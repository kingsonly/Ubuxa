<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Component;
?>


<?php 
/*
* This Widget is exclusively related to the index page of every component
* it is a merging point between listview widget and view widget, 
* in the sense that it helps to render both widget on a single page via Javascript 
******************* Widget Usage *******************************************
* 	use app\boffins_vendor\components\controllers\DisplayComponentViewLayout;
*   <?= DisplayComponentViewLayout::widget(['model'=>$model,'id'=>$invoiceId,]); ?>
*/
class DisplayComponentViewLayout extends Widget{
	public $model; // component model
	public $viewAttributes;  
	public $listAttributes; 
	public $menuAttributes; 
	
	public $folderId; 
	public $componentId; 
	public $templateId; 
	/*
	this properties are presently not in use, but could be used in  the future
	*/
	
	
	/* 
	* this id helps to display the first component value in the 
	* database, and also help in indicating 
	* that a the perticular component has been selected.
	*/
	public $id; 
	
	 
	public function init()
	{
		parent::init();
		
	}
	
	
	public function run(){
		return $this->render('displaycomponentviewlayoutview',[
			'model' => $this->model,
			'viewAttributes' => $this->viewAttributes,
			'listAttributes' => $this->listAttributes,
			'menuAttributes' => $this->menuAttributes,
			'id' => $this->id,
			'folderId' => $this->folderId,
			'componentId' => $this->componentId,
			'templateId' => $this->templateId,
		]);
	}
	
	
}


?>


