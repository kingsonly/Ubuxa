<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model frontend\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">
	<?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'details')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'due_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
