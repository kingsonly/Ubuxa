<?php
namespace app\boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use app\models\Component;
use app\models\EDocument;
?>


<?php 
/*
* This widget is designed to display all linked components
* linked component has to do with attachments of other components to another component
* for users to be able to relate with this dynamically linked component, this widget was created to provide a 
* graphycal interface for the presentation of the linked component.
* 
* Note this widget is actually dragable and has a view which is not displayed in this widget file 
* 		Files included for this widget 
*			1) web/js/dashboard.js (this page has a set of javascript rules)
*			2) app/components/controllers/views/displaylinkedcomponents.php ( hold both html and php rules )
* Has 4 public property and two public methods
*************** BAsic Usage **********************
*	use app\boffins_vendor\components\controllers\DisplayLinkedComponents;
*	<?= DisplayLinkedComponents::widget([
*		'subComponents' => $subComponents,
*		'files' => $files,
*	]); ?>
*/
class DisplayLinkedComponents extends Widget{
	public $subComponents; // get component linked components as an array 
	public $files; // public property used only in edocument, to merge linked edocumen  with  default edocuments 
	/*
	* Cause edocument is a unique componet subcomponent which are edocumnet would have to be subtracted
	* as such it does not follow the nurmal order of linked component
	* subtracted component from subComponents property would be pushed to eDocumentSubcomponent
	**/
	public $eDocumentSubcomponent =[]; 
	public $edocumentModel; //  model instance 
	
	 
	public function init()
	{
		parent::init();
		
	}
	
	
	public function run(){
		$subComponents = [];// holds all subcomponent details
		// loop through all subcomponents as sent by the component behaviour .
		$this->edocumentModel = new EDocument(); // edocument instance 
		foreach($this->subComponents as $key => $value){
			$componentDetails = Component::findOne($value['component_id']);
			array_push($subComponents,$componentDetails);
		}
		
		return $this->render('displaylinkedcomponents',[
			'subComponents' => $subComponents,
			'files' => $this->files,
			'eDocumentSubcomponent' => $this->eDocumentSubcomponent,
			'edocumentModel' => $this->edocumentModel,
		]);
	}
	
	
}


?>


