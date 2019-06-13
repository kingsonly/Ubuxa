<?php
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace boffins_vendor\behaviors;


use Yii;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\UploadedFile;
use frontend\models\FolderManager;
use frontend\models\UserDb;
//use app\models\InvoiceComponent;




class FolderBehavior extends Behavior
{
	
	public const FOLDER_LOCK_STRING = 'fa fa-lock'; //string to detremin if folder creation is private or not, basicaly used by folderbehaviour
	public const BASIC_ADMIN_ROLES = [1,2]; //Basic admin roles in the database, which are 1 admin and 2 for manager
    public function init()
    {
        parent::init();
		
    }
	
	/**
	 * inherit docs
     */
	public function events() 
	{
		return [
			ActiveRecord::EVENT_AFTER_INSERT => 'behaviorFolderAfterSave', // commence linking on afer save event. 
			//ActiveRecord::EVENT_AFTER_UPDATE => 'behaviorFolderAfterSave', // commence linking on afer save event. 
		];
   }
	

	public function behaviorFolderAfterSave($event) 
	{
		$folderId = $this->owner->id;
		$userId = yii::$app->user->identity->id;
		$role = 'author';
		$folderManager = $this->linkUserToFolder($userId,$folderId,$role);
		
		if($this->owner->privateFolder === self::FOLDER_LOCK_STRING or $this->owner->private_folder === 1){
			if($folderManager->save()){
				return;
			}
		
		}
		if($this->owner->parent_id > 0){
			if($this->linkUserToFolder($userId,$folderId,$role)->save()){
				foreach($this->owner->folderUsersInheritance as $v){
					$this->linkUserToFolder($v->id,$folderId,'user')->save();

				}
			}
		}else{
			if($this->linkUserToFolder($userId,$folderId,$role)->save()){

				foreach($this->getAdminUsers() as $v){
					$this->linkUserToFolder($v->id,$folderId,'user')->save();
				}
			};
		}
	}
	
	private function getAdminUsers()
	{
		$model = new UserDb();
		$getAllAdmin  = $model->find()
			->select(['id'])->where(['in','basic_role',self::BASIC_ADMIN_ROLES])->andWhere(['cid' => yii::$app->user->identity->cid])->all();
		return $getAllAdmin;
	}
	
	private function linkUserToFolder($userId,$folderId,$role)
	{
		$model = new FolderMAnager();
		$model->folder_id = $folderId;
		$model->user_id = $userId;
		$model->role = $role;
		return $model;
	}
	
	
}
