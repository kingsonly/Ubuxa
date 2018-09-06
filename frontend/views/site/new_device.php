<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

$this->title = 'Get your new device approved';
$this->params['breadcrumbs'][] = 'Approve Device';
?>
<div class="site-login">
    <style>
	.user-image{
		width:80px;
		height:80px;
		border-radius: 20px 20px 20px 20px ;
	}
	.login-box-msg {
		margin: 0;
		text-align: left;
		padding: 0 10px 10px 10px;
		font-size: 18px;
    }
	.login-box-body{
		overflow: auto;
		padding: 5px;
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
				
            <p class="login-box-msg">Click to begin the process of approving your device</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form','enableClientValidation' => true,
     'enableAjaxValidation' => false,]); ?>
            
            <div class="col-xs-8 pull-left" style="padding-left: 0px !important">
        </div>

            <div class="form-group pull-right" id ="login-button">
            
          <?= Html::submitButton('Approve', ['class' => 'btn btn-danger', 'name' => 'login-button']) ?>
        
                    
                
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
