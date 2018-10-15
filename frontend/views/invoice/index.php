<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\Corporation;
use yii\bootstrap\Alert;
use frontend\models\Supplier;
use boffins_vendor\components\controllers\DisplayComponentViewLayout;
use yii\bootstrap\Modal;
use yii\jui\Draggable;

/* @var $this yii\web\View */
/* @var $model app\models\Folder */
$this->title = 'Tycol | Invoice';
$this->params['breadcrumbs'][] = ['label' => ' Folders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<? $invoiceId=''; if($model->find()->count() <= 0){$invoiceId=0;}else{$invoiceId=!empty($findOneInvoice->id)?$findOneInvoice->id:0; } ?>

 <?= DisplayComponentViewLayout::widget(['model'=>$model,'id'=>$invoiceId,]); ?>

