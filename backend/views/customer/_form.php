<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'entity_id')->textInput() ?>

    <?= $form->field($model, 'cid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'master_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'master_doman')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_id')->textInput() ?>

    <?= $form->field($model, 'billing_date')->textInput() ?>

    <?= $form->field($model, 'account_number')->textInput() ?>

    <?= $form->field($model, 'has_admin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
