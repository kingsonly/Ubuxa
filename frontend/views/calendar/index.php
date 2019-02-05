<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\models\Task;
use frontend\models\Calendar;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use kartik\editable\Editable;

use frontend\assets\CalendarAsset;
CalendarAsset::register($this);
unset($this->assetBundles['yii\web\JqueryAsset']);
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calendars';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
.text-aqua, .text-aqua:hover, .text-aqua:focus{
    color:#00c0ef !important;
}
.text-blue, .text-blue:hover, .text-blue:focus{
    color:#0073b7 !important;
}
.text-light-blue, .text-light-blue:hover, .text-light-blue:focus{
    color:#3c8dbc !important;
}
.text-teal, .text-teal:hover, .text-teal:focus{
    color:#39cccc !important;
}
.text-yellow, .text-yellow:hover, .text-yellow:focus{
    color:#f39c12 !important;
}
.text-orange, .text-orange:hover{
    color:#ff851b !important;
}
.text-green, .text-green:hover, .text-green:focus{
    color:#00a65a; !important;
}
.text-lime, .text-lime:hover, .text-lime:focus{
    color:#01ff70 !important;
}
.text-red, .text-red:hover, .text-red:focus{
    color:#dd4b39 !important;
}
.text-purple, .text-purple:hover, .text-purple:focus{
    color:#605ca8 !important;
}
.text-fuchsia, .text-fuchsia:hover, .text-fuchsia:focus{
    color:#f012be !important;
}
.text-muted, .text-muted:hover, .text-muted:focus{
    color:#777;
}
.text-navy, .text-navy:hover, .text-navy:focus{
    color:#001f3f !important;
}

.fa-square{
    font-size:30px;
}
.fa-square:hover{
        transform: rotate(60deg);
}
#color-chooser{
    list-style: none;
}
#color-chooser li{
    margin: 2px 2px;
    float: left;
    text-decoration: none;
}
#color-chooser li:hover{
    text-decoration: none;
}
.external-event.ui-draggable.ui-draggable-handle{
    padding:5px;
    min-height: 20px;
    cursor: move;
    margin: 0px 0px 5px 0px;
    border-radius: 3px;
}
.bg-green{
    background:#00a65a; 
}
.bg-yellow{
    background:#f39c12; 
}
.bg-aqua{
    background:#00c0ef; 
}
.bg-light-blue{
    background:#3c8dbc; 
}
.bg-red{
    background:#dd4b39; 
}
.fc-day-grid-event {
    border: 0px;
}
.cal-center, .cal-side{
    background: #fff;
    padding-top:5px;
}
.cal-side{
   box-shadow: 0 3px 5px #bbb;
   padding:5px;
}
.trash {
  background: #fff;
  width: 33px;
  height: 29px;
  margin: auto;
  border-bottom-left-radius: 6px;
  border-bottom-right-radius: 6px;
  position: absolute;
  left: 33%;
  right: 33%;
  top: 45px;
}
.trash:after, .trash:before {
  content: '';
  position: absolute;
  transition: ease-out 0.3s;
}
.trash:after {
  height: 10px;
  background: #fff;
  width: 120%;
  left: -10%;
  top: -13px;
  -webkit-animation: demoAft 0.3s ease-out 0.5s 2 alternate;
  animation: demoAft 0.3s ease-out 0.5s 2 alternate;
}
.trash:before {
  left: 0;
  right: 0;
  margin: auto;
  top: -22px;
  border: 5px solid transparent;
  border-bottom-color: #fff;
  z-index: 5;
  width: 29px;
  -webkit-animation: demoBfr 0.3s ease-out 0.5s 2 alternate;
  animation: demoBfr 0.3s ease-out 0.5s 2 alternate;
}

.btns {
  width: 100px;
  height: 100px;
  background: #03A8F2;
  border-radius: 100%;
  box-shadow: 0 3px 5px #bbb;
  margin-left: 15px;
  margin-bottom: 57px;
  position: fixed;
  left: 100;
  /* right: 0px; */
  top: 3;
  bottom: 0;
  overflow: hidden;
  cursor: -webkit-grabbing;
  cursor: grabbing;
}
.btns:active {
  cursor: -webkit-grab;
  cursor: grab;
}
.btns:hover .trash:after {
  -webkit-transform: translate(-3px, -8px) rotate(-15deg);
  transform: translate(-3px, -8px) rotate(-15deg);
}
.btns:hover .trash:before {
  -webkit-transform: translate(-6px, -7px) rotate(-15deg);
  transform: translate(-6px, -7px) rotate(-15deg);
}
@-webkit-keyframes demoAft {
  to {
    -webkit-transform: translate(-3px, -8px) rotate(-15deg);
    transform: translate(-3px, -8px) rotate(-15deg);
  }
}
@keyframes demoAft {
  to {
    -webkit-transform: translate(-3px, -8px) rotate(-15deg);
    transform: translate(-3px, -8px) rotate(-15deg);
  }
}
@-webkit-keyframes demoBfr {
  to {
    -webkit-transform: translate(-6px, -7px) rotate(-15deg);
    transform: translate(-6px, -7px) rotate(-15deg);
  }
}
@keyframes demoBfr {
  to {
    -webkit-transform: translate(-6px, -7px) rotate(-15deg);
    transform: translate(-6px, -7px) rotate(-15deg);
  }
}
.ui-widget-header{
    background: #fff !important;
    border:0px !important;
}
.fa-bell{
  color:#ab7979;
  margin: 11px 5px;
  font-size: 9px;
}
#dialog-ul{
  box-shadow: 0 3px 5px #bbb;
  padding: 5px;
}
.ui-dialog-title{
  text-transform: uppercase;
}
.card {
    margin: auto;
    width: 100%;
    box-shadow: 0 3px 5px #bbb;
    padding: 3px 2px 10px 8px;
    margin-bottom: 21px;

}

.material-toggle {
    margin: auto;
    display: inline-block;
    height: 22px;
    width: 30%;
    float: left;
    display: none;
}

.material-toggle input:empty {
  margin-left: -9999px;
}

.material-toggle input:empty ~ label {
  position: relative;
  float: left;
  width: 150px;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.material-toggle input:empty ~ label:before,
.material-toggle input:empty ~ label:after {
  position: absolute;
  display: block;
  content: ' ';
  -webkit-transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
  transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
}

.material-toggle input:empty ~ label:before {
  top: 2px;
  left: 0px;
  width: 32px;
  height: 13px;
  border-radius: 12px;
  background-color: #bdbdbd;
}

input.switch:empty ~ label:after {
  top: -1px;
  left: -9px;
  width: 1.4em;
  height: 8px;
  bottom: 0.1em;
  margin-left: 0.1em;
  background-color: #fff;
  border-radius: 50%;
  width: 17px;
  height: 17px;
  border-radius: 50%;
  border: solid 2px;
  border-color: #fff;
  box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.14), 0 3px 3px -2px rgba(0, 0, 0, 0.2), 0 1px 8px 0 rgba(0, 0, 0, 0.12);
}

.material-toggle input:checked ~ label:before {
  background-color: #1e88e5;
}

.material-toggle input:checked ~ label:after {
  left: 15px;
  background-color: #1565c0;
  border-color: #1565c0;
}
#side-bar-left{
  background: #fff;
  padding-top: 22px;
  height: 688px;
}
.google-calendar-switch{
    width: 100%;
    /* float: left; */
    font-family: calibri;
    color: #777;
    font-size: 15px;
}
#loading {
    display: none;
    position: absolute;
    top: 10px;
    right: 10px;
  }

  #calendarr {
    max-width: 900px;
    margin: 0 auto;
  }
.toggle-switch {
  background: #ccc;
  width: 80px;
  height: 30px;
  overflow: hidden;
  border-radius: 3px;
  display: inline-block;
  vertical-align: middle;
  margin: 0 10px;
}
.toggle-switch:after {
  content: " ";
  display: block;
  width: 40px;
  height: 30px;
  background-color: #3498DB;
  border: 3px solid #fff;
  border-top: 0;
  border-bottom: 0;
  margin-left: -3px;
  transition: all 0.1s ease-in-out;
}
.active .toggle-switch:after {
  margin-left: 40px;
}
.toggle-label {
  display: inline-block;
  line-height: 30px;
}
.toggle-label-off {
  color: #3498DB;
}
.active .toggle-label-off {
  color: #000;
}
.active .toggle-label-on {
  color: #3498DB;
}
</style>
<div class="calendar-index">
    <div class="calendar-container">
          <div class="row">
                <div class="col-sm-3" id="side-bar-left">
                    <div id="dialog">
                        <div id="dialog-ul" style="font-family: calibri;border-bottom:1px solid #ccc;padding-bottom:6px"></div>
                          <input type="hidden" autofocus="true" />
                          <?php $form = ActiveForm::begin(['id' => 'tasklistform']); ?>
               
                          <?= $form->field($taskModel, 'title')->hiddenInput(['maxlength' => true, 'id' => 'new-task-created', 'placeholder' => "Event Title", 'class' => 'form-control'])->label(false) ?>
                       
                          <?= $form->field($taskModel, 'ownerId')->hiddenInput(['value' => 14])->label(false) ?>
                          <?= $form->field($taskModel, 'fromWhere')->hiddenInput(['value' => 'folder'])->label(false) ?>
                          <div class="input-group" id="input-task-group">
                              <input id="new-task" type="text" class="form-control" placeholder="Add task to this event">

                              <div class="input-group-btn" style="font-size: 14px">
                                <?= Html::submitButton('Add Task', ['class' => 'btn btn-primary', 'id' => 'add-new-task']) ?>
                              </div>
                              <!-- /btn-group -->
                          </div>
                        <?php ActiveForm::end(); ?>
                    
                    </div>
                    <!-- switching between google calendar and fullcalendar -->
                    <div class="card">
                        <div class="google-calendar-switch">View my Google Calendar</div>
                          <div class="material-toggle">
                            <input type="checkbox" id="toggle" name="toggle" class="switch gCal-switch" />
                            <label for="toggle" class="switch-gear"></label>
                          </div>
                          <?php (!empty($calendarCheckModel)) ? ($calendarCheckModel->status !== 0) ? $checkedClass = "active": $checkedClass = "" : $checkedClass = "";?>
                          <div class="toggle <?=$checkedClass;?>">
                            <div class="toggle-label toggle-label-off">Ubuxa</div>
                            <div class="toggle-switch"></div>
                            <div class="toggle-label toggle-label-on">Google Calendar</div>
                          </div>
                      <?php $form = ActiveForm::begin(['id' => 'gCalId']); ?>

                      <?php 
                          /*
                          *Block of code get the @ part of the email address to check whether the email is a gmail account
                          */
                          if(!empty($gCalId)){
                          $expEmail = explode('@', $gCalId->calendar_id);
                          if($expEmail[1] == 'gmail.com'){
                            $gCalId = $gCalId->calendar_id;
                          } else {
                            $gCalId = '';
                          }
                          } else {
                      ?>
                        <div class="input-group" id="calendar-id">
                            <?= $form->field($gCalIdModel, 'calendar_id')->textInput(['maxlength' => true, 'id' => 'new-task-created', 'placeholder' => "Add google ID", 'class' => 'form-control'])->label(false) ?>

                            <div class="input-group-btn">
                                <?= Html::submitButton('Go', ['class' => 'btn btn-default btn-flat', 'id' => 'add-calendar-id']) ?>
                            </div>
                            <!-- /btn-group -->
                       </div>
                            <?Php } ?> 
                    <?php ActiveForm::end(); ?>
                     
                    </div>
                    <!-- switching between google calendar and fullcalendar ends here -->

                    <h4 style="font-family: calibri">My events</h4>
                    <div class = "cal-side" id="external-events">
                    <?php
                    /*
                     * This block of code get all the events that are not deleted
                     * The events are being pushed to an array to be used by javascript to render on 
                     * calendar
                     */
                    $events = []; //define an array to push all events into
                    foreach ($calendarTask as $key => $value) {
                       if(!empty($value->taskGroup)){ // check that task group (ie event) is not empty
                        $newEvents = $newTask->find()->select(['title as title','in_progress_time as start','id as id','due_date as end'])->where(['id' => $value->taskGroup->task_group_id])->asArray()->one();
                        if($newEvents['start'] !== NULL ){
                            $expStart =explode(' ', $newEvents['start']);
                            $expEnd =explode(' ', $newEvents['end']);
                            $newEventColor = $taskColor->find()->select(['task_color as color'])->where(['task_group_id' => $value->id])->asArray()->column();
                                $getColorValue = array_shift( $newEventColor );
                                $newEvents['color'] = $getColorValue;
                                array($events,$newEventColor);
                                $date = new DateTime($value['in_progress_time']);
                                $dateFormat = $date->format('Y-m-d');
                                $eventReplaceTitle = str_replace($value['title'],strip_tags($value['title']),$newEvents);
                                $dateReplace = str_replace($value['in_progress_time'],$expStart[0],$eventReplaceTitle);
                                $endDateReplace = str_replace($value['due_date'],$expEnd[0],$dateReplace);
                            array_push($events, $endDateReplace);
                        }
                        
                       }
                    }
                    foreach ($TaskGroupModel as $key => $value) {
                        if(!empty($value->taskGroup) && $value->taskGroup->remove_after_drop_status == 0 && $value->owner == $personId){?>
                            <div class="external-event" data-id="<?=$value->id;?>"><?= $value->title;?></div>
                    <?php } } ?>
                    <div class="checkbox">
                      <label for="drop-remove">
                        <?php (!empty($taskGroupCheckModel)) ? ($taskGroupCheckModel->status !== 0) ? $checked = "checked": $checked = "" : $checked = "";?>
                        <input type="checkbox" id="drop-remove" <?=$checked;?> >
                        remove after drop
                      </label>
                    </div>
              </div>
            <div class="box-body">
                <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                    </ul>
                </div>
            <!-- /btn-group -->
            <!-- /creating new event forms starts here -->
              <div class="input-groups">
                  <?php $form = ActiveForm::begin(['id' => 'create-task-calendar']); ?>
               
                  <?= $form->field($taskModel, 'title')->hiddenInput(['maxlength' => true, 'id' => 'new-events', 'placeholder' => "Event Title", 'class' => 'form-control'])->label(false) ?>
               
                  <?= $form->field($taskModel, 'ownerId')->hiddenInput(['value' => $getIdParam])->label(false) ?>
                  <?= $form->field($taskModel, 'fromWhere')->hiddenInput(['value' => 'folder'])->label(false) ?>
              <?php ActiveForm::end(); ?>
              </div>
            <!-- /creating new event ends starts here -->
                <div class="input-group">
                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                    <div class="input-group-btn">
                      <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
                    </div>
                        <!-- /btn-group -->
                </div>
              <!-- /input-group -->
            
              </div>
           
              <div id="reminder-dialog" style="overflow: hidden">
               <span id="loading-reminder" style="display: none"><?= Yii::$app->settingscomponent->boffinsLoaderImage()?></span> 
              </div>

                </div>
                <div class="col-sm-9 cal-center" style="background: #fff;height:688px">
                    <div class="" id="calendar"></div>
                    <div id='loading'>loading...</div>

                    <div id='calendarr'></div>
                    
                </div>
                  <div class="btn btns">
                      <div class="trash"></div>
                  </div>
        </div>
    </div>
    
</div>
<?php
/*
 * Defining all URL path that will be used for ajax calls
 */
$createTaskUrl           = Url::to(['task/dashboardcreate']); // creating a task url
$updateDropUrl           = Url::to(['calendar/updateremoveafterdrop']); //checkbox for remove event after drop url
$updateTaskGroupCheckUrl = Url::to(['calendar/updatetaskgroupcheckurl']); // update task group check url
$updateCalendarCheckUrl  = Url::to(['calendar/updatecalendarcheckurl']); //calendar type switch update url
$DropUrl                 = Url::to(['calendar/drop']); // when event is dropped on the calendar uel
$resizeDueDateUrl        = Url::to(['calendar/resizeduedate']); // when calender event is resized to a new due date url
$UpdateOnDrop            = Url::to(['calendar/updateondrop']); // when external events are being dropped on the calendar
$Taskgrouptask           = Url::to(['calendar/taskgrouptask']); // create task for each task group(ie event)
$reminderUrl             = Url::to(['calendar/reminder']); //reminder url
$createReminderUrl       = Url::to(['reminder/create']); //create new reminder url
$calendarTaskDeleteUrl   = Url::to(['task/calendartaskdelete']); // URL to delete task
$createCalendarIdUrl     = Url::to(['calendar/createcalendarid']); // create google calendar ID for new user URL
$newEve                  = json_encode($events); //pass event array as json encoded array to be used in the javascript
$calendarScript = <<<JS
$(document).ready(function(){
      var eve = $newEve; //get the event array from server
      //function to toggle the switch button for google calendar and update the database switch status
    $(function(){
        //get user google calendar ID. If its empty user should fill the form to insert goodle calendar ID
        var gCalId = '$gCalId';
        if(gCalId == " "){
          $('.toggle').hide();
          $('#calendar-id').slideDown();
          ubuxaCalendar();
        }
        if($('.toggle').hasClass('active')){
          $('#calendar').hide();
          displayGoogleCalendarEvent(); //call to the google calendar display function
        } else {
          $('#calendarr').hide();
          ubuxaCalendar();
          $('#calendar').show();

        }
    
      //function to inherit background from child
      $('.external-event').each(function() {
        var childColor = $(this).find(':first-child').css('background-color');
        $(this).css('background-color',childColor);
      });
      //update check box
      $('#drop-remove').click(function(){
            var getStatus = 1;
            $.post('$updateTaskGroupCheckUrl',
            {
              status:getStatus
            },
            function(data){
               console.log(data);
            }
            )
      }) 
        
      //add task to the events
      $('#new-task').keyup(function(){
            if($('#new-task').val().length === 0){
                $('#add-new-task').prop('disabled', true);
            } else {
                $('#add-new-task').prop('disabled', false);
            }
            $('#new-task-created').val($(this).val());
      })  

      $('#tasklistform').on('beforeSubmit',function(e){
            e.preventDefault();
            var task_group_id = $('#dialog').find('.taskGroupId').attr('data-id');
            var datas = $(this).serializeArray();
            datas.push({name: 'taskgroupid', value: task_group_id});
            var dateValue = $('#new-task').attr('data-date');
         
            $.ajax({
                url: '$createTaskUrl',
                type: 'POST',
                data: datas,
                success: function(response) {
                    var taskArray = JSON.parse(response);

                    var dateString = new Date(taskArray[2]);
                    dateString = new Date(dateString).toUTCString();
                    dateString = dateString.split(' ').slice(1, 4).join(' ');
                    var event = $('<div />')
                var input = $("<input/>", {
                  type: "checkbox",
                  class: "checkbox-task",
                  id: "task-"+taskArray[0]
                });
                var label = $("<label/>", {
                  for: "task-"+taskArray[0],
                  class: "reminder-notes",
                  id: "task-"+taskArray[0]
                });
                var p = $("<p/>");
                var span = $("<span/>", {
                  class: "fa fa-calendar-check-o"
                });
                var spanChild = $("<span/>", {
                  class: "dialog-bell"
                });
                var lastSpan = $("<span/>", {
                  class: "fa fa-trash calendar-task-delete",
                  id:"calendar-task-delete"
                });
                span.css({
                  'font-size':'13px',
                  'font-family':'calibri',
                  'margin':'0px -1px'
                });
                spanChild.css('margin-left','3px');
                spanChild.css('margin-left','3px');
                spanChild.text(dateString);
                span.append(spanChild);
                p.append(span);
                label.text(taskArray[1]);
                input.attr({"data-id":taskArray[0],"date-id":taskArray[2]})
                lastSpan.prop(" data-id",taskArray[0])
                p.append(lastSpan);

            event.addClass('task-element');
            event.append(input);
            event.append(label);
            event.append(p);
            $('.ui-dialog').find('[data-date =' + dateValue + ']').find('#calendar-task-refresh').find('#parent').append(event);
                    $('#new-task').val('')
                    
                },
              error: function(res, sec){
                    console.log('Something went wrong');
              }
            });
          
          return false; 
      })

      //initialize the dialog methods for events
      $('#dialog').dialog({
          autoOpen: false,
          modal:true,
          closeText: null
      });

      //initialize the dialog methods for reminders
       $('#reminder-dialog').dialog({
          autoOpen: false,
          modal:false,
          closeText: null,
          draggable:false
      });


      function init_events(ele) {
          ele.each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            }
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject)

            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex        : 1070,
              revert        : true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            })

          })
      }
     
      //call the init_event function      
      init_events($('#external-events div.external-event'));

      //function to initialize fullcalendar
      function ubuxaCalendar(){
        $('#calendar').fullCalendar({
            header    : {
            left  : 'prev,next today',
            center: 'title',
            },
            buttonText: {
            today: 'today',
            month: 'month',
            week : 'week',
            day  : 'day'
            },
            defaultDate: '2019-01-01',
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            durationEditable:true,
            droppable : true, // this allows things to be dropped onto the calendar !!!

          drop      : function (date, allDay) { // this function is called when something is dropped
                var elements = $(this);
                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject')
                var getId = $(this).attr('data-id');
                var getColor = $(this).css('background-color');
                var dt = new Date();
                var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                console.log(getColor);
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject)

                // assign it the date that was reported
                copiedEventObject.start           = date
                copiedEventObject.allDay          = allDay
                copiedEventObject.id              = getId
                copiedEventObject.backgroundColor = $(this).css('background-color')

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                //console.log(copiedEventObject);
                console.log(date.format());
                var getDate = date.format()+' '+time;
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)
               // update remove after drop status
                $.post('$DropUrl',
                {
                  id:getId,
                  color:getColor,
                  date:getDate
                },
                function(data){
                  console.log(data);
                }
                )
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                  // if so, remove the element from the "Draggable Events" list
                $.post('$updateDropUrl',
                {
                  id:getId
                },
                function(data){
                   //console.log(data);
                   elements.remove();
                }
                )
                  
                }
            },
            dayClick: function(date, jsEvent, view) {
                //empty the dialog box first
                $('#reminder-dialog').html(' ');
                var theDialog = $('#reminder-dialog').dialog("option", "position",  {my: "center top+5", of: jsEvent});
                  theDialog.dialog({ modal: false, title:date.format(), width:350});
                  theDialog.dialog('open');
                  $('#reminder-dialog').parent().css({
                      'box-shadow':'0 3px 5px #bbb',
                      })
                    $('#loading-reminder').show();
                    setTimeout(function(){ 
                    $.post('$reminderUrl',
                    {
                      date:date.format()
                    },
                    function(data){
                       $('#loading-reminder').hide();
                       $('#reminder-dialog').html(data);

                       $('#reminder-dialog').attr('data-date',date.format());
                    }
                    )
                    }, 500);
                      
            },
              events: eve,
            eventDragStop: function(event,jsEvent) {

                var trashEl = jQuery('.btns');
                var ofs = trashEl.offset();

                var x1 = ofs.left;
                var x2 = ofs.left + trashEl.outerWidth(true);
                var y1 = ofs.top;
                var y2 = ofs.top + trashEl.outerHeight(true);

                if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
                    jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
                        $('#calendar').fullCalendar('removeEvents', event._id);
                        setTimeout(function(){ 
                        $.post('$calendarTaskDeleteUrl',
                        {
                          id: event.id
                        },
                        function(data){
                           console.log(data);
                        }
                        )
                        }, 500);
                }
            },
            eventRender: function (event, element) {
                //element.attr('href', 'javascript:void(0);');
                var target = $(this);
                element.click(function(e) {
                     $.post('$Taskgrouptask',
                    {
                      id:event.id
                    },
                    function(data){
                       console.log(data);
                       $('#dialog-ul').html(data);
                       $('#dialog').attr('data-date',event.start.format());
                       $('#new-task').attr('data-date',event.start.format());
                    }
                    )
                    var offest = $(this).offset();
                    var height = $(this).height();
                    var theDialog = $('#dialog').dialog("option", "position",  {my: "center top+5", of: e});
                    theDialog.dialog({ modal: true, title: event.title, width:350});
                    theDialog.dialog('open');
                    $('#add-new-task').prop('disabled', true);
                    if($('#new-task').val().length > 0){
                        console.log('true');
                        $('#new-task').val('');
                        
                    }
                    //remove div if already exist already exist
                    $('#dialog').find('.taskGroupId').remove();

                    //add a new div
                    var newElement = $('<div />');
                 
                    newElement.addClass('taskGroupId');
                    newElement.attr('data-id',event.id);
                    $('#dialog').append(newElement);
                    
                })
            },
            eventDrop: function(event, delta, revertFunc) {
                var getId = event.id;
                var getStartDate = event.start.format();
                if(event.end == null){
                    var getEndDate = event.start.format();
                } else {
                    var getEndDate = event.end.format();
                }
                var dt = new Date();
                var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                var getStartDate = getStartDate+' '+time;
                var getEndDate = getEndDate+' '+time;

                $.post('$UpdateOnDrop',
                {
                  id:getId,
                  start:getStartDate,
                  end:getEndDate
                },
                function(data){
                   console.log(data);
                }
                )

            },
            eventResize: function(event, delta, revertFunc) {
                var dt = new Date();
                var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                var getId = event.id;
                var getDate = event.end.format() + " " + time;
                $.post('$resizeDueDateUrl',
                {
                  id:getId,
                  duedate:getDate
                },
                function(data){
                   console.log(data);
                }
                )

            }
        });
      }

      /* ADDING EVENTS */
      var currColor = '#3c8dbc' //Red by default
       //Color chooser button
      var colorChooser = $('#color-chooser-btn')
      $('#color-chooser > li > a').click(function (e) {
          e.preventDefault()
          //Save color
          currColor = $(this).css('color')
          //Add color effect to button
          $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
      })
            
      $('#add-new-event').click(function(e){
        e.preventDefault();
        //Get value and make sure it is not null
        var val = $('#new-event').val()
        if (val.length == 0) {
          return
        }
        var event2 = '<div class="external-child" style="background-color: '+ currColor + '; border-color:'+ currColor + '; color:#fff">'+val+'</div>'
        var datas = $('#create-task-calendar').serializeArray();
        datas.push({name: 'field', value: event2});
        $.ajax({
          url: '$createTaskUrl',
          type: 'POST',
          data: datas,
          success: function(response) {
              console.log(response)
              //Create events
                var event = $('<div />')
               
                event.css({
                  'background-color': currColor,
                  'border-color'    : currColor,
                  'color'           : '#fff'
                }).addClass('external-event');
                event.html(val);
                event.attr('data-id',response);
                $('#external-events').prepend(event)

                //Add draggable funtionality
                init_events(event)

                //Remove event from text input
                $('#new-event').val('')
         
          },
        error: function(res, sec){
             console.log('Something went wrong');
        }
        });
      
      })

      //onclick of calendar next button should load the reminders
      $(document).find('.fc-next-button').click(function(){
        var arr = $getDateArr; //get reminder array data
        //iterate through the array
        for(var i=0; i<$getDateArr.length; i++){
            
            var getArrDate = arr[i];
            if($('.fc-day-top').data('date','2019-01-23')){
            $('tr').find('[data-date =' + getArrDate + ']').append('<span class="fa fa-bell" data-id="' + getArrDate + '"></span>');
            } 
        }

      })      
      //onclick of calendar previuos button should load the reminders
       $('.fc-prev-button').click(function(){
        var arr = $getDateArr; //get reminder array data
        //iterate through the array
        for(var i=0; i<$getDateArr.length; i++){
            
            var getArrDate = arr[i];
            if($('.fc-day-top').data('date','2019-01-23')){
            $('tr').find('[data-date =' + getArrDate + ']').append('<span class="fa fa-bell" data-id="' + getArrDate + '"></span>');
            } 
        }

      })

     //on document ready should load the reminders icons
      var arr = $getDateArr; //get reminder array data
      //iterate through the array and append the icons at their respective dates
      for(var i=0; i<$getDateArr.length; i++){
          var getArrDate = arr[i];
          if($('.fc-day-top').data('date','2019-01-23')){
          $('tr').find('[data-date =' + getArrDate + ']').append('<span class="fa fa-bell" data-id="' + getArrDate + '" data-unique = "'+ i +'"></span>');
          } 
      }

      $('.toggle').on('click', function(event){
      event.preventDefault();
      $(this).toggleClass('active');
      if($(this).hasClass('active')){
        $('#calendar').hide();
        displayGoogleCalendarEvent(); //call to the google calendar display function
        $('#calendarr').show();
      } else {
          $('#calendarr').hide();
          ubuxaCalendar();
          $('#calendar').show();
      }
      
      setTimeout(function(){ 
      var getStatus = 1;
          $.post('$updateCalendarCheckUrl',
          {
            status:getStatus
          },
          function(data){
             console.log(data);
          }
          )
          }, 1000)
      });
    });
  

    // Submit method for user google calendar ID
    $('#gCalId').on('beforeSubmit',function(e){
        e.preventDefault();
        var datas = $(this).serializeArray();
        $.ajax({
            url: '$createCalendarIdUrl',
            type: 'POST',
            data: datas,
            success: function(response) {
               $('#calendar-id').slideUp();
               $('.toggle').slideDown();
                
            },
          error: function(res, sec){
              console.log('Something went wrong');
          }
        });
        
        return false; 
    })

    //function to display the google calender event of fullcalendar
    function displayGoogleCalendarEvent(){
      $('#calendarr').fullCalendar({

      header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,listYear'
      },

      displayEventTime: false, // don't show the time column in list view

      // THIS KEY WON'T WORK IN PRODUCTION!!!
      // To make your own Google API key, follow the directions here:
      // http://fullcalendar.io/docs/google_calendar/
      googleCalendarApiKey: 'AIzaSyBa8z38z5UzFjaYJlbXapaxBoQGeGyX618',

      // US Holidays
      events: {
      googleCalendarApiKey: 'AIzaSyBa8z38z5UzFjaYJlbXapaxBoQGeGyX618',
      googleCalendarId: 'engineernamzy@gmail.com',
      },

      eventClick: function(event) {
      // opens events in a popup window
      window.open(event.url, 'gcalevent', 'width=700,height=600');
      return false;
      },

      loading: function(bool) {
      $('#loading').toggle(bool);
      }

      });
    }            

})
JS;
 
$this->registerJs($calendarScript);
?>
