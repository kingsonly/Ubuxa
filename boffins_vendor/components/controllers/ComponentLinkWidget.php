<?php
namespace boffins_vendor\components\controllers;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii;
?>


<?php 
/*
* ComponentLinkWidget was designed to make it easy for developers to attach componet linking feature to the creation 
* of new component in an easy manner.
* as such this feature is attached to any form which is responsible to carring out the creation action for new 
* componet
*  Note : Most of the havy lifting has been done buy javascript .
* (check out *present_derectory/views/componentlinkview.php) for more details on functionality of the widget
*********************  Basic Usage *************************
*	use app\boffins_vendor\components\controllers\ComponentLinkWidget;
*	<?= ComponentLinkWidget::widget(['model'=>$model,'form'=>$form]); ?> 
*
**/
class ComponentLinkWidget extends Widget{
	public $model; // public function of original form model
	
	public $form; // active form instance 
	 
	public function init()
	{
		parent::init();
		
	}
	
	// output the outcome of loopmenu
	public function run(){
		return $this->render('componentlinkview',[
			'model' => $this->model,
			'form' => $this->form,
		]);
	}
	
	
	
}


?>

