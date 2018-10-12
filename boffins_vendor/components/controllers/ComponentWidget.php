<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;

/**
** This widget is the skeletal representation of the users component section
** 
**
**
**
**
**
**
**
**
**
**
*************/
class ComponentWidget extends Widget
{
	public $users;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
         
        return $this->render('components',['users'=>$this->users]);
    }
}
?>