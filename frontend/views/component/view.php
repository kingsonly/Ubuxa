<?php
use boffins_vendor\components\controllers\ComponentViewWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Payment */

?>

<?= ComponentViewWidget::widget([
									'model'=>$component,
									'content'=>$content,
									'users'=>$users,
									'listOfUsers'=>$fuser,
									
								]); 

?>
