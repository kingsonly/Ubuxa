<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\FolderUsersWidget;
use boffins_vendor\components\controllers\CreateButtonWidget;
use boffins_vendor\components\controllers\FolderCarouselWidget;
use yii\widgets\Pjax;
?>
<style type="text/css">
	
.comps {
	background-color: white;
	height: 110px;
	
	margin-top: 20px;
	box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
	padding-left: 15px;
	padding-right:15px;
	
}
	hr{
		margin: 0px !important;
	}

	
.auth-users {
	border-bottom: 1px solid #ccc;
	padding-top: 12px;
}
	.components .col-sm-12, .components .col-xs-12,.components .col-xs-5,.components .col-sm-2{
		padding-left: 0px !important;
	}
	
	.component-display{
		
		
		box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
		padding-left: 15px;
		padding-right:15px;
		
	}
	
	.component-display-wrapper{
		/*background:linear-gradient(#ffffff,#ffffff,#fcfcfc,#F0F0F0,#fafafa);*/
		background:linear-gradient(#ffffff, #fcfcfc,#fafafa);
		display: none;
		min-height: 300px;
		max-height: 600px;
		width: 100%;
		overflow: scroll;
		margin-bottom: 20px;
	}
	
	.margin-bottom{
		margin-bottom: 20px;
	}
	.comps .owl-nav{
		margin: 0px !important;
	}

</style>

<div class="col-sm comps margin-bottom">
    <div class="auth-users">

		<?php Pjax::begin(['id'=>'for-profile-refresh']); ?>
    	<?= FolderUsersWidget::widget(['attributues'=>$users,'id'=>$id,'type'=>'folder','pjaxId' => $id])?>	
		<?php Pjax::end(); ?>
    </div>
	<div class="components">
		<div class="col-sm-12 col-xs-12  column-margin component-contetnt">
		
		<div class="col-xs-5 col-sm-2 ">
				<div class="">
					<div class=""><?= CreateButtonWidget::widget(['buttonType' => 'icon','htmlAttributes'=>['class'=>'test'] ]);?></div>
				</div>
   		</div>
		
		
			<div class="col-xs-7 col-sm-10 component-carousel ">
		
			
				
					<?= FolderCarouselWidget::widget([
							'folderModel' => $model, 
							'model' => $displayModel, 
							'folderId' => $folderId, 
							'displayType' => 'component',
							'height' => $height,
							'numberOfDisplayedItems' => 4,
							'htmlAttributes'=>'test',
							'createFormWidgetAttribute'=>[
								'formId'=>'create-component-form', 
								'formAction'=>$formAction,
								'refreshSectionElement'=>'component-create-refresh',
								
							]
						]) ?>
				
			
		</div>
	</div></div>
</div>

<div class="component-display-wrapper">
	<div class="col-sm-12 col-xs-12 component-display"></div>
</div>