<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;


// Task widget is a widget which represent a section on the folder  dashboard which is responsible for the holding of users task and reminder
class TaskWidget extends Widget
{
    public $task;
	public $tasks;
    public $id;
    public $taskModel;
    public $parentOwnerId;
    public $onboarding;
    public $onboardingExists;
    public $userId;
	
    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('task', [
            'display' => $this->task,
        	'tasks' => $this->tasks,
            'taskModel' => $this->taskModel,
            'id' => $this->id,
            'parentOwnerId' => $this->parentOwnerId,
            'onboarding' => $this->onboarding,
            'onboardingExists' => $this->onboardingExists,
            'userId' => $this->userId,
        	]);
    }
}
?>