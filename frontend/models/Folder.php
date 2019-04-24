<?php

namespace frontend\models;

use Yii;
use boffins_vendor\classes\FolderARModel;
use yii\web\UploadedFile;
use boffins_vendor\behaviors\FolderBehavior;
use yii\helpers\ArrayHelper;


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
	public $externalTemplateId;
	public $controlerLocation = 'frontend';
	const ROLEAUTHOR = 'author';
    public static function tableName()
    {
        return '{{%folder}}';
    }
	
	public  function init()
    {
		parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'deleted', 'cid','private_folder'], 'integer'],
            [['title'], 'required'],	
            [['last_updated','privateFolder','upload_file','folder_image','externalTemplateId'], 'safe'],
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
	
	
	public function getComponentTemplateAsComponents()
    {
        return $this->hasMany(Component::className(), ['id' => 'component_id',])->andWhere(['component_template_id' => $this->externalTemplateId])->viaTable('tm_folder_component', ['folder_id' => 'id'])->orderBy([
			'id' => SORT_DESC
		]);
    }
	
	public function getFolderComponentTemplate(){
		return $this->hasMany(ComponentTemplate::className(), ['id' => 'component_template_id'])->via('components');
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
	
//    public function getUsers()
//    {
//        return $this->hasMany(Userdb::className(), ['id' => 'user_id'])->viaTable('tm_folder_manager', ['folder_id' => 'id']);
//    }
	
	public function getUsers()
	{
         return $this->hasMany(UserDb::className(), ['id' => 'user_id'])->via('folderManager');
    }
	
	public function getFolderManager()
    {
		return $this->hasMany(FolderManager::className(), ['folder_id' => 'id']);
    }
	
	public function getFolderManagerByRole()
    {
		
		return $this->hasOne(FolderManager::className(), ['folder_id' => 'id'])->andWhere(['role' => self::ROLEAUTHOR]);
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
			'id' => SORT_DESC
		]);
    }
	
	public function getTree()
    {
		 
        return array_reverse($this->containsFolderTree([],$this->parent_id));
    }

    public function buildTree(array $elements, $parentId) 
	{
        $child = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if (!empty($children)) {
                    $element['children'] = $children;
                }
                $child[] = $element;
            }
        }
        return $child;
	}

    public function printTree($trees) {

        foreach ($trees as $tree) {
            printf("<ul class='first-list' id='menu-folders%d'>
                        <li class='second-list' id='menu-folders%d'><a href='#'' class='list-link%d'><i class='fa fa-folder iconzz'></i>%s</a></li>
                    </ul>", $tree['id'], $tree['id'], $tree['id'], $tree['title']);

            if (isset($tree['children'])) {

                $this->printTree($tree['children'], $tree['parent_id']);

            }

        }

    }

	public  function getDashboardItems($limit = 100) 
	{
		return $this->find()
				->limit($limit)
				->all();
	}
	
	public function getFolderUsersInheritance()
	{
		 return $this->hasMany(UserDb::className(), ['id' => 'user_id'])->select(['id','username','profile_image'])->via('folderManagerInheritance');
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
    }

    public function getFolderManagerInheritance()
    {
		if($this->parent_id > self::DEFAULT_FOLDER_PARENT_STATUS){
			return $this->hasMany(FolderManager::className(), ['folder_id' => 'parent_id']);
		}
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
	
	public function myBehaviors() 
	{
		return [
			'FolderBehavior' => FolderBehavior::className(),
		];
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
			$this->controlerLocation === 'API'?\Yii::$app->params['uploadPath'] = '../../frontend/web/uploads/':\Yii::$app->params['uploadPath'] = \Yii::$app->basePath.'/web/uploads/';
			//\Yii::$app->params['uploadPath'] = \Yii::$app->basePath.'/web/uploads/';
			\Yii::$app->params['uploadPath'] = '../../frontend/web/uploads/';
			$path = \Yii::$app->params['uploadPath'] . $newName;
			$dbpath = 'uploads/' . $newName;
			
			$holdPath= $dbpath;
			
			if($file->saveAs($path)){
				
				$this->folder_image = $dbpath;
				
			}
			
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
