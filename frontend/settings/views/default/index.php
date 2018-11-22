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
<!--<div class="settings-default-index">
    <h1>view users</h1>
	<table class="settings-table">
		<tr>
		<td>Sn</td>
		<td>username</td>
		<td>last loged</td>
		<td>action</td>
		</tr>
   <? //$i=1; foreach($users as $k => $v){ ?>
	<tr>
		<td><?//= $i; ?></td>
		<td><?//= $v['username']; ?></td>
		<td><?//=$v['last_login']; ?></td>
		<td><?//= Html::a('edit Permission', Url::to(['create-privilege','id'=> $v['id']]), ['class' => 'btn btn-default btn-flat']) ?></td>
		</tr>
	<? //$i++;} ?>
	</table>
</div> -->
            <div class="tab-wrap">
  
    <input type="radio" name="tabs" id="tab1" checked>
    <div class="tab-label-content" id="tab1-content">
      <label for="tab1" class="settings-tabz first-tab">Date Format</label>
      <div class="tab-content first-content">
      	<?php $forms = ActiveForm::begin(['enableClientValidation' => true,'id'=>'settings-date', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
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
        <?= Html::submitButton('Change', ['class' => 'btn btn-success', 'id' => 'date-buttonz']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>
      </div>
    </div>
     
    <input type="radio" name="tabs" id="tab2">
    <div class="tab-label-content" id="tab2-content">
      <label for="tab2" class="settings-tabz second-tab">Language</label>
      <div class="tab-content second-content">
      	
<?php $forms = ActiveForm::begin(['enableClientValidation' => true,'id'=>'settingsLang', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	<? $settingsModel->language  = $settings->language; ?>
	<?= $forms->field($settingsModel, 'language')->radioList([
		'es'=>'Spanish',
		'en-US'=>'English (USA)',
		'de'=>'Dutch',
		'it'=>'Italiano',
		'ja'=>'Japanise',
		
	],['class'=>'dates']); ?>

	<div class="form-group">
         <?= Html::submitButton('Change', ['class' => 'btn btn-success']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>
      </div>
    </div>
    
    <input type="radio" name="tabs" id="tab3">
    <div class="tab-label-content" id="tab3-content">
      <label for="tab3" class="settings-tabz third-tab">Theme</label>
      <div class="tab-content third-content">
      	<?php $forms = ActiveForm::begin(['enableClientValidation' => true,'id'=>'settingsTheme', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	<? $settingsModel->theme  = $settings->theme; ?>
	<?= $forms->field($settingsModel, 'theme')->radioList([
		'StandardFormsAsset'=>'red',
		'TestFormsAsset'=>'blue',
		'IndexDashboardAsset'=>'green',
		
		
	],['class'=>'dates']); ?>

	<div class="form-group">
        <?= Html::submitButton('Change', ['class' => 'btn btn-success']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>
      </div>
    </div>
  
     <input type="radio" name="tabs" id="tab4">
     <div class="tab-label-content" id="tab4-content">
      <label for="tab4" class="settings-tabz fourth-tab">Logo</label>
      <div class="tab-content fourth-content">
      	<?php $forms = ActiveForm::begin(['action'=>Url::to(['default/setlogo']),'options' => ['enctype' => 'multipart/form-data'],'enableClientValidation' => true,'id'=>'settingsLogo', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	<? $settingsModel->logo  = $settings->logo; ?>
	

<?= $forms->field($models, 'imageFile')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*', 'id' => 'set-logo'],
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
        <?= Html::submitButton('Change', ['class' => 'btn btn-success']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>
      </div>
    </div>
    
    <div class="slide"></div>
  
</div>

<?php
$settingsUrl = 'index.php?r=settings%2Fdefault';
$createSettings = 'index.php?r=settings%2Fdefault%2Fcreate';

$settts = <<<JS
$('#settings-date').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
           var form = $(this);
            if(form.find('#settings-date').length) {
                return false;
            }
            $.ajax({
                url: '$settingsUrl',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    console.log('completed');
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
            return true;    
});
$('#settingsLang').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
           var form = $(this);
            if(form.find('#settingsLang').length) {
                return false;
            }
            $.ajax({
                url: '$settingsUrl',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    console.log('completed');
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
            return true;    
});
$('#settingsTheme').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
           var form = $(this);
            if(form.find('#settingsTheme').length) {
                return false;
            }
            $.ajax({
                url: '$settingsUrl',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    console.log('completed');
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
            return true;    
});
$('#settingsLogo').on('submit', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
           var form = $(this);
            if(form.find('#settingsLogo').length) {
                return false;
            }
            $.ajax({
                url: '$settingsUrl',
                type: 'POST',
                processData: false,
		      	contentType: false,
		      	async: false,
		      	cache: false,
                data: form.serialize(),
                success: function(response) {
                    console.log('completed');
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
            return true;    
});
JS;
$this->registerJs($settts);
?>