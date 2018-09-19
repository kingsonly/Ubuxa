<?
use yii\helpers\Url;
?>
<div id="folderusers">
<?php foreach($attributues as $users){ 
	$image = !empty($users["image"])?$users["image"]:'default.png';
	?>
	<span class="img-circular" style="background-image:url('<?= Url::to('@web/images/users/'.$image); ?>')" aria-label="<?= $users["username"];?>"></span>
	<? }; ?>
	</div>