<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
?>


<?php 



class FolderUsersWidget extends Widget{
	public $attributues = [];

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('folderuserswidgetview',[
			'attributues' => $this->attributues,
		]);
	}
	
}


?>