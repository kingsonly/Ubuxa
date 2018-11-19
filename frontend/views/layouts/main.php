<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;
use app\assets\IndexDashboardAsset;
use app\assets\NewIndexDashboardAsset;
use boffins_vendor\components\controllers\MenuWidget;

Yii::$app->settingscomponent->boffinsUsersAsset()
?>
<?php $this->beginPage() ?>
<? Yii::$app->language  = Yii::$app->settingscomponent->boffinsUsersLanguage();?>
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
          
			 
			<?= Html::a(Html::tag('span',Html::tag('b',Yii::$app->settingscomponent->boffinsLogo()),['class' => 'logo-lg']), ['/site/index'],['class' => 'img-circle']) ?>

          
        </div>

        
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
      
		
    </section>

      <!-- Main content -->
     <section class="content">
		 <div class="col-lg-12">
			<?= Alert::widget([
				   'options' => ['class' => 'alert-info','id'=>'flas'],
				   'body' => 'test<button class="btn btn-success">Feedback</button>',
					 ]);?>
		</div>
        <?= $content ?>
		 <?= MenuWidget::widget(); ?>
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
