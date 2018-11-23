<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 */

namespace boffins_vendor\classes\models;


use boffins_vendor\classes\BoffinsARRootModel;
use yii\db\ActiveQuery;


/**
 * This is an ActiveRecord class strictly for value objects from attribute objects. 
 *
 */
class ValueARModel extends BoffinsARRootModel
{
	/*
	 *  protected property to use for public getter/setter value properties. 
	 *  of each child class
	 */
	protected $_usefulValue = null;
	
	public static function find()
	{
		return new ActiveQuery(get_called_class());	
	}
}