<?php
use yii\helpers\Url;
use boffins_vendor\components\controllers\ComponentListViewWidget;
var_dump($content);
?>

<?= ComponentListViewWidget::widget([
							
									'content'=>$content,
									'hoverEffect'=> 'true',

								]); ?>
