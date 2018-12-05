<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\TaskAssignedUser;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

?>
<style>
.loading-add-label{
    display: none;
    float: left;
  }
</style>
<?php Pjax::begin(['id'=>'label-refresh']); ?>
<?php 
    $form = ActiveForm::begin(['id' => 'activeLabel'.$taskid.$labelId,'options' => ['class' => 'task-label-class']]); ?>
    <?= $form->field($label, 'name')->textInput(['maxlength' => true,'id' => 'testing-'.$id.$labelId, 'placeholder' => "Add label"]) ?>
    <?= $form->field($taskLabel, 'task_id')->hiddenInput(['maxlength' => true, 'value' => $taskid])->label(false); ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success labelButton', 'id'=>'checkb'.$id.$labelId, 'data-id' => $id]) ?>
    <span class="loading-add-label"><?= Yii::$app->settingscomponent->boffinsLoaderImage()?></span>
    
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<?php
$labelUrl = Url::to(['label/create']);
$assignee = <<<JS
$('.task-label-class').on('beforeSubmit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $('.labelButton').hide();
            $('.loading-add-label').show(); 
           var form = $(this);
            if(form.find('#activeLabel').length) {
                return false;
            }
            setTimeout(function(){
                $.ajax({
                    url: '$labelUrl',
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        toastr.success('Label added');
                        $.pjax.reload({container:"#task-list-refresh"});
                        $.pjax.reload({container:"#kanban-refresh",async: false});
                    },
                  error: function(res, sec){
                      console.log('Something went wrong');
                  }
                });
            }, 5);
            return false;    
        });


JS;
 
$this->registerJs($assignee);
?>