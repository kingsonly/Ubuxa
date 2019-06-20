<?php 

namespace boffins_vendor\classes;

use Yii;

class StandardQuery extends BaseQuery
{
	public $triggerEvents = true;
	/***
	 * @brief {@inheritdoc}
	 */
	public function init() 
	{
		parent::init();
		$modelClass = $this->modelClass;
		if ( $this->triggerEvents ) {
			$modelClass::beforeFind();
		}
	}

	/***
	 * @brief returns records that have been marked as deleted.
	 * @return ActiveRecord
	 */
    public function deleted()
    {
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->onCondition($tableName . '.deleted = :deleted',
								[
									':deleted' => 1
								]);
	}
	
	/***
	 * {{@inheritdoc}}
	 * @brief this overrides the yii core function createModels.
	 * 
	 * @return barrms.
	 * 
	 * @details the behavior of yii is untouched. This alters the value of triggerEvents variable in barrms.
	 * PS: please note the createModels() function is implemented in the ActiveQueryTrait not ActiveQuery class.
	 */
	protected function createModels($rows)
	{
		$modifiedModels = [];
		$models = parent::createModels($rows);
		if ( $this->triggerEvents === false && $models[0] instanceof BoffinsArRootModel ) {
			Yii::warning("Yes modifying models", "HERE");
			foreach ( $models as $model ) {
				$model->triggerEvent = false;
				$modifiedModels[] = $model;
			}
			return $modifiedModels;
		}
		return $models; //unmodified. 
	}

} 