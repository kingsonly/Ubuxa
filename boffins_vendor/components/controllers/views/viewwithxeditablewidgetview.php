<?
use kartik\editable\Editable;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\popover\PopoverX;
use frontend\models\Corporation;
$customers = Corporation::find()
    ->joinWith('client')
    
    ->all();
$data=ArrayHelper::map($customers,'id','name');
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
	em.value-if-null{
		color: red;
	}
	
</style>
<?




?>

<?
foreach($attributues as $v){
	
	if($editableArea == 'component'){
			if(!isset($v['xeditable'])){
		?>
<div>
<h5><?= $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
			'size'=>'sm',
			'inputType' => Editable::INPUT_MONEY,
			//'options'=>['placeholder'=>'Enter title...'],
		'containerOptions' => ['id' =>$editableId],
		'options'=>[
					'options'=>['placeholder'=>'From date']
				],
			'editableValueOptions'=>['class'=>'xinput ellipsis']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
Editable::end();
	
		?>
	</div>
	<?
	}else{?>
<? if($v['xeditable'] == 'integer'){?>

<div>
<h5><?= $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
			'size'=>'sm',
			'inputType' => Editable::INPUT_MONEY,
			//'options'=>['placeholder'=>'Enter title...'],
		'containerOptions' => ['id' =>$editableId],
		'options'=>[
					'options'=>['placeholder'=>'From date']
				],
			'editableValueOptions'=>['class'=>'xinput ellipsis']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
Editable::end();
	
		?>
	</div>

<? }elseif($v['xeditable'] == 'short_string'){?>

<div>
<h5><?= $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
			'size'=>'sm',
			//'inputType' => Editable::INPUT_MONEY,
			//'options'=>['placeholder'=>'Enter title...'],
		    'pluginEvents' => [
  
        "editableSuccess"=>"function(event, val, form, data) { console.log('Successful submission of value ' + val); alert(data.test); $(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.test).addClass('active-component-tr') }",
        
    	],
		'containerOptions' => ['id' =>$editableId],
		'options'=>[
					'options'=>['placeholder'=>'From date','id'=>'fakeme']
				],
			'editableValueOptions'=>['class'=>'xinput ellipsis']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
Editable::end();
	
		?>
	</div>
<?}elseif($v['xeditable'] == 'long_string'){?>


<div>
<h5><?= $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
			'size'=>'md',
			'inputType' => Editable::INPUT_TEXTAREA,
			//'options'=>['placeholder'=>'Enter title...'],
		'containerOptions' => ['id' =>$editableId],
		'options'=>[
					'options'=>['placeholder'=>'From date']
				],
			'editableValueOptions'=>['class'=>'xinput ellipsis']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
Editable::end();
	
		?>
	</div>


<? }elseif($v['xeditable'] == 'money'){ ?>


<div>
<h5><?= $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
			'size'=>'md',
			'inputType' => Editable::INPUT_MONEY,
		'containerOptions' => ['id' =>$editableId],
			//'options'=>['placeholder'=>'Enter title...'],
		'options'=>[
					'options'=>['placeholder'=>'From date']
				],
			'editableValueOptions'=>['class'=>'xinput ellipsis']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
Editable::end();
	
		?>
	</div>

<? }elseif($v['xeditable'] == 'known_class'){ ?>


<div>
<h5><?= $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
			'size'=>'md',
			'inputType' => Editable::INPUT_DROPDOWN_LIST,
			'data'=>$data,
			//'options'=>['placeholder'=>'Enter title...'],
		'containerOptions' => ['id' =>$editableId],
		'formOptions' => ['id' => 'wishitemaction' ],
		'options'=>[
					'options'=>['placeholder'=>'From date']
				],
			'editableValueOptions'=>['class'=>'xinput ellipsis']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
Editable::end();
	
		?>
	</div>

<? }elseif($v['xeditable'] == 'variant_object'){ ?>

<div>
<?
			$editable = Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'valueIfNull' => $v['modelAttribute'],
				'containerOptions' => ['id' =>$editableId],
				'options'=>[
					'options'=>['placeholder'=>'From date']
				],
				'editableValueOptions'=>['class'=>'well well-sm']
			]);
				$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
			Editable::end();
			?>
	</div>
<? }elseif($v['xeditable'] == 'timestamp'){ ?>

<div>
<?
			$editable = Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'valueIfNull' => $v['modelAttribute'],
				'containerOptions' => ['id' =>$editableId],
				'inputType' => Editable::INPUT_DATE,
				'options'=>[
					'options'=>['placeholder'=>'From date']
				],
				'editableValueOptions'=>['class'=>'well well-sm']
			]);
				$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
			Editable::end();
			?>
	</div>
<? }elseif($v['xeditable'] == 'variant_string'){ ?>

<div>
<?
			$editable = Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'valueIfNull' => $v['modelAttribute'],
				'containerOptions' => ['id' =>$editableId],
				'options'=>[
					'options'=>['placeholder'=>'From date']
				],
				'editableValueOptions'=>['class'=>'well well-sm']
			]);
				$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
			Editable::end();
			?>
	</div>
<? }else{  ?>

<div>
<?
			$editable = Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'valueIfNull' => $v['modelAttribute'],
				'containerOptions' => ['id' =>$editableId],
				'options'=>[
					'options'=>['placeholder'=>'From date']
				],
				'editableValueOptions'=>['class'=>'well well-sm']
			]);
				$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
			Editable::end();
			?>
	</div>

<? } ?>

<? } ?>
		
	<?}else{
	if(!isset($v['xeditable'])){
		?>
<div>
<h5><?= $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
		$editable = Editable::begin([
			'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
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
				'valueIfNull' => $v['modelAttribute'],
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
	}elseif($v['xeditable'] == 'datetime'){
			?>
		<div>
<?
			echo Editable::widget([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'inputType' => Editable::INPUT_DATETIME,
				'asPopover' => false,
				'header' => 'Due Date',
				'size'=>'md',
				'options'=>['id' => 'x-editable-date'.$xEditableDateId,
					'options'=>['placeholder'=>'Enter date']
				],
				'editableValueOptions'=>['class'=>'well well-sm multi-reminder']
			]);
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
	        'style'=>'width:400px', 
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
								'size' => 'md',
								 
								'toggleButton' => ['src'=>Url::to('@web/'.$displayImage),'tag'=>'img', 'class'=>'folder_image','id' => 'folder_image'],
								'header' => 'Change Folder Image',
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
  
        $('#w2').popoverX('hide');
		$("#folder_image").load(' #folder_image');

		toastr.success('Image was Changed', "", options);
		//$.pjax.reload({container:"#folder-details-refresh",async: false});
}

$(".xinput").mouseout(function() {
    $(this).addClass("ellipsis");
});
     
XeditableBoffins;
 
$this->registerJs($xeditableBoffins);
?>