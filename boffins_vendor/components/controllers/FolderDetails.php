<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

class FolderDetails extends Widget
{
/**
**  This wiget represents a section in the folder dashboard of ubuxa
**  it holds the editable content of folder such as folder title , folder descriptio  etc 
*************************/
    public function init()
    {
        parent::init();
    }
	public $model;
	public $url;

    public function run()
    {
         // Register AssetBundle
        return $this->render('folderdetails',['model'=>$this->model,'url'=>$this->url]);
    }
}
?>