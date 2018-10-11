<?
use kartik\editable\Editable;
?>
<style>
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
	}
	.kv-editable-parent.form-group{
		width:60% !important;
	}
	.panel.panel-default{
		margin-bottom: 0px;
	}
	#folder-description{
		width: 100%;
	}
	h5{
		
		margin-bottom: 7px;
		margin-top: 7px;
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
			'editableValueOptions'=>['class'=>'xinput']
			
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
		}
	}
	

	
}
?>