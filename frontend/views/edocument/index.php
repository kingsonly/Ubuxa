<?php
	use boffins_vendor\components\controllers\ViewEdocumentWidget;
	use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id'=>'edoc-folders']); ?>
	<?= ViewEdocumentWidget::widget(['edocument'=>$edocument, 'target' => 'folder', 'forFolder' => 'forfolderDocs']) ?>
<?php Pjax::end(); ?>