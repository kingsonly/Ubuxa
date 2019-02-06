<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Calendar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calendar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'last_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'deleted')->textInput() ?>

    <?= $form->field($model, 'last_updated')->textInput() ?>

    <?= $form->field($model, 'cid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
