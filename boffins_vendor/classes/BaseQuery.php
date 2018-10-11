<?php 

namespace boffins_vendor\classes;

use Yii;
use yii\db\ActiveQuery;


class BaseQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
		/*if ( $modelClass->hasMethod('managerTable') ) {
			$managerTable = $modelClass->managerTable;
			$this->join('INNER JOIN', $managerTable, "{$managerTable}.{$modelClass->managerForeignKey} = {$modelClass->managerColumn}");
			$this->andOnCondition(['user_id' => Yii::$app->user->identity->id]);
		}*/
		
		$this->andWhere(['or', ['deleted' => 0], ['deleted' => NULL] ]);
    }
	
	/*private function _requiresManagers() 
	{
		Switch ($this->modelClass) {
			case '\app\models\Folder': 
				return true;
			case '\app\model\'
		}
	}*/
} 