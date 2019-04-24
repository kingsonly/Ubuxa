<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 * @author Anthony Okechukwu
 */

namespace boffins_vendor\classes;

use Yii;
use yii\base\BaseObject;
use boffins_vendor\classes\Tree\{NodeTrait, NodeInterface};

/**
 *  Activity message nodes hold critical data about sub activities which are held as messages/phrases. 
 *
 */
class ActivityMessageNode extends MessageConstruct implements NodeInterface
{
	use NodeTrait;

	/***
	 * contains details of the activity such as the activity object, the user id of the user who performed the activity etc.
	 * So that it is also possible to reconstitute the ActivityMessageNode in a completely different way. 
	 */
	public $activityDetails = [];

	
	/***
	 * @brief {@inheritdoc} //trait
	 */
	public function getValue() 
	{
		return $this->resolve();
	}

	/***
	 * @brief {@inheritdoc} //trait
	 * 
	 * @details sets this to an ActivityMessageNode 
	 */
	public function setValue($value)
	{
		throw new yii\base\InvalidCallException("You cannot set values for ActivityMessageNodes. You need to use addConstruct to construct a message");
	}
}