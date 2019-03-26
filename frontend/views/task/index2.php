<?php 
use yii\helpers\Url;
use frontend\models\Task;
use boffins_vendor\components\controllers\EdocumentWidget;



if(!empty($tasks)){
  $array = Task::sortTaskList($tasks);
}
    $id = 1;
    if(!empty($array)){
    foreach ($array as $key => $value) { 
      $assigneesIds = $value->taskAssigneesUserId;
      $userid = Yii::$app->user->identity->id;
      //$taskBoard = Url::to(['task/modal', 'id' => $value->id,'folderId' => $folderId]);
    ?>
  <div class="todo">
        <input class="todo_listt<?= $value->id; ?> todo__state <?= ($userid == $value->owner) || in_array($userid, $assigneesIds) ?  'has-access' : 'no-access'?>" data-id="<?= $value->id; ?>" id="todo-list<?= $value->status_id; ?>" type="checkbox" <?= $value->status_id == Task::TASK_COMPLETED ? 'checked' : '';?>/>
    <?= EdocumentWidget::widget(['docsize'=>84,'target'=>'tasklist'.$value->id, 'textPadding'=>18,'referenceID'=>$value->id,'reference'=>'task','iconPadding'=>1,'tasklist'=>'hidetasklist', 'edocument' => 'dropzone']);?>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon" id="task-box">
      <use xlink:href="#todo__line" class="todo__line"></use>
      <use xlink:href="#todo__box" class="todo__box"></use>
      <use xlink:href="#todo__check" class="todo__check"></use>
      <use xlink:href="#todo__circle" class="todo__circle"></use>
    </svg>
    <div class="todo__text" value ="<?//=$taskBoard;?>">
        <?php
          $edocLists = $value->clipOn['edocument'];
          if(!empty($edocLists)){?>
              <span class="edoc-list" aria-hidden="true" data-toggle="tooltip" title="Attachments">
                <? 
                  $edoc = count($edocLists); 
                  echo $edoc;
                ?>
                <i class="fa fa-file-text-o time-icon" aria-hidden="true"></i>
              </span>
        <?php }?>
        <span><?= strip_tags($value->title); ?></span>
    </div>
    
  </div>

  <?php $id++;}}else{
    echo "No task";
  }?>