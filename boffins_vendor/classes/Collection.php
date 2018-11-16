<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 */

namespace boffins_vendor\classes;

use Yii;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Countable;
use yii\base\Component;
use yii\base\StaticInstanceInterface;
use yii\base\Arrayable;
use yii\base\StaticInstanceTrait;
use yii\base\ArrayableTrait;
use yii\base\ArrayAccessTrait;
use yii\base\InvalidCallException;
use yii\base\InvalidArgumentException;

/**
 * This is an Special class to collect a set of objects. 
 * This is a read/write collection. However, a warning is triggered when trying to 'manualy' set the items. 
 * It uses an array (associative or not)
 */
class Collection extends Component implements StaticInstanceInterface, IteratorAggregate, ArrayAccess, Arrayable, Countable
{
	use ArrayableTrait;
	use ArrayAccessTrait;
    use StaticInstanceTrait;

	/*
	 * array that holds the actual items   
	 */
	protected $_items;
	
	/***
	 *  @brief constructor 
	 *  
	 *  @param $items = the items you want in the collection. You can start with an empty collection 
	 *  and add items one at a time. 
	 *  @param $config = configuration variable. As per Yii's format for classes that extend from BaseObject, 
	 *  you can use $config to set public variables of the class.
	 */
	public function __construct(array $items = [], $config = [])
    {
        $this->_items = $items;
        parent::__construct($config);
    }
	
	/***
	 *  @brief returns the data held in the collection. 
	 *  This is a simple getter.
	 *  
	 *  @return array of items in the collection. 
	 */
	public function getItems() 
	{
		if ( empty($this->_items) ) {
			Yii::trace("This collection is empty. " . static::className() );
		}			
		return $this->_items;
	}
	
	/**
	 *  @brief next two properties created in the hope that they fulfil the requirements necessary 
	 *  to use ArrayableTrait
	 */
	public function getData()
	{
		return $this->getItems();
	}
	
	public function setData($data)
	{
		$this->setItems($data);
	}
	
	/***
	 *  @brief mass assign all the items you want into the collection 
	 *  so they act like a collection now. 
	 *  
	 *  @param [array] $items you want to set
	 *  @return mixed. the array you just set lol. Or false if the function failed. 
	 *  
	 *  @details If the collection is not empty, or the argument provided is not an array, or it is empty, 
	 *  this triggers an error and asks you to use the correct function instead
	 */
	public function setItems($items) 
	{
		if ( !empty($this->_items) ) {
			throw new InvalidCallException( "You can not reset the items in a collection. You can refresh and then addItem or  addItems " . static::className() );
		}
		
		if ( !is_array($items) ) {
			throw new InvalidArgumentException( "You can only mass assign an array to a collection. If you want a mixed collection, use  addItem." . static::className() ); 
		}
		
		if ( empty($items) ) {
			throw new InvalidCallException( "To clear items, use emptyCollection() " . static::className() );
		}
		
		$this->_items = $items;
	}
	
	
	/***
	 *  @brief function to add an item to the collection
	 *  
	 *  @param [mixed] $item the item to add to the collection
	 *  @param [string|integer] $key a key to use to access the item.
	 *  @return the collection
	 */
	public function addItem($item, $key = '')
	{
		if ( empty($key) ) {
			$this->_items[] = $item;
			return $this;
		} else {
			if ( is_string($key) || is_integer($key) ) {
				$this->_items[$key] = $item;
				return $this;
			}
			throw new InvalidArgumentException( "Second Argument 'key' must be string or integer" . static::className() ); 
		}
	}
	
	/***
	 *  @brief add an iteratable object to the collection
	 *  
	 *  @param [array|collection|Object instanceof Traversable] $items has to be an iteratable variable
	 *  @param [string|integer] a key  to place all the items under. 
	 *  @return the collection
	 *  
	 *  @details $items must be iterable i.e. implements, Traversable/IteratorAggregate (PHP 7>=7.1)
	 */
	public function addItems( $items, $commonKey = '' )  
	{
		$traversable = false;
		if ( ! function_exists('is_iterable') ) {
			if ( is_array($items) || (is_object($items) && $items instanceof Traversable ) ) {
				$traversable = true;
			}
		} elseif ( is_iterable($items) ) {
			$traversable = true;
		}
		
		if ($traversable) {
			foreach ($items as $singleItem) {
				$this->addItem($singleItem, $commonKey);
			}
			return $this;
		}
		
		throw new InvalidArgumentException( "Argument one, 'items', must be traversable. Arrays, collections or objects implementing Traversable" . static::className() ); 
	}
	
	/**
	 *  @brief remove a single item from the collection
	 *  
	 *  
	 *  @param [integer|string] $key requires a key to remove the item from the collection 
	 *  @return the collection
	 *  @detail throws an exception if the key does not exist or key provided is not an integer or string. 
	 */
	public function removeItem($key) 
	{
		if( is_string($key) || is_integer($key) ) {
			if ( array_key_exists( $key, $this->getItems() ) ) {
				unset( $this->_item[$key] );
				return $this;
			}
			throw new InvalidArgumentException( "This key does not exist in this collection" . static::className() ); 
		} else {
			throw new InvalidArgumentException( "Argument 'key' must be string or integer" . static::className() ); 
		}
		
	}
	
	/**
	 *  @brief tell if the collection is empty. 
	 *  
	 *  @return boolea
	 */
	public function isEmpty() 
	{
		return empty($this->getItems());
	}
	
	/***
	 *  @brief function to retrieve all the values of the items in the collection
	 *  without the keys. (is this useful?)
	 *  
	 *  @return collection. values of the items in the collection
	 */
	public function values()
    { 
        return new static( array_values($this->getItems()) );
    }
	
	/**
	 *  @brief function to retrieve the keys of the items in the collection
	 *  
	 *  @return collection the keys of the original collection
	 */
	public function keys()
    {
        return new static(array_keys($this->getItems()));
    }
	
	/**Run a function/callback against all items in the collection.
     *
     * The original collection will not be changed, a new collection with modified data is returned.
     * @param $function the callback function to apply. Signature: `function($model)`.
     * @return static a new collection with items returned from the callback.
     */
    public function map($function)
    {
        array_map($function, $this->getItems());
		return $this;
    }
}