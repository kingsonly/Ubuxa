<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
?>


<?php 



class ViewWithXeditableWidget extends Widget{
	public $model;
	public $url;
	
	public $attributues = [];

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('viewwithxeditablewidgetview',[
			'model' => $this->model,
			'attributues' => $this->attributues,
			'url' => $this->url,
		]);
	}
	
}


?>