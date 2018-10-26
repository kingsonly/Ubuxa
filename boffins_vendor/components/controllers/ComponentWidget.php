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
	public $components;
	public $otherAttributes;
	public $id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
         $height = !empty($this->otherAttributes['height'])?$this->otherAttributes['height']:'';
        return $this->render('components',[
			'users'=>$this->users,
			'components'=>$this->components,
			'id'=>$this->id,
			'height'=>$height,
		]);
    }
}
?>