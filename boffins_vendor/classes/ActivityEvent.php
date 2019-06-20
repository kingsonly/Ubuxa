<?php

namespace boffins_vendor\classes;

use yii\base\Event;

/**
 * ActivityEvent represents the event triggered by BoffinsArRootModel which ActivityManager listens to.
 *
 */
class ActivityEvent extends Event
{

	/***
	 * constant for the event phase.
	 */
	const ACTIVITY_EVENT_PHASE_BEFORE = 'before';

	/***
	 * constant for the event phase.
	 */
	const ACTIVITY_EVENT_PHASE_AFTER = 'after';
	
    /**
     * the BoffinsArRootModel event type that initiates this event. This usually correlates to a database action
	 * find, insert, update, delete some of which have been e;xtended such as softdelete which is really an update 
     */
    public $modelAction = 'find';
	
	/***
	 *  the ActiveRecord phase - before or after in which this event is triggered. 
	 */
	public $eventPhase = self::ACTIVITY_EVENT_PHASE_AFTER;
	
	/***
	 *  An additional array to contain dynamic parameters that a model may wish to pass. 
	 */
	public $additionalParams = [];
}
