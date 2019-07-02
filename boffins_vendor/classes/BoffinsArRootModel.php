<?php
/**
 * @copyright Copyright (c) 2017 Ubuxa (By Epsolun Ltd)
 */

namespace boffins_vendor\classes;

use Yii;
use yii\base\Behavior;
use yii\behaviors\AttributeBehavior;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use boffins_vendor\behaviors\DeleteUpdateBehavior;
use boffins_vendor\behaviors\DateBehavior;
use boffins_vendor\behaviors\ComponentsBehavior;
use boffins_vendor\behaviors\ClipOnBehavior;
use boffins_vendor\behaviors\TenantSpecificBehavior;
use yii\db\ActiveQuery;
use boffins_vendor\classes\{StandardQuery, ActivityEvent};
use boffins_vendor\classes\models\{StandardTenantQuery, TenantSpecific, TrackDeleteUpdateInterface, ClipperInterface, ClipableInterface};
use frontend\models\FolderComponent;
use frontend\models\Clip;


/***
 *  This is the base/root Active Record Model for most DB objects in Ubuxa. 
 */
class BoffinsArRootModel extends ActiveRecord //In retrospect, I think this is poorly named and I named it! Anthony
{
	//this class is also POORLY documented. 
	
	/***
	 * boolean. To indicate that an instance of this class should not implement any other behaviors but those configures in-class 
	 * THIS IS NOT IMPLEMENTED SO THIS IS USELESS.
	 */
	public $defaltBehaviour;
	
	public $ownerId; //what is this?
	public $fromWhere; //what is this? 
	
	/***
	 * triggered at the beginning of an activity 
	 */
	const BEGIN_ACTIVITY = 'beginActivity';

	/***
	 * triggered at the end of an activity 
	 */
	const COMPLETED_ACTIVITY = 'completeActivity';
	
	/***
	 * corresponds to the find activity
	 */
	const MODEL_ACTIVITY_FIND = 'find';
	
	/***
	 * corresponds to the insert activity
	 */
	const MODEL_ACTIVITY_INSERT = 'insert';
	
	/***
	 * corresponds to the update activity
	 */
	const MODEL_ACTIVITY_UPDATE = 'update';
	
	/***
	 * corresponds to the delete activity
	 */
	const MODEL_ACTIVITY_DELETE = 'delete';
	
	/***
	 * corresponds to the softDelete activity
	 */
	const MODEL_ACTIVITY_SOFT_DELETE = 'softDelete';

	/***
	 * boolean to indicate if Activity Find Events are triggerd. Mostly used by the new findQuietly static function 
	 * and afterFind() method. Defaults to true. 
	 */
	public $triggerEvent = true;
	
	/*
	 * @array or string to list date values in the ARModel/Child class
	 * each child class should define it's own dateAttributes - this should be deprecated once the 
	 * date fields all move to timestamp instead of dateTime. 
	 */
	public $dateAttributes = array( 'last_updated' );
	
	/**
     * Initialise AR. 
	 * Respond to new Events defined in DeleteUpdateBehavior
	 * @imporatant! All child classes must call parent::init() if they override this function. 
	 * attaches behaviors for each instance of this class depending on the needs for that instance/the type of child class. 
	 * this kind of implies global knowledge - breaks encapsulation I think. Refactor this. 
	 * all these attachments at initialisation, does this mean behaviors(), myBehaviors() and _mergeBehaviours() are deprecated?
	 */
	public function init() 
	{
		//attach the TenantSpecificBehavior if this SUBCLASS implements it.  
		if ( in_array( "boffins_vendor\classes\models\TenantSpecific", class_implements(static::class) ) ) {
			Yii::trace("Attaching TenantSpecificBehavior in " . static::class, __METHOD__ );
			$this->attachBehavior("TenantSpecificBehavior", [
					'class' => TenantSpecificBehavior::className(),
					//'tenantID' => '...', //we should have a global function that retrieves the tenantID agnostically in all situations.
				]);
		}

		//attach the DeleteUpdateBehavior if this subclass implements it.  
		if ( in_array( "boffins_vendor\classes\models\TrackDeleteUpdateInterface", class_implements(static::className()) ) ) {
			Yii::trace("Attaching DeleteUpdateBehavior in " . static::class, __METHOD__ );
			$this->attachBehavior("DeleteUpdateBehavior", [
					'class' => DeleteUpdateBehavior::className(),
				]);

			$this->on(DeleteUpdateBehavior::EVENT_BEFORE_SOFT_DELETE, [$this, 'beforeSoftDelete']);
			$this->on(DeleteUpdateBehavior::EVENT_AFTER_SOFT_DELETE, [$this, 'afterSoftDelete']);
			$this->on(DeleteUpdateBehavior::EVENT_BEFORE_UNDO_DELETE, [$this, 'beforeUndoDelete']);
			$this->on(DeleteUpdateBehavior::EVENT_AFTER_UNDO_DELETE, [$this, 'afterUndoDelete']);
		}			
				
		//attach the ClipOnBehavior if this INSTANCE implements it.  
		if ( $this->usesClipOnBehavior() ) {
			Yii::trace("Attaching ClipOnBehavior in " . static::class, __METHOD__ );
			$this->attachBehavior("ClipOnBehavior", [
					'class' => ClipOnBehavior::className(),
				]);
		}
 	}
	
	/**** behaviors function DEPRECATED?
	 * Final function returns a merged array of the base behaviors and the custom behaviors created by user
	 * Function cannot be overridden by child classes. Use 'myBehaviors' to assign new behaviors
	 *
	final public function behaviors()
	{
		return [];
		//return $this->_mergeBehaviours( $this->_baseBehaviors(), $this->myBehaviors() );		
	}*/
	
	/*
	 * IS THIS DEPRECATED?
	 * Merges two behaviors. Expects to merge a base behavior (internally defined) 
	 * and custom behaviors defined by the user. Those behaviors common to the base behavior will
	 * be ovewritten by the custom behavior.
	 * @params $base - expexts a base behavior 
	 * @param $customBehaviors - optional should be the custom behaviors set by the user.
	 */
	private function _mergeBehaviours($base, $customBehaviors = array())
	{
		$mergedBehaviors = array();
		
		//First merge with base 
		foreach ($customBehaviors as $customBehaviorKey => $customBehaviorValue) {
			$found = false;
			foreach ($base as $baseBehaviorKey => $baseBehaviorValue) {
				if ( is_array($baseBehaviorValue) && is_array($customBehaviorValue) ) {
					if ( !empty($baseBehaviorValue['class']) && !empty($customBehaviorValue['class']) ) {
						if ( $baseBehaviorValue['class'] == $customBehaviorValue['class'] ) {
							$found = true;
							try {
								$mergedBehaviors[$customBehaviorKey] = $baseBehaviorKey == $customBehaviorKey ? array_merge($baseBehaviorValue, $customBehaviorValue) : $customBehaviorValue;
							} catch(Exception $e) {
								trigger_error("The base = {$baseBehaviorValue} and custom {$customBehaviorValue} ");
							}
						}
					} else {
						trigger_error("Behavior incorrectly set! - " . __METHOD__, E_USER_ERROR );
					}
				} elseif ( is_string($baseBehaviorValue) || is_string($customBehaviorValue) ) {
					if ( $this->_classString($baseBehaviorValue) == $this->_classString($customBehaviorValue) ) {
						$found = true;
						try {
							$mergedBehaviors[$customBehaviorKey] = $baseBehaviorKey == $customBehaviorKey ? $this->merge_string_array($baseBehaviorValue, $customBehaviorValue) : $customBehaviorValue;
						} catch(Exception $e) {
							trigger_error("The base = {$baseBehaviorValue} and custom {$customBehaviorValue} ");
						}
						//merge_string_array as one of the behaviors is a string not an array. 
					}
				} else {
					//neither is a string or array trigger error
					trigger_error("Behavior the type neither string nor array? - " . __METHOD__, E_USER_ERROR );
				}
			}
						
			if (!$found) {
				//must be a new behavior 
				$mergedBehaviors[$customBehaviorKey] = $customBehaviorValue;
			}
		}
		return array_merge($this->_baseBehaviors(), $mergedBehaviors);
	}
	
	/*
	 * Returns the class string of a behavior. 
	 * if the behavior is simply a class string, returns the class string. 
	 * if the behavior it returns the array item in the 'class' key. Returns false if this is empty
	 * returns null if the class found is not a valid class.
	 * @params string or array variables.
	 * @details returns the class name as stored in an array/string, but, 'className' is already taken
	 * @return string
	 */
	private function _classString($item) 
	{
		if ( is_array($item) ) {
			if ( !empty($item['class']) ) {
				return class_exists($item['class']) ? $item['class'] : false;
			} else {
				return false;
			}
		} else {
			return class_exists($item) ? $item : null;
		}
	}
	
	/**
	 * Merges two items which can be either an array or a string. 
	 * latter items in the parameter list will overwrite earlier ones.
	 * Should be extendable to accept multiple items but currently limited to 2.
	 * @params string or array variables. 
	 */
	public function merge_string_array()
	{
		$result = array();
		$args = func_get_args();
		$arrayItem = array();
		$otherItem = '';
		$firstIsPreferred = false;
		$continue = true;
		if ( is_array($args[0]) ) { 
			$arrayItem = $args[0];
			$otherItem = $args[1];
		} elseif ( is_array($args[1]) ) {
			$arrayItem = $args[1];
			$otherItem = $args[0];
			$firstIsPreferred = true;
		} else {
			$result = $args[0] === $args[1] ? $args[0] : $args[1];
			$continue = false;
 		}
		
		if ( $continue ) {
			foreach ( $arrayItem as $key => $item1 ) {
				if ( ! is_array($otherItem) ) {
					$result[$key] = $firstIsPreferred ? $this->merge_string_array($otherItem, $item1) : $this->merge_string_array($item1, $otherItem);
				} else {
					foreach ( $otherItem as $item2 ) {
						$result[$key] += $this->merge_string_array($item1, $item2);
					}
				}
			}
		}
		return $result;
	}
	
	/*
	 * Simply returns a base configuration of behaviors 
	 * to ammend this, the user can set their configurations in 
	 * myBehaviors function. 
	 */
	private function _baseBehaviors()
	{
		return [
			
		];

	}

	/**
	 * @brief a function to be overriden by a child class. This function should return a set of behaviors for the child class
	 * 
	 * @return array
	 */
	public function myBehaviors()
	{
		return array();
		
	}
	
	/**
	 * placeholder function - to be overridden by user as required.
	 */
	public function beforeSoftDelete()
	{
		$activityEvent = new ActivityEvent;
		$activityEvent->modelAction = self::MODEL_ACTIVITY_SOFT_DELETE;
		$this->trigger(self::BEGIN_ACTIVITY, $activityEvent);

	}
	
	/**
	 * @details - triggers the completion of an activity. Also consider refactoring. 
	 */
	public function afterSoftDelete()
	{
		$activityEvent = new ActivityEvent;
		$activityEvent->modelAction = self::MODEL_ACTIVITY_SOFT_DELETE;
		$this->trigger(self::COMPLETED_ACTIVITY, $activityEvent);
	}
	
	/**
	 * placeholder function - to be overridden by user as required.
	 */
	public function beforeUndoDelete()
	{
	}
	
	/**
	 * placeholder function - to be overridden by user as required.
	 */
	public function afterUndoDelete()
	{
	}
	
	/**
	 *  @brief {@inheritdoc}
	 *  
	 *  @details leaving this function here in order to make progress. 
	 *  however, this terribly needs to be refactored because if child classes overload this, then the Completed Activity will be triggered 
	 *  WHILE the final checks and transformations for the find activity are still being done. 
	 *  
	 *  IMPORTANT NOTICE: All child classes overriding afterFinde MUST call parent::afterFind() AFTER their custom code. 
	 *  i.e. it should be the last line of code.
	 *  @future refactor - this should be placed in StandardQuery Class populate function 
	 */
	public function afterFind() 
	{
		if ( $this->triggerEvent ) {
			parent::afterFind();
			$activityEvent = new ActivityEvent;
			$activityEvent->modelAction = self::MODEL_ACTIVITY_FIND;
			$this->trigger(self::COMPLETED_ACTIVITY, $activityEvent);
		}
	}
		
	/**
	 * @brief {@inheritdoc}
	 *
	 * @details overriding save in order to ensure that an activity event is only triggered AFTER a successful save. 
	 * Note that this calls the parent save function (ActiveRecord or BaseActiveRecord) and so this function 
	 * is run BEFORE and AFTER afterSave. It is run before afterSave in that it is the entry function to commence the saving process
	 * (this is consistent with how Yii2 core works). Then the parent runs the functions, beforeSave, updates or inserts and then afterSave
	 * This is all consistent with Yii2 core. After this is all done, the ActivityEvent 'COMPLETED_ACTIVITY' will be triggered.
	 * Please note triggering the ActivityEvent by overriding afterSave() is the wrong implementation as it
	 * will break Yii2 core rules whenever a child class needs to override afterSave() (which is very likely)
	 *
	 * Steps are therefore as follows:
	 * 1. Ask to save the record. 
	 * 2. Initiate beforeSave function (this is in the parent and goes through the update/insert and internal functions)
	 * 3. If 2 is successful, run the actual database queries 
	 * 4. Trigger afterSave function (this is done in the parent)
	 * 5. ActivityEvent is triggered. 
	 *
	 * IMPORTANT NOTICE: All child classes overriding save MUST call parent::save() AFTER their custom code. i.e. 
	 * it should be the last line of code. Otherwise, the activity event will be triggered BEFORE the custom
	 * code is acually completed.
	 * Which is not the intended behavior. 
	 */
	public function save($runValidation = true, $attributeNames = null)
    {
		$newRecord = $this->isNewRecord; //once parent::save is completed through insert, isNewRecord is no longer true;
		if ( $result = parent::save($runValidation, $attributeNames) ) {
			$activityEvent = new ActivityEvent;
			$activityEvent->modelAction = $newRecord ? self::MODEL_ACTIVITY_INSERT : self::MODEL_ACTIVITY_UPDATE;
			$this->trigger(self::COMPLETED_ACTIVITY, $activityEvent);
		}
		
		//$activityEvent->additonalParams['changedAttributes'] = $changedAttributes; //have to figure out where this is injected.
		return $result;
    }
	
	/**
	 * {@inheritdoc}
	 *
	 *  @details switching Query class for all instances of this class
	 */
	public static function find()
	{
		Yii::info("Using StandardQuery class to perform queries in " . static::class, __METHOD__ );
		return new StandardQuery(get_called_class());
	}
	
	/***
	 * @brief a new find method which does not trigger the beforeFind and afterFind events. 
	 */
	public static function findQuietly()
	{
		Yii::info("Using StandardQuery class in Quiet Mode to perform queries in " . static::class, __METHOD__ );
		return new StandardQuery(get_called_class(), ['triggerEvents' => false] );
	}
	/***
	 * Get the type of a given attribute 
	 * THIS SEEMS TO CLASH WITH a child class. Removed as it is barely in use. 
	public function getAttributeType($attribute)
	{
		return $this->hasAttribute($attribute) ? self::getTableSchema()->columns[$attribute]->type : trigger_error('This attribute ({$attribute}) does not exist: ' . $attribute . ' ' . __METHOD__);
	}*/
	
	/***
	 * basic before validate function for each component 
	 */
	public function beforeValidate()  
	{
		if ($this->hasAttribute('deleted') && $this->isNewRecord ) { //this can be improved simply by setting a default value for deleted!
																	//in the DB
			$this->deleted = 0;
		}
		return parent::beforeValidate();
	}
	
	/***
	 * returns a list of the folders as a string. 
	 */ 
	public function specificClipsWithLimitAndOffset($limit=4,$offset=0,$ownerTypeId=2,$barId = 0)
    {
        return Clip::find()->select(['owner_id'])->andWhere(['bar_id' => $barId])->andWhere(['owner_type_id' => $ownerTypeId])->asArray()->limit($limit)->offset($offset)->all();
    }
	
	protected function usesClipOnBehavior($className = '')  //just in case child classes want a variable. 
	{
		$result = false;
		
		$result = in_array( "boffins_vendor\classes\models\ClipperInterface", class_implements(static::class) ) ? true : $result; 
		
		$result = in_array( "boffins_vendor\classes\models\ClipableInterface", class_implements(static::class) ) ? true : $result; 
		
		return $result;
	}
	
	/***
	 *  @brief A simple function to identify what class this object is of. 
	 *  
	 *  @return returns the class name without the namespace 
	 */
	public static function shortClassName()
	{
		$fqnm = static::class;
		return substr($fqnm, strrpos($fqnm, '\\')+1);
	}
	
	/***
	 *  @brief This method tries to use one of the standard ways to determine
	 *  a public title for this instance.
	 *  
	 *  @return string - the title
	 *  
	 */
	public function getPublicTitleofBARRM() : string 
	{
		if ( $this->hasProperty('nameString') ) {
			return $this->nameString;
		}
		
		if ( $this->hasMethod('nameString') ) {
			return $this->nameString();
		}
		
		if ( $this->hasProperty('title') ) {
			return $this->title;
		}
		
		if ( $this->hasProperty('name') ) {
			return $this->name;
		}
		
		if ( $this->hasProperty('id') ) {
			Yii::error("Using ID as a public title! All other properties failed. This child class '" . static::class . "' should implement a nameString property.");
			return $this->id;
		}
		
		throw new yii\base\InvalidCallException("I tried. This object has no method or property to use as a public title. Needs nameString");
	}
	
	/**
	 *  @brief a function that child classes can override in order for instances of that child class to be subscribed
	 *  for activity manager UPON their first creation i.e. insertion into the DB ONLY. If you want to subscribe 
	 *  an instance for activity manager, you have to call Yii::$app->activityManager->subscribe($this); at that point. 
	 *  For instance, if you want a new instances of your child class to be subscribed, 
	 *  simply override this so that in the scenarios you want, it returns true. 
	 *  And in scenarios you do not want it to be subscribed, return false. 
	 */
	protected function subscribeInstanceOnInsert()
	{
		return false;
	}
	
	/**
	 *  @brief {@inheritdoc}
	 *  
	 *  @details Activity stream needs to subscribe this instance for this user at the point of insert. 
	 *  this code can be copy pasted onto any AR model you want to subscribe. 
	 *  this was not placed in parent class because subscription should be limited to a small set of AR models - user centred models.
	 *  
	 *  @future you might want to trigger a Subscription event here. User subscribed to this folder etc.
	 */
	public function afterSave ( $insert, $changedAttributes ) 
	{
		if ( $insert && $this->subscribeInstanceOnInsert() ) {
			Yii::$app->activityManager->subscribe($this);
		}
		parent::afterSave( $insert, $changedAttributes );
	}

	/***
	 * @brief introducing a function that MUST be run before any find process. 
	 * @details This function triggers a BEGIN_ACTIVITY event. 
	 * This is important as it is the only way to introduce an event before a find is commenced 
	 * The current ActiveRecord lifecycle leaves no space for an event to be triggered before the find. 
	 * 
	 * @future consider other ways to trigger an event before the find without touching Yii core.
	 */
	public static function beforeFind()
	{
		Yii::info("Running Before Find for " . static::class, __METHOD__);
		$activityEvent = new ActivityEvent;
		$activityEvent->eventPhase = ActivityEvent::ACTIVITY_EVENT_PHASE_BEFORE;
		$activityEvent->modelAction = SELF::MODEL_ACTIVITY_FIND;
		$activityEvent->additionalParams['modelClass'] = static::class;
		$activityEvent->additionalParams['shortClass'] = static::shortClassName();
		
		ModelEvent::trigger(static::class, SELF::BEGIN_ACTIVITY, $activityEvent);
	}

	public function getFqn() 
	{
		return static::class;
	}


	public function getClipOwnerType() 
	{
		$myShortClass = lcfirst( $this->shortClassName() );
		Yii::warning(\yii\helpers\VarDumper::dumpAsString( $this->hasOne(\frontend\models\ClipOwnerType::className(), ['owner_type' => $myShortClass]) ), "BARRM 2");
		return $this->hasOne(\frontend\models\ClipOwnerType::className(), ['owner_type' => $myShortClass]);
	}

	public function getClip()
	{
		return $this->hasOne(\frontend\models\Clip::className(), ['owner_id' => 'id'] )
				->onCondition(['owner_type_id' => 'clipOwnerType.id' ]);
	}
}