<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\models\Folder;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use boffins_vendor\components\controllers\FolderUsersWidget;
use boffins_vendor\components\controllers\FolderCreateWidget;
use boffins_vendor\components\controllers\SubFolderWidget;
use boffins_vendor\components\controllers\FolderCarouselWidget;
use boffins_vendor\components\controllers\SearchFormWidget;
use boffins_vendor\components\controllers\CreateButtonWidget;
/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Folders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$users = $model->folderUsers;
?>
<div class="folder-view">
	
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
	<?
	$images=['<img src="http://placehold.it/300/673ab7/000000"/>','<img src="/path/to/file2"/>','<img src="/path/to/file3"/>'];
	?>
<?= FolderUsersWidget::widget(['attributues'=>$users]);?>
<?= CreateButtonWidget::widget();?>

	<div style="width:400px;background:#fff;">
		<?= SearchFormWidget::widget();?>
		<?=FolderCarouselWidget::widget(['folderModel' => $model->subFolders]);?>
	</div>


<? SubFolderWidget::widget(['model' => $model->subFolders]);?>





  <? $this->beginBlock('sidebar')?>    
	<div class="tab-2">
				    <label for="tab2-2">Folder Info</label>
				    <input id="tab2-2" name="tabs-two" type="radio">
			    	<div>
			    	<ul class="list_load">
				    	<?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
	['modelAttribute'=>'title'],
	['modelAttribute'=>'description']
]]); ?>
					</ul>
			    </div>
			</div>

  <? $this->endBlock();?> 
</div>