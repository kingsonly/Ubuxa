<?php 
  use boffins_vendor\components\controllers\KanbanWidget;
  use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id'=>'kanban-refresh']); ?>
<div class="close-kanban">
  <a class="closebtn kanban-board-app">&times;</a>
  
    <?= KanbanWidget::widget(['dataProvider' => $dataProvider, 'folderIds' => $folderIds, 'users'=>$users, 'taskStatus' => $taskStatus, 'task' => $task, 'reminder' => $reminder, 'taskAssignedUser' => $taskAssignedUser,'label' => $label, 'taskLabel' => $taskLabel]) ?>
    
</div>



<?
$board = <<<JS

$('.closebtn').click(function(){
  $('.board-open').removeClass('board-opened');
  $('.board-open').addClass('board-closed');
  $('#mySidenav').css({'width':'0'})
  $('body').toggleClass('noscroll')
});
JS;
$this->registerJs($board);
?>
<?php Pjax::end(); ?>