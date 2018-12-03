<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;



/* @var $this yii\web\View */
/* @var $model app\models\Tmuser */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

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
.photoEdit:before{
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.photoEdit{
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
.photoEdit:hover{
  background: #f1f1f1;
  border-color: #d6d6d6;
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
.progress-button {
  position: relative;
  overflow: hidden;
  display: inline-block;
  border-radius: 1px;
  outline: none;
  border: none;
  background: #628dd7;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 3px;
  font-size: 1.2em;
  line-height: 2;
  box-shadow: none;
  cursor: pointer;
  transition: all .2s ease-in-out;
  display: block;
  margin: auto;

}

.progress-button:hover {
  border-radius: 16px 1px;
}

.progress-button .content {
  position: relative;
}

.progress-button .progress-load{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #29529a;
  transform: translateX(-100%);
  transition: transform .2s ease;
}

.progress-button.photo-loading .progress-load {
  transform: translateX(0%);
  transition: transform 2s cubic-bezier(0.59, 0.01, 0.41, 0.99);
}
.bot-border{
	padding-left: 15px;
}
.box-body{
	box-shadow: -1px 3px 20px -2px rgba(0,0,0,0.1);
}
.profile_name{
	color: #00b1b1;
	text-transform: capitalize;	
}
.profile_role{
	text-transform: capitalize;
}
</style>



	<div class="row">
        
        
       <div class="col-md-12 ">

<div class="panel panel-default">
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
            	<?php $form = ActiveForm::begin(['enableAjaxValidation' => false,'id' => 'userform', 'options' => ['enctype' => 'multipart/form-data']]); ?>
	
					<div class="avatar-upload">
				        <div class="avatar-edit">

				            <?= $form->field($model, 'profile_image')->fileInput(['id' => 'imageUpload'])->label('<i class="fa fa-pencil photoEdit" aria-hidden="true"></i>'); ?>
				            
				        </div>
				        <div class="avatar-preview">
				            <div id="imagePreview" style="background-image: url(<?= $model->profile_image; ?>);">
				            </div>
				        </div>
				    </div>
						<?= Html::submitButton('<span class="progress-load"></span>
  						<span class="content">Upload</span>',['class' => 'progress-button']) ?>
				<?php ActiveForm::end(); ?>
            <div class="col-sm-6">
	            <h4 class="profile_name"><?= yii::$app->user->identity->fullName; ?></h4></span>
	              <span><p class="profile_role"><?= $model->roleName; ?></p></span>            
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
	<hr style="margin:5px 0 5px 0;">

	<div class="col-sm-12 col-xs-12">Date Of Birth: <?= ViewWithXeditableWidget::widget(['model'=>$person,'attributues'=>[
	                                ['modelAttribute'=>'dob','xeditable' => 'datetime'],
	                                ]]); ?>                           
	</div>
	
	<hr style="margin:5px 0 5px 0;">
	<div class="col-sm-6">Username:</div>
	<div class="col-md-6"><?=$model->username; ?></div>

	<div class="col-md-6">Email:</div>
	<div class="col-md-6"><?= $model->email; ?></div>
      

            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
       
            
    </div> 
    </div>
</div>         
   </div>

<?php
$uploadUrl = Url::to(['user/update']);
$profile = <<<JS
	function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
$(document).ready(function(){
    $('.progress-button').hide();   
});
$('.progress-button').click(function() {
  $(this).toggleClass('photo-loading');
});
$('.photoEdit').click(function(){
	$('.progress-button').show();
});

$('#userform').on('beforeSubmit', function (e) {
	e.preventDefault();
	e.stopImmediatePropagation();
	var form = $(this);
	var formData = new FormData(form[0]);
   $.ajax({
        url: '$uploadUrl',     
        data: formData,                         
        type: 'post',
        success: function(res){
        	setTimeout(function(){
        	 $('.progress-button').hide();
        	 $('.progress-button').removeClass('photo-loading'); 
        	 }, 2000);
        },
        error: function(res){
        },
        cache: false,
        contentType: false,
        processData: false,
     });
    return false;

});


JS;
$this->registerJs($profile);
?>
