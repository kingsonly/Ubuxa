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




/**
 * ComponentsBehavior automatically fetches all the associated component of a Parent component and stores value  
 * in a global/ public array to be used in any controller based on the AFTER_FIND_EVENT . 
 * 
 * This only applies to Component models 
 *
 * To use ComponentsBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use app\tm_vendor\ComponentsBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         ComponentsBehavior::className(),
 *     ];
 * }
 * ```
 *
 * By default, ComponentBehavior returns a nested array of subComponets which is identified by the variable *'$subComponents'.
 * 
 * 
 * By default component type are 6 and are held as a data type (string) in a '$componentType' numeric key array 
 * 
 * If the component names are different then this can be changed by changing the values of 'componentType', to achive this change 
 * 'newComponetsType' property to true  and add new component as an array of strings to 'componentTypeSetting' eg 
 *
 *	public function behaviors()
 * 	{
 *     return [
 *				[
 *					'class'=>ComponentsBehavior::className(),
 *					'componentTypeSetting' =>['payment','goods','products'],// add new components
 					"newComponetsType" => 'TRUE',// determine if componetTypeSetting  should  be treated as new components or  as the only components as such making the existing 								  default components null
					
 *				] 	
 *     		 ];
 * 	}
 *
 * 
 *
 */
class FolderBehavior extends Behavior
{
	
    public function init()
    {
        parent::init();
		
    }
	
	/**
	 * inherit docs
     */
	public function events() 
	{
		if ( $this->owner->stopComponentBehaviors ) {
			return [];
		}
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
		
		if($this->owner->privateFolder === 'fa fa-lock'){
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
			->select(['id'])->where(['basic_role' => 1])
			->orWhere(['basic_role' => 2])->all();
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
