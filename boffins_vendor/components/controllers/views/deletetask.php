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
  .for-edoc-loader{
  position: relative;
}
.text-delete{
  padding: 0 12px 12px;
}
.confirm-doc-delete{
  background-color: #eb5a46;
  /*box-shadow: 0 1px 0 0 #b04632;*/
  border: none;
  width: 100%;
}
.delete-header-holder{
  height: 40px;
  position: relative;
  margin-bottom: 8px;
  text-align: center;
}
.delete-header{
  box-sizing: border-box;
  color: #6b808c;
  display: block;
  line-height: 40px;
  border-bottom: 1px solid rgba(9,45,66,.13);
  margin: 0 12px;
  overflow: hidden;
  padding: 0 32px;
  position: relative;
  text-overflow: ellipsis;
  white-space: nowrap;
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
$boardUrl = Url::to(['task/board']);
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
                    var folderId = $('.board-specfic').attr('data-folderId');
                    $.pjax.reload({container:"#kanban-refresh",replace: false, async:false, url: '$boardUrl&folderIds='+folderId});
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