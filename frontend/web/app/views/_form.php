<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_number')->textInput() ?>

    <?= $form->field($model, 'tyc_ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'component_id')->textInput() ?>

    <?= $form->field($model, 'supplier_id')->textInput() ?>

    <?= $form->field($model, 'supplier_ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_currency')->textInput() ?>

    <?= $form->field($model, 'issue_date')->textInput() ?>

    <?= $form->field($model, 'supplier_completion_date')->textInput() ?>

    <?= $form->field($model, 'order_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_file')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
