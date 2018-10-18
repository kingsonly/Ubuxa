<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii; 

class KanbanWidget extends Widget{
	
	public $task;
	public $dataProvider;
	public $id;
	public $reminder;
	public $taskStatus;
	public $users;
	public $taskAssignedUser;

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('kanban',[
			'task' => $this->task,
			'dataProvider' => $this->dataProvider,
			'id' => $this->id,
			'reminder' => $this->reminder,
			'taskStatus' => $this->taskStatus,
			'users' => $this->users,
			'taskAssignedUser' => $this->taskAssignedUser,
		]);
	}
	
}


?>