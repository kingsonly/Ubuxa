<?php 

use frontend\models\Folder;
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\FolderCreateWidget;
use boffins_vendor\components\controllers\CreateButtonWidget;
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
.private_color{
	color: red;
}
.author_color{
	color: blue;
}
.users_color{
	color: aquamarine;
}
hr{
	margin-top: 2px;
	margin-bottom: 2px;
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

.cabinet {
	background-image: url('images/cabinet_resized.png');
	background-repeat: no-repeat; 
}

.folder-ref,
.cabinet-span {
	width: 100%;
	height: 100%;
	display: block;
	position: relative;
}

.folder-ref a,
.cabinet-span a {
	width: 100%;
	height: 100%;
	display: block;
	position:absolute;
	left: 0;
	top: 0;
	text-decoration: none; /* No underlines on the link */
	z-index: 10; /* Places the link above everything else in the div */
	background-color: #FFF; /* Fix to make div clickable in IE */
	opacity: 0; /* Fix to make div clickable in IE */
	filter: alpha(opacity=1); /* Fix to make div clickable in IE */
}

@media screen and (min-width: 320px) and (max-width: 599px) {
	/*************BASIC MOBILE PHONE(320px AN ABOVE) TO TABLET VIEW (600px ABD ABOVE) ***************/
	.folder-item {
		order: 2;
	}
	.cabinet {
		order: 1;
	}
}

.owl-buttons {
  display: none;
}


.owl-item {
  text-align: center;
}

	
	.owl-prev {
    width: 15px;
    height: <?= !empty($height)?$height.'px':'57px' ; ?> ;
    position: absolute;
    top: 0%;
    margin-left: -20px;
    display: block!IMPORTANT;
    border:0px solid black;
}

.owl-next {
    width: 15px;
    height: <?= !empty($height)?$height.'px':'57px' ;?> ;
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
	
}
.owl-prev{
	width:23px !important;
} 
.component-list{
	list-style: none;
	}
	.component-holder{
	
    line-height: 40px;
    height: inherit;
	padding-top: 10px;
	
	}
	.active-component{
		width: 70%;
		margin: 0 auto;
		border-bottom: solid 3px red;
		padding-bottom: 9px !important;
		text-decoration: none;
		list-style: disc !important;
	}
	#carousles button .fa{
		color: green !important;
	}
	
</style>


<section id="carousles">

      <div class="row folder-new-content">
		  
        <div class="large-12 columns">
			<? if(!empty($folderModel)){?>
          <div class="owl-carousel owl-theme <?= $displayType;?>">
              <?php foreach ($folderModel as $folder) { ?>
		 <div class="item">
			 <? if($displayType == 'component'){?>
			 <div class="component-holder">
				 <li class="component-list " data-url = "<?= Url::to(['/invoice'])?>">
					 <?= $folder ?>
				 </li>
			 </div>
			 
			
			 <? } else{?>
			
			<?
			 $url = Url::to(['folder/view', 'id' => $folder['id']]);
			 ?>
			 <div class="folder-content col-sm-12">
				 <a href="<?= $url;?>" data-pjax="0">
			 	<div id="folder-item-<?php echo $folder['id']; ?>" class="folder-item <?php echo $folder->isEmpty ? 'empty' : 'filled' ?> <?= $folder->folderColors; ?>" data-toggle="tooltip" title="<?= $folder['title']; ?>" data-placement="bottom"> 
				</div>
			 	<div class="folder-text .ellipsis">
					
						<?= $folder['title']; ?> <br/><hr/>
					<?
					$numItems = count($folder->tree);
					$i = 0;
					foreach($folder->tree as $path){ 
					if(++$i === $numItems) {
						?>
						<span class="<?= $folder->folderColors.'_color'; ?>"> <?= $path->title; ?> </span>
					<?  }else{ ?>
						<span class="<?= $folder->folderColors.'_color'; ?>"> <?= $path->title; ?> ></span>
					<? }; }; ?>
					
				</div>
				
				</a>
			 </div>
			 <? }?>
			</div>
		<?php } ?>
            
            
          </div>
         <?}else{?>
			<? if($displayType == 'component'){?>
			Click on the Create Button to Add A new component to folder 
			<? }else{?>
			<div><?= CreateButtonWidget::widget(['buttonType' => 'text']);?></div>
			<? }?>
         <?}?>
        </div>
      </div>
	<div class="create-new-folder">
		<?= FolderCreateWidget::widget();?>
	</div>
    </section>


<?
$Carousel = <<<Carousels

var owl = $('.'+'$displayType');

              owl.owlCarousel({
                nav: true,
                loop: false,
				 dots: false,
				 lazyLoad: true,
				 responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 2
                  },
                  1000: {
                    items: $numberOfDisplayedItems
                  }
                },
				navText : ['<i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>','<i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>'],
               
              });
			  
			  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".owl-item").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  
		
		
		$(".folder-text").mouseover(function() {
    $(this).removeClass("ellipsis");
    var maxscroll = $(this).width();
    var speed = maxscroll * 15;
    $(this).animate({
        scrollLeft: maxscroll
    }, speed, "linear");
});

$(".folder-text").mouseout(function() {
    $(this).stop();
    $(this).addClass("ellipsis");
    $(this).animate({
        scrollLeft: 0
    }, 'slow');
});

$('.component-list').on('click',function(){
	$('.component-list').removeClass('active-component');
	data = $(this).data('url');
	$(this).addClass('active-component');
	$('.comps').removeClass('margin-bottom');
	$('.component-display').load(data);
	$('.component-display-wrapper').show()
	
})

Carousels;
 
$this->registerJs($Carousel);
?>

