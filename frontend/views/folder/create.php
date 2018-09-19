<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */

$this->title = 'Create Folder';
$this->params['breadcrumbs'][] = ['label' => 'Folders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="folder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
