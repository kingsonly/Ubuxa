<?php 

use frontend\models\Folder;
use yii\helpers\Html;
use yii\helpers\Url;
$jsEventTriger = $htmlAttributes['class'];
?>
<style>	
.image {
	background-image: url('images/folder/newfolder.png');
	background-repeat: no-repeat; 
	width: 79px;
	background-size: contain;
	height: 60px;
}
.text {
	color: rgb(122, 134, 154);
	width: 100%;
	height: 48px;
	display: table;
	font-size: 14px;
	font-weight: 400;
	padding-left: 20px;
}

.text span {
	display: table-cell;
	vertical-align: middle;
}
	.icon{
		background: #ccc;
		text-align: center;
		vertical-align: middle;
		height: 50px;
		width: 40%;
		position: relative;
		margin-top: 1px;
	}
	
	.icondesign{
		width: 30px;
		height: 30px;
		border-radius: 50%;
		background: green;
		margin: 0 auto;
		margin: auto;
  position: absolute;
  top: 0; left: 0; bottom: 0; right: 0;
	}
	.icondesign .fa{
		color: #fff !important;
		padding-top: 8px;
	}

</style>


<section id="carousles">
	<? if($buttonType == 'text'){?>
	<div id="<?= $jsEventTriger;?>-text" class="text <?= $class;?> <?= $jsEventTriger;?>-text">
			<span><h4><i class="fa fa-plus"></i> Create folder</h4></span>
		</div>
	
		
	<? }elseif($buttonType == 'icon'){ ?>
	<div id="<?= $jsEventTriger;?>-icon" class="<?= $class;?> <?= $jsEventTriger;?>-icon">
			<div class="icondesign"><strong><i class="fa fa-plus"></i></strong></div>
		</div>
	<? } else{?>
		<div id="<?= $jsEventTriger;?>-image" class="image <?= $jsEventTriger;?>-image"></div>
	<?}?>
</section>


<?

$Carousel = <<<Carousels

$("#"+"$jsEventTriger"+"-image").click(function(e){
    
	$( ".folder-new-content" ).slideUp( 300 ).delay( 800 );
	$( ".create-new-folder" ).slideDown( 300 ).delay( 800 ).fadeIn( 400 );
	
     e.stopPropagation();
});

$("#"+"$jsEventTriger"+"-text").click(function(e){
	$( ".folder-new-content" ).hide();
	$( ".create-new-folder" ).delay( 100 ).fadeIn( 400 );
     e.stopPropagation();
});


$("#"+"$jsEventTriger"+"-icon").click(function(e){
	alert(1);
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

