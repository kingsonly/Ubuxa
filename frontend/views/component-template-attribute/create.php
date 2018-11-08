<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ComponentTemplate */

$this->title = 'Create Component Template';
$this->params['breadcrumbs'][] = ['label' => 'Component Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
