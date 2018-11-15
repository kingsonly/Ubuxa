<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\Supplier;

class SupplierWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('supplierComponentView',[
        	'supplierModel' => $this->remarkModel,
        ]);
    }
}
?>