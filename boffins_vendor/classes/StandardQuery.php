<?php 

namespace app\boffins_vendor\classes;

use Yii;

class StandardQuery extends BaseQuery
{
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