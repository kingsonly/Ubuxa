<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Reminder */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
  .loading-delete-task{
    display: none;
    text-align: center;
  }
</style>
<div class="delete-header-holder">
  <span class="delete-header">
    Confirm Delete
  </span>
</div>
<div class="text-delete">
  <div class="for-edoc-loader">
    <p>Are you sure you want to delete this task?</p>
    <span class="for-task-loader">
      <?php $form = ActiveForm::begin(['action'=>Url::to(['task/delete'])]); ?>
      <?= Html::button('Delete', ['class' => 'btn btn-success delete-task confirm-doc-delete', 'name' => 'add', 'id' => 'delete-task'.$id, 'data-taskid' => $taskid]) ?>
      <?php ActiveForm::end(); ?>
       <span class="loading-delete-task"><?= Yii::$app->settingscomponent->boffinsLoaderImage()?></span>
  </span>
  </div>
</div>


<?php
$deleteTaskUrl = Url::to(['task/delete']);
$deleteTask = <<<JS

$(".delete-task").on('click',function(e) {
    var taskid;
    taskid = $(this).data('taskid');
    console.log(taskid)
    $('.delete-task').hide();
    $('.loading-delete-task').show();
    _deleteTask(taskid);        
});

function _deleteTask(taskid){
        $.ajax({
              url: '$deleteTaskUrl',
              type: 'POST',
              async: false,
              data: {
                  task_id: taskid, 
                },
              success: function(res, sec){
                    toastr.success('Task Deleted');
                    $.pjax.reload({container:"#kanban-refresh",async: false});
                    $.pjax.reload({container:"#task-list-refresh"});
                   //console.log('Task Deleted');
              },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
    	});
}

JS;
$this->registerJs($deleteTask);
?>