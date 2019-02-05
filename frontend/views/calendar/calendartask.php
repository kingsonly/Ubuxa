<?php
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use kartik\editable\Editable; 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\models\Task;
use frontend\models\Calendar;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\widgets\Pjax;

$taskModel = new Task();

?>
<style type="text/css">
#ui-dialog-title{
	text-transform: uppercase !important;
	font-family: calibri !important;
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

.taskUpdate{
	display: none;
}
#update-task{
	width:314px;
	margin-bottom:2px;
}
#date-time-update{
	display: none;
}
.task-element{
	border-bottom: 1px solid #ccc;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
}
.dialog-bell{
	color:#b78181;
}
.parent{
	max-height: 260px;
	overflow-y: scroll;
}
.task-element{
	/*z-index:1005;
	background: #fff;
	cursor: move;
	*/
}
#calendar-task-delete{
	float: right;
    margin-right: 9px;
    color: #d07777;
    cursor: pointer;
}
</style>
<?php Pjax::begin(['id'=>'calendar-task-refresh']); ?>
<div class="parent" id="parent">
<?php
foreach ($taskGroup->taskTitle as $key => $value) {
	if($value['deleted'] == Calendar::TASK_NOT_DELETED){
?>
	<div class="task-element">
		<input class = "checkbox-task" id="task-<?=$value['id'];?>" data-id ="<?=$value['id'];?>" type="checkbox" />
        <label for="task-<?=$value['id'];?>" id = "notes-<?=$value->id;?>" class="reminder-notes" style=""><?= strip_tags($value['title']);?></label>
        	<p><span class="fa fa-calendar-check-o" style="font-size: 13px; font-family: calibri; margin:0px -1px">
        		<span class=" dialog-bell" id = "date-<?=$value->id;?>" style="margin-left: 3px"><?= date("F jS, Y", strtotime($value['in_progress_time'])); ?></span>
        	</span>
        	<span class="fa fa-trash calendar-task-delete" id="calendar-task-delete" data-id ="<?=$value['id'];?>"></span>
        	</p>
     </div>
<?php 
} }
?>
</div>
<?php Pjax::end(); ?>
<div class="taskUpdate">
<input type="hidden" autofocus="true" />
<?php $form = ActiveForm::begin(['id' => 'taskupdateform']); ?>
<?= $form->field($taskModel, 'title')->hiddenInput(['maxlength' => true, 'id' => 'new-calendar-task-created', 'placeholder' => "Event Title", 'class' => 'form-control'])->label(false) ?>
<?= $form->field($taskModel, 'in_progress_time')->hiddenInput(['maxlength' => true, 'id' => 'new-time-created', 'placeholder' => "Update Date", 'class' => 'form-control'])->label(false) ?>
<div class="input-group">
	<input id="update-task" type="text" class="form-control" placeholder="update this task">
    <!-- /btn-group -->
</div>

<div class="input-group" id = "date-time-update">
	 <?php echo $form->field($taskModel, 'in_progress_time')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Select date','id' => 'save-rem',],
    'pluginOptions' => [
        'autoclose' => true,
    ]

    ]); ?>
	<div class="input-group-btn" style="font-size: 14px">
	  <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'id' => 'update-new-task']) ?>
	</div>
</div>

<?php ActiveForm::end(); ?>
</div>
<div class="domDiv" style="display: none"></div>
<p class="task-update-error"></p>
<?php
/*
 * Define all URL path that with be used for ajax calls
 */
$getTaskUpdateDataUrl     = Url::to(['task/updatetask']); // get the update task url
$updateTaskUrl            = Url::to(['task/calendartaskupdate']); // update calendar task url
$deleteCalendarTaskUrl    = Url::to(['task/calendartaskdelete']); //URL to delete calendar task
$calendarTaskUpdateScript = <<<JS

//hide first task element with its line break which is the same with the task title

$('.parent').find('div').first().remove();
$('.parent').find('br').first().remove();

//show create task form on document ready
$('.input-task-group').show();

//toggle date time form on keyup
$('input#update-task').keyup(function(){
		$('#date-time-update').slideDown();
		var getVal = $(this).val();
		$('#new-calendar-task-created').val(getVal);
})

$(document).on('change','.checkbox-task',function(){
            var checked = $(this).is(':checked');
            $(".checkbox-task").prop('checked',false);
            var getId = $(this).attr('data-id');
            if(checked) {
                $(this).prop('checked',true);
                $('.taskUpdate').attr('data-id',getId);
                $(document).find('#input-task-group').fadeOut();
                var getId = $(this).attr('data-id');
                $.post('$getTaskUpdateDataUrl',
                {
                  id:getId
                },
                function(data){
                	var arr = JSON.parse(data);
                	$('#update-task').val(arr[0])
                	$('#save-rem').val(arr[1]);
            		$('.taskUpdate').slideDown();
                }
                )
            } else{
                $('.taskUpdate').slideUp();
                $('.task-update-error').text('');
                $(document).find('#input-task-group').fadeIn();
            }
        });

        $('#taskupdateform').on('beforeSubmit',function(e){
            e.preventDefault();
            var id = $('.taskUpdate').attr('data-id');
            var datas = $(this).serializeArray();
             $.ajax({
                url: '$updateTaskUrl&id='+id,
                type: 'POST',
                data: datas,
                success: function(response) {
                    console.log(response);
                    if(response == 1){
                      var getNote = $("#update-task").val()
                      var getDate = $("#save-rem").val()
                      var dateString = new Date(getDate);
                      dateString = new Date(dateString).toUTCString();
					  dateString = dateString.split(' ').slice(1, 4).join(' ');
                      $('label#notes-'+id).text(getNote);
                      $('span#date-'+id).text(dateString);
                      $('.task-update-error').text('updated successfully').css('color','green')
                    } else {
                      $('.task-update-error').text('something went wrong').css('color','red')
                    }
                    
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
             return false; 
        })

        //delete calendar task
        $('.calendar-task-delete').click(function(e){
			e.preventDefault();
			var element = $(this);
			var taskId = element.attr('data-id');
			$.post('$deleteCalendarTaskUrl',
	        {
	          id:taskId
	        },
	        function(data){
	        	element.parent().parent().hide();
	        }
	        )
		})

        //add draggable to task list elements
        //$('.task-element').draggable({
        //	helper: 'clone',
		//    revert: 'true',
		//    appendTo: 'body'
        //	});
JS;
 
$this->registerJs($calendarTaskUpdateScript);
?>