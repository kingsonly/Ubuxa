<?php

use yii\helpers\Html;
use yii\grid\GridView;
use boffins_vendor\components\controllers\FolderCreateWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Folders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="folder-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= FolderCreateWidget::widget(); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'title',
            'description',
            'last_updated',
            
            //'deleted',
            //'cid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

	
</div>
