<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use boffins_vendor\components\controllers\TaskViewWidget;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;


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
        height: 230px;
        border-bottom: 1px solid #ccc;
        padding-top: 8px;
        overflow: auto;
    }

    .box-input1 {
        padding-top: 5px;
        height: 50px;
    }

    #boardButton {
        position: absolute;
        right: 0px;
        top: 4px;
    }
     .todo-list {
   background: #FFF;
   font-size: 13px;
}
 .todo {
   display: block;
   position: relative;
   padding: 1em 1em 1em 16%;
   margin: 0 auto;
   cursor: pointer;
   border-bottom: solid 1px #ddd;
}
 .todo:last-child {
   border-bottom: none;
}
 .todo__state {
   position: absolute;
   top: 0;
   left: 0;
   opacity: 0;
}
 .todo__text {
   color: #135156;
   transition: all 0.4s linear 0.4s;
}
 .todo__icon {
   position: absolute;
   top: 0;
   bottom: 0;
   left: 0;
   width: 100%;
   height: auto;
   margin: auto;
   fill: none;
   stroke: #27FDC7;
   stroke-width: 1;
   stroke-linejoin: round;
   stroke-linecap: round;
}
 .todo__line, .todo__box, .todo__check {
   transition: stroke-dashoffset 0.8s cubic-bezier(.9,.0,.5,1);
}
 .todo__circle {
   stroke: #27FDC7;
   stroke-dasharray: 1 6;
   stroke-width: 0;
   transform-origin: 13.5px 12.5px;
   transform: scale(0.4) rotate(0deg);
   animation: none 0.8s linear;
}
 .todo__circle 30% {
     stroke-width: 3;
     stroke-opacity: 1;
     transform: scale(0.8) rotate(40deg);
  }
   
   .todo__circle 100% {
     stroke-width: 0;
     stroke-opacity: 0;
     transform: scale(1.1) rotate(60deg);
  } 
  .todo__box {
   stroke-dasharray: 56.1053, 56.1053;
   stroke-dashoffset: 0;
   transition-delay: 0.16s;
}
 .todo__check {
   stroke: #27FDC7;
   stroke-dasharray: 9.8995, 9.8995;
   stroke-dashoffset: 9.8995;
   transition-duration: 0.32s;
}
 .todo__line {
   stroke-dasharray: 168, 1684;
   stroke-dashoffset: 168;
}
 .todo__circle {
   animation-delay: 0.56s;
   animation-duration: 0.56s;
}
 .todo__state:checked ~ .todo__text {
   transition-delay: 0s;
   color: #ccc;;
   opacity: 0.6;
}
 .todo__state:checked ~ .todo__icon .todo__box {
   stroke-dashoffset: 56.1053;
   transition-delay: 0s;
}
 .todo__state:checked ~ .todo__icon .todo__line {
   stroke-dashoffset: -8;
}
 .todo__state:checked ~ .todo__icon .todo__check {
   stroke-dashoffset: 0;
   transition-delay: 0.48s;
}
 .todo__state:checked ~ .todo__icon .todo__circle {
   animation-name: explode;
}

.assignee {
    float: right;
}

 .embed-submit-field {
   position: relative;
}
 #addTask {
   width: 100%;
   padding: 9px;
}
 #taskButton {
    position: absolute;
    right: 3px;
    top: 3px;
    -webkit-appearance: none;
    -moz-appearance: none;
    border: none;
    background: #ededed;
    border-radius: 3px;
    padding: 6px;
    width: 60px;
    transition: all 0.2s;
}
 .embed-submit-field #taskButton:hover {
   background-color: #37c88d;
   color: #fff;
   cursor: pointer;
}
.form-containers {
   margin: 0 auto;
}
#addTask {
    border:none;
}
#taskButton {
    display: none;
}

</style>
  
	 <div class="col-md-4">
        <div class="bg-info column-margin">
	        <div class="task-header">
                <span>TASKS</span>
                 <?= Html::button('View Board', ['id' => 'boardButton', 'value' => $boardUrl, 'class' => 'btn btn-success'])?> 
            </div>
            <?php Pjax::begin(['id'=>'task-list-refresh']); ?>
	        <div class="box-content-task">
             <svg viewBox="0 0 0 0" style="position: absolute; z-index: -1; opacity: 0;">
  <defs>
    <linearGradient id="boxGradient" gradientUnits="userSpaceOnUse" x1="0" y1="0" x2="25" y2="25">
      <stop offset="0%"   stop-color="#27FDC7"/>
      <stop offset="100%" stop-color="#0FC0F5"/>
    </linearGradient>

    <linearGradient id="lineGradient">
      <stop offset="0%"    stop-color="#ccc"/>
      <stop offset="100%"  stop-color="#ccc"/>
    </linearGradient>

    <path id="todo__line" stroke="url(#lineGradient)" d="M21 12.3h168v0.1z"></path>
    <path id="todo__box" stroke="url(#boxGradient)" d="M21 12.7v5c0 1.3-1 2.3-2.3 2.3H8.3C7 20 6 19 6 17.7V7.3C6 6 7 5 8.3 5h10.4C20 5 21 6 21 7.3v5.4"></path>
    <path id="todo__check" stroke="url(#boxGradient)" d="M10 13l2 2 5-5"></path>
    <circle id="todo__circle" cx="13.5" cy="12.5" r="10"></circle>
  </defs>
</svg>


<div class="todo-list">
  <?php 
    $id = 1;
    foreach ($display as $key => $value) { ?>
  <label class="todo">
    <?php if($value->status_id == 24){ ?>
        <input class="todo__state" data-id="<?= $value->id; ?>" id="todo-list<?= $value->status_id; ?>" type="checkbox" checked/>
    <?php }else { ?>
        <input class="todo__state" data-id="<?= $value->id; ?>" id="todo-list<?= $value->status_id; ?>" type="checkbox"/>
    <?php } ?>
    
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon">
      <use xlink:href="#todo__line" class="todo__line"></use>
      <use xlink:href="#todo__box" class="todo__box"></use>
      <use xlink:href="#todo__check" class="todo__check"></use>
      <use xlink:href="#todo__circle" class="todo__circle"></use>
    </svg>

    <div class="todo__text">
        <span><?= $value->title; ?></span>
        
    </div>
    
  </label>

  <?php $id++; }?>
</div>   
</div>
<?php Pjax::end(); ?>
	   <div class="box-input1">
            <div class="form-containers">
                 <div class="embed-submit-field">
                  <?php Pjax::begin(['id'=>'task-refresh']); ?>
                    <?php $form = ActiveForm::begin(['id' => 'create-task','options' => ['data-pjax' => true ]]); ?>
                    <?= $form->field($taskModel, 'title')->textInput(['maxlength' => true, 'id' => 'addTask', 'placeholder' => "Write some task here"])->label(false) ?>
                   <!-- <input type="text" placeholder="Write some task here" id="addTask"/> -->
                    <?= Html::submitButton('Save', ['id' => 'taskButton']) ?>
                    <!-- <button type="submit" id="taskButton">Save</button> -->
                    <?php ActiveForm::end(); ?>
                  <?php Pjax::end(); ?>
                </div> 
            </div>  
        </div>
    </div>
</div>





<?php 
$taskUrl = Url::to(['site/task']);
$createUrl = Url::to(['task/dashboardcreate']);
$task = <<<JS

$(function(){
    $('#boardButton').click(function(){
        $('#boardModal').modal('show')
        .find('#viewboard')
        .load($(this).attr('value'));
        });
    });


$(".todo__state").change(function() {
    var checkedId;
    checkedId = $(this).data('id');
    _UpdateStatus(checkedId);        
});

//$(".todo__icon").click(false);

function _UpdateStatus(checkedId){
          $.ajax({
              url: '$taskUrl',
              type: 'POST', 
              data: {
                  id: checkedId,
                },
              success: function(res, sec){
                $.pjax.reload({container:"#asign-refresh",async: false});
                   console.log('Status updated');
              },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
          });
}

$('#create-task').on('beforeSubmit', function(e) { 
           var form = $(this);
           e.preventDefault();
            if(form.find('.has-error').length) {
                return false;
            }
            $.ajax({
                url: '$createUrl',
                type: 'POST',
                data: form.serialize(),
                success: function(response) { 
                    console.log('completed');
                    $.pjax.reload({container:"#task-list-refresh",async: false});
                    $.pjax.reload({container:"#kanban-refresh",async: false});
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });    
});

$("#addTask").bind("keyup change", function() {
    var value = $(this).val();
    if (value && value.length > 0) {
        $("#taskButton").show();
    } else {
        $("#taskButton").hide();
    }
});
JS;
 
$this->registerJs($task);
?>

