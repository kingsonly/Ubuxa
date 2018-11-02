<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\FolderARModel;
use yii\web\UploadedFile;


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
	public $upload_file;
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
            [['parent_id', 'deleted', 'cid','private_folder'], 'integer'],
            [['title'], 'required'],	
            [['last_updated','privateFolder','upload_file','folder_image'], 'safe'],
            [['title'], 'string', 'max' => 40],
            [['description','folder_image'], 'string', 'max' => 255],
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
        return $this->hasMany(Userdb::className(), ['id' => 'user_id'])->viaTable('tm_folder_manager', ['folder_id' => 'id']);
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
        return $this->hasMany($this::className(), ['parent_id' => 'id'])->orderBy([
  'last_updated' => SORT_DESC,
  //'item_no'=>SORT_ASC
]);
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
         return $this->hasMany(UserDb::className(), ['id' => 'user_id'])->select(['id','username','profile_image'])->via('folderManagerInheritance');
        }
	public function getFolderUsers(){
         return $this->hasMany(UserDb::className(), ['id' => 'user_id'])->via('folderManager');
        }


    public function getPerson()
    {
        return $this->hasMany(Person::className(), ['id' => 'person_id'])->via('users');
    }


    public function getPersonName()
    {   
        $names = [];
        $data = $this->person;
        foreach($data as $attr) {
            $names[] = $attr->first_name.' '.$attr->surname;
        }
        return implode(" ", $names);

        //return $this->person->first_name;
    }

    public function getFolderManagerInheritance()
    {
		if($this->parent_id > self::DEFAULT_FOLDER_PARENT_STATUS){
			return $this->hasMany(FolderManager::className(), ['folder_id' => 'parent_id']);
		}
        
    }
	public function getFolderManager()
    {
		
			return $this->hasMany(FolderManager::className(), ['folder_id' => 'id']);
		
        
    }
	
	public function getFolderManagerFilter()
    {
		
			return $this->hasOne(FolderManager::className(), ['folder_id' => 'id'])->andWhere(['user_id' => yii::$app->user->identity]);
		
        
    }
	
	public function getAllChildFolder(){
		
	}
	
	public function getRole()
    {
		return $this->hasOne(FolderManager::className(), ['folder_id' => 'id'])->andWhere(['user_id' => yii::$app->user->identity])->select('role');
		
        
    }
	
	public function getIsPrivate()
    {
		
			return $this->hasMany(FolderManager::className(), ['folder_id' => 'id'])->asArray()->count() == 1 ? true : false;
		
        
    }
	
	public function getIsEmpty() 
	{
		return empty( $this->components ) ? true: false;
	}
	public function getFolderColors() 
	{
		$colorStatus = '';
		if($this->private_folder > self::DEFAULT_PRIVATE_FOLDER_STATUS){
			$colorStatus =  'private';
		} elseif($this->role->role == 'author'){
			$colorStatus = 'author';
		}else{
			$colorStatus = 'users';
		}
		return $colorStatus;
	}
	
	
	
	
		public function upload()
    {
        if ($this->validate()) {
			$holdPath = '';
			$file = $this->upload_file;
			$ext = $file->extension;
			$newName = \Yii::$app->security->generateRandomString().".{$ext}";
			$basePath = explode('/',\Yii::$app->basePath);
			//\Yii::$app->params['uploadPath'] = \Yii::$app->basePath.'/web/uploads/';
			$path = 'uploads/' . $newName;
			$dbpath = 'uploads/' . $newName;
			
			$holdPath= $dbpath;
			
			if($file->saveAs($path)){
				
				$this->folder_image = $path;
				
			}
			//$this->file_location = implode(",",$holdPath);
			
            return true;
        } else {
            return false;
        }
    }
	
	
	
	
	 public function uploads()
    {
        if ($this->validate()) {
            $this->upload_file->saveAs('uploads/' . $this->upload_file->baseName . '.' . $this->upload_file->extension);
            return true;
        } else {
            return false;
        }
    }
	
	
	
	
}
