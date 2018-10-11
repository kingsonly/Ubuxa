<?
use yii\helpers\Url;
?>
<style>
	.img-circular{
 width: 30px;
 height: 30px;
 background-repeat: no-repeat;
 background-size: cover;
 display: inline-block;
border:solid 1px #666;
 border-radius: 15px;
 -webkit-border-radius: 15px;
 -moz-border-radius: 15px;
background-color: #fff;
transition: margin-top 0.1s ease-out 0s;
}
	.user-name{
		color: #ccc;
		font-size: 13px;
		margin-left: 1px;
		display: inline-block;
		position: absolute;
		height: 30px;
		padding-top: 3px;
	}

	#folderusers{
		display: flex;
		flex: 1;
	}
	.user-container{
		width: 80px;
		overflow: hidden;
	}
	#invitenewuser{
		color: #666;
		font-size: 13px;
		display: inline-block;
		height: 30px;
		padding-top: 4px;
		margin-right: 5px;
	}
	
	#plus-button{
		color: #666;
		font-size: 13px;
		display: inline-block;
		
		padding-top: 4px;
		margin: 0 5px;
		width: 30px;
 height: 30px;
		
 border-radius: 15px;
 -webkit-border-radius: 15px;
 -moz-border-radius: 15px;
background-color: #fff;
		text-align: center;
	}
	.fa-plus{
		width:20px;
		height: 20px;
		background: #ccc;
		border-radius: 15px;
 -webkit-border-radius: 15px;
 -moz-border-radius: 15px;
		padding-top: 3.5px;
		color:greenyellow !important;
	}
	</style>
<div id="folderusers" class="row">
	<span id="invitenewuser">AUTHORISED USERS</span>
	<span id="plus-button"><i class="fa fa-plus"></i></span>
<?php foreach($attributues as $users){ 
	$image = !empty($users["image"])?$users["image"]:'default.png';
	?>
	<div class="user-container">
		<div class="img-circular" style="background-image:url('<?= Url::to('@web/images/users/'.$image); ?>')" aria-label="<?= $users["username"];?>"></div>
		<div class="user-name"><?= $users["username"];?></div>
	</div>
	
	<? }; ?>
	</div>