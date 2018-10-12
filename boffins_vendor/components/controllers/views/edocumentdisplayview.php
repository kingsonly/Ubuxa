<?php
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\components\controllers\DisplayLinkedComponents;
/* @var $this yii\web\View */
/* @var $model app\models\Payment */
?>
<style>
.edocumentfolder{
	background: url('images/edocument.png');
	width: 100px;
	height: 100px;
	background-size: contain;
	text-align: center;
	padding-top: 40px;
	display: inline-block;
	color: #fff;
}
</style>
<? foreach($files as $key => $value){
	$content = implode(',',$files[$key]);
	$url = Url::to(['edocument/thumbnail','type'=>$key,'content'=>$content]);
	?>
	<div class='edocumentfolder' data-url="<?= $url;?>" data-edocument="<?= implode(',',$files[$key]);?>">
		<?=  count($files[$key]).' '.$key;?>
		
	</div>
<? }?>