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

	
	public function behaviorBeforeDelete($event) 
	{
		// this method is to be called just before the clip is actually deleted
		$clipBarModel = new ClipBar();// instatnciate clipbar
		$clipOwnerTypeModel = new ClipOwnerType();// instatnciate clipownertypemodel
		$ownerId = $this->owner->id;// owners id 
		$ownerType = $this->_getShortClassName($this->owner) ;// get class name eg remaks
		$ownerTypeId = $this->_getShortClassName($this->owner) == 'Folder'?1:2;// Change this fetch from the db 
		$getClipBar = $clipBarModel->find()->andWhere(['owner_id' => $ownerId,'owner_type_id' => $ownerTypeId])->one();// find clip bar
		$findClipOwnerType = $clipOwnerTypeModel->find()->select(['id'])->andWhere(['owner_type' => $ownerType])->asArray()->one();// find clip owner type 
		$findClip = Clip::find()->andWhere(['owner_type_id' => $findClipOwnerType,'owner_id' => $ownerId])->one();// find clip using ownertype id
		// delete clip 
		if($findClip->delete()){
			// check is deletedt clip has a bar 
			if(!empty($getClipBar)){
				// delete bar 
				$getClipBar->delete();
			}
		}
		
	}
	
	public function fetchAllClipOn()
	{
		$this->getClipDetails();// method to fetch all clipons
	}
	
	public function specificClips($ownerid=0,$ownerTypeId=1,$offset=0,$limit=1,$ownerType='remark')
	{
		// public funtion to be used outside of behaviour to fetch all clips and attache a limitatio
		// quite usefull when creating an infinit scrol 
		
		$clipBarModel = new ClipBar(); // instanciate clip bar 
		$ownerId = $ownerid;// this could be folder id, but specifically the model a user is accessing
		
		//$ownerTypeId = $this->_getShortClassName($this->owner) == 'Folder'?1:2; // validate if owner is a folder or a component or something else 
		
		$getClipBarcount = $clipBarModel->find()->andWhere(['owner_id' => $ownerId])->count(); // check to see if specified element has a clipbar *** which would be used for checkig in the below if clause ******
		
		$getClipBar = $clipBarModel->find()->andWhere(['owner_id' => $ownerId,'owner_type_id' => $ownerTypeId])->one();
		// if the bar exist then get all its clips 
		if($getClipBarcount  !== '0'){
			if(!empty($getClipBar->clips)){
				$getClips = $this->owner->specificClipsWithLimitAndOffset($limit,$offset,$ownerTypeId,$getClipBar->id);
				$getArrayValues = [];
				foreach($getClips as $value){
					array_push($getArrayValues,$value['owner_id']); // convert clip owners id 
				}
				return  $this->tagetClipTypes($ownerType,array_values($getArrayValues));// retuen clips
			}
			return;
			
		}else{
			return ;
		}
		
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

	private function getAllClips()
	{
		$clipBarModel = new ClipBar(); // clipbar instance 
		$ownerId = $this->owner->id; // owners id usually the folder id
		$ownerTypeId = $this->_getShortClassName($this->owner) == 'Folder'?1:2; // to be changed once component is done , holds static value depending if owner class is a folder or a component
		$getClipBarcount = $clipBarModel->find()->andWhere(['owner_id' => $ownerId])->count();// used to make sure a clip exist 
		$getClipBar = $clipBarModel->find()->andWhere(['owner_id' => $ownerId,'owner_type_id' => $ownerTypeId])->one(); // get clip bar id which would be used to fetch all clips associated to the bar 
		
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
		
		$getClassName = $this->_getShortClassName($this->owner) == 'Folder'?'folder':'component'; // determine owner class name and make them lower case and in terms of component convert their names to components , note this code would be reviewed and this comment would be changed, as such as long as this comment is here, this this code is yet to be reviewed .
		
		$searchOwnerTypeId = $ownerTypeModel->find()->select(['id'])->andWhere(['owner_type' => $getClassName])->one();// get the id of the ownertype eg folder component etc
		
		$clipBarModel->owner_id = $this->owner->id; // assign clipBarModel->owner_id with the owner id
		$clipBarModel->owner_type_id = $searchOwnerTypeId->id; // determine if its a folder or a component etc options could be more than just folder or components 
		$clipBarModel->save(false); // save bar 
		
	}
	
	private function _getShortClassName($classMethod)
	{
		return (new \ReflectionClass($classMethod))->getShortName();// use to strip out name space in a class name
	}
	
	private function createClipOn()
	{
		if(!empty($this->owner->ownerId)){
			//$clipOwnerTypeModel = new ClipOwnerType(); // instatnciate ClipOwnerType model
			//$clipBarModel  = new ClipBar(); // instatnciate clip bar model 
			$clipModel  = new Clip(); //instanciate clip model
			$getClassName = $this->_getShortClassName($this->owner); // convert class name to string and strip out name space 
			
			$getOwnerTypeId = ClipOwnerType::find()->select(['id'])->andWhere(['owner_type' => $getClassName])->one();// get just the id of ClipOwnerType model
			
			$getClipBarId = ClipBar::find()->select(['id'])->andWhere(['owner_id' => $this->owner->ownerId])->one(); // fetch the clip bar it to be used to clip the clip 
			$clipModel->owner_id = $this->owner->id; // assign owner id to clip 
			$clipModel->bar_id = $getClipBarId->id; // assign bar  id to clip 
			$clipModel->owner_type_id = $getOwnerTypeId->id; // assign owner type id to clip 
			$clipModel->save(); // save clip
			
		}else{
			return;
		}
	}
	
	
	
	
}
