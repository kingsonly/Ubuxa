<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\IndexDashboardAsset;
use app\assets\NewIndexDashboardAsset;

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
    <title>

    <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-red hold-transition layout-top-nav">
<?php $this->beginBody() ?>
<?php
    if(isset(Yii::$app->user->identity->person_id)) {
		define("USERID", Yii::$app->user->identity->person_id);
    }
?>
    <style>
	
	/****
	 * What is the meaning of this???
	 * WHY IS THERE INLINE CSS IN A LAYOUT??? WHAT HAPPENED TO ADDING IT TO A STYLESHEET???
	 */ 
    .fa{color:#dd4b39 !important;}
        .iconimage {
            background: url('../web/images/logo1.jpg') no-repeat ;
            background-size: 100% 100%;
        }
        h1>small{
            font-size:30px !important;
        }
        h1{
            font-size:40px;
        }
		.logo{
			 height: 50px !important;
    		width: 100% !important;
			background: #DD4B39 !important;
			height: 45px !important;
    		position: relative;
    		top: -13px !important;
		}
		#refresh{
      cursor: pointer;
    }
    </style>
    
<? $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '../web/images/logo1.png']); ?>

<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          
			 
			<?= Html::a(Html::tag('span',Html::tag('b',Yii::$app->settingscomponent->buffinsLogo()),['class' => 'logo-lg']), ['/site/index'],['class' => 'img-circle']) ?>

          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Main link menu start -->
        
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <!-- Tasks Menu -->
            
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-right: 30px;">
                <!-- The user image in the navbar-->
               
				  <?= Html::img('@web/images/male.png', ['alt' => 'logo', 'class' => 'user-image' ]); ?>
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                 
				  <?= Html::img('@web/images/male.png', ['alt' => 'logo', 'class' => 'img-circle' ]); ?>

                  <p><?= Yii::$app->user->identity->username ?></p>
                </li>
                <!-- Menu Body -->
                
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
			  
			 
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
	
	
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
	
    <section class="content-header">
      <h1 style="font-size:40px;margin-left: 20px">
       <?php if (isset($this->blocks['folderview'])): ?>
            <?= $this->blocks['folderview'] ?>
          <?php endif; ?>
        <?php if (isset($this->blocks['projectview'])): ?>
            <?= $this->blocks['projectview'] ?>
          <?php endif; ?>
        
      </h1>
      <ol class="breadcrumb" style="padding-right: 23px">
        <li><a href="#"><i class="fa fa-dashboard"></i><?= \yii\helpers\Html::a( 'Dashboard', ['site/index']);?> </a></li>
        
      </ol>
		
		
    </section>

      <!-- Main content -->
     <section class="content">
        <?= $content ?>
    </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  
</div>


    
<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.2
    </div>
    <!--<strong>Copyright &copy; Tycol 2017<a href="#"> Boffins Systems</a>.</strong>--> All rights reserved.
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
