<?php

namespace console\models;

use Yii;
use frontend\models\Folder;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use boffins_vendor\classes\StandardConsoleFolderQuery;
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
class ConsoleFolder extends Folder
{
   
	public static function find() 
	{
		return new StandardConsoleFolderQuery(get_called_class());
	}
	
	
	
}
