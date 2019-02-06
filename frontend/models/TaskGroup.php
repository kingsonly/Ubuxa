<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%task_group}}".
 *
 * @property int $task_group_id A task item which is also a task group
 * @property int $task_child_id A task item which is also a child task of a task group
 *
 * @property Task $taskChild
 * @property Task $taskGroup
 */
class TaskGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_group_id', 'task_child_id'], 'integer'],
            [['task_child_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_child_id' => 'id']],
            [['task_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_group_id' => 'Task Group ID',
            'task_child_id' => 'Task Child ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskChild()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_child_id']);
    }
    public function getTaskTitle()
   {
       return $this->hasMany(Task::className(), ['id' => 'task_child_id'])->viaTable('tm_task_group', ['task_group_id' => 'task_group_id']);
   }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskGroup()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_group_id']);
    }
    public static function primaryKey()
    {
        return ['task_group_id'];
    }
}
