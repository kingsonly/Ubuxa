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
	
	<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Sent!</h4>
         <?= Yii::$app->session->getFlash('success') ?>
		<p>
		<? if(is_array($users)){?>
		<? foreach($users as $key => $value){ ?>
				<? if(!empty($value->nameString)){?>
					<?= $value->nameString;?><br/>
				<? }elseif(!empty($value->comOrPersonName)){?>
					<?= $value->comOrPersonName.'<br/>';?>
				<?}?>
			
			<? }}else{ ?>
			<? if(!empty($users->nameString)){?>
					<?= $users->nameString;?><br/>
				<? }elseif(!empty($users->comOrPersonName)){?>
					<?= $users->comOrPersonName.'<br/>';?>
				<?}?>
			
			<? } ?>
		</p>
		
    </div>
<?php endif; ?>
	
    <?php $form = ActiveForm::begin(['enableClientValidation' => true,'options' => ['enctype' => 'multipart/form-data'],'id'=>'emailform']); ?>
	
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true, 'class' => 'form_input']) ?>
	
    
	
	

    <?= $form->field($model, 'body')->textarea(['rows' => '6', 'maxlength' => '255', 'class' => 'form_input form_form_input']) ?>

    
    <div class="form-group">
        <?= Html::submitButton('Send') ?>
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


