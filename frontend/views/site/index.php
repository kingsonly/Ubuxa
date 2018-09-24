<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\bootstrap\Alert;

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

	.bg-info {
    	background-color: #fff;
    	box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
    	padding-left: 15px;
		padding-right: 15px;
	}

	.header {
    	border-bottom: 1px solid #ccc;
    	padding-top: 7px;
    	padding-bottom: 7px;
    	font-weight: bold
	}

	.box-content {
		height: 300px;
	}

	.box-content-task {
		height: 250px;
		border-bottom: 1px solid #ccc;
	}

	.box-input {
		padding-top: 7px;
    	padding-bottom: 7px;
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
    .content-header{
        display:none;
    }
</style>




<section>
    <div class="container-fluid">
        <div class="row">
            <section style="border:1px solid #000; min-height:400px">
                <section id="dashboard-content">
                    <div class="grid-item folder">
                        <?=$this->render('/folder/latest', ['folders' =>$folders]);?>
                    </div>
                </section>
    
                <div class="container">
                    <div class="row"></div>
                    <div class="row"></div>
                </div>

            </section>
        </div>
        <div class="row">
            <section style="border:1px solid #000; min-height:400px">

                	<div class="row">
					   <div class="col-md-5">
            				<div class="bg-info">
	            				<div class="header">TASKS</div>
	            				<div class="box-content-task">Hello World!</div>
	            				<div class="box-input">
	            					Input task
	            				</div>
            				</div>
            				
        				</div>
        				<div class="col-md-7">
            				<div class="bg-info">
            					<div class="header">REMARKS</div>
	            				<div class="box-content">Hello World!</div>
            				</div>
        				</div>
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
