<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('component', 'Component Attributes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-attribute-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('component', 'Create Component Attribute'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'component_id',
            'component_template_attribute_id',
            'value_id',
            'cid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
