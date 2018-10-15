<?php
use boffins_vendor\components\controllers\ComponentViewWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Payment */
$viewAttributes = [
            'receivedpurchaseorder_id',
            'description',
            [
			 'label' => 'Amount',
            'value' => $model->owner->currencyAndAmount,
			],

			[
				'label' => 'Date created',
				'value' => $model->owner->creation_date,
			],

            'last_updated',

            
        ];
$description = 'description';
?>

<?= ComponentViewWidget::widget([
									'model'=>$model,
									'subComponents'=>$subComponents,
									'viewAttributes'=>$viewAttributes,
									'title'=>$description,
								]); ?>
