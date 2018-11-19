<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use boffins_vendor\components\controllers\Menu;
use yii\bootstrap\Modal;
use yii\jui\Draggable;


/* @var $this yii\web\View */
/* @var $model app\models\Folder */



?>
<style>
	/*
.floatright{
	float: right;
}
	
.foldernote{
	line-height: 24px;
	text-underline-position: alphabetic;
	margin-top: 10px;
}
	
#loading{
	display:none;
}

#flash{
	display: none;
}

#componentviewcontent{
	background: #fff;
	margin-top: 22px;
	min-height: 600px;
}
	*/
</style>
<?php $this->beginBlock('folderview'); ?>

	<small>Select </small>
   
<?php $this->endBlock(); ?>

<?php $this->beginBlock('folderSidebar'); ?>
	<?//= Menu::widget(); ?>
<?php $this->endBlock(); ?>

<section class="content">
	
	<div class="row">
		<div class="col-lg-12">
			<?= Alert::widget([
				   'options' => ['class' => 'alert-info','id'=>'flash'],
				   'body' => Yii::$app->session->getFlash('created_successfully'),
					 ]);?>
		</div>
	</div>
	
  
      <div class="row">
          
		  <div class="col-xs-12" id="listView">
			  <img class="loadergif" src="images/loader.gif"  />
			
		  </div>
		  
		  <div id="view-content" class="col-xs-5" style="display:none" >
			  
			  <div id="viewcontainer">
				  <div id="view">
				  <img class="loadergif" src="images/loader.gif"  />
				  </div>
			  </div>
		  </div>
    </div>
</section>
<? 
Modal::begin([
	'header' =>'<h1 id="headers"></h1>',
	'id' => 'dashboard',
	'size' => 'modal-md',  
]);
?>
<div id="formcontent"></div>
<?
	Modal::end();
?>

<?php 

	$urlListView = Url::to(['component/listview','folder'=>$folderId,'component' => $templateId]);
	$urlView = Url::to(['component/view','id'=>$componentId->id]);
	
$js3 = <<<JS

$('table').tablesorter({
			widgets        : ['zebra', 'columns'],
			usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true
		});

$("#listView").load('$urlListView');
$("#view").load('$urlView',{var2:1});




JS;
 
$this->registerJs($js3);
?>