<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%task_reminder}}".
 *
 * @property int $reminder_id
 * @property int $task_id
 *
 * @property Task $task
 * @property Reminder $reminder
 */
class TaskReminder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_reminder}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reminder_id', 'task_id'], 'required'],
            [['reminder_id', 'task_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['reminder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reminder::className(), 'targetAttribute' => ['reminder_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reminder_id' => 'Reminder ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReminder()
    {
        return $this->hasOne(Reminder::className(), ['id' => 'reminder_id']);
    }
}
