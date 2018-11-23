<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ValueKnownClass */

$this->title = Yii::t('component', 'Create Value Known Class');
$this->params['breadcrumbs'][] = ['label' => Yii::t('component', 'Value Known Classes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="value-known-class-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
