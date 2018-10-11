<?
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\models\Userdb;
use kartik\file\FileInput;

use frontend\models\AccessPermission;
$client = AccessPermission::find()->where(['>', 'access_value', 1])->all();
$model = new Userdb();


?>
<style>
	.dates label {
		display: block;
	}
</style>
<div class="settings-default-index">
    <h1>view users</h1>
	<table class="table">
		<tr>
		<td>Sn</td>
		<td>username</td>
		<td>last loged</td>
		<td>action</td>
		</tr>
   <? $i=1; foreach($users as $k => $v){ ?>
	<tr>
		<td><?= $i; ?></td>
		<td><?= $v['username']; ?></td>
		<td><?=$v['last_login']; ?></td>
		<td><?= Html::a('edit Permission', Url::to(['create-privilege','id'=> $v['id']]), ['class' => 'btn btn-default btn-flat']) ?></td>
		</tr>
	<? $i++;} ?>
	</table>
</div>



<h3>Basic Date</h3>



<?php $forms = ActiveForm::begin(['enableClientValidation' => true,'id'=>'projectforms', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	<? $settingsModel->date_format  = $settings->date_format;//'MM/dd/yyyy (HH:mm:ss)'; ?>
	<?= $forms->field($settingsModel, 'date_format')->radioList([
		'M/d/yy ! (HH:mm:ss)'=>'M/d/yyyy (HH:mm:ss)',
		'M/d/yy ! (HH:mm:ss)'=>'M/d/yy (HH:mm:ss)',
		'MM/dd/yy ! (HH:mm:ss)'=>'MM/dd/yy (HH:mm:ss)',
		'MM/dd/yyyy ! (HH:mm:ss)'=>'MM/dd/yyyy (HH:mm:ss)',
		'yy/MM/dd ! (HH:mm:ss)'=>'MM/dd/yyyy (HH:mm:ss)',
		'yyyy-MM-dd ! (HH:mm:ss)'=>'yyyy-MM-dd (HH:mm:ss)',
		'dd-MMM-yy ! (HH:mm:ss)'=>'dd-MMM-yy (HH:mm:ss)',
		'dddd MMM d  yyyy ! (HH:mm:ss)'=>' dddd MMM d  yyyy (HH:mm:ss)',
		'MMMM d  yyyy ! (HH:mm:ss)'=>' MMMM d  yyyy (HH:mm:ss)',
		'dddd,d MMMM  yyyy ! (HH:mm:ss)'=>'dddd,d MMMM  yyyy  (HH:mm:ss)',
		'd MMMM  yyyy ! (HH:mm:ss)'=>' d MMMM  yyyy (HH:mm:ss)',
	],['class'=>'dates']); ?>

	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span id="projectbuttonText">Create</span> <img id="projectloader" src="images/45.gif" " /> <span id="projectloader1"><span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-basic' : 'btn btn-basic','id'=>'projectsubmit_id']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>

<h3>Select Language</h3>



<?php $forms = ActiveForm::begin(['enableClientValidation' => true,'id'=>'projectforms', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	<? $settingsModel->language  = $settings->language; ?>
	<?= $forms->field($settingsModel, 'language')->radioList([
		'es'=>'Spanish',
		'en-US'=>'English (USA)',
		'de'=>'Dutch',
		'it'=>'Italiano',
		'ja'=>'Japanise',
		
	],['class'=>'dates']); ?>

	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span id="projectbuttonText">Create</span> <img id="projectloader" src="images/45.gif" " /> <span id="projectloader1"><span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-basic' : 'btn btn-basic','id'=>'projectsubmit_id']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>

<h3>Select Theme</h3>
<?php $forms = ActiveForm::begin(['enableClientValidation' => true,'id'=>'projectforms', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	<? $settingsModel->theme  = $settings->theme; ?>
	<?= $forms->field($settingsModel, 'theme')->radioList([
		'StandardFormsAsset'=>'red',
		'TestFormsAsset'=>'blue',
		'IndexDashboardAsset'=>'green',
		
		
	],['class'=>'dates']); ?>

	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span id="projectbuttonText">Create</span> <img id="projectloader" src="images/45.gif" " /> <span id="projectloader1"><span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-basic' : 'btn btn-basic','id'=>'projectsubmit_id']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>

<h3>Select Theme</h3>
<?php $forms = ActiveForm::begin(['action'=>Url::to(['default/setlogo']),'options' => ['enctype' => 'multipart/form-data'],'enableClientValidation' => true,'id'=>'projectf', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	<? $settingsModel->logo  = $settings->logo; ?>
	

<?= $forms->field($models, 'imageFile')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
	'pluginOptions' => [
        'initialPreview'=>[
            $settings->logo,
        ],
        'initialPreviewAsData'=>true,
        'initialPreviewConfig' => [
            ['caption' => 'Moon.jpg', 'size' => '873727'],
            ['caption' => 'Earth.jpg', 'size' => '1287883'],
        ],
        'overwriteInitial'=>true,
        'maxFileSize'=>2800
    ],
]);
?>
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span id="projectbuttonText">Create</span> <img id="projectloader" src="images/45.gif" " /> <span id="projectloader1"><span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-basic' : 'btn btn-basic','id'=>'projectsubmit_id']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>