<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 * @author Anthony Okechukwu
 */

namespace boffins_vendor\classes;

use Yii;
use yii\base\{ModelEvent, ActionEvent};
use yii\base\Component;
use yii\db\ActiveRecord;
use frontend\models\{ActivityObjectClass, Subscription};
use boffins_vendor\classes\Tree\{Node};

/***
 * @brief
 * This component listens to action and model events to determine the activities that
 * occur within a request.
 * @details
 * This works automatically, generating messages corresponding to activities within a single action
 * [ONE ACTIVITYMANAGER TRACKS ONE REQUEST AND THUS ONE ACTION]
 * The activity messages are dispatched through redis and can be read from each client from the redis server.
 * 
 * @future
 * Extend this by using the redis stream log data structure. This data structure is best suited for the goal of Activity Manager 
 * however, it was discovered late in the development process of Activity Stream (the project name that generated ActiviytManager).
 * With redis streams however, much greater efficiencies are possible and more advanced uses are possible.
 * https://redis.io/topics/streams-intro
 */
class ActivityManager extends Component 
{
	/**
	 * Serie of activity message nodes/trees that indicate all the activities that occur in a given ActivityManager/Request.
	 * Each series represents a tree (or node).
	 */
	protected $activitySeries = null;
	
	/**
	 * tracks the current active node in the series. You should only act on the current activity node when generating a message
	 * but you manage the activity series by keeping track of your current node and switching to a new node when you actually need 
	 * one.
	 */
	protected $currentActivityNode = null;
	
	/**
	 * tracks the objects you have treated so that you are not adding the same object in the same tree doing the same thing. 
	 * an object may have duplicates in the activity tree but only if it is transformed i.e. it occurs in a different DB activity such 
	 * as find and update. 
	 */
	protected $discoveredObjects = [];
	
	/**
	 * Keeps a set of activity objects that activity manager watches/listens to. Outside of this list (which is populated upon init)
	 * other objects are ignored. In order for an object to be listened to, it needs to suscribe. 
	 */
	protected $_activityObjectClasses = [];
	
	/**
	 * what is this?
	 */
	protected $_subscriptions = [];
	
	/**
     * the controller that initiates the source action Controller|\yii\web\Controller|\yii\console\Controller 
	 */
	protected $sourceControllerID;
	
	/**
	 * the action that commences the activity. 
	 */
	protected $sourceActionID;
	
	/***
	 * the user who makes the request that initiates the activities. This variable is expected to be a simple string.
	 * Note that each activity manager manages only one request so only ever has one actor. That said,
	 * this variable is public so that, through the process of request, it can be intercepted and potentially restyled. 
	 */
	public $actor;

	/***
	 * simple boolean tracker to determine if activity manager should terminate all observation of the action.
	 * if true. Observation is terminated. 
	 */
	protected $terminate = false;

	/***
	 * Cool off period during which similar actions will be ignored. This is to prevent manager from tracking similar actions within 
	 * the cool off period.
	 */
	public $coolOff = 5;

	/***
	 * an array to emulate a stack. This array should not be handled directly but on through prodided functions 
	 * addToStack() - add an item to the top of the stack
	 * removeFromStack() - removes the top item from stack
	 * topStackItem() - returns the top stack item
	 * @future convert stack into a class.
	 */
	private $_stack = null;

	/**
	 * indicate whether the stack is NEW or being USED in a new stack cycle.
	 */
	private $_stackState = 0;

	/***
	 * this indicates that the stack iS new. The stack is considered NEW at the point when it is first populated. It continuues to be 
	 * considered new as long as it is not emptied even if more items are added to the stack and items are removed, it remains new. 
	 * It only becomes USED when after populting it, you then empty it.
	 */
	const STACK_IS_NEW = 1;

	/***
	 * this indicates that the stack iS USED. The stack is considered USED when it has been populated then emptied
	 * so that it is available for a new cycle of populating and removing items.  
	 */
	const STACK_IS_USED = -1;

	/***
	 * each redis key should begin with a prefix which indicates which module is using redis for that key. This is to prevent clashing
	 * keys within the application space.
	 */
	const REDIS_NAMESPACE_PREFIX	= "AM"; //activity manager.

	/** 
	 * an array of intercepts to run before generating activity message(s)
	 */
	public $intercepts = [];

	/**
	 * @brief {@inheritdoc}
	 * 
	 * @details basic initialisations and start listening to controller actions 
	 * (only those that are relevant to the activity manager)
	 * 
	 * @future delete the controller_name column in ActivityObjectClass as it is no longer useful.
	 */
	public function init()
	{
		Yii::warning("Initialising Activity Manager", __METHOD__);
		parent::init();
		$this->currentActivityNode = $this->activitySeries[0] = new ActivityMessageNode; //first, primary tree.
		$trackedControllers = \frontend\models\ActivityAction::find()
																->select(['id', 'controller_name'])
																->groupBy('controller_name')
																->all();

		foreach ($trackedControllers as $trackedController) {
			$controller = $trackedController->controller_name;
			ActionEvent::on($controller, BoffinsBaseController::EVENT_BEFORE_ACTION, [$this, 'handleBeforeAction']);
			ActionEvent::on($controller, BoffinsBaseController::EVENT_AFTER_ACTION, [$this, 'handleAfterAction']);
		}
	}
	
	/**
	 * @brief 
	 * 
	 * @param [in] $event The event object triggered by the controller
	 * @return void
	 * 
	 * @details More details
	 */
	public function handleBeforeAction($event)
	{
		$this->sourceControllerID = $event->sender->id;
		$this->sourceActionID = $event->action->id;
		$sessID = Yii::$app->session->id;
		$key = self::REDIS_NAMESPACE_PREFIX . ":session:$sessID:{$this->sourceControllerID}/{$this->sourceActionID}";
		$escapedStr = $event->sender->className();
		//Yii::warning("$key", __METHOD__);

		$trackedActions = \frontend\models\ActivityAction::find()
										->where([
											'controller_name' => $escapedStr,
											'action' => $this->sourceActionID,
										])
										->count();

		//var_dump($key);
		if ( $trackedActions < 1 ) {
			Yii::warning("Activity Manager does not track this action. Terminating shortly", __METHOD__);
			$this->terminate = true; //this action is not being tracked by activity streem. 
			return;
		}
		
		$redis = Yii::$app->redis;
		if ( $redis->exists($key) ) {
			Yii::warning("This action has been run within the last {$this->coolOff} seconds. Terminating duplicate", __METHOD__);
			$this->terminate = true; //this action has been run before within this instance. This is to counter a potential bug.
			return;
		}

		$redis->setex($key, $this->coolOff, 1); //SETEX key expire_in_seconds string_value NOTE: cooloff period can be set from config

		Yii::warning('Activity Manager is now tracking events on ' . $this->sourceControllerID . ' through ' . $this->sourceActionID, __METHOD__);

		foreach ($this->getActivityObjectClasses() as $activityObjectClass) {
			//attach event handlers for COMPLETED_ACTIVITY and BEGIN_ACTIVITY which are special Activity events 
			//triggered by a BARRM instance when it conducts an activity which it wants Activity Manager to track.
			//these are class level event handlers so they will listen to the events of all
			//instances of the class that are created within this action.
			//@future - make this so that some instances do not trigger the activty manager.
			$ARModelClass = $activityObjectClass->class_name;
			Yii::info("Creating listeners on specfic events for $ARModelClass", __METHOD__);
			
			ActivityEvent::on($ARModelClass, BoffinsArRootModel::COMPLETED_ACTIVITY, [$this, 'handleCompletedActivity']);
			ActivityEvent::on($ARModelClass, BoffinsArRootModel::BEGIN_ACTIVITY, [$this, 'handleBeginActivity']);
		}
	}
	
	/**
	 * @brief
	 * 
	 * @details
	 */
	public function handleBeginActivity($event)
	{
		//do some house keeping to make sure that this event was triggered correctly
		if (! $event instanceof ActivityEvent) {
			throw new yii\base\InvalidCallException("Activity Manager only works with instances or child classes of ActivityEvent!");
		}

		if ($event->eventPhase != ActivityEvent::ACTIVITY_EVENT_PHASE_BEFORE) {
			throw new yii\base\InvalidCallException("This event should have a phase {ActivityEvent::ACTIVITY_EVENT_PHASE_BEFORE}");
		}

		if ( ! isset($event->additionalParams['shortClass']) ) {
			throw new yii\base\InvalidCallException("This event must provide shortClass details of the BARRM");
		}


		static $emptyObjectCount = 0;
		$activityObject = $event->sender;
		$objectClass = $event->additionalParams['shortClass'];
		$id = empty($activityObject) ? 'e:' . ++$emptyObjectCount : $activityObject->id;
		$modelActivity = $event->modelAction;
		$key = "{$objectClass}:{$modelActivity}:{$id}";
		//var_dump($id);
		
		Yii::info("Starting an new activity with the following key: $key", __METHOD__);

		if ( array_key_exists($key, $this->discoveredObjects) ) {
			Yii::warning("This is totally unexpected. I have alread found this activity???", __METHOD__);
			return;
		}

		if ( empty($activityObject)	&& empty($event->additionalParams['modelClass']) ) {
			Yii::warning("This could cause a serious error. When generating an event, you must critically provide a sender object and/or provide a modelClass to the event->additionalParams array ", __METHOD__);
			return;
		}

		switch ($modelActivity) {
			case BoffinsArRootModel::MODEL_ACTIVITY_FIND : 
				$this->handleBeforeFind($event);
				break;
			case BoffinsArRootModel::MODEL_ACTIVITY_INSERT : 
				$this->handleBeforeInsert($event);
				break;
			case BoffinsArRootModel::MODEL_ACTIVITY_UPDATE : 
				$this->handleBeforeUpdate($event);
				break;
			case BoffinsArRootModel::MODEL_ACTIVITY_SOFT_DELETE : 
				$this->handleBeforeSoftDelete($event);
				break;
			//have not treated delete proper. 
			default: 
				Yii::warning("Handling other type of activity event", __METHOD__);
				$this->handleCustomBeforeEvents($event);
				break;
	}
	}

	/**
	 * @brief 
	 *  
	 * @param [ModelEvent] $event The event object triggered by ActiveRecord
	 * @return void
	 *  
	 * @details More details
	 */
	protected function handleBeforeFind($event) 
	{
		$activityObject = $event->sender;
		$aoClass = $event->additionalParams['shortClass'];

		switch ( $this->sourceActionID ) {
			case 'index' :
				//in an index, simply provide a list of activity objects
				if ( $this->classMatchesController($aoClass) ) {
					//Yii::warning("Using a child node as current");
					$childNode = new ActivityMessageNode;
					$this->currentActivityNode->addChildNode($childNode);
					$this->currentActivityNode = $childNode;
				}
				break;

			case 'view' :
				if ( !$this->stackIsEmpty() ) {
					//Yii::warning("Creating a child node");
					//attachh a child node to the tree. 
					$childNode = new ActivityMessageNode;
					$this->currentActivityNode->addChildNode($childNode);
					$this->currentActivityNode = $childNode;
				}

				if ( $this->_stackState === SELF::STACK_IS_USED && $this->stackIsEmpty() ) {
					//Yii::warning("Starting a new series");
					//start a new seriess
					$newNode = $this->getNewSeriesNode();
					$this->currentActivityNode = $newNode;
				}

				if ( $this->_stackState === SELF::STACK_IS_NEW && $this->stackIsEmpty() ) {
					//Yii::warning("Doing nothing. At the head. ");

					//do nothing here.
					//in a view, if there is nothing in a brand new stack then do nothing - (just add to to the stack)
					//at this point, the currentActivityNode is already set at the very head of the tree so there is no work to do.
					//if the stack is not empty, go down one child (i.e. first if block above.)
					//however, at the beginning of each new stack cycle, you add a new series (as if building a forest) 
					//and set the currentActivityNode to the head of the new series (i.e. the second if block above)
					//providing this if bloc only to improve code readability.
					//PS: each series is like a tree in a forest.
				}
				break;

			default:
				//do nothing.
				//@future. This is an opportunity to deal with finds in update/create/delete actions.
		}
		Yii::warning("Adding an item to the stack: {$aoClass}:beforeFind");
		$this->addToStack("{$aoClass}:beforeFind");
		//var_dump($this->_stack); //die();
	}

	/**
	 * @brief 
	 *  
	 * @param [ModelEvent] $event The event object triggered by ActiveRecord
	 * @return void
	 *  
	 * @details More details
	 */
	protected function handleBeforeInsert($activityObject)
	{
		//$activityObject = $event->sender;
		//$aoClass = $event->additionalParams['shortClass'];
		//var_dump($activityObject);
		//nothing here really 
	}

	/**
	 * @brief 
	 *  
	 * @param [ModelEvent] $event The event object triggered by ActiveRecord
	 * @return void
	 *  
	 * @details More details
	 */
	protected function handleBeforeUpdate($activityObject)
	{
		//nothing here yet
	}

	/**
	 * @brief 
	 *  
	 * @param [ModelEvent] $event The event object triggered by ActiveRecord
	 * @return void
	 *  
	 * @details More details
	 */
	protected function handleBeforeSoftDelete($activityObject)
	{
		//nothing here yet
	}

	protected function handleCustomBeforeEvents($event)
	{

	}

	/**
	 *  @brief One handler for the one Completed Activity Event. 
	 *  This initiates another handdler depending on the parameters passed by the ActivityEvent object. 
	 *  
	 *  @param [ActivityEvent] $event The parameters of the activity which Activity Manager will now track. 
	 *  @return void
	 */
	public function handleCompletedActivity($event)
	{
		//conduct some housekeeping and then hand over to proper handlers 
		if (! $event instanceof ActivityEvent) {
			throw new yii\base\InvalidCallException("Activity Manager only works with instances or child classes of ActivityEvent!");
		}

		if ($event->eventPhase != ActivityEvent::ACTIVITY_EVENT_PHASE_AFTER) {
			throw new yii\base\InvalidCallException("This event should be of phase {ActivityEvent::ACTIVITY_EVENT_PHASE_AFTER}");
		}

		//Yii::warning("Running this a second time! Or first??? {$event->modelAction} ", __METHOD__);
		$activityObject = $event->sender;
		$objectClass = $activityObject->shortClassName();
		$id = $activityObject->id;
		$modelActivity = $event->modelAction;
		$key = "{$objectClass}:{$modelActivity}:{$id}";
		
		if ( array_key_exists($key, $this->discoveredObjects) ) {
			Yii::warning("This object has already been handled.", __METHOD__);
			return;
		}
		
		$this->discoveredObjects["{$objectClass}:{$modelActivity}:{$id}"] = $id;
		
		switch ($modelActivity) {
			case BoffinsArRootModel::MODEL_ACTIVITY_FIND :
				$this->handleAfterFind($event);
				break;
			case BoffinsArRootModel::MODEL_ACTIVITY_INSERT :
				$this->handleAfterInsert($event);
				break;
			case BoffinsArRootModel::MODEL_ACTIVITY_UPDATE :
				$this->handleAfterUpdate($event);
				break;
			case BoffinsArRootModel::MODEL_ACTIVITY_SOFT_DELETE :
				$this->handleAfterSoftDelete($event);
				break;
			//have not treated delete proper. 
			default: 
				Yii::warning("Handling other type of activity event", __METHOD__);
				$this->handleCustomAfterEvents($event);
				break;
		}
	}

	/**
	 * @brief 
	 *
	 * @param [ModelEvent] $event The event object triggered by ActiveRecord
	 * @return void
	 *
	 * @details More details
	 */
	protected function handleAfterFind($event)
	{
		$activityObject = $event->sender;
		$aoClass = $activityObject->shortClassName();
		//var_dump($this->_stack);
		if ( $this->sourceActionID == 'index' ) {
			Yii::trace("Applying afterFind INDEX rule for this class: $aoClass");
			if ( ! $this->classMatchesController($aoClass) ) {
				//in a index, only the controller related objects are treated. 
				Yii::warning("This controller does not match this object. In index, it is ignored and top stack item removed.");
				//Yii::warning("Removing an item from the stack - {$this->topStackItem()} - at point:  1");
				$this->removeFromStack();
				return;
			}
		}
		
		Yii::warning("Will test the class: $aoClass with id {$activityObject->id} agains the stack item: [{$this->topStackItem()}]");
		if ( $this->topStackItem() != "{$aoClass}:beforeFind" ) {
			//this scenario could occur when you conduct a find on another BARRM which results in NO active records. 
			//In which case, there will be no afterFind but a beforeFind will be trigggered. 
			//Therefore, remove the offending stack item and return in the hopes that the next stack item's 
			//related event will be triggered
			//@future - the scenario could occur in which a completed activity (afterFind) is triggered wthout 
			//it's begin activity ever being triggered. This would mess up the stack completely. Guard against this. 
			Yii::warning("Removing an item from the stack - {$this->topStackItem()} - at point: 2");
			$this->removeFromStack();
			return;
		}

		if ( $this->sourceActionID != 'index' ) {
			if ( $this->topStackItem() == "{$aoClass}:beforeFind" ) {
				Yii::warning("Removing an item from the stack - {$this->topStackItem()} - at point: 3");
				$this->removeFromStack();
			}
		}

		Yii::warning("Passed all tests. Now generating a message.");

		$defaultConstructs = [
			'verb'=> Yii::t("activity_manager", "afterFind_verb"),
			'article' => Yii::t("activity_manager", "afterFind_article"),
			'object' => Yii::t("activity_manager", $aoClass) . ' - ' . $activityObject->getPublicTitleofBARRM(),
		];

		$modelConstructs = isset($event->additionalParams['modelConstructs']) ? $event->additionalParams['modelConstructs'] : [] ;
		$correctConstructs = array_merge($defaultConstructs, $modelConstructs);
		$tes = $this->addActivityToTree2($activityObject, $correctConstructs);

		//Yii::warning($tes->resolve(), implode(",", $modelConstructs) );
		//Yii::warning($tes->resolve(), implode(",", array_keys($correctConstructs) ) );


		if ( $this->currentActivityNode->isChild() ) {
			$this->currentActivityNode = $this->currentActivityNode->parent;
		}
		//Yii::warning("$objectName " . $activityObject->id . ' is found', 'Actvity Manager');

		if ( $this->stackIsEmpty() && $this->sourceActionID == 'index' ) {
			$topRoot = reset($this->activitySeries);
			//add objecte details and message to this root. 
		}
	}
	
	/**
	 *  @brief 
	 *
	 *  @param [ModelEvent] $event The event object triggered by ActiveRecord
	 *  @return void
	 *
	 *  @details More details
	 */
	protected function handleAfterInsert($event)
	{
		$activityObject = $event->sender;
		$aoClass = lcfirst($activityObject->shortClassName());
		$defaultConstructs = [
			'verb'=> Yii::t("activity_manager", "afterInsert_verb"),
			'article' => Yii::t("activity_manager", "afterInsert_article"),
			'object' => Yii::t("activity_manager", lcfirst($aoClass)) . ' - ' . $activityObject->getPublicTitleofBARRM(),
		];

		$modelConstructs = isset($event->additionalParams['modelConstructs']) ? $event->additionalParams['modelConstructs'] : [] ;
		$correctConstructs = array_merge($defaultConstructs, $modelConstructs);
		
		if ( $activityObject->hasMethod('shortClassName') ) {
			$objectName = $activityObject->shortClassName();
			$this->addActivityToTree2($activityObject, $correctConstructs);
		}
		//Yii::warning("$objectName " . $activityObject->id . ' is found', 'Actvity Manager');
	}
	
	/**
	 *  @brief 
	 *  
	 *  @param [ModelEvent] $event The event object triggered by ActiveRecord
	 *  @return void
	 *  
	 *  @details More details
	 */
	protected function handleAfterUpdate($event) 
	{
		$activityObject = $event->sender;
		$aoClass = lcfirst($activityObject->shortClassName());
		$defaultConstructs = [
			'verb'=> Yii::t("activity_manager", "afterUpdate_verb"),
			'article' => Yii::t("activity_manager", "afterUpdate_article"),
			'object' => Yii::t("activity_manager", $aoClass) . ' - ' . $activityObject->getPublicTitleofBARRM(),
		];

		$modelConstructs = isset($event->additionalParams['modelConstructs']) ? $event->additionalParams['modelConstructs'] : [] ;
		$correctConstructs = array_merge($defaultConstructs, $modelConstructs);
		
		if ( $activityObject->hasMethod('shortClassName') ) {
			$objectName = lcfirst($activityObject->shortClassName());
			$this->addActivityToTree2($activityObject, [
				'verb' => 'updated',
				'article' => 'the',
				'object' => $objectName . ': ' . $activityObject->getPublicTitleofBARRM(),
			]);
		}
		//Yii::warning(\yii\helpers\VarDumper::dumpAsString($activityObject->clipOwnerType), "BARRM"); 
		//Yii::warning("$objectName " . $activityObject->id . ' is found', 'Actvity Manager');
	}
	
	/**
	 *  @brief 
	 *  
	 *  @param [ModelEvent] $event The event object triggered by ActiveRecord
	 *  @return void
	 *  
	 *  @details More details
	 */
	protected function handleAfterSoftDelete($event) 
	{
		$activityObject = $event->sender;
		$aoClass = $activityObject->shortClassName();

		$defaultConstructs = [
			'verb'=> Yii::t("activity_manager", "afterUpdate_verb"),
			'article' => Yii::t("activity_manager", "afterUpdate_article"),
			'object' => Yii::t("activity_manager", $aoClass) . ' - ' . $activityObject->getPublicTitleofBARRM(),
		];

		$modelConstructs = isset($event->additionalParams['modelConstructs']) ? $event->additionalParams['modelConstructs'] : [] ;
		$correctConstructs = array_merge($defaultConstructs, $modelConstructs);

		if ( $activityObject->hasMethod('shortClassName') ) {
			
			$objectName = lcfirst($activityObject->shortClassName());
			$this->addActivityToTree2($activityObject, [
				'verb' => 'deleted',
				'article' => 'the',
				'object' => $objectName . ': ' . $activityObject->getPublicTitleofBARRM(),
			]);

		}
		//Yii::warning("$objectName " . $activityObject->id . ' is found', 'Actvity Manager');
	}

	public function handleCustomAfterEvents($event)
	{
		Yii::warning("Running Custom", "EVENTS");
		if ( ! $event->eventPhase != ActivityEvent::ACTIVITY_EVENT_PHASE_AFTER ) {
			throw new yii\base\InvalidCallException("The phase of this event does not match it's handler!");

		}

		if ( ! isset($event->additionalParams['modelConstructs']) ) {
			throw new yii\base\InvalidCallException("Custom Activity Events must provide message constructs");
		}

		$activityObject = $event->sender;
		$aoClass = $activityObject->shortClassName();
		$modelConstructs = $event->additionalParams['modelConstructs'];
		$this->addActivityToTree2($activityObject, $modelConstructs);
	}
	
	/***
	 *  @brief 
	 *  
	 *  @param [in] $event The event object triggered by the controller
	 *  @return void
	 *  
	 *  @details More details
	 */
	static $functionCount;

	public function handleAfterAction($event)
	{
		if ( $this->terminate ) { //I've been instructed to terminate activity manager observations.
			Yii::warning("I've been instructed to terminate", __METHOD__);
			return;
		}

		if ( empty(Yii::$app->user->identity) ) {
			Yii::warning("User component is empty or user identity is not set. Stopping", __METHOD__);
			return; // there is no user, Activity Manager currently will not work with console requests or before a user identity is set. 20/04/19 WHY???
		}

		//$subscriberUserID = $user_id = Yii::$app->user->identity->id;
		//Yii::Warning(\yii\helpers\VarDumper::dumpAsString($this->activitySeries), "SERIES HERE");
		$activitySeriesTip = reset($this->activitySeries); //the very first node. Root of the first series.		
		if ( $activitySeriesTip->isEmpty() ) {
			Yii::warning("No activity nodes generated. Stopping", __METHOD__);
			return;
		}

		if (Yii::$app->has('user') && !empty(Yii::$app->user->identity) && Yii::$app->user->identity instanceof BoffinsArRootModel ) {
			$actor = Yii::$app->user->identity->getPublicTitleofBARRM();
		} else {
			$actor = 'The System';
		}

		$activitySeriesTip->prependFormat('actor');
		$activitySeriesTip->addConstruct('actor', $actor);

		//$redis = Yii::$app->redis;
		$sessID = Yii::$app->session->id;
		$key = self::REDIS_NAMESPACE_PREFIX . ":session:$sessID:{$this->sourceControllerID}/{$this->sourceActionID}";
		//$msg = "Runing to die";

		

		//$objectClassID = ActivityObjectClass::findOne(['class_name' => $this->activityTree->activityDetails['object_class'] ])->id;
		/*if ( $activitySeriesTip->isEmpty() ) {
			Yii::warning("Tip is empty", 'SERIES HERE');
			return;
		}*/
		$userSubscriptions = Subscription::find()
								->joinWith('activityObjectClass aoc')
								->andWhere( ['aoc.class_name' => $activitySeriesTip->activityDetails['object_class'] ])
								->andWhere( ['{{%subscription}}.object_id' => $activitySeriesTip->activityDetails['object_id'] ])
								->andWhere( ['{{%subscription}}.action_id' => $this->sourceActionID])
								->all();

		//Yii::Warning(\yii\helpers\VarDumper::dumpAsString($userSubscriptions), "SUBS HERE2");
		
		if ( empty($userSubscriptions) ) {
			Yii::error("No subscriptions, we still have a problem here.", __METHOD__);
			$subscriberUserID = Yii::$app->user->identity->id;
		} else {
			foreach ( $userSubscriptions as $subscriber ) {
				$subscriberUserID[] = $subscriber->user_id;
			}
			//$subscriberUserID = $userSubscriptions->user_id;
		}
		$this->dispatchMessages($activitySeriesTip, $subscriberUserID);
		//Yii::warning("The number of subscriptions are " . count($userSubscriptions), __METHOD__ );
		
		//Yii::warning($this->activityTree->resolve(), __METHOD__);
		Yii::warning("One increase", __METHOD__);
		Yii::warning('Activity Manager has now finished tracking events on ' . $event->sender->id, __METHOD__); //sender is FolderController
		Yii::trace('Activity Manager has now finished tracking events on ' . $event->sender->id, __METHOD__); //sender is FolderController
	}

	/***
     * Added by Emeka
     * @brief Publishes push notifications to redis and allows node.js listen for those notification
	 * 
	 * @param [ActivityMessageNode] $node (resolve)
	 * @param [int] $userIDs - the id(s) 0f the users who have subscribed to the given activity.
	 * @return void
	 * 
	 * @details also provides meta data for the message.
	 */
	public function publishNotifications ($userIDs, $node)
	{
		$redis = Yii::$app->redis;
		$notification = (object)[]; 
		$notification->subscribers = $userIDs; 
		$notification->message = $node;
		$notification->actor_id = Yii::$app->user->identity->id;
		$redis->publish( "notification", json_encode($notification));
	}

	/***
	 * @brief dispatches messages to a specific node.
	 * 
	 * @param [ActivityMessageNode] $node
	 * @param [int] $userIDs - the id(s) 0f the users who have subscribed to the given activity.
	 * @param [bool] $resolveAll - defaults to false. If set to true, this will loop through the node to resolve child messages. 
	 * @return void
	 * 
	 * @details also provides meta data for the message.
	 */
	
	public function dispatchMessages($node, $userIDs, $resolveAll = false)
	{
		$redis = Yii::$app->redis;

		do {
			$messageKey = (new \yii\base\Security)->generateRandomString(16);
			//@future if keys start clashig, increment the random string length in the loop each time this loop is run again. 
		} while ($redis->exists($messageKey));
		Yii::warning($messageKey, "THE KEY");

		
		if ( ! is_array($userIDs) ) {
			$userIDs = [$userIDs];
		}

		$userIDs = array_unique($userIDs); //filter array to ensure a user never gets the same messsage twice.  
		$userIDs = array_values($userIDs); // get array key values 
		foreach( $userIDs as $userID ) {
			$redis->lpush( "user_message:$userID", $messageKey );
			$redis->hset( $messageKey, "meta_message", $node->resolve() );
			$redis->hset( $messageKey, "meta_actor_id", Yii::$app->user->identity->id );
			$redis->hset( $messageKey ,"meta_date", time() );
			$profileImage = Yii::$app->user->identity->profile_image ? Yii::$app->user->identity->profile_image : 'no image';
			$redis->hset( $messageKey, "meta_actor_image", $profileImage );
		}

		$this->publishNotifications($userIDs, $node->resolve());
	}

	/***
	 * @brief getter for private $_activityObjectClasses
	 *
	 * @return $_activityObjectClasses
	 */
	public function getActivityObjectClasses()
	{
		if ( empty($this->_activityObjectClasses) ) {
			$this->_activityObjectClasses = ActivityObjectClass::find()->all(); //with this initialisation, it means there can be no change reflected for the duration of a single request.
		}
		return $this->_activityObjectClasses;
	}
	
	/***
	 * @brief fetch activity object classes
	 * this is only useful if there is any need, within a request to update the ActivityObject Classes.
	 * this function is pretty redundant otherwise.
	 *
	 * @return $_activityObjectClasses
	 */
	public function fetchActivityObjectClasses()
	{
		$this->_activityObjectClasses = ActivityObjectClass::find()->all();
		return $this->_activityObjectClasses;
	}
	
	/***
	 * @brief a function that any BARRM can run to subscribe itself to activity stream.
	 *  
	 * @param [BoffinsArRootModel] $object the object that wants to be subscribed.
	 * @params [array] $actions the actions for which this object should be subscribed.
	 * @param [mixed] a user id or array of user ids of users to subscribe an object to.
	 * @return void
	 *  
	 * @details You can call this function simply as follows from any BARRM (only models saved in the DB can subscribe)
	 * FROM within any model write:
	 * Yii::$app->activityManager->subscribe($this); or Yii::$app->activityManager->subscribe($this, ['view']);
	 * In the first example, activity manager will subscribe the BoffinsArRootModel object instance ($this)
	 * In the second example, activity manager will subscribe the BoffinsArRootModel instance to listen to the view action only of that object
	 * @future register new BARRM classes which are not in ActivityObjectClasses set by creating a new instance of
	 * ActivityObjectClasses and saving to the DB. This way when someone subscribes a new instance of BARRM and Activity Manager 
	 * will now begin to listen for it. 
	 * Provide a user id or an array of user ids for each usser you want to subscribe $object activities.
	 * If $user is null, then the current user will be subscribed. If there is no user, an error will be triggered.
	 */
	public function subscribe($object, $user = null, $actions = ['view', 'update', 'delete'])
	{
		if (! $object instanceof BoffinsArRootModel ) {
			Yii::warning("Can only register objects of class BoffinsArRootModel or child.", __METHOD__);
			throw new yii\base\InvalidCallException("Parameter object does not match requirements. Provide a BARRN instance");
		}
		
		if (! is_array($actions) ) {
			Yii::warning("Registration process cannot proceed. I need an array of actions.", __METHOD__);
			throw new yii\base\InvalidCallException("Parameter 'actions' does not match requirements. Provide an array of strings");
		}

		if ( empty($object->id) ) {
			Yii::error("Hmn. Can't subscribe this object. There is no id!", __METHOD__);
			throw new yii\base\InvalidCallException("Parameter object does not match requirements. Provide a BARRN instance with an id attribute!");
		}
		

		if ( $user === null && empty(Yii::$app->user->identity) ) {
			Yii::error("Hmn. Can't subscribe this object. There is no user!", __METHOD__);
			throw new yii\base\InvalidCallException("I cannot subscribe this object if I have no user to subscribe for");
		}

		$objectClass = ActivityObjectClass::findOne(['class_name' => $object->className()]);
		if ( empty($objectClass) ) {
			Yii::error("Hmn. Can't subscribe this object. There is no registerd objectClass!", __METHOD__); //or you include this one. 
		}

		if ( $user !== null ) {
			if ( is_string($user) || is_integer($user) ) {
				$this->subscribeInternal($object, $objectClass, $actions, $user);
			}

			if ( is_array($user) ) {
				foreach( $user as $singleUser ) {
					$this->subscribeInternal($object, $objectClass, $actions, $singleUser);
				}
			}
		}
		
		
	}

	/***
	 * @brief internal function that actually creates a subscription for each user on each action. 
	 * @param [BoffinsArRootModel] $object the object that the subscripton is for.
	 * @params [ActivityObjectClass] $objectClass the ActivityObjectClass that indicates the class of activity object [BARRM]. 
	 * @params [array] $actions the actions for which this object should be subscribed.
	 * @param [mixed] a user id or array of user ids of users to subscribe an object to.
	 */
	protected function subscribeInternal($object, $objectClass, $actions, $user_id)
	{
		$security = new \yii\base\Security;
		foreach ( $actions as $action ) {
			$subscription = new Subscription;
			$subscription->id = $security->generateRandomString(64);
			$subscription->user_id = $user_id;
			$subscription->object_id = $object->id;
			$subscription->object_class_id =  $objectClass->id;
			$subscription->action_id = $action;
			$subscription->save();
		}
	}

	protected function addActivityToTree2($activityObject, $messageConstructs)
	{
		$this->assignActivityDetails($this->currentActivityNode, $activityObject);
		$this->addActivityMessage($messageConstructs, $this->currentActivityNode);
		return $this->currentActivityNode;
	}

	
	/**
	 * @brief simple function to create an activity message node upon the completion of each activity.
	 *
	 * @param [$activityObject] an object of an activity. 
	 * @param [arr] $messageConstructs an array of constructs to the activity message node 
	 * @return [ActivityMessageNode]
	 */
	protected function addActivityToTree($activityObject, $messageConstructs)
	{
		$sourceModelName = strtolower($activityObject->shortClassName());
		
		//Yii::warning("Model and Controller: {$sourceModelName} and {$this->sourceControllerID}", __METHOD__);
		
		$newNode = new ActivityMessageNode;
		$this->assignActivityDetails($newNode, $activityObject);
		if ( $sourceModelName == $this->sourceControllerID ) {
			switch ($this->sourceActionID) {
				case 'index':
					//in a list. Just list all items
					//$this->assignActivityDetails($this->currentActivityNode, $activityObject);
					$this->addActivityMessage($messageConstructs, $this->currentActivityNode);
					break;
				case 'view':
					//check url if it's the same one, then
					if ( $this->objectIsTarget($activityObject) ) {
						$this->assignActivityDetails($this->currentActivityNode, $activityObject);
						Yii::warning("Object is self!", __METHOD__);
					} else {
						Yii::warning("Object is child", __METHOD__);
					} 
					$this->addActivityMessage($messageConstructs, $this->currentActivityNode);
					//Yii::warning("Object is target " . $this->objectIsTarget($event->sender), __METHOD__);
					break;
				case 'create':
				$this->assignActivityDetails($newNode, $activityObject);
				$this->currentActivityNode = $this->addActivityMessage($messageConstructs, $this->activityTree);
					break;
				case 'update':
					$this->assignActivityDetails($newNode, $activityObject);
					$this->currentActivityNode = $this->addActivityMessage($messageConstructs, $this->activityTree);
					break;
				case 'delete':
					break;
				default: 
					Yii::warning("This action id is not recognized.", __METHOD__);
					$this->currentActivityNode->addChildNode( $this->addActivityMessage($messageConstructs) );
			}
			//$this->addActivityMessage($messageConstructs, $this->activityTree);
		} else {
		//this means it lies within a container or is an object unrelated to the action or an activity consequent to the action,
		//but not the real activity intended by the user - for instance deleting a folder and deleting the tasks within the folder.
			$this->currentActivityNode->addChildNode( $this->addActivityMessage($messageConstructs) );
		}
		
		//return $this->activityTree;
	}
	
	/**
	 * @brief simple function to create an activity message node upon the completion of each activity.
	 *
	 * @param [array] $constructs an array of constructs to the activity message node
	 * @param [NodeInterface] $node an ActivityMessageNode
	 * @param [string] $msgFormat a string indicating the format
	 * @return [ActivityMessageNode]
	 */
	protected function addActivityMessage($constructs, &$node = null, $msgFormat = null)
	{
		if ( $node === null ) {
			$node = new ActivityMessageNode;
		} elseif ( !$node instanceof ActivityMessageNode ) {
			throw new yii\base\InvalidArgumentException("You must provide a node instance of ActivityMessageNode." . __METHOD__ );
		}
		
		foreach ( $constructs as $construct => $value ) {
			$node->addConstruct($construct, $value);
		}

		if ( $msgFormat !== null ) {
			$node->format = $msgFormat; 
		}
				
		Yii::warning($node->resolve(), __METHOD__);
		return $node;
	}
	
	/**
	 *  @brief tests if the object provded is the target of this request i.e it's id is provided in the request body or get query params.
	 *  
	 *  @param [BoffinsArRootModel i.e. BARRM] $object the object to test against. Tests this object to see if it is the target of a request
	 *  @param [str] $action the action id of the request. Right now, this only works for view actions.
	 *  @return bool
	 *  
	 *  @details This is a very specific and targeted comparison. It cannot work in many many situations. Please use this carefully 
	 *  as it will return false or even throw an exception in situations where this activity is not conducted over a standard request 
	 *  or an id is nor provided (if for instance the view is pulled using some other primary key) or if this activity is not conducted 
	 *  over a view action. The object provided must also be a BARRM i.e. BoffinsArRootModel. It won't work with anything else. 
	 */
	protected function objectIsTarget($object, $action = 'view')
	{
		if ( ! $object instanceof BoffinsArRootModel ) {
			Yii::warning("Don't recognise this object, can't make a guess. Returning false.", __METHOD__);
			return false;
		} 
		
		if ( $action != 'view' ) {
			throw new yii\base\InvalidCallException("Not yet implemented this for any action but view");
		}
		
		if ( ! $object->hasAttribute('id') ) {
			throw new yii\base\InvalidCallException(__METHOD__ . " Currently only works with objects (BARRMs) with an id.");
		}
		
		if ( ! Yii::$app->has('request') ) {
			Yii::warning(__METHOD__ . " Currently only works within a standard request.", __METHOD__);
			return false;
		}
		
		if ( empty(Yii::$app->request->queryParams['id']) && empty(Yii::$app->request->bodyParams['id']) ) {
			Yii::warning(__METHOD__ . " Currently only works when a request provides an id within its body or query.", __METHOD__);
			return false;
		}
		
		$request = Yii::$app->request;
		$requestParams = $request->isGet ? Yii::$app->request->queryParams : Yii::$app->request->bodyParams;
		
		return $requestParams['id'] == $object->id; //YAY! Finally we can perform the test. Lol
	}

	/***
	 * @brief simple function to assign 
	 */
	protected function assignActivityDetails($node, $activityObject )
	{
		$node->activityDetails['object_id'] = $activityObject->id;
		$node->activityDetails['object_class'] = $activityObject->className();
	}

	/***
	 * @brief a function to check if a given activity object class matches the current controller which ActivityManager is observing
	 * @param $class the clas you want to test against.
	 * @return boolean - true is the given short class name matches the contoller
	 */
	protected function classMatchesController($class)
	{
		Yii::warning("$class : {$this->sourceControllerID}");
		return strtolower($class) == strtolower($this->sourceControllerID);
	}

	/***
	 * @brief adds an item to the stack 
	 *
	 * @param [mixed] $item 
	 */
	protected function addToStack($item)
	{
		if ( $this->_stack === null ) {
			$this->_stack = [];
			$this->_stack[] = $item;
			$this->_stackState = SELF::STACK_IS_NEW;
			return;
		}

		array_push($this->_stack, $item);
	}

	/***
	 * @brief removes an item from the stack.
	 *
	 * @return mixed
	 */
	protected function removeFromStack()
	{
		array_pop($this->_stack);
		if ( empty($this->_stack) ) {
			$this->_stackState = SELF::STACK_IS_USED;
		}
	}

	/***
	 * @brief returns the top item on the stack 
	 * @return mixed 
	 */
	protected function topStackItem()
	{
		if ( empty($this->_stack) ) {
			return null;
		}

		$item = end($this->_stack);
		reset($this->_stack);
		return $item;
	}

	/***
	 * @brief checks if stack is empty 
	 * @return bool - whether or not the stack is empty.
	 */
	protected function stackIsEmpty()
	{
		return empty($this->_stack);
	}

	/***
	 * @brief creates a new series in the activitySeries array under specific conditions.
	 * 
	 * @return void 
	 * 
	 * @details the activitySeries is an array that models a series of nodes/trees of activities within a single action.
	 * Generally, a single action should generate a single activity i.e. a node. In some actions, like an index or view
	 * what is generated is a set of related activities which are collected in a tree. In even more complex actions,
	 * the action results in not just in one set of related activities, but a series of activities. Each set of related
	 * activities is collected in a tree, but there are a set of trees or series of related activities  - as in a forest
	 * which is held by the activitySeries array.
	 * A new series can only be created when one set of activities is completely finished. The best way to determine this is through
	 * the stack. When the stack is filled (with strings indicating the activieies) and then emptied (when the related activies
	 * are completed) and another activity is started (or set of activities) then a new series can be created.
	 */
	protected function getNewSeriesNode()
	{
		static $index = 0;
		if ( isset( $this->activitySeries[$index] ) && !$this->activitySeries[$index]->isEmpty() ) {
			Yii::warning("Through a new index");
			$node = $this->activitySeries[++$index] = new ActivityMessageNode;
			return $node;
		}
		if (isset( $this->activitySeries[$index]) ) {
			Yii::warning("Reusing that index");
			return $this->activitySeries[$index];
		}

		if ( $this->currentActivityNode->isEmpty() ) {
			Yii::warning("The last node on the previous series is stil empty? This shouldn't happen really!");
			return $this->currentActivityNode;
		}

		throw new yii\base\InvalidCallException("There appears to be a logical error in navigating the activity series object!");
	}

	/***
	 * @brief provides a simple way to include a message to an activity node at any point BEFORE it is handled by acivityManager
	 * 
	 * @param [array] $messageDetails an array providing details of the message to include. 
	 * @details the $messageDetails array must provide some information as a minimum for this to work. 
	 * 1. Provide the message you want to add. For now, this should just be a simple message with the flag (array index) indicating if 
	 * the message is to be apended or prepended upon resolution. 
	 * 2. The object to which this message relates. Right now, messages need to be linked to specific activity objects.
	 * 
	 * @future create a message draft object which can be provied instead of the array. The message draft object at instantiation 
	 * would test against the conditions automatically. Then create a simple system with which a message construct can be amended 
	 * through a message draft.
	 */
	public function includeMessage($messageDetails) 
	{
		if (!is_array($messageDetails)) {
			throw new yii\base\InvalidCallException("You must provide an array for message details.");
		}

		if ( !( array_key_exists('PREPEND', $messageDetails) || array_key_exists('APPEND', $messageDetails) ) ) {
			throw new yii\base\InvalidCallException("You must provide a message string in either a PREPEND or APPEND key");
		}

		if ( ( array_key_exists('PREPEND', $messageDetails) && ! is_string($messageDetails['PREPEND']) ) ) {
			throw new yii\base\InvalidCallException("This value must be a string");
		}

		if ( ( array_key_exists('APPEND', $messageDetails) && ! is_string($messageDetails['APPEND']) ) ) {
			throw new yii\base\InvalidCallException("This value must be a string");
		}
		
		if ( !( array_key_exists('OBJECT_ID', $messageDetails) ) ) {
			throw new yii\base\InvalidCallException("You must provide an object id");
		}
		
		if ( !( array_key_exists('OBJECT_SHORT_CLASS', $messageDetails) ) ) {
			throw new yii\base\InvalidCallException("You must provide an object class");
		}

		$this->informActivity($messageDetails);

	}

	protected function informActivity($messageDetails) 
	{
		$interceptKey = $messageDetails['OBJECT_SHORT_CLASS'] . ':' . $messageDetails['OBJECT_ID'];
		$this->intercepts[$interceptKey] = $messageDetails;
	}
}
