<?
use yii\helpers\Url;
use kartik\file\FileInput;

?>
<style>
.boffins_cascader{
	display: inline-block;
	margin-right: 6px;
	margin-bottom: 10px;
}
</style>
<div class="row">
	<div class="col-sm-12 loadhere">
		<div class="boffins_cascader actives"></div>
	</div>
</div>
 

<?= $form->field($model, 'itemType')->hiddenInput(['maxlength' => true,'id'=>'itemType'])->label(false); ?>
	
<?= $form->field($model, 'itemID')->hiddenInput(['maxlength' => true,'id'=>'itemId'])->label(false); ?>

<? if($model->junctionFK != 'edocument_id'){?>
	<?= $form->field($model, 'upload_file[]')->widget(FileInput::classname(), [
		'options' => ['accept' => 'image/*',
					 'multiple' => true,
					 'uploadUrl' => Url::to(['/edocument/create']),],
		'pluginOptions' => [
					'maxFileSize'=>2800,
					'previewFileType' => 'any',
					'showUpload' => false
		],
	]);
	?>
<? }?>
<?
$loadData = Url::to(['/linkedapi/index']);
 
?>

<?php 
$this->registerJsFile('@web/js/dist/js/bootstrap-cascader.js');	
$this->registerCssFile('@web/js/specific.js');	



$javascriptView = <<<js
	
   
function componentlink(){
	$.ajax({
		url: '$loadData',
		success: function(response){
			$('.boffins_cascader').bsCascader({
				openOnHover: true,
				loadData: function (openedItems, callback) {
					callback(response);
				}
			});

		},

	});
}

componentlink();
	   
	 

js;
 
$this->registerJs($javascriptView);
?>
