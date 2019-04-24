<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Corporation */

$this->title = Yii::t('component', 'Create Corporation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('component', 'Corporations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="corporation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
