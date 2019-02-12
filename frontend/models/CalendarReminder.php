<?php

namespace frontend\models;

use frontend\models\UserDb;
use frontend\models\Reminder;

use Yii;

/**
 * This is the model class for table "{{%calendar_reminder}}".
 *
 * @property int $id
 * @property int $reminder_id
 * @property int $user_id
 *
 * @property Reminder $reminder
 * @property User $user
 */
class CalendarReminder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%calendar_reminder}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reminder_id', 'user_id'], 'required'],
            [['reminder_id', 'user_id'], 'integer'],
            [['reminder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reminder::className(), 'targetAttribute' => ['reminder_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserDb::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reminder_id' => 'Reminder ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReminder()
    {
        return $this->hasOne(Reminder::className(), ['id' => 'reminder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserDb::className(), ['id' => 'user_id']);
    }
}
