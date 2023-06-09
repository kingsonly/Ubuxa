<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use boffins_vendor\components\controllers\FolderUsersWidget;
use boffins_vendor\components\controllers\AssigneeViewWidget;
use boffins_vendor\components\controllers\CreateLabelWidget;
use boffins_vendor\components\controllers\EdocumentWidget;
use boffins_vendor\components\controllers\ViewEdocumentWidget;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use frontend\models\Reminder;
use yii\bootstrap\Modal;
use frontend\models\StatusType;
$taskUrl = Url::to(['task/view']);
?>

<style>
#task-details-cont {
    width: 100%;
}
#task-title-cont{
  width: 100%;
}
.panel{
    border: none;
}
.X{
    margin-left: 10px !important;
    margin-right: 10px !important;
}


.timestamp {
    color: #707070;
    font-size: 12px;
    line-height: 1.33333333333333;
}
.createDate {
    margin-bottom: 5px;
    margin-top: 10px;
}

#task-details-targ{
    background: none;
    border: none;
    text-align: left !important;
    width: 100%;
    overflow: hidden;
    display: inline-block;
    color: black;
    display: inline-block;
}
#task-details-targ:hover{
    background-color: #ccc;
}
.task-titlez {
    margin-bottom: 10px;
}
.task-detailzz {
    display: block;
    margin: 0 8px 8px 0;
    max-width: 100%;
    margin-right: 8px;
    min-width: 140px;
    clear: left;
}
.assignContent {
    margin-bottom: 5px;
}
.assignUsers {
    color: #6b808c;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: .04em;
    line-height: 16px;
    margin-top: 16px;
    text-transform: uppercase;
    /* display: block; */
    line-height: 20px;
    margin: 0px 2px 4px 0;
}
.moreusers{
    border-radius: 2px;
    color: #6b808c;
    cursor: pointer;
    margin: 0 8px 8px 0;
    transition-property: background-color,border-color,box-shadow;
    transition-duration: 85ms;
    transition-timing-function: ease;
    margin-right: 0px;
    padding-left: 5px;
}
.taskdrop {
    background-color: rgba(9,45,66,.08);
    padding: 0px;
}
.modal-content {
    background-color: #ecf0f1;
}

.addUserz {
    padding: 5px;
    font-size: 12px;
    padding-right: 10px;
}

.addLabels {
    padding: 5px;
    font-size: 12px;
    padding-right: 10px;
}

.allassignees {
    display: block;
    margin: 0 8px 8px 0;
    max-width: 100%;
    margin-right: 8px;
    min-width: 140px;
    float: left;
}
.task-labels {
    /* margin-top: 15px; */
}
.task-details-title{
    color: #6b808c;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: .04em;
    line-height: 16px;
    margin-top: 16px;
    text-transform: uppercase;
    line-height: 20px;
    margin: 0px 2px 4px 0;
}
.all-status {
    margin-bottom: 10px;
    float: right;
    margin-right: 30px;
}
.stat-title {
    color: #6b808c;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: .04em;
    line-height: 16px;
    margin-top: 16px;
    text-transform: uppercase;
    line-height: 20px;
    margin: 0px 2px 4px 0;
}
.task-titless {
    font-weight: 500;
}
.reminder-title {
    color: #6b808c;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: .04em;
    line-height: 16px;
    margin-top: 16px;
    text-transform: uppercase;
    line-height: 20px;
    margin: 0px 2px 4px 0;
}
.alldates {
    display: block;
    max-width: 100%;
}
.all-labels{
    margin-bottom: 10px;
}
.label-reminder {
    display: flex;
    flex-wrap: nowrap;
    -webkit-flex-wrap: nowrap;
    display: -ms-flexbox;
    display: -moz-flex;
    display: -webkit-flex;
    overflow: scroll;
}
.multi-reminder {
    min-width: 160px;
}

/*-- For document view--*/

#boardContent{
  overflow: scroll !important;
}
.no-access{
    pointer-events: none;
}
.assigntask{
    width: 350px;
}
.list-name:hover{
    background-color: unset !important;
    text-decoration: none;
}
.task-label{
    width: 250px;
    padding-left: 10px;
    padding-right: 10px;
}
</style>
    <div class="task-view <?= ($userid == $model->owner || in_array($userid, $assigneesIds)) ?  'has-access' : 'no-access'?>">

        <div class="task-titlez">
        <?= ViewWithXeditableWidget::widget(['model'=>$model,'pjaxId'=>'#kanban-refresh', 'taskId' => $model->id, 'folderId'=> $folderId,'attributues'=>[
                        ['modelAttribute'=>'title'],
                        ]]); ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="alldates">
                    <div class="due-dates">
                        <span class="glyphicon glyphicon-time"></span>
                        <span class="assignUsers">Due Date</span>
                    </div>    
                    <div class="due-labels">
                        <span class="label-date"><?= ViewWithXeditableWidget::widget(['model'=>$model, 'pjaxId'=>'#kanban-refresh','attributues'=>[
                                ['modelAttribute'=>'due_date','xeditable' => 'datetime'],
                                ]]); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="all-status">
                    <div class="task-statuz">
                        <span class="stat-title">Status</span>
                    </div>
                    <?php Pjax::begin(['id'=>'status']); ?>
                        <div class="task-status">
                            <!-- <span class="task-titless"><?//= $model->statusTitle; ?></span> -->
                            <span class=""><?= ViewWithXeditableWidget::widget(['model'=>$model, 'data' => $statusData,'taskUrl' => $taskUrl,'taskId'=>$model->id,'folderId' => $folderId, 'pjaxId'=>'#kanban-refresh','folderId'=> $folderId,'displayValue' => $model->statusTitle, 'attributues'=>[
                                    ['modelAttribute'=>'status_id','xeditable' => 'dropdown'],
                                    ]]); ?></span>
                        </div>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
        
            <div class="allassignees">
                <div class="assignContent">
                    <span class="assignUsers">Assignees</span>
                    <span class="dropdown taskdrop">
                             <a class="dropdown-toggle drop-assignee moreusers" type="button" id="dropdownMenuButtont" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-plus addUserz" aria-hidden="true" data-toggle="tooltip" title="Assign Users"></span>
                            </a> 
                                <div class="dropdown-menu assigntask" aria-labelledby="dropdownMenuButton">
                                        <?= AssigneeViewWidget::widget(['users' => $users, 'taskid' => $model->id]) ?>  
                                </div>
                    </span>
                </div>
                <div id="memberz">
                </div>
                    <?php if(!empty($model->taskAssignees)){?>
                            <div class="assignedto assignedto<?=$model->id;?>" id="">
                                <?= FolderUsersWidget::widget(['attributues'=>$model->taskAssignees,'removeButtons' => false, 'dynamicId' => $model->id, 'taskModal' => 'modal-users']);?>
                            </div>
                    <?php } ?>
            
            </div>
        
        
            <div class="all-labels">
                <div class="assignContent">
                    <span class="assignUsers">Labels</span>
                    <span class="dropdown taskdrop">
                         <a class="dropdown-toggle drop-labels moreusers" type="button" id="dropdownMenuButtont" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-plus addLabels" aria-hidden="true" data-toggle="tooltip" title="Add Label"></span>
                        </a> 
                            <div class="dropdown-menu task-label" aria-labelledby="dropdownMenuButton">
                                <?= CreateLabelWidget::widget(['id' => $model->id,'label' => $label, 'taskLabel' => $taskLabel, 'taskid' => $model->id]) ?>  
                            </div>
                    </span>
                </div>  
                <?php Pjax::begin(['id'=>'task-modal-labels']); ?>
                    <div class="task-labels">
                        <?php if(!empty($model->labelNames)){ ?>
                            <span class="label-task"><?= $model->labelNames; ?></span>
                        <?php } ?>
                    </div>
                <?php Pjax::end(); ?>
            </div>
    <div class="task-detailzz">
        <div>
            <span class="glyphicon glyphicon-tasks"></span>
            <span class="task-details-title">Details</span>
        </div>
           <div class="task-detailz">
                       <?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
                        ['modelAttribute'=>'details','xeditable' => 'notes'],
                        ]]); ?>
           </div>
    </div>
    <div class="folder-specific-board" data-taskId = '<?=$model->id;?>' data-folderId = '<?=$folderId;?>'>
    <?= EdocumentWidget::widget(['docsize'=>95,'target'=>'taskboard','attachIcon'=>'yes','textPadding'=>20,'referenceID'=>$model->id,'reference'=>'task','iconPadding'=>10, 'edocument' => 'dropzone']);?>
    <?php if(!empty($model->reminderTimeTask)){ ?>
    <div class="allreminder">
            <div class="reminder-dates">
                <i class="fa fa-bell icons"></i>
                <span class="reminder-title">Reminder</span>
            </div>    
            <div class="reminder-labels">
                <span class="label-reminder">
                    <?php 
                    $reminders = $model->reminderTimeTask;
                    $count = 1;
                     foreach ($reminders as $reminder) {
                       ${'model'.$count}= new Reminder();
                        ${'model1'.$count} = ${'model'.$count}->findOne($reminder->id);
                    ?>
                        <?= ViewWithXeditableWidget::widget(['model'=>${'model1'.$count}, 'pjaxId'=>'#kanban-refresh','attributues'=>[
                        ['modelAttribute'=>'reminder_time','xeditable' => 'datetime'],
                        ],'xEditableDateId' => $count]); ?>
                    <?php $count++; }?>
                    </span>                    
                    
            </div>
        </div>
    </div>
    <?php }?>
    <?php Pjax::begin(['id'=>'task-edoc']); ?>
        <?php if(!empty($edocument)){?>
        <h4>Files</h4>
            <div class="edocument-view" data-taskId = '<?=$model->id;?>' data-folderId = '<?=$folderId;?>'>
                <?= ViewEdocumentWidget::widget(['edocument' => $edocument, 'target' => 'task']);?>
            </div>
        <?php }?>
    <?php Pjax::end(); ?>
    <div data-taskId = '<?=$model->id;?>' data-folderId = '<?=$folderId;?>'>
        <?= EdocumentWidget::widget(['referenceID'=>$model->id,'reference'=>'task','edocument' => 'clickUpload','target' => 'modalUpload', 'attachIcon' => 'yes']);?>
    </div>
  
    <div class ="timestamp">
        <div class="createDate">
            <span>Created <?= $model->timeElapsedString;?> by <?=$model->ownerName;?></span>
        </div>
    <?php if($model->completion_time != NULL && $model->in_progress_time !=NULL && $model->status_id == $model::TASK_COMPLETED){ ?>
        <div>
            Task completed in <?= $model->timeCompletion; ?>
        </div>
    <?php } ?>
    </div>
</div>



<?
$folderIds = $folderId;
$boardUrl = Url::to(['task/board']);
$taskmodal = <<<JS

$('#boardContent').on('hide.bs.modal', function () {
  /*setTimeout(function(){
    $.pjax.reload({container:"#kanban-refresh",replace: false, async:false, url: '$boardUrl&folderIds=$folderIds'});
  }, 200);*/
});

JS;
$this->registerJs($taskmodal);
?>