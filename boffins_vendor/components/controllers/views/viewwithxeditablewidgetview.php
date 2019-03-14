<?
use kartik\editable\Editable;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\popover\PopoverX;

?>
<style>
	#view-content h4{
		font-size: 1em;
		line-height: 24px;
		letter-spacing: -0.003em;
		text-transform: capitalize;
		margin: 0px !important;

	}
	.kv-editable-input{
		width: 100% !important;
	}
	.xinput:hover{
		background:#ccc;
		padding: 0px !important;
	}
	
	.xinput-component:hover{
		background:rgb(235, 236, 240);
		padding: 2px !important;
		font-style: italic;
		border-radius: 5px;
		text-align: center !important;
		border-radius: 5px;
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
	
	.xinput-component{
		background: none;
		border:none;
		text-align: left !important;
		width: 100%;
		color:rgb(9, 30, 66);
		min-height: 35px;
		font-size: 16px;
		
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
	
	if($editableArea == 'component' || $editableArea == 'changeurl'){
			if(!isset($v['xeditable'])){
		?>
<div>
<h5><?= $attributeName;?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $attributeName.' )</em>',
			'size'=>'sm',
			'formOptions' => ['action'=>$modelUrl],
			'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
			'inputType' => Editable::INPUT_TEXTAREA,
			//'options'=>['placeholder'=>'Enter title...'],
		'containerOptions' => ['id' =>$editableId],
		'options'=>[
					'placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
			'editableValueOptions'=>['class'=>'xinput ellipsis']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
 
Editable::end();
	
		?>
	</div>
	<?
	}else{?>
<? if($v['xeditable'] == 'integer'){?>

<div>
<h5><?= $attributeName;?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $attributeName.' )</em>',
			'size'=>'md',
		'formOptions' => ['action'=>$modelUrl,],
			'inputType' => 'input',
			//'options'=>['placeholder'=>'Enter title...'],
		'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
		'containerOptions' => ['id' =>$editableId],
		'options'=>[
					'type'=>'number','placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
			'editableValueOptions'=>['class'=>'xinput-component']
		
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
Editable::end();
	
		?>
	</div>

<? }elseif($v['xeditable'] == 'short_string'){?>

<div>
<h4><?= $attributeName;?></h4>
<?
				
				
				
	$editable = Editable::begin([
    		'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $attributeName.' )</em>',
			'size'=>'md',
			//'inputType' => Editable::INPUT_MONEY,
			//'options'=>['placeholder'=>'Enter title...'],
			'formOptions' => ['action'=>$modelUrl],
		    'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
		'containerOptions' => ['id' =>$editableId],
		'options'=>[
					'placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
			'editableValueOptions'=>['class'=>'xinput-component']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
Editable::end();
	
		?>
	</div>
<?}elseif($v['xeditable'] == 'long_string'){?>


<div>
<h5><?= $attributeName;?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $attributeName.' )</em>',
			'size'=>'md',
		'formOptions' => ['action'=>$modelUrl],
			'inputType' => Editable::INPUT_TEXTAREA,
			//'options'=>['placeholder'=>'Enter title...'],
		'containerOptions' => ['id' =>$editableId],
		'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
		'options'=>[
					'placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
			'editableValueOptions'=>['class'=>'xinput-component']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
Editable::end();
	
		?>
	</div>


<? }elseif($v['xeditable'] == 'money'){ ?>


<div>
<h5><?= $attributeName;?></h5>
<?
				
				
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $attributeName.' )</em>',
			'size'=>'md',
		'formOptions' => ['action'=>$modelUrl],
			'inputType' => Editable::INPUT_MONEY,
		'containerOptions' => ['id' =>$editableId],
		'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
			//'options'=>['placeholder'=>'Enter title...'],
		'options'=>[
					'options'=>['placeholder'=>'Enter Value','id'=>'editableId'.$editableId]
				],
			'editableValueOptions'=>['class'=>'xinput-component']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
Editable::end();
	
		?>
	</div>

<? }elseif($v['xeditable'] == 'known_class'){ ?>


<div>
<h5><?= $attributeName;?></h5>
<?
	if($v['typeName'] == 'User'){
		$knownClassModel =  "frontend\\models\\".$v['typeName'].'Db';
		$knownClassInit = new $knownClassModel;
		$data = $knownClassInit->dropDownListData;
	}else{
		$knownClassModel =  "frontend\\models\\".$v['typeName'];
		$knownClassInit = new $knownClassModel;
		$data = $knownClassInit->dropDownListData;
	}	
				
	$editable = Editable::begin([
    'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $attributeName.' )</em>',
			'size'=>'md',
			'inputType' => Editable::INPUT_DROPDOWN_LIST,
			'data'=>$data,
			//'options'=>['placeholder'=>'Enter title...'],
		'formOptions' => ['id' => 'wishitemaction','action'=>$modelUrl],
		'displayValueConfig' => $data,
		   // $testArray['displayValueConfig'],
		'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
		'containerOptions' => ['id' =>$editableId],
		'options'=>[
					'placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
			'editableValueOptions'=>['class'=>'xinput-component']
]);
$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
Editable::end();
	
		?>
	</div>

<? }elseif($v['xeditable'] == 'variant_object'){ ?>

<div>
	<h5><?= $attributeName;?></h5>
<?
			$editable = Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'valueIfNull' => '<em style="color:blue;">( Enter '. $attributeName.' )</em>',
				'formOptions' => ['action'=>$modelUrl],
				'containerOptions' => ['id' =>$editableId],
				'options'=>[
					'placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
				'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
				'editableValueOptions'=>['class'=>'xinput-component']
			]);
				$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
			Editable::end();
			?>
	</div>
<? }elseif($v['xeditable'] == 'timestamp'){ ?>

<div>
	<h5><?= $attributeName;?></h5>
<?
			$editable = Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'formOptions' => ['action'=>$modelUrl],
				'valueIfNull' => '<em style="color:blue;">( Enter '. $attributeName.' )</em>',
				'containerOptions' => ['id' =>$editableId],
				'inputType' => Editable::INPUT_DATE,
				'options'=>[
					'placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
				'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
				'editableValueOptions'=>['class'=>'xinput-component']
			]);
				$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
			Editable::end();
			?>
	</div>
<? }elseif($v['xeditable'] == 'variant_string'){ ?>

<div>
	<h5><?= $attributeName;?></h5>
<?
			$editable = Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'formOptions' => ['action'=>$modelUrl],
				'valueIfNull' => '<em style="color:blue;">( Enter '. $attributeName.' )</em>',
				'containerOptions' => ['id' =>$editableId],
				'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
				'options'=>[
					'placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
				'editableValueOptions'=>['class'=>'xinput-component']
			]);
				$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
			Editable::end();
			?>
	</div>
<? }else{  ?>

<div>
	<h5><?= $attributeName;?></h5>
<?
			$editable = Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'valueIfNull' => '<em style="color:blue;">( Enter '. $attributeName.' )</em>',
				'containerOptions' => ['id' =>$editableId],
				'formOptions' => ['action'=>$modelUrl],
				'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
			 			$(document).find('#listView').load($('.active-component').data('url')).find('.one-time-component-click'+data.component).delay( 800 ).addClass('active-component-tr');
						options = {
					  'closeButton': true,
					  'debug': false,
					  'newestOnTop': true,
					  'progressBar': true,
					  'positionClass': 'toast-top-right',
					  'preventDuplicates': true,
					  'showDuration': '300',
					  'hideDuration': '1000',
					  'timeOut': '5000',
					  'extendedTimeOut': '1000',
					  'showEasing': 'swing',
					  'hideEasing': 'linear',
					  'showMethod': 'fadeIn',
					  'hideMethod': 'fadeOut',
					  'tapToDismiss': false
		  			}
				toastr.success('Change made is successfull', '', options);
			 		}",
    	],
				'options'=>[
					'placeholder'=>'Enter Value','id'=>'editableId'.$editableId
				],
				'editableValueOptions'=>['class'=>'xinput-component']
			]);
				$form = $editable->getForm();
// use a hidden input to understand if form is submitted via POST
 if($editableArea == 'component'){
	echo  $form->field($model, 'attributeId')->hiddenInput()->label(false);
}
			Editable::end();
			?>
	</div>

<? } ?>

<? } ?>
		
	<?}else{
	if(!isset($v['xeditable'])){
		?>
<div>
<h5><?= ucfirst($editableArea) .' '. $model->attributeLabels()[$v['modelAttribute']];?></h5>
<?
		$editable = Editable::begin([
			'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
			'size'=>'sm',
			'options'=>['placeholder'=>'Enter title...'],
			'editableValueOptions'=>['class'=>'xinput-component xinput'],
			'pluginEvents' => [
				"editableSuccess"=>"
					function(event, val, form, data) {
						var pjax = '$pjaxId';
						if(pjax !== ''){
							$.pjax.reload({container:'$pjaxId',async: false});
						}
			 		}",
    	],
			
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
					'options'=>['placeholder'=>'Enter date']
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
				'options'=>[
        			'options'=>['placeholder'=>'From date','id' => 'x-editable-date'.$xEditableDateId,]
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
	    'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
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
	}elseif($v['xeditable'] == 'dropdown'){
			?>
<div>
	<?
		echo Editable::widget([
	    'model'=>$model,
	    'asPopover' => false,
	    'inputType' => Editable::INPUT_DROPDOWN_LIST,
	    'attribute'=>$v['modelAttribute'],
	    'valueIfNull' =>'<em style="color:blue;">( Enter '. $v['modelAttribute'].' )</em>',
	    'data'=>$data,
	    'header' => 'Notes',
	    'submitOnEnter' => false,
	    'options' => [
	        'class'=>'form-control',  
	        'placeholder'=>'Select status...'
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

$(".xinput-component").mouseover(function() {
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
		$.pjax.reload({container:"#folder-details-refresh",async: false});
}

$(".xinput").mouseout(function() {
    $(this).addClass("ellipsis");
});
     
XeditableBoffins;
 
$this->registerJs($xeditableBoffins);
?>