<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii; 

class AssigneeViewWidget extends Widget{
	
	public $users;
	public $taskid;
	public $attributues;
	public $assigneeId;

	public function init()
	{
		parent::init();
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('assigneeview',[
			'users' => $this->users,
			'taskid' => $this->taskid,
			'attributues' => $this->attributues,
			'assigneeId' => $this->assigneeId,
		]);
	}
	
}


?>