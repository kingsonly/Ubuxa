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
	height: 60px;
}
#button-text {
	color: rgb(122, 134, 154);
	width: 100%;
	height: 48px;
	display: table;
	font-size: 14px;
	font-weight: 400;
	padding-left: 20px;
}

#button-text span {
	display: table-cell;
	vertical-align: middle;
}

</style>


<section id="carousles">
	<? if($buttonType !== 'text'){?>
		<div id="button-image"></div>
	<? }else{?>
		<div id="button-text">
			<span><h4><i class="fa fa-plus"></i> Create folder</h4></span>
		</div>
	<?}?>
</section>


<?
$Carousel = <<<Carousels

$("#button-image").click(function(e){
    
	$( ".folder-new-content" ).slideUp( 300 ).delay( 800 );
	$( ".create-new-folder" ).slideDown( 300 ).delay( 800 ).fadeIn( 400 );
	
     e.stopPropagation();
});

$("#button-text").click(function(e){
	$( ".folder-new-content" ).hide();
	$( ".create-new-folder" ).delay( 100 ).fadeIn( 400 );
     e.stopPropagation();
});



$(".create-new-folder").click(function(e){
    e.stopPropagation();
});

$(document).click(function(){
    $('.folder-new-content').show()
	$('.create-new-folder').hide()
});



Carousels;
 
$this->registerJs($Carousel);
?>

