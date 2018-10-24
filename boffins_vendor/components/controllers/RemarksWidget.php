<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\Remark;

class RemarksWidget extends Widget
{
	public $remarkModel;
	public $parentOwnerId;
	public $remarks;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('remarks',[
        	'remarkModel' => $this->remarkModel,
        	'parentOwnerId' => $this->parentOwnerId,
        	'remarks' => $this->remarks,
        ]);
    }
}
?>