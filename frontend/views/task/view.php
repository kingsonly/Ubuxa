<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use boffins_vendor\components\controllers\FolderUsersWidget;
use boffins_vendor\components\controllers\AssigneeViewWidget;
use boffins_vendor\components\controllers\CreateLabelWidget;

use yii\widgets\Pjax;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
#task-details-cont {
    width: 100%;
}
.panel{
    border: none;
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
    margin-bottom: 10px;
    /* display: inline-block; */
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
    background-color: rgba(9,45,66,.08);
    border-radius: 2px;
    color: #6b808c;
    cursor: pointer;
    padding: 6px;
    margin: 0 8px 8px 0;
    transition-property: background-color,border-color,box-shadow;
    transition-duration: 85ms;
    transition-timing-function: ease;
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
    padding-right: 4px;
}

.allassignees {
    display: block;
    float: left;
    margin: 0 8px 8px 0;
    max-width: 100%;
}
.task-labels {
    margin-top: 15px;
}
.task-details-title{
    padding-right: 100%;
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
</style>
<?php Pjax::begin(['id'=>'task-refresh']); ?>
    <div class="task-view">

        <div class="task-titlez">
        <?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
                        ['modelAttribute'=>'title'],
                        ]]); ?>
        </div>

        <div class="all-status">
            <div class="task-statuz">
                <span class="stat-title">Status</span>
            </div>
            <div class="task-status">
                <span class="task-titless"><?= $model->statusTitle; ?></span>
            </div>
        </div>

        <div class="allassignees">
            <div class="assignContent">
                <span class="assignUsers">Assignees</span>
                <div class="dropdown taskdrop">
                        <a class="dropdown-toggle drop-assignee moreusers" type="button" id="dropdownMenuButtont" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-plus addUserz" aria-hidden="true" data-toggle="tooltip" title="Assign Users"></span>
                        </a>
                            <div class="dropdown-menu assigntask" aria-labelledby="dropdownMenuButton">
                                    <?= AssigneeViewWidget::widget(['users' => $users, 'taskid' => $model->id]) ?>  
                            </div>
                </div>
            </div>
            <?php if(!empty($model->taskAssignees)){?>

                <div class="members">
                    <?= FolderUsersWidget::widget(['attributues'=>$model->taskAssignees,'removeButtons' => false]);?>
                </div>
            <?php } ?>
        </div>
    
        <div class="allassignees">
            <div class="assignContent">
                <span class="assignUsers">Labels</span>
                <a class="dropdown-toggle drop-labels moreusers" type="button" id="dropdownMenuButtont" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-plus addLabels" aria-hidden="true" data-toggle="tooltip" title="Add Label"></span>
                </a>
                <div class="dropdown-menu assigntask" aria-labelledby="dropdownMenuButton">
                    <?= CreateLabelWidget::widget(['id' => $model->id,'label' => $label, 'taskLabel' => $taskLabel, 'taskid' => $model->id]) ?>  
                </div>
            </div>  
            <?php if(!empty($model->labelNames)){ ?>  
                <div class="task-labels">
                    <span class="label-task"><?= $model->labelNames; ?></span>
                </div>
            <?php } ?>
        </div>

        <div class="alldates">
            <div class="due-dates">
                <span class="assignUsers">Due Date</span>
            </div>    
            <div class="due-labels">
                <span class="label-date"><?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
                        ['modelAttribute'=>'due_date','xeditable' => 'datetime'],
                        ]]); ?></span>
            </div>
        </div>  

    <div class="task-detailzz">
        <div><span class="task-details-title">Details</span></div>
        <div class="task-detailz">
        <?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
                        ['modelAttribute'=>'details','xeditable' => 'notes'],
                        ]]); ?>
        </div>
    </div>

    <div class="allreminder">
            <div class="reminder-dates">
                <span class="reminder-title">Reminder</span>
            </div>    
            <div class="reminder-labels">
                <span class="label-reminder"><?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
                        ['modelAttribute'=>'reminderTime','xeditable' => 'datetime'],
                        ]]); ?></span>
            </div>
        </div>
  
    <div class ="timestamp">
        <div class="createDate">
            <span>Created <?= Yii::$app->formatter->format($model->create_date, 'relativeTime') ?></span>
        </div>
    <?php if($model->completion_time != NULL && $model->in_progress_time !=NULL && $model->status_id == 24){ ?>
        <div>
            Task completed in <?= $model->timeCompletion; ?>
        </div>
    <?php } ?>
    </div>
</div>

<?php Pjax::end(); ?>