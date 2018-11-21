<?php 

namespace boffins_vendor\classes\models;

use Yii;

class StandardTenantQuery extends BaseTenantQuery
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