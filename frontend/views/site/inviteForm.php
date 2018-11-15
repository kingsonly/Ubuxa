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
	                    <tr class="dynamics">
	                    	<td> <?= $form->field($model, 'email[]')->textInput(['autofocus' => true,
	                    	'class' => 'form-control name_list' ]) ?> </td>
	                    	<td>
	                    		<?= $form->field($model, 'role')->dropDownList(ArrayHelper::map(Role::find()->all(),'id', 'name'), ['prompt'=> Yii::t('user', 'Choose Role'), 'options' => ['class' => 'form-control'] ]) ?>
	                    				<i class="fa fa-remove"></i>
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
$addUsers = $form->field($model, 'email[]')->textInput(['autofocus' => true, 'class' => 'form-control name_list' ]);
$addRoles = Html::button('Add more', ['class' => 'btn btn-success', 'name' => 'add', 'id' => 'add']); 



$js = <<<JS

$(document).ready(function(){      
      var i=1;

      $('#add').click(function(){  
      	  var index = $(this).closest('.dynamics').index();
      	  
          $('.dynamics').clone().appendTo('#dynamic_field');
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