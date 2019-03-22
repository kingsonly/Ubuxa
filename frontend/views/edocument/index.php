<?php
	use boffins_vendor\components\controllers\ViewEdocumentWidget;
?>

<?= ViewEdocumentWidget::widget(['edocument'=>$edocument, 'target' => 'folder', 'forFolder' => 'forfolderDocs']) ?>