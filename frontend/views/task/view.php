<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
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
.task-detailsss {
    background-color: rgb(235, 236, 240);
    width: 100%;
    padding-bottom: 10px;
    padding-top: 10px;
    margin-bottom: 15px;
}
.task-titless{
    background: none;
        border:none;
        text-align: left !important;
        width: 100%;
        overflow: hidden;
        display: inline-block;
        white-space: nowrap;
}
.asign {
    background-color: rgb(235, 236, 240);
    width: 100%;
    padding-bottom: 10px;
    padding-top: 10px;
    margin-bottom: 20px;
}
.timestamp {
    color: #707070;
    font-size: 12px;
    line-height: 1.33333333333333;
}
.createDate {
    margin-bottom: 5px
}
#task-details-targ:hover {
    background-color: rgb(235, 236, 240);
    
    margin-bottom: 30px;
}

.xinput{
        background: none;
        border:none;
        text-align: left !important;
        width: 100%;
        overflow: hidden;
        display: inline-block;
        white-space: nowrap;
        font-size: 30px;
        margin-bottom: 15px;
    }
.details {
        background: none !important;
        border:none !important;
        text-align: left !important;
        display: inline-block !important;
        font-size: 15px;
        margin-bottom: 15px !important;
        width: 400px !important;
}



</style>
<?php Pjax::begin(['id'=>'task-refresh']); ?>
<div class="task-view">

    <?= 
        Editable::widget([
        'model'=>$model,
        'attribute'=>'title',
        'asPopover' => false,
            'size'=>'sm',
            'options'=>['placeholder'=>'Enter title...'],
            'editableValueOptions'=>['class'=>'xinput']
]);
     ?>

<div>
    <label>Details</label>
    <? echo Editable::widget([
    'model'=>$model,
    'attribute'=>'details', 
    'asPopover' => false,
    'inputType' => Editable::INPUT_TEXTAREA,
    'header' => 'Notes',
    'submitOnEnter' => true,
    'options' => [
        'class'=>'details', 
        'rows'=>5, 
        'placeholder'=>'Enter notes...'
    ]
]); ?>
</div>

    <span>Assignee</span>
    <div class="asign">
        <span class="task-titless"><?= $model->fullname; ?></span>
    </div>
    <span>Status</span>
    <div class="asign">
        <span class="task-titless"><?= $model->statusTitle; ?></span>
    </div>
    <?=
        Editable::widget([
            'name'=>'province', 
            'asPopover' => false,
            'header' => 'Status',
            'format' => Editable::FORMAT_BUTTON,
            'inputType' => Editable::INPUT_DROPDOWN_LIST,
            'data'=>ArrayHelper::map($status, 'id', 'status_title'), // any list of values
            'options' => ['class'=>'form-control', 'prompt'=>'Select status...'],
            'editableValueOptions'=>['class'=>'text-danger']
        ]);
     ?>
    <div class ="timestamp">
        <div class="createDate">
            <span>Created <?= Yii::$app->formatter->format($model->create_date, 'relativeTime') ?></span>
        </div>
        <div>
            <span>Updated <?= Yii::$app->formatter->format($model->last_updated, 'relativeTime') ?></span>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>