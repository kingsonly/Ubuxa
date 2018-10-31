<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */
/* @var $form yii\widgets\ActiveForm */

?>
<style>
	#loadingdiv{
		display: none;
	}
	#form-contnent{
		display: flex;
		
	}
	
	#form-contnent span{
		flex:1;
		
	}
	select {
  font-family: 'FontAwesome', 'sans-serif';
}
	#title-span{
		margin-left: -5px;
		 flex:1;
	}
	
	#create-new-folder-title{
		height: 33px;
		border:0px;
		width: 100%;
		 
	}
	.select2-selection{
		background: #fff !important;
		border: 0px !important;
		border-radius:0px !important;
		-webkit-box-shadow: inset 0 1px 1px rgba(255,255,255);
		box-shadow: inset 0 1px 1px rgba(255,255,255);
	}
	
	.select2-container--krajee .select2-selection{
		background: #fff !important;
		border: 0px !important;
		border-radius:0px !important;
		-webkit-box-shadow: inset 0 1px 1px rgba(255,255,255)!important;
		box-shadow: inset 0 1px 1px rgba(255,255,255) !important;
	}
	
	#select2-folder-privatefolder-container{
		padding-top: 6px !important;
	}
	
	.fa-unlock-alt{
		font-size: 20px;
	}
	#form-content{
		display: flex;
		flex-direction: row;
		padding-right: 4px;
		height: 40px;
	}
	#folderform{
		background: #fff;
		border: solid 2px green;
		display: block;
		border-radius: 4px;
		padding-top: 6px;
	}
</style>
<?
$url = \Yii::$app->urlManager->baseUrl . '/images/flags/';
$format = <<< SCRIPT
function format(state) {
    if (!state.id) return state.text; // optgroup
    src = state.id;
    return '<i class="' + src + '"></i>';
}
SCRIPT;
$escape = new JsExpression("function(m) { return m; }");
$this->registerJs($format,  yii\web\View::POS_HEAD);
?>

<div class="folder-form">
	<?php 
	$folderId = '';
if(isset($_GET['id'])){
	$folderId = $_GET['id'];
	}else{
		$folderId = 0;
	}
    $form = ActiveForm::begin(['action'=>Url::to(['folder/create']),'id'=> 'folderform','fieldConfig' => ['template' => '{label}{input}']]); ?>
<div id="loadingdiv"> loading .....</div>
    

<div id="form-content">
	<span>
	<?
		
		if(isset($_GET['id']) and $folderPrivacy == 0){
			$privacy = ['fa fa-unlock-alt'=>'Public','fa fa-lock'=>'Private'];
		}elseif(!isset($_GET['id']) and empty($folderPrivacy)){
			$privacy = ['fa fa-unlock-alt'=>'Public','fa fa-lock'=>'Private'];
		}else{
			$privacy = ['fa fa-lock'=>'Private'];
		}
		
	?>
		  <?= $form->field($folderModel, 'privateFolder')->widget(Select2::classname(), [
    'data' => $privacy,
    'options' => [],
	'hideSearch' => true,
    'pluginOptions' => [
        'templateResult' => new JsExpression('format'),
        'templateSelection' => new JsExpression('format'),
        'escapeMarkup' => $escape,
        
    ],
])->label(false);?>
	</span>
	<span id="title-span">
		<?= $form->field($folderModel, 'title')->textInput(['id' => 'create-new-folder-title','placeholder'=>'Folder title'])->label(false); ?>
	<?= $form->field($folderModel, 'parent_id')->hiddenInput(['value' => $folderId])->label(false); ?>
	<?= $form->field($folderModel, 'cid')->hiddenInput(['value' => Yii::$app->user->identity->cid])->label(false); ?>
	</span>
	
	

    <span class="form-group">
        <?= Html::button('Create', ['class' => 'btn btn-success', 'id' => 'submit-folder']) ?>
    </span>

</div>


    <?php ActiveForm::end(); ?>

</div>

<?php 
$url = Url::to(['folder/check-if-folder-name-exist']);
$js = <<<JSS

 function useSameName(){
			var \$form = $('#folderform');
			$.post(\$form.attr('action'),\$form.serialize())
			.always(function(result){
			jsonResult = result;
		   if(jsonResult.message == 'sent'){
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
				toastr.success('Folder was created successfully', "", options);
			   $.pjax.reload({container:"#create-folder-refresh",async: false});

			}else{
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
		toastr.error('Somthing went wrong', "", options);
			 $.pjax.reload({container:"#create-folder-refresh",async: false});
			}
			}).fail(function(){
			console.log('Server Error');
			});


			return false;
};
areyousure = 'are you sure ';
$('#submit-folder').on('click', function (e) {
	
	getInputIds = $('#create-new-folder-title').val();
	$.get('$url'+'&folderName='+getInputIds, function(data) {
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
