<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */
/* @var $form yii\widgets\ActiveForm */

?>
<style>
	#loadingdiv{
		display: none;
	}
</style>
<div class="folder-form">
	<?php 
	$folderId = '';
if(isset($_GET['id'])){
	$folderId = $_GET['id'];
	}else{
		$folderId = 0;
	}
    $form = ActiveForm::begin(['action'=>Url::to(['folder/create']),'id'=> 'folderform']); ?>
<div id="loadingdiv"> loading .....</div>
    
<?= $form->field($folderModel, 'privateFolder')->checkbox(['label'=>'test','value' => "1"]); ?>
<?= $form->field($folderModel, 'title')->textInput(['maxlength' => true, 'id' => 'folder-title']) ?>
<?= $form->field($folderModel, 'parent_id')->hiddenInput(['value' => $folderId])->label(false); ?>
<?= $form->field($folderModel, 'cid')->hiddenInput(['value' => Yii::$app->user->identity->cid])->label(false); ?>
    <div class="form-group">
        <?= Html::button('Save', ['class' => 'btn btn-success', 'id' => 'submit-folder']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$url = Url::to(['folder/check-if-folder-name-exist']);
$js = <<<JSS

 function useSameName(){
	$('#loadingdiv').show();
			var \$form = $('#folderform');
			$.post(\$form.attr('action'),\$form.serialize())
			.always(function(result){
			jsonResult = JSON.parse(result);
			$(document).find('#loadingdiv').html(jsonResult.message);

		   if(jsonResult.message == 'sent'){

			   //$(document).find('#loader1').html(result.message).show();
			   // bring green toast
			   alert(jsonResult.message)

			}else{
			//$(document).find('#loader1').html(result).show();
			// bring red toast 
			alert(jsonResult.message)
			}
			}).fail(function(){
			console.log('Server Error');
			});


			return false;
};
areyousure = 'are you sure ';
$('#submit-folder').on('click', function (e) {
	
	getInputId = $('#folder-title').val();
	$.get('$url'+'&folderName='+getInputId, function(data) {
		if(data == 1){
		options = {
		  "closeButton": true,
		  "debug": false,
		  "newestOnTop": true,
		  "progressBar": true,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": true,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "5000",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		  "hideMethod": "fadeOut",
		  "tapToDismiss": false
		  }
		toastr.error('name exist and could cause a conflict, you could change or use same name if you chose.<div><button type="button" id="okBtn" onclick="useSameName()" class="btn btn-primary">Use Same Name</button></div>', "Title", options);
		}else{
		useSameName();
		}
		
		
	});

    
    
    
});

JSS;
 
$this->registerJs($js);
?>
