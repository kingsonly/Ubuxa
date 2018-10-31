<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RemarkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="remark-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'folder_id') ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'remark_type') ?>

    <?= $form->field($model, 'remark_date') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'cid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
