<?php

use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\DisplayComponentViewLayout;
use yii\jui\Draggable;

/* @var $this yii\web\View */
/* @var $model app\models\Folder */
?>

 <?= DisplayComponentViewLayout::widget(
	[
		'folderId'=>$folderId,
		'templateId'=>$templateId,
		'componentId'=>$componentId,
	]); ?>

