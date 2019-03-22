<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$subdomain = join('.', explode('.', $_SERVER['HTTP_HOST'], -2));

?>

<style>
	body {
  margin: 0;
  height: 100%;
  overflow: hidden;
  width: 100% !important;
  box-sizing: border-box;
  font-family: "Roboto", sans-serif;
}
.container{
	width: 100%;
	padding-left: 0px !important;
}

.backRight {
  position: absolute;
  right: 0;
  width: 50%;
  height: 100%;
  background: #03A9F4;
}

.backLeft {
  position: absolute;
  left: 0;
  width: 50%;
  height: 100%;
  background-image: url("images/Ubuxa-1.png");
  background-repeat: no-repeat;
  background-size: 100% 100%;
}

#back {
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: -999;
}

.canvas-back {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 10;
}

#slideBox {
  width: 50%;
  max-height: 100%;
  height: 100%;
  overflow: hidden;
  margin-left: 50%;
  position: absolute;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}

.topLayer {
  width: 200%;
  height: 100%;
  position: relative;
  left: 0;
  left: -100%;
}

label {
  font-size: 0.8em;
  text-transform: uppercase;
}

input {
  background-color: transparent;
  border: 0;
  outline: 0;
  font-size: 1em;
  padding: 8px 1px;
  margin-top: 0.1em;
}

.left {
  width: 50%;
  height: 100%;
  overflow: scroll;
  background: #2C3034;
  left: 0;
  position: absolute;
}
.left label {
  color: #e3e3e3;
}
.left input {
  border-bottom: 1px solid #e3e3e3;
  color: #e3e3e3;
}
.left input:focus, .left input:active {
  border-color: #03A9F4;
  color: #03A9F4;
}
.left input:-webkit-autofill {
  -webkit-box-shadow: 0 0 0 30px #2C3034 inset;
  -webkit-text-fill-color: #e3e3e3;
}
.left a {
  color: #03A9F4;
}

.right {
  width: 50%;
  height: 100%;
  overflow: scroll;
  background: #f9f9f9;
  right: 0;
  position: absolute;
}
.right label {
  color: #212121;
}
.right input {
  border-bottom: 1px solid #212121;
}
.right input:focus, .right input:active {
  border-color: #673AB7;
}
.right input:-webkit-autofill {
  -webkit-box-shadow: 0 0 0 30px #f9f9f9 inset;
  -webkit-text-fill-color: #212121;
}

.content {
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 100%;
  width: 80%;
  margin: 0 auto;
  position: relative;
}

.content h2 {
  font-weight: 300;
  font-size: 2.6em;
  margin: 0.2em 0 0.1em;
}

.left .content h2 {
  color: #03A9F4;
}

.right .content h2 {
  color: #273163;
}

.form-element {
  margin: 1.6em 0;
}
.form-element.form-submit {
  margin: 1.6em 0 0;
}

.form-stack {
  display: flex;
  flex-direction: column;
}

.checkbox {
  -webkit-appearance: none;
  outline: none;
  background-color: #e3e3e3;
  border: 1px solid #e3e3e3;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
  padding: 12px;
  border-radius: 4px;
  display: inline-block;
  position: relative;
}

.checkbox:focus, .checkbox:checked:focus,
.checkbox:active, .checkbox:checked:active {
  border-color: #03A9F4;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px 1px 3px rgba(0, 0, 0, 0.1);
}

.checkbox:checked {
  outline: none;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05), inset 15px 10px -12px rgba(255, 255, 255, 0.1);
}

.checkbox:checked:after {
  outline: none;
  content: '\2713';
  color: #03A9F4;
  font-size: 1.4em;
  font-weight: 900;
  position: absolute;
  top: -4px;
  left: 4px;
}

.form-checkbox {
  display: flex;
  align-items: center;
}
.form-checkbox label {
  margin: 0 6px 0;
  font-size: 0.72em;
}

button {
  padding: 0.8em 1.2em;
  margin: 0 10px 0 0;
  width: auto;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 1em;
  color: #fff;
  line-height: 1em;
  letter-spacing: 0.6px;
  border-radius: 3px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
  border: 0;
  outline: 0;
  transition: all 0.25s;
}
button.signup {
  background: #03A9F4;
}
button.login {
  background: #273163;
}
button.off {
  background: none;
  box-shadow: none;
  margin: 0;
}
button.off.signup {
  color: #03A9F4;
}
button.off.login {
  color: #273163;
}

button:focus, button:active, button:hover {
  box-shadow: 0 4px 7px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
}
.signup:focus, .signup:active, .signup:hover {
  box-shadow: 0 4px 7px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
}
a:focus.signup, a:active.signup, a:hover.signup {
  background: #0288D1;
  color: #fff;
}
button:focus.login, button:active.login, button:hover.login {
  background: #00b8ff;
}
button:focus.off, button:active.off, button:hover.off {
  box-shadow: none;
}
.signup:focus.off, .signup:active.off, .signup:hover.off {
  box-shadow: none;
}
a:focus.off.signup, a:active.off.signup, a:hover.off.signup {
  color: #03A9F4;
  background: #212121;
}
button:focus.off.login, button:active.off.login, button:hover.off.login {
  color: #512DA8;
  background: #e3e3e3;
}

@media only screen and (max-width: 768px) {
  #slideBox {
    width: 80%;
    margin-left: 20%;
  }

  .signup-info, .login-info {
    display: none;
  }
}
#loginform-username{
	border-radius: 10px;
}
#loginform-password{
	border-radius: 10px;
}
.checkbox{
	outline: none;
    background-color: unset;
    border: unset;
    box-shadow: unset;
    padding: 0px; 
    border-radius: 0px; 
    display: unset;
    position: relative;
}
input[type=checkbox]{
	margin-top: -28px;
}
.signup{
	background: #273163;
    padding: 0.8em 1.2em;
    margin: 0 10px 0 0;
    width: auto;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 1em;
    color: #fff;
    line-height: 1em;
    letter-spacing: 0.6px;
    border-radius: 3px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
    border: 0;
    outline: 0;
    transition: all 0.25s;
}
.reset{
	margin-top: 10px;
}
</style>
 <!--
   <div class="login-box">
      <div class="login-logo">
		  <?//= Html::img('@web/images/ubu.png', ['alt' => 'logo', 'class' => 'user-image' ]); ?>
		  <br>
        
      </div>
        <div class="login-box-body">
			<?/*php  if (Yii::$app->session->getFlash('error') !== NULL): ?>
				<?php echo Alert::widget([
					'options' => ['class' => 'alert-danger'],
					'body' => Yii::$app->session->getFlash('error'),
					]);?>
				<?php endif ?>
				
            <p class="login-box-msg">Sign into  <?//= $accountName;?></p>
        <?php $form = ActiveForm::begin(['id' => 'login-form','enableClientValidation' => true,
     'enableAjaxValidation' => false,]); ?>

            <?= $form->field($model, 'username',['options'=>[
                'tag'=>'div',
                'class'=>'form-group has-feedback field-loginform-username required'],
                                                 
                'template'=>'{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>{error}{hint}'
                    ])->textInput(['placeholder'=>'User Name']) ?>

            <?= $form->field($model, 'password',['options'=>[
                'tag'=>'div',
                'class'=>'form-group has-feedback field-loginform-password required'],
                'template'=>'{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{error}{hint}'
                    ])->passwordInput(['placeholder'=>'Password']) ?>

            
            
            <div class="col-xs-8 pull-left" style="padding-left: 0px !important">
          <div class="checkbox icheck">
            <label>
              <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </label>
          </div>
        </div>

            <div class="form-group pull-right" id ="login-button">
            
          <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
        
                    
                
            </div>
			
			<div class="col-xs-12 pull-left" style="padding-left: 0px !important">
          <div class="checkbox icheck">
            <label>
				<a href="<?= Url::to(['site/customersignup','plan_id' => 1]);?>">Sign Up</a></br>
              <a href="<?= Url::to(['site/request-password-reset']);?>">Forgot Password </a>
            </label>
          </div>
        </div>

            <?php ActiveForm::end(); */?>
        </div>

    </div>
</div>
-->

<div id="back">
  <canvas id="canvas" class="canvas-back"></canvas>
  <div class="backRight">    
  </div>
  <div class="backLeft">
  </div>
</div>

<div id="slideBox">
  <div class="topLayer">
    <div class="right">
      <div class="content">
        <h2>Login</h2>
        <?php  if (Yii::$app->session->getFlash('error') !== NULL): ?>
				<?php echo Alert::widget([
					'options' => ['class' => 'alert-danger'],
					'body' => Yii::$app->session->getFlash('error'),
					]);?>
		<?php endif ?>
         <?php $form = ActiveForm::begin(['id' => 'login-form','enableClientValidation' => true,
     'enableAjaxValidation' => false,]); ?>
          <div class="form-element form-stack">
            <label for="username-login" class="form-label">Username <?=$subdomain;?></label>
            <?= $form->field($model, 'username',['options'=>[
                'tag'=>'div',
                'class'=>'form-group has-feedback field-loginform-username required','id' => 'username-login'],
                                                
                'template'=>'{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>{error}{hint}'
                    ])->textInput(['placeholder'=>'User Name'])->label(false); ?>
          </div>
          <div class="form-element form-stack">
            <label for="password-login" class="form-label">Password</label>
            <?= $form->field($model, 'password',['options'=>[
                'tag'=>'div',
                'class'=>'form-group has-feedback field-loginform-password required', 'id' => 'password-login'],
                'template'=>'{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{error}{hint}'
                    ])->passwordInput(['placeholder'=>'Password'])->label(false); ?>
          </div>
          		<label for="checkbox-lab">Remember me</label>
              <?= $form->field($model, 'rememberMe',['options' => ['class' => 'checkbox-lab']])->checkbox()->label(false); ?>
          <div class="form-element form-submit">
            <button id="logIn" class="login" type="submit" name="login">Log In</button>
            <a class="signup" href="<?= Url::to(['site/customersignup','plan_id' => 1]);?>">Sign Up</a>
          </div>
          <?= $form->field($model, 'domain')->hiddenInput(['value' => 'ubuxa'])->label(false); ?>
          <?php ActiveForm::end(); ?>
          <div>
          	<a class="reset" href="<?= Url::to(['site/request-password-reset']);?>">Forgot Password </a>
          </div>
      </div>
    </div>
  </div>
</div>

<?php 
$signupUrl = Url::to(['site/customersignup','plan_id' => 1]);
$indexJs = <<<JS
var sub_domain = window.location.split('.')[0].split('//')[1];
console.log('sub domain:'+sub_domain);
/* ====================== *
 *  Toggle Between        *
 *  Sign Up / Login       *
 * ====================== */
$(document).ready(function(){
  $('#goRight').on('click', function(){
    $('#slideBox').animate({
      'marginLeft' : '0'
    });
    $('.topLayer').animate({
      'marginLeft' : '100%'
    });
  });
  $('#goLeft').on('click', function(){
    if (window.innerWidth > 769){
      $('#slideBox').animate({
        'marginLeft' : '50%'
      });
    }
    else {
      $('#slideBox').animate({
        'marginLeft' : '20%'
      });
    }
    $('.topLayer').animate({
      'marginLeft': '0'
    });
  });
});



JS;
 
$this->registerJs($indexJs);
?>
