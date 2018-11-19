<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Reminder */
/* @var $form yii\widgets\ActiveForm */
?>
<span>Are you sure you want to delete this task?</span>
<?= Html::button('Delete', ['class' => 'btn btn-success delete-task', 'name' => 'add', 'id' => 'delete-task'.$id, 'data-taskid' => $taskid]) ?>


<?php
$deleteTaskUrl = Url::to(['task/delete']);
$deleteTask = <<<JS

$(".delete-task").on('click',function(e) {
    var taskid;
    taskid = $(this).data('taskid');
    console.log(taskid)
    _deleteTask(taskid);        
});

function _deleteTask(taskid){
        $.ajax({
              url: '$deleteTaskUrl',
              type: 'POST', 
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