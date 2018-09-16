<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="folder-form">
	<?php 
	$folderId = '';
if(isset($_GET['id'])){
	$folderId = $_GET['id'];
	}else{
		$folderId = 0;
	}
    $form = ActiveForm::begin(['action'=>Url::to(['folder/create'])]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'privateFolder')->checkbox(['label'=>'test','value' => "1"]); ?>
<?= $form->field($model, 'parent_id')->hiddenInput(['value' => $folderId])->label(false); ?>
<?= $form->field($model, 'cid')->hiddenInput(['value' => Yii::$app->user->identity->cid])->label(false); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
