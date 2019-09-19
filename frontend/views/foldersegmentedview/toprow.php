<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use boffins_vendor\components\controllers\TaskWidget;
use boffins_vendor\components\controllers\KanbanWidget;
use boffins_vendor\components\controllers\RemarksWidget;
use boffins_vendor\components\controllers\ComponentWidget;
use boffins_vendor\components\controllers\FolderDetails;
use boffins_vendor\components\controllers\SubFolders;
use boffins_vendor\components\controllers\ActivitiesWidget;
use boffins_vendor\components\controllers\OnlineClients;
use boffins_vendor\components\controllers\EdocumentWidget;
use boffins_vendor\components\controllers\ViewEdocumentWidget;
use kartik\popover\PopoverX;
use yii\web\View;
use frontend\assets\AppAsset;
use frontend\models\Onboarding;
?>
<section>
                  <div class="row top-box">
					  
                  	<?= ActivitiesWidget::widget(['id'=>$userId]) ;?>
					 <?= OnlineClients::widget(['model' => $model, 'taskStats' => $model->clipOn['task'], 'users' => $model->users]); ?>
                  	
                  </div>  
                    	<div class="row">
							
   						 	<?= FolderDetails::widget(['model' => $model,'author'=> $model->folderManagerByRole->user->nameString,'onboardingExists' => $onboardingExists, 'onboarding' => $onboarding,'userId' => $userId, 'folderDetailsImage' => $img ,'imageUrl' => Url::to(['folder/update-folder-image','id' => $model->id])]) ?>
   						 	<?= SubFolders::widget(['placeHolderString'=> 'a new sub','folderCarouselWidgetAttributes' =>['class' => 'folder','folderPrivacy'=>$model->private_folder],'createButtonWidgetAttributes' =>['class' => 'folder'],'displayModel' => $model->subFolders,'onboardingExists' => $onboardingExists, 'onboarding' => $onboarding,'userId' => $userId,]) ?>
                    	</div>
            </section>

