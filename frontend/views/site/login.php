<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
<style>
	.user-image{
		width:80px;
		height:80px;
		border-radius: 20px 20px 20px 20px ;
	}
	
	.login-box-body{
		/*min-height:220px;*/
	}
	
	#login-form {
		overflow: hidden;
	}
	
	.checkbox, .radio {
		margin-top: 0;
		margin-bottom: 0;
		padding: 7.5px;
	}
	
	.checkbox.icheck {
		padding: 0;
	}
	
	.form-group {
		margin-bottom: 0;
	}
</style>

   <div class="login-box">
      <div class="login-logo">
		  <?= Html::img('@web/images/logo1.png', ['alt' => 'logo', 'class' => 'user-image' ]); ?>
		  <br>
        <a href="#" style="color:#000 !important;"><b>Tycol</b>Main</a>
      </div>
        <div class="login-box-body">
			<?php if (Yii::$app->session->getFlash('error') !== NULL): ?>
				<?php echo Alert::widget([
					'options' => ['class' => 'alert-danger'],
					'body' => Yii::$app->session->getFlash('error'),
					]);?>
				<?php endif ?>
				
            <p class="login-box-msg">Sign in to start your session</p>
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
            
          <?= Html::submitButton('Login', ['class' => 'btn btn-danger', 'name' => 'login-button']) ?>
        
                    
                
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
