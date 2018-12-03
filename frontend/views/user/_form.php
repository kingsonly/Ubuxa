<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;



/* @var $this yii\web\View */
/* @var $model app\models\Tmuser */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => false,'id' => 'userform', 'options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'password')->passwordInput() ?>
	<?= $form->field($model, 'profile_image')->fileInput() ?>
	
	<?= Html::submitButton('Submit',['class' => 'sub']) ?>
<?php ActiveForm::end(); ?>



