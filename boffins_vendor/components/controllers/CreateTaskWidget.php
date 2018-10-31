<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
?>


<?php 



class CreateTaskWidget extends Widget{
	public $attributes = [];

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('createtask',[
			'attributues' => $this->attributes,
		]);
	}
	
}


?>