<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%reminder}}".
 *
 * @property int $id
 * @property string $reminder_time
 * @property string $notes
 * @property string $last_updated
 * @property int $deleted
 * @property int $cid
 *
 * @property TaskReminder[] $taskReminders
 */
class Reminder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reminder}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reminder_time', 'notes', 'last_updated', 'deleted'], 'required'],
            [['reminder_time', 'last_updated'], 'safe'],
            [['deleted', 'cid'], 'integer'],
            [['notes'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reminder_time' => 'Reminder Time',
            'notes' => 'Notes',
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskReminders()
    {
        return $this->hasMany(TaskReminder::className(), ['reminder_id' => 'id']);
    }
}
