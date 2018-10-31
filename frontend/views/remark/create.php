<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Remark */

$this->title = 'Create Remark';
$this->params['breadcrumbs'][] = ['label' => 'Remarks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="remark-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
