<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 */
namespace boffins_vendor\classes\models;


/**
 * This is an Interface to be implemented by classes (usually 'known classes') that exhibit a 
 * property 'nameString'. Thereby performing some level of predictability across these known classes. 
 */

Interface KnownClass 
{
	/***
	 *  each implementing class should provide a string value indicating a clear 
	 *  user friendly name
	 *  @example 
	 *  Class Man 
	 *  {
	 *  	$firstName = 'John';
	 *  	$lastName = 'Smith'l
	 *  	
	 *  	public function getNameString()
	 *  	{
	 *  		return $this->firstName . $this->lastName; 
	 *		}
	 *	 }
	 *  
	 */
	public function getNameString() : string;
}
