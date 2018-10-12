<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\Task;


// Task widget is a widget which represent a section on the folder  dashboard which is responsible for the holding of users task and reminder
class TaskWidget extends Widget
{
	public $task;
    public $taskModel;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('task', [
        	'display' => $this->task,
            'taskModel' => $this->taskModel,
        	]);
    }
}
?>