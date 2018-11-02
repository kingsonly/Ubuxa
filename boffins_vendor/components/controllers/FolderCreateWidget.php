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
** Folder create widget is designed to be used in any part of the ubuxa app, it holds a form which is used for 
** the creation of folders 
****************************************Usage ******************************
**** use boffins_vendor\components\controllers\FolderCreateWidget;
** <?= FolderCreateWidget::widget(['folderModel' => $folderModel]) ?>
********************************/
class FolderCreateWidget extends Widget{
	
	public function init()
	{
		parent::init();
	}
	private $folderModel; // hold instance of folder model 
	public $folderPrivacy; // Used to check if a folder is private or not
	public $refreshSectionElement; // holds the id of the div or section to be refreshed after creation
	
	public function run(){
		$this->folderModel = new Folder();
		return $this->render('foldercreatewidgetview',[
			'folderModel' => $this->folderModel,
			'folderPrivacy' => $this->folderPrivacy,
			'pjaxId' => $this->refreshSectionElement,
		]);
	}
	
}


?>
