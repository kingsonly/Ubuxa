<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tm_folder".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $description
 * @property string $folder_image
 * @property int $private_folder
 * @property string $last_updated
 * @property int $deleted
 * @property int $cid
 *
 * @property FolderComponent[] $folderComponents
 * @property Component[] $components
 * @property FolderManager[] $folderManagers
 * @property User[] $users
 * @property FolderTask[] $folderTasks
 * @property Task[] $tasks
 */
class BackendFolder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tm_folder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'private_folder', 'deleted', 'cid'], 'integer'],
            [['title', 'last_updated', 'deleted'], 'required'],
            [['last_updated'], 'safe'],
            [['title'], 'string', 'max' => 40],
            [['description', 'folder_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'description' => 'Description',
            'folder_image' => 'Folder Image',
            'private_folder' => 'Private Folder',
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolderComponents()
    {
        return $this->hasMany(FolderComponent::className(), ['folder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponents()
    {
        return $this->hasMany(Component::className(), ['id' => 'component_id'])->viaTable('tm_folder_component', ['folder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolderManagers()
    {
        return $this->hasMany(FolderManager::className(), ['folder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('tm_folder_manager', ['folder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolderTasks()
    {
        return $this->hasMany(FolderTask::className(), ['folder_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['id' => 'task_id'])->viaTable('tm_folder_task', ['folder_id' => 'id']);
    }
}
