<?php
/**
 * @copyright Copyright (c) 2019 Ubuxa (By Epsolun Ltd)
 */
 
namespace boffins_vendor\classes;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecordInterface;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;
use yii\base\InvalidCallException;
use yii\base\InvalidArgumentException;


/**
 * ModelCollection
 *
 * @authors - Originally written by Carsten Brandt <mail@cebe.cc>
 * @authors - Heavily modified by Anthony Okechukwu and Rustam Mamadaminov
 * @since 1.0
 */
class ModelCollection extends Collection
{
    /**
     * @var ActiveQuery|null the query that returned this collection.
     * May be`null` if the collection has not been created by a query.
     */
    public $query = null;
	
	/***
	 *  @var indicates that this collection must be based on a query ONLY. 
	 *  if the collection can use a mix of query and and dynamically added items
	 *  then you must set $queryString to false. 
	 */
	public $queryStrict = true;
	
	/***
	 *  set the model class this collection is for - if empty, any model will be accepted.
	 */
	public $acceptableModelClass = '';
	
	/**
     * Lazy evaluation of models, if this collection has been created from a query.
     */
    public function getData()
    {
		if ( $this->usesQuery() && empty($this->_items) ) { //check if getModels() is empty - 
																//note that models can return [] after query but is not null
			$this->_items = $this->queryAll(); //items are already empty so setItems won't throw an exception
			$c = count($this->_items);
			Yii::trace("ModelCollection was populated via query which returned {$c} items.");
        }
        return parent::getData();
    }
	
    /**
     * @return array|BaseActiveRecord[]|ActiveRecordInterface[]|Arrayable[] models contained in this collection.
     */
    public function getModels()
    {
        return $this->getData();
    }
	
    // TODO relational operations like link() and unlink() sync()
    // https://github.com/yiisoft/yii2/pull/12304#issuecomment-242339800
    // https://github.com/yiisoft/yii2/issues/10806#issuecomment-242346294
    // TODO addToRelation() by checking if query is a relation
    // https://github.com/yiisoft/yii2/issues/10806#issuecomment-241505294
    // https://github.com/yiisoft/yii2/issues/12743
    public function findWith($with)
    {
        if ( !$this->usesQuery() ) {
            throw new InvalidCallException('This collection was not created from a query, so findWith() is not possible.');
        }
        $this->query->findWith($with, $this->getModels());
        return $this;
    }

    /**
     *  @brief delete all models in the collection
     *  
     *  @return void
     */
    public function deleteAll()
    {
        foreach($this->getModels() as $model) {
            $model->delete();
        }
    }
	
    /**
     *  @brief change the scenario of the models
     *  
     *  @param [string] $scenario the new scenaario
     *  @return $this collection
     */
    public function scenario($scenario)
    {
        foreach($this->getModels() as $model) {
            $model->scenario = $scenario;
        }
        return $this;
    }
    /**
     * https://github.com/yiisoft/yii2/issues/13921
     *
	 * @param array $attributes
     * @param bool $safeOnly
     * @param bool $runValidation
     * @return ModelCollection
	 * TOD - trigger an event 
	 */
    public function updateAll($attributes, $safeOnly = true, $runValidation = true)
    {
        foreach($this->getModels() as $model) {
            $model->setAttributes($attributes, $safeOnly);
            $model->update($runValidation, array_keys($attributes));
        }
        return $this;
    }
	
	/***
	 * @brief  
	 *
     * @param array $attributes
     * @param bool $safeOnly
     * @param bool $runValidation
     * @return $this
     */
    public function insertAll($attributes, $safeOnly = true, $runValidation = true)
    {
        foreach ($this->getModels() as $model) {
            $model->setAttributes($attributes, $safeOnly);
            $model->insert($runValidation, array_keys($attributes));
        }
        return $this;
    }
	
	public function fillAll($attributes, $safeOnly = true)
    {
        foreach ($this->getModels() as $model) {
            $model->setAttributes($attributes, $safeOnly);
        }
        return $this;
    }
	
	public function loadModel($key, $attributes, $safeOnly = true)
	{
		$this->scenario('default');
		Yii::trace("Loading this model {$key} ");
		$models = $this->getModels();
		$model = $models[$key];
		$model->setAttributes($attributes, $safeOnly);
	}
	
	
    public function saveAll($runValidation = true, $attributeNames = null)
    {
        foreach ($this->getModels() as $model) {
            $model->save($runValidation, $attributeNames);
        }
        return $this;
    }
	
	public function saveModel($key, $runValidation = false, $attributeNames = null) 
	{
		Yii::trace("Saving this model {$key} ");
		$models = $this->getModels();
		$model = $models[$key];
		return $model->save($runValidation, $attributeNames);
		
	}
    /**
     * https://github.com/yiisoft/yii2/issues/10806#issuecomment-242119472
     *
     * @return bool
     */
    public function validateAll()
    {
        $success = true;
        foreach($this->getModels() as $model) {
            if (!$model->validate()) {
                $success = false;
            }
        }
        return $success;
    }
	
	public function validateModel($key)
	{
		$models = $this->getModels();
		$model = $models[$key];
		return $model->validate();
	}
    /**
     * @param array $fields
     * @param array $expand
     * @param bool $recursive
     * @return Collection|static
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true) 
    {
        return $this->map( function($model) use ($fields, $expand, $recursive) { //inline function
            /** @var $model Arrayable */
            return $model->toArray($fields, $expand, $recursive); 
        });
    }
    /**
     * Encodes the collected models into a JSON string.
     * @param int $options the encoding options. For more details please refer to
     * <http://www.php.net/manual/en/function.json-encode.php>. Default is `JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE`.
     * @return string the encoding result.
     */
    public function toJson($options = 320)
    {
        return Json::encode($this->toArray()->getModels(), $options); 
    }
	
	/*
	 *  @brief function to trigger the query if the model collection was built on a query
	 *  
	 *  @return ActiveRecord. An array of the models that match the query.. 
	 */
	private function queryAll()
    {
        if ($this->query === null) {
            throw new InvalidCallException('You need a query for this collection to be populated.');
        }
		
		//if the programmer does not set an index, the items in the model collection should be indexed using the model ID. 
		if ($this->query->indexBy === null) {
			$this->query->indexBy('id'); //if there is no 'id', ArrayHelper will use null
		}
		
        return $this->query->all();
    }
	
	/*private function _ensureModels()
    {
		if ( $this->usesQuery() && $this->_items === null ) { //check if getModels() is empty - 
																//note that models can return [] after query but is not null
			$this->setItems() = $this->queryAll(); //items are already empty so setItems won't throw an exception
        }
    }*/
	
	/**
	 *  @brief common function to check if this model collection strictly uses queries and actually has a query set at this point
	 *  
	 *  @return boolean
	 */
	public function usesQuery()
	{
		return $this->queryStrict ? !($this->query === null || $this->query === false) : false;
	}
	
	/***
	 *  @inheritdoc
	 *  
	 *  overriding to ensure that you cannot add an item when the collection is created through a query. 
	 */
	public function addItems( $items, $commonKey = '' )
	{
		if ( $this->usesQuery() ) {
			throw new InvalidCallException('This collection was created from a query. And you cannot add items to it.');
		}
		return parent::addItems($items, $commonKey);
	}
	
	/***
	 *  @inheritdoc
	 *  
	 *  overriding to ensure that you cannot add an item when the collection is created through a query. 
	 */
	public function addItem( $item, $key = '' )
	{
		if ( $this->usesQuery() ) {
			throw new InvalidCallException('This collection was created from a query. And you cannot add items to it.');
		}
		
		if ( ! $item instanceof Model ) {
			throw new InvalidArgumentException( "Argument 'item' must be a member of yii\base\Model " . static::className() ); 
		}
		
		if ( !empty($this->acceptableModelClass) && !($item instanceof $this->acceptableModelClass) ) {
			throw new InvalidArgumentException( "Argument 'item' must be a member of {$this->acceptableModelClass} " . static::className() ); 
		}
		return parent::addItem($item, $key);
	}
	

}