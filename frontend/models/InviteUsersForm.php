<?php

namespace frontend\models;

use Yii;
use yii\base\Model;


/**
 * ContactForm is the model behind the contact form.
 */
class InviteUsersForm extends Model
{
    public $email;
    public $subject;
    public $body;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email', 'subject', 'body', 'role'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        $cid = Yii::$app->user->identity->cid;
        $tests = $this->email;
        foreach ($tests as $test) {
           $sendTest = Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . 'robot'])
            ->setSubject("Ubuxa Invite")
            ->setTextBody("Hello, you have been invited to join an ubuxa's workspace.Click join to confirm".\yii\helpers\Html::a('JOIN',
                Yii::$app->urlManager->createAbsoluteUrl(
                ['site/signup','email'=> $test,'cid'=>$cid,'role' => $this->role]
                ))
                )
            ->send();
        }
        
        return $sendTest;
    }

}
