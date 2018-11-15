<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ValueMoney */

$this->title = Yii::t('app', 'Create Value Money');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Value Moneys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="value-money-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
