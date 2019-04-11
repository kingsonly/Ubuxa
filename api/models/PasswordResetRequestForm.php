<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\User;
use frontend\models\Email;
use frontend\models\UserDb;
use frontend\models\EmailEntity;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $address;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'email'],
            ['address', 'exist',
                'targetClass' => 'frontend\models\Email',
                //'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
		if (!$this->validate()) {

            Yii::$app->api->sendFailedResponse($this->errors);
            //return null;
        }
        /* @var $user User */
        $user = Email::find()
        ->where(['address' => $this->address])
        ->one();
		
        if (!isset($user->user)) {
            Yii::$app->api->sendFailedResponse($this->errors);
        }
        
        if (!UserDb::isPasswordResetTokenValid($user->user->password_reset_token)) {
            $user->user->generatePasswordResetToken();
            if (!$user->user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user->user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->address)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
