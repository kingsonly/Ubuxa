<?php 
    use boffins_vendor\components\controllers\TaskModalWidget;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
    use yii\helpers\Url;
?>

<?php Pjax::begin(['id'=>'task-modal-refresh']); ?>
    <?= TaskModalWidget::widget(['model' => $model, 'reminder' => $reminder, 'users' => $users, 'label' => $label, 'taskLabel' => $taskLabel]) ?>
<?php Pjax::end(); ?>
