<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii; 

class CreateReminderWidget extends Widget{
	
	public $reminder;
	public $id;
	public $reminderUrl;

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('createreminder',[
			'reminder' => $this->reminder,
			'id' => $this->id,
			'reminderUrl' => $this->reminderUrl,
		]);
	}
	
}


?>