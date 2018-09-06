<?php
/* @var $this yii\web\View */
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\models\Userdb;
use frontend\models\Role;
use frontend\models\AccessPermission;
$client = AccessPermission::find()->where(['>', 'access_value', 1])->all();
$role = Role::find()->all();
$model = new Userdb();
?>
<style>
	.basic_role label {
		display: block;
	}
</style>
<h1><?= !empty($saved)?$saved:'create' ?></h1>

<p>
<? foreach($userDetails as $userKey => $userInfo){ ?>
	<div>Username: <?= $userInfo['username']; ?></div>
	<div>Fullname: <?= $userInfo['person']['personstring']; ?></div>
<?}	?>
</p>

<p>
	<?php $form = ActiveForm::begin(['enableClientValidation' => true,'id'=>'projectforms', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	
  
<?php $model->basic_role = $userDetails[0]->basic_role ?>
<?= $form->field($model, 'basic_role')->radioList(ArrayHelper::map($role, 'id', 'name'),['class'=>'basic_role'])->label(Yii::t('settings','basic users role')); ?>
    
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span id="projectbuttonText">Create</span> <img id="projectloader" src="images/45.gif" " /> <span id="projectloader1"><span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-basic' : 'btn btn-basic','id'=>'projectsubmit_id']) ?>
		
		<div class="btn btn-basic">Advance Options</div>
    </div>

    <?php ActiveForm::end(); ?>
</p>

<p>
<? foreach($allRoutes as $routeKey => $routeValue){ ?>
	<div class="btn btn-danger routebutton" data-route="<?=$routeValue['base_route']; ?>"> <?=$routeValue['name'];  ?> page</div>
	<?}  ?>
</p>

<p class="advance"></p>


<p>
	<?php $form = ActiveForm::begin(['enableClientValidation' => true,'id'=>'projectforms', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	
  <?php $model->roles =[8,2]; ?>
<?php echo $form->field($model, 'roles')->checkboxList( ArrayHelper::map($client, 'access_value', 'action'));
?>
    
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span id="projectbuttonText">Create</span> <img id="projectloader" src="images/45.gif" " /> <span id="projectloader1"><span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-basic' : 'btn btn-basic','id'=>'projectsubmit_id']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</p>


<?php 
$url = Url::to(['getrouteform']);
$projectform = <<<JS

$('.routebutton').on('click', function () {
	
    var dataRoute = $(this).data('route');
	
	$(".advance").load('$url'+'&id=$id&route='+dataRoute);
	
    
    
});
JS;
 
$this->registerJs($projectform);
?>
