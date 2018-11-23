<?php 

namespace boffins_vendor\classes;

use Yii;
use yii\db\ActiveQuery;



class BaseQuery extends ActiveQuery
{
	
	protected $modelImplementatons = [];
	
	protected $_cid = false;
	
    public function init()
    {
        parent::init();
		
        $tableName = $this->modelClass::tableName();
		if ( in_array( "boffins_vendor\classes\models\TrackDeleteUpdateInterface", $this->getModelImplementations() ) ) {
			$this->andWhere(['or', ["{$tableName}.deleted" => 0], ["{$tableName}.deleted" => NULL] ]);
		}
		
		if ( in_array( "boffins_vendor\classes\models\TenantSpecific", $this->getModelImplementations() ) && $this->_cid !== false ) {
			$this->andWhere([ 'or', ["{$tableName}.cid" => $this->getTenantID()], ["{$tableName}.cid" => NULL] ]);
		}
    }
	
	protected function getModelImplementations() 
	{
		if ( empty($this->modelImplementatons) ) {
			$this->modelImplementatons = class_implements($this->modelClass);
		}
		return $this->modelImplementatons;
	}
	
	protected function getTenantID()
	{
		$this->_cid = Yii::$app->has('user') ? Yii::$app->user->identity->cid : false; 	//in console applications, you should simply add user 
		return $this->_cid;																//to the component list of the application 
	}
} 