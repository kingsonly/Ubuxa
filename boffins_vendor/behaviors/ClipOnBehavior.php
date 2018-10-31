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
use yii\db\Expression;
use frontend\models\Clip;
use frontend\models\Component;
use frontend\models\Folder;
use frontend\models\ClipBarOwnerType;
use frontend\models\ClipOwnerType;
use frontend\models\ClipBar;
use yii\db\ActiveRecord;


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
class ClipOnBehavior extends Behavior
{
	
    public function init()
    {
        parent::init();
		
    }
	public $clipOn;
	
	/**
	 * inherit docs
     */
	public function events() 
	{
		
		return [
			ActiveRecord::EVENT_AFTER_INSERT => 'behaviorAfterSave', 
			ActiveRecord::EVENT_BEFORE_DELETE => 'behaviorBeforeDelete', 
			ActiveRecord::EVENT_AFTER_FIND => 'fetchAllClipOn', 
		];
   }
	

	public function behaviorAfterSave($event) 
	{
		$this->createClipOnBar();
		$this->createClipOn();
	}
	
	// this method is to be called just before the clip is actually deleted
	public function behaviorBeforeDelete($event) 
	{
		
		$clipBarModel = new ClipBar();// instatnciate clipbar
		$clipOwnerTypeModel = new ClipOwnerType();// instatnciate clipownertypemodel
		$ownerId = $this->owner->id;// owners id 
		$ownerType = $this->_getShortClassName($this->owner) ;// get class name eg remaks
		$ownerTypeId = $this->_getShortClassName($this->owner) == 'Folder'?1:2;// Change this fetch from the db 
		$getClipBar = $clipBarModel->find()->where(['owner_id' => $ownerId,'owner_type_id' => $ownerTypeId])->one();// find clip bar
		$findClipOwnerType = $clipOwnerTypeModel->find()->select(['id'])->where(['owner_type' => $ownerType])->asArray()->one();// find clip owner type 
		$findClip = $clip->find()->where(['owner_type_id' => $findClipOwnerType,'owner_id' => $ownerId])->one();// find clip using ownertype id
		// delete clip 
		if($findClip->delete()){
			// check is deletedt clip has a bar 
			if(!empty($getClipBar)){
				// delete bar 
				$getClipBar->delete();
			}
		}
		
	}
	
	private function createClipOn(){
		if(!empty($this->owner->ownerId)){
			//
			$clipOwnerTypeModel = new ClipOwnerType();
			$clipBarModel  = new ClipBar();
			$clipModel  = new Clip();
			$getClassName = $this->_getShortClassName($this->owner);
			
			$getOwnerTypeId = $clipOwnerTypeModel->find([])->select(['id'])->where(['owner_type' => $getClassName])->one();
			
			$getClipBarId = $clipBarModel->find()->select(['id'])->where(['owner_id' => $this->owner->ownerId])->one();
			$clipModel->owner_id = $this->owner->id;
			$clipModel->bar_id = $getClipBarId->id;
			$clipModel->owner_type_id = $getOwnerTypeId->id;
			$clipModel->save();
			
		}else{
			return;
		}
	}
	
	public function fetchAllClipOn(){
		$this->getClipDetails();
		//var_dump($this->getAllClips());
	}
	
	private function getClipDetails(){
		$allClips = [];
		
		$getAllClipOwnerType = ClipOwnerType::find()->all();
		foreach($getAllClipOwnerType as $value){
			$allClips[$value->owner_type] = [];
		}
		
		if(empty($this->getAllClips())){
			return;
		}
		foreach($this->getAllClips() as $value){
			$clips = $this->switchAmongClipTypes($value->ownerType->owner_type,$value->owner_id);
			array_push($allClips[$value->ownerType->owner_type],$clips);
		}
		$this->clipOn = $allClips;
	}
	
	private function switchAmongClipTypes($clipType,$clipId){
		$clipParentClass = ucwords($clipType);
		$clipTypeModel = '\\frontend\\models\\'.$clipParentClass;
		$getClipDetails = $clipTypeModel::find()->where(['id' => $clipId])->one();
		return $getClipDetails;
	}
	
	private function getAllClips(){
		$clipBarModel = new ClipBar();
		$ownerId = $this->owner->id;
		$ownerTypeId = $this->_getShortClassName($this->owner) == 'Folder'?1:2;
		$getClipBarcount = $clipBarModel->find()->where(['owner_id' => $ownerId])->count();
		$getClipBar = $clipBarModel->find()->where(['owner_id' => $ownerId,'owner_type_id' => $ownerTypeId])->one();
		if($getClipBarcount  !== '0'){
			if(!empty($getClipBar->clips)){
				$getClips = $getClipBar->clips;
				return  $getClips;
			}
			return;
			
		}else{
			return ;
		}
		
	}
	
	private function createClipOnBar(){
		$ownerTypeModel = new ClipBarOwnerType();
		$clipBarModel = new ClipBar();
		
		$getClassName = $this->_getShortClassName($this->owner) == 'Folder'?'folder':'component';
		$searchOwnerTypeId = $ownerTypeModel->find()->select(['id'])->where(['owner_type' => $getClassName])->one();
		
		$clipBarModel->owner_id = $this->owner->id;
		$clipBarModel->owner_type_id = $searchOwnerTypeId->id;
		$clipBarModel->save(false);
		
	}
	
	private function _getShortClassName($classMethod)
	{
		return (new \ReflectionClass($classMethod))->getShortName();
	}
	
	
	
	
}
