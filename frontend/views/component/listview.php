<?php
use yii\helpers\Url;
use boffins_vendor\components\controllers\ComponentListViewWidget;
?>

<?= ComponentListViewWidget::widget([
							
									'content'=>$content,
									'folderId'=>$folder,
									'hoverEffect'=> 'true',

								]); ?>
