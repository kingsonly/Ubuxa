<?php

namespace boffins_vendor\classes;

use yii\base\Event;

/**
 * ActivityEvent represents the event triggered by BoffinsArRootModel which ActivityManager listens to.
 *
 */
class ActivityEvent extends Event
{
    /**
     * the BoffinsArRootModel event type that initiates this event. This usually correlates to a database action
	 * find, insert, update, delete some of which have been extended such as softdelete which is really an update 
     */
    public $modelAction = 'find';
	
	/***
	 *  the ActiveRecord phase - before or after in which this event is triggered. 
	 */
	public $eventPhase = 'after';
	
	/***
	 *  An additional array to contain dynamic parameters that a model may wish to pass. 
	 */
	public $additonalParams = [];
}
