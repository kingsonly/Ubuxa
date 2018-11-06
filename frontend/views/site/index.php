<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use frontend\assets\AppAsset;
use boffins_vendor\components\controllers\TaskWidget;
use boffins_vendor\components\controllers\KanbanWidget;
use boffins_vendor\components\controllers\RemarksWidget;
use boffins_vendor\components\controllers\ComponentWidget;
use boffins_vendor\components\controllers\FolderDetails;
use boffins_vendor\components\controllers\SubFolders;
use boffins_vendor\components\controllers\ActivitiesWidget;
use boffins_vendor\components\controllers\OnlineClients;
use boffins_vendor\components\controllers\FolderCreateWidget;

AppAsset::register($this);
$this->title = Yii::t('dashboard', 'dashboard_title');


use boffins_vendor\components\controllers\MenuWidget;

/* @var $this yii\web\View */

?>
<style>
	#flash {
		display: none !important;
	}

	#dashboard-content {
		display: grid;
		grid-gap: 50px 10px;
		grid-template-columns: 40% 20% 40%;
		grid-template-areas: 	'folders folders folders'
								'flash flash flash'
								'remarks tasks tasks';
	}
	
	.grid-item {
		
	}
	
	.grid-item.folder {
		grid-area: folders;
	}
	
	.grid-item.flash {
		grid-area: flash;
	}
	
	.grid-item.remark-box {
		grid-area: remarks;
	}
	
	.grid-item.task-box {
		grid-area: tasks;
	}

	.folderdiv{
		height: 50px;
	}

	.top-box {
		padding-bottom: 50px;
	}
	
	@media screen and (min-width: 280px) and (max-width: 599px) {
			#dashboard-content {
				grid-gap: 0px 20px;
				grid-template-columns: 100%;
				grid-template-areas: 	'folders'
										'flash'
										'tasks'
										'remarks';
			}
	}

	@media (max-width:991px) {
 	 	.column-margin { 
 	 		margin: 20px 0; 
 	 	}
 	 	.act-margin {
 	 		margin: 5px 0;
 	 	}
 	 	.info-1 {
			margin-left: 0px;
		}
		.activedetls{
			padding-left: 0px !important;
			border-bottom: 5px solid green;
		}
		.box-content-active {
			height: 87px !important;
			-webkit-box-shadow: none !important;
	        -moz-box-shadow: none !important;
	        box-shadow: none !important;
		}
	}
    .content-header{
        display:none;
    }
.view-task-board{
	display: none;
	background-color: #fff;
	box-shadow: 5px 8px 25px -2px rgba(0,0,0,0.1);
	padding-bottom: 50px;
	padding-top: 10px;
	overflow: scroll;
	position: relative;
}
.owl-nav{
	display:none;
}
.owl-stage-outer{
	margin-top:10px;
}
.folder-items{
	cursor: pointer;
}
.folder-logo{
	width: 40px;
    margin-left: 24px;
    position: fixed;
    z-index: 100;
    top: 0;
    margin-top: 30px;
    border-radius: 50%;
    border: 1px solid #c5c7cc;
    height: 40px;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 1.3em;
    color:#c5c7cc;
    padding: 7px
}
.folder-logos{
	width: 40px;
    margin-left: 24px;
    position: fixed;
    z-index: 100;
    top: 0;
    margin-top: 30px;
    border-radius: 50%;
    border: 1px solid #c5c7cc;
    height: 40px;
    
}

.flip-box {
  perspective: 3000px;
}

.flip-box-inner {
  width: 100%;
  height: 100%;
  position: relative;
  transition: transform 0.8s;
  transform-style: preserve-3d;
}

.flip-boxx .flip-box-innerr{
  transform: rotateX(180deg);
}





.flip-box-front, .flip-box-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
}

.flip-box-front {
  background-color: #555;
  color: black;
}
.flip-box-back {
  color: white;
  transform: rotateX(180deg);
  margin-top:-23px;
}
.close-create{
	cursor: pointer;
	position: absolute;
    top: -25px;
    z-index: 100;
    right: 4px;
    font-size: 1.5em;
}

#createfolder{
	cursor: pointer;
}
</style>




<section>
	
    <div class="container-fluid">
        <div class="row">
            <section>
                  <div class="row top-box">
                  	<?= ActivitiesWidget::widget() ?>
                  	<?= OnlineClients::widget() ?>
                  </div>  
                    	<div class="row">
   						 	
                    	</div>

            </section>
        </div>
        <div class="row">

            <section>

            	<div class="row" style="margin-bottom: 32px;">
            		 <div class="row">
            		 <div class="col-md-12">
			        	<div class="col-md-1" id="createfolder" data-toggle="tooltip-folder" data-placement="bottom" title="create new folder" style="height:100px;background-image: url('<?= Url::to("@web/images/folder/newfolder.png"); ?>'); background-repeat: no-repeat;background-size: cover"></div>
			        	<div class="col-md-11 flip-box">
			        		<div class=" flip-box-inner">
				        		<div class="owl-carousel owl-theme flip-box-front row">
				        			<?php foreach($folders as $folder){
				        				$folder_name_logo = Url::to("@web/images/folder_images/". $folder['folder_image']);
				        				$folderUrl = Url::to(['folder/view', 'id' => $folder['id']]);
				        			?>
						        	<div class = 'item folder-items' data-toggle="tooltip-folder" data-placement="bottom" title="<?= $folder['title']; ?>">
						        		<a href="<?= $folderUrl; ?>">
							        		<img src="<?= Url::to('@web/images/folder/folderempty.png'); ?>" alt="">
							        		<?php (!empty($folder['folder_image'])) ? $image = '<div class="folder-logos" style=" background-repeat: no-repeat;background-size: cover; background-image: url('.$folder_name_logo.')"> </div>' :
							        			$image = '<div class="folder-logo">'.substr($folder['title'], 0, 2).'</div>'
							        		?>
							        		<?php echo $image; ?>
						        		</a>
						        	</div>

						        	<?php };?>

					        	</div>
					        	<div class="flip-box-back">
							      <div class="close-create"><i class="fa fa-close"></i></div>
							      <?= FolderCreateWidget::widget();?>
								</div>

				        	</div>
				        	
			        	</div>
			        </div>
			        </div>
            	</div>
            </section>
        </div>

        

        <div class="row widget-bottom">

            <section>
            	<div class="row test5">
            			<?= TaskWidget::widget(['task' => $task->dashboardTask, 'taskModel' => $task]) ?>
            		<?//= RemarksWidget::widget(['remarkModel' => $remarkModel]) ?>

            	</div>
            </section>
        </div>

        <span class="folder"></span>
    </div>
    <?php Pjax::begin(['id'=>'kanban-refresh']); ?>
    <div class="view-task-board">

    	<?= KanbanWidget::widget(['taskStatus' => $taskStatus, 'dataProvider' => $task->displayTask(), 'task' => $task, 'reminder' => $reminder, 'users' => $users, 'taskAssignedUser' => $taskAssignedUser, 'label' => $label, 'taskLabel' => $taskLabel]) ?>
    </div>
    <?php Pjax::end(); ?>
</section>


  <? $this->beginBlock('sidebar')?>
  	<div id="two">
    	<ul class="list_load">
    		<li class="list_item"><a href="#">List Item 01</a></li>
			<li class="list_item"><a href="#">List Item 02</a></li>
			<li class="list_item"><a href="#">List Item 03</a></li>
    	</ul>
    </div>
    <div id="three">
    	<ul class="list_load">
			<li class="list_item"><a href="#">List Item 01</a></li>
			<li class="list_item"><a href="#">List Item 02</a></li>
			<li class="list_item"><a href="#">List Item 03</a></li>
			<li class="list_item"><a href="#">List Item 04</a></li>
		</ul>
    </div>
  <? $this->endBlock();?>

<?php 
$indexJs = <<<JS


$('.owl-carousel').owlCarousel({
	  items:10,
      loop:false,
      margin:5,
      nav:true,
      
  	});

$('[data-toggle="tooltip-folder"]').tooltip({container: 'body'});

$('#createfolder').click(function(e){
	e.preventDefault();
	$('.flip-box-inner').addClass('flip-box-innerr')
	$('.flip-box').addClass('flip-boxx')

})
$('.close-create').click(function(e){
	e.preventDefault();
	$('.flip-box-inner').removeClass('flip-box-innerr')
	$('.flip-box').removeClass('flip-boxx')

})

$(function(){
    $("#boardButton").on('click', function(e){
        $(".test5").slideUp('slow');
        $('.view-task-board').show();
  });
  $('.task-icon').on('click',function(e){
  		e.preventDefault();
	    //$(".view-task-board").hi('slow');
	    $(".view-task-board").hide();
	    $('.test5').slideDown('slow');
   });
});
$('#refresh').click(function(){ $.pjax.reload({container:"#content",async: false
}); })

	$('.test3').each(function(){
	$(this).click(function(){
		$('#task'+$(this).data('number')).slideToggle();

		if($(this).hasClass('fa-caret-down')){
				$(this).removeClass('fa-caret-down').addClass('fa-caret-up');
			} else {
				$(this).removeClass('fa-caret-up').addClass('fa-caret-down');
			}
		})
	})
    $('.test1').each(function(){
	$(this).click(function(){
		$('#task2'+$(this).data('number')).slideToggle();

		if($(this).hasClass('fa-caret-down')){
				$(this).removeClass('fa-caret-down').addClass('fa-caret-up');
			} else {
				$(this).removeClass('fa-caret-up').addClass('fa-caret-down');
			}
		})
	})
    
    $('.test').each(function(){
	$(this).click(function(){
		$('#task'+$(this).data('number')).slideToggle();

		if($(this).hasClass('fa-caret-down')){
				$(this).removeClass('fa-caret-down').addClass('fa-caret-up');
			} else {
				$(this).removeClass('fa-caret-up').addClass('fa-caret-down');
			}
		})
	})

	

	$('.client').on('click', function() {
					$(document).find('#sliderwizz1').show();
					$(document).find('#sliderwizz').hide();
					$(document).find('#sliderwizz2').hide();
					$(document).find('#sliderwizz3').hide();
	})
	
	$('.supplier').on('click', function() {
					$(document).find('#sliderwizz2').show();
					$(document).find('#sliderwizz1').hide();
					$(document).find('#sliderwizz3').hide();
					$(document).find('#sliderwizz').hide();
	})
	
	$('.contact').on('click', function() {
					$(document).find('#sliderwizz3').show();
					$(document).find('#sliderwizz2').hide();
					$(document).find('#sliderwizz1').hide();
					$(document).find('#sliderwizz').hide();
	})
	
	$('#activeuser').on('click', function() {
					$(document).find('#sliderwizz').show();
					$(document).find('#sliderwizz3').hide();
					$(document).find('#sliderwizz2').hide();
					$(document).find('#sliderwizz1').hide();
	})

JS;
 
$this->registerJs($indexJs);
?>


<?= MenuWidget::widget(); ?>
