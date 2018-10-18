<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\TaskAssignedUser;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

?>
<?php Pjax::begin(['id'=>'label-refresh']); ?>
<?php 
    $form = ActiveForm::begin(['id' => 'activeLabel'.$taskid, 'action'=>Url::to(['task/update', 'id' => $taskid]),'options' => ['data-pjax' => true ]]); ?>
    <?= $form->field($task, 'label')->textInput(['maxlength' => true,'id' => 'testing-'.$id, 'placeholder' => "Add label"]) ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-success labelButton', 'id'=>'checkb'.$id, 'data-id' => $id]) ?>
    
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<?php
//$createUrl = Url::to(['task/update', 'id' => $taskid]);
$assignee = <<<JS
$('#activeLabel'+'$taskid').on('beforeSubmit', function(e) { 
           var form = $(this);
            if(form.find('#activeLabel').length) {
                return false;
            }
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    console.log('completed');
                    $.pjax.reload({container:"#asign-refresh"});
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
            return true;    
        });


JS;
 
$this->registerJs($assignee);
?>