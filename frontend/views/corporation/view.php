<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Corporation */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('component', 'Corporations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="corporation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('component', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('component', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('component', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'short_name',
            'entity_id',
            'notes',
			//'address',
            'cid',
        ],
    ]) ?>

</div>
