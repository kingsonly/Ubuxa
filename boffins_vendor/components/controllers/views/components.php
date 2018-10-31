<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\FolderUsersWidget;
use boffins_vendor\components\controllers\CreateButtonWidget;
use boffins_vendor\components\controllers\FolderCarouselWidget;
?>
<style type="text/css">
	
.comps {
	background-color: white;
	height: 110px;
	
	margin-top: 20px;
	box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
	padding-left: 15px;
	padding-right:15px;
	
}

	
.auth-users {
	border-bottom: 1px solid #ccc;
	padding-top: 12px;
}
	.components .col-sm-12, .components .col-xs-12,.components .col-xs-5,.components .col-sm-2{
		padding-left: 0px !important;
	}
	
	.component-display{
		height: 600px;
		background-color: white;
		margin-bottom: 20px;
		box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
		padding-left: 15px;
		padding-right:15px;
		overflow: hidden;
		border-top: solid 2px green;
	}
	
	.component-display-wrapper{
		padding-top:5px;
		display: none;
	}
	
	.margin-bottom{
		margin-bottom: 20px;
	}

</style>

<div class="col-sm comps margin-bottom">
    <div class="auth-users"><?= FolderUsersWidget::widget(['attributues'=>$users,'id'=>$id])?></div>
	<div class="components">
		<div class="col-sm-12 col-xs-12  column-margin component-contetnt">
		
		<div class="col-xs-5 col-sm-2 ">
				<div class="">
					<div class=""><?= CreateButtonWidget::widget(['buttonType' => 'icon','htmlAttributes'=>['class'=>'test'] ]);?></div>
				</div>
   		</div>
		
		
			<div class="col-xs-7 col-sm-10 component-carousel ">
		
			<div class="">
				<div class="">
					<?= FolderCarouselWidget::widget([
							'folderModel' => $components, 
							'displayType' => 'component',
							'height' => $height,
							'numberOfDisplayedItems' => 4,
							'htmlAttributes'=>'test',
						]) ?>
				</div>
				</div>
			
		</div>
	</div></div>
</div>

<div class="component-display-wrapper">
	<div class="col-sm-12 col-xs-12 component-display">test</div>
</div>