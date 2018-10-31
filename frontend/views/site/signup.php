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
#loader{
display: none;
}
  html, body * { box-sizing: border-box; font-family: 'Open Sans', sans-serif; }



.container {
  width: 100%;
  padding-bottom: 100px;
}

.frame {
  height: auto;
  width: 40%;
   background-image: linear-gradient(to top, #002f74, #234585, #3b5b95, #5472a5, #6d8ab5);
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
  height: auto;
}

.frame-short {
    height: auto;
  margin-top: 50px;
  box-shadow: 0px 2px 7px rgba(0,0,0,0.1);
  width: 40%;
}
    
@media screen and (max-width: 600px) {
.frame {
  height: auto;
  margin-top: 30px;
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

.frame-short {
  height: 280px;
    margin-top: 100px;
    box-shadow: 0px 2px 7px rgba(0,0,0,0.1);
    width: 100%;
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

.form-signup {
  width: 100%;
  height: auto;
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

.btn-signup {
  float: left;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 13px;
  text-align: center;
  color: #ffffff;
  width: 50%;
  height: 35px;
  border: none;
  border-radius: 20px;
  margin-top: 23px;
  background-color: #1059FF;
  margin-left: 25%;
}

</style>
<div class="container">
    <div class="frame">
        <div class="nav">
          <ul class"links">
            <li class="signup-active"><a class="btn">Sign Up</a></li>
          </ul>
        </div>
        <div ng-app ng-init="checked = false">
           
            <?php $form = ActiveForm::begin(['enableClientValidation' => true, 'attributes' => $userForm->attributes(),'enableAjaxValidation' => true, 'validationUrl' => ['site/ajax-validate-user-form'], 'options' => [
                'class' => 'form-signup', 'id' => 'userForm']
            ]); ?>

              <div class="form-group">
                <?= $form->field($userForm, 'first_name')->textInput(['maxlength' => true, 'class' => 'form-styling']) ?>

                <?= $form->field($userForm, 'surname')->textInput(['maxlength' => true, 'class' => 'form-styling']) ?>

                <?= $form->field($userForm, 'username')->textInput(['maxlength' => true, 'class' => 'form-styling']) ?>

                <?= $form->field($userForm, 'password')->passwordInput(['minlength' => true, 'class' => 'form-styling']) ?>
                <?= $form->field($userForm, 'password_repeat')->passwordInput(['minlength' => true, 'class' => 'form-styling']) ?>
            </div>
                    <div>
                    <?= Html::submitButton('Signup <img id="loader" src="images/45.gif"/>',['class' => 'btn-signup']) ?>
                    </div>

            <?php ActiveForm::end(); ?>
            <div class="success">
                
            </div>
        </div>
    </div>
</div>


<?php
$js = <<<JS

$('#userForm').on('beforeSubmit', function (e) {
    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            
        },
        error: function () {
            alert("Something went wrong");
        },
        beforeSend: function(){
            $("#loader").show()
        },
       
    });

    return false;
    
    
    
});

$(document).ready(function () {
    $(".form-signup").toggleClass("form-signup-left");
    $(".frame").toggleClass("frame-long");
});



JS;
 
$this->registerJs($js);
?>

