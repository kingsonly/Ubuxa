<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\models\Folder;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use boffins_vendor\components\controllers\FolderUsersWidget;
use boffins_vendor\components\controllers\FolderCreateWidget;
/* @var $this yii\web\View */
/* @var $model frontend\models\Folder */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Folders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$users = $model->folderUsers;
?>
<div class="folder-view">
	<style>
	.img-circular{
 width: 50px;
 height: 50px;
 background-repeat: no-repeat;
 background-size: cover;
 display: inline-block;
border:solid 1px #ccc;
 border-radius: 25px;
 -webkit-border-radius: 100px;
 -moz-border-radius: 100px;
background-color: #fff;
transition: margin-top 0.1s ease-out 0s;
}
#folderusers .img-circular:not(:first-of-type) {
      margin-left: -10px;
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
<?= FolderUsersWidget::widget(['attributues'=>$users]);?>
<?= FolderCreateWidget::widget();?>






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