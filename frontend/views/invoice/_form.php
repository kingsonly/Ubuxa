<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\money\MaskMoney;
use kartik\date\DatePicker;
use app\boffins_vendor\components\controllers\ComponentLinkWidget;


/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form_input {
        resize:none;
        width:100%;
    }
	
	#invoiceloader, 
	#invoiceloader1 {
		display: none;
	}
</style>
<div class="invoice-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => true,'options' => ['enctype' => 'multipart/form-data'],'id'=>'invoiceform', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	
	<?= ComponentLinkWidget::widget(['model'=>$model,'form'=>$form]); ?> 
	
	
	
    <?= $form->field($model, 'invoice_reference')->textInput(['maxlength' => true, 'class' => 'form_input']) ?>
	
    
	
	<?= $form->field($model, 'receivedpurchaseorder_id')->dropDownList($receivedpurchaseorders, ['prompt'=> $language['RPODropDownPrompt'], 'options' => ['class' => 'form_input'] ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => '6', 'maxlength' => '255', 'class' => 'form_input form_form_input']) ?>

    <?= $form->field($model, 'amount')->widget(MaskedInput::classname(), $currency_settings)  ?>
	
    <?= $form->field($model, 'currency_id')->dropDownList($currencies, [ 'prompt'=> $language['currencyDropDownPrompt'], 'options' => ['class' => 'form_input'] ]) ?>
    
	<?= $form->field($model, 'creation_date')->widget(DatePicker::classname(), [
							'options' => ['placeholder' => 'Select creation date ...','id' => 'creation_date'],
							 'pluginOptions' => [
								 'format' => 'dd/mm/yyyy',
								 'todayHighlight' => true
									],
								
								])  ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span id="invoicebuttonText">Create</span> <img id="invoiceloader" src="images/45.gif" " /> <span id="invoiceloader1"><span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-basic' : 'btn btn-basic','id'=>'invoicesubmit_id']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$url = Url::to(['/invoice/create']);
$invoiceform = <<<JS

$('#invoiceform').on('beforeSubmit', function (e) {
	$('#invoiceformbuttonText').hide();
 	$('#invoiceloader').show();
	formData = new FormData(this);
    var \$form = $(this);
	
	
	$.ajax( {
      url: '$url',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
	  success: function(data){
	  $('#edocumentbuttonText').hide();
 		$('#edocumentloader').hide();
	  if(data == 1){
	  	$('#edocumentloader1').show().html('Created Successfully');
	  }else{
	  	$('#edocumentloader1').show().html('Opps An Error Ocored !');
	  }
	  
	  
	
	setTimeout(function(){
		$(document).find('#flash').hide();
	}, 10000);
               
           }
    } );
	
	
	
 
	
	setTimeout(function(){ 
		$(document).find('#invoiceloader').hide();
		$(document).find('#invoiceloader1').hide();
		$(document).find('#invoicebuttonText').show();
	}, 5000);
    return false;
    
    
    
});
JS;
 
$this->registerJs($invoiceform);
?>


