<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ComponentAttribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="component-attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'component_id')->textInput() ?>

    <?= $form->field($model, 'component_template_attribute_id')->textInput() ?>

    <?= $form->field($model, 'value_id')->textInput() ?>

    <?= $form->field($model, 'cid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('component', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
