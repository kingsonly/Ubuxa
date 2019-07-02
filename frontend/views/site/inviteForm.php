<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Role;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


?>
<style type="text/css">

	h1 {
    font-size: 30px;
    font-family: calibri;
	}
	#add {
		margin-top: 25px;
	}
	.borderless td, .borderless th {
    border: none;
    border-top: none;
	}
	.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
		border-top: none;
	}

	.invite-form{
		border-top:1px solid #ccc;
		padding-top: 10px;
	}
	.invite-btn {
    margin-right: 80px;
    float: right;
	}
  .client_template{
    background-image:linear-gradient(#fff,#ccc);
  }
	#loading-folder-div-invite-users{
		display: none;
	}
</style>

<div class="">
	<div class="invite-form">
		<?php $form = ActiveForm::begin(['id' => 'add_email']); ?>
			<div class="table-responsive">  
	                <table class="table borderless" id="dynamic_field">  
	                    <tr class="dynamics">
	                    	<td> <?= $form->field($model, 'email[]')->textInput(['autofocus' => true,
	                    	'class' => 'form-control name_list' ]) ?> </td>
	                    	<td>
	                    		<?= $form->field($model, 'role[]')->dropDownList(ArrayHelper::map(Role::find()->all(),'id', 'name'), ['prompt'=> Yii::t('user', 'Choose Role'), 'options' => ['class' => 'form-control'] ]) ?>
	                    				
	                    	</td>
	                    	<td> <?= Html::button('Add more', ['class' => 'btn btn-success', 'name' => 'add', 
	                    	'id' => 'add']) ?> </td> 
	                    </tr>
	                  </table> 
	        <div class="form-group">
			<?= Html::submitButton('Send Invitation', ['class'=> 'btn btn-primary invite-btn', 'id' => 'submit-users-invite', 'name' => 'submit']); ?>
				<div id="loading-folder-div-invite-users" class="invite-btn"> <?= Yii::$app->settingscomponent->boffinsLoaderImage(); ?></div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>

<?php
$addUsers = $form->field($model, 'email[]')->textInput(['autofocus' => true, 'class' => 'form-control name_list' ]);
$addRoles = Html::button('Add more', ['class' => 'btn btn-success', 'name' => 'add', 'id' => 'add']); 

$inviteUrl = Url::to(['site/inviteusers']);

$js = <<<JS

$(document).ready(function(){      
      var i=1;

      $('#add').click(function(){  
      	  var index = $(this).closest('.dynamics').index();

      	  
          $(this).closest('.dynamics').clone().appendTo('#dynamic_field').find("#add").remove().end().html();
          if(index === 0){
      			$('.fa-remove').hide();
      	  }
      });
      $(document).on('click', '.fa-remove', function(){
      		var getIndex = $(this).closest('.dynamics').index();
      		if(getIndex === 0){
      			return false;
      		} else {
              $(this).closest('.dynamics').remove(); 
      		} 
      });  
    $('#add_email').on('beforeSubmit', function(e) {
	if($(document).find('.folderdetls').length > 0){
		var folderId = $(document).find('.folderdetls').data('folderid');
	}else{
		var folderId = 0;
	}
    var getform = $('#add_email').serialize();
        $.ajax({ 
            url:'$inviteUrl'+'&folderid='+folderId, 
		    method:"POST",  
            data:$('#add_email').serialize(),
            type:'json',
			beforeSend: function(msg){
        		$('#submit-users-invite').hide();
        		$('#loading-folder-div-invite-users').show();
				},
            success:function(data)  
            {
			if(data == 1){
				i=1;
				
               	$('.dynamic-added').remove();
                $('#add_email')[0].reset();
				$('.close-arrow').trigger('click');
				toastr.success('Invitation has been sent to all users.');
			}else{
				i=1;
				alert(123)
               	$('.dynamic-added').remove();
                $('#add_email')[0].reset();
				$('.close-arrow').trigger('click');
				toastr.error('something went wrong. ');
			}
         	$('#submit-users-invite').show();
        	$('#loading-folder-div-invite-users').hide();	
            }  
        });  
      });
    });  
JS;
 
$this->registerJs($js);
?>