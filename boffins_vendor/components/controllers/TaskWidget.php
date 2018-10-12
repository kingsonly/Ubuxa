<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\Task;

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