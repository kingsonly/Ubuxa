<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use frontend\models\Folder;
/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
	#loading-folder-div-<?= $formId;?>{
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
	
	#create-new-<?=$formId;?>-title{
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
		padding-top: 13px;
		
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
	#folderform-<?=$formId;?>{
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
    $form = ActiveForm::begin(['action'=>!empty($formAction)?$formAction:Url::to(['folder/create']),'id'=> 'folderform-'.$formId,'fieldConfig' => ['template' => '{label}{input}']]); ?>

    

<div id="form-content">
	
	
	<? if($creationType == 'folder'){?>
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
		<?= $form->field($folderModel, 'privateFolder')->widget(Select2::classname(),
																[
																	'data' => $privacy,
																	'options' => ['id'=>$pjaxId.'sss'],
																	'hideSearch' => true,
																	'pluginOptions' => [
																		'templateResult' => new JsExpression('format'),
																		'templateSelection' => new JsExpression('format'),
																		'escapeMarkup' => $escape,
																		],
																])->label(false);?>
	</span>
	<? }else{?>
	<? $folderComponentJunctionTableModel = new \frontend\models\FolderComponent;?>
		<?= $form->field($folderComponentJunctionTableModel, 'folder_id')->hiddenInput(['value' => $folderId])->label(false); ?>
		<?= $form->field($folderModel, 'component_template_id')->hiddenInput(['value' => ''])->label(false); ?>
	<? }?>
	<span id="title-span">
		<?= $form->field($folderModel, 'title')->textInput(['id' => 'create-new-'.$formId.'-title','placeholder'=>'Create '.$creationType])->label(false); ?>
	<?= $form->field($folderModel, 'parent_id')->hiddenInput(['value' => $folderId])->label(false); ?>
	<?= $form->field($folderModel, 'cid')->hiddenInput(['value' => Yii::$app->user->identity->cid])->label(false); ?>
	</span>
	
	

    <span class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success', 'id' =>$formId,'data-button' => $formId ]) ?>
		<div id="loading-folder-div-<?= $formId;?>"> <?= Yii::$app->settingscomponent->boffinsLoaderImage(); ?></div>
    </span>

</div>


    <?php ActiveForm::end(); 
		
	?>

</div>

<?php 
$url = Url::to(['folder/check-if-folder-name-exist']);
$js = <<<JSS

 $(document).on('click','#ok',function(){
 localStorage.setItem("skipValidation", "yes");
 	formId = $(this).data('formid');
	$('#'+formId).trigger('beforeSubmit');
	
})
x = 'are you sure ';
\$buttonId = $(this).data('data-button');

$('#folderform-$formId').on('beforeSubmit', function(e) { 
	$(document).find('#$formId').hide();
	$(document).find('#loading-folder-div-$formId').show();
	e.preventDefault();
	if(localStorage.getItem("skipValidation") === 'yes'){
	
	}else{
		localStorage.setItem("skipValidation", "no");
	}
	var \$form = $(this);
	var  \$getIdOfForm = \$form.attr('id');
	getInputIds = $('#create-new-$formId-title').val();
	$.get('$url'+'&folderName='+getInputIds, function(data) {
	if(data == 1 && localStorage.getItem("skipValidation") === 'no'){
		
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
		  
		toastr.error('name exist and could cause a conflict, you could change or use same name if you chose.<div><button type="button" id="ok" data-formid="folderform-$formId"  class="btn btn-primary">Use Same Name</button></div>', "Title", options);
		$(document).find('#$formId').show();
		$(document).find('#loading-folder-div-$formId').hide();
		}else{
		$.ajax({
                url: \$form.attr('action'),
                type: 'POST',
                data: \$form.serialize(),
                success: function(response) {
				jsonResult = response;
		   if(jsonResult.message == 'sent'){
                    
			   if(jsonResult.area == 'folder'){
			   
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

				if(localStorage.getItem("skipValidation") === 'yes'){
					localStorage.setItem("skipValidation", "no");	
				}
				if('$newFolderCreated' === '0' ){
					location.reload();
				   }

				$(document).find('#$formId').show();
				$(document).find('#loading-folder-div-$formId').hide();
			   $.pjax.reload({container:"#"+"$pjaxId",async: false});
			   $(document).find('#folder-item-'.jsonResult.output).addClass('blink');
			   }else{
			   
			   		templateId = jsonResult.templateId;
			   		componentId = jsonResult.output;
					
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
					
					toastr.success('Element was created successfully', "", options);
					//alert('component');
					if(localStorage.getItem("skipValidation") === 'yes'){
						localStorage.setItem("skipValidation", "no");
					}
					
					$(document).find('#$formId').show();
				   $(document).find('#loading-folder-div-$formId').hide();
				   $.pjax.reload({container:"#"+"component-pjax",async: false});
				   $('.one-time-template-click-'+templateId).trigger('click');
				   $('.one-time-component-click'+componentId).trigger('click');
				   if('$newFolderCreated' === '0' ){
					location.reload();
				   }
				   
			   }
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
		  if(localStorage.getItem("skipValidation") === 'yes'){
			localStorage.setItem("skipValidation", "no");
			}
		$(document).find('#$formId').show();
		$(document).find('#loading-folder-div-$formId').hide();
		toastr.error('Somthing went wrong', "", options);
		$.pjax.reload({container:"#"+"$pjaxId",async: false});
			 	
				
			   }
            },
              
            });
			
			
		}  
		});
	return false;
});


JSS;
 
$this->registerJs($js);
?>

