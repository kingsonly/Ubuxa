<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\UserDb;
use yii\widgets\Pjax;
use boffins_vendor\components\controllers\MenuAccordionWidget;
use boffins_vendor\components\controllers\ViewBoardWidget;
use boffins_vendor\components\controllers\SettingsAccordionWidget;
use boffins_vendor\components\controllers\ClientsAccordionWidget;
use boffins_vendor\components\controllers\UsersAccordionWidget;
use boffins_vendor\components\controllers\SuppliersAccordionWidget;
use boffins_vendor\components\controllers\ContactsAccordionWidget;
use boffins_vendor\components\controllers\UserProfileWidget;
use boffins_vendor\components\controllers\ViewCalendarWidget;

$checkSiteUrl = yii::$app->getRequest()->getQueryParam('r');

?>

<div class="side_menu side-drop">

    	<div class="client-containers" style="visibility: hidden;width:300px;min-height:1px;background:#fff;">
    		<div class="row client-content" style="display: none">
    			<div class="col-sm-12">
    				<div class="col-md-10" style=""></div>
    				<div class="col-md-2" style="padding-top:20px">
    					<i class="fa fa-arrow-left fa-2x close-arrow" style=""></i>
    				</div>
    			</div>
    			<div>
    				<section style="margin: 50px">
			 			 <div class="tbl-header client_template">
			 			 	<img class="supplierLoader" src="<?= Url::to('@web/images/loader/spinner.gif'); ?>" style = "display: none;margin-left:230px;margin-top:150px" id="remarkLoader">
			  			 </div>
					</section>
    			</div>
    		</div>
    	</div>

    	<div class="settings-container">
    		<div class="row settings-content" style="display: none">
    			<div class="col-sm-12">
    				<div class="col-md-10">
    					<span class="settings-text">Settings</span>
    				</div>
    				<div class="col-md-2" style="padding-top:20px">
    					<i class="fa fa-arrow-left fa-2x close-arrow"></i>
    				</div>
    			</div>
    			<div class="sett-content">
    				
    			</div>
    		</div>
    	</div>
        <div class="profile-container">
            <div class="row profile-content" style="display: none">
                
                <div class="profile-content">
                    
                </div>
            </div>
        </div>
	<div class="burger_box">
		<div class="menu-icon-container">

			<a href="#" class="menu-icon js-menu_toggle closed">
				<span class="menu-icon_box">
                    <i class="fa fa-plus fa-2x menu-plus" style="color: #fff !important;" aria-hidden="true"></i>
					<img src="images/ubuxamenu.png" class="ubuxalogo"/>
				</span>
			</a>
            <div class="beacon-wrapper">
              <span class="signal beacon--epicentre"></span>
              <span class="signal signal--wave"></span>
              <span class="signal signal--wave signal--delay"></span>
            </div>
		</div>
	</div>
	<div class="container sider">
    <?php Pjax::begin(['id'=>'profile-refresh']); ?>
		<div class="top-sidebar">
    			<?php if(!empty(yii::$app->user->identity->profile_image)){ ?>
    				<div class="side-images" style="position: relative;background-position: center;z-index:1000;background-image:url('<?= Url::to(yii::$app->user->identity->profile_image); ?>')"></div>
    			<?php }else{?>
    				<div class="side-images" style="position: relative;background-position: center;z-index:1000;background-image:url('<?= Url::to('@web/images/users/default-user.png'); ?>')"></div>
    			<?php }?>
			<div class="client-name">
				<span class="first-name"><?= yii::$app->user->identity->fullName; ?></span>
				<?= UserProfileWidget::widget();?>
			</div>
		</div>
    <?php Pjax::end(); ?>

			<div class="wrap">
  
  <ul class="tabs group">
    <li><a class="active" href="#/one">General</a></li>
   <!-- <li><a href="#/two">Two</a></li> -->
    <li><a href="#/three">Settings</a></li>
  </ul>
  
  <div id="content">
    <div id="one">
    	<ul class="list_load">
    		<!-- <a class="menu-list" href="<?//= Url::to(['site/index'])?>"><li class="list_item menu-settings"><i class="fa fa-home iconz" aria-hidden="true"></i></i>Dashboard</li></a> -->
    		<a class="menu-list" href="<?= Url::to(['folder/index'])?>"><li class="list_item menu-settings"><i class="fa fa-folder iconz" aria-hidden="true"></i>Folder Vault</li></a>
    		<?php if (isset($this->blocks['subfolders'])){ ?>
			 	<?//= MenuAccordionWidget::widget();?>
			 <?php } ?> 
             <?php if($checkSiteUrl != 'folder/index'){ ?>
                <li class="list_item"><?= ViewBoardWidget::widget();?></li>
                <li class="list_item"><?= ViewCalendarWidget::widget();?></li>
             <?php }?>
		</ul>
    </div>
<?php if (isset($this->blocks['sidebar'])){ ?>
            <?= $this->blocks['sidebar'] ?>
<?php }else{ ?>
      <div id="two">
    	<ul class="list_load">
    		<!-- <li class="list_item"><a href="#">List Item 01</a></li> -->
			<?= ClientsAccordionWidget::widget();?>
			<?//= SuppliersAccordionWidget::widget();?>
			<?//= UsersAccordionWidget::widget();?>
			<?//= ContactsAccordionWidget::widget();?>
    	</ul>
    </div>
    <div id="three">
    	<ul class="list_load">
    		<?//= SettingsAccordionWidget::widget();?>
    		<?= UsersAccordionWidget::widget();?>
			<a class="menu-list" href="<?= Url::to(['site/logout'])?>"><li class="list_item menu-settings"><i class="fa fa-sign-out iconz" aria-hidden="true"></i>Logout</li></a>
			
		</ul>
    </div>
<?php } ?>
  </div>
  
</div>
</div>