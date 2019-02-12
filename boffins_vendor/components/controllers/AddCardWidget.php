<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;


// Task widget is a widget which represent a section on the folder  dashboard which is responsible for the holding of users task and reminder
class AddCardWidget extends Widget
{
	public $statusid;
    public $id;
    public $taskModel;
    public $parentOwnerId;
    public $location;
    
    public function init()
    {
        parent::init();
    }

    public function run()
    {
         // Register AssetBundle
        return $this->render('addtaskcard', [
        	'statusid' => $this->statusid,
            'taskModel' => $this->taskModel,
            'id' => $this->id,
            'parentOwnerId' => $this->parentOwnerId,
            'location' => !empty($this->location)?$this->location:'folder',
        	]);
    }
}
?>