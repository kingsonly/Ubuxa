<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use frontend\models\Component;
?>


<?php 
/*
* This component is desinged with the aim to reduce the duplication of html codes
* as such with this widget developers can focus on building the component logic and the controllers
* while when it comes to graphical representation of a single component, this widget would aid.
* as such having a single view for displaying all component after selection has been made.
* Presently this component has 5 public properties and 2 public models
* Function and names of properties amd method are listed and explained below .
* 
*	public $model;  //Component Model.
	public $viewAttributes;  // Content to be displayed on the view page 
	public $subComponents; // Component which are related to a specific component
	public $title; // Title of the component to be displayed boldly on the view.
	public $files; // edocument linked to this conponent are held in this property .
*
********************* Component Usage ************************************************
* Developer must include name space as as sshow below 
* 	use app\boffins_vendor\components\controllers\ComponentViewWidget;
	$description = 'description'; // this holds the title 
	$viewAttributes = [
				'receivedpurchaseorder_id',
				'description',
				[
				 'label' => 'Amount',
				'value' => $model->owner->currencyAndAmount,
				],

				[
					'label' => 'Date created',
					'value' => $model->owner->creation_date,
				],

				'last_updated',


			];   // holds the view attributes Note what ever is on this list is what would be displayed for a user to see and interact with .
			
	 echo ComponentViewWidget::widget([
										'model'=>$model, //holds the component model instance 
										'subComponents'=>$subComponents, holds subcomponents linked to the component
										'viewAttributes'=>$viewAttributes, // Component view details
										'title'=>$description, // component view title 
									]); ?>
*/

class ComponentViewWidget extends Widget{
	public $model; //Component Model.
	public $viewAttributes; // Content to be displayed on the view page 
	public $subComponents; // Component which are related to a specific component
	public $title; // Title of the component to be displayed boldly on the view.
	public $files; // edocument linked to this conponent are held in this property .
	
	 
	public function init()
	{
		parent::init();
		
	}
	
	
	public function run(){
		$modelClassName = \yii\helpers\StringHelper::basename(get_class($this->model));
		return $this->render('componentviewwidgetview',[
			'model' => $this->model,
			'viewAttributes' => $this->viewAttributes,
			'subComponents' => $this->subComponents,
			'modelClassName' => $modelClassName,
			'title' => $this->title,
			'files' => $this->files,
		]);
	}
	
	
}


?>


