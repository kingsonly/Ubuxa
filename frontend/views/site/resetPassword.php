<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


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
  padding-top: 50px;
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
  padding-left: 12px;
  padding-right: 24px;
  position: relative;
  top: -375px;
  left: 400px;
  opacity: 0;
  transition: all .6s ease;
  top: 0px;
}
.form-reset{
  padding-left: 12px;
  padding-right: 24px;  
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
  top: -600px;
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
  padding-top: 50px;
    padding-right: 12px;
  padding-left: 0px;
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


.input-box { position: relative; }


.unit { 
    color: #fff;
    position: absolute;
    display: block;
    right: 15px;
    top: 34px;
    z-index: 9;
    font-size: 15px;
    font-family: sans-serif;
    font-weight: 600;
  }
  .confirm-text{
    font-size: 23px;
  }
.links{
    padding-left: 0px;
}
.fill-text{
    color: #fff;
    padding-left: 15px;
}
.login-text{
    color: #fff;
    font-size: 18px;
    cursor: pointer;
}
.login{
    padding-left: 20px;
    margin-bottom: 10px;
}
</style>
<div class="container">
    <div class="frame">
        <div class="nav">
          <ul class="links">
            <li class="signup-active"><a class="btn">Reset Password </a></li>
          </ul>
        </div>
        <div ng-app ng-init="checked = false">
           
            <p class="fill-text">Please choose your new password:</p>

                        <?php $form = ActiveForm::begin(['id' => 'reset-password-form','id' => 'request-password-reset-form','enableClientValidation' => true, 'enableAjaxValidation' => false, 'options' => ['class' => 'form-reset']]); ?>

                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'class' => 'form-styling']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save <img id="loader" src="images/45.gif"/>', ['class' => 'btn-signup']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
            <div class="success">
              <svg id="check" ng-class="checked ? 'checked' : ''">
                <div class="successtext">
                   <p class="confirm-text">Please check your email to reset your password.</p>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$js = <<<JS

function inTest() {
  $(".nav").toggleClass("nav-up");
  $(".form-signup-left").toggleClass("form-signup-down");
  $(".success").toggleClass("success-left"); 
  $(".frame").toggleClass("frame-short");
}

/* function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
} */

$('#reset-password-form').on('beforeSubmit', function (e) {
    //e.preventDefault();
    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            inTest();
            $(".fill-text,.form-reset, .login").css("display","none");
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

