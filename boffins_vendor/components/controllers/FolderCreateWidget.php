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
	
	public $folderModel; // hold instance of folder model 
	public $folderPrivacy; // Used to check if a folder is private or not
	public $refreshSectionElement; // holds the id of the div or section to be refreshed after creation
	public $formAction; // this makes it possible to use the form for defferent scenerio eg for both folders and components
	public $formId; // holds the id of form, this is done to make the form used multiple times on a single page 
	public $creationType; // this property is used to determine if a user wants to create a folder or a component
	public $newFolderCreated; // this property is used to determine if a user is new and does not have folder, so the folder create widget will redirect.
	public $placeHolderString; // use to make placeholder readable
	public function init()
	{
		// if formId is not set by a user, give a default id 
		if(empty($this->formId)){
			$this->formId = 'create-widget-id'; 
		}
		
		// if creation type is empty by default creation type should be folder 
		if(empty($this->creationType)){
			$this->creationType = 'folder'; 
		}
		// note folderModel is === active form formModel and if its empty by default folder is used  
		if(empty($this->folderModel)){
			$this->folderModel = new Folder();
		}
		parent::init();
	}
	
	public function run()
	{
		
		return $this->render('foldercreatewidgetview',[
			'folderModel' => $this->folderModel,
			'folderPrivacy' => $this->folderPrivacy,
			'pjaxId' => $this->refreshSectionElement,
			'formId' => $this->formId,
			'formAction' => $this->formAction,
			'creationType' => $this->creationType,
			'newFolderCreated' => $this->newFolderCreated,
			'placeHolderString' => !empty($this->placeHolderString)?$this->placeHolderString:'a new ',
		]);
	}
	
}


?>
