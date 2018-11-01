<?php

use yii\helpers\Html;
use yii\grid\GridView;
use boffins_vendor\components\controllers\FolderCreateWidget;
use boffins_vendor\components\controllers\CreateButtonWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Folders';
?>

<style>
.private{
	background-color: red;
}
.author{
	background-color: blue;
}
.users{
	background-color: aquamarine;
}
.folders-container {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	justify-content: space-around;
}

.folder-item{
	line-height: 150px;
	font-size: 20px;
	width:70px;
	text-align: center;
	display: inline-block;
	
}	

.folder-item.filled {
	background-image: url('images/folder/folderfill.png');
	background-repeat: no-repeat; 
	background-size: cover; 
	height: 60px;
}

.folder-item.empty {
	background-image: url('images/folder/folderempty.png');
	background-repeat: no-repeat; 
	background-size: cover; 
	height: 60px;
}
	
	.folder-create{
	background-image: url('images/folder/folderempty.png');
	background-repeat: no-repeat; 
	background-size: cover; 
	height: 60px;
	display: inline-block;
	width: 69px;
}





.owl-buttons {
  display: none;
}


.owl-item {
  text-align: center;
}

	
	.owl-prev {
    width: 15px;
    height: 57px;
    position: absolute;
    top: 0%;
    margin-left: -20px;
    display: block!IMPORTANT;
    border:0px solid black;
}

.owl-next {
    width: 15px;
    height: 57px;
    position: absolute;
    top: 0%;
    right: 8px;
    display: block!IMPORTANT;
    border:0px solid black;
}
.owl-prev i, .owl-next i { 
	color: #ccc !important; 
	font-size:20px
}
.owl-prev:hover,.owl-next:hover{
	background-color: rgba(255, 0, 0, 0) !important ;
}
 .owl-carousel .owl-nav button.owl-prev{
	border-right: solid #ccc 1px !important;
	padding-right: 18px !IMPORTANT;
	 left: -10px;
	 border-radius:0px !important;
	 background: #fff !important;
}
 .owl-carousel .owl-nav button.owl-next{
	border-left: solid #ccc 1px !important;
	padding-left: 5px !IMPORTANT;
	 border-radius:0px !important;
	 background: #fff !important;
}

.folder-content{
	padding-right: 0px;
}

.folder-text{
	padding-left: 0px;
	padding-right: 0px;
	text-align: left;
	padding-bottom: 25px;
	color: #333;
	overflow: hidden;	
	width:40%;
	white-space: nowrap;
	display: inline-block;
}

.ellipsis
{
text-overflow: ellipsis;
}

.create-new-folder{
	display:none;
}
#carousles{
	margin-top: 10px;
}
.owl-prev{
	width:23px !important;
} 
</style>


<style>




.accordion {
  
  margin: 0 auto;
  border-radius: 5px;
}

.accordion-header,
.accordion-body {
  background: white;
}

.accordion-header {
  padding: 1.5em 1.5em;
  background: #3F51B5;
  text-transform: uppercase;
  color: white;
  cursor: pointer;
  letter-spacing: .1em;
  transition: all .3s;
}

.accordion-header:hover {
  background: #2D3D99;
  position: relative;
  z-index: 5;
}

.accordion-body {
  background: #fcfcfc;
  color: #3f3c3c;
  
}


.accordion__item.active:last-child .accordion-header {
  border-radius: none;
}

.accordion:first-child > .accordion__item > .accordion-header {
  border-bottom: 1px solid transparent;
}

.accordion__item > .accordion-header:after {
 content: "\f0d8";
  font-family: FontAwesome;
  font-size: 1.2em;
  float: right;
  position: relative;
  top: -2px;
  transition: .3s all;
  transform: rotate(0deg);
}

.accordion__item.active > .accordion-header:after {
  transform: rotate(-180deg);
}

.accordion__item.active .accordion-header {
  background: #2D3D99;
}

.accordion__item .accordion__item .accordion-header {
  background: #f1f1f1;
  color: black;
}
.accordion__item .accordion__item {
  border-bottom: 1px dotted #2D3D99;
}

@media screen and (max-width: 1000px) {
  
  
  .accordion {
    width: 100%;
  }
}
	.create-new-test{
		display: none;
	}
</style>
<div class="folder-index">

    <p>
        
		<?= CreateButtonWidget::widget(['buttonType' => 'text','htmlAttributes'=>['class'=>'test']]);?>
    </p>
	<div class="create-new-test">
		<?= FolderCreateWidget::widget(); ?>
	</div>
	<div class="accordion js-accordion">
		<? 
		
		$i = 1;
		
		foreach($folders as $firstKey => $folder){?>
		
			<div class="accordion__item js-accordion-item ">
    <div class="accordion-header js-accordion-header"><?= $firstKey;?></div> 
				<div class="accordion-body js-accordion-body">
    	
			<? foreach($folder as $secondKey => $actuallFolder){?>
			
			<div class="accordion js-accordion">
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header"><?= $secondKey;?> folder</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
				 <div class="container">
				 <div class="row">
              <? foreach($actuallFolder as $newactualfolder){?>
		
			<?
			 $url = Url::to(['folder/view', 'id' => $newactualfolder['id']]);
			 ?>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6" style="padding: 20px;">
            <a href="<?= $url;?>" data-pjax="0">
			 	<div id="folder-item-<?php echo $newactualfolder['id']; ?>" class="folder-item <?php echo $newactualfolder->isEmpty ? 'empty' : 'filled' ?> <?= $newactualfolder->folderColors; ?>" data-toggle="tooltip" title="<?= $newactualfolder['title']; ?>" data-placement="bottom"> 
				</div>
			 	<div class="folder-text .ellipsis">
					
						<?= $newactualfolder['title']; ?>
					
				</div>
				</a>
        </div>
				 

			
			<? }?>
			   </div>
			   </div>
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
			
					</div>
			<? }?> 
			</div>
			</div>
		<? $i++; }?> 
	
	</div>
	


	
</div>







	
	
	<?php 
$indexJs = <<<JS
var accordion = (function(){
  
  var accordions = $('.js-accordion');
  var accordion_header = accordions.find('.js-accordion-header');
  var accordion_item = $('.js-accordion-item');
 
  // default settings 
  var settings = {
    // animation speed
    speed: 400,
    
    // close all other accordion items if true
    oneOpen: false
  };
    
  return {
    // pass configurable object literal
    init: function(settingss) {
      accordion_header.on('click', function() {
        accordion.toggle($(this));
      });
      
      $.extend(settings, settingss); 
      
      // reveal the active accordion bodies
      $('.js-accordion-item.active').find('> .js-accordion-body').show();
    },
    toggle: function(thiss) {
            
      if(settings.oneOpen && thiss[0] != thiss.closest('.js-accordion').find('> .js-accordion-item.active > .js-accordion-header')[0]) {
        thiss.closest('.js-accordion')
               .find('> .js-accordion-item') 
               .removeClass('active')
               .find('.js-accordion-body')
               .slideUp()
      }
      
      // show/hide the clicked accordion item
      thiss.closest('.js-accordion-item').toggleClass('active');
      thiss.next().stop().slideToggle(settings.speed);
    }
  }
})();

$(document).ready(function(){
  accordion.init({ speed: 300, oneOpen: false });
});
	
JS;
 
$this->registerJs($indexJs);
?>