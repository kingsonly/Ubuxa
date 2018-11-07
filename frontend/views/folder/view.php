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
AppAsset::register($this);

$this->title = Yii::t('dashboard', 'dashboard_title');

use boffins_vendor\components\controllers\MenuWidget;

/* @var $this yii\web\View */

$img = $model->folder_image; 
?>
<style>
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
            	<?php Pjax::end(); ?>
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

    
        
</section>

  
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

	$(document).ready(function() {

  var tour = new Tour({

    steps: [
        {
          element: ".taskz-listz",
          title: "Title1",            
          content: "Message 1.",
          debug:true
        },
        {
          element: "#addTask",
          title: "Title2",
          content: "Message 2",
         debug:true
        }

      ],
      backdrop: true,
      storage: false,
      debug: true

  });
 tour.init();
 tour.start();

});	

JS;
 
$this->registerJs($indexJs, $this::POS_READY);
?>
	
<?php
	$steps[0] = [
    'title'=>'Step 1',
    'content'=>'Find all task in this folder here.',
    'element'=>'.taskz-listz'
];


// $steps[1] = ... etc
$steps[1] = [
    'title'=>'Step 2',
    'content'=>'You can create new task here',
    'element'=>'#addTask'
];

$steps[2] = [
    'title'=>'Step 3',
    'content'=>'Do more from the side bar',
    'element'=>'.menu-icon',
    'onShow' => $this->registerJs(
    	"$(function(tour) {
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
    })"
    )
];

$steps[3] = [
    'title'=>'Step 4',
    'content'=>'Side bar',
    'element'=>'.side_menu'
];


\macrowish\widgets\BootstrapTour::widget([
    'steps'=>$steps,
    'options'=>[
        'backdrop'=>'true',
        'storage' => 'false',
        'debug' => 'true'
        ]
]);
?>			

<?= MenuWidget::widget(); ?>
	
		