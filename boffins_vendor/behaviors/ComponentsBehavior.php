<?php
/**
 * @copyright Copyright (c) 2017 Tycol Main (By Epsolun Ltd)
 */

namespace app\boffins_vendor\behaviors;


use Yii;
use yii\base\InvalidCallException;
use yii\base\UnknownPropertyException;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\ModelEvent;
use yii\db\BaseActiveRecord;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\models\Component as modelComponent;
use app\models\FolderComponent;
use app\models\EDocument;
use yii\web\UploadedFile;
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
class ComponentsBehavior extends Behavior
{
	
	//Public variables and arrays 
	
	/***
	 * Must be set to true if you want to use a new set of components.
	 * Default is false.
	 */
	public $newComponetsType = FALSE;
	
	/***
	 * component behavior output (subComponents) is returned with this public variable 
	 */
    public $subComponents;
	
	
    //public $eDocumentSubComponents; 
	
	/***
	 * by default there are 6 components , but there is room to increase the number of component using the public variable 'componentTypeSetting'. 
	 * add new components (and old components) and set $newComponetsType to true;
	 */
	public $componentTypeSetting = []; 
	
	/***
	 * set this to false if you do not want this behavior to set a component id before save. 
	 */
	public $setComponentID = true;
	
	/***
	 *  variable to set if you want this behavior to expose this feature. Dfault is true. Set to false to disable this feature.
	 */
	public $behaviorLinkFolders = true; //now redundant.
	
	/**
	 * const EVENT_BEFORE_CREATE_COMPONENT event triggered before a component id is generated. 
	 * This allows AR models to listen for this event if they wish to do special handling before 
	 * a component id is generated. 
	 */
	const EVENT_BEFORE_CREATE_COMPONENT = 'beforeCreateComponent';
	
	/**
	 * const EVENT_AFTER_CREATE_COMPONENT event triggered after a component id is generated. 
	 * This allows AR models to listen for this event if they wish to do special handling after 
	 * a component id is generated. 
	 */
	const EVENT_AFTER_CREATE_COMPONENT = 'afterCreateComponent';
	
	/**
	 * const EVENT_BEGIN_LINKING event triggered after a component id is generated and after before linking event. 
	 * This allows AR models to listen for this event if they wish to link any folders or components 
	 */
	const EVENT_BEGIN_LINKING = 'beginLinking';
	
	/**
	 * const EVENT_BEFORE_LINKING event triggered after a component id is definitely generated. 
	 * This allows AR models to listen for this event if they wish to populate the list of components/folders 
	 */
	const EVENT_BEFORE_LINKING = 'beforeLinking';

	/**
	 * const EVENT_AFTER_LINKING event triggered after the begin linking event. 
	 * This allows AR models to listen for this event if they wish to link any folders or components 
	 */
	const EVENT_AFTER_LINKING = 'afterLinking';

	
	//Private variables and arrays 
	
	/* 
	 * Default components for component behaviour 
	 */
	private $componentType = ['payment','project','order','correspondence','invoice','receivedpurchaseorder', 'product','edocument'];
	
	/* 
	 * This is the actual list of componetnts which is passed to the programm  
	 */
	private  $componentArrayTypeMerged ;

    //Function/Methods.
	
	/* Checks to see if owner is set as a new component 
	 * where added to the default component of if the default ???
	 * component should be replaced with a new set of components ???
	 */
    public function init()
    {
        parent::init();
		
		if($this->newComponetsType == TRUE){
			$this->componentArrayTypeMerged = $this->componentTypeSetting;	//I think there is a logical error here
		} elseif(!empty($this->componentTypeSetting)){
			$this->componentArrayTypeMerged = array_merge($this->componentType,$this->componentTypeSetting);	
		} else {
			$this->componentArrayTypeMerged = $this->componentType;
		}
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
			ActiveRecord::EVENT_AFTER_FIND => 'behaviorComponentAfterFind',
			ActiveRecord::EVENT_AFTER_VALIDATE => 'behaviorComponentAfterValidate', // name is to prevent possible clash with other behaviors or AR Model. 
			ActiveRecord::EVENT_AFTER_INSERT => 'behaviorComponentAfterSave', // commence linking on afer save event. 
			ActiveRecord::EVENT_AFTER_UPDATE => 'behaviorComponentAfterSave', // commence linking on afer save event. 
		];
   }
	
	/**
     * "behaviorComponentAfterFind" is now attached to the afterFind event which is triggered when a Yii2 FIND function is called by a model, 
	 * @return void
	 * assinges a value to  the public variable "subComponents" .
     */
	public function behaviorComponentAfterFind($event) 
	{
		
	   $this->subComponents = $this->mainComponent();
	}
	
	/**
     * every component has a relational table in the database which is used to filter each component sub components as
	 * such componentToComponent is a method which returns an array of related subcomponent for a particular component 
     */
	public function componentToComponent()
	{
		$componentId=[];// a blank array that holds the entire subcomponent id 
		
	/**
	* selectComponentToComponentModel' a method  that filters which table is the right component to component table 
	* using the owner class name as a  filter parameter 
	* findAllMatchingComponet hold the value of subcomponets related to the parent component 
 	*/
		$findAllMatchingComponet = $this->selectComponentToComponentModel(); 
		
		//loop through  findAllMatchingComponet and assing the componet id to "component_id" array  
		foreach($findAllMatchingComponet as $key => $value){
			array_push($componentId,$value['component_id']);
		}
		
		return array_values($componentId); // return the array value of "component_id" array 
	}
	
	/** 
	* "componentTable" this method represents the core database table responsible for the generations of components / 
	*/
	public function componentTable()
	{
		$getClassName = $this->owner->className().'Component';
		$ComponentJunction = \yii\helpers\StringHelper::basename(get_class($this->owner)).'_id';
		return $this->owner->hasMany($getClassName::className(), [$ComponentJunction => 'id']);
	}
	
	/**
	 * function to set a component and link it to the owner. - Anthony
	 * may be explicitly called from within an AR Model (not advised) 
	 * but be sure to set setComponentID to false in behavior settings.
	 * also trigger an event to permit the component to commence linking activities. 
	 * sets owner component id and returns true if successful (false if not successfull)
	 */
	public function behaviorComponentAfterValidate($event) //consider moving this function to run at before insert (event has to be created)
	{
		if ($this->setComponentID && $this->owner->isNewRecord ) {
			$beforeCreate = new ModelEvent;
			$this->owner->trigger(self::EVENT_BEFORE_CREATE_COMPONENT, $beforeCreate);
			if ($beforeCreate->isValid) {
				$shortClassName = lcfirst($this->_getShortClassName());
				$fullClassName = get_class($this->owner);
				$component = new modelComponent;
				$component->component_type = $shortClassName;
				$component->component_classname = $fullClassName; 
				$component->component_junction = $this->owner->junctionModel;
				$component->junction_foreign_key = $this->owner->junctionFK;
				if ( $component->save(false) ) {
					$this->owner->component_id = $component->id;
					$afterCreate = new ModelEvent;
					$this->owner->trigger(self::EVENT_AFTER_CREATE_COMPONENT, $afterCreate);
				}
			}
		}
		//this return creates a duplicate component id which does not have a component type in the database 
		//return empty($this->owner->component_id) ? false : true;
	}
	
	/**
	 * Simply triggers the event 'EVENT_BEGIN_LINKING' after a component has been issued a componnt id AND saved to the DB.
	 */
	public function behaviorComponentAfterSave($event) 
	{
		//trigger events to permit linking of folders and components 
		if ( !empty($this->owner->component_id) ) {
			$beginLinking = new ModelEvent;
			$this->owner->trigger(self::EVENT_BEGIN_LINKING, $beginLinking);
		} 
	}
		
	/* 
	 * guesses at the foreign key used by the owner to link to other components i.e. the foreign key in the component to component junction table. 
	 * this uses a standardised format - however, this is now deprecated. Use $this->owner->junctionFK instead.
	 */
	private function getOwnerJunctionForeignKeyName() 
	{
		$strippedOwnerClassName = $this->_getShortClassName();
		return key($this->owner->getPrimaryKey(true)) == 'id' ?  strtolower($strippedOwnerClassName) . '_id' : key($this->owner->getPrimaryKey(true));
	}
	
	/*** 
	 * Link components. Takes the private list of components from the FolderSubComponentARModel and links them
	 * This should only be called from with the FolderSubComponentARModel and only after the event 'beginLinking'
	 * is triggered. 
	 */ 
	public function linkComponents()
	{
		if ( !empty($this->getComponentsList()) ) {
			foreach ($this->getComponentsList() as $index => $component_id) {
				
				//first check if component is already in the list though
				$ownerClassName = get_class($this->owner) . 'Component'; //gives the full class name including namespace
				$currentItem = new $ownerClassName; //use the full class name including namespace
				$strippedOwnerClassName = $this->_getShortClassName();
				$foreignColumn = $this->getOwnerJunctionForeignKeyName();
				$existingComponents = empty( $this->owner->getPrimaryKey() ) ? [] : $currentItem->find()->select( ['component_id as component_ids'] )->andWhere( [ "{$foreignColumn}" => $this->owner->getPrimaryKey() ] )->asArray()->all(); 
				if ( in_array($component_id, $existingComponents) ) {
					continue; //go to next loop. This component is already linked.
				}
				
				$currentItem->component_id = $component_id; //a COMPONENT must have a component id 
				$currentItem->$foreignColumn = $this->owner->getPrimaryKey();
				$currentItem->save(false); //component is linked to subcomponent
				
				//now ensure there is also a backward link as well - link the component in the list to this component
				$component = modelComponent::findOne($component_id);
				
				$componentClass = $component->component_classname; //new columns in the component table 
				$componentJunction = $component->component_junction; //new column in the component table 
				
				//$componentTable = $componentClass::tableName();
				//$componentStaging = new $componentClass;
				//$componentStaging->stopComponentBehaviors = true;
				$componentItem =  $componentClass::findOne(['component_id' => $component_id]);  //(new \yii\db\ActiveQuery($componentClass))->from($componentTable)->where(['component_id' => $component_id])->one();//$componentClass::findOne(['component_id' => $component_id ]) ;
				$componentToComponent = new $componentJunction;
				$componentToComponentFK = $component->junction_foreign_key; //new column in the component table
				$existingComponents = $componentToComponent->find()->select( ['component_id as component_ids'] )->andWhere( [ "{$componentToComponentFK}" => $componentItem->getPrimaryKey() ] )->asArray()->all(); 
				if ( in_array($this->owner->component_id, $existingComponents)  ) {
					continue; //go to next loop. A backward link exists.
				}
				$componentToComponent->component_id = $this->owner->component_id;
				$componentToComponent->$componentToComponentFK = $componentItem->getPrimaryKey();
				$componentToComponent->save(false); //back link completed
			}
		} else {
			// empty - do nothing 
			
			
			
		}
	}
	
	/***
	 * Link folders. Takes the private list of folders and links them using the FolderSubComponentARModel (or other model)
	 */ 
	public function linkFolders() 
	{
		if ( !empty( $this->getFoldersItems() ) ) {
			foreach ($this->getFoldersItems() as $index => $folder) {
				if (!empty($folder)) {
					//check if folder is already in the list though
					$currentItem = new FolderComponent;
					$existingFolders = empty($this->owner->component_id) ? [] : $currentItem->find()->select(['folder_id as folder'])->andWhere( ['component_id' => $this->owner->component_id ])->asArray()->all(); 
					if ( in_array($folder, $existingFolders) ) {
						continue; //next loop this folder is already linked.
					}
					$currentItem->component_id = $this->owner->component_id;
					$currentItem->folder_id = $folder; //should linking be refactored so that FolderComponent does the linking?
					$currentItem->save(false);
				}
			}
		} else {
			//do nothing 
			
		}
	}	
		
	/*
	 * returns the simple class name (stripping namespace) of $owner property.
	 */
	private function _getShortClassName()
	{
		$ownerClass = get_class($this->owner);
		$explodeClass = explode("\\", $ownerClass);
		$className = end($explodeClass);
		return $className;
	}
	
	/* 
	*  "mainComponent" is the actuall returns the method componentTable 
	*
	*/
	private function mainComponent()
	{
		return $this->componentTable();
	}
	
	/*
	 * using the yii2 query function to fetch data from the database 
	 */
	private function queryComponent($component,$searchValue){
		$fetchComponentValue = (new \yii\db\Query())
			->from($component)
			->where(['in','component_id',$searchValue])
			->all();
		return $fetchComponentValue;
	}
	
	/*
	* the "selectComponentToComponentModel" is a method which has a conditional statement, 
	* the aim of the private method is to return the right table which would be used as  the relationship table, 
	* by default there are 6 relational table but but new tables could be added 
	*/
	private function selectComponentToComponentModel()
	{
		$thisClass = get_class($this->owner);
		$explodeThisClass = explode("\\",$thisClass);
		$className = $explodeThisClass[2];
		$id = $className.'_id';
		
		switch ($className) {
			case 'Project':
				return $this->projectComponent();
				break;
			case 'EDcument':
				return $this->edocumentComponent();
				break;
			case 'Invoice':
				return $this->invoiceComponent();
				break;
			case 'Payment':
				return $this->paymentComponent();
				break;
			case 'Correspondence':
				return $this->correspondenceComponent();
				break;
			case 'Order':
				return $this->orderComponent();
				break;
			case 'Receivedpurchaseorder':
				return $this->receivedPurchaseOrderComponent();
				break;
			case 'Product':
				return $this->productComponent();
				break;
			default: 
				return $this->customComponent($id);
				
		}
		
	}
	
	/* projectComponent, invoiceComponent, orderComponent, paymentComponent, receivedPurchaseOrderComponent, correspondenceComponent, customComponent
	 * this methods are returned by the "selectComponentTcomponentModel"
	 * method and the individually hold the part to a specific model which is relevant in the fetching 
	 * and displaying of component subcomponents .
	 */
	private function projectComponent()
	{
		
		return  \app\models\ProjectComponent::findAll(['project_id'=>$this->owner->getPrimaryKey()]);
	}

	private function productComponent()
	{
		
		return  \app\models\ProductComponent::findAll(['product_id'=>$this->owner->getPrimaryKey()]);
	}
	
	private function invoiceComponent()
	{
		
		return \app\models\InvoiceComponent::findAll(['invoice_id'=>$this->owner->getPrimaryKey()]);
	}
	
	private function orderComponent()
	{
		
		return \app\models\OrderComponent::findAll(['order_number'=>$this->owner->getPrimaryKey()]);
	}
	
	private function paymentComponent()
	{
		return \app\models\PaymentComponent::findAll(['payment_id'=>$this->owner->getPrimaryKey()]);
	}
	
	private function receivedPurchaseOrderComponent()
	{
		return \app\models\ReceivedpurchaseorderComponent::findAll(['receivedpurchaseorder_reference'=>$this->owner->getPrimaryKey()]);
	}
	
	private function correspondenceComponent()
	{
		
		return \app\models\CorrespondenceComponent::findAll(['correspondence_id'=>$this->owner->getPrimaryKey()]);
	}
	private function edocumentComponent()
	{
		
		return \app\models\EDocumentComponent::findAll(['edocument_id'=>$this->owner->getPrimaryKey()]);
	}
	
	private function customComponent($id)
	{	
		$model = get_class($this->owner).'Component';
		return $model::findAll([$id=>$this->owner->getPrimaryKey()]);
		
	}
	
	/* 
	 * returns owners array of folders 
	 */ 
	private function getFoldersItems()
	{
		return $this->owner->_foldersList;
	}
	
	/* 
	 * returns owners array of components 
	 */ 
	private function getComponentsList()
	{
		return $this->owner->_componentsList;
	}

	/* 
	 * Create dynamic edocument
	 */ 
	
	public function createLikedEDocument()
	{
		/*
		* If primary key is not edocument_id then component can be linked 
		* but if the primary key is edocument_id the stop the linking 
		*/
		if($this->owner->junctionFK != 'edocument_id'){
			// if upload_file if not empty, basic validaton before starting to link
			if(!empty($this->owner->upload_file)){
				$edocument = new EDocument(); // init edocument 
				// Pass upload fule temp path to edocument upload_file property
				$edocument->upload_file = UploadedFile::getInstances($this->owner, 'upload_file');
				// save edocument file in upload directory by calling the global upload method
				// every dynamic edocument should have a reference, such reference should be the title or description of component been created, 
					$edocument->reference = $this->owner->descriptions; // description could be a property or a method of a model
					// if edocument have been saved then it should instantly be attached so it could be linked to linked with newly created component.
					/*
					* unset upload_file to prevent 'finfo_file(/Applications/XAMPP/xamppfiles/temp/phpdhFfdn): 
					* failed to open stream: No such file or directory'  error
					*/
					//$test = $edocument->upload_file = null;
					$edocument->scenario = EDocument::EDocumentLinking;
				if ($edocument->upload()) {
					/*
					* if itemType and itemID have values , then add edocument to it, 
					* else link only edocument
					* Note this was done to make sure already selected linked component are not overwrite by the
					* newly created edocument component which is to be linked to the associated component.
					*/
					if(!empty($this->owner->itemType) && !empty($this->owner->itemID)){
						$this->owner->itemType = $this->owner->itemType.',edocument';
						$this->owner->itemID = $this->owner->itemID.','.$edocument->component_id;
					} else{
						$this->owner->itemType = 'edocument';
						$this->owner->itemID = $edocument->component_id;
					}

					return true;

				}
			}
		} else{
			return true;
		}
		
	}
	
}
