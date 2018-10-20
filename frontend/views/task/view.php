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
    white-space: nowrap;
    color: black;
    display: inline-block;
}
#task-details-targ:hover{
    background-color: #ccc;
}


</style>
<?php Pjax::begin(['id'=>'task-refresh']); ?>
<div class="task-view">


<div>
    <label>Details</label>
    <div class="task-detailz">
    <?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
                    ['modelAttribute'=>'details','xeditable' => 'notes'],
                    ]]); ?>
    </div>
</div>

    <span>Assignee</span>
    <div class="asign">
        <span class="task-titless"><?= $model->personName; ?></span>
    </div>
    <span>Status</span>
    <div class="asign">
        <span class="task-titless"><?= $model->statusTitle; ?></span>
    </div>
  
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