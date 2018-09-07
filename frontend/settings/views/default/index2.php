<?
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use frontend\models\Userdb;
use frontend\models\AccessPermission;
$client = AccessPermission::find()->where(['>', 'access_value', 1])->all();
$model = new Userdb();
?>
<div class="settings-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
	
</div>



<?php $form = ActiveForm::begin(['enableClientValidation' => true,'id'=>'projectforms', 'attributes' => $model->attributes(),'enableAjaxValidation' => false,]); ?>
	
	<?php echo $form->field($model, 'roles[]')->checkboxList( ArrayHelper::map($client, 'access_value', 'action'));
?>

    <?php ActiveForm::end(); ?>