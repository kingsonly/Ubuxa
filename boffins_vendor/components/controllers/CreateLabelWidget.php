<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii; 

class CreateLabelWidget extends Widget{
	
	public $id;
	public $taskid;
	public $label;
	public $taskLabel;

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('createtasklabel',[
			'id' => $this->id,
			'taskid' => $this->taskid,
			'label' => $this->label,
			'taskLabel' => $this->taskLabel,
		]);
	}
	
}


?>