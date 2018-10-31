<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\FolderCarouselWidget;
use boffins_vendor\components\controllers\CreateButtonWidget;
use boffins_vendor\components\controllers\SearchFormWidget;
use yii\widgets\Pjax;
?>

<style type="text/css">
	.subfolder-container{
		padding-left: 15px;
	    background: #fff;
	    padding-right: 15px;
	    box-shadow: 4px 19px 25px -2px rgba(0,0,0,0.1);
		height: 160px;
		overflow: hidden;
	}

.box-sub-folders {
		height:122px;
	}

	.box-subfolders {
		height:122px;
	}
	.subheader {
	    padding-top: 7px;
	    padding-bottom: 7px;
	    font-weight: bold;
	    background-color: #fff;
	    border-bottom: 1px solid #ccc;
	}
	.sub-second {
		padding-right: 0px !important;
    	padding-left: 0px !important;
	}
	.subfirst {
		background-color: transparent;
    padding-left: 0px !important;
    padding-right: 0px !important;
    background: #fff;
	}
	.info-2 {
		background-color: #fff;
	}
	.subheader{
		margin-bottom: 20px;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php Pjax::begin(['id'=>'create-folder-refresh']); ?>
<div class="col-md-7">
	<div class="col-sm-12 col-xs-12 subfolder-container column-margin">
		<div class="col-sm-12 col-xs-12 subheader">
			<div class="col-sm-3 col-xs-3 sub-folder">
				<span class="subfolder">SUB FOLDERS</span> 
			</div>
			
			<div class="col-sm-9 col-xs-9 form-widget" >
				<?= SearchFormWidget::widget();?>
			</div>
		</div>
		<? if(!empty($folderModel)){?>
		<div class="col-xs-5 col-sm-2 sub-second">
				<div class="info-2">
					<div class="box-subfolders"><?= CreateButtonWidget::widget(['htmlAttributes'=>['class'=>$createButtonWidgetAttributes['class']]]);?></div>
				</div>
   		</div>
		<? }?>
		<? if(!empty($folderModel)){?>
		
			<div class="col-xs-7 col-sm-10 subfirst ">
		<? }else{?>
			<div class="col-xs-12 col-sm-12 subfirst ">
		<? }?>
			<div class="info-2">
				<div class="box-sub-folders">
					<?= FolderCarouselWidget::widget(['folderModel' => $folderModel,'numberOfDisplayedItems' => 3,'htmlAttributes'=>$folderCarouselWidgetAttributes['class'],'folderCarouselWidgetAttributes'=>['folderPrivacy'=>$folderPrivacy]]) ?>
				</div>
			</div>
		</div>
	</div>
</div>


	
<?php Pjax::end(); ?>

