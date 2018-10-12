<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use app\boffins_vendor\components\controllers\Menu;
use yii\bootstrap\Modal;
use yii\jui\Draggable;


/* @var $this yii\web\View */
/* @var $model app\models\Folder */
$controlerStrinName = strtolower(\yii\helpers\StringHelper::basename(get_class($model)));
$this->title = 'Tycol | '.ucfirst($controlerStrinName);
$this->params['breadcrumbs'][] = ['label' => ' Folders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
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
</style>
<?php $this->beginBlock('folderview'); ?>

	<small>Select <?= ucfirst($controlerStrinName);?></small>
   
<?php $this->endBlock(); ?>

<?php $this->beginBlock('folderSidebar'); ?>
	<?= Menu::widget(); ?>
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
          
		  <div class="col-xs-7" id="listView">
			  <img class="loadergif" src="images/loader.gif"  />
			
		  </div>
		  
		  <div class="col-xs-5" >
			  
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

	$urlListView = Url::to([$controlerStrinName.'/'.$controlerStrinName.'listview']);
	$urlView = Url::to([$controlerStrinName.'/'.$controlerStrinName.'view','id'=>$id]);
	
$js3 = <<<JS


$("#listView").load('$urlListView');
$("#view").load('$urlView',{var2:1});

$(document).on('click','.$controlerStrinName'+'url',function(){
	var parent = $(this).parent();

	$('.$controlerStrinName'+'urltr').removeClass('activelist');
	parent.addClass('activelist');

	$('#view').html('<img class="loadergif" src="images/loader.gif"  />');
	var url = parent.data('url');
	$("#view").load(url,{var2:1},function(){
		$('#loader').slideUp('slow');
		$('#viewcontainer').slideDown('fast');

	});
})
$(document).on('click','#create'+'$controlerStrinName',function(){
	var formUrl = $(this).data('formurl');
	$('#$controlerStrinName'+'viewcreate').modal('show').find('#$controlerStrinName'+'createform').load(formUrl);

})


JS;
 
$this->registerJs($js3);
?>