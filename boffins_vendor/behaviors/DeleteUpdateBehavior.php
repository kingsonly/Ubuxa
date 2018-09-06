<?php
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace app\boffins_vendor\behaviors;

use Yii;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\db\ActiveRecord;
use yii\db\Expression;


/** 
 * DeleteUpdateBehavior automatically saves the old attributes of a model into a backup DB on any Update Event 
 * AND changes delete attribute to true (1) upon delete OR false (0) for a new record
 * This only applies to models that track updates and are not deleted
 *
 * To use DeleteUpdateBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use boffins_vendor\behaviors\DeleteUpdateBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         DeleteUpdateBehavior::className(),
 *     ];
 * }
 * ```
 *
 * By default, DeleteUpdateBehavior expects 'last_updated' to be the field/attribute that indicates the date of the last update 
 * and 'deleted' to be the field/attribute that indicates the status of a model item 
 * when the associated AR object is being updated (insert or update); it will fill the `last_updated` attribute (or the attribute that tracks this)
 * *
 * 
 * DeleteUpdateBehavior expects a datetime attribute for last_updated and Int(1) for deleted
 * 
 * If the attribute names are different then this can be changed by changing the values of lastUpdatedAttribute and markedForDeleteAttribute variables
 *
 * public function behaviors()
 * {
 *     	return [
 *         	[
 *             	'class' => DeleteUpdateBehavior::className(),
 *             	'lastUpdatedAttribute' => 'last_updated',  	//change this if it does not match your model
 *             	'markedForDeleteAttribute' => 'deleted',  	//change this if it does not match your model
 *				'allowHardDelete' => false,					//change to true if you actually want this model deleted
				'AREvents' => 								//see comments below on how to set AREvents
 *         	],
 *     	];
 * }
 * ```
 * *
 * DeleteUpdateBehavior also allows a method named [[touch()]] borrowed from TimeStampBehavior that allows you to assign the current
 * timestamp to the specified attribute(s) and save them to the database. For example,
 *
 * ```php
 * $model->touch('creation_time');
 * ```
 *
 */
class DeleteUpdateBehavior extends Behavior
{
	/**
     * @var array list of ActiveRecord events that this behavior will respond to and how they are to be dealt with
     * The array keys are the names of the ActiveRecord event upon which this behavior is to act on,
     * and the array values are an array of arrays corresponding to the attribute(s) to be updated by this behavior. 
     * You must use an array to represent a list of attributes (even if it is only one attribute).
	 * In addition, you can optionally assign a function (within the AR class) or an anonymous function which can 
     * be run to retrieve a value for the attributes in the attributes array
	 * See the below example:
	 *
	 *
     * ```php
	 * $AREvents = array( 
     *     			ActiveRecord::EVENT_BEFORE_INSERT => [ 'attributes' => ['attribute1', 'attribute2'], 'method' => 'functionWithinARModel' ],
	 *     			ActiveRecord::EVENT_AFTER_UPDATE => [ 'attributes' => ['attribute2', 'attribute3'], 'method' => function ($event) { return 'some value'; } ],
	 * 				ActiveRecord::EVENT_BEFORE_VALIDATE => [ 'attributes' => ['attribute1'] ]
     * 			);
     * ```
	 * NOTE: If you set an event other than EVENT_BEFORE_UPDATE, EVENT_BEFORE_VALIDATE or EVENT_BEFORE_DELETE you must write a special function to handle it within the 
	 * AR model. Therefore, any other events should be handled within the ActiveRecord model itself
     */
	 
	//VARIABLES/PROPERTIES
	/***
	 * @var array list of Events that this behaviour acts on - can be user defined. 
	 * Any event not listed in this array will be ignored by this behavior 
	 */
    public $AREvents = [];
	/***
	 * @var bool. Set variable to true before delete process to ensure a Hard Delete.
	 */
	public $forceDelete = false;
    /***
     * @var string the attribute that will receive datetime value
     * Set this property to false if you do not want to track the update 
     */
    public $lastUpdatedAttribute = 'last_updated';
    /***
     * @var string the attribute that will receive timestamp value.
     * Set this property to false if you do not want to terminate deletes - this means that setting this to false will make your model deletable 
     */
    public $markedForDeleteAttribute = 'deleted';	 
	/**
	 * @var mixed internal variable to track last_updated value - should be either a date value or false
	 */
    protected $lastUpdatedValue;
	/**
	 * @var mixed internal variable to track last_updated value - should be TINYINT(1) (0, 1) or false
	 */
    protected $deletedValue;
	/**
	 * Internal constant for default value for dates
	 */
	const DEFAULT_DATE = '01/01/1971';
	/**
	 * Internal constant for default value for markup to indicate item is deleted
	 */
	const DEFAULT_DELETED = 1;
	/**
	 * Internal constant for default value for markup to indicate item is in default state i.e. not deleted expects TINYINT(1) to track boolean value for deleted item
	 */
	const DEFAULT_NOT_DELETED = 0;
	/***
     * @event ModelEvent an event that is triggered before deleting a record.
     * You may set [[ModelEvent::isValid]] to be false to stop the deletion.
     */
    const EVENT_BEFORE_SOFT_DELETE = 'beforeSoftDelete';
    /***
     * @event Event an event that is triggered after a record is deleted.
     */
    const EVENT_AFTER_SOFT_DELETE = 'afterSoftDelete';
    /***
     * @event ModelEvent an event that is triggered before record is restored from "deleted" state.
     * You may set [[ModelEvent::isValid]] to be false to stop the restoration.
     */
    const EVENT_BEFORE_UNDO_DELETE = 'beforeUndoDelete';
    /***
     * @event Event an event that is triggered after a record is restored from "deleted" state.
     */
    const EVENT_AFTER_UNDO_DELETE = 'afterUndoDelete';	

	//FUNCTIONS
    /**
     * Set AREvents to default values if not set by owner model. 
	 * Set default values for deletedValue and lastUpdatedValue
     */
    public function init()
    {
        parent::init();
		
		$this->deletedValue = $this->markedForDeleteAttribute == false ? false : SELF::DEFAULT_NOT_DELETED;
		$this->lastUpdatedValue = $this->lastUpdatedAttribute == false ? false : SELF::DEFAULT_DATE;
		
		//allow developer to select which events are handled and how
        if (empty($this->AREvents)) {
            $this->AREvents = [
                ActiveRecord::EVENT_BEFORE_VALIDATE => [ 'attributes' => [$this->lastUpdatedAttribute] ],
				ActiveRecord::EVENT_AFTER_UPDATE => [ 'attributes' => ['NONE'] ],
				ActiveRecord::EVENT_AFTER_INSERT => [ 'attributes' => ['NONE'] ],
				ActiveRecord::EVENT_BEFORE_DELETE => [ 'attributes' => [$this->markedForDeleteAttribute] ],
            ];
        }
    }
	/**
     * Returns an array of Events contained in AREvents variable and sends them to the function evaluateEvents 
	 * to be evaluated
     * @param Event $event
     */
	public function events()
    {
        return array_fill_keys(
					array_keys($this->AREvents),
					'evaluateEvents'
				);
    }
	/**
     * Evaluates each event that has been assigned to the attributes variable and call the function responsible for handling it
     * @param Event $event
     */
    public function evaluateEvents($event)
    {
		switch ($event->name) {
			case ActiveRecord::EVENT_BEFORE_VALIDATE:
				$this->handleBeforeValidate($event);
				break;
			case ActiveRecord::EVENT_AFTER_UPDATE:
				$this->handleAfterUpdate($event);
				break;
			case ActiveRecord::EVENT_AFTER_INSERT:
				$this->handleAfterInsert($event);
				break;
			case ActiveRecord::EVENT_BEFORE_DELETE:
				$this->handleBeforeDelete($event);
				break;
			default: 
				$this->handleOtherEvents($event);
		}
	}
	/**
     * Handles the ActiveRecord::EVENT_BEFORE_DELETE event and checks for proper calls and dispatches to correct functions for processing 
	 * either a user defined funciton or _processDelete function 
     * @param Event $event
     */
	protected function handleBeforeDelete($event) 
	{
		if ( !$this->_checkHandlerCall($event, ActiveRecord::EVENT_BEFORE_DELETE,  __METHOD__ ) ) {
			return false;		
		} else {
			$markedForDeleteAttributes = $this->_getAttributes($event, __METHOD__);
			$method = $this->_getMethod($event, __METHOD__);
			
			if ($method !== false) {
				$this->deletedValue = $this->owner->hasMethod($method) ? $this->owner->$method($event) : call_user_func($method, $event);
			} else {
				$this->deletedValue = $this->_processDelete($event);
			}
			foreach ($markedForDeleteAttributes as $attribute) {
				$this->owner->{$attribute['attribute']} = $this->deletedValue === false ? $attribute['oldValue'] : $this->deletedValue; //false translates to 0. So use $oldDeletedValue if false
			}
			
			if ($this->owner->save(false) && $this->deletedValue === self::DEFAULT_DELETED ) { //trigger AFTER_SOFT_DELETE ONLY if actually soft deleted - ALGORITHM IS INCORRECT WHEN DEFAULT DELETED PREVIOUSLY
				$newEvent = new ModelEvent;
				$this->owner->trigger(self::EVENT_AFTER_SOFT_DELETE, $newEvent);
			}
			return ( ($this->deletedValue !== false) || ($this->deletedValue != self::DEFAULT_NOT_DELETED) ); //Actually no need for a return value at this point
		}
	}
	/**
     * Handles the ActiveRecord::EVENT_BEFORE_VALIDATE event and checks for proper calls and dispatches to correct functions for processing 
	 * where a valid user defined funciton is provided
     * @param Event $event
     */
	protected function handleBeforeValidate($event) 
	{
		if ( !$this->_checkHandlerCall($event, ActiveRecord::EVENT_BEFORE_VALIDATE, __METHOD__) ) {
			return false;
		} else {
			$lastUpdatedAttributes = $this->_getAttributes($event, __METHOD__);// _getAttributes returns an array of the attribute name and array
			foreach ($lastUpdatedAttributes as $attribute) {//lastUpdatedAttributes is not an attribute but an array containing an attribute name and its "old" value
				$newAttribute=$attribute['attribute'];
				$this->owner->$newAttribute = new Expression('NOW()');//these names are poorly defined. $attribute is actually an array 
				
			}
			return true;
		}
	}
	/**
	 * Handles the ActiveRecord::EVENT_AFTER_UPDATE event and checks for proper calls 
	 * and then backs up old data.
	 */
	protected function handleAfterUpdate($event) 
	{
		if ( !$this->_checkHandlerCall($event, ActiveRecord::EVENT_AFTER_UPDATE, __METHOD__) ) {
			return false;
		} else {
			$this->_backupChanges();
		}
	}
	/**
	 * Handles the ActiveRecord::EVENT_AFTER_INSERT event and checks for proper calls 
	 * and then backs up old data.
	 */
	protected function handleAfterInsert($event) 
	{
		if ( !$this->_checkHandlerCall($event, ActiveRecord::EVENT_AFTER_INSERT, __METHOD__) ) {
			return false;
		} else {
			$this->_backupChanges();
		}

	}
	/**
	 * Handles all other events 
	 * However, user must provide a function.
	 */
	protected function handleOtherEvents($event) 
	{
		$attributes = $this->_getAttributes($event, __METHOD__);
		$method = $this->_getMethod($event, __METHOD__);
		if ($method !== false) {
			foreach( $attributes as $attribute ) {
				if ( $this->owner->hasMethod($method) ) {
					$this->owner->$attribute['attribute'] = $this->owner->$method($event); 
				} else {
					$this->owner->$attribute['attribute'] = call_user_func($method, $event);
				}
			}
		} else {
			trigger_error("Sorry! This behavior does not handle this event. You must provide a function. {$handlerName}", E_USER_ERROR); //E_USER_ERROR will terminate everything no need for a return value
		}
		
	}
	/*
	 * Private function to do all the pre handling checks to be sure the correct handler is running the correct event 
	 * This ensures basic rules are followed to prevent incorrect calls from users.
	 */
	private function _checkHandlerCall($event, $handdlerCorrectEventName, $handlerName) 
	{
		if ($event->name !== $handdlerCorrectEventName) {
			//someone called this wrongly
			trigger_error("Wrong handler for this event {$handlerName}", E_USER_ERROR); //E_USER_ERROR will terminate everything no need for a return value
		}
		if (empty($this->AREvents[$event->name])) {
			//not allowed by ARModel. Terminate.  Trigger just a warning and proceed gracefully
			trigger_error("This event is not to be handled by this behavior {$handlerName}");
			return false;
		} else {
			return true;
		}
	}
	/*
	 * Private function to get attributes for a given event
	 * This ensures basic rules are followed to prevent incorrect calls from users.
	 */
	private function _getAttributes($event, $handlerName) 
	{
			$rules = $this->AREvents[$event->name];
			if (empty($rules['attributes'])) {
				//attributes MUST be set for each event - trigger just a warning and proceed gracefully
				trigger_error("Attributes must be set for each event {$handlerName}");
				return false; //or use default??? perhaps in next iteration 
			} elseif (!is_array($rules['attributes'])) {
				//attributes MUST be an array - trigger just a warning and proceed gracefully
				trigger_error("Attributes must be an array {$handlerName}");
				return false;
			} else {
				$attributes = array();
				foreach ($rules['attributes'] as $attribute) {
					if ( $this->owner->hasAttribute($attribute) ) {
						$attributes['attribute']['attribute'] = $attribute;
						$attributes['attribute']['oldValue'] = $this->owner->$attribute;
					} else {
						trigger_error("Attribute ({$attribute}) must be a valid attribute of the model ({$this->owner->className()}) {$handlerName}");
					}
				}
				return $attributes;
			}
	}
	/*
	 * Private function to get user defined method for a given event
	 * This ensures basic rules are followed to prevent incorrect calls from users.
	 */
	private function _getMethod($event, $handlerName) 
	{
		$rules = $this->AREvents[$event->name];
		$method = false;
		if (!empty($rules['method'])) {
			$method = $rules['method'];
		}
		
		if ($method !== false) {
			if( is_callable($method) || $this->owner->hasMethod($method) ) {
				return $method; 
			} else {
				trigger_error("Method must be a function within the AR Model or an anonymous function {$handlerName}");
				return false;
			}
		} else {
			return false;
		}
	}
	/*
	 * Handles the ActiveRecord::EVENT_AFTER_UPDATE event and checks for proper calls 
	 * and then backs up old data.
	 */
	private function _backupChanges() 
	{
		$data = serialize($this->owner->oldAttributes);
		$tableName = $this->owner->tableName();
		$updateDate = new Expression('NOW()');
		Yii::$app->db_backup->createCommand()->insert('tm_updates', array('update_contents' => $data, 
																		'table_name' => $tableName,
																		'create_date' => $updateDate,
																		)
														)->execute();
		return true;
	}
	/*
     * Process the delete instruction. If forceDelete is true, it continues the normal delete process AND marks the item as deleted (just in case the normal delete fails)
	 * triggers an Event: EVENT_BEFORE_SOFT_DELETE and then soft deletes. 
	 * Set the ModelEvent::isValid to false in the handler to stop soft deletion.
	 * Use undoDelete function to undo thedelete
     * @param Event $event
     */
	private function _processDelete($event) 
	{
		if ($this->forceDelete) {
			$event->isValid = true;
			return self::DEFAULT_DELETED; //if for some other reason the normal delete process fails, mark as deleted
		} else {
			$event->isValid = false;
			$softEvent = new ModelEvent;
			$this->owner->trigger(self::EVENT_BEFORE_SOFT_DELETE, $softEvent);
			return $softEvent->isValid ? self::DEFAULT_DELETED : false;
		}
	}
	/***
	 * Private function to get user defined method for a given event
	 * This ensures basic rules are followed to prevent incorrect calls from users.
	 */
	public function undoDelete() 
	{
		$beforeEvent = new ModelEvent;
		$this->owner->trigger(SELF::EVENT_BEFORE_UNDO_DELETE, $beforeEvent);
		if ($beforeEvent->isValid) {
			$rules = $this->AREvents[ActiveRecord::EVENT_BEFORE_DELETE]; //test for exceptions
			if (empty($rules['attributes'])) {
				//attributes MUST be set for each event - trigger just a warning and proceed gracefully
				trigger_error("Attributes must be set for each event " . __METHOD__);
				return false; 
			} elseif (!is_array($rules['attributes'])) {
				//attributes MUST be an array - trigger just a warning and proceed gracefully
				trigger_error("Attributes must be an array " . __METHOD__);
				return false;
			} else {
				foreach ($rules['attributes'] as $attribute) {
					if ( $this->owner->hasAttribute($attribute) ) {
						$this->owner->$attribute = SELF::DEFAULT_NOT_DELETED;						
					}
				}
				if ( $this->owner->save(false) ) {
					$afterEvent = new ModelEvent;
					$this->owner->trigger(SELF::EVENT_AFTER_UNDO_DELETE, $afterEvent);
					return true;
					
				}
			}
		}
	}
    /***
     * Updates a timestamp attribute to the current timestamp.
     *
     * ```php
     * $model->touch('lastVisit');
     * ```
     * @param string $attribute the name of the attribute to update.
     * @throws InvalidCallException if owner is a new record (since version 2.0.6).
     */
    public function touch($attribute)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if ($owner->getIsNewRecord()) {
            throw new InvalidCallException('Updating the timestamp is not possible on a new record.');
        }
        $owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }
}
