<?php
use yii\helpers\Url;
use yii\helpers\Html;
$waitToLoad = Yii::$app->settingscomponent->boffinsLoaderImage($size = 'md', $type = 'link');
?>
<style>
.modal-loading{
	height: 400px;
}
.modal-busy{
position: fixed;
left: 30%;
top: 30%;
width: 200px;
height: 200px;
background: url(<?= $waitToLoad; ?>) center no-repeat #fff;
}
</style>
<div class="modal-contents modal-loading">
	<div class="modal-busy"></div>
</div>

<?php
$modalurl = Url::to(['task/view', 'id' => $id,'folderId' => $folderId]);
$loadModal = <<<JS

setTimeout(function(){
  $.ajax({
    url: '$modalurl',
    success: function(data) {
    	$('.modal-contents').removeClass('modal-loading')
    	$('.modal-busy').fadeOut();
        $('.modal-contents').html(data);
     }
});
}, 1000);
JS;
$this->registerJs($loadModal);
?>
