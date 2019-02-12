<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
?>


<?php 


/**
** This widget is used to display all users who has access to a perticular folder
**
**
**
**
************/
class FolderUsersWidget extends Widget{
	public $attributues = [];
	public $removeButtons;
	public $id;
	public $listOfUsers; // this are users that would show on the drop down ;
	public $addUsersUrl;//  this is a url which would be used to add users.
	public $type;//  could be folder remarks,component, as the case may be 
	public $pjaxId;//  could be folder remarks,component, as the case may be 
	
	
	
	
	public function init()
	{
		parent::init();
		
	}
	
	
	public function run(){
		return $this->render('folderuserswidgetview',[
			'attributues' => $this->attributues,
			'removeButtons' => $this->removeButtons,
			'id' => $this->id,
			'listOfUsers' => $this->listOfUsers,
			'addUsersUrl' => $this->addUsersUrl,
			'type' => $this->type,
			'pjaxId' => !empty($pjaxId)?$pjaxId:'userjax',
			
		]);
	}
	
}


?>