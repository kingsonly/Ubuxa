<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.task-detailsss {
    background-color: rgb(235, 236, 240);
    width: 80%;
    padding-bottom: 10px;
    padding-top: 10px;
    margin-bottom: 15px;
}
.task-titless{
    padding-left: 10px;
}
.asign {
    background-color: rgb(235, 236, 240);
    width: 80%;
    padding-bottom: 10px;
    padding-top: 10px;
    margin-bottom: 15px;
}
</style>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <span>Details</span>
    <div class="task-detailsss">
        <span class="task-titless"><?= $model->details; ?></span>
    </div>
    <span>Assignee</span>
    <div class="asign">
        <span class="task-titless"><?= $model->fullname; ?></span>
    </div>
    <span>Status</span>
    <div class="asign">
        <span class="task-titless"><?= $model->statusTitle; ?></span>
    </div>
    


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'details',
            'assigned_to',
            'status_id',
            'create_date',
            'due_date',
            'last_updated',
        ],
    ]) ?>



</div>
