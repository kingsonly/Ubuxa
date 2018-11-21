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
<div class="sponsor" title="Click to flip">
	<div class="sponsorFlip" style="background:red !important">
		<div class="">
			<div class="box" id="invoicecontent">
				<div class="box-body">

				<? $model = new ComponentAttributeModel();
					$model->attributeId = 'yes';
					$model->value = 1;

					?>
					<?
					foreach($content as $key => $value){
						//var_dump($value->getComponentAttribute());
						echo $value->title;
						$i = 1;
						foreach($value->getComponentAttribute() as $attributeKey => $attributeValule){
							${'model'.$i} = new ComponentAttributeModel();
							${'model'.$i}->attributeId = $attributeValule['id'] ;
							${'model'.$i}->value = $attributeValule['value'] ;
							echo ViewWithXeditableWidget::widget(['model'=>${"model".$i},'editableId' =>'modelid-'.${'model'.$i}->attributeId,'editableArea'=>'component','attributues'=>[
					['modelAttribute'=>'value','xeditable' => $attributeValule['type'],],
					
					]]);
							 
							$i++;
						}
					}
					
					?>
					
					
					
				</div>
			</div>
		</div> 
	</div>


</div>

