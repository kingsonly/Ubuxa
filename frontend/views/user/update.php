<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDb */

$this->title = 'Update User Db: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Dbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-db-update">
    <?= $this->render('_form', [
        'model' => $model,
        'person' => $person,
    ]) ?>

</div>
