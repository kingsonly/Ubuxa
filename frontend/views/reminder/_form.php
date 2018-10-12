<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model frontend\models\Reminder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reminder-form">

    <?php $form = ActiveForm::begin(); ?>
    <h3>Reminder</h3>
    <?php echo $form->field($model, 'reminder_time')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Enter event time ...'],
    'pluginOptions' => [
        'autoclose' => true
    ]

    ]); ?>

    <?= $form->field($model, 'notes')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
