<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;


// Task widget is a widget which represent a section on the folder  dashboard which is responsible for the holding of users task and reminder
class ViewEdocumentWidget extends Widget
{   
    public $edocument;
    public $searchMargin;
    public $target;
	public $forFolder;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('edocumentdisplay',[
            'edocument' => $this->edocument,
            'searchMargin' => $this->searchMargin,
            'target' => $this->target,
            'forFolder' => $this->forFolder,
        	]);
    }
}
?>