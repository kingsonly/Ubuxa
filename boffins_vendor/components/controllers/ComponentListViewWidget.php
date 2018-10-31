<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
use app\models\Component;
?>


<?php 
/*
* This widget is designed to display all components list views 
* its aimed at porviding a single graphical representation of all list views
* Has a 5 public property and two public methods
**************** Basic Usage ****************
*	use app\boffins_vendor\components\controllers\ComponentListViewWidget; // attach to the top of the page 
*
*	$attributes = [
*				'receivedpurchaseorder_id',
*				'description',
*				'creation_date',
*				'Amount'=>'currencyAndAmount',
*			];
*	$action = [
*		'update'=> Url::to(['invoice/update']),
*		'delete'=> Url::to(['invoice/delete']),
*	];
*	
*
*	 ComponentListViewWidget::widget(
*	 [
*		'model'=>$model,
*		'content'=>$invoice,
*		'attributes'=>$attributes,
*		'hoverEffect'=>$hoverEffect,
*		'action'=>$action,
*
*	]); 
*
*/


class ComponentListViewWidget extends Widget{
	public $model; // component model  
	public $attributes; // this is a list of the model properties to be displayed on the view 
	public $content; // content to be looped in the display
	public $hoverEffect;  // an atribute that adds a hover effect to the widget view 
	public $action; // View and update action links are sent to this attribute.
	 
	public function init()
	{
		parent::init();
		
	}
	
	
	public function run(){
		$modelClassName = \yii\helpers\StringHelper::basename(get_class($this->model));
		return $this->render('componentlistviewwidgetview',[
			'model' => $this->model,
			'attributes' => $this->attributes,
			'modelClassName' => $modelClassName,
			'content' => $this->content,
			'hoverEffect' => $this->hoverEffect,
			'action' => $this->action,
			'icons' => $this->icons(),
		]);
	}
	/*
	* Private icons used to diaplay FA Fonts for action buttons 
	*
	*/
	private function icons(){
		return [
			'delete' => 'fa fa-trash',
			'update' => 'fa fa-pencil',
		];
	}
	
	
}


?>


