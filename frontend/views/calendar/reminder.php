<?php
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use kartik\editable\Editable; 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use frontend\models\Reminder;
?>
<style type="text/css">
  .toggleButton {
  background-color: #fff !important;
  border-color: #ccc !important;
  box-shadow: none;  
  color: lightgrey !important;
  font-size: 17pt !important;
  float:right;
}

.toggleButtonActive {
  color: #0071c5;
  transition: color 0.3s;
}

.toggleButton:focus {
  box-shadow: none;
}


/* MLAF Style Snippet */
.toggleButton {
    display: inline-block;
    margin-bottom: 10px; /* Altered from 0 */
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 0px 3px;
    font-size: 15px;
    line-height: 1.5;
    border-radius: 2px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.toggleButton {
  color: #333;
  background-color: #fff;
  border-color: #ccc;
}
.toggleButton:focus,
.toggleButton.focus {
  color: #333;
  background-color: #e6e6e6;
  border-color: #8c8c8c;
}
.toggleButton:hover {
  color: #333;
  background-color: #e6e6e6;
  border-color: #adadad;
}
.toggleButton:active,
.toggleButton.active,
.open > .toggleButton.dropdown-toggle {
  color: #333;
  background-color: #e6e6e6;
  border-color: #adadad;
}
.toggleButton:active:hover,
.toggleButton:active:focus,
.toggleButton:active.focus,
.toggleButton.active:hover,
.toggleButton.active:focus,
.toggleButton.active.focus,
.open > .toggleButton.dropdown-toggle:hover,
.open > .toggleButton.dropdown-toggle:focus,
.open > .toggleButton.dropdown-toggle.focus {
  color: #333;
  background-color: #d4d4d4;
  border-color: #8c8c8c;
}
.toggleButton:active,
.toggleButton.active,
.open > .toggleButton.dropdown-toggle {
  background-image: none;
}
.toggleButton.disabled:hover,
.toggleButton.disabled:focus,
.toggleButton.disabled.focus,
.toggleButton[disabled]:hover,
.toggleButton[disabled]:focus,
.toggleButton[disabled].focus,
fieldset[disabled] .toggleButton:hover,
fieldset[disabled] .toggleButton:focus,
fieldset[disabled] .toggleButton.focus {
  background-color: #fff;
  border-color: #ccc;
}
.toggleButton .badge {
  color: #fff;
  background-color: #333;
}
.checkbox-reminder { display:none; } /* to hide the checkbox itself */
.checkbox-reminder + label:before {
  font-family: FontAwesome;
  display: inline-block;
}

.checkbox-reminder + label:before { content: "\f096"; } /* unchecked icon */
.checkbox-reminder + label:before { letter-spacing: 10px; } /* space between checkbox and label */

.checkbox-reminder:checked + label:before { content: "\f046"; } /* checked icon */
.checkbox-reminder:checked + label:before { letter-spacing: 5px; } /* allow space for check mark */

#add-update-reminder{
  margin-right:2px;
}
.reminder-notes{
  margin-right:52px;
  width:150px;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
</style>
<?php Pjax::begin(['id'=>'calendar-reminder-refresh']); ?>
<?php 
/*
 * This block of code is used to retrieve the reminders based on
 * 1. if the reminder is not deleted
 * 2. get the reminder time and explode the array to get the time part of the timestamp
 */
$arr = []; // defines the array to hold the reminder data retrieved
foreach ($reminders as $key => $reminder) { //loop through the reminders
    $exp = explode(' ', $reminder->reminder_time); //explode to get the date part of the timestamp
    $arr[]=$exp[0]; //date part retrieved
}
if(in_array($date,$arr)){ //render the reminder list if the date clicked has reminders already else display new form to create new reminder
foreach ($reminders as $key => $value) { // iterate to display each reminder
    if($value['deleted'] == Reminder::REMINDER_NOT_DELETED){ // make sure it is not deleted
        $exp = explode(' ',$value->reminder_time); //explode to get the date part
        if($exp[0] == $date){ //set the date
        $reminderz = $reminderModel::findOne($value->id);
?>
<div class="reminder-detail">
    <input class = "checkbox-reminder" id="box-<?=$value->id;?>" data-id ="<?=$value->id;?>" data-date ="<?=$value->reminder_time;?>" type="checkbox" />
    <label for="box-<?=$value->id;?>" id = "notes-<?=$value->id;?>" class="reminder-notes" style="margin-right:52px;width:150px;text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?= $value->notes; ?></label><span class="fa fa-bell" style="overflow:hidden"><span class=" dialog-bell" style="margin-left: 3px"><?= $value->reminder_time; ?></span></span><br>

</div>
   
		
<?php } } }?>
<?php Pjax::end(); ?>
     <p style="margin-top:12px;padding-top:3px;border-top: 1px solid #ccc">
            <button type="button" class="btn btn-default toggleButton" onclick=toggleClasses();>
                <i id="plus" class="fa fa-plus-square"></i>
                  / 
                <i id="minus" class="fa fa-minus-square toggleButtonActive"></i>
            </button>
            <div style="display:none" class="add-reminder-toggle">
                <h5 style="font-family: calibri">Add a new reminder</h5>
                <?php $form = ActiveForm::begin(['id' => 'reminderForm']); ?>
                <?= $form->field($reminderModel, 'notes')->textarea(['rows' => '2']) ?>
                <div class="row">
                <div class="col-sm-9" style="padding-right: 0px !important">
                <?= $form->field($reminderModel, 'reminder_time')->textInput(['maxlength' => true, 'id' => 'new-reminder-created', 'placeholder' => "e.g 12:30", 'class' => 'form-control'])->label('Set time') ?>
                </div>
                <div class="col-sm-2" style="padding: 25px 10px 0px 0px !important">
                <select style="height: 33px">
                  <option>AM</option>
                  <option>PM</option>
                </select>
                </div>
                </div>
                <p class="time-error" style="color:red;display: none">your time format is incorrect</p>

                <?= Html::submitButton('Add', ['class' => 'btn btn-primary btn-flat', 'id' => 'add-new-reminder']) ?>
                <?php ActiveForm::end(); ?>
            </div>
      </p>
<?php } else { ?>

        <h5 style="font-family: calibri">Add a new reminder</h5>
        <?php $form = ActiveForm::begin(['id' => 'reminderForm']); ?>
        <?= $form->field($reminderModel, 'notes')->textarea(['rows' => '2']) ?>
        <div class="row">
            <div class="col-sm-9" style="padding-right: 0px !important">
            <?= $form->field($reminderModel, 'reminder_time')->textInput(['maxlength' => true, 'id' => 'new-reminder-created', 'placeholder' => "e.g 12:30", 'class' => 'form-control'])->label('Set time') ?>
            </div>
            <div class="col-sm-2" style="padding: 25px 10px 0px 0px !important">
                <select style="height: 33px">
                    	<option>AM</option>
                    	<option>PM</option>
                </select>
            </div>
        </div>
        <p class="time-error" style="color:red;display: none">your time format is incorrect</p>

        <?= Html::submitButton('Add', ['class' => 'btn btn-primary btn-flat', 'id' => 'add-new-reminder']) ?>
        <?php ActiveForm::end(); ?>
<?php } ?>
<div style="display:none" class="update-reminder-toggle">
    <h5 style="font-family: calibri">Update reminder</h5>
        <?php $form = ActiveForm::begin(['id' => 'reminderUpdateForm']); ?>
        <?= $form->field($reminderModel, 'notes')->textarea(['rows' => '2','id' => 'note']) ?>
        <div class="row">
            <div class="col-sm-9" style="padding-right: 0px !important">
            <?= $form->field($reminderModel, 'reminder_time')->textInput(['maxlength' => true, 'id' => 'update-reminder-created', 'placeholder' => "e.g 12:30", 'class' => 'form-control'])->label('Set time') ?>
            </div>
        <div class="col-sm-2" style="padding: 25px 10px 0px 0px !important">
            <select style="height: 33px">
                <option>AM</option>
                <option>PM</option>
            </select>
        </div>
        </div>
        <p class="reminder-update-error"></p>

    <?= Html::submitButton('Update', ['class' => 'btn btn-primary btn-flat', 'id' => 'add-update-reminder']) ?>
    <button type="button" class="btn btn-danger btn-flat" id = 'delete-calendar-reminder'>Delete</button>
    <?php ActiveForm::end(); ?>

</div>

<?php
/*
 * Define all url path required for ajax calls
 */
$createReminderUrl  = Url::to(['reminder/create']);
$updateReminderUrl  = Url::to(['reminder/update']);
$getReminderDataUrl = Url::to(['reminder/updatereminder']);
$deleteReminderUrl  = Url::to(['reminder/deletecalendarreminder']);
$calendarReminderScript = <<<JS
//add new reminder

//put ellipses in reminder notes


$('#reminderForm').on('beforeSubmit',function(e){
    e.preventDefault();
    var dateValue = $('#reminder-dialog').attr('data-date');
    var datas = $(this).serializeArray();
    datas.push({name: 'date', value: dateValue});
     $.ajax({
        url: '$createReminderUrl',
        type: 'POST',
        data: datas,
        success: function(response) {
            var reminderArray = JSON.parse(response);
            if(response == 0){
                $('.time-error').show();
            } else {
                $('#reminderForm').find("input[type=text], textarea").val("");
                $('tr').find('[data-date =' + dateValue + ']').append('<span class="fa fa-bell" data-id="' + dateValue + '"></span>');
                
                //Create elements
            var event = $('<div />')
            var input = $("<input/>", {
          type: "checkbox",
          class: "checkbox-reminder",
          id: "box-"+reminderArray[0]
                });
                var label = $("<label/>", {
          for: "box-"+reminderArray[0],
          class: "reminder-notes",
          id: "notes-"+reminderArray[0]
                });
                var span = $("<span/>", {
                    class: "fa fa-bell"
                });
                var spanChild = $("<span/>", {
                    class: "dialog-bell"
                });
                span.css('overflow','hidden');
                spanChild.css('margin-left','3px');
                spanChild.text(reminderArray[2]);
                span.append(spanChild);
                label.text(reminderArray[1]);
                input.attr({"data-id":reminderArray[0],"date-date":reminderArray[2]})
     
          event.addClass('reminder-detail');
          event.append(input);
          event.append(label);
          event.append(span);
                $('.ui-dialog').find('[data-date =' + dateValue + ']').find('#calendar-reminder-refresh').append(event);
            }
            
        },
        error: function(res, sec){
          console.log('Something went wrong');
      }
    });
     return false; 
})

var plus = document.getElementById("plus");
var minus = document.getElementById("minus");
var className = 'toggleButtonActive';

//function to toggle classed to open and close new reminder form
function toggleClasses(){
    if(plus.classList.contains(className)){
        plus.classList.remove(className);
        minus.classList.add(className);
        $('.update-reminder-toggle').hide();
        $('.add-reminder-toggle').slideUp();

    } else {
        minus.classList.remove(className);
        plus.classList.add(className);
        $('.update-reminder-toggle').fadeOut();
        $('.checkbox-reminder').prop('checked',false);
        $('.add-reminder-toggle').slideDown();
    }
}

$(document).on('change','.checkbox-reminder',function(){

      var checked = $(this).is(':checked');
      $(".checkbox-reminder").prop('checked',false);
      if(checked) {
          $('.add-reminder-toggle').fadeOut();
          plus.classList.remove(className);
          minus.classList.add(className);
          $(this).prop('checked',true);
          var getId = $(this).attr('data-id');
          var getDateTime = $(this).attr('data-date');
          var getDate = getDateTime.split(' ');
          $('.update-reminder-toggle').attr('data-id',getId);
          $('.update-reminder-toggle').attr('data-date',getDate[0]);
          $.post('$getReminderDataUrl',
          {
            id:getId
          },
          function(data){
            var arr = JSON.parse(data)
            var getTime = arr[1].split(' ');
            $('.update-reminder-toggle').find('#note').val(arr[0]);
            $('.update-reminder-toggle').find('#update-reminder-created').val(getTime[1]);
            $('.update-reminder-toggle').slideDown();
          }
          )
      } else{
          $('.update-reminder-toggle').slideUp();
      }
});

//function to update reminder
$('#reminderUpdateForm').on('beforeSubmit',function(e){
      e.preventDefault();
      var id = $('.update-reminder-toggle').attr('data-id');
      var date = $('.update-reminder-toggle').attr('data-date');
      var datas = $(this).serializeArray();
      datas.push({name: 'date', value: date});
       $.ajax({
          url: '$updateReminderUrl&id='+id,
          type: 'POST',
          data: datas,
          success: function(response) {
              console.log(response)
              if(response == 1){
                var getNote = $("#note").val()
                $('label#notes-'+id).text(getNote);
                $('.reminder-update-error').text('updated successfully').css('color','green')
              } else {
                $('.reminder-update-error').text('something went wrong').css('color','red')
              }

          },
        error: function(res, sec){
            console.log('Something went wrong');
        }
      });
      return false; 
})

//delete reminder 
$('#delete-calendar-reminder').click(function(e){
      e.preventDefault();
      var id = $('.update-reminder-toggle').attr('data-id');
      var dateValue = $('#reminder-dialog').attr('data-date');
      $.post('$deleteReminderUrl',
          {
            id:id
          },
          function(data){
           if(data == 1){
            console.log('deleted');
            $('#box-'+id).parent().hide();
            $('.update-reminder-toggle').slideUp();
            $('tr').find('[data-id =' + dateValue + ']:last').remove();
           } else {
            console.log('something went wrong');
           }
          }
          )
})
JS;
 
$this->registerJs($calendarReminderScript);
?>