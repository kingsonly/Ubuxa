<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$boardUrl = Url::to(['task/index']);
?>
<style type="text/css">
    .bg-info {
        background-color: #fff;
        box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
        padding-left: 15px;
        padding-right: 15px;
    }

    .task-header {
        border-bottom: 1px solid #ccc;
        padding-top: 10px;
        padding-bottom: 10px;
        font-weight: bold;
        position: relative;
    }

    .box-content-task {
        height: 250px;
        border-bottom: 1px solid #ccc;
        padding-top: 15px;
    }

    .box-input {
        padding-top: 7px;
        padding-bottom: 7px;
    }

    #boardButton {
        position: absolute;
        right: 0px;
        top: 4px;
    }
</style>
	 <div class="col-md-4">
        <div class="bg-info column-margin">
	        <div class="task-header">
                <span>TASKS</span>
                <!-- <?= Html::button('View Board', ['id' => 'boardButton', 'value' => $boardUrl, 'class' => 'btn btn-success'])?> -->
            </div>
	        <div class="box-content-task">Hello World!</div>
	        <div class="box-input">Input task</div>
        </div>
    </div>

<? 
    Modal::begin([
        'header' =>'<h1 id="headers"></h1>',
        'id' => 'boardModal',
        'size' => 'modal-lg',  
    ]);
?>
<div id="viewboard"></div>
<?
    Modal::end();
?>

<?php 
$task = <<<JS

$(function(){
    $('#boardButton').click(function(){
        $('#boardModal').modal('show')
        .find('#viewboard')
        .load($(this).attr('value'));
        });
    });
JS;
 
$this->registerJs($task);
?>

