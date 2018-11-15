<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ValueInteger */

$this->title = Yii::t('app', 'Create Value Integer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Value Integers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="value-integer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
