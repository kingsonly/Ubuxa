<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */
/* @var $form yii\widgets\ActiveForm */

?>
<style>
	#loadingdiv{
		display: none;
	}
</style>
<div class="folder-form">
	<?php 
	$folderId = '';
if(isset($_GET['id'])){
	$folderId = $_GET['id'];
	}else{
		$folderId = 0;
	}
    $form = ActiveForm::begin(['action'=>Url::to(['folder/create']),'id'=> 'folderform']); ?>
<div id="loadingdiv"> loading .....</div>
    
<?= $form->field($folderModel, 'privateFolder')->checkbox(['label'=>'test','value' => "1"]); ?>
<?= $form->field($folderModel, 'title')->textInput(['maxlength' => true]) ?>
<?= $form->field($folderModel, 'parent_id')->hiddenInput(['value' => $folderId])->label(false); ?>
<?= $form->field($folderModel, 'cid')->hiddenInput(['value' => Yii::$app->user->identity->cid])->label(false); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$js = <<<JSS

$('#folderform').on('beforeSubmit', function (e) {
	
 	$('#loadingdiv').show();
    var \$form = $(this);
    $.post(\$form.attr('action'),\$form.serialize())
    .always(function(result){
	jsonResult = JSON.parse(result);
	$(document).find('#loadingdiv').html(jsonResult.message);
	
   if(jsonResult.message == 'sent'){
	   
	   //$(document).find('#loader1').html(result.message).show();
	   // bring green toast
	   alert(jsonResult.message)
    
    }else{
    //$(document).find('#loader1').html(result).show();
	// bring red toast 
	alert(jsonResult.message)
    }
    }).fail(function(){
    console.log('Server Error');
    });
	
	
    return false;
    
    
    
});
JSS;
 
$this->registerJs($js);
?>
