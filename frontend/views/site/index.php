<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use boffins_vendor\components\controllers\TaskWidget;
use boffins_vendor\components\controllers\RemarksWidget;
use boffins_vendor\components\controllers\ComponentWidget;
use boffins_vendor\components\controllers\FolderDetails;
use boffins_vendor\components\controllers\SubFolders;
use boffins_vendor\components\controllers\ActivitiesWidget;
use boffins_vendor\components\controllers\OnlineClients;

$this->title = Yii::t('dashboard', 'dashboard_title');


use boffins_vendor\components\controllers\MenuWidget;

/* @var $this yii\web\View */

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
			margin-left: 0px;
		}
		.activedetls{
			padding-left: 0px !important;
			border-bottom: 5px solid green;
		}
		.box-content-active {
			height: 87px !important;
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
   						 	
                    	</div>

            </section>
        </div>

        <div class="row">
        	<?= ComponentWidget::widget() ?>
            <section>
            	<div class="row">
            		<?= TaskWidget::widget() ?>
            		<?= RemarksWidget::widget() ?>
            	</div>
            </section>
        </div>
    </div>
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
