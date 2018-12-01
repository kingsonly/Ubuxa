<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use frontend\models\Role;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDb */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
input.hidden {
    position: absolute;
    left: -9999px;
}

#profile-image1 {
    cursor: pointer;
  
     width: 100px;
    height: 100px;
  border:2px solid #03b1ce ;}
  .title{ font-size:14px; font-weight:500;}
   .bot-border{ border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0}  
   body {
  background: whitesmoke;
  font-family: 'Open Sans', sans-serif;
}
h1 {
  font-size: 20px;
  text-align: center;
  margin: 20px 0 20px;
}
h1 small {
  display: block;
  font-size: 15px;
  padding-top: 8px;
  color: gray;
}
.avatar-upload {
  position: relative;
  max-width: 205px;
  margin: 50px auto;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 34px;
  height: 34px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #FFFFFF;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: 'FontAwesome';
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 192px;
  height: 192px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #F8F8F8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}

</style>

<div class="user-db-form">

    <?php $form = ActiveForm::begin(['id' => 'profile-form']); ?>

    <?= $form->field($person, 'first_name')->textInput() ?>

    <?= $form->field($person, 'surname')->textInput() ?>

    <?= $form->field($model, 'roleName')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'dob')->widget(DatePicker::classname(), [
							'options' => ['placeholder' => 'Select Date Of Birth ...','id' => 'datepicker'],
							 'pluginOptions' => [
								 'format' => 'dd/mm/yyyy',
								 'todayHighlight' => true
									],
								]) 
	?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success profileButton']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="container">
	<div class="row">
		 <h2>Your Profile</h2>
        
        
       <div class="col-md-7 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h4>User Profile</h4></div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">

    <div class="avatar-upload">
        <div class="avatar-edit">
            <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
            <label for="imageUpload"></label>
        </div>
        <div class="avatar-preview">
            <div id="imagePreview" style="background-image: url(http://i.pravatar.cc/500?img=7);">
            </div>
        </div>
    </div>
            <div class="col-sm-6">
            <h4 style="color:#00b1b1;"><?= yii::$app->user->identity->fullName; ?></h4></span>
              <span><p><?= $model->roleName; ?></p></span>            
            </div>
            <div class="clearfix"></div>
            <hr style="margin:5px 0 5px 0;">
    
	<div class="row bot-border">              
		<div class="col-md-6"><?= ViewWithXeditableWidget::widget(['model'=>$person,'attributues'=>[
		                        ['modelAttribute'=>'first_name'],
		                        ]]); ?></div>

		<div class="col-md-6"><?= ViewWithXeditableWidget::widget(['model'=>$person,'attributues'=>[
		                        ['modelAttribute'=>'surname'],
		                        ]]); ?></div>
	</div>


<div class="col-sm-5 col-xs-6 title">Date Of Birth:</div><div class="col-sm-7"><?= ViewWithXeditableWidget::widget(['model'=>$person,'attributues'=>[
                                ['modelAttribute'=>'dob','xeditable' => 'datetime'],
                                ]]); ?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 title">Username:</div><div class="col-sm-7"><?=$model->username; ?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 title">Email:</div><div class="col-sm-7"><?= $model->email; ?></div>
      

 <div class="clearfix"></div>
<div class="bot-border"></div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
       
            
    </div> 
    </div>
</div>         
   </div>
</div>

<?php 
$profile = <<<JS

JS;
$this->registerJs($profile);
?>
