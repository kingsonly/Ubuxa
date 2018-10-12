<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

/**
** this section holds sub-folder carosel widget and folder search form widget 
**
**
**
***********/
class SubFolders extends Widget
{

    public function init()
    {
        parent::init();
    }
	public $folderModel;
    public function run()
    {
       
        return $this->render('subfolders',[
			'folderModel' => $this->folderModel,
		]);
    }
}
?>