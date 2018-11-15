<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 */
namespace boffins_vendor\classes\models;


/**
 * This is an Interface strictly for value objects from attribute objects. 
 * it defines the basic functions a Value Class must implement to perform it basic value role.
 */

Interface ValueInterface 
{
	/***
	 *  each implementing class should provide a string value of the core value presented by the class
	 */
	public function stringValue() : string;
	
	/***
	 * each implementing class must be able to provide a formatted value
	 * an implementing class may use it's default, the app default or a format provided by the client/whoever called for it.
	 * @param $externalFormat - a 'sprintf' valid format 
	 * @param $paramsToExtract - values you would like to extract from the string;
	 */
	public function formattedStringValue($externalFormat = '', $paramsToInject = []) : string;
	
	/**
	 *  @brief each Value Type should implement a public setter and getter for the $value property.  
	 *  as some values may be useless to the user. For instance an id to a currency for ValueKnownClass.
	 */
	public function getValue();
	public function setValue($value);
	
	public function metaValue();
	
	
}
