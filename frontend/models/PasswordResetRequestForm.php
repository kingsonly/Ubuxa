<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use frontend\models\Email;

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
                'targetClass' => '\frontend\models\Email',
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
        /* @var $user User */
        $user = User::find()->joinWith('email')
    ->where(['address' => $this->address])
    ->all();

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->address)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
