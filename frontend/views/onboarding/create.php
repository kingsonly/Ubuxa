<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Onboarding */

$this->title = 'Create Onboarding';
$this->params['breadcrumbs'][] = ['label' => 'Onboardings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="onboarding-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
