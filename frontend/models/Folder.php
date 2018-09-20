<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\FolderARModel;


/**
 * This is the model class for table "tm_folder".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $title
 * @property string $description
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
 * @property Remark[] $remarks
 */
class Folder extends FolderARModel
{
    /**
     * {@inheritdoc}
     */
	public $privateFolder;
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
            [['parent_id', 'deleted', 'cid'], 'integer'],
            [['title'], 'required'],
            [['last_updated','privateFolder'], 'safe'],
            [['title'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 255],
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
            'last_updated' => 'Last Updated',
            'deleted' => 'Deleted',
            'cid' => 'Cid',
			'privateFolder' => 'Private',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemarks()
    {
        return $this->hasMany(Remark::className(), ['folder_id' => 'id']);
    }
	
	public function getSubFolders()
    {
        return $this->hasMany($this::className(), ['parent_id' => 'id']);
    }
	
	public function getTree()
    {
		 
        return array_reverse($this->containsFolderTree([],$this->parent_id));
    }
	
	public  function getDashboardItems($limit = 100) 
	{
		return $this->find()
				
				->limit($limit)
				->all();
	}
	
	 public function getFolderUsersInheritance(){
         return $this->hasMany(UserDb::className(), ['id' => 'user_id'])->select(['id','username','image'])->via('folderManagerInheritance');
        }
	public function getFolderUsers(){
         return $this->hasMany(UserDb::className(), ['id' => 'user_id'])->select(['id','username','image'])->via('folderManager')->asArray();
        }

    public function getFolderManagerInheritance()
    {
		if($this->parent_id > 0){
			return $this->hasMany(FolderManager::className(), ['folder_id' => 'parent_id']);
		}
        
    }
	public function getFolderManager()
    {
		
			return $this->hasMany(FolderManager::className(), ['folder_id' => 'id']);
		
        
    }
	
	public function getIsEmpty() 
	{
		return empty( $this->components ) ? true: false;
	}
	
	
}
