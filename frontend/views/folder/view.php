<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\models\Folder;
use kartik\editable\Editable;
/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Folders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="folder-view">
<?= $this->render('_form', [
        'model' => $model,
    ]) ;
	
	?>
	<style>
	.img-circular{
 width: 50px;
 height: 50px;
 background-repeat: no-repeat;
 background-size: cover;
 display: block;
 border-radius: 25px;
 -webkit-border-radius: 100px;
 -moz-border-radius: 100px;
}
	</style>
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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'parent_id',
            'title',
            'description',
            'last_updated',
            'deleted',
            'cid',
        ],
    ]) ;
	

 
 
	?>

</div>
<?php foreach($model->folderUsers as $users){ 
	$image = !empty($users["image"])?$users["image"]:'default.png';
	?>
	<div class="img-circular" style="background-image:url('<?= Url::to('@web/images/users/'.$image); ?>')" aria-label="achumie kingsley"></div>
	<? }; ?>

<?
 Editable::begin([
    'model'=>$model, 
    'attribute' => 'title',
    'size' => 'md',
	 'asPopover' => false,
    
    'editableValueOptions'=>['class'=>'well well-sm']
]);
Editable::end();

$editable = Editable::begin([
    'model'=>$model,
    'attribute'=>'title',
    'asPopover' => false,
    'size'=>'md',
    'displayValue' => '15th Main, OK, 10322',
    'options'=>['placeholder'=>'Enter location...']
]);

Editable::end();
?>
