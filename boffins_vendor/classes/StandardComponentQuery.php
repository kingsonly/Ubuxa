<?php 

namespace boffins_vendor\classes;

use Yii;
use yii\db\ActiveQuery;
use boffins_vendor\classes\BaseQuery;


class StandardComponentQuery extends BaseQuery
{
    public function init()
    {
        parent::init();
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
		$managerForeignKey = 'component_id';
		$managerColumn = 'id';
		$managerTable = "{{%component_manager}}";
		$this->join('INNER JOIN', $managerTable, "{$managerTable}.{$managerForeignKey} = {$managerColumn}");
		$this->andOnCondition(['user_id' => Yii::$app->user->identity->id,'cid' => Yii::$app->user->identity->cid]);
		
		
		
    }
	
} 