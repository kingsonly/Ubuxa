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
  html, body * { box-sizing: border-box; font-family: 'Open Sans', sans-serif; }

body {
  background:
    linear-gradient(
    rgba(246,247,249,0.8),
    rgba(246,247,249,0.8)),
    url(https://dl.dropboxusercontent.com/u/22006283/preview/codepen/sky-clouds-cloudy-mountain.jpg) no-repeat center center fixed;
  background-size: cover;
}

.container {
  width: 100%;
  padding-bottom: 100px;
}

.frame {
  height: 575px;
  width: 65%;
  background: #37474f;
  background-size: cover;
  margin-left: auto;
  margin-right: auto;
  border-top: solid 1px rgba(255,255,255,.5);
  border-radius: 5px;
  box-shadow: 0px 2px 7px rgba(0,0,0,0.2);
  overflow: hidden;
  transition: all .5s ease;
}

.frame-long {
  height: 750px;
}

.frame-short {
  height: 400px;
  margin-top: 50px;
  box-shadow: 0px 2px 7px rgba(0,0,0,0.1);
  width: 40%;
}
    
@media screen and (max-width: 600px) {
.frame {
  height: 575px;
  width: 100%;
  background: #37474f;
  background-size: cover;
  margin-left: auto;
  margin-right: auto;
  border-top: solid 1px rgba(255,255,255,.5);
  border-radius: 5px;
  box-shadow: 0px 2px 7px rgba(0,0,0,0.2);
  overflow: hidden;
  transition: all .5s ease;
}
}

.nav {
  width: 100%;
  height: 100px;
  padding-top: 40px;
  opacity: 1;
  transition: all .5s ease;
}

.nav-up {
  transform: translateY(-100px);
  opacity: 0;
}

li {
  padding-left: 10px;
  font-size: 18px;
  display: inline;
  text-align: left;
  text-transform: uppercase;
  padding-right: 10px;
  color: #ffffff;
}


.signup-active a {
  cursor: pointer;
  color: #ffffff;
  text-decoration: none;
  border-bottom: solid 2px #1059FF;
  padding-bottom: 10px;
}

.signup-inactive a {
  cursor: pointer;
  color: rgba(255,255,255,.3);
  text-decoration: none;
  transition: all .25s ease;
}


.form-signup {
  width: 100%;
  height: 375px;
  font-size: 16px;
  font-weight: 300;
  padding-left: 37px;
  padding-right: 37px;
  padding-top: 20px;
  position: relative;
  top: -375px;
  left: 400px;
  opacity: 0;
  transition: all .6s ease;
  top: 0px;
}

.form-signup-left {
  transform: translateX(-399px);
  opacity: 1;
}

.form-signup-down {
  top: 0px;
  opacity: 0;
}

.success {
  width: 80%;
  height: 150px;
  text-align: center;
  position: relative;
  top: -890px;
  left: 450px;
  opacity: .0;
  transition: all .8s .4s ease;
}

.success-left {
  transform: translateX(-406px);
  opacity: 1;
}

.successtext {
  color: #ffffff;
  font-size: 16px;
  font-weight: 300;
  margin-top: 100%;
  padding-left: 37px;
  padding-right: 37px;
}

#check path {
    stroke: #ffffff;
    stroke-linecap:round;
    stroke-linejoin:round;
    stroke-width: .85px;
    stroke-dasharray: 60px 300px;
    stroke-dashoffset: -166px;
    fill: rgba(255,255,255,.0);
    transition: stroke-dashoffset 2s ease .5s, fill 1.5s ease 1.0s;
}

#check.checked path {
    stroke-dashoffset: 33px;
    fill: rgba(255,255,255,.03);
}

.form-signup input {
  color: #ffffff;
  font-size: 13px;
}

.form-styling {
  width: 100%;
  height: 35px;
  padding-left: 15px;
  border: none;
  border-radius: 20px;
  margin-bottom: 1px;
  background: rgba(255,255,255,.2);
}

label {
  font-weight: 400;
  text-transform: uppercase;
  font-size: 13px;
  padding-left: 15px;
  padding-bottom: 5px;
  color: rgba(255,255,255,.7);
  display: block;
}

:focus {outline: none;
}

 .form-signup input:focus, textarea:focus {
    background: rgba(255,255,255,.3);
    border: none; 
    padding-right: 40px;
    transition: background .5s ease;
 }

[type="checkbox"]:not(:checked),
[type="checkbox"]:checked {
  position: absolute;
  display: none;
}

[type="checkbox"]:not(:checked) + label,
[type="checkbox"]:checked + label {
  position: relative;
  padding-left: 85px;
  padding-top: 2px;
  cursor: pointer;
  margin-top: 8px;
}

[type="checkbox"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before,
[type="checkbox"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after {
  content: '';
  position: absolute;
}

[type="checkbox"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before {
  width: 65px; 
  height: 30px;
  background: rgba(255,255,255,.2);
  border-radius: 15px;
  left: 0; 
  top: -3px;
  transition: all .2s ease;
}

[type="checkbox"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after {
  width: 10px; 
  height: 10px;
  background: rgba(255,255,255,.7);
  border-radius: 50%;
  top: 7px; 
  left: 10px;
  transition: all .2s ease;
}

/* on checked */
[type="checkbox"]:checked + label:before {
  background: #0F4FE6; 
}

[type="checkbox"]:checked + label:after {
  background: #ffffff;
  top: 7px; 
  left: 45px;
}

[type="checkbox"]:checked + label .ui,
[type="checkbox"]:not(:checked) + label .ui:before,
[type="checkbox"]:checked + label .ui:after {
  position: absolute;
  left: 6px;
  width: 65px;
  border-radius: 15px;
  font-size: 14px;
  font-weight: bold;
  line-height: 22px;
  transition: all .2s ease;
}

[type="checkbox"]:not(:checked) + label .ui:before {
  content: "no";
  left: 32px;
  color: rgba(255,255,255,.7);
}

[type="checkbox"]:checked + label .ui:after {
  content: "yes";
  color: #ffffff;
}

[type="checkbox"]:focus + label:before {
  box-sizing: border-box;
  margin-top: -1px;
}

.btn-signup {
  float: left;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 13px;
  text-align: center;
  color: #ffffff;
  padding-top: 8px;
  width: 50%;
  height: 35px;
  border: none;
  border-radius: 20px;
  margin-top: 23px;
  background-color: #1059FF;
  margin-left: 25%;
}


.btn-animate {
  float: left;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 13px;
  text-align: center;
  color: rgba(255,255,255, 1);
  padding-top: 8px;
  width: 100%;
  height: 35px;
  border: none;
  border-radius: 20px;
  margin-top: 23px;
  background-color: rgba(16,89,255, 1);
  left: 0px;
  top: 0px;
  transition: all .5s ease, top .5s ease .5s, height .5s ease .5s, background-color .5s ease .75s; 
}

.btn-animate-grow {
  width: 130%;
  height: 625px;
  position: relative;
  left: -55px;
  top: -420px;
  color: rgba(255,255,255,0);
  background-color: rgba(255,255,255,1);
}

a.btn-signup:hover {
    cursor: pointer; 
    background-color: #0F4FE6;
    transition: background-color .5s; 
}


</style>
<div class="container">
    <div class="frame">
        <div class="nav">
          <ul class"links">
            <li class="signup-active"><a class="btn">Get Started </a></li>
          </ul>
        </div>
        <div ng-app ng-init="checked = false">
           
            <?php $form = ActiveForm::begin(['enableClientValidation' => true, 'attributes' => $customerForm->attributes(),'enableAjaxValidation' => false, 'options' => [
                'class' => 'form-signup']
            ]); ?>

              <div class="form-group">
                <?= $form->field($customerForm, 'master_email')->textInput(['maxlength' => true, 'class' => 'form-styling']) ?>

                <?= $form->field($customerForm, 'master_doman')->textInput(['maxlength' => true, 'class' => 'form-styling']) ?>

                <?= $form->field($customerForm, 'billing_date')->textInput(['maxlength' => true, 'class' => 'form-styling']) ?>

                <?= $form->field($customerForm, 'account_number')->textInput(['maxlength' => true, 'minlenght'=>6, 'class' => 'form-styling']) ?>
                <?= $form->field($customerForm, 'plan_id')->dropDownList(ArrayHelper::map(Plan::find()->all(),'id', 'title'), ['prompt'=> Yii::t('customer', 'Choose Plan'), 'options' => ['class' => 'form-styling'] ]) ?>
            </div>

                    <?= Html::submitButton($customerForm->isNewRecord ? '<span ng-click="checked = !checked" class="btn-signup">Next</span> <img id="userloader" src="images/45.gif" " /> <span id="userloader1"><span>' : 'Update', ['class' => $customerForm->isNewRecord ? 'btn btn-danger' : 'btn btn-danger','id'=>'usersubmit_id']) ?>

            <?php ActiveForm::end(); ?>
            <div class="success">
              <svg id="check" ng-class="checked ? 'checked' : ''">
                <div class="successtext">
                   <p> Thanks for signing up! Check your email for confirmation.</p>
                </div>
            </div>
        </div>
    </div>
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

$(document).ready(function () {
    $(".form-signup").toggleClass("form-signup-left");
    $(".frame").toggleClass("frame-long");

});

$(function() {
  $(".btn-signup").click(function() {
  $(".nav").toggleClass("nav-up");
  $(".form-signup-left").toggleClass("form-signup-down");
  $(".success").toggleClass("success-left"); 
  $(".frame").toggleClass("frame-short");
  });
});

JS;
 
$this->registerJs($js);
?>

