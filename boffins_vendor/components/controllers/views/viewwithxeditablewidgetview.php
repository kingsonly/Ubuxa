<?
use kartik\editable\Editable;
?>
<style>
	.xinput:hover{
		background:#ccc;
	}
	.xinput{
		background: none;
		border:none;
	}
</style>
<?




?>

<?


foreach($attributues as $v){
	if(!isset($v['xeditable'])){
		?>
<div>
<h3><?= $model->attributeLabels()[$v['modelAttribute']];?></h3>
<?
		$editable = Editable::begin([
			'model'=>$model,
			'attribute'=>$v['modelAttribute'],
			'asPopover' => false,
			'size'=>'md',
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
			echo Editable::widget([
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
			?>
	</div>
	<?
		}
	}
	

	
}
?>