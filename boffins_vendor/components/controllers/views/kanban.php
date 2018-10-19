<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use frontend\assets\AppAsset;
use boffins_vendor\components\controllers\CreateReminderWidget;
use boffins_vendor\components\controllers\AssigneeViewWidget;
use boffins_vendor\components\controllers\CreateLabelWidget;
use yii\base\view;
use yii\bootstrap\Modal;
use kartik\popover\PopoverX;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

AppAsset::register($this);


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */



?>

<?= Html::csrfMetaTags() ?>
<style>
    ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
.drag-container {
  max-width: 1000px;
  margin: 20px auto;
}
.drag-list {
  display: flex;
  align-items: flex-start;
  overflow: scroll;
  width: 1000px;
}

.fa {
    color: black !important;
}
.drag-column {
  flex: 1;
  margin: 0 10px;
  position: relative;
  background: rgba(193, 198, 212, 0.2);
  /* overflow: hidden; */
  border-radius: 4px;
}
@media (max-width: 690px) {
  .drag-column {
    margin-bottom: 30px;
  }
}
.drag-column h2 {
  font-size: 1.2rem;
  margin: 0;
  text-transform: uppercase;
  font-weight: 600;
}
.drag-column-on-hold .drag-column-header, .drag-column-on-hold .is-moved, .drag-column-on-hold .drag-options {
  background: #98afc5;
}
.drag-column-in-progress .drag-column-header, .drag-column-in-progress .is-moved, .drag-column-in-progress .drag-options {
  background: #2a92bf;
}
.drag-column-needs-review .drag-column-header, .drag-column-needs-review .is-moved, .drag-column-needs-review .drag-options {
  background: #f4ce46;
}
.drag-column-approved .drag-column-header, .drag-column-approved .is-moved, .drag-column-approved .drag-options {
  background: #00b961;
}
.drag-column-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
}
.drag-inner-list {
  min-height: 50px;
}
.drag-item {
  margin: 10px;
  min-height: 100px;
  background: #FAFAFA;
  transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
  cursor: -webkit-grab;
  cursor: grab;
  border-radius: 2px;
  box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
  position: relative;
}
.drag-item.is-moving {
  transform: scale(1.5);
  background: rgba(0, 0, 0, 0.8);
  cursor: -webkit-grabbing; 
  cursor: grabbing;
}
.drag-header-more {
  cursor: pointer;

}
.drag-options {
  position: absolute;
  top: 44px;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 10px;
  transform: translateX(100%);
  opacity: 0;
  transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}
.drag-options.active {
  transform: translateX(0);
  opacity: 1;
  z-index: 99;
}
.drag-options-label {
  display: block;
  margin: 0 0 5px 0;
}
.drag-options-label input {
  opacity: 0.6;
}
.drag-options-label span {
  display: inline-block;
  font-size: 0.9rem;
  font-weight: 400;
  margin-left: 5px;
}
/* Dragula CSS  */
.gu-mirror {
  position: fixed !important;
  margin: 0 !important;
  z-index: 9999 !important;
  opacity: 0.8;
  list-style-type: none;
}
.gu-hide {
  display: none !important;
}
.gu-unselectable {
  -webkit-user-select: none !important;
  -moz-user-select: none !important;
  -ms-user-select: none !important;
  user-select: none !important;
}
.gu-transit {
  opacity: 0.2;
}
/* Demo info */
.task-head {
  text-align: center;
}
.task-icon {
  position: absolute;
  top: 10px;
    left: 10px;
    font-size: 30px;
    cursor: pointer;
}
.bottom-content {
    display: none;
    position: absolute;
    bottom: 0;
    width: 100%;
}


.modal-content {
    border-radius: 6px !important; 
}

/* NEW DIV */
.wrapit {
  position: absolute;
  overflow: hidden;
  top: 10%;
  right: 10%;
  bottom: 85px;
  left: 10%;
  padding: 20px 50px;
  display: block;
  border-radius: 4px;
  transform: translateY(20px);
  transition: all 0.5s;
  visibility: hidden;
}
.wrapit .content {
  opacity: 0;
}
.wrapit:before {
  position: absolute;
  width: 1px;
  height: 1px;
  background: white;
  content: "";
  bottom: 10px;
  left: 50%;
  top: 95%;
  color: #fff;
  border-radius: 50%;
  -webkit-transition: all 600ms cubic-bezier(0.215, 0.61, 0.355, 1);
  transition: all 600ms cubic-bezier(0.215, 0.61, 0.355, 1);
}
.wrapit.active {
  display: block;
  visibility: visible;
  box-shadow: 2px 3px 16px silver;
  transition: all 600ms;
  transform: translateY(0px);
  transition: all 0.5s;
}
.wrapit.active:before {
  height: 2000px;
  width: 2000px;
  border-radius: 50%;
  top: 50%;
  left: 50%;
  margin-left: -1000px;
  margin-top: -1000px;
  display: block;
  -webkit-transition: all 600ms cubic-bezier(0.215, 0.61, 0.355, 1);
  transition: all 600ms cubic-bezier(0.215, 0.61, 0.355, 1);
}
.wrapit.active .content {
  position: relative;
  z-index: 1;
  opacity: 1;
  transition: all 600ms cubic-bezier(0.55, 0.055, 0.675, 0.19);
}

a.addTaskButton {
  padding: 11px 11px 13px 13px;
  outline: none;
  border-radius: 50%;
  background: #007fed;
  color: #fff;
  font-size: 24px;
  display: block;
  position: absolute;
  right: 10px;
  top: 60px;
  margin-left: -25px;
  transition: transform 0.25s;
}
a.addTaskButton:hover {
  text-decoration: none;
  background: #2198ff;
}
a.addTaskButton.active {
  transform: rotate(135deg);
  transition: transform 0.5s;
}
.holdbtn {
  position: relative;
}

.dropdown-menu {
  padding-left: 20px;
    border-right-width: 1px;
    padding-right: 20px;
    width: 272px;
    cursor: pointer;
}
.dropdown {
  cursor: pointer;
}
.dropup{
  cursor: pointer;
}
.task-test {
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 2px;
    cursor: pointer;
    padding-bottom: 20px;
}
.taskpop {
  position: absolute;
  right: 10px;
  top: 15px;
}
.confirm {
  display: flex;
    justify-content: center;
}
.label-task {
    background: #3B5998;
    padding-left: 10px;
    padding-right: 10px;
    color: #fff;
    border-radius: 3px;
    padding-top: 1px;
    padding-bottom: 1px;
}
.assigndrop{
  width:340px;
}
.date-time {
      color: rgba(0,0,0,.87);
    cursor: pointer;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 12px;
    color: #6b808c;
}
.time-icon {
  font-size: 12px;
  color: #6b808c;
}
.reminder-time{
  float: right;
  padding-right: 8px;
}
.drop-icon{
    padding-right: 50px;
    cursor: pointer;
}
.task-label-title {
  margin-bottom: 4px;
}

</style>
<div class="task-index">

    <!-- <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

</div>

<section class="task-head">
    <h1>Task Board</h1>
</section>
<div class="task-icon">
  <i class="glyphicon glyphicon-remove"></i>
</div>

<?php Pjax::begin(['id'=>'asign-refresh']); ?>
<div class="drag-container">
    <ul class="drag-list">
        <?php
        $id = 1; 
        foreach($taskStatus as $key => $value){ ?>
        <li class="drag-column drag-column-on-hold" data-statusid="<?= $value->id; ?>">
            <span class="drag-column-header">
                <?= $value->status_title;?>
                <svg class="drag-header-more" data-target="options<?= $id; ?>" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg>
            </span>
                
            <div class="drag-options" id="options<?=$id;?>"></div>
            
            <ul class="drag-inner-list" id="<?=$id;?>" data-contain="<?= $value->id; ?>">
                <?php 
                    $id2 = 1;
                    foreach ($dataProvider as $key => $values) {

                        if($values->status_id == $value->id){
                        $boardUrl = Url::to(['task/view', 'id' => $values->id]);
                        $reminderUrl = Url::to(['reminder/create']);
                        $listData=ArrayHelper::map($users,'id','username');
                 ?>
                <li data-filename="<?= $values->id;?>" id="test_<?= $values->id; ?>" class="drag-item test_<?= $values->id;?>">
                  <div class="task-test test3_<?= $values->id;?>" value ="<?= $boardUrl; ?>">
                      <div class="task-title">
                        <?= $values->title; ?>
                      </div>
                      
                      <div class="assignedto" data-toggle="tooltip" title="<?= $values->personName; ?>">
                        <?= $values->personName; ?>
                      </div>
                      <?php if(!empty($values->label)){ ?>
                      <div class="task-label-title">
                        <span class="label-task">
                        <?= $values->label; ?>
                      </span>
                      </div>
                    <?php } ?>
                    <?php 
                      $time = $values->reminderTime;
                      $check = date("Y-m-d H:i:s");
                    if(!empty($time) && $time >= $check){ ?>
                    <div class="reminder-time">
                        <i class="fa fa-bell time-icon"></i>
                        <span class="date-time" ria-hidden="true" data-toggle="tooltip" title="Reminder">
                          <?php
                            $date = $values->reminderTime;
                            $date = date('M j, g:i a', strtotime($date));
                            echo $date;
                          ?>
                        </span>
                      </div>
                      <?php } ?>
                      <div class="due-date">
                        <span class="glyphicon glyphicon-time time-icon"></span>
                          <?php
                            $date = $values->due_date;
                            $date = date('M j, g:i a', strtotime($date));
                            $boardDate = date('M j', strtotime($date))
                          ?>
                          <span class="date-time" aria-hidden="true" data-toggle="tooltip" title="Due: <?=$date; ?>">
                            <?= $boardDate; ?>
                          </span>
                      </div>
                </div>
                    <div class="bottom-content">
                      <div class="confirm">
                      <div class="dropdown testdrop">
                        <a class=" dropdown-toggle drop-icon" type="button" id="dropdownMenuButton_<?= $values->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell icons" aria-hidden="true" data-toggle="tooltip" title="Add reminder"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <?= CreateReminderWidget::widget(['reminder' => $reminder,'id'=> $values->id,'reminderUrl'=> $reminderUrl]) ?>
                        </div>
                      </div>
                      <div class="dropdown testdrop">
                        <a class=" dropdown-toggle drop-icon" type="button" id="dropdownMenuButton_<?= $values->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-plus icons" aria-hidden="true" data-toggle="tooltip" title="Assign task"></i></a>
                        <div class="dropdown-menu assigndrop" aria-labelledby="dropdownMenuButton">
                            <?= AssigneeViewWidget::widget(['users' => $users, 'taskid' => $values->id]) ?>  
                        </div>
                      </div>
                      <div class="dropdown testdrop">
                        <a class=" dropdown-toggle drop-icon" type="button" id="dropdownMenuButton_<?= $values->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tags icons" aria-hidden="true" data-toggle="tooltip" title="Add label"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                         <?= CreateLabelWidget::widget(['id' => $id,'task' => $task, 'taskid' => $values->id]) ?>
                        </div>
                      </div>
                        <a href='#'><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </li>
            <?php $id2++;}}?>
            </ul>
        </li>
        <?php $id++; }?>
    </ul> 
</div>
<?php Pjax::end(); ?>

<!-- <div class='wrapit'>
  <div class='content'>
    <div id="load-data"></div>
  </div>
</div>
  <a class='button glyphicon glyphicon-plus addTaskButton' href='#'></a>
-->
<?php 
PopoverX::begin([
    'header' => 'Add Task',
    'size' => PopoverX::SIZE_MEDIUM,
    'placement' => PopoverX::ALIGN_LEFT,
    'toggleButton' => ['label'=>'Add Task', 'class'=>'btn btn-primary taskpop'],
]);

 $form = ActiveForm::begin(['action'=>Url::to(['task/create'])]); ?>
                    <?= $form->field($task, 'title')->textInput(['maxlength' => true, 'id' => 'task-popover', 'placeholder' => "Write some task here"])->label(false) ?>
                  <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'taskButton2']) ?>
                  <?php ActiveForm::end();

PopoverX::end();

?>


<? 
    Modal::begin([
        'header' =>'<h1 id="headers"></h1>',
        'id' => 'boardContent',
        'size' => 'modal-md',  
    ]);
?>
<div id="viewcontent"></div>
<?
    Modal::end();
?>



<?php 
$saveUrl = Url::to(['task/kanban']);
$formUrl = Url::to(['task/create']);
$board = <<<JS

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});


$.fn.closest_descendent = function(filter) {
    var found = $(),
        currentSet = this; // Current place
    while (currentSet.length) {
        found = currentSet.filter(filter);
        if (found.length) break;  // At least one match: break loop
        // Get all children of the current set
        currentSet = currentSet.children();
    }
    return found.first(); // Return first match of the collection
}


$(function(){
    $('.task-test').click(function(){
        $('#boardContent').modal('show')
        .find('#viewcontent')
        .load($(this).attr('value'));
        });
  });

    dragula([
    document.getElementById('1'),
    document.getElementById('2'),
    document.getElementById('3'),
    document.getElementById('4'),
    document.getElementById('5')
])

.on('drag', function(el) {
    
    // add 'is-moving' class to element being dragged
    el.classList.add('is-moving');
})


.on('drop', function(el, container) {
        var c = $(container);
        var items  = c.find('li[data-filename]');
        var status  = $('#'+el.id).attr('data-filename');
        var contain = $('#'+el.id).parent().attr('data-contain');
        
        var result = [];
        $.each(items, function(key, item) {
          result.push($(item).data('filename'));
        });
        _UpdateTask(status, contain);
        //console.log(contain, status);
        var check = $('#'+el.id).closest_descendent('li[data-filename]');
        //console.log(check);

})
.on('dragend', function(el) {
    
    // remove 'is-moving' class from element after dragging has stopped
    el.classList.remove('is-moving');
    

    // add the 'is-moved' class for 600ms then remove it
    window.setTimeout(function() {
        el.classList.add('is-moved');
        
        window.setTimeout(function() {
            el.classList.remove('is-moved');
        }, 600);
    }, 100);
   
    //alert(el.parent().attr('class'));
});

function _UpdateTask(status, contain){
          $.ajax({
              url: '$saveUrl',
              type: 'POST', 
              data: {
                  id: status,
                  status_id: contain, 
                },
              success: function(res, sec){
                $.pjax.reload({container:"#task-list-refresh",async: false});
                   console.log('Completed');
              },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
          });
}


var createOptions = (function() {
    var dragOptions = document.querySelectorAll('.drag-options');
    
    // these strings are used for the checkbox labels
    var options = ['Research', 'Strategy', 'Inspiration', 'Execution'];
    
    // create the checkbox and labels here, just to keep the html clean. append the <label> to '.drag-options'
    function create() {
        for (var i = 0; i < dragOptions.length; i++) {

            options.forEach(function(item) {
                var checkbox = document.createElement('input');
                var label = document.createElement('label');
                var span = document.createElement('span');
                checkbox.setAttribute('type', 'checkbox');
                span.innerHTML = item;
                label.appendChild(span);
                label.insertBefore(checkbox, label.firstChild);
                label.classList.add('drag-options-label');
                dragOptions[i].appendChild(label);
            });

        }
    }
    
    return {
        create: create
    }
    
    
}());

var showOptions = (function () {
    
    // the 3 dot icon
    var more = document.querySelectorAll('.drag-header-more');
    
    function show() {
        // show 'drag-options' div when the more icon is clicked
        var target = this.getAttribute('data-target');
        var options = document.getElementById(target);
        options.classList.toggle('active');
    }
    
    
    function init() {
        for (i = 0; i < more.length; i++) {
            more[i].addEventListener('click', show, false);
        }
    }
    
    return {
        init: init
    }
}());

createOptions.create();
showOptions.init();

//$('.addTaskButton').on('click', function(){
  //$('.wrapit, a').toggleClass('active');
  //$( "#load-data" ).load( "$formUrl" );
  //return false;
  //});

$('.dropdown').on('click',function(){
  if($(this).hasClass('clicked')){
    $(this).removeClass('clicked');
    $(this).parent().parent().css('display','none');
  } else {
  $(this).addClass('clicked');
  }
  })

$('.drag-item').mouseenter(function(){
       $(this).find('.bottom-content').css("display","block");
  }).mouseleave(function(){
          if($(this).find('.dropdown').hasClass('clicked')){
            $(this).find('.bottom-content').css("display","block");
          } else {
            $(this).find('.bottom-content').css("display","none");
          }
         
    })

$(".dropdown").click(function () {
  
  $(this).find('.bottom-content').css("display","block");
 // $(".bottom-content").css("display","block");
});

 /* window.onscroll = function(ev) {
   if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
       $('.testdrop').removeClass('dropdown');
       $('.testdrop').addClass('dropup');
   }else {
      $('.testdrop').removeClass('dropup');
      $('.testdrop').addClass('dropdown');
   }
}; */
$(document).click(function (e) {
    e.stopPropagation();
    var container = $(".dropdown");
    var containerr = container.find('.clicked');

    //check if the clicked area is dropDown or not
    if (container.has(e.target).length === 0 && container.hasClass('clicked')) {
        container.removeClass('clicked');
        $('.bottom-content').hide();
    }
})
JS;
 
$this->registerJs($board);
?>