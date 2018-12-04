<?php
use boffins_vendor\components\controllers\DisplayLinkedComponents;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use frontend\models\ComponentAttributeModel;
use yii\helpers\Url; 
use boffins_vendor\components\controllers\FolderUsersWidget;
	
		
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
						
						echo ViewWithXeditableWidget::widget(['model'=>$model,'attributeName' => 'Element title','editableId' =>'modelid-'.$model->attributeId,'editableArea'=>'component','modelUrl' =>Url::to(['component/update-title','id' => $model->attributeId]),'attributues'=>[
					['modelAttribute'=>'value','xeditable' => 'short_string',],
					
					]]);
						$i = 1;
						
						echo FolderUsersWidget::widget(['attributues'=>$users,'id'=>$value->id,'type' => 'component','listOfUsers' => $listOfUsers]);
						
						foreach($value->getComponentAttribute() as $attributeKey => $attributeValule){
							${'model'.$i} = new ComponentAttributeModel();
							${'model'.$i}->attributeId = $attributeValule['id'] ;
							${'model'.$i}->value = $attributeValule['value'] ;
							echo ViewWithXeditableWidget::widget(['model'=>${"model".$i},'attributeName' => $attributeValule['name'],'editableId' =>'modelid-'.${'model'.$i}->attributeId,'editableArea'=>'component','modelUrl' => $attributeValule['type'] != 'known_class'?Url::to(['component/update-value','id' => ${'model'.$i}->attributeId]):$attributeValue['type'] == 'Number'?Url::to(['component/update-integer-value','id' => ${'model'.$i}->attributeId]):Url::to(['component/update-known-class-value','id' => ${'model'.$i}->attributeId]),'attributues'=>[
					['modelAttribute'=>'value','xeditable' => $attributeValule['type'],'typeName' => $attributeValule['typeName']],
					
					]]);
								
							 
							$i++;
						}
					}
					
					?>
					
					
					
				</div>
			</div>
		</div> 
	


