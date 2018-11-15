<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('component', 'Value Known Classes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="value-known-class-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('component', 'Create Value Known Class'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'value',
            'query',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
