<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii; 

class KanbanWidget extends Widget{
	
	public $task;
	public $model;
	public $dataProvider;
	public $id;
	public $reminder;
	public $taskStatus;
	public $users;
	public $taskAssignedUser;
	public $folderId;
	public $label;
	public $taskLabel;

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		$this->folderId = $this->id;
		return $this->render('kanban',[
			'task' => $this->task,
			'model' => $this->model,
			'dataProvider' => $this->dataProvider,
			'id' => $this->id,
			'reminder' => $this->reminder,
			'taskStatus' => $this->taskStatus,
			'users' => $this->users,
			'taskAssignedUser' => $this->taskAssignedUser,
			'folderId' => $this->folderId,
			'label' => $this->label,
			'taskLabel' => $this->taskLabel,
		]);
	}
	
}


?>