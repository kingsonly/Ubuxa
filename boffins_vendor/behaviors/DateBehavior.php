<?php
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace app\boffins_vendor\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\UnknownPropertyException;
use yii\db\ActiveRecord;
use yii\db\Expression;



/***********************IMPORTANT GUIDE!!!!!!!!!!!!!!!!!*************************
*********************************************************************************
	If a date attribute/variable in your model class never has a date class of 'DATE_CLASS_STAMP' in your behavior configuration but uses 'DATE_CLASS_STANDARD' throughout, 
	then in the database, it should be stored and structured as type 'Date' UNLESS the date attribute is set in a view using a date picker which includes  a time stamp 
	(but then, if this is what you need, then your variable in the model class probaby ought to be a 'DATE_CLASS_STAMP' at some point in your behavior configuration)
*********************************************************************************
*********************************************************************************/

class DateBehavior extends Behavior
{
	
	//VARIABLES/PROPERTIES
	/***
	 * @var array list of Events that this behaviour acts on - can be user defined. 
	 * Any event not listed in this array will be ignored by this behavior 
	 */
    public $AREvents = [];	
	
	/***
	 * integer or string to set if date is invalid
	 */
	public $zeroDateString = 0;
	
	/*
	 * Constant for Date Stamp Class
	 */
	const DATE_CLASS_STAMP = "stamp"; // treat as a date/time stamp of the moment the variable is saved. (NOW)
	
	/*
	 * Constant for Stanard Date Class
	 */
	const DATE_CLASS_STANDARD = "standard"; //treat as a set date/time value in the future or past
	
	/*
	 * Constant for General class for all other Date classes
	 */
	const DATE_CLASS_OTHER = "other";
	
	/*
	 * $settings used to manage users specific date settings 
	 * its a private class used only inside of the after find event to display and convert date based on users specifications
	 */
	
	private $settings ;
	
	//METHODS/FUNCTIONS
	
	/**
     * Set AREvents to default values if not set by owner model. 
     */
	public function init()
    {
        parent::init();
		$this->settings =  \Yii::$app->settingscomponent;
		
		//allow developer to select which events are handled and how
        if (empty($this->AREvents)) {
            $this->AREvents = [
						ActiveRecord::EVENT_BEFORE_VALIDATE => [ 'rules' => [
																			self::DATE_CLASS_STAMP => [
																					'attributes' => ['last_updated'],
																					]
																				] 
															],
						ActiveRecord::EVENT_AFTER_FIND => [ 'rules' => [
																			self::DATE_CLASS_STANDARD => [
																					'attributes' => ['last_updated'],
																					]
																				] 
															],
					];
        }
    }
	
	/**
     * Returns an array of Events contained in AREvents variable and sends them to the function evaluateEvents 
	 * to be evaluated
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
     * @param ModelEvent $event
     */
    public function evaluateEvents($event)
    {
		$dateRules = $this->_getRules($event, __METHOD__);
		switch ($event->name) {
			case ActiveRecord::EVENT_BEFORE_VALIDATE:
				$this->handleSendtoDB($event, $dateRules);
				break;
			case ActiveRecord::EVENT_AFTER_FIND:
				$this->handleAfterFind($event, $dateRules);
				break;
			case ActiveRecord::EVENT_BEFORE_INSERT:
				$this->handleSendtoDB($event, $dateRules);
				break;
			case ActiveRecord::EVENT_BEFORE_UPDATE:
				$this->handleSendtoDB($event, $dateRules);
				break;
			default:
				$this->handleOtherEvents($event, $dateRules); //need to create a handleOtherEvents() function. 
		}
	}
	
	/**
     * Chooses which format to use to send depending on the DB. Currently 
	 * only uses MySQL. Should be extended to include MongoDB and the rest. 
	 * @param ModelEvent $event the event passed down through the call. Is passed on to user defined functions if defined. 
	 * @param array $dateRules rules as set by the user. 
     */
	protected function handleSendtoDB($event, $dateRules) 
	{
		Yii::trace("Running send to DB {$event->name}", self::className() . '->handleSendtoDB' );
		$this->_formatForMYSQLDB($event, $dateRules); //prepare a check for DB types. 
	}
	
	/**
	 * Handles the ActiveRecord::EVENT_AFTER_FIND event 
	 * if user has provided a function to be run for this event, assigns the value of that 
	 * function to attributes to be monitored in this event 
	 * otherwise, it formats the date to d-m-Y which is standard format for Africa/Lagos time zones time
	 * @param ModelEvent $event 
	 * @param array $dateRules
	 */
	protected function handleAfterFindOld($event, $dateRules) 
	{
		Yii::trace('DateBehavior treating afterfind.');
		foreach( $dateRules as $class => $rule ) {
			foreach ( $rule['attributes'] as $attribute ) {
				if( !empty($rule['method']) && ( is_callable($method) || $this->owner->hasMethod($method) ) )  {
					$this->owner->$attribute = $this->owner->hasMethod($rule['method']) ? $this->owner->$rule['method']($event) : call_user_func($rule['method'], $event);
					continue; //skip the rest of this cycle of the loop
				}
				Switch ($class) {
					case self::DATE_CLASS_STAMP:
						Switch ( $this->owner->getTableSchema()->columns[$attribute]->type ) {
							case 'date':
								$this->owner->$attribute = date_create_from_format('Y-m-d', $this->owner->$attribute) ? date_format(date_create_from_format('Y-m-d', $this->owner->$attribute), 'd/m/Y') : $this->triggerDateCreationError($this->owner->$attribute . 'TWO' . $attribute, true); //this really should be a timestamp of NOW()
								break;
							case 'datetime':
								$this->owner->$attribute = date_create_from_format('Y-m-d H:i:s', $this->owner->$attribute) ? date_format(date_create_from_format('Y-m-d H:i:s', $this->owner->$attribute), 'd/m/Y (H:i:s)') : $this->triggerDateCreationError($this->owner->$attribute . 'THREE' . $attribute, true); //this really should be a timestamp of NOW()
								break;
							default:
								Yii::warning('Not a recognised date value: ' . __METHOD__ );
							}
							break;
					case self::DATE_CLASS_STANDARD:
						Switch ( $this->owner->getTableSchema()->columns[$attribute]->type ) {
							case 'date':
								$this->owner->$attribute = date_create_from_format('Y-m-d', $this->owner->$attribute) ? date_format(date_create_from_format('Y-m-d', $this->owner->$attribute), 'd/m/Y') : $this->triggerDateCreationError($this->owner->$attribute . 'FOUR' . $attribute, true); 
								break;
							case 'datetime':
								$this->owner->$attribute = date_create_from_format('Y-m-d H:i:s', $this->owner->$attribute) ? date_format(date_create_from_format('Y-m-d H:i:s', $this->owner->$attribute), 'd/m/Y (H:i:s)') : $this->triggerDateCreationError($this->owner->$attribute . 'FIVE' . $attribute, true);
								break;
							default:
								Yii::warning('Not a recognised date value: ' . __METHOD__ );
							}
							break;
					case self::DATE_CLASS_OTHER: 
						$this->owner->$attribute = Yii::$app->formatter->asDate($this->owner->$attribute, "php:d/m/Y"); 
						break;
					default:
						$this->owner->$attribute = Yii::$app->formatter->asDate($this->owner->$attribute, "php:d/m/Y"); 
				}
			}
		}
	}
	
	
	protected function handleAfterFind($event, $dateRules) 
	{
		Yii::trace('DateBehavior treating afterfind.');
		foreach( $dateRules as $class => $rule ) {
			foreach ( $rule['attributes'] as $attribute ) {
				if( !empty($rule['method']) && ( is_callable($method) || $this->owner->hasMethod($method) ) )  {
					$this->owner->$attribute = $this->owner->hasMethod($rule['method']) ? $this->owner->$rule['method']($event) : call_user_func($rule['method'], $event);
					continue; //skip the rest of this cycle of the loop
				}
				Switch ($class) {
					case self::DATE_CLASS_STAMP:
						$this->owner->$attribute = $this->settings->buffinsDate($this->owner->$attribute , $this->owner->getTableSchema()->columns[$attribute]->type);
							break;
					case self::DATE_CLASS_STANDARD:
						$this->owner->$attribute = $this->settings->buffinsDate($this->owner->$attribute , $this->owner->getTableSchema()->columns[$attribute]->type);
							break;
					case self::DATE_CLASS_OTHER: 
						$this->owner->$attribute = $this->settings->buffinsDate($this->owner->$attribute , $this->owner->getTableSchema()->columns[$attribute]->type);
						break;
					default:
						$this->owner->$attribute = $this->settings->buffinsDate($this->owner->$attribute , $this->owner->getTableSchema()->columns[$attribute]->type); 
				}
			}
		}
	}
		
	/*
	 * Private function to get rule for a given event
	 * This ensures basic rules are followed to prevent improper calls from users.
	 */
	private function _getRules($event, $handlerName) 
	{
			$rules = $this->AREvents[$event->name];
			if (empty($rules['rules'])) {
				//attributes MUST be set for each event - trigger just a warning and proceed gracefully
				Yii::warning("Rules must be set for each event {$handlerName}");
				return false; 
			} elseif (!is_array($rules['rules'])) {
				//Rules MUST be an array - trigger just a warning and proceed gracefully
				Yii::warning("Rules must be an array {$handlerName}");
				return false;
			} else {
				return $rules['rules'];
			}
	}
	
	/*
	 * function to format dates before they go to the database. 
	 * If user has provided a function to be run for this event, assigns the value of that 
	 * function to attributes to be monitored in this event 
	 * otherwise, it formats the date to Y-m-d which is MySQL standard format for Database time 
	 * currently only handles model attributes of 'date' and 'datetime' attributeTypes
	 * future extension to unix time stamps 
	 * @param ModelEvent $event the event passed down through the call. Is passed on to user defined functions if defined. 
	 * @param array $dateRules rules as set by the user. 
	 */
	private function _formatForMYSQLDB($event, $dateRules) 
	{
		$loopa = $loopb = 0;
		$attribute = '';
		foreach( $dateRules as $class => $rule ) {
			$loopa++;
			Yii::trace("{A:{$loopa} B:{$loopb} and class:{$class} and event:{$event->name} and att:{$attribute}");
			foreach ( $rule['attributes'] as $attribute ) {
				$loopb++;
				Yii::trace("{A:{$loopa} B:{$loopb} and class:{$class} and event:{$event->name} and att:{$attribute}");
				if ( $attribute == 'request_date' ) {
					Yii::trace("Started request_date {$class}");
				}
				
				if( !$this->owner->hasAttribute($attribute) ) {
					Yii::warning("This '{$attribute}' is not an attribute of the owner model.");
					continue; //error notice above does not interrupt script
				}
				
				if( !empty($rule['method']) && ( is_callable($rule['method']) || $this->owner->hasMethod($rule['method']) ) )  {
					$this->owner->$attribute = $this->owner->hasMethod($rule['method']) ? $this->owner->$rule['method']($event) : call_user_func($rule['method'], $event);
					continue; //skip the rest of this cycle of the loop
				}
				
				Switch ($class) {
					case self::DATE_CLASS_STAMP:
						Switch ( $this->owner->getTableSchema()->columns[$attribute]->type ) {
							case 'date':
								$this->owner->$attribute = date('Y-m-d');
								break;
							case 'datetime':
								$this->owner->$attribute = date('Y-m-d H:i:s');
								break;
							default:
								Yii::warning('Not a recognised date value: ' . __METHOD__ );
							}
						break;
					case self::DATE_CLASS_STANDARD: 
						Switch ( $this->owner->getTableSchema()->columns[$attribute]->type ) {
							case 'date':
								$this->owner->$attribute = date_create_from_format('d/m/Y', $this->owner->$attribute) ? date_format(date_create_from_format('d/m/Y', $this->owner->$attribute), 'Y-m-d') : 'do nothing for now';
								break;
							case 'datetime':
								Yii::warning("Database type of 'datetime' when attribute class is STANDARD. See guide. Reconsider class or database type. ({$attribute})");
								$this->owner->$attribute = date_create_from_format('d/m/Y H:i:s', $this->owner->$attribute) ? date_format(date_create_from_format('d/m/Y H:i:s', $this->owner->$attribute), 'Y-m-d H:i:s') : $this->triggerDateCreationError("{$this->owner->$attribute} ONE att:{$attribute} event:{$event->name} class:{$class} A:{$loopa} B:{$loopb}"  );
								break;
							default:
								Yii::warning('Not a recognised date value: ' . __METHOD__ );
							}
						break;
					case self::DATE_CLASS_OTHER: 
						$this->owner->$attribute = Yii::$app->formatter->asDate($this->owner->$attribute, "php:Y-m-d"); 
						break;
					default:
						$this->owner->$attribute = Yii::$app->formatter->asDate($this->owner->$attribute, "php:Y-m-d"); 
				}
			}
		}
	}
	
	private function triggerDateCreationError($additionalMsg, $forDisplay = false)
	{
		Yii::warning("Something went wrong. Unable to create this date. {$additionalMsg}", __METHOD__);
		Yii::trace("Set to {$this->zeroDateString}");
		return $forDisplay ? $this->zeroDateString : 0;
	}
}


