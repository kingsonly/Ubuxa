<?php
use boffins_vendor\components\controllers\DisplayLinkedComponents;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use frontend\models\ComponentAttributeModel 
	
		
/* @var $this yii\web\View */
/* @var $model app\models\Payment */
?>
<style>
	/*
#invoicecontent{
	background: #fff;
	margin-top: 20px;
	min-height: 600px;
}
	 */
</style>
		<div class="">
			<div class="" id="invoicecontent">
				<div class="box-body">

				
					<?
					foreach($content as $key => $value){
						
						//var_dump($value->getComponentAttribute());
						$model = new ComponentAttributeModel();
						$model->attributeId = $value->id ;
						$model->value = $value->title ;
						
						echo ViewWithXeditableWidget::widget(['model'=>$model,'attributeName' => 'Element title','editableId' =>'modelid-'.$model->attributeId,'editableArea'=>'component','attributues'=>[
					['modelAttribute'=>'value','xeditable' => 'short_string',],
					
					]]);
						$i = 1;
						foreach($value->getComponentAttribute() as $attributeKey => $attributeValule){
							${'model'.$i} = new ComponentAttributeModel();
							${'model'.$i}->attributeId = $attributeValule['id'] ;
							${'model'.$i}->value = $attributeValule['value'] ;
							echo ViewWithXeditableWidget::widget(['model'=>${"model".$i},'attributeName' => $attributeValule['name'],'editableId' =>'modelid-'.${'model'.$i}->attributeId,'editableArea'=>'component','attributues'=>[
					['modelAttribute'=>'value','xeditable' => $attributeValule['type'],],
					
					]]);
							 
							$i++;
						}
					}
					
					?>
					
					
					
				</div>
			</div>
		</div> 
	


