<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use frontend\models\Plan;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Tmuser */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
#userloader,#userloader1{
display: none;
}
</style>
<div class="user-form">


    <?php $form = ActiveForm::begin(['enableClientValidation' => true, 'attributes' => $customerForm->attributes(),'enableAjaxValidation' => false,'id' => 'customerForm']); ?>

     
    <div  class="indexFormContainer">
        <section class="indexFormTitle"> Basic info </section>
        <?= $form->field($customerForm, 'master_email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($customerForm, 'master_doman')->textInput(['maxlength' => true]) ?>

        <?= $form->field($customerForm, 'billing_date')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Select billing date ...','id' => 'datepicker'],
                             'pluginOptions' => [
                                 'format' => 'dd/mm/yyyy',
                                 'todayHighlight' => true
                                    ],
                                ]) 
        ?>
    </div>
        <section class="indexFormTitle" > Customer details </section>
        <?= $form->field($customerForm, 'account_number')->textInput(['maxlength' => true, 'minlenght'=>6]) ?>
        <?= $form->field($customerForm, 'plan_id')->dropDownList(ArrayHelper::map(Plan::find()->all(),'id', 'title'), ['prompt'=> Yii::t('customer', 'Choose Plan'), 'options' => ['class' => 'form_input'] ]) ?>
    <div class="indexFormContainer">
    <div class="form-group">
        <p>

            <br>
            <?= Html::submitButton($customerForm->isNewRecord ? '<span id="userbuttonText">Next</span> <img id="userloader" src="images/45.gif" " /> <span id="userloader1"><span>' : 'Update', ['class' => $customerForm->isNewRecord ? 'btn btn-danger' : 'btn btn-danger','id'=>'usersubmit_id']) ?>

        </p>
    </div>

    <?php ActiveForm::end(); ?>
   
</div>


<?php
$js = <<<JS

$('#customerForm').on('beforeSubmit', function (e) {
    $('#userbuttonText').hide();
    $('#userloader').show();
    var \$form = $(this);
    $.post(\$form.attr('action'),\$form.serialize())
    .always(function(result){
    
    $(document).find('#userloader').hide();
   if(result == 'sent'){
       
       $(document).find('#userloader1').html(result).show();
       
    
    }else{
    $(document).find('#userloader1').html(result).show();
    
    }
    }).fail(function(){
    console.log('Server Error');
    });
    
    setTimeout(function(){ 
    $(document).find('#userloader').hide();
    $(document).find('#userloader1').hide();
    $(document).find('#userbuttonText').show();
    }, 5000);
    return false;
    
    
    
});

JS;
 
$this->registerJs($js);
?>

