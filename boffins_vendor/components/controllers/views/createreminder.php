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
<style>
  .loading-add-rem{
    display: none;
    text-align: center;
  }
  .add-reminder{
    outline: none;
    display: block;
    background: rgba(0, 0, 0, 0.1);
    width: 100%;
    border: 0;
    border-radius: 4px;
    box-sizing: border-box;
    padding: 12px 20px;
    color: rgba(0, 0, 0, 0.6);
    font-family: inherit;
    font-size: inherit;
    font-weight: 500;
    line-height: inherit;
    transition: 0.3s ease;
  }
  .input-group-addon{
    border-radius: 4px;
    background: rgba(214, 213, 213, 0.6);
    border: 1px solid #ccc;
  }
  .rem-title{
    color: #6b808c;
  }
  .save-rem{
    border: none;
    width: 100%;
  }
  .rem-button{
    position: relative;
  }
</style>

<div class="reminder-form">

    <?php $form = ActiveForm::begin(['id' => 'save-rem-form'.$id]); ?>
    <h3 class="rem-title">Reminder</h3>
    <?php echo $form->field($reminder, 'reminder_time')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Select date','id' => 'save-rem'.$id,'class'=>'add-reminder'],
    'pluginOptions' => [
        'autoclose' => true,
    ]

    ]); ?>

    <?= $form->field($reminder, 'notes')->textarea(['maxlength' => true,'class' => 'add-reminder']) ?>
    <?= $form->field($taskremnider, 'task_id')->hiddenInput(['maxlength' => true, 'value' => $id])->label(false); ?>

    <div class="form-group rem-button">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success save-rem']) ?>
        <span class="loading-add-rem"><?= Yii::$app->settingscomponent->boffinsLoaderImage()?></span>
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
   $('.save-rem').hide();
    $('.loading-add-rem').show(); 
   thiss = $(this);
   setTimeout(function(){
          $.post('$reminderUrl',thiss.serialize())
            .always(function(result){
            toastr.success('Reminder set');
             $.pjax.reload({container:"#task-list-refresh"});
             $.pjax.reload({container:"#kanban-refresh",async: false});
            
            }).fail(function(){
            console.log('Server Error');
            });
    }, 5);
    return false;
});

Reminder;
 
$this->registerJs($reminderss);
?>

