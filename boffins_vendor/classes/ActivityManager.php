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
 * however, it was discovered late in the development process of Activity Stream (the project name that generated Activiyt Manager).
 * With redis streams however, much greater efficiencies are possible and more advanced uses are possible.
 * https://redis.io/topics/streams-intro
 */
class ActivityManager extends Component 
{
	/**
	 *  Tree of activity message nodes that indicate all the activities that occur in a given ActivityManager/Request. 
	 */
	protected $activityTree = null;
	
	/**
	 *  tracks the current active node in the tree so that you can make good guesses as to what should be a child node or if you should 
	 *  act on the node you are on.
	 */
	protected $currentActivityNode = null;
	
	/**
	 *  tracks the objects you have treated so that you are not adding the same object in the same tree doing the same thing. 
	 *  an object may have duplicates in the activity tree but only if it is transformed i.e. it occurs in a different DB activity such 
	 *  as find and update. 
	 */
	protected $discoveredObjects = [];
	
	/**
	 *  Keeps a set of activity objects that activity manager watches/listens to. Outside of this list (which is populated upon init)
	 *  other objects are ignored. In order for an object to be listened to, it needs to suscribe. 
	 */
	protected $_activityObjectClasses = [];
	
	/**
	 *  what is this?
	 */
	protected $_subscriptions = [];
	
	/**
     * @var Controller|\yii\web\Controller|\yii\console\Controller the controller that initiates the source action
	 */
	protected $sourceControllerID;
	
	/**
	 *  the action that commences the activity. 
	 */
	protected $sourceActionID;
	
	/***
	 *  the user who makes the request that initiates the activities. 
	 *  Note that each activity manager manages only one request so only ever has one actor. That said,
	 *  this variable is public so that, through the process of request, it can be intercepted and potentially restyled. 
	 */
	public $actor;

	public $globalCount = 0;


	/**
	 * @brief {@inheritdoc}
	 * 
	 * @details basic initialisations and start listening to controller actions (only those that are relevant to the activity manager)
	 */
	public function init()
	{
		parent::init();
						
		$this->currentActivityNode = $this->activityTree = new ActivityMessageNode;
		
		foreach ($this->getActivityObjectClasses() as $activityObjectClass) { 
			$controller = $activityObjectClass->controller_name;
			ActionEvent::on($controller, \yii\web\Controller::EVENT_BEFORE_ACTION, [$this, 'handleBeforeAction']);
			ActionEvent::on($controller, \yii\web\Controller::EVENT_AFTER_ACTION, [$this, 'handleAfterAction']);
		}
		
		if ( Yii::$app->user->identity instanceof boffins_vendor\classes\BoffinsArRootModel ) { //this never happens which means activity
																							//manager is instantiated before a user is
																							//created
			throw new yii\base\InvalidArgumentException("Can't get a public title.");
		}
	}
	
	/**
	 *  @brief 
	 *  
	 *  @param [in] $event The event object triggered by the controller
	 *  @return void
	 *  
	 *  @details More details
	 */
	public function handleBeforeAction($event)
	{
		$this->sourceControllerID = $event->sender->id;
		$this->sourceActionID = $event->action->id;
		
		Yii::warning('Activity Manager is now tracking events on ' . $this->sourceControllerID . ' through ' . $this->sourceActionID, __METHOD__);
		
		foreach ($this->getActivityObjectClasses() as $activityObjectClass) {
			//attach event handlers for all relevant events for each model in $activityObjectClass
			//these are class level event handlers so they will listen to the events of all 
			//instances of the class which are created within this action. 
			$ARModelClass = $activityObjectClass->class_name;
			Yii::warning("Creating listeners on specfic events for $ARModelClass", __METHOD__);
			
			ActivityEvent::on($ARModelClass, BoffinsArRootModel::COMPLETED_ACTIVITY, [$this, 'handleCompletedActivity']);
			ActivityEvent::on($ARModelClass, BoffinsArRootModel::BEGIN_ACTIVITY, [$this, 'handleBeginActivity']);
		}
		//check the subscriptions this user is currently listed on
		//if any of these subscriptions result in an object activiity 
		//record that object activity 
	}
	
	public function handleBeginActivity($event)
	{
		static $staticCount = 0;

		if (! $event instanceof ActivityEvent) {
			throw new yii\base\InvalidCallException("Activity Manager only works with instances or child classes of ActivityEvent!");
		}

		
		Yii::warning("Commence Activity static:" . ++$staticCount . ' Global:' . ++$this->globalCount, __METHOD__);

		$activityObject = $event->sender;

		if ( empty($activityObject) ) {
			return;
		}
		$objectClass = empty($activityObject) ? $activityObject->additonalParams['modelClass'] : $activityObject->shortClassName();
		$id = $activityObject->id;
		$modelActivity = $event->modelAction;
		
		if ( array_key_exists("{$objectClass}:{$modelActivity}:{$id}", $this->discoveredObjects) ) {
			return;
		}


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
		if (! $event instanceof ActivityEvent) {
			throw new yii\base\InvalidCallException("Activity Manager only works with instances or child classes of ActivityEvent!");
		}

		Yii::warning("Running this a second time! Or first??? {$event->modelAction} ", __METHOD__);
		$activityObject = $event->sender;
		$objectClass = $activityObject->shortClassName();
		$id = $activityObject->id;
		$modelActivity = $event->modelAction;
		
		if ( array_key_exists("{$objectClass}:{$modelActivity}:{$id}", $this->discoveredObjects) ) {
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
				$this->handleAfterDelete($event);
				break;
			//have not treated delete proper. 
			default: 
				Yii::error("Scratching head. Activity manager doesn't track this event and yet found it???");
				break;
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
	protected function handleAfterFind($event) 
	{
		$activityObject = $event->sender;
		if ( $activityObject->hasMethod('shortClassName') ) {
			$objectName = ucfirst($activityObject->shortClassName());
			$this->addActivityToTree($activityObject, [
				'verb' => 'found',
				'article' => 'the',
				'object' => $objectName . ' ' . $activityObject->getPublicTitleofBARRM(),
			]);
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
	protected function handleAfterInsert($event) 
	{
		$activityObject = $event->sender;
		if ( $activityObject->hasMethod('shortClassName') ) {
			$objectName = $activityObject->shortClassName();
			$this->addActivityToTree($activityObject, [
				'verb' => 'created',
				'article' => 'a',
				'object' => $objectName . ': ' . $activityObject->getPublicTitleofBARRM(),
			]);

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
		if ( $activityObject->hasMethod('shortClassName') ) {
			$objectName = ucfirst($activityObject->shortClassName());
			$this->addActivityToTree($activityObject, [
				'verb' => 'updated',
				'article' => 'the',
				'object' => $objectName . ': ' . $activityObject->getPublicTitleofBARRM(),
			]);
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
	protected function handleAfterDelete($event) 
	{
		$activityObject = $event->sender;
		if ( $activityObject->hasMethod('shortClassName') ) {
			
			$objectName = ucfirst($activityObject->shortClassName());
			$this->addActivityToTree($activityObject, [
				'verb' => 'deleted',
				'article' => 'the',
				'object' => $objectName . ': ' . $activityObject->getPublicTitleofBARRM(),
			]);

		}
		//Yii::warning("$objectName " . $activityObject->id . ' is found', 'Actvity Manager');
	}
	
	/***
	 *  @brief 
	 *  
	 *  @param [in] $event The event object triggered by the controller
	 *  @return void
	 *  
	 *  @details More details
	 */
	public function handleAfterAction($event)
	{
		if ( empty(Yii::$app->user->identity) ) {
			Yii::warning("User component is empty or user identity is not set. Stopping", __METHOD__);
			return; // there is no user, Activity Manager currently will not work with console requests or before a user identity is set. 20/04/19 WHY???
		}
		
		$user_id = Yii::$app->user->identity->id;
		//$objectClassID = ActivityObjectClass::findOne(['class_name' => $this->activityTree->activityDetails['object_class'] ])->id;
		//$userSubscriptions = Subscription::findAll(['object_class_id' => $objectClassID, 'action_id' => $this->sourceActionID ]);
		//don't forget the object id in the line above. 
		//$sub_user_id = $userSubscriptions->user_id;
		//Yii::warning("The number of subscriptions are " . count($userSubscriptions), __METHOD__ );
		
		if (Yii::$app->has('user') && !empty(Yii::$app->user->identity) && Yii::$app->user->identity instanceof BoffinsArRootModel ) {
			$actor = Yii::$app->user->identity->getPublicTitleofBARRM();
		} else {
			$actor = 'The System';
		}
		
		$this->activityTree->prependFormat('actor');
		$this->activityTree->addConstruct('actor', $actor);
		Yii::warning($this->activityTree->resolve(), __METHOD__);
		$redis = Yii::$app->redis;
		
		//$redis->lpush( "user_message:$user_id", $this->activityTree->resolve() );
		//$redis->hmset( "user_message:$user_id", "message", $this->activityTree->resolve(), "date", time() );
		//echo "<pre>";
		//var_dump($this->activityTree);
		
		//check the activities and activity objects that were generated in this request.
		//generate messages for each of the objects
		//encapsulate into a single message
		//store that message or trigger a message send routine that will ensure the message is published on the frontend.
		Yii::warning('Activity Manager has now finished tracking events on ' . $event->sender->id, __METHOD__); //sender is FolderController

	}
	
	/***
	 *  @brief getter for private $_activityObjectClasses
	 *  
	 *  @return $_activityObjectClasses
	 */
	public function getActivityObjectClasses()
	{
		if ( empty($this->_activityObjectClasses) ) {
			$this->_activityObjectClasses = ActivityObjectClass::find()->all(); //with this initialisation, it means there can be no change reflected for the duration of a single request.
		}
		return $this->_activityObjectClasses;
	}
	
	/***
	 *  @brief fetch activity object classes
	 *  this is only useful if there is any need, within a request to update the ActivityObject Classes.
	 *  this function is pretty redundant otherwise.
	 *  
	 *  @return $_activityObjectClasses
	 */
	public function fetchActivityObjectClasses()
	{
		$this->_activityObjectClasses = ActivityObjectClass::find()->all();
		return $this->_activityObjectClasses;
	}
	
	/***
	 *  @brief a function that any BARRM can run to subscribe itself to activity stream.
	 *  
	 *  @param [BoffinsArRootModel] $object the object that wants to be subscribed.
	 *  @params [array] $actions the actions for which this object should be subscribed.
	 *  @return void
	 *  
	 *  @details You can call this function simply as follows from any BARRM (only models saved in the DB can subscribe)
	 *  FROM within any model write:
	 *  Yii::$app->activityManager->subscribe($this); or Yii::$app->activityManager->subscribe($this, ['view']);
	 *  In the first example, activity manager will subscribe the BoffinsArRootModel object instance ($this)
	 *  In the second example, activity manager will subscribe the BoffinsArRootModel instance to listen to the view action only of that object
	 * @future register new BARRM classes which are not in ActivityObjectClasses set by creating a new instance of 
	 * ActivityObjectClasses and saving to the DB. This way when someone subscribes a new instance of BARRM and Activity Manager 
	 * will now begin to listen for it. 
	 */
	public function subscribe($object, $actions = ['view', 'update', 'delete'])
	{
		if (! $object instanceof BoffinsArRootModel ) {
			Yii::warning("Can only register objects of class BoffinsArRootModel or child.", __METHOD__);
			throw new yii\base\InvalidCallException("parameter object does not match requirements. Provide a BARRN instance");
		}
		
		if (! is_array($actions) ) {
			Yii::warning("Registration process cannot proceed. I need an array of actions.", __METHOD__);
			throw new yii\base\InvalidCallException("parameter actions does not match requirements. Provide an array of strings");
		}
		
		if ( empty(Yii::$app->user->identity) ) {
			Yii::error("Hmn. Can't subscribe this object. There is no user!", __METHOD__);
		}
		
		if ( empty($object->id) ) {
			Yii::error("Hmn. Can't subscribe this object. There is no id!", __METHOD__);
		}

		$objectClass = ActivityObjectClass::findOne(['class_name' => $object->className()]);
		if ( empty($objectClass) ) {
			Yii::error("Hmn. Can't subscribe this object. There is no objectClass!", __METHOD__); //or you include this one. 
		}
		
		$security = new \yii\base\Security;
		foreach ( $actions as $action ) {
			$subscription = new Subscription;
			$subscription->id = $security->generateRandomString(64);
			$subscription->user_id = Yii::$app->user->identity->id;
			$subscription->object_id = $object->id;
			$subscription->object_class_id =  $objectClass->id;
			$subscription->action_id = $action;
			$subscription->save();
		}
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
		
		Yii::warning("Model and Controller: {$sourceModelName} and {$this->sourceControllerID}", __METHOD__);
		
		$newNode = new ActivityMessageNode;
		$this->assignActivityDetails($newNode, $activityObject);
		if ( $sourceModelName == $this->sourceControllerID ) {
			switch ($this->sourceActionID) {
				case 'index':
					//in a list. Just list all items
					$this->currentActivityNode->addChildNode( $this->addActivityMessage($messageConstructs, $newNode) );
					break;
				case 'view':
					//check url if it's the same one, then
					if ( $this->objectIsTarget($activityObject) ) {
						$this->addActivityMessage($messageConstructs, $this->currentActivityNode);
						Yii::warning("Object is self!", __METHOD__);
					} else {
						$this->currentActivityNode->addChildNode( $this->addActivityMessage($messageConstructs, $newNode) );
						$this->currentActivityNode = $newNode;
						
						Yii::warning("Object is child", __METHOD__);
					} 
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
		
		return $this->activityTree;
	}
	
	/**
	 *  @brief simple function to create an activity message node upon the completion of each activity.
	 *  
	 *  @param [arr] $constructs an array of constructs to the activity message node
	 *  @param [NodeInterface] $node an ActivityMessageNode
	 *  @return [ActivityMessageNode]
	 */
	protected function addActivityMessage($constructs, &$node = null)
	{
		if ( $node === null ) {
			$node = new ActivityMessageNode;
		} elseif ( !$node instanceof ActivityMessageNode ) {
			throw new yii\base\InvalidArgumentException("You must provide a node instance of ActivityMessageNode: " . __METHOD__ );
		}
		
		foreach ( $constructs as $construct => $value ) {
			$node->addConstruct($construct, $value);
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
}
