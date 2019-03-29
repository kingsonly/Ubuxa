<?php 

use frontend\models\Folder;
use yii\helpers\Html;
use yii\helpers\Url;
$jsEventTriger = $htmlAttributes['class'];
?>
<style>	
.creste-image {
	background-image: url('images/folder/newfolder.png');
	background-repeat: no-repeat; 
	width: 79px;
	background-size: contain;
	height: 60px;
}
.text {
	color: rgb(122, 134, 154);
	min-width: 100%;
	height: 48px;
	display: table;
	font-size: 14px;
	font-weight: 400;
	padding-left: 20px;
	cursor: pointer;
}
	
	.create-text{
		text-align: center !important;
		display: inline;
		color: #ccc;
		letter-spacing: 3px;
		transform: scale(1.5,1);
		width: 100% !important;
		position: absolute;
	}
	
	.icon{
		background: #ccc;
		text-align: center;
		vertical-align: middle;
		height: 50px;
		position: relative;
		margin-top: 1px;
		
	}
	.test-icon{
		width:40% !important;
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
	
	h4 .fa.fa-plus {
		color: green;
	}

	
</style>


<section id="carousles">
	<? if($buttonType == 'text'){?>
			<div id="<?= $jsEventTriger;?>-text" style="<?= array_key_exists("style",$htmlAttributes)?$htmlAttributes['style']:'';?>" class="text <?= $class;?> <?= $jsEventTriger;?>-text">
				<div>
					<h4>
						<i class="fa fa-plus"></i>
						<span class="create-text">Create a new subfolder</span>
					</h4>
				</div>
			</div>
	<? }elseif($buttonType == 'icon'){ ?>
		<div class="dropdown">
		<div id="<?= $jsEventTriger;?>-icon" style="<?= array_key_exists("style",$htmlAttributes)?$htmlAttributes['style']:''; ?>" class="<?= $class;?> <?= $jsEventTriger;?>-icon dropdown-toggle" id="dropdownMenuButton_<?= $jsEventTriger;?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<div class="icondesign"><strong><i class="fa fa-plus"></i></strong></div>
		</div>

		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		<? foreach($componentTemplate as $componentList){?>
		<li id="<?= $jsEventTriger.$componentList->id;?>-component" data-templateid="<?= $componentList->id; ?>"data-templatestring="Create <?= $componentList->name; ?>" class="<?= $jsEventTriger;?>-component">Create <?= $componentList->name;?></li>
		
		<?}?>

		</div>
		</div>
	<? } else{?>
		<div id="<?= $jsEventTriger;?>-image" style="<?= array_key_exists("style",$htmlAttributes)?$htmlAttributes['style']:'';?>" class="creste-image <?= $jsEventTriger;?>-image"></div>
	<?}?>
</section>


<?

$Carousel = <<<Carousels

$("#"+"$jsEventTriger"+"-image").click(function(e){
    
	$( ".$jsEventTriger-new-content" ).slideUp( 300 ).delay( 800 );
	$( ".create-new-$jsEventTriger" ).removeClass('display-non');
	$( ".create-new-$jsEventTriger" ).addClass('display');
	
     e.stopPropagation();
});

$("#"+"$jsEventTriger"+"-text").click(function(e){
	$( ".$jsEventTriger-new-content" ).hide();
	$( ".create-new-$jsEventTriger" ).removeClass('display-non');
	$( ".create-new-$jsEventTriger" ).addClass('display');
     e.stopPropagation();
});

$("#"+"$jsEventTriger"+"-icon").click(function(e){
	
	 $iconJs
});

$("."+"$jsEventTriger"+"-component").click(function(){
	$( ".$jsEventTriger-new-content" ).hide();
	//$( ".create-new-$jsEventTriger" ).delay( 100 ).fadeIn( 400 );
	$( ".create-new-$jsEventTriger" ).find('#component-component_template_id').val($(this).data('templateid'));
	$( ".create-new-$jsEventTriger" ).find('#create-new-create-component-form-title').attr('placeholder',$(this).data('templatestring'));
	$( ".create-new-$jsEventTriger" ).removeClass('display-non');
	$( ".create-new-$jsEventTriger" ).addClass('display');
     
});






$(".create-new-$jsEventTriger").click(function(e){
    e.stopPropagation();
});

$(".$jsEventTriger-component").click(function(e){
    e.stopPropagation();
});

$(document).click(function(){
	//$('.create-new-folder').hide();
	
	$('.create-new-$jsEventTriger').addClass('display-non');
	$('.create-new-$jsEventTriger').removeClass('display');
    $('.$jsEventTriger-new-content').show();
	
	
});





Carousels;
 
$this->registerJs($Carousel);
?>

