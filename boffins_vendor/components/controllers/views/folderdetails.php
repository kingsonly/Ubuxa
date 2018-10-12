<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
?>

<style type="text/css">
	.folder_image{
		width: 100%;
		height: 120px;
	}
	
	.folder-image-cont{
		
		width: 100%;
	}
	.info{
		background: #fff;
	    padding-left: 15px;
	    box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
	    border-bottom: 5px solid rgb(7, 71, 166);
	}
	
	.private-border-bottom-color{
		border-bottom: 5px solid red;
	}
	.author-border-bottom-color{
		border-bottom: 5px solid rgb(7, 71, 166);
	}
	.users-border-bottom-color{
		border-bottom: 5px solid aquamarine;
	}

	.folder-header {
	    padding-top: 7px;
	    padding-bottom: 7px;
	    font-weight: bold;
	}

	.box-content-folder {
		border-top: 1px solid #ccc;
		height:120px;
		
	}

	.folder-side {
		
	}
	.box-folders {
		padding-left: 0px;
    	padding-right: 0px;
		overflow: hidden;
	}
	#folder-description-cont{
		width: 100%;
	}
	.image-update{
		display: none;
	}
	.close-update{
		width: 100%;
		display: block;
		background: red;
	}
</style>

<div class="col-md-5 folderdetls">

	<div class="col-sm-12 col-xs-12 info column-margin <?= $model->folderColors.'-border-bottom-color'; ?>">
		<div class="folder-header">FOLDER DETAILS</div>
		<div class="col-sm-7 col-xs-7 box-folders">
			<div class="folder-side">
				<div class="box-content-folder">
					<?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
					['modelAttribute'=>'title'],
					['modelAttribute'=>'description']
					]]); ?>
				</div>

			</div>
		</div>
		<div class="col-sm-5 col-xs-5 box-folders-count">
            <div class="folder-image-cont">
				<div class="image-holder">
					<?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
					['modelAttribute'=>'folder_image','xeditable' => 'image','url' => $url],
					
					]]); ?>
				</div>
				
				<div class="image-update">
					<span class="close-update">Close</span>
					
				</div>
				
				</div>
        </div>
	</div>
</div>



<?
$updateImage = <<<updateImage


updateImage;
 
$this->registerJs($updateImage);
?>
