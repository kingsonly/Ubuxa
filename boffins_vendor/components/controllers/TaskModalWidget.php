<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii; 

class TaskModalWidget extends Widget{
	
	public $model;
	public $reminder;
	public $users;
	public $label;
	public $taskLabel;
	public $edocument;
	public $folderId;

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('taskmodal',[
			'model' => $this->model,
			'reminder' => $this->reminder,
			'users' => $this->users,
			'label' => $this->label,
			'taskLabel' => $this->taskLabel,
			'edocument' => $this->edocument,
			'folderId' => $this->folderId,
		]);
	}
	
}


?>