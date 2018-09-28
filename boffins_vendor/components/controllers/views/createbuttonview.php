<?php 

use frontend\models\Folder;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<style>	
	#button-image {
	background-image: url('images/folder/newfolder.png');
	background-repeat: no-repeat; 
	width: 79px;
	background-size: contain;
	height: 79px;
}
	#button-text {
	display: none;
}
</style>


<section id="carousles">
  <div id="button-image"></div>
  <div id="button-text"></div>
    </section>


<?
$Carousel = <<<Carousels
$("#button-image").on("click", function() {
	$('.folder-new-content').hide()
	$('.create-new-folder').show()
})

$(document).on('click',function (e) {
  createFolder = $('#button-image');
  if (!createFolder.is(e.target) 
      && createFolder.has(e.target).length === 0){
   $('.folder-new-content').show()
	$('.create-new-folder').hide()
	
  }
});


Carousels;
 
$this->registerJs($Carousel);
?>

