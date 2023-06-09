<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ComponentTemplate */

$this->title = 'Update Component Template: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Component Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="component-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
