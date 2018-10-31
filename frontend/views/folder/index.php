<?php

use yii\helpers\Html;
use yii\grid\GridView;
use boffins_vendor\components\controllers\FolderCreateWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Folders';
$this->params['breadcrumbs'][] = $this->title;
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


body {
  font-size: 62.5%;
  background: #dadada;
  font-family: 'Open Sans', sans-serif;
  line-height: 2;
  padding: 5em;
}

.accordion {
  font-size: 1rem;
  width: 30vw;
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
  font-size: .8em;
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
  display: none;
}

.accordion-body__contents {
  padding: 1.5em 1.5em;
  font-size: .85em;
}

.accordion__item.active:last-child .accordion-header {
  border-radius: none;
}

.accordion:first-child > .accordion__item > .accordion-header {
  border-bottom: 1px solid transparent;
}

.accordion__item > .accordion-header:after {
  content: "\f3d0";
  font-family: IonIcons;
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

@media screen and (max-width: 1000px) {
  body {
    padding: 1em;
  }
  
  .accordion {
    width: 100%;
  }
}
</style>
<div class="folder-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= FolderCreateWidget::widget(); ?>
    </p>
	<div class="row" style="background:#fff;">
		<? 
		
		
		foreach($folders as $firstKey => $folder){?>
		
			<div style="border:solid 2px red; margin-top:20px;">
				<?= $firstKey;?>
			<? foreach($folder as $secondKey => $actuallFolder){?>
			<?= $secondKey;?>
			<? foreach($actuallFolder as $newactualfolder){?>
		
			
				<?= $newactualfolder->id;?>
			
			<? }?>
		
			<? }?> 
			</div>
		<? }?> 
	
	</div>
	


	
</div>

<pre>
		<? //var_dump($categoryToTag1);?>
	</pre>	

<!--
<?/*
			 $url = Url::to(['folder/view', 'id' => $folder['id']]);
			 ?>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6" style="padding: 20px;">
            <a href="<?= $url;?>" data-pjax="0">
			 	<div id="folder-item-<?php echo $folder['id']; ?>" class="folder-item <?php echo $folder->isEmpty ? 'empty' : 'filled' ?> <?= $folder->folderColors; ?>" data-toggle="tooltip" title="<?= $folder['title']; ?>" data-placement="bottom"> 
				</div>
			 	<div class="folder-text .ellipsis">
					
						<?= $folder['title'];*/ ?>
					
				</div>
				</a>
        </div>
-->



<div class="accordion js-accordion">
  <div class="accordion__item js-accordion-item">
    <div class="accordion-header js-accordion-header">Panel 1</div> 
  <div class="accordion-body js-accordion-body">
    <div class="accordion-body__contents">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
    </div>
      <div class="accordion js-accordion">
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 1</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 2</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
      </div><!-- end of sub accordion -->
    </div
    </div><!-- end of accordion body -->
  </div><!-- end of accordion item -->
  <div class="accordion__item js-accordion-item active">
    <div class="accordion-header js-accordion-header">Panel 2</div> 
  <div class="accordion-body js-accordion-body">
    <div class="accordion-body__contents">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
    </div>
      <div class="accordion js-accordion">
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 1</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 2</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
      </div><!-- end of sub accordion -->
    </div><!-- end of accordion body -->
  </div><!-- end of accordion item -->
    <div class="accordion__item js-accordion-item">
    <div class="accordion-header js-accordion-header">Panel 3</div> 
  <div class="accordion-body js-accordion-body">
    <div class="accordion-body__contents">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
    </div>
      <div class="accordion js-accordion">
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 1</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 2</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
      </div><!-- end of sub accordion -->
    </div><!-- end of accordion body -->
  </div><!-- end of accordion item -->
     <div class="accordion__item js-accordion-item">
    <div class="accordion-header js-accordion-header">Panel 4</div> 
  <div class="accordion-body js-accordion-body">
    <div class="accordion-body__contents">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
    </div>
      <div class="accordion js-accordion">
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 1</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 2</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
      </div><!-- end of sub accordion -->
    </div><!-- end of accordion body -->
  </div><!-- end of accordion item -->
     <div class="accordion__item js-accordion-item">
    <div class="accordion-header js-accordion-header">Panel 5</div> 
  <div class="accordion-body js-accordion-body">
    <div class="accordion-body__contents">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
    </div>
      <div class="accordion js-accordion">
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 1</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 2</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
      </div><!-- end of sub accordion -->
    </div><!-- end of accordion body -->
  </div><!-- end of accordion item -->
     <div class="accordion__item js-accordion-item">
    <div class="accordion-header js-accordion-header">Panel 6</div> 
  <div class="accordion-body js-accordion-body">
    <div class="accordion-body__contents">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
    </div>
      <div class="accordion js-accordion">
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 1</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
        <div class="accordion__item js-accordion-item">
           <div class="accordion-header js-accordion-header">Sub Panel 2</div> 
           <div class="accordion-body js-accordion-body">
             <div class="accordion-body__contents">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sequi placeat distinctio dolor, amet magnam voluptatibus eos ex vero, sunt veritatis esse. Nostrum voluptatum et repudiandae vel sed, explicabo in?
             </div><!-- end of sub accordion item body contents -->
           </div><!-- end of sub accordion item body -->
        </div><!-- end of sub accordion item -->
      </div><!-- end of sub accordion -->
    </div><!-- end of accordion body -->
  </div><!-- end of accordion item -->
</div><!-- end of accordion -->
 
	
	
	
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
      
      // ensure only one accordion is active if oneOpen is true
      if(settings.oneOpen && $('.js-accordion-item.active').length > 1) {
        $('.js-accordion-item.active:not(:first)').removeClass('active');
      }
      
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
  accordion.init({ speed: 300, oneOpen: true });
});
	
JS;
 
$this->registerJs($indexJs);
?>