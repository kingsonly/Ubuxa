<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\models\Task;

use frontend\assets\CalendarAsset;
CalendarAsset::register($this);
unset($this->assetBundles['yii\web\JqueryAsset']);
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calendars';
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
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
  width: 50px;
  height: 60px;
  margin: auto;
  border-bottom-left-radius: 6px;
  border-bottom-right-radius: 6px;
  position: absolute;
  left: 33%;
  right: 33%;
  top: 55px;
  /*box-shadow: 0px 0px #039ee3, 1px 1px #039ee3, 2px 2px #039ee3, 3px 3px #039ee3, 4px 4px #039ee3, 5px 5px #039ee3, 6px 6px #039ee3, 7px 7px #039ee3, 8px 8px #039ee3, 9px 9px #039ee3, 10px 10px #039ee3, 11px 11px #039ee3, 12px 12px #039ee3, 13px 13px #039ee3, 14px 14px #039ee3, 15px 15px #039ee3, 16px 16px #039ee3, 17px 17px #039ee3, 18px 18px #039ee3, 19px 19px #039ee3, 20px 20px #039ee3, 21px 21px #039ee3, 22px 22px #039ee3, 23px 23px #039ee3, 24px 24px #039ee3, 25px 25px #039ee3, 26px 26px #039ee3, 27px 27px #039ee3, 28px 28px #039ee3, 29px 29px #039ee3, 30px 30px #039ee3, 31px 31px #039ee3, 32px 32px #039ee3, 33px 33px #039ee3, 34px 34px #039ee3, 35px 35px #039ee3, 36px 36px #039ee3, 37px 37px #039ee3, 38px 38px #039ee3, 39px 39px #039ee3, 40px 40px #039ee3, 41px 41px #039ee3, 42px 42px #039ee3, 43px 43px #039ee3, 44px 44px #039ee3, 45px 45px #039ee3, 46px 46px #039ee3, 47px 47px #039ee3, 48px 48px #039ee3, 49px 49px #039ee3, 50px 50px #039ee3, 51px 51px #039ee3, 52px 52px #039ee3, 53px 53px #039ee3, 54px 54px #039ee3, 55px 55px #039ee3, 56px 56px #039ee3, 57px 57px #039ee3, 58px 58px #039ee3, 59px 59px #039ee3, 60px 60px #039ee3, 61px 61px #039ee3, 62px 62px #039ee3, 63px 63px #039ee3, 64px 64px #039ee3, 65px 65px #039ee3, 66px 66px #039ee3, 67px 67px #039ee3, 68px 68px #039ee3, 69px 69px #039ee3, 70px 70px #039ee3;*/
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
  top: -23px;
  border: 5px solid transparent;
  border-bottom-color: #fff;
  z-index: 5;
  width: 40px;
  -webkit-animation: demoBfr 0.3s ease-out 0.5s 2 alternate;
  animation: demoBfr 0.3s ease-out 0.5s 2 alternate;
}

.btns {
  width: 150px;
  height: 150px;
  background: #03A8F2;
  border-radius: 100%;
  box-shadow: 0 3px 5px #bbb;
  margin: auto;
  /*position: fixed;*/
  left: 0;
  right: 0;
  top: 0;
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
</style>
</style>
<div class="calendar-index">

    <div class="calendar-container">
        <div class="row">
            <div class="col-sm-3">
                <div id="dialog">
                    <ul id="dialog-ul">
                        
                    </ul>
                    <p><input type="text" id="datepicker" style="display: none"><span class="fa fa-calendar" id="mycalendar-fc"></span></p>
                    <input type="hidden" autofocus="true" />
                    <?php $form = ActiveForm::begin(['id' => 'tasklistform']); ?>
         
                    <?= $form->field($taskModel, 'title')->hiddenInput(['maxlength' => true, 'id' => 'new-task-created', 'placeholder' => "Event Title", 'class' => 'form-control'])->label(false) ?>
                 
                    <?= $form->field($taskModel, 'ownerId')->hiddenInput(['value' => 14])->label(false) ?>
                    <?= $form->field($taskModel, 'fromWhere')->hiddenInput(['value' => 'folder'])->label(false) ?>
                    <div class="input-group">
                    <input id="new-task" type="text" class="form-control" placeholder="Add task to this event">

                    <div class="input-group-btn" style="font-size: 14px">
                      <?= Html::submitButton('Add Task', ['class' => 'btn btn-primary', 'id' => 'add-new-task']) ?>
                    </div>
                        <!-- /btn-group -->
                    </div>
                    
                <?php ActiveForm::end(); ?>
                
                </div>
                <h4 style="font-family: calibri">My events</h4>
                <div class = "cal-side" id="external-events">
                <?php
                $events = [];
                foreach ($calendarTask as $key => $value) {
                    //echo 45566;
                   if(!empty($value->taskGroup)){
                    $newEvents = $newTask->find()->select(['title as title','in_progress_time as start','id as id','due_date as end'])->where(['id' => $value->taskGroup->task_group_id])->asArray()->one();
                    if($newEvents['start'] !== NULL ){
                        $expStart =explode(' ', $newEvents['start']);
                        $expEnd =explode(' ', $newEvents['end']);
                        $newEventColor = $taskColor->find()->select(['task_color as color'])->where(['task_group_id' => $value->id])->asArray()->column();
                        
                        //foreach ($newEvents as $newEvent) {
                            $getColorValue = array_shift( $newEventColor );
                            $newEvents['color'] = $getColorValue;
                            array($events,$newEventColor);
                            $date = new DateTime($value['in_progress_time']);
                            $dateFormat = $date->format('Y-m-d');
                            $eventReplaceTitle = str_replace($value['title'],strip_tags($value['title']),$newEvents);
                            $dateReplace = str_replace($value['in_progress_time'],$expStart[0],$eventReplaceTitle);
                            $endDateReplace = str_replace($value['due_date'],$expEnd[0],$dateReplace);
                            
                       // }
                        array_push($events, $endDateReplace);
                    }
                    
                   }
                }
                foreach ($TaskGroupModel as $key => $value) {
                    if(!empty($value->taskGroup) && $value->taskGroup->remove_after_drop_status == 0){?>
                        <div class="external-event" data-id="<?=$value->id;?>"><?= $value->title;?></div>
                <?php    
                    }
                }
                
                ?>
            <div class="external-event bg-green">Lunch</div>
            <div class="external-event bg-yellow">Go home</div>
            <div class="external-event bg-aqua">Make Coffee</div>
            <div class="external-event bg-light-blue">Break time</div>
            <div class="external-event bg-red">Sleep tight</div>
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
        <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
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
        <div class="input-groups">
            <?php $form = ActiveForm::begin(['id' => 'create-task-calendar']); ?>
         
            <?= $form->field($taskModel, 'title')->hiddenInput(['maxlength' => true, 'id' => 'new-events', 'placeholder' => "Event Title", 'class' => 'form-control'])->label(false) ?>
         
            <?= $form->field($taskModel, 'ownerId')->hiddenInput(['value' => 14])->label(false) ?>
            <?= $form->field($taskModel, 'fromWhere')->hiddenInput(['value' => 'folder'])->label(false) ?>
        <?php ActiveForm::end(); ?>
        </div>
        <div class="input-group">
            <input id="new-event" type="text" class="form-control" placeholder="Event Title">

            <div class="input-group-btn">
              <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
            </div>
                <!-- /btn-group -->
        </div>
          <!-- /input-group -->
    </div>
            </div>
            <div class="col-sm-9 cal-center">
                <div class="" id="calendar"></div>
                
            </div>
            <div class="col-sm-2" style="display: none">
                <div class="btn btns">
                    <div class="trash"></div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php
$createTaskUrl = Url::to(['task/dashboardcreate']);
$updateDropUrl = Url::to(['calendar/updateremoveafterdrop']);
$updateTaskGroupCheckUrl = Url::to(['calendar/updatetaskgroupcheckurl']);
$DropUrl = Url::to(['calendar/drop']);
$resizeDueDateUrl = Url::to(['calendar/resizeduedate']);
$UpdateOnDrop = Url::to(['calendar/updateondrop']);
$Taskgrouptask = Url::to(['calendar/taskgrouptask']);
$newEve = json_encode($events);
$calendarScript = <<<JS
    $(document).ready(function(){
        var eve = $newEve;
        console.log(eve);
        //function to inherit background from child
        $('.external-event').each(function() {
          var childColor = $(this).find(':first-child').css('background-color');
          console.log(childColor);
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
        
        //add task to task group
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
           
            $.ajax({
                url: '$createTaskUrl',
                type: 'POST',
                data: datas,
                success: function(response) {
                    console.log(response)
                    $('#dialog-ul').append("<li>"+$('#new-task').val()+"</li>")
                    $('#new-task').val('')
                    
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
            
            return false; 
        })

                      
                    
                
        $("#mycalendar-fc").click(function(){
                $( "#datepicker" ).show();
                $( "#datepicker" ).datepicker();
            })
            $('#dialog').dialog({
              autoOpen: false,
              modal:true,
              closeText: null
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
            init_events($('#external-events div.external-event'))
                  $('#calendar').fullCalendar({
                   header    : {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'month,agendaWeek,agendaDay'
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
                  select: function(start, end, jsEvent, view) {
                         // start contains the date you have selected
                         // end contains the end date. 
                         // Caution: the end date is exclusive (new since v2).
                         var allDay = !start.hasTime() && !end.hasTime();
                         alert(["Event Start date: " + moment(start).format(),
                                "Event End date: " + moment(end).format(),
                                "AllDay: " + allDay].join("<br />"));
                  },
                  events: eve,
                eventDragStop: function(event,jsEvent) {

                    var trashEl = jQuery('#external-events');
                    var ofs = trashEl.offset();

                    var x1 = ofs.left;
                    var x2 = ofs.left + trashEl.outerWidth(true);
                    var y1 = ofs.top;
                    var y2 = ofs.top + trashEl.outerHeight(true);

                    if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
                        jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
                        if (confirm("Are you sure to  detete " + event.title +" ?")) {
                            $('#calendar').fullCalendar('removeEvents', event._id);
                        }
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
    })
JS;
 
$this->registerJs($calendarScript);
?>
