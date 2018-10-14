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
	// output the outcome of loopmenu
	public function run(){
		
		return $this->render('foldercarouselwidgetview',[
			'folderModel' => $this->folderModel,
			'displayType' => $this->displayType,
			'height' => $this->height,
			
		]);
	}
	
	

	
}


?>
