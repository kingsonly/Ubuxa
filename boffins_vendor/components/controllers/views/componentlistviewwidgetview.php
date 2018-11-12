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
					
				</h1>

				<div class="box-body">
					<h3></h3>
					
						<?php Pjax::begin(['id' => 'listviewtablereload']) ?>
					<table id="listviewtable" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SN</th>
								
							</tr>

						</thead>
						<tbody>
							<?php $sn=1; foreach($content as $k=>$v){ ?>
								<tr class="<?=  <?if($sn === 1 && $hoverEffect == 'true'){echo 'activelist';} ?>" data-url="" title="">
									<td class="">
										<?= $sn;  ?>
									</td>
									
									<td class="">
										<?= $v->$value;  ?>
									</td>
									<? } ?>

								</tr>
							<?php $sn++; }?>
						</tbody>
						<tfoot>
							<tr>
								<th>SN</th>
								
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



