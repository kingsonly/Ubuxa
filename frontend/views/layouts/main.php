
<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
Yii::$app->settingscomponent->buffinsUsersAsset()

?>
<?php $this->beginPage() ?>
<? Yii::$app->language  = Yii::$app->settingscomponent->buffinsUsersLanguage();?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="app">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	
</head>
<? $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '../web/images/logo1.png']); ?>
<body class="skin-red sidebar-mini">
<?php $this->beginBody() ?>
<?php
    if(isset(Yii::$app->user->identity->person_id)){
define("USERID", Yii::$app->user->identity->person_id);
//echo GREETING;
    }
?>
	
    <style>
    .fa{color:#dd4b39 !important;}
        .iconimage{
            background: url('../web/images/logo1.jpg') no-repeat ;
            background-size: 100% 100%;
        }
        h1>small{
            font-size:30px !important;
        }
        h1{
            font-size:40px;
        }
    </style>
    
<div class="wrapper">
    <header class="main-header">
    <!-- Logo -->
    
		
		<?= Html::a(Html::tag('span',Html::tag('b',Yii::$app->settingscomponent->buffinsLogo()),['class' => 'logo-lg']), ['/site/index'],['class' => 'logo']) ?>
		
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
       
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
				<?= Html::img('@web/images/male.png', ['alt' => 'logo', 'class' => 'user-image' ]); ?>
			
              <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
               
				  <?= Html::img('@web/images/logo1.jpg', ['alt' => 'logo', 'class' => 'img-circle' ]); ?>

                <p>
                  <?= Yii::$app->user->identity->username ?>
                  
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                 
                    <?= Html::a('Logout', Url::to(['/site/logout']), ['data-method' => 'POST','class' => 'btn btn-default btn-flat']) ?>
					
                    
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
    <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <!--<li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>-->
          
        
		<li>
			<?= Html::a(Html::tag('i', '', ['class' => 'fa fa-th','title' => 'Dashboard']). Html::tag('span', 'Dashboard', ['class' => '','title' => 'Open folder']), ['site/index'], ['class' => '']) ?>
		</li>
		
		
		  
          
          <?php if (isset($this->blocks['createFolder'])): ?>
            <?= $this->blocks['createFolder'] ?>
          <?php endif; ?>
          <?php if (isset($this->blocks['folderSidebar'])): ?>
            <?= $this->blocks['folderSidebar'] ?>
          <?php endif; ?>
          
          <!--
          <li>
          <a href="pages/widgets.html">
            <i class="fa fa-folder"></i> <span>Folders</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>
          
       <li>
          <a href="pages/widgets.html">
            <i class="fa fa-tasks"></i> <span>Project</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>
          
          
          <li>
          <a href="pages/widgets.html">
            <i class="fa fa-shopping-cart"></i> <span>Order</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"></small>
            </span>
          </a>
        </li>
          
          <li>
          <a href="pages/widgets.html">
            <i class="fa fa-credit-card"></i> <span>Invoice</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
          
       
       -->
        
        
        
        
       
    </section>
    <!-- /.sidebar -->
  </aside> 
 
  <!-- Left side column. contains the logo and sidebar -->

    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="font-size:40px">
       <?php if (isset($this->blocks['folderview'])): ?>
            <?= $this->blocks['folderview'] ?>
          <?php endif; ?>
        <?php if (isset($this->blocks['projectview'])): ?>
            <?= $this->blocks['projectview'] ?>
          <?php endif; ?>
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?= \yii\helpers\Html::a( 'Home', ['site/index']);?> </a></li>
        <li class="active"> <?= \yii\helpers\Html::a( 'Back', Yii::$app->request->referrer);?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?= $content ?>
    </section>
    </div>
</div>


    
<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.2.0
    </div>
    <!--<strong>Copyright &copy; Tycol 2017<a href="#"> Boffins Systems</a>.</strong>--> All rights reserved.
  </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
