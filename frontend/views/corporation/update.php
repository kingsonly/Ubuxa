<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Corporation */

$this->title = Yii::t('component', 'Update Corporation: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('component', 'Corporations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('component', 'Update');
?>
<div class="corporation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
