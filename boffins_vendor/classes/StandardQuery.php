<?php 

namespace boffins_vendor\classes;

use Yii;

class StandardQuery extends BaseQuery
{
	/***
	 * @brief {@inheritdoc}
	 */
	public function init() 
	{
		parent::init();
        $modelClass = $this->modelClass;
		$modelClass::beforeFind();
	}

    public function deleted()
    {
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->onCondition($tableName . '.deleted = :deleted',
								[
									':deleted' => 1
								]);
    }
} 