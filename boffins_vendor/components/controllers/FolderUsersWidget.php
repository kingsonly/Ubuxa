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
	

	public function init()
	{
		parent::init();
		
	}
	
	
	public function run(){
		return $this->render('folderuserswidgetview',[
			'attributues' => $this->attributues,
			'removeButtons' => $this->removeButtons,
		]);
	}
	
}


?>