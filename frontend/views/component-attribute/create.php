<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ComponentAttribute */

$this->title = Yii::t('component', 'Create Component Attribute');
$this->params['breadcrumbs'][] = ['label' => Yii::t('component', 'Component Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
