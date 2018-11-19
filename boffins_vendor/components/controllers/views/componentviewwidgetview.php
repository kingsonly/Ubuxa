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
					$model->value = '';

					?>
					
					<?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
					['modelAttribute'=>'value'],
					
					]]); ?>
					
					
				</div>
			</div>
		</div> 
	</div>


</div>

