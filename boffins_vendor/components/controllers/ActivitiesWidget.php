<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

class ActivitiesWidget extends Widget
{
	public $id;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('activities',[
        	'userid' => $this->id,
        ]);
    }
}
?>