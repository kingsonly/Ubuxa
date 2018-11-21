<?php 

namespace boffins_vendor\classes\models;

use Yii;
use yii\db\ActiveQuery;


class BaseTenantQuery extends ActiveQuery
{
    public function init()
    {
		Yii::trace("I'm in use");
        parent::init();
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
		/*if ( $modelClass->hasMethod('managerTable') ) {
			$managerTable = $modelClass->managerTable;
			$this->join('INNER JOIN', $managerTable, "{$managerTable}.{$modelClass->managerForeignKey} = {$modelClass->managerColumn}");
			$this->andOnCondition(['user_id' => Yii::$app->user->identity->id]);
		}*/
		
		$this->andWhere(['or', ['deleted' => 0], ['deleted' => NULL] ]);
		$this->andWhere([ 'cid' => $this->getTenantID() ]);
    }
	
	/*private function _requiresManagers() 
	{
		Switch ($this->modelClass) {
			case '\app\models\Folder': 
				return true;
			case '\app\model\'
		}
	}*/
	
	public function getTenantID()
	{
		return Yii::$app->user->identity->cid;
	}
} 