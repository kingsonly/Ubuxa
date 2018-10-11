<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property int $id
 * @property string $title
 * @property string $details
 * @property int $owner
 * @property int $assigned_to
 * @property int $status_id
 * @property string $create_date
 * @property string $due_date
 * @property string $last_updated
 * @property int $deleted
 * @property int $cid
 *
 * @property ComponentTask[] $componentTasks
 * @property FolderTask[] $folderTasks
 * @property Folder[] $folders
 * @property User $assignedTo
 * @property User $owner0
 * @property TaskStatus $status
 * @property TaskReminder[] $taskReminders
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'details', 'owner','status_id', 'create_date'], 'required'],
            [['last_updated', 'deleted', 'assigned_to', 'due_date'], 'safe'],
            [['owner', 'assigned_to', 'status_id', 'deleted', 'cid'], 'integer'],
            [['create_date', 'due_date', 'last_updated'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['details'], 'string', 'max' => 255],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => UserDb::className(), 'targetAttribute' => ['assigned_to' => 'id']],
            [['owner'], 'exist', 'skipOnError' => true, 'targetClass' => UserDb::className(), 'targetAttribute' => ['owner' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusType::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'details' => 'Details',
            'owner' => 'Owner',
            'assigned_to' => 'Assigned To',
            'status_id' => 'Status ID',
            'create_date' => 'Create Date',
            'due_date' => 'Due Date',
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentTasks()
    {
        return $this->hasMany(ComponentTask::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolderTasks()
    {
        return $this->hasMany(FolderTask::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolders()
    {
        return $this->hasMany(Folder::className(), ['id' => 'folder_id'])->viaTable('{{%folder_task}}', ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(User::className(), ['id' => 'assigned_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner0()
    {
        return $this->hasOne(User::className(), ['id' => 'owner']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(StatusType::className(), ['id' => 'status_id']);
    }

    public function getStatusTitle()
    {
        return $this->status->status_title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskReminders()
    {
        return $this->hasMany(TaskReminder::className(), ['task_id' => 'id']);
    }

    public function displayTask()
    {
        $task= $this->find()->all();
        return $task;
    }
}
