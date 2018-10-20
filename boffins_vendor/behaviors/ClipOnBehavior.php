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
			ActiveRecord::EVENT_AFTER_INSERT => 'behaviorCreateClipBarAfterSave', 
		];
   }
	

	public function behaviorCreateClipBarAfterSave($event) 
	{
		$this->createClipOnBar();
	}
	
	private function createClipOn(){}
	
	private function fetchAllClipOn(){}
	
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
