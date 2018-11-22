<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\UserDb;
use boffins_vendor\components\controllers\MenuAccordionWidget;
use boffins_vendor\components\controllers\ViewBoardWidget;
use boffins_vendor\components\controllers\SettingsAccordionWidget;
use boffins_vendor\components\controllers\ClientsAccordionWidget;
use boffins_vendor\components\controllers\UsersAccordionWidget;
use boffins_vendor\components\controllers\SuppliersAccordionWidget;
use boffins_vendor\components\controllers\ContactsAccordionWidget;

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

	<div class="burger_box">
		<div class="menu-icon-container">
			<a href="#" class="menu-icon js-menu_toggle closed">
				<span class="menu-icon_box">
					<img src="images/ubuxamenu.png" class="ubuxalogo"/>
				</span>
			</a>
		</div>
	</div>
	<div class="container sider">
		<div class="top-sidebar">
			<?php if(!empty(yii::$app->user->identity->profile_image)){ ?>
				<div class="side-images" style="position: relative;z-index:1000;background-image:url('<?= Url::to('images/users/'.yii::$app->user->identity->profile_image); ?>')"></div>
			<?php }else{?>
				<div class="side-images" style="position: relative;z-index:1000;background-image:url('<?= Url::to('@web/images/users/default-user.png'); ?>')"></div>
			<?php }?>
			<div class="client-name">
				<span class="first-name"><?= yii::$app->user->identity->fullName; ?></span>
				<div><a class="profile-link" href="#">Edit profile</a></div>
			</div>
		</div>
			<div class="wrap">
  
  <ul class="tabs group">
    <li><a class="active" href="#/one"> One</a></li>
    <li><a href="#/two">Two</a></li>
    <li><a href="#/three">Three</a></li>
  </ul>
  
  <div id="content">
    <div id="one">
    	<ul class="list_load">
    		<a class="menu-list" href="<?= Url::to(['site/index'])?>"><li class="list_item menu-settings"><i class="fa fa-home iconz" aria-hidden="true"></i></i>Dashboard</li></a>
    		<a class="menu-list" href="<?= Url::to(['folder/index'])?>"><li class="list_item menu-settings"><i class="fa fa-folder iconz" aria-hidden="true"></i>Folder Vault</li></a>
    		<?php if (isset($this->blocks['subfolders'])){ ?>
			 	<?= MenuAccordionWidget::widget();?>
			 <?php } ?> 
            <li class="list_item"><?= ViewBoardWidget::widget();?></li>
		</ul>
    </div>
<?php if (isset($this->blocks['sidebar'])){ ?>
            <?= $this->blocks['sidebar'] ?>
<?php }else{ ?>
      <div id="two">
    	<ul class="list_load">
    		<!-- <li class="list_item"><a href="#">List Item 01</a></li> -->
			<?= ClientsAccordionWidget::widget();?>
			<?= SuppliersAccordionWidget::widget();?>
			<?= UsersAccordionWidget::widget();?>
			<?= ContactsAccordionWidget::widget();?>
    	</ul>
    </div>
    <div id="three">
    	<ul class="list_load">
    		<?= SettingsAccordionWidget::widget();?>

			<a class="menu-list" href="<?= Url::to(['site/logout'])?>"><li class="list_item menu-settings"><i class="fa fa-sign-out iconz" aria-hidden="true"></i>Logout</li></a>
			
		</ul>
    </div>
<?php } ?>
  </div>
  
</div>
</div>