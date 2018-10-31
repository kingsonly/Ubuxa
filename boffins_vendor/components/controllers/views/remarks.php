<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\RemarkComponentViewWidget;
?>
<style type="text/css">
    .bg-info {
        background-color: #fff;
        box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
        padding-left: 15px;
        padding-right: 15px;
    }

    .header {
        border-bottom: 1px solid #ccc;
        padding-top: 7px;
        padding-bottom: 7px;
        font-weight: bold
    }

    .box-content {
        min-height: 300px;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .box-input {
        padding-top: 7px;
        padding-bottom: 7px;
    }
</style>

<div class="col-md-8">
    <div class="col-md-12 bg-info">
      	<div class="header">REMARKS</div>
	    <div class="col-md-12 box-content"><?= RemarkComponentViewWidget::widget(['remarkModel' => $remarkModel, 'parentOwnerId' => $parentOwnerId, 'remarks'=> $remarks]); ?></div>
    </div>
</div>