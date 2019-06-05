<?php

namespace api\models;

use Yii;
use yii\base\Model;


class ChatNotificationEmail extends Model
{
	
	public function sendEmail($msgArray,$customerEmail)
    {
        return Yii::$app->mailer->compose(['html' => 'chatmsg'],
                [
                    'msgArray'  => $msgArray,
                ])
            ->setTo($customerEmail)
            ->setFrom(['support@ubuxa.net' => 'Ubuxa.net'])
            ->setSubject('Ubuxa (Chat notification)')
            ->send();
    }


   
}
