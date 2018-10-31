<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Folder;

?>


<?php 

/**
** FolderCarouselWidget was design with the aim to hold subfolders which are inside a root folder 
********************************** Usage ********************************************************
** use boffins_vendor\components\controllers\FolderCarouselWidget;
** <?= FolderCarouselWidget::widget(['folderModel' => $folderModel]) ?>
****************/

class FolderCarouselWidget extends Widget{
	
	public function init()
	{
		parent::init();
	}
	
	public $folderModel;
	public $displayType;
	public $height;
	public $numberOfDisplayedItems;
	public $htmlAttributes;
	public $folderCarouselWidgetAttributes;
	// output the outcome of loopmenu
	public function run(){
		$numberOfDisplayedOfItems = !empty($this->numberOfDisplayedItems)?$this->numberOfDisplayedItems:3;
		
		return $this->render('foldercarouselwidgetview',[
			'folderModel' => $this->folderModel,
			'displayType' => empty($this->displayType)?'folders-carocel-js':$this->displayType,
			'height' => $this->height,
			'numberOfDisplayedItems' => $numberOfDisplayedOfItems,
			'htmlAttributes' => $this->htmlAttributes,
			'folderCarouselWidgetAttributes' => $this->folderCarouselWidgetAttributes,
			
		]);
	}
	
	

	
}

?>
