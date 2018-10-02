<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
?>

<style type="text/css">
	.info{
		background: #fff;
	    padding-left: 15px;
	}

	.box-content-folder {
		height:120px;
	}
	.nothing {
		border-bottom: 5px solid rgb(7, 71, 166);
	}
	.folder-side {
		width: 60%;
	}
</style>

<div class="col-md-5 folderdetls">
	<div class="info column-margin">
		<div class="folder-side">
			<div class="header">FOLDER DETAILS</div>
			<div class="box-content-folder">
				<?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
	['modelAttribute'=>'title'],
	['modelAttribute'=>'description']
]]); ?>
			</div>
		</div>
	</div>
	<div class="nothing"></div>
</div>
