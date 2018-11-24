<?php
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace boffins_vendor\behaviors;

use Yii;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\db\ActiveRecord;
use yii\db\Expression;


class TenantSpecificBehavior extends Behavior  
{
	//VARIABLES/PROPERTIES
	/***
	 * @var array list of Events that this behaviour acts on - can be user defined. 
	 * Any event not listed in this array will be ignored by this behavior 
	 */
    public $AREvents = [];
	
	private $_usingDefaultActions = false;
	
	public $tenantID = null;
     
    public function init()
    {
        parent::init();
				
		//allow developer to select which events are handled and how
        if (empty($this->AREvents)) {
			$this->_usingDefaultActions = true;
            $this->AREvents = [
                ActiveRecord::EVENT_BEFORE_INSERT => 'TSBHandleBeforeInsert',
				ActiveRecord::EVENT_AFTER_FIND => 'TSBHandleAfterFind' ,
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
		$return = $this->AREvents;
		if ( ! $this->_usingDefaultActions ) {
			foreach($AREvents as $event => $action ) {
				if ( is_callable($action) ) {
					$return[$event] = $action;
				}
			}
		}
		return $return;
    }
	
	/**
	 *  @brief Brief description
	 *  
	 *  @return Return description
	 *  
	 *  @details More details
	 */
	public function TSBHandleBeforeInsert() 
	{
		Yii::trace("Adding A Tenant ID");
		if ( $this->retrieveTenantID() !== false ) {
			if ( $this->owner->hasAttribute('cid') ) {
				$this->owner->cid = $this->retrieveTenantID();
			} else {
				Yii::warning("I cannot set a tenant ID on this component. Is this a model that has a tenant ID?");
				//throw exception here? This is not a must fail issue. If this is just wrongly applied, move on - warn the programmer.
				
			}
		} else {
			//throw an error here. This is a must fail scenario because the programmer is expecting an action that is not possible. 
			Yii::error("I cannot set a tenant ID. This may not be running on a web controller or the user is not logged in. Please supply a tenant ID from instantiation of this behavior or before insert.  ");
			//Yii::error is an exception I believe. 
		}
	}
	
	/**
	 *  @brief test to make sure this model (if it is a model) has the correct tenant id 
	 *  
	 *  @return void. However, it trigers warnings for non fail scenarios and triggers error for fail scenarios. 
	 *  
	 *  @details checks agains 7 scenarios.
	 *  1. this is either not a model or is a model without the correct tenant id (cid) attribute
	 *  2. the tenant id is empty
	 *  3. we're in a console application - no warning is given 
	 *  4. unless the tenant id is provided to the behavior in which case it tests other scenarios 
	 *  5. There is no user component in the application or 
	 *  6. the user component does not give an identity with a tenant id
	 *  7. The tenant id retrieved (supplied or retrieved from user identity) does not match the model's tenant id (cid)
	 */
	public function TSBHandleAfterFind()
	{
		if ( ! $this->owner->hasAttribute('cid') ) {
			Yii::warning("This base component is not a model with a tenant id attribute. Reconsider your application of this behaviour.");
			return;
		} 
		
		if ( empty($this->owner->cid) ) {
			Yii::warning("This model's tenant id is not set! ");
			return;
		}
		
		if ( (Yii::$app instanceof \yii\console\Application) && empty($this->tenantID)  ) {
			return; //we don't want clashes in console mode unless we have been given a tenant id to test against. 
		}
		
		if ( ! Yii::$app->has('user') || empty(Yii::$app->user->identity->cid) ) {
			Yii::error("This application does not have a user component or the identity does not have a tenant id.");
			return; 
		}
		
		if ( $this->owner->cid != $this->retrieveTenantID() ) {
			Yii::error("There is a problem. This tenant ID and the model's tenant ID simply do not match and this should not be possible.");
			//this line of code needs to be rewritten for multiple tenants' access to shared content. maybe have a test against shared ids. 
		}
	}
	
	/**
	 *  @brief retrieves a tenant id in this priority. 
	 *  
	 *  @return mixed - false|int|string(if tenant id structure changes in the future.)
	 *  
	 *  @details prefers a tenant id provided to the behaviour. 
	 *  failing that, will try to retrieve it from the  app user compoent's identity. 
	 *  if those two fail, then triggers a warning and returns false
	 */
	protected function retrieveTenantID()
	{
		//if user is a guest there is no need to retrieve tenant id and this function is also trigered when users are trying to create a new account .
		if (!Yii::$app->user->isGuest) {
			if ( !empty($this->tenantID) ) {
				Yii::trace("Or first place");
				return $this->tenantID;
			}

			if ( $this->tenantID === null && Yii::$app->has('user') && ! (Yii::$app->user->identity->cid === null) ) {
				Yii::trace("Retrieving it here?" . Yii::$app->user->identity->cid );
				$this->tenantID = Yii::$app->user->identity->cid;
				return $this->tenantID;
			}

			Yii::warning("Can't get a tenant id from user component");
			return false;
			//or throw an exception here?
		}else{
			//generate new  cid which would serve the relationship between a new customer and creating a new settings 
			
		}
		return true;
	}
}
