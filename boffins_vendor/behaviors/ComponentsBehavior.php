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
use frontend\models\ComponentManager;
use frontend\models\Folder;
use frontend\models\ComponentTemplateAttribute;
use frontend\models\ComponentAttribute;




class ComponentsBehavior extends Behavior
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
		return [
			ActiveRecord::EVENT_AFTER_INSERT => 'behaviorFolderAfterSave', // commence linking on afer save event. 
			//ActiveRecord::EVENT_AFTER_UPDATE => 'behaviorFolderAfterSave', // commence linking on afer save event. 
		];
   }
	

	public function behaviorFolderAfterSave($event) 
	{
		$componentId = $this->owner->id;// owners component id
		$userId = yii::$app->user->identity->id;// creators user id
		$role = 'author'; // basic role for creator 
		$componentManager = $this->linkUserToComponent($userId,$componentId,$role);// call linkUserToComponent method which does all the heavy lifting 
		// create empty values
		$templateId = $this->owner->component_template_id;
		foreach($this->getAllComponentTemplateAttributes($templateId) as $templateAttributeKey => $templateAttributeValue){
			$type = $templateAttributeValue->componentAttributeType->type; //string type of the template attribute
			$typeName = $templateAttributeValue->componentAttributeType->name; //string type of the template attribute
			$templateAttributeId = $templateAttributeValue->id;//component template id
			$this->createEmptyValue($type,$componentId,$templateAttributeId,$typeName);
		}
		
		if($componentManager->save(false)){
			// once the author role has been saved, the system should go ahead to save other users
			foreach($this->getFolderUsers() as $v){
				if($v->id === yii::$app->user->identity->id){
					continue;
				} else{
					$this->linkUserToComponent($v->id,$componentId,'user')->save(false);// save at each loop
				}
					
			}
		}

	}
	
	private function getFolderUsers()
	{
		$model = new Folder();// init folder
		$getAllFolderUsers  = $model->find()
			->select(['id'])->where(['id' => $this->owner->folderId])->one();//Find folder of component
		return $getAllFolderUsers->folderUsers; // Return all users in fetched folder above
	}
	
	private function linkUserToComponent($userId,$componentId,$role)
	{
		$model = new ComponentManager();// init component manager
		$model->component_id = $componentId;// assign this->owner->id to the component argument when method is caled
		$model->user_id = $userId;// user id which would be passed when method is called
		$model->role = $role; // role either user or author as the case may be .
		return $model;// return model so as to be able to run a save
	}
	
	private function getAllComponentTemplateAttributes($templateId)
	{
		$templateAttributeId = ComponentTemplateAttribute::find()->where(['component_template_id' => $templateId])->all();//Find tenplate attribute based on the component template is which is hel in the $template variable
		return $templateAttributeId;// return all template and their relationships .
	}
	
	private function createEmptyValue($type,$componentId,$templateAttributeId,$typeName)
	{
		
		$model = 'frontend\models\Value'.$this->convertAttributeType($type);
		$valueModel = new $model();//init the value model.
		Yii::trace("this is a ".$type);
		if($type === 'known_class'){
			if($typeName == 'user'){
				$knownClassModel =  "frontend\\models\\".ucwords($typeName).'Db';
				$valueModel->value = ['nameSpace' =>$knownClassModel];
				Yii::trace("this is a ".$knownClassModel);
			}else{
				$knownClassModel =  "frontend\\models\\".ucwords($typeName);
				$valueModel->value = ['nameSpace' =>$knownClassModel];
				Yii::trace("this is a ".$knownClassModel);
			}
		}else{
			$valueModel->value = ''; // pass an empty value to model property.
		}
		
		if($valueModel->save(false)){ //save model.
			$valueId = $valueModel->id; // retrive model value id after saving.
			$cid = yii::$app->user->identity->cid;
			// use createComponentAttribute to create component attribute value.
			$this->createComponentAttribute($componentId,$templateAttributeId,$valueId,$cid);
		}
	}
	
	private function createComponentAttribute($componentId,$templateAttributeId,$valueId,$cid)
	{
		$componentAttributeModel = new ComponentAttribute();// init componentAttribute model
		$componentAttributeModel->component_id = $componentId;// assign component id to new instance
		$componentAttributeModel->component_template_attribute_id = $templateAttributeId; //assign templateattribute to new instance
		$componentAttributeModel->value_id = $valueId;// assign created value id to new instance
		$componentAttributeModel->cid = $cid; //assign cid to new instance
		$componentAttributeModel->save(false); // save new instance with values assinged above
	}
	
	private function convertAttributeType($type){
    	return str_replace('_', '', ucwords($type));// convert attribute type to have model partern eg FolderManager etc  
	}
	
	
}
