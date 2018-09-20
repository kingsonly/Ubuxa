<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use frontend\models\Role;
use frontend\models\Country;



/* @var $this yii\web\View */
/* @var $model app\models\Tmuser */
/* @var $form yii\widgets\ActiveForm */
?>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<style>
#userloader,#userloader1{
display: none;
}
*{
  margin:0;
  padding:0;
}
html{
  height:100%;
  background: #ccc;
}
body{
  font-family: 'Montserrat', sans-serif;
}
#form-id{
  width: 65%;
  margin:50px auto;
  text-align:center;
  position: relative;
}
#form-id fieldset{
  border:0 none;
  border-radius:3px;
  box-sizing:border-box;
  padding:20px 30px;
  width:100%;
  margin:0 10%;
  position: relative;  
}
#form-id fieldset:not(:first-of-type){
  display:none;
}

#form-id input{
  border:1px solid #ccc;
  border-radius:3px;
  padding:15px;
  color:#2C3E50;
  font-family: 'Montserrat', sans-serif;
  margin-bottom:10px;
  font-size:13px;
  box-sizing:border-box; 
  width:100%;
}
#form-id .custom-button{
  width:30%;
  background: #3B5998;
  font-weight: bold;
  color:#fff;
  border:0;
  pointer:cursor;
  padding:10px;
  margin:10px;
  border-radius: 5px;  
}

.form-control{
  height:50px;
  box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.3);
}

#form-id .custom-button:hover{
  box-shadow:0 0 0 2px #fff, 0 0 0 4px #3B5998;
}
.title{
  font-size:30px;
  margin-bottom:10px;
  color:#2C3E50;
  text-transform:uppercase;
}
.sub-title{
  font-size:13px;
  margin-bottom:20px;
  font-weight:normal;
  color:#666;
}

.input {
  border-radius: 5px;
    padding: 10px;
    width: 80%;
    overflow: hidden;
    font-family: 'Lato';
    font-weight: 400;
    font-size: 16px;
    position: relative;
    margin: 5px;
}
.heading{
    padding-right: 50%
}
.under_title{
    padding-right: 30%;
}

.prev-button{
    width: 10%;
    padding: 10px;
    border-radius: 5px;
    background: #3B5998;
    border: 0;
}

.prev-button:hover{
  box-shadow:0 0 0 2px #fff, 0 0 0 4px #3B5998;
}

</style>
<div class="user-form">


    <?php $form = ActiveForm::begin(['enableClientValidation' => true, 'attributes' => $userForm->attributes(),'enableAjaxValidation' => false,'id' => 'form-id']); ?>

        <fieldset>
            <div class='heading'>
                <h2 class='title'>Personal Details</h2>
            </div>
            <div class="input">
                <?= $form->field($userForm, 'first_name')->textInput()->input('first_name', ['placeholder' => "Enter Your First Name"])->label(false); ?>

                <?= $form->field($userForm, 'surname')->textInput(['maxlength' => true])->input('surname', ['placeholder' => "Enter Your Surname"])->label(false) ?>

                <?= DatePicker::widget([
                'name' => 'dob', 
                'value' => date('d-M-Y', strtotime('+2 days')),
                'options' => ['placeholder' => 'Select issue date ...'],
                'pluginOptions' => [
                  'format' => 'dd-M-yyyy',
                  'todayHighlight' => true
                ]
              ]); ?>
            </div>
            <?= Html::button('Contact Details <i class="fa fa-arrow-right"></i>', ['class' => 'next-button custom-button']) ?>
        </fieldset>
        <fieldset>
            <div class='heading'>
                <h2 class='title'>Contact Details</h2>
            </div>
            <div class="input">
                

                <?= $form->field($userForm, 'telephone_number')->textInput(['maxlength' => true])->input('first_name', ['placeholder' => "Phone Number"])->label(false) ?>
            </div>
                <?= Html::button('<i class="fa fa-arrow-left"></i>', ['class' => 'prev-button']) ?>
                <?= Html::button('Proceed to Address <i class="fa fa-arrow-right"></i>', ['class' => 'next-button custom-button']) ?>
        </fieldset>

        <fieldset>
            <div class='heading'>
                <h2 class='title'>Address</h2>
            </div>
            <div class="input">
                <?= $form->field($userForm, 'address_line')->textInput(['maxlength' => true])->input('address_line', ['placeholder' => "Address"])->label(false) ?>

                <?= $form->field($userForm, 'country_id')->dropDownList(ArrayHelper::map(Country::find()->all(),'id', 'name'), ['prompt'=> Yii::t('user', 'Choose Country'), 'options' => ['class' => 'form_input'] ])->label(false) ?>

                <?= $form->field($userForm, 'state_id')->textInput(['maxlength' => true])->input('state_id', ['placeholder' => "Choose state"])->label(false) ?>

                <?= $form->field($userForm, 'code')->textInput(['maxlength' => true])->input('code', ['placeholder' => "Enter Your Zip code"])->label(false) ?>
            </div>
            
            <?= Html::button('<i class="fa fa-arrow-left"></i>', ['class' => 'prev-button']) ?>
                <?= Html::button('Login Details <i class="fa fa-arrow-right"></i>', ['class' => 'next-button custom-button']) ?>
        </fieldset>
        <fieldset>
            <div class="heading">
                <h2 class='title'>Set your username and password</h2>
            </div>
            <div class="input">
                <?= $form->field($userForm, 'username')->textInput(['maxlength' => true, 'minlenght'=>8])->input('first_name', ['placeholder' => "Enter your username"])->label(false) ?>
                <?= $form->field($userForm, 'password')->passwordInput()->input('password', ['placeholder' => "Enter Your password"])->label(false) ?>
            </div>
            <?= Html::button('<i class="fa fa-arrow-left"></i>', ['class' => 'prev-button']) ?>
                <?= Html::button('Proceed to Role <i class="fa fa-arrow-right"></i>', ['class' => 'next-button custom-button']) ?>
        </fieldset>
        <fieldset>
            <div class="heading">
                <h2 class='title'>Role</h2>
            </div>
            <div class="input">
                <?= $form->field($userForm, 'basic_role')->dropDownList(ArrayHelper::map(Role::find()->all(),'id', 'name'), ['prompt'=> Yii::t('user', 'Choose Role'), 'options' => ['class' => 'form_input'] ]) ?>
            </div>
            <?= Html::button('<i class="fa fa-arrow-left"></i>', ['class' => 'prev-button']) ?>
                <?= Html::submitButton($userForm->isNewRecord ? '<span id="userbuttonText">Signup</span> <img id="userloader" src="images/45.gif" " /> <span id="userloader1"><span>' : 'Update', ['class' => $userForm->isNewRecord ? 'btn btn-danger' : 'btn btn-danger','id'=>'usersubmit_id']) ?>
        </fieldset>
    <?php ActiveForm::end(); ?>
   

</div>
<?php 
$js = <<<JS

$('#userform').on('beforeSubmit', function (e) {
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

$(document).ready(function(){
  $('.next-button').click(function(){
        var current = $(this).parent();
        var next = $(this).parent().next();
        $(".progress li").eq($("fieldset").index(next)).addClass("active");
        current.hide();
        next.show();
  })
  
  $('.prev-button').click(function(){
        var current = $(this).parent();
        var prev = $(this).parent().prev()
        $(".progress li").eq($("fieldset").index(current)).removeClass("active");
        current.hide();
        prev.show();
  })
})
JS;
 
$this->registerJs($js);
?>


