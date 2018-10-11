<?php 

namespace boffins_vendor\classes;

use Yii;

class ManagedQuery extends StandardQuery
{
	public function init()
	{
		parent::init();
		
		$model = $this->modelClass;
		$modelInstance = new $model;
		if ( method_exists($modelInstance, 'managerJunctionTable') ) {
			$managerJunctionTable = $model::managerJunctionTable();
			$id = Yii::$app->user->identity->id;
			$this->joinWith('componentManagers', true, 'INNER JOIN');
			$this->andOnCondition("{$managerJunctionTable}.user_id = {$id}");
		} else {
			Yii::warning("This ActiveQuery child class is for managed components/folders only");
		}		
	}
} 