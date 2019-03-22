<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use boffins_vendor\components\controllers\TaskViewWidget;
use boffins_vendor\components\controllers\EdocumentWidget;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\web\View;
use frontend\models\Task;
use frontend\models\Onboarding;

$checkUrl = explode('/',yii::$app->getRequest()->getQueryParam('r'));
$checkUrlParam = $checkUrl[0];
$boardUrl = Url::to(['task/index']);
if(!empty($display)){
  $array = Task::sortTaskList($display);
}
//echo '<pre>',print_r($array),'</pre>';
?>
<style type="text/css">
    .bg-info {
        background-color: #fff !important;
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
        height: 245px;
        border-bottom: 1px solid #ccc;
        padding-top: 8px;
        overflow: auto;
        width: 100%;
    }

    .box-input1 {
        padding-top: 5px;
        height: 50px;
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
   border-bottom: solid 1px #ddd;
}
 .todo:last-child {
   border-bottom: none;
}
 .todo__state {
  position: absolute;
   top: 10px;
   left: 0;
   opacity: 0;
   cursor: pointer;
   width: 32px;
   height: 25px;
}
 .todo__text {
   color: #135156;
   transition: all 0.4s linear 0.4s;
   width: 95%;
}
 .todo__icon {
   position: absolute;
   top: 0;
   bottom: 0;
   left: 0;
   /*width: 100%;*/
   pointer-events: none;
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
   width: 80%;
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
#loading-task {
    position: absolute;
    right: 3px;
    top: -3px;
    -webkit-appearance: none;
    -moz-appearance: none;
    border: none;
    padding: 6px;
    width: 60px;
    transition: all 0.2s;
    display: none;
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
/*-------------------------
  Inline help tip
--------------------------*/


.help-tip{
  position: absolute;
  top: 7px;
  right: 18px;
  text-align: center;
  background-color: #BCDBEA;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  font-size: 14px;
  line-height: 26px;
  cursor: pointer;
}

.help-tip:before{
  content:'?';
  font-weight: bold;
  color:#fff;
}

.help-tip:hover p{
  display:block;
  transform-origin: 100% 0%;

  -webkit-animation: fadeIn 0.3s ease-in-out;
  animation: fadeIn 0.3s ease-in-out;

}
#task-list-loader{
  display: none;
}
.help-tip p{
  display: none;
  text-align: left;
  background-color: #0b1015a6;
  padding: 20px;
  width: 300px;
  position: absolute;
  border-radius: 3px;
  box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
  right: -4px;
  color: #FFF;
  font-size: 13px;
  line-height: 1.4;
  z-index: 99999;
  opacity: 20;
}

.help-tip p:before{
  position: absolute;
  content: '';
  width:0;
  height: 0;
  border:6px solid transparent;
  border-bottom-color:#1E2021;
  right:10px;
  top:-12px;
}

.help-tip p:after{
  width:100%;
  height:40px;
  content:'';
  position: absolute;
  top:-40px;
  left:0;
}
.tip-text{
  padding-bottom: 10px;
}
@-webkit-keyframes fadeIn {
  0% { 
    opacity:0; 
    transform: scale(0.6);
  }

  100% {
    opacity:100%;
    transform: scale(1);
  }
}

@keyframes fadeIn {
  0% { opacity:0; }
  100% { opacity:100%; }
}
.for-modal-loader {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 50%;
  height: 50%;
  z-index: 9999;
  background: url(<?//= $modalwait; ?>) center no-repeat #fff;
}
.edoc-list{
    position: absolute;
    right: 10px;
    font-size: 13px;
    color: #6b808c;
    top: 14px;
}
.todo__text{
  cursor: pointer;
}
</style>
	 <div class="col-md-4" id="for-pjax">
        <div class="bg-info column-margin taskz-listz">
	        <div class="task-header">
            <?php if($checkUrlParam == 'folder'){
              $tasksExists = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::TASK_ONBOARDING])->exists();
              $getTasks = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::TASK_ONBOARDING])->one();
            ?>
              <?php if(!$tasksExists || $getTasks->status < Onboarding::ONBOARDING_COUNT){ ?>
                <div class="help-tip" id="task-tipz">
                    <p class="tip=text">Take a tour of task and find out useful tips.
                      <button type="button" class="btn btn-success" id="task-tour">Start Tour</button>
                    </p>
                  </div>
              <?php } ?>
            <?php }else if($checkUrlParam == 'site'){
                $tasksExists = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::TASK_ONBOARDING])->exists();
                $getTasks = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::TASK_ONBOARDING])->one();
              ?>
              <?php if(!$tasksExists || $getTasks->status < Onboarding::ONBOARDING_COUNT){ ?>
                  <div class="help-tip" id="site-tasktour">
                      <p class="tip=text">Take a tour of task and find out useful tips.
                        <button type="button" class="btn btn-success" id="site-task-tour">Start Tour</button>
                      </p>
                    </div>
                <?php } ?>
            <?php }?>
                <span>TASKS</span>
                 
            </div>
            
	        <div class="box-content-task" id="box-content">
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
    if(!empty($array)){
    foreach ($array as $key => $value) { 
      $assigneesIds = $value->taskAssigneesUserId;
      $userid = Yii::$app->user->identity->id;
      $taskBoard = Url::to(['task/view', 'id' => $value->id,'folderId' => $folderId]);
    ?>
  <div class="todo">
        <input class="todo_listt<?= $value->id; ?> todo__state <?= ($userid == $value->owner) || in_array($userid, $assigneesIds) ?  'has-access' : 'no-access'?>" data-id="<?= $value->id; ?>" id="todo-list<?= $value->status_id; ?>" type="checkbox" <?= $value->status_id == Task::TASK_COMPLETED ? 'checked' : '';?>/>
    <?= EdocumentWidget::widget(['docsize'=>84,'target'=>'tasklist'.$value->id, 'textPadding'=>18,'referenceID'=>$value->id,'reference'=>'task','iconPadding'=>1,'tasklist'=>'hidetasklist', 'edocument' => 'dropzone']);?>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon" id="task-box">
      <use xlink:href="#todo__line" class="todo__line"></use>
      <use xlink:href="#todo__box" class="todo__box"></use>
      <use xlink:href="#todo__check" class="todo__check"></use>
      <use xlink:href="#todo__circle" class="todo__circle"></use>
    </svg>
    <div class="todo__text" value ="<?=$taskBoard;?>">
        <?php
          $edocLists = $value->clipOn['edocument'];
          if(!empty($edocLists)){?>
              <span class="edoc-list" aria-hidden="true" data-toggle="tooltip" title="Attachments">
                <? 
                  $edoc = count($edocLists); 
                  echo $edoc;
                ?>
                <i class="fa fa-file-text-o time-icon" aria-hidden="true"></i>
              </span>
        <?php }?>
        <span><?= strip_tags($value->title); ?></span>
    </div>
    
  </div>

  <?php $id++;}}else{
    echo "No task";
  }?>
</div> 

</div>
      
	   <div class="box-input1">
            <div class="form-containers">
                 <div class="embed-submit-field">
					       <?php if($checkUrlParam == 'folder'){?>
                    <?php $form = ActiveForm::begin(['action'=>Url::to(['task/dashboardcreate']),'id' => 'create-task']); ?>
					 
                      <?= $form->field($taskModel, 'title')->textInput(['maxlength' => true, 'id' => 'addTask', 'placeholder' => "Add a task"])->label(false) ?>
  					 
  					           <?= $form->field($taskModel, 'ownerId')->hiddenInput(['value' => $parentOwnerId])->label(false) ?>
					 			<?= $form->field($taskModel, 'fromWhere')->hiddenInput(['value' => $location])->label(false) ?>
                    
                    <span class="for-task-loader">

                      <?= Html::submitButton('Save', ['id' => 'taskButton']) ?>
                      <span id="loading-task"><?= Yii::$app->settingscomponent->boffinsLoaderImage()?></span>
                    </span>
                    
                    <?php ActiveForm::end(); ?>
                  <?php }?>
                </div> 
            </div>  
        </div>
    </div>
</div>

<!-- <div class="for-modal-loader"></div> -->



<?php 
$taskUrl = Url::to(['site/task']);
$boardUrlz = Url::to(['task/board']);
$taskOnboarding = Url::to(['onboarding/taskonboarding']);
$createUrl = Url::to(['task/dashboardcreate']);
$task = <<<JS

$(".todo__state").change(function() {
    var checkedId;
    checkedId = $(this).data('id');
    _UpdateStatus(checkedId);        
});

$(function(){
  $('.todo__text').on('click',function(){
      var folderId = $('.board-specfic').attr('data-folderId');
      $('#boardContent').modal('show')
      .find('#viewcontent')
      .load($(this).attr('value'));
    });
});

function _TaskOnboarding(){
          $.ajax({
              url: '$taskOnboarding',
              type: 'POST', 
              data: {
                  user_id: $userId,
                },
              success: function(res, sec){
                   console.log('Status updated');
              },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
          });
}

//$(".todo__icon").click(false);

function _UpdateStatus(checkedId){
          $.ajax({
              url: '$taskUrl',
              type: 'POST', 
              data: {
                  id: checkedId,
                },
              success: function(res, sec){
                var folderId = $('.board-specfic').attr('data-folderId');
                  setTimeout(function(){
                    $.pjax.reload({container:"#kanban-refresh",replace: false, async:false, url: '$boardUrlz&folderIds='+folderId});
                  }, 900);
              },
              error: function(res, sec){
                  //console.log(' went wrong');
              }
          });
}


$('#create-task').on('beforeSubmit', function(e) {
           var form = $(this);
           var task = $('#addCard').val();
           $('#taskButton').hide();
           $("#loading-task").show();
           e.preventDefault();
            if(form.find('.has-error').length) {
                return false;
            }
            setTimeout(function(){
            $.ajax({
                url: '$createUrl',
                type: 'POST',
                data: form.serialize(),
                async: true,
                success: function(response) { 
                  var folderId = $('.board-specfic').attr('data-folderId');
                    toastr.success('Task created');
                    $.pjax.reload({container:"#task-list-refresh",async: false});
                    $.pjax.reload({container:"#kanban-refresh",replace: false, async:false, url: '$boardUrlz&folderIds='+folderId});
                    $.pjax.reload({container:"#task-modal-refresh",async: false});
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
            }, 5);
            return false;    
});

$("#addTask").bind("keyup change", function() {
    var value = $(this).val();
    if (value && value.length > 0) {
        $("#taskButton").show();
    } else {
        $("#taskButton").hide();
    }
    if(value && value.length > 49){
      //toastr.info("Maximum characters for task title reached. You can add description to a task from the task board");
    }
});

$('#addTask').bind("keyup keypress", function(e) {
  var code = e.keyCode || e.which; 
  if (code  == 13) {    
      if($(this).val()==''){
          e.preventDefault();
          return false;
      }
  }
});


  $(function() {

  var taskTour = new Tour({
    name: "taskTour",
    steps: [
        {
          element: ".taskz-listz",
          title: "Task List",            
          content: "You can view all task from this section",
          onShow: function(taskTour){
            $('#task-tipz').hide();
          },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-tasks icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: "#addTask",
          title: "Add task",
          content: "Add new tasks here",
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-plus-square icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        
        {
          element: ".board-open",
          title: "Task board",
          content: "You can get access to more features for task management from the action menu.",
          onShow: function(taskTour){
                //$('.side_menu').addClass('side-drop');
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
            },
          onShown: function(taskTour){
            $(".tour-backdrop").appendTo("#content");
            $(".tour-step-background").appendTo("#content");
            $(".tour-step-background").css("left", "0px");
            },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-tasks icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".drag-container",
          title: "Task board",
          content: "This is your task board. You can manage all task here.",
          placement: "bottom",
          onShow: function(taskTour){
            $('#mySidenav').css({'width':'100%'});
            var folderId = $('.board-specfic').attr('data-folderId');
              $.ajax({
              url: '$boardUrlz'+'&folderIds='+folderId,
              success: function(data) {
              $('.sidenav').html(data);
              }
            });
            },
          onShown: function(taskTour){
            $(".tour-backdrop").appendTo(".close-kanban");
            $(".tour-step-background").appendTo(".close-kanban");
            $(".tour-step-background").css("left", "0px");
            },
            template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-clipboard icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".drag-item:first",
          title: "Kanban",
          content: "You can drag and drop task to the various status, assign task to users and much more",
          onShown: function(taskTour){
            $(".tour-backdrop").appendTo(".drag-container");
            $(".tour-step-background").appendTo(".drag-container");
            $(".tour-step-background").css("left", "0px");
            },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-bars icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".add-card:first",
          title: "Add Task Card",
          content: "Add task card for each status from here.",
          onShown: function(taskTour){
            $(".tour-backdrop").appendTo(".drag-column:first");
            $(".tour-step-background").appendTo(".drag-container");
            $(".tour-step-background").css("left", "0px");
            },
            template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-plus-square icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='end' class='btn hca-tooltip--okay-btn'>Close</a></div></div></div>",
        },
        
      ],
    backdrop: true,  
    storage: false,

    smartPlacement: true,    
    onEnd: function (taskTour) {
      _TaskOnboarding();
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
  $('#task-tour').on('click', function(e){
       taskTour.start();
       e.preventDefault();
    })
 taskTour.init();

});


  $(function() {

  var siteTaskTour = new Tour({
    name: "siteTaskTour",
    steps: [
        {
          element: ".taskz-listz",
          title: "Task List",            
          content: "You can view all task from this section",
          onShow: function(taskTour){
            $('#site-tasktour').hide();
          },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-tasks icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".open-board",
          title: "Task board",
          content: "You can get access to more features for task management from the action menu.",
          onShow: function(siteTaskTour){
                //$('.side_menu').addClass('side-drop');
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
            },
          onShown: function(siteTaskTour){
            $(".tour-backdrop").appendTo("#content");
            $(".tour-step-background").appendTo("#content");
            $(".tour-step-background").css("left", "0px");
            },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-tasks icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".drag-container",
          title: "Task board",
          content: "This is your task board. You can manage all task here.",
          placement: "bottom",
          onShow: function(siteTaskTour){
            $('#mySidenav').css({'width':'100%'});
            
            },
          onShown: function(siteTaskTour){
            $(".tour-backdrop").appendTo(".sidenav");
            $(".tour-step-background").appendTo(".sidenav");
            $(".tour-step-background").css("left", "0px");
            },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-clipboard icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".drag-item:first",
          title: "Kanban",
          content: "You can drag and drop task to the various status, assign task to users and much more",
          onShown: function(siteTaskTour){
            $(".tour-backdrop").appendTo(".drag-container");
            $(".tour-step-background").appendTo(".drag-container");
            $(".tour-step-background").css("left", "0px");
            },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-bars icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='end' class='btn hca-tooltip--okay-btn'>End</a></div></div></div>",
        },
        
      ],
    backdrop: true,  
    storage: false,

    smartPlacement: true,    
    onEnd: function (siteTaskTour) {
      _TaskOnboarding();
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
  $('#site-task-tour').on('click', function(e){
       siteTaskTour.start();
       e.preventDefault();
    })
 siteTaskTour.init();

});


JS;
 
$this->registerJs($task);
?>