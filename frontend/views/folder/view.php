<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use boffins_vendor\components\controllers\TaskWidget;
use boffins_vendor\components\controllers\KanbanWidget;
use boffins_vendor\components\controllers\RemarksWidget;
use boffins_vendor\components\controllers\ComponentWidget;
use boffins_vendor\components\controllers\FolderDetails;
use boffins_vendor\components\controllers\SubFolders;
use boffins_vendor\components\controllers\ActivitiesWidget;
use boffins_vendor\components\controllers\OnlineClients;
use kartik\popover\PopoverX;
use yii\web\View;
use frontend\assets\AppAsset;


$this->title = Yii::t('dashboard', 'dashboard_title');


use boffins_vendor\components\controllers\MenuWidget;

/* @var $this yii\web\View */

$img = $model->folder_image; 
?>
<style>
.row.content {
	 height: 1500px;
}
 .onboardnav {
	 background-color: #f1f1f1;
	 height: 100%;
}
 footer {
	 background-color: #555;
	 color: white;
	 padding: 15px;
}
 @media screen and (max-width: 767px) {
	 .onboardnav {
		 height: auto;
		 padding: 15px;
	}
	 .row.content {
		 height: auto;
	}
}
 .popover {
	 max-width: 375px;
}
 .popover .fa {
	 color: #D47075;
	 padding-top: 5px;
}
 .popover-content {
	 /* padding: 5px 0; */
}
 .hca-tooltip--left-nav {
	 position: absolute;
	 background-color: #fff;
	 border-radius: 6px;
	 border: 1px solid #efefef;
	 left: 78px;
	 top: 60px;
	 padding: 10px 10px 15px 15px;
	 font-size: 1em;
	 width: 340px;
	 box-shadow: 0 2px 8px rgba(0,0,0,0.4);
	 color: #000;
	 z-index: 1000;
	 text-decoration: none;
}
 .hca-tooltip--left-nav .hca-tooltip--okay-btn {
	 padding: 12px 20px;
	 line-height: 15px;
	 background-color: #408DDD;
	 border: none;
	 color: #fff;
}
 .hca-tooltip--left-nav .hca-border-circle--40 {
	 width: 40px;
	 height: 40px;
	 margin-top: 10px;
	 border-radius: 50%;
	 font-size: .8em;
	 color: #F07C8B;
	 line-height: 38px;
	 text-align: center;
	 background: #fff;
	 border: 1px solid #F07C8B;
}

*{
	text-decoration: none;
}
	#flash {
		display: none;
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
			margin-left: 8%;
			width: 80%;
		}
	}
    .content-header{
        display:none;
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
   						 	<?= FolderDetails::widget(['model' => $model,'folderDetailsImage' => $img ,'imageUrl' => Url::to(['folder/update-folder-image','id' => $model->id])]) ?>
   						 	<?= SubFolders::widget(['folderModel' => $model->subFolders,'folderCarouselWidgetAttributes' =>['class' => 'folder','folderPrivacy'=>$model->private_folder],'createButtonWidgetAttributes' =>['class' => 'folder']]) ?>
                    	</div>
            </section>
        </div>

        <div class="row">
			<?php Pjax::begin(['id'=>'component-pjax']); ?>
			<?

				$components  = ['PAYMENT','PROJECT','INVOICE','ORDER','CORRESPONDECE']
			?>
			
        	<?= ComponentWidget::widget(['users'=>$model->folderUsers,'components' => $components,'otherAttributes' =>['height'=>45],'id'=>$id]) ?>
			<?php Pjax::end(); ?>
            <section>
            	<div class="row test5">
            		<?php Pjax::begin(['id'=>'task-list-refresh']); ?>
            				<?= TaskWidget::widget(['task' => $model->clipOn['task'], 'taskModel' => $taskModel,'parentOwnerId' => $id]) ?>
            		<?php Pjax::end(); ?>

            		<?= RemarksWidget::widget(['remarkModel' => $remarkModel, 'parentOwnerId' => $id,'modelName'=>'folder', 'remarks' => $model->clipOn['remark'] ]) ?>
            	</div>
            </section>
        </div>
    </div>
    
    <? $this->beginBlock('kanban')?>
    	<?php Pjax::begin(['id'=>'kanban-refresh']); ?>
		    <div class="view-task-board">
		    	<?= KanbanWidget::widget(['taskStatus' => $taskStatus, 'dataProvider' => $model->clipOn['task'], 'task' => $task, 'reminder' => $reminder, 'users' => $users, 'taskAssignedUser' => $taskAssignedUser,'label' => $label, 'taskLabel' => $taskLabel, 'id' => $id]) ?>
		    </div>
	    <?php Pjax::end(); ?>
    <? $this->endBlock();?>
    
  <? $this->beginBlock('subfolders')?>
  	<?php 
    	$num = 1;
        foreach ($model->subFolders as $subfolders) {
        $checks = $subfolders->buildTree($subfolders->subFolders, $subfolders->id);
        $folderUrl = Url::to(['folder/view', 'id' => $subfolders->id]);
    ?>
         	<input type="checkbox" class="accord-input" name ="sub-group-<?=$num; ?>" id="sub-group-<?=$num; ?>">
            <label class="accord-label" for="sub-group-<?=$num; ?>" id="menu-folders<?=$subfolders->id.'-'.$num ?>"><i class="fa fa-folder iconz"></i><?= $subfolders->title ?><i class="fa fa-chevron-down iconz-down"></i></label>
            <?php
            	$num2 = 2;
            	foreach ($checks as $innerFolders) { ?>
            		<ul class="first-list" id="menu-folders<?=$subfolders->id.'-'.$num2 ?>">
		                <li class="second-list" id="menu-folders<?=$subfolders->id.'-'.$num2 ?>"><a href="#0" class="list-link<?=$subfolders->id.'-'.$num2 ?>"><i class="fa fa-folder iconzz"></i><?= $innerFolders->title; ?></a></li>
              		</ul>
      
           <?php } ?>
        <?php $num2++;$num++; }?>
  <? $this->endBlock();?>
  </section>

<? 
    Modal::begin([
        'header' =>'<h1 id="headers"></h1>',
        'id' => 'boardContent',
        'size' => 'modal-md',
        //'backdrop' => false,  
    ]);
?>
<div id="viewcontent"></div>
<?
    Modal::end();
?>
<?php 
$indexJs = <<<JS

$(function(){
    $('.task-test').click(function(){
        $('#boardContent').modal('show')
        .find('#viewcontent')
        .load($(this).attr('value'));
        });
  });
  $(function() {

  var tour = new Tour({
    steps: [
        {
          element: ".taskz-listz",
          title: "Title1",            
          content: "Message 1"
        },
        {
          element: "#addTask",
          title: "Title2",
          content: "Message 2",
        },
        {
          element: ".side_menu",
          title: "Title3",
          content: "Message 3",
          onShow: function(tour) {
          	$('.side_menu').removeClass('side-drop');
    		$('.list_load, .list_item').stop();
			$(this).removeClass('closed').addClass('opened');

			$('.side_menu').css({ 'left':'0px' });

			var count = $('.list_item').length;
			$('.list_load').slideDown( (count*.6)*100 );
			$('.list_item').each(function(i){
				var thisLI = $(this);
				timeOut = 100*i;
				setTimeout(function(){
					thisLI.css({
						'opacity':'1',
						'margin-left':'0'
					});
				},100*i);
			});
		    }
        },
        {
          element: ".open-board",
          title: "Title4",
          content: "Message 4",
          onShow: function(tour){
          	$('.side_menu').addClass('side-drop');
          	},
          onShown: function(tour){
          	$(".tour-backdrop").appendTo("#content");
		    $(".tour-step-background").appendTo("#content");
		    $(".tour-step-background").css("left", "0px");
          	},
        },
        {
          element: ".drag-container",
          title: "Task board",
          content: "This is your task board.",
          placement: "bottom",
          onShow: function(tour){
          	$('#mySidenav').css({'width':'100%'});
          	},
          onShown: function(tour){
          	$(".tour-backdrop").appendTo(".view-task-board");
		    $(".tour-step-background").appendTo(".view-task-board");
		    $(".tour-step-background").css("left", "0px");
          	},
        },
        {
          element: ".drag-item:first",
          title: "Title 6",
          content: "Message 6",
          onShown: function(tour){
          	$(".tour-backdrop").appendTo(".drag-container");
		    $(".tour-step-background").appendTo(".drag-container");
		    $(".tour-step-background").css("left", "0px");
          	},
        },
        {
          element: ".add-card:first",
          title: "Title 7",
          content: "Message 7",
          onShown: function(tour){
          	$(".tour-backdrop").appendTo(".drag-column:first");
		    $(".tour-step-background").appendTo(".drag-container");
		    $(".tour-step-background").css("left", "0px");
          	},
        },
        
      ],
    backdrop: true,  
    storage: true,
    smartPlacement: true,    
    onEnd: function (tour) {
    	$('.side_menu').addClass('side-drop');
        $('#mySidenav').css({'width':'0'})
  		$('.list_load, .list_item').stop();
	$(this).removeClass('opened').addClass('closed');

	$('.side_menu').css({ 'left':'-300px' });

	var count = $('.list_item').length;
	$('.list_item').css({
		'opacity':'0',
		'margin-left':'-20px'
	});
	$('.list_load').slideUp(300);
  		},
  });
 tour.init();
 tour.start(true);

});

JS;
 
$this->registerJs($indexJs);
?>