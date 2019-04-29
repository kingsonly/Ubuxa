<?php

namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\ChatNotification;

/**
** This widget is the skeletal representation of the Chat Notification section
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
class ChatNotificationWidget extends Widget
{
	
    public function init()
    {
        parent::init();
    }

    public function run()
    {
		$model = new ChatNotification();
        return $this->render('chatnotification',[
			'model'=>$model,
		]);
    }
}
?>