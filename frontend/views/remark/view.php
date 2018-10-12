<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use frontend\assets\AppAsset;
AppAsset::register($this);
use boffins_vendor\components\controllers\RemarkComponentViewWidget;

/* @var $this yii\web\View */
/* @var $model frontend\models\Remark */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Remarks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="remark-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    
 
<?= RemarkComponentViewWidget::widget(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 results"></div>
    </div>
    <div class="text-center" id="loading">
        <img src="ajax-loader.gif" id="ani_img"/>
    </div>
</div>
</div>
