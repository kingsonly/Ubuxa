<style>
.floatright{
	float: right;
	margin-right: 10px;
}
.foldernote{
	line-height: 24px;
	text-underline-position: alphabetic;
	margin-top: 10px;

}
.projecturl{
	 cursor: pointer;
 }

.box{
	border: none;
	font-family: candara;
}
#createinvoice{
	margin: 10px 10px;
}
</style>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Folder */
?>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="folder-index">
				<h1> 
					<div class="floatright btn btn-success" id="create<?= strtolower($modelClassName);?>" data-formurl="<?= Url::to(['create']) ?>">Create New <?= strtolower($modelClassName);?>
					</div>
				</h1>

				<div class="box-body">
					<h3><?= $modelClassName;?> List</h3>
					
						<?php Pjax::begin(['id' => 'listviewtablereload']) ?>
					<table id="listviewtable" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SN</th>
								<? foreach($attributes as $key => $value){ ?>
									<? if(filter_var($key, FILTER_VALIDATE_INT) !== false){?>
										<th><?= $model->attributeLabels()[$value];?></th>
									<? }else{ ?>
										<th><?= $key ;?></th>
									<? };?>

								<? } ?>
								<th>Action</th>
							</tr>

						</thead>
						<tbody>
							<?php $sn=1; foreach($content as $k=>$v){ ?>
								<tr class="<?= strtolower($modelClassName);?>urltr <?if($sn === 1 && $hoverEffect == 'true'){echo 'activelist';} ?>" data-url="<?=Url::to([strtolower($modelClassName).'/'.strtolower($modelClassName).'view','id' => $v->getPrimaryKey()]) ?>" title="Click to view project">
									<td class="<?= strtolower($modelClassName);?>url">
										<?= $sn;  ?>
									</td>
									<? foreach($attributes as $key => $value){ ?>
									<td class="<?= strtolower($modelClassName);?>url">
										<?= $v->$value;  ?>
									</td>
									<? } ?>

									<td>
										<p>
											<? foreach($action as $key => $value){?>
												<?= Html::tag('i', '', ['class' => $icons[$key].' '.$key, 'data-url'=>$value.'&id='.$v->getPrimaryKey()]); ?>
											<? }?>

										</p>          
									</td>

								</tr>
							<?php $sn++; }?>
						</tbody>
						<tfoot>
							<tr>
								<th>SN</th>
								<? foreach($attributes as $key => $value){ ?>
									<? if(filter_var($key, FILTER_VALIDATE_INT) !== false){?>
										<th><?= $model->attributeLabels()[$value];?></th>
									<? }else{ ?>
										<th><?= $key ;?></th>
									<? };?>

								<? } ?>
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>


<script>
$("#listviewtable").DataTable({
	"aaSorting": [],
	"responsive": "true",
	"pagingType": "simple",
});
</script>

<?php Pjax::end() ?>

<? 
Modal::begin([
	'header' =>'<h1 id="headers"></h1>',
	'id' => strtolower($modelClassName).'viewcreate',
	'size' => 'modal-lg',  
]);
?>
<div id="<?= strtolower($modelClassName).'createform'?>"> </div>

<? 
Modal::end();
?>


