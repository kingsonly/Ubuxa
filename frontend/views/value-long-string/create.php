<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ValueLongString */

$this->title = Yii::t('app', 'Create Value Long String');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Value Long Strings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="value-long-string-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
