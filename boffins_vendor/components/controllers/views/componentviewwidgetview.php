<?php
use boffins_vendor\components\controllers\DisplayLinkedComponents;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use frontend\models\ComponentAttributeModel;
use yii\helpers\Url; 
use boffins_vendor\components\controllers\FolderUsersWidget;
use frontend\models\Onboarding;
use frontend\models\Remark;
use frontend\models\Component;
use boffins_vendor\components\controllers\RemarksWidget;
	
		
/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$remark = new Remark();
$userId = Yii::$app->user->identity->id;
$componentCreateUrl = Url::to(['component/create']);
$onboardingExists = Onboarding::find()->where(['user_id' => $userId])->exists(); 
$onboarding = Onboarding::findOne(['user_id' => $userId]);
?>
<style>
	/*
#invoicecontent{
	background: #fff;
	margin-top: 20px;
	min-height: 600px;
}
	 */
	.position-absolute{
		position: absolute;
		right: 0;
	}
	.display-none{
		display: none;
	}
	
	.position-absolute .fa{
		cursor: pointer;
	}
	.adjust-font{
		font-size-adjust: 0.8;
	}
</style>
		<div class="">
			<div style="width:100%">
				<span class="position-absolute">
					<i class="fa fa-expand"></i>
					<i class="fa fa-window-minimize display-none"></i>
					<i class="fa fa-remove"></i>
				</span>
			
			</div>
			<div class="" id="invoicecontent">
				<div class="box-body">

				
					<?
					$id = 0;
					foreach($content as $key => $value){
						
						//var_dump($value->getComponentAttribute());
						$model = new ComponentAttributeModel();
						$model->attributeId = $value->id ;
						$model->value = $value->title ;
						$id = $value->id;
						
						echo ViewWithXeditableWidget::widget(['model'=>$model,'attributeName' => 'Element title','editableId' =>'modelid-'.$model->attributeId,'editableArea'=>'component','modelUrl' =>Url::to(['component/update-title','id' => $model->attributeId]),'attributues'=>[
					['modelAttribute'=>'value','xeditable' => 'short_string',],
					
					]]);
						$i = 1;
						
						echo FolderUsersWidget::widget(['attributues'=>$users,'id'=>$value->id,'type' => 'component','listOfUsers' => $listOfUsers]);
						
						foreach($value->getComponentAttribute() as $attributeKey => $attributeValule){
							
							${'model'.$i} = new ComponentAttributeModel();
							${'model'.$i}->attributeId = $attributeValule['id'] ;
							${'model'.$i}->value = $attributeValule['value'] ;
							
							if( $attributeValule['type'] == 'integer'){
									echo ViewWithXeditableWidget::widget(['model'=>${"model".$i},'attributeName' => $attributeValule['name'],'editableId' =>'modelid-'.${'model'.$i}->attributeId,'editableArea'=>'component','modelUrl' => Url::to(['component/update-integer-value','id' => ${'model'.$i}->attributeId]),'attributues'=>[
					['modelAttribute'=>'value','xeditable' => $attributeValule['type'],'typeName' => $attributeValule['typeName']],
					
					]]);
							}elseif($attributeValule['type'] == 'known_class'){
									echo ViewWithXeditableWidget::widget(['model'=>${"model".$i},'attributeName' => $attributeValule['name'],'editableId' =>'modelid-'.${'model'.$i}->attributeId,'editableArea'=>'component','modelUrl' =>Url::to(['component/update-known-class-value','id' => ${'model'.$i}->attributeId]),'attributues'=>[
					['modelAttribute'=>'value','xeditable' => $attributeValule['type'],'typeName' => $attributeValule['typeName']],
					
					]]);
								
							}else{
									echo ViewWithXeditableWidget::widget(['model'=>${"model".$i},'attributeName' => $attributeValule['name'],'editableId' =>'modelid-'.${'model'.$i}->attributeId,'editableArea'=>'component','modelUrl' => Url::to(['component/update-value','id' => ${'model'.$i}->attributeId]),'attributues'=>[
					['modelAttribute'=>'value','xeditable' => $attributeValule['type'],'typeName' => $attributeValule['typeName']],
					
					]]);
								
							}
						
								
							 
							$i++;
						}
					}
					
					?>
					
					
					
				</div>
			</div>
		</div> 
<? $component = Component::findOne($id); 
	
?>
<?//= RemarksWidget::widget(['remarkModel' => $remark, 'parentOwnerId' => $id,'modelName'=>'folder', 'remarks' => $component->clipOn['remark'], 'onboardingExists' => $onboardingExists, 'onboarding' => $onboarding, 'userId' => $userId,'location' => 'component']) ?>
	



<?
$jsComponentView = <<<JS
$(document).find('.position-absolute .fa-expand').click(function(){
	$(document).find('#view-content').removeClass('col-xs-4').addClass('col-xs-12 adjust-font');
	$(document).find('#listView').hide();
	$(this).hide();
	$('.position-absolute .fa-window-minimize').show();
	 
})

$(document).find('.position-absolute .fa-window-minimize').on('click',function(){

	$(document).find('#view-content').removeClass('col-xs-12 adjust-font').addClass('col-xs-4');
	$(document).find('#listView').show();
	$(this).hide();
	$('.position-absolute .fa-expand').show();
	 
})

$(document).find('.position-absolute .fa-remove').on('click',function(){

	$(document).find('#view-content').hide().removeClass('adjust-font');
	$(document).find('#listView').show().addClass('col-xs-12').removeClass('col-xs-8');
	 
})

JS;
 
$this->registerJs($jsComponentView);
?>
