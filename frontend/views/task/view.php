<?php 
    use boffins_vendor\components\controllers\TaskModalWidget;
?>

    <?= TaskModalWidget::widget(['model' => $model, 'reminder' => $reminder, 'users' => $users, 'label' => $label, 'taskLabel' => $taskLabel,'edocument'=>$edocument, 'folderId' => $folderId, 'statusData' => $statusData, 'assigneesIds' => $assigneesIds, 'userid' => $userid]) ?>
