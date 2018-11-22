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
<style type="text/css">
table{
  width:100%;
  table-layout: fixed;
}
.tbl-header{
  background-color: rgba(255,255,255,0.3);
 }
.tbl-content{
  height:300px;
  overflow-x:auto;
  margin-top: 0px;
  border: 1px solid rgba(255,255,255,0.3);
}
th{
  padding: 20px 15px;
  text-align: left;
  font-weight: 500;
  font-size: 12px;
  color: #666;
  text-transform: uppercase;
}
td{
  padding: 15px;
  text-align: left;
  vertical-align:middle;
  font-weight: 300;
  font-size: 12px;
  color: #666;
  border-bottom: solid 1px rgba(255,255,255,0.1);
}
.close-arrow{
	cursor: pointer;
}


/* demo styles */

@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);

</style>
<div class="side_menu side-drop">

    	<div class="client-container" style="visibility: hidden;width:300px;min-height:1px;background:#fff;">
    		<div class="row client-content" style="display: none">
    			<div class="col-sm-12">
    				<div class="col-md-10" style="height: 100px"></div>
    				<div class="col-md-2" style="padding-top:20px">
    					<i class="fa fa-arrow-left fa-2x close-arrow" style="height: 100px"></i>
    				</div>
    			</div>
    			<div>
    				
    			</div>
    		</div>
    	</div>

    	<div class="settings-container" style="visibility: hidden;width:300px;min-height:1px;background:#fff;">
        <div class="row settings-content" style="display: none">
          <div class="col-sm-12">
            <div class="col-md-10"><span class="settings-text">Settings</span></div>
            <div class="col-md-2" style="padding-top:20px">
              <i class="fa fa-arrow-left fa-2x close-arrow" style="height: 100px"></i>
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
					<img src="images/ubuxalogo.png" class="ubuxalogo"/>
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

			<li class="list_item menu-settings"><a class="menu-list" href="<?= Url::to(['site/logout'])?>"><i class="fa fa-sign-out iconz" aria-hidden="true"></i>Logout</a></li>
			
		</ul>
    </div>
<?php } ?>
  </div>
  
</div>
</div>