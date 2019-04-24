<?php 

namespace boffins_vendor\classes;

use Yii;
use yii\db\ActiveQuery;



class BaseQuery extends ActiveQuery
{
	/**
	 * aray of interfaces the modelClass implements. 
	 */
	protected $modelImplementatons = [];
	
	/**
	 * the cid of this session. Only apply applies for classes that implement TenantSpecific. 
	 */
	protected $_cid = false;
	
	/**
	 * {@inheritdoc}
	 * 
	 * @details 
	 */
    public function init()
    {
        parent::init();
		
        $tableName = $this->modelClass::tableName();
		if ( in_array( "boffins_vendor\classes\models\TrackDeleteUpdateInterface", $this->getModelImplementations() ) ) {
			$this->andWhere(['or', ["{$tableName}.deleted" => 0], ["{$tableName}.deleted" => NULL] ]);
		}
		
		if ( in_array( "boffins_vendor\classes\models\TenantSpecific", $this->getModelImplementations() ) && !empty($this->getTenantID()) ) {
			$this->andWhere([ 'or', ["{$tableName}.cid" => $this->_cid], ["{$tableName}.cid" => NULL] ]);
		}
    }
	
	/** 
	 * @brief an array of interfaces the active record implements. 
	 * @return array.
	 * @future feels clunky. Refactor. 
	 */
	protected function getModelImplementations() 
	{
		if ( empty($this->modelImplementatons) ) {
			$this->modelImplementatons = class_implements($this->modelClass);
		}
		return $this->modelImplementatons;
	}
	
	/**
	 * @brief a getter for the tenantID property 
	 * @return string|int
	 * @details this currently only works when the application has a user and the user has an identity with a cid. 
	 * @future refactor to work in console applications or in situations where the user is not yet loaded or the identity is not set. 
	 */
	protected function getTenantID()
	{
		$this->_cid = Yii::$app->has('user') && !empty(Yii::$app->user->identity->cid) ? Yii::$app->user->identity->cid : false; 	//in console applications, you should simply add user 
		return $this->_cid;																//to the component list of the application 
	}
} 