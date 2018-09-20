<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Role;
use yii\helpers\ArrayHelper;


?>
<style type="text/css">
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
</style>

<div class="container">
	<div class="invite-form">
		<?php $form = ActiveForm::begin(['id' => 'add_email']); ?>
			<div class="table-responsive">  
	                <table class="table borderless" id="dynamic_field">  
	                    <tr>
	                    	<td> <?= $form->field($model, 'email[]')->textInput(['autofocus' => true,
	                    	'class' => 'form-control name_list' ]) ?> </td>
	                    	<td>
	                    		<?= $form->field($model, 'role')->dropDownList(ArrayHelper::map(Role::find()->all(),'id', 'name'), ['prompt'=> Yii::t('user', 'Choose Role'), 'options' => ['class' => 'form-control'] ]) ?>
	                    	</td>
	                    	<td> <?= Html::button('Add more', ['class' => 'btn btn-success', 'name' => 'add', 
	                    	'id' => 'add']) ?> </td> 
	                    </tr>
	                  </table> 
	        <div class="form-group">
			<?= Html::submitButton('Send Invitation', ['class'=> 'btn btn-primary', 'id' => 'submit', 'name' => 'submit']); ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>

<?php
$js = <<<JS

$(document).ready(function(){      
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added borderless"><td> <input id="inviteusersform-email" class="form-control name_list" name="InviteUsersForm[email][]" autofocus="" type="text"></td><td><select id="inviteusersform-role" class="form-control" name="InviteUsersForm[role]" aria-required="true"><option value="">Choose Role</option><option value="1">admin</option><option value="2">manager</option><option value="3">administrator</option><option value="4">field_officer</option><option value="5">data_entry</option></select></td><td> <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button> </td> </tr>');  
      });
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
    $('#submit').click(function(){            
        $.ajax({  
		    method:"POST",  
            data:$('#add_email').serialize(),
            type:'json',
            success:function(data)  
            {
         	  	i=1;
               	$('.dynamic-added').remove();
                $('#add_email')[0].reset();
    			alert(data);
            }  
        });  
      });
    });  
JS;
 
$this->registerJs($js);
?>