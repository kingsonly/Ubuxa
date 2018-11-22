<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use frontend\models\TaskReminder;
$taskremnider = new TaskReminder();

/* @var $this yii\web\View */
/* @var $model frontend\models\Reminder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reminder-form">

    <?php $form = ActiveForm::begin(['id' => 'save-rem-form'.$id]); ?>
    <h3>Reminder</h3>
    <?php echo $form->field($reminder, 'reminder_time')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Select date','id' => 'save-rem'.$id,],
    'pluginOptions' => [
        'autoclose' => true,
    ]

    ]); ?>

    <?= $form->field($reminder, 'notes')->textarea(['maxlength' => true]) ?>
    <?= $form->field($taskremnider, 'task_id')->hiddenInput(['maxlength' => true, 'value' => $id])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success save-rem']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$reminderss = <<<Reminder

function _CreateReminder(task){
          $.ajax({
              url: '$reminderUrl',
              type: 'POST', 
              data: {
                  id: task,
                },
              success: function(res, sec){
                   console.log('task sent');
              },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
          });





}

$("#save-rem-form"+'$id').on('beforeSubmit', function (e) {
    
   thiss = $(this);
          $.post('$reminderUrl',thiss.serialize())
            .always(function(result){
            jsonResult = result;
           if(jsonResult.message == 'sent'){
                    options = {
                      "closeButton": true,
                      "debug": false,
                      "newestOnTop": true,
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "preventDuplicates": true,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "5000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut",
                      "tapToDismiss": false
                    }
                //toastr.success('Folder was created successfully', "", options);
                $.pjax.reload({container:"#task-list-refresh",async: false});
                $.pjax.reload({container:"#kanban-refresh",async: false});
                //$.pjax.reload({container:"#task-modal-refresh",async: false});

            }else{
                    options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": true,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": true,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut",
          "tapToDismiss": false
          }
          //alert(jsonResult);
        toastr.success('Reminder set');
             $.pjax.reload({container:"#task-list-refresh"});
             $.pjax.reload({container:"#kanban-refresh",async: false});
            }
            }).fail(function(){
            console.log('Server Error');
            });
});

Reminder;
 
$this->registerJs($reminderss);
?>

