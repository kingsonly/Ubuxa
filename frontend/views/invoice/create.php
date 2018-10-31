<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = 'Create Invoice/Quotation';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-create">
	<?php if(Yii::$app->controller->action->id == 'index' and Yii::$app->controller->id == 'site'){ ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
		'receivedpurchaseorders' => $receivedpurchaseorders,
		'currencies' => $currencies,
		'currency_settings' => $currency_settings,
		'language' => $language,
		
    ]) ?>

</div>
