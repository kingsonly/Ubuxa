<?
use kartik\editable\Editable;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\popover\PopoverX;
?>
<style>

	.kv-editable-input{
		width: 100% !important;
	}
	.xinput:hover{
		background:#ccc;
		padding: 0px !important;
	}
	.xinput{
		
		padding: 0px !important;
	}
	
	#folder-title-targ,#folder-description-targ{
		font-size: 17px !important;
		font-weight: bold !important;
	}
	#folder-title-targ:hover,#folder-description-targ:hover{
		cursor: text;
	}
	.xinput{
		background: none;
		border:none;
		text-align: left !important;
		width: 100%;
		overflow: hidden;
		display: inline-block;
		white-space: nowrap;
	}
	.ellipsis{
text-overflow: ellipsis;
}
	.kv-editable-parent.form-group{
		width:60% !important;
		margin-top: 3px;
	}
	.panel.panel-default{
		margin-bottom: 0px;
	}
	#folder-description{
		width: 100%;
	}
	h5{
		
		margin-bottom: 5px;
		margin-top: 5px;
		font-size: 13px !important;
	}
	
	.kv-editable{
		
	}
	.folder_image:hover{
		cursor: pointer;
		border:1px solid #ccc;
		transform: scale(1.5);
	}
	
</style>
<?




?>

<?

foreach($attributues as $v){
	if(!isset($v['xeditable'])){
		?>
<div>
<h5><?= $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
		$editable = Editable::begin([
			'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'size'=>'sm',
			'options'=>['placeholder'=>'Enter title...'],
			'editableValueOptions'=>['class'=>'xinput ellipsis']
			
		]);
		Editable::end();
		?>
	</div>
	<?
	}else{
		if($v['xeditable'] == 'date'){
			?>
<div>
<?
			echo Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'inputType' => Editable::INPUT_DATE,
				'options'=>[
					'options'=>['placeholder'=>'From date']
				],
				'editableValueOptions'=>['class'=>'well well-sm']
			]);
			Editable::end();
			?>
	</div>
	<?
	}elseif($v['xeditable'] == 'notes'){
			?>
<div>
	<?
		echo Editable::widget([
	    'model'=>$model,
	    'asPopover' => false,
	    'inputType' => Editable::INPUT_TEXTAREA,
	    'attribute'=>$v['modelAttribute'],
	    'header' => 'Notes',
	    'submitOnEnter' => false,
	    'options' => [
	        'class'=>'form-control', 
	        'rows'=>5, 
	        //'style'=>'width:400px', 
	        'placeholder'=>'Enter details...'
    ]
]);

	?>
</div>

	<?
		}elseif($v['xeditable'] == 'image'){
			?>
<div>
	<?
		PopoverX::begin([	
								'placement' => PopoverX::ALIGN_LEFT,
								 
								'toggleButton' => ['src'=>Url::to('@web/'.$displayImage),'tag'=>'img', 'class'=>'folder_image'],
								'header' => '<i class="glyphicon glyphicon-lock"></i> Enter credentials',
								'footer' => Html::button('Submit', [
										'class' => 'btn btn-sm btn-primary', 
										'onclick' => '$("#form-signup").trigger("submit")'
									]) . Html::button('Reset', [
										'class' => 'btn btn-sm btn-default', 
										'onclick' => '$("#form-signup").trigger("reset")'
									])
								]);

							   ?>
					
			
		

       
	
	
	
	<?= FileInput::widget([
    'model' => $model,
    'attribute' => 'upload_file',
    'options' => ['accept' => 'image/*'],
	'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => $imageUrl],
	    'pluginEvents' => [
        "fileuploaded" => 'function() { xeditableSuccessCallback() }',
    ]
	
	]);?>
	

								
						 <?
							   PopoverX::end();
						?>
	

	</div>
	<?
		}
	}
	

	
}


?>

<?
$xeditableBoffins = <<<XeditableBoffins
  
$(".xinput").mouseover(function() {
    $(this).removeClass("ellipsis");
	$(this).attr("title", $(this).text());
    $(this).attr("data-toggle", "tooltip");
    $(this).attr("data-placement", "bottom");
    
});

function xeditableSuccessCallback(){
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
	
        // hide popover


    	var thiss = $('[data-toggle="popover-x"]');
	href = thiss.attr('href'),
	dialog = $(thiss.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))), //strip for ie7
	option = dialog.data('popover-x') ? 'toggle' : $.extend({remote: !/#/.test(href) && href});
	dialog.popoverX('hide');
         
		
		toastr.success('Image was Changed', "", options);
		$.pjax.reload({container:"#folder-details-refresh",async: false});
}

$(".xinput").mouseout(function() {
    
    $(this).addClass("ellipsis");
    
});

XeditableBoffins;
 
$this->registerJs($xeditableBoffins);
?>