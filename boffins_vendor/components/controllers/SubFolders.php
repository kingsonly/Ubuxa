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
	public $htmlAttributes;
	public $folderCarouselWidgetAttributes;
	public $createButtonWidgetAttributes;
	
    public function run()
    {
       
        return $this->render('subfolders',[
			'folderModel' => $this->folderModel,
			'htmlAttributes' => $this->htmlAttributes['class'],
			'folderCarouselWidgetAttributes' => $this->folderCarouselWidgetAttributes,
			'createButtonWidgetAttributes' => $this->createButtonWidgetAttributes,
		]);
    }
}
?>

