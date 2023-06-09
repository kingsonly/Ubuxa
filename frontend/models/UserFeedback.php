<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%user_feedback}}".
 *
 * @property int $id
 * @property int $user_id the user id
 * @property string $user_comment space for the user to make a comment, ask for a feature etc
 * @property string $user_agent the user agent (UA) of the device the user is using - a device string
 * @property string $created_at tracking the date this template was created
 * @property string $last_update tracking the date this template was last updated
 * @property int $deleted for soft delete - DeleteUpdated does this
 * @property int $cid
 */
class UserFeedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_feedback}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_tenant');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'deleted', 'cid'], 'integer'],
            [['created_at', 'last_update'], 'safe'],
            [['user_comment', 'user_agent'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_comment' => 'Comment',
            'user_agent' => 'User Agent',
            'created_at' => 'Created At',
            'last_update' => 'Last Update',
            'deleted' => 'Deleted',
            'userCustomer' => 'Company Name',
            'userName' => 'Name',
        ];
    }

    public function sendEmail($message, $agent)
    {
        return Yii::$app->mailer->compose(['html' => 'feedback'], [
            'message' => $message, 'agent' => $agent
        ])
            ->setTo('support@epsolun.com')
            ->setFrom([\Yii::$app->params['supportEmail'] => 'Ubuxa'])
            ->setSubject('New Feedback')
            ->send();
    }
	
	public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }
	
	public function getUserName()
    {
        return $this->user->nameString;
    }
	
	public function getUserCustomer()
    {
        return $this->user->customer->comOrPersonName;
    }
	
	
}
