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
use yii\db\ActiveQuery;
use boffins_vendor\classes\StandardQuery;
use frontend\models\FolderComponent;
use frontend\models\Clip;




class BoffinsArRootModel extends ActiveRecord
{
	
	/**
     * Initialise AR. 
	 * Respond to new Events defined in DeleteUpdateBehavior
	 * All child classes must call parent::init() if they override this function. 
	 */
	public $defaltBehaviour;
	
	public $ownerId;
	
	/*
	 * @array or string to list date values in the ARModel/Child class
	 */
	public $dateAttributes = array( 'last_updated' );
	
	

	
	public function init() 
	{
		 $this->on(DeleteUpdateBehavior::EVENT_BEFORE_SOFT_DELETE, [$this, 'beforeSoftDelete']);
		 $this->on(DeleteUpdateBehavior::EVENT_AFTER_SOFT_DELETE, [$this, 'afterSoftDelete']);
		 $this->on(DeleteUpdateBehavior::EVENT_BEFORE_UNDO_DELETE, [$this, 'beforeUndoDelete']);
		 $this->on(DeleteUpdateBehavior::EVENT_AFTER_UNDO_DELETE, [$this, 'afterUndoDelete']);
		 
		 
	}
	
	/* 
	 * Final function returns a merged array of the base behaviors and the custom behaviors created by user
	 * Function cannot be overridden by child classes. Use 'myBehaviors' to assign new behaviors
	 */
	final public function behaviors() 
	{
		return $this->_mergeBehaviours( $this->_baseBehaviors(), $this->myBehaviors() );		
	}
	
	/*
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
					trigger_error("Behavior type neither strig nor array? - " . __METHOD__, E_USER_ERROR );
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
	 */
	private function _classString($item) //returns the class name as stored in an array/string, however, 'className' is already taken 
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
			
			"dateValues" => [
				"class" => DateBehavior::className(),
			],
			'ClipOnBehavior' => ClipOnBehavior::className(),
			
			"deleteUpdateBehavior2" => DeleteUpdateBehavior::className(),
		];

	}

	
	public function myBehaviors() 
	{
		return array();
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function beforeSoftDelete() 
	{
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function afterSoftDelete() 
	{
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function beforeUndoDelete() 
	{
	}
	
	/***
	 * placeholder function - to be overridden by user as required.
	 */
	public function afterUndoDelete()
	{
	}
	
	public static function find() 
	{
		return new StandardQuery(get_called_class());
	}
	
	/***
	 * Get the type of a given attribute 
	 */
	public function getAttributeType($attribute)
	{
		return $this->hasAttribute($attribute) ? self::getTableSchema()->columns[$attribute]->type : trigger_error('This attribute ({$attribute}) does not exist: ' . $attribute . ' ' . __METHOD__);
	}
	
	/***
	 * basic before validate function for each component 
	 */
	public function beforeValidate()  
	{
		if ($this->hasAttribute('deleted') && $this->isNewRecord ) {
			$this->deleted = 0;
		}
		return parent::beforeValidate();
	}
	
	/***
	 * returns a list of the folders as a string. 
	 */ 
	public function specificClipsWithLimitAndOffset($limit=4,$offset=0,$ownerTypeId=2,$barId = 0)
    {
        return Clip::find()->select(['owner_id'])->where(['bar_id' => $barId])->andWhere(['owner_type_id' => $ownerTypeId])->asArray()->limit($limit)->offset($offset)->all();
		
		
    }
	
}