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
?>
<div class="site-login">
<style>
	.user-image{
		width:inherit;
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
		  <?= Html::img('@web/images/ubu.png', ['alt' => 'logo', 'class' => 'user-image' ]); ?>
		  <br>
        
      </div>
        <div class="login-box-body">
			<?php if (Yii::$app->session->getFlash('error') !== NULL): ?>
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
              <a href="<?= Url::to(['site/customersignup']);?>">Forgot Password </a>
            </label>
          </div>
        </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
