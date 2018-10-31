<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%task_status}}".
 *
 * @property int $id
 * @property string $task_status
 *
 * @property Task[] $tasks
 */
class TaskStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_status'], 'required'],
            [['task_status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_status' => 'Task Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['status_id' => 'id']);
    }
}
