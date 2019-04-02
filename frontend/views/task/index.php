<?/*php
use yii\helpers\Url; 
use boffins_vendor\components\controllers\CreateReminderWidget;
use boffins_vendor\components\controllers\AssigneeViewWidget;
use boffins_vendor\components\controllers\CreateLabelWidget;
use boffins_vendor\components\controllers\AddCardWidget;
use boffins_vendor\components\controllers\DeleteTaskWidget;
use boffins_vendor\components\controllers\FolderUsersWidget;
use boffins_vendor\components\controllers\EdocumentWidget;
$checkUrls = explode('/',yii::$app->getRequest()->getQueryParam('r'));
$checkUrlParams = $checkUrls[0];
?>
 <ul class="drag-list" id="kanban-board">
        <?php
        $count = 1; 
        foreach($taskStatus as $key => $value){ ?>
        <li class="drag-column drag-column-on-hold" id="holder<?= $value->id;?>" data-statusid="<?= $value->id; ?>">
            <span class="drag-column-header">
                <?= $value->status_title;?>
                <!-- <svg class="drag-header-more" data-target="options<?= $count; ?>" fill="#FFFFFF" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/</svg> -->
            </span>
                
            <div class="drag-options" id="options<?=$count;?>"></div>
            
            <ul class="drag-inner-list" id="<?=$count;?>" data-contain="<?= $value->id; ?>">
<?php
    $count2 = 1;
      if(!empty($taskclips)){
        foreach ($taskclips as $key => $values) {
          if($values->status_id == $value->id){
          $boardUrl = Url::to(['task/modal', 'id' => $values->id,'folderId' => $folderIds]);
          $reminderUrl = Url::to(['reminder/create']);
          $titleLength = strlen($values->title);
          $taskLabels = $values->labelNames;
          $edocuments = $values->clipOn['edocument'];
          $assigneesIds = $values->taskAssigneesUserId;
          $userid = Yii::$app->user->identity->id;
          //$listData=ArrayHelper::map($users,'id','username');
 ?>
<li data-filename="<?= $values->id;?>" id="test_<?= $values->id; ?>" class="drag-item <?= ($userid == $values->owner || in_array($userid, $assigneesIds)) ?  '' : 'no-drag'?> test_<?= $values->id;?>">
  <?= EdocumentWidget::widget(['docsize'=>100,'target'=>'kanban'.$values->id, 'textPadding'=>17,'referenceID'=>$values->id,'reference'=>'task','iconPadding'=>10,'tasklist'=>'for-kanban', 'edocument' => 'dropzone']);?>
  <div class="task-test task-kanban_<?= $values->id;?>" style="margin-bottom: <?= empty($taskLabels) && ($titleLength > 43) && !empty($edocuments) ? '15' : 0; ?>px" value ="<?= $boardUrl; ?>">
      <div class="task-title" id="task-title<?=$values->id;?>">
        <span class="task-titles"><?= strip_tags($values->title); ?></span>
      </div>
      <?php if(!empty($values->personName)){ ?>
      <div class="assignedto assignedto<?=$values->id;?>" id="">
         <?= FolderUsersWidget::widget(['attributues'=>$values->taskAssignees,'removeButtons' => false, 'dynamicId' => $values->id, 'taskModal' => 'modal-users'.$values->id]);?>
      </div>
    <?php }?>
    <div class="holder-board" id="holder-board<?=$values->id;?>">
      <?php
        if(!empty($edocuments)){?>
            <span class="edoc-count" id="edoc-count<?=$values->id;?>" aria-hidden="true" data-toggle="tooltip" title="Attachments" style="top:<?= !empty($values->personName) && empty($values->labelNames) ? '-32px' : '3px'; ?>">
              <? 
                $edocs = count($edocuments); 
                echo $edocs;
              ?>
              <i class="fa fa-file-text-o time-icon" aria-hidden="true"></i>
            </span>
      <?php }?>
      <?php if(!empty($values->labelNames)){ ?>
        <div class="task-label-title" style="width: <?= !empty($edocuments) ? '90' : '100';?>%">
          <span class="label-task" id="label<?=$values->id.$count?>">
            <?= $values->labelNames; ?>
          </span>                        </div>
      <?php } ?>
    </div>
      <?php 
      $time = $values->reminderTime;
      $timers = explode(",",$time);
      $check = date("Y-m-d H:i:s");
      $timeNow = strtotime($check);
      $closest = $values->closestReminder($timers, $check);
      $reminders = date('M j, g:i a', strtotime($closest));
        if(!empty($time) && strtotime($closest) >= $timeNow){ ?>
        <div class="reminder-time">
            <i class="fa fa-bell time-icon"></i>
            <span class="date-time" aria-hidden="true" data-toggle="tooltip" title="Reminder">
              <?= $reminders; ?>
            </span>
          </div>
      <?php } ?>
      <?php if(!empty($values->due_date)){ ?>
      <div class="due-date">
        <span class="glyphicon glyphicon-time time-icon"></span>
          <?php
            $date = $values->due_date;
            $date = date('M j, g:i a', strtotime($date));
            $boardDate = date('M j', strtotime($date))
          ?>
          <span class="date-time" aria-hidden="true" data-toggle="tooltip" title="Due: <?=$date; ?>">
            <?= $boardDate; ?>
          </span>
      </div>
    <?php } ?>
</div>
  
    <div class="bottom-content">
      <div class="confirm <?= ($userid == $values->owner || in_array($userid, $assigneesIds)) ?  'has-access' : 'no-access'?> test_<?= $values->id;?>">
      <div class="dropdown testdrop">
        <a class=" dropdown-toggle drop-icon" type="button" id="dropdownMenuButton_<?= $values->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell icons" aria-hidden="true" data-toggle="tooltip" title="Add reminder"></i></a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <?= CreateReminderWidget::widget(['reminder' => $reminder,'id'=> $values->id,'reminderUrl'=> $reminderUrl]) ?>
        </div>
      </div>
      <?php if($checkUrlParams == 'folder' || $checkUrlParams == 'task'){?>
        <div class="dropdown testdrop">
          <a class=" dropdown-toggle drop-icon" type="button" id="dropdownMenuButton_<?= $values->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-plus icons" aria-hidden="true" data-toggle="tooltip" title="Assign task"></i></a>
          <div class="dropdown-menu assigndrop" aria-labelledby="dropdownMenuButton">
              <?= AssigneeViewWidget::widget(['users' => $users, 'taskid' => $values->id, 'assigneeId' => $count]) ?>  
          </div>
        </div>
      <?php }?>
      <div class="dropdown testdrop">
        <a class=" dropdown-toggle drop-icon" type="button" id="dropdownMenuButton_<?= $values->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tags icons" aria-hidden="true" data-toggle="tooltip" title="Add label"></i></a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
         <?= CreateLabelWidget::widget(['id' => $count,'label' => $label, 'taskLabel' => $taskLabel, 'taskid' => $values->id, 'labelId' => $count]) ?>
        </div>
      </div>
      <div class="dropdown testdrop">
        <a class=" dropdown-toggle drop-icon" type="button" id="dropdownMenuButton_<?= $values->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-trash icons" aria-hidden="true" data-toggle="tooltip" title="Delete task"></i></a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
         <?= DeleteTaskWidget::widget(['id' => $count,'taskid' => $values->id]) ?>
        </div>
      </div>
      </div>
    </div>
</li>
<?php $count2++;}}}?>

</ul>
            <?php if($checkUrlParams == 'folder' || $checkUrlParams == 'task'){?>
              <a class="add-card" href="#">
                <span class="cardTask">
                  <span class="glyphicon glyphicon-plus"></span>
                  <span class="add-title"> Add Task </span>
                </span>
              </a>
              <div class="card-add" id="add-new-cardz">
                  <?= AddCardWidget::widget(['id' => $count,'taskModel' => $task, 'statusid' => $value->id,'parentOwnerId' => $folderIds]) ?>
              </div>
            <?php }?>
        </li>
        <?php $count++;} ?>
    </ul> */