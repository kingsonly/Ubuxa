<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

?>
<style>
 .cardInput{
    border-radius: 3px;
    resize: none;
    display: block;
    width: 100%;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: none;
    box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
    max-height: 162px;
    min-height: 54px;
 }
 .cardInput:focus {
    outline: 0;
 }
 #cardButton {
    padding: 5px
 }
 .close-add {
    height: 32px;
    font-size: 16px;
    line-height: 32px;
    width: 32px;
    font-weight: 100px;
    color: #798d99;
    padding-left: 10px;
    cursor: pointer;
 }
</style>
<?php $form = ActiveForm::begin(['id' => 'create-task-card'.$statusid,'options' => ['data-pjax' => true ]]); ?>
    <?= $form->field($taskModel, 'title')->textarea(['maxlength' => true, 'id' => 'addCard'.$id, 'placeholder' => "Write some task here", 'class' => 'cardInput'])->label(false) ?>
    <?= $form->field($taskModel, 'status_id')->hiddenInput(['maxlength' => true, 'value' => $statusid])->label(false); ?>
    <?= $form->field($taskModel, 'ownerId')->hiddenInput(['value' => $parentOwnerId])->label(false) ?>
    <?= Html::submitButton('Add Card', ['id' => 'cardButton']) ?>
    <span class="glyphicon glyphicon-remove close-add"></span> 
<?php ActiveForm::end(); ?>

<?php
$taskUrl = Url::to(['task/dashboardcreate']);
$addCard = <<<JS
$('#create-task-card$statusid').on('beforeSubmit', function(e) {
        e.preventDefault(); 
           var form = $(this);
            if(form.find('#create-task-card$statusid').length) {
                return false;
            }
            $.ajax({
                url: '$taskUrl',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    console.log('completed');
                    $.pjax.reload({container:"#task-list-refresh"});
                    $.pjax.reload({container:"#kanban-refresh",async: false});
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });
            return true;    
});

$(".cardInput").keydown(function(e){
// Enter was pressed without shift key
if (e.keyCode == 13 && !e.shiftKey)
{
    // prevent default behavior
    e.preventDefault();
}
});


JS;
 
$this->registerJs($addCard);
?>