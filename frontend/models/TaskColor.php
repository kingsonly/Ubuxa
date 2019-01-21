<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%task_color}}".
 *
 * @property int $id
 * @property int $task_group_id
 * @property string $task_color
 *
 * @property Task $taskGroup
 */
class TaskColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_color}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_group_id', 'task_color'], 'required'],
            [['task_group_id'], 'integer'],
            [['task_color'], 'string', 'max' => 50],
            [['task_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_group_id' => 'Task Group ID',
            'task_color' => 'Task Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskColor()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_group_id']);
    }
}
