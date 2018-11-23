<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 * 
 * THIS IS REDUNDANT 
 *******************NOT IN USE****************
 * FOUND A MORE EFFECTIVE WAY TO DO THIS
 */
namespace boffins_vendor\classes\models;



/**
 * This is an Interface that defines the basic functions any class will need to be sortable in a grid or between members/instances.
 */

Interface ValueSortable extends Sortable
{
	/**
	 *  @brief returns the field of the class with which you can make a comparison
	 *  
	 *  @return the sortable field
	 *  @example
	 *  class example {
	 *  	$public var1;
	 *  	$public total; //the sortable field 
	 *  	
	 *  	public function getSortField() {
	 *  		return $total;
	 *		}
	 *  }
	 */
	public function getSortField();
	
	
	public function getSortValue();
}
