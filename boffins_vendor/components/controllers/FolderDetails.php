<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

class FolderDetails extends Widget
{

    public function init()
    {
        parent::init();
    }
	public $model;

    public function run()
    {
         // Register AssetBundle
        return $this->render('folderdetails',['model'=>$this->model]);
    }
}
?>