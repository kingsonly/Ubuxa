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
 * This is behaviour class for clipons.
 * Class Name  ClipOnBehavior
 * @property array $clipOn holds a list of all clipons in a clip bar. 
 *********************** Usage ****************************************
 * public function behaviors() 
 *	{
 *		return [
 *			'ClipOnBehavior' => ClipOnBehavior::className(),
 *		];
 *
 *	}
 *************************** 5 Public Methods***********************************
 * @method events // holds all the events triggered in this class
 * @method behaviorAfterSave // this method is trigered once a save method has been called on a model.
 * @method behaviorBeforeDelete // this method is trigered once a delete method has been called on a model.
 * @method fetchAllClipOn // as the name impies its basic function is to fetch  clipons.
 * @method specificClips // this method is used when a developer wants to fetch a specific clipon in batches .
 *************************** 7 Private Methods***********************************
 * @method createClipOn // as the name impies its basic function is to create any type of clipon .
 * @method getClipDetails // this is used in fetching each clip details.
 * @method getAllClips // this is used in fetching all clips.
 * @method switchAmongClipTypes // this makes they fetching of clips dynamic determine from which table to fetch 
 * the cleip details .
 * @method tagetClipTypes // simillar to switchAmongClipTypes method .
 * @method createClipOnBar // basically responsible for creating a bar for every model using this behavior .
 * @method _getShortClassName // helps to strip out namespace from class name  .
 */

class ClipOnBehavior extends Behavior
{
	
    public function init()
    {
        parent::init();
		
    }
	
	public $clipOn;
	public $fromWhere;
	
	/**
	 * inherit docs
     */
	/*************************************************************************************************************************************************************************************************************************************************************** public methods start here **************************************** ***********************************************************************************************************************************************************************************************************************/
	
	public function events() 
	{
		// Trigers all events on this behavior
		return [
			ActiveRecord::EVENT_AFTER_INSERT => 'behaviorAfterSave',// event after save 
			ActiveRecord::EVENT_BEFORE_DELETE => 'behaviorBeforeDelete', // event before delete
			ActiveRecord::EVENT_AFTER_FIND => 'fetchAllClipOn', // event after find
		];
	}
	
	public function behaviorAfterSave($event) 
	{
		// methods trigered when the behaviour event after save is called 
		$this->createClipOnBar();
		$this->createClipOn();
	}

	
//	public function behaviorBeforeDelete($event) 
//	{
//		// this method is to be called just before the clip is actually deleted
//		$clipBarModel = new ClipBar();// instatnciate clipbar
//		$clipOwnerTypeModel = new ClipOwnerType();// instatnciate clipownertypemodel
//		$ownerId = $this->owner->id;// owners id 
//		$ownerType = $this->_getShortClassName($this->owner) ;// get class name eg remaks
//		$ownerTypeId = $this->_getShortClassName($this->owner) == 'Folder'?1:2;// Change this fetch from the db 
//		$getClipBar = $clipBarModel->find()->andWhere(['owner_id' => $ownerId,'owner_type_id' => $ownerTypeId])->one();// find clip bar
//		$findClipOwnerType = $clipOwnerTypeModel->find()->select(['id'])->andWhere(['owner_type' => $ownerType])->asArray()->one();// find clip owner type 
//		$findClip = Clip::find()->andWhere(['owner_type_id' => $findClipOwnerType,'owner_id' => $ownerId])->one();// find clip using ownertype id
//		// delete clip 
//		if($findClip->delete()){
//			// check is deletedt clip has a bar 
//			if(!empty($getClipBar)){
//				// delete bar 
//				$getClipBar->delete();
//			}
//		}
//		
//	}
	
	
	
	
	public function behaviorBeforeDelete($event) 
	{
		// this method is to be called just before the clip is actually deleted
		$clipBarModel = new ClipBar();// instatnciate clipbar
		$clipOwnerTypeModel = new ClipOwnerType();// instatnciate clipownertypemodel
		$ownerId = $this->owner->id;// owners id 
		$ownerType = $this->_getShortClassName($this->owner) ;// get class name eg remaks
		$ownerTypeModel = ClipBarOwnerType::find()->andWhere(['owner_type'=> $ownerType])->one();
		$ownerTypeId = $ownerTypeModel->id;// Change this fetch from the db 
		$getClipBar = $clipBarModel->find()->andWhere(['owner_id' => $ownerId,'owner_type_id' => $ownerTypeId])->one();// find clip bar
		$findClipOwnerType = $clipOwnerTypeModel->find()->select(['id'])->andWhere(['owner_type' => $ownerType])->asArray()->one();// find clip owner type 
		$findClip = Clip::find()->andWhere(['owner_type_id' => $findClipOwnerType,'owner_id' => $ownerId])->one();// find clip using ownertype id
		// delete clip
//		if($this->_getShortClassName($this->owner) == 'Folder'){
//			if(!empty($findclip)){
//				if($findClip->delete()){
//					// check is deletedt clip has a bar 
//					if(!empty($getClipBar)){
//						// delete bar 
//						$getClipBar->delete();
//					}
//				}
//			}else{
//			// check is deletedt clip has a bar 
//				if(!empty($getClipBar)){
//					// delete bar 
//					$getClipBar->delete();
//				}
//			
//			}
//		}
		
		
//		if($this->_getShortClassName($this->owner) != 'Folder'){
//			if(!empty($findclip)){
//					if($findClip->delete()){
//						// check is deletedt clip has a bar 
//						if(!empty($getClipBar)){
//							// delete bar 
//							$getClipBar->delete();
//						}
//					}
//				}
//		}else{
//			
//			if(!empty($getClipBar)){
//							// delete bar 
//							$getClipBar->delete();
//						}
//			
//		}
		
		if($this->_getShortClassName($this->owner) == 'Folder'){
			if(!empty($getClipBar)){
					// delete bar 
					$getClipBar->delete();
				}
		}else{
			if($findClip->delete()){
				// check is deletedt clip has a bar 
				if(!empty($getClipBar)){
					// delete bar 
					$getClipBar->delete();
				}
			}
		}
		
		
		
		
	}
	
	public function fetchAllClipOn()
	{
		$this->getClipDetails();// method to fetch all clipons
	}
	
	public function specificClips($ownerid=0,$ownerTypeId=1,$offset=0,$limit=1,$ownerType='task')
	{
		// public funtion to be used outside of behaviour to fetch all clips and attache a limitatio
		// quite usefull when creating an infinit scrol 
		
		$clipBarModel = new ClipBar(); // instanciate clip bar 
		$ownerId = $ownerid;// this could be folder id, but specifically the model a user is accessing
		
		//$ownerTypeId = $this->_getShortClassName($this->owner) == 'Folder'?1:2; // validate if owner is a folder or a component or something else 
		$initClipBarOwnerType = ClipBarOwnerType::find()->andWhere(['owner_type' => $this->owner->fromWhere])->one();
		$getClipBarcount = $clipBarModel->find()->andWhere(['owner_id' => $ownerId])->count(); // check to see if specified element has a clipbar *** which would be used for checkig in the below if clause ******
		
		$getClipBar = $clipBarModel->find()->andWhere(['owner_id' => $ownerId,'owner_type_id' => $initClipBarOwnerType->id])->one();
		
		// if the bar exist then get all its clips 
		if($getClipBarcount  !== '0'){
			if(!empty($getClipBar->clips)){
				$getClips = $this->owner->specificClipsWithLimitAndOffset($limit,$offset,$ownerTypeId,$getClipBar->id);
				$getArrayValues = [];
				foreach($getClips as $value){
					array_push($getArrayValues,$value['owner_id']); // convert clip owners id 
				}
				//var_dump($getArrayValues);
				return  $this->tagetClipTypes($ownerType,array_values($getArrayValues));// retuen clips
			}
			return;
			
		}else{
			return ;
		}
		
	}

	/***
	 * @brief returns a ClipBarOwner - i.e. a BARRM which is a ClipBar eg folder. 
	 * 
	 * @param [int] $clipBarID the id of the ClipBar to retrieve.
	 */
	protected function retrieveClipBarOwner($clipBarID)
	{
		$clipBar = ClipBar::find()
					//->select('{{%clip_bar}}.id, ot.owner_type')
					->joinWith(['ownerType'])
					->andWhere(['{{%clip_bar}}.id' => $clipBarID])
					->one();
		$ownerType = ucfirst($clipBar->ownerType->owner_type);
		Yii::warning("Owner $ownerType", "HERE");
		$fqn = "\\frontend\\models\\{$ownerType}";
		$barOwner = $fqn::findQuietly()->andWhere(['id' => $clipBar->owner_id])->one();
		//Yii::warning(\yii\helpers\VarDumper::dumpAsString($barOwner), "RIGHT HERE");
		return $barOwner;
	}
	
	/*************************************************************************************************************************************************************************************************************************************************************** Private methods start here **************************************** ***********************************************************************************************************************************************************************************************************************/
	
	private function getClipDetails()
	{
		$allClips = []; // Array to hold all clips
		
		$getAllClipOwnerType = ClipOwnerType::find()->all(); // find all clip owner types eg task remarks etc
		
		foreach($getAllClipOwnerType as $value){
			// loop through all clip owner types and create a new set of nexted array
			// Aim to simply hold all remarks or task as the case may be in its own unique key 
			//eg $allClips['task'] would hold all cliped task in a bar
			$allClips[$value->owner_type] = [];
		}
		// do nothing if there are no clips in a bar
		if(empty($this->getAllClips())){
			return;
		}
		foreach($this->getAllClips() as $value){
			// loop through all clips and fetch their details depending on the clip type 
			$clips = $this->switchAmongClipTypes($value->ownerType->owner_type,$value->owner_id); // holds an object of a clip it could be either a task , remaks object etc
			array_push($allClips[$value->ownerType->owner_type],$clips); // push object to sll clip array
		}
		$this->clipOn = $allClips; // assign clipon array to the allclips array 
	}
	
	private function switchAmongClipTypes($clipType,$clipId)
	{
		$clipParentClass = ucwords($clipType); // convert classname to string with first figure capital to match the model class name naming style
		$clipTypeModel = '\\frontend\\models\\'.$clipParentClass;// Add class namespace for models
		$getClipDetails = $clipTypeModel::find()->andWhere(['id' => $clipId])->one(); // fetch clips details 
		return $getClipDetails; //return an object of the clip depending on the type
	}

	/***
	 * @brief - this is missing. @KINGLSLEY add this so that other people can fully understand what this funcion does and what it 
	 * is meant to achieve. This is better than describing what each line does (which isn't helpful because everyone already reads)
	 * 
	 * @future - The three lines marked as LINE 1, LINE 2, LINE 3 should be merged into one line 
	 * wih one query using one find. Right now, this triggers 3 finds which throws off the system.
	 * @KINGLSLEY or anyoen else, please refactor. Consider joins.
	 * 	 */
	private function getAllClips()
	{
		$clipBarModel = new ClipBar(); // clipbar instance 
		$ownerId = $this->owner->id; // owners id usually the folder id but could also be a task or a any thing that can be cliped to eg a clipbar
		$ownerClassName= $this->_getShortClassName($this->owner); // holds a string value of the actuall class name
		//LINE 1 REFACTOR
		$getOwnerType = ClipBarOwnerType::find()->andWhere(['owner_type'=>$ownerClassName])->one();
		
		$ownerTypeId = $getOwnerType->id; //returns the id which is gotten from the clip bar owner type search
		//LINE 2 REFACTOR
		$getClipBarcount = $clipBarModel->find()->andWhere(['owner_id' => $ownerId])->andWhere(['owner_type_id' => $ownerTypeId])->count();// used to make sure a clip exist 
		//LINE 3 REFACTOR USE JOINS 
		$getClipBar = $clipBarModel->find()->andWhere(['owner_id' => $ownerId])->andWhere(['owner_type_id' => $ownerTypeId])->one(); // get clip bar id which would be used to fetch all clips associated to the bar 
		
		/**** if bar exist run the below set of code to complete the circle ***********
		***** and eventually fetch all clips ******************************************/
		
		if($getClipBarcount  !== '0'){
			if(!empty($getClipBar->clips)){
				// making sure there are clips associated to the clipbar
				$getClips = $getClipBar->clips; // $getClips holds all clips associated to a bar 
				return  $getClips;
			}
			return;
			
		}else{
			return ;
		}
		
	}
	
	private function tagetClipTypes($clipType,$clipIds)
	{
		$clipParentClass = ucwords($clipType);// convert classname to string with first figure capital to match the model class name naming style
		$clipTypeModel = '\\frontend\\models\\'.$clipParentClass; // Add class namespace for models
		// remarks has a parent column as such not all remarks are root remarks , some remarks are replies as such that need to be factored
		if($clipType == 'remark'){
			$getClipDetails = $clipTypeModel::find()->andWhere(['in','id', $clipIds])->orderBy(['id'=>SORT_DESC])->andWhere(['parent_id' => $clipTypeModel::DEFAULT_PARENT_ID ])->all();
		}else{
			$getClipDetails = $clipTypeModel::find()->andWhere(['in','id', $clipIds])->orderBy(['id'=>SORT_DESC])->all();
		}
		return $getClipDetails;//return an object of the clip depending on the type
		
	}
	
	private function createClipOnBar()
	{
		$ownerTypeModel = new ClipBarOwnerType();// instanciate clip bar owner type 
		$clipBarModel = new ClipBar(); // instanciate clip bar 
		
		$getClassName = ucwords($this->_getShortClassName($this->owner));// == 'Folder'?'folder':'component'; // determine owner class name and make them lower case and in terms of component convert their names to components , note this code would be reviewed and this comment would be changed, as such as long as this comment is here, this  code is yet to be reviewed .

		//the below comment is to be reviewed 

		// if($this->_getShortClassName($this->owner) == 'Task' or $this->_getShortClassName($this->owner) == 'Remark'){
		// 	return false;
		// }
		$searchOwnerTypeId = $ownerTypeModel->find()->select(['id'])->andWhere(['owner_type' => $getClassName])->one();// get the id of the ownertype eg folder component etc
		
		// if searchownertype is empty, this simply means such class is new to clipon, as such it has to be added to the db first and what it returs after adding would bbe used to finish the query process 
		if(empty($searchOwnerTypeId)){
			$ownerTypeModel->owner_type = strtolower($getClassName); //assign classname to ownertype
			
			// if ownerTypeModel is saved pass the value to $searchOwnerTypeId variable to overrite $searchOwnerTypeId which at this point shouold be empty
			if($ownerTypeModel->save()){
				$searchOwnerTypeId = $ownerTypeModel;
			}
			 
		}
		
		$clipBarModel->owner_id = $this->owner->id; // assign clipBarModel->owner_id with the owner id
		$clipBarModel->owner_type_id = $searchOwnerTypeId->id; // determine if its a folder or a component etc options could be more than just folder or components 
		$clipBarModel->save(false); // save bar 
		
	}
	
	private function _getShortClassName($classMethod)
	{
		return (new \ReflectionClass($classMethod))->getShortName();// use to strip out name space in a class name
	}
	
	/***
	 * @KINGSLEY this function needs a lot of refactoring.
	 * 
	 * @brief - missing KINGSLEY TO INCLUDE
	 * @details - if necessary 
	 * @future - 
	 * 1. the queries here can reasonably be reduced to 1 or 2 queries. Aim for 1. You can join, with and joinWith to include
	 * relations.
	 * 2. The variable names are very opaque
	 * 3. Inline documentation is actually more a nuisance than a help. The code should be self explanatory. If you need inline 
	 * documentation, it means you are using the wrong variable names and method names. 
	 */
	private function createClipOn()
	{
		Yii::trace("The id of this clip on is - ".$this->owner->id);
		if(!empty($this->owner->ownerId)){ //i think ownerId here should be BarOwnerID
			Yii::trace("The id of the bar owner is {$this->owner->ownerId}");
			//$clipOwnerTypeModel = new ClipOwnerType(); // instatnciate ClipOwnerType model
			//$clipBarModel  = new ClipBar(); // instatnciate clip bar model 
			$clipModel  = new Clip(); //instanciate clip model
			$getClassName = $this->_getShortClassName($this->owner); // convert class name to string and strip out name space 

			//this should be the right implementation to get the owner type, never the less this is not a patch but would still be reviewed.
			$ownerTypeModel = ClipBarOwnerType::find()->andWhere(['owner_type'=> $this->owner->fromWhere])->one();//$this->owner->fromWhere == 'folder'?1:2; (this comment should be removed after validated that code is working )
			
			// if selection comes out empty, that means from where does not exist in the db, as such create a new one 
			if(empty($ownerTypeModel)){
				$clipBarOwner = new ClipBarOwnerType();
				$clipBarOwner->owner_type = strtolower($this->owner->fromWhere); // assingn from where to owner_type property
				// if clipBarOwner is saved, pass the saved object to $ownerTypeModel
				if($clipBarOwner->save()){
					$ownerTypeModel = $clipBarOwner; // this should return an object of the just saved type
				}
			}
			
			$ownerTypeId = $ownerTypeModel->id;
			$getOwnerTypeId = ClipOwnerType::find()->select(['id'])->andWhere(['owner_type' => $getClassName])->one();// get just the id of ClipOwnerType model
			
			if(empty($getOwnerTypeId)){
				$clipOwnerType = new ClipOwnerType();
				$clipOwnerType->owner_type = strtolower($getClassName); // assingn class name to owner_type property
				
				// if clipOwnerType is saved, pass the saved object to $getOwnerTypeId
				if($clipOwnerType->save()){
					$getOwnerTypeId = $clipOwnerType; // this should return an object of the just saved type
				}
			}
			//Yii::warning(\yii\helpers\VarDumper::dumpAsString($this->retrieveClipBarOwner($this->owner->ownerId)), "HRER");
			$getClipBarId = ClipBar::find()->select(['id'])->andWhere(['owner_id' => $this->owner->ownerId])->andWhere(['owner_type_id' => $ownerTypeId])->one(); // fetch the clip bar it to be used to clip the clip and where type is = folder /component or task
			$clipBarOwner = $this->retrieveClipBarOwner($getClipBarId);
			/*Yii::$app->activityManager->includeMessage([
						'PREPEND' => "in {$clipBarOwner->shortClassName()} {$clipBarOwner->publicTitleofBarrm}",
						'OBJECT_ID' => $clipBarOwner->id,
						'OBJECT_SHORT_CLASS' => $clipBarOwner->shortClassName()
			]);*/
			$clipModel->owner_id = $this->owner->id; // assign owner id to clip 
			$clipModel->bar_id = $getClipBarId->id; // assign bar  id to clip 
			$clipModel->owner_type_id = $getOwnerTypeId->id; // assign owner type id to clip 
			$clipModel->save(); // save clip
			//var_dump($this->owner->fromWhere);
			Yii::warning("Just added a {$this->owner->publicTitleOfBarrm} with id of {$this->owner->id} ");
			
		}else{
			return;
		}
	}
	
	private function fixEdocumentClips(){
		
	}

	
	
	
}