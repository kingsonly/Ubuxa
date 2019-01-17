<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use boffins_vendor\components\controllers\FolderUsersWidget;
use boffins_vendor\components\controllers\AssigneeViewWidget;
use boffins_vendor\components\controllers\CreateLabelWidget;
use boffins_vendor\components\controllers\EdocumentWidget;
use yii\widgets\Pjax;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use frontend\models\Reminder;


?>

<style>
#task-details-cont {
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
    margin-bottom: 5px
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
    padding: 6px;
}
.modal-content {
    background-color: #ecf0f1;
}
.members {
    margin-left: 10px;
    margin-top: 10px;
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
</style>

    <div class="task-view">

        <div class="task-titlez">
        <?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
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
                        <span class="label-date"><?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
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
                    <div class="task-status">
                        <span class="task-titless"><?= $model->statusTitle; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!empty($model->taskAssignees)){?>
            <div class="allassignees">
                <div class="assignContent">
                    <span class="assignUsers">Assignees</span>
                    <!--<span class="dropdown taskdrop">
                             <a class="dropdown-toggle drop-assignee moreusers" type="button" id="dropdownMenuButtont" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-plus addUserz" aria-hidden="true" data-toggle="tooltip" title="Assign Users"></span>
                            </a> 
                                <div class="dropdown-menu assigntask" aria-labelledby="dropdownMenuButton">
                                        <?//= AssigneeViewWidget::widget(['users' => $users, 'taskid' => $model->id]) ?>  
                                </div>
                    </span> -->
                </div>
                

                    <div class="members">
                        <?= FolderUsersWidget::widget(['attributues'=>$model->taskAssignees,'removeButtons' => false]);?>
                    </div>
            </div>
        <?php } ?>
        <?php if(!empty($model->labelNames)){ ?>
            <div class="all-labels">
                <div class="assignContent">
                    <span class="assignUsers">Labels</span>
                    <!--<span class="dropdown taskdrop">
                         <a class="dropdown-toggle drop-labels moreusers" type="button" id="dropdownMenuButtont" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-plus addLabels" aria-hidden="true" data-toggle="tooltip" title="Add Label"></span>
                        </a> 
                        <div class="dropdown-menu task-label" aria-labelledby="dropdownMenuButton">
                            <?//= CreateLabelWidget::widget(['id' => $model->id,'label' => $label, 'taskLabel' => $taskLabel, 'taskid' => $model->id]) ?>  
                        </div>
                    </span> -->
                </div>  
                  
                    <div class="task-labels">
                        <span class="label-task"><?= $model->labelNames; ?></span>
                    </div>
            </div>
        <?php } ?>
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
    <?= EdocumentWidget::widget(['docsize'=>565,'target'=>'taskboard','attachIcon'=>'yes','textPadding'=>20,'referenceID'=>$model->id,'reference'=>'task']);?>
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
                        <?= ViewWithXeditableWidget::widget(['model'=>${'model1'.$count},'attributues'=>[
                        ['modelAttribute'=>'reminder_time','xeditable' => 'datetime'],
                        ],'xEditableDateId' => $count]); ?>
                    <?php $count++; }?>
                    </span>                    
                    
            </div>
        </div>
    <?php }?>
    <?= var_dump($edocument);?>
  
    <div class ="timestamp">
        <div class="createDate">
            <span>Created <?= $model->timeElapsedString;?></span>
        </div>
    <?php if($model->completion_time != NULL && $model->in_progress_time !=NULL && $model->status_id == $model::TASK_COMPLETED){ ?>
        <div>
            Task completed in <?= $model->timeCompletion; ?>
        </div>
    <?php } ?>
    </div>
</div>
