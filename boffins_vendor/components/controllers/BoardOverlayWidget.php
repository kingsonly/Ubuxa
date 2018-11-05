<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii; 

class BoardOverlayWidget extends Widget{
	
	public $id;
	public $taskids;

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('assigneeview',[
			'id' => $this->id,
			'taskids' => $this->taskids,
		]);
	}
	
}


?>