<?php
use yii\helpers\Url;
use boffins_vendor\components\controllers\ComponentListViewWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Payment */
$attributes = [
            'receivedpurchaseorder_id',
            'description',
            'creation_date',
            'Amount'=>'currencyAndAmount',
			
            

            
        ];
$action = [
	'update'=> Url::to(['invoice/update']),
	'delete'=> Url::to(['invoice/delete']),
];
?>

<?= ComponentListViewWidget::widget([
									'model'=>$model,
									'content'=>$invoice,
									'attributes'=>$attributes,
									'hoverEffect'=>$hoverEffect,
									'action'=>$action,
									
								]); ?>
