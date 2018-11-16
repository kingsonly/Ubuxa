<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

class OnlineClients extends Widget
{
	public $taskStats;
	public $model;
	public $users;
	public $usersStat;
	public $allTasks;
	public $task;
	public $allUsers;
	public $folder;
	public $allFolders;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('onlineclients',[
        	'taskStats' => $this->taskStats,
        	'model' => $this->model,
        	'usersStat' => $this->usersStat,
        	'users' => $this->users,
        	'allTasks' => $this->allTasks,
        	'task' => $this->task,
        	'allUsers' => $this->allUsers,
        	'folder' => $this->folder,
        	'allFolders' => $this->allFolders,
        ]);
    }
}
?>