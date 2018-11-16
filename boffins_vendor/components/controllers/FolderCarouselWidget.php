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
	
	public $folderModel; // this property is used to hold model instance for creation form 
	public $model; //  folder model, this would need to be change to accomodate the new structure 
	public $displayType; // how the carousel should be displayed 
	public $height; // attributes height
	public $numberOfDisplayedItems;
	public $htmlAttributes;// widhet html attributes
	public $createFormWidgetAttribute; // form widget attributes
	public $folderCarouselWidgetAttributes; // forlder carousel widget attributes
	public $folderId; // this propoerty is only usefull for component, to hold folder id, which would be used to fetch component of a specific folder
	
	public function init()
	{
		/* return empty string if form propertise are not set */
		if(!isset($this->createFormWidgetAttribute['folderPrivacy'])){
			$this->createFormWidgetAttribute['folderPrivacy'] = '';// form private forlder
		}
		
		if(!isset($this->createFormWidgetAttribute['formId'])){
			$this->createFormWidgetAttribute['formId'] = ''; // form form id
		}
		
		if(!isset($this->createFormWidgetAttribute['refreshSectionElement'])){
			$this->createFormWidgetAttribute['refreshSectionElement'] = ''; // form refresh html  element
		}
		
		if(!isset($this->createFormWidgetAttribute['formAction'])){
			$this->createFormWidgetAttribute['formAction'] = ''; // form action 
		}
		
		parent::init();
	}
		
	public function run()
	{
		$numberOfDisplayedOfItems = !empty($this->numberOfDisplayedItems)?$this->numberOfDisplayedItems:3;
		return $this->render('foldercarouselwidgetview',[
			'folderModel' => $this->folderModel,
			'displayType' => empty($this->displayType)?'folder':$this->displayType,
			'height' => $this->height,
			'numberOfDisplayedItems' => $numberOfDisplayedOfItems,
			'htmlAttributes' => $this->htmlAttributes,
			'folderCarouselWidgetAttributes' => $this->folderCarouselWidgetAttributes,
			'createForm' => $this->createFormWidgetAttribute,
			'model' => $this->model,
			'folderId' => $this->folderId,
			
		]);
	}
	
	

	
}

?>
