<?
use kartik\editable\Editable;
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
			'options'=>['placeholder'=>'Enter location...'],
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
		}elseif($v['xeditable'] == 'image'){
			?>
<div>
<?
			 Editable::begin([
				'model'=>$model,
				'attribute'=>$v['modelAttribute'],
				'asPopover' => true,
				'size'=>'md',
				'inputType' => Editable::INPUT_FILEINPUT,
				'options'=>[
					'options'=>['placeholder'=>'image', 'accept' => 'image/*']
				],
				'editableValueOptions'=>['class'=>'well well-sm']
			]);
			Editable::end();
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

$(".xinput").mouseout(function() {
    
    $(this).addClass("ellipsis");
    
});

XeditableBoffins;
 
$this->registerJs($xeditableBoffins);
?>