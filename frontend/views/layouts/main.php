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
use boffins_vendor\components\controllers\ChatNotificationWidget;
use boffins_vendor\components\controllers\FeedbackWidget;
use frontend\models\UserFeedback;
use frontend\assets\AppAsset;
use yii\widgets\Pjax;
AppAsset::register($this);

$feedback = new UserFeedback();

Yii::$app->settingscomponent->boffinsUsersAsset();
$waitToLoad = Yii::$app->settingscomponent->boffinsLoaderImage($size = 'md', $type = 'link');
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
	<style>
		.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(<?= $waitToLoad; ?>) center no-repeat #fff;
}
.customer-info{
	background: black !important;
}
		
		
.images ul li img {
	width: 400px;
	height: 266px;
}
.images ul li {
	display: inline-block;
}

	</style>
    <?php $this->head() ?>
	<? $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Yii::$app->settingscomponent->boffinsFavIcon()]); ?>
	
</head>
<body class="skin-red hold-transition layout-top-nav" data-folderviewurl="<?= Url::to(['folder/view'])?>" data-username="<?= Yii::$app->user->identity->username;?>" data-newmessageurl="<?= Url::to(['folder/new-message'])?>" data-fullname="<?= Yii::$app->user->identity->fullName;?>" data-userimage="<?= !empty(Yii::$app->user->identity->profile_image)?Yii::$app->user->identity->profile_image:'images/users/default-user.png';?>" data-sessionlink="<?= Url::to(['site/update-socket-user-stack'])?>" data-getfolderdetailsurl="<?= Url::to(['site/get-chat-folder-details'])?>" data-chatnotificationurl="<?= Url::to(['site/update-chat-notification'])?>" >
<!-- <div class="msg_chat_container msg-right">'+data.msg+' </div> -->
	<div class="se-pre-con"></div>

<?php $this->beginBody() ?>
<?php
  if(isset(Yii::$app->user->identity->person_id)) {
    if(!defined('USERID')){
  		define("USERID", Yii::$app->user->identity->person_id);
    }
  }
?>
    <style>

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
    .content{
      position: relative;
    }
    .feedback-button{
      text-decoration: none;
    }

    #flas{
      position: relative;
      padding: 16px;
      display: none;
      box-shadow: -8px 8px 25px -2px rgba(0, 0, 0, 0.1);
      cursor: unset;
    }
    .alert-text{
      color: #000;
      font-size: 15px;
    }
    .main-name{
      font-weight: 600;
      text-transform: capitalize;
    }
.alert-info{
  background-color: #d9edf7 !important;
  border:0px !important;
}
.feedback-button{
  background-color:#3c8dbc !important;
}
.alert-text{
  text-align: left !important;
}
		.hide-label{
			display: none;
		}
    </style>
    

<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          
			 
			<?= Html::a(Html::tag('span',Html::tag('b',Yii::$app->settingscomponent->boffinsLogo()),['class' => 'logo-lg']), ['/folder/index'],['class' => 'img-circle']) ?>

          
        </div>
		  <?php Pjax::begin(['id'=>'chat-refresher']); ?>
		  <div class="navbar-custom-menu">
			  
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle hide-counter" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success hide-label"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header header-info"></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                 <?= ChatNotificationWidget::widget(); ?>
                  <!-- end message -->
                </ul>
              </li>
              
            </ul>
          </li>
          
        </ul>
			  <?php

$flashs = <<<ABC
  $(document).on('click','.hide-counter',function(){
			  	localStorage.removeItem('chatcounter');
				$(document).find('.hide-label').hide();
			  })
			  		$.pjax.reload({container:"#"+"chat-refresher",async: false});
					if ("chatcounter" in localStorage) {
					var chtacounter = localStorage.getItem('chatcounter')
						alert(chtacounter);
						$(document).find('.header-info').html('You have '+chtacounter+' messages');
						$(document).find('.hide-label').show().html(chtacounter);
					} else {
						$(document).find('.header-info').html('You have 0 message');
						$(document).find('.hide-label').hide();
					}
ABC;
$this->registerJs($flashs);
?>
			  
		
			  
      </div>
<?php Pjax::end(); ?>
        
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
				   'options' => ['class' => 'alert-info btn btn-primary','id'=>'flas'],
				   'body' => '<div class="alert-text">Hi <span class="main-name">'.yii::$app->user->identity->firstname.'</span>, you are running on beta.</div><a href="#" class="feedback-button btn btn-primary" id="open-feedback-form">Give Feedback</a>',

					 ]);?>
		</div>
        <?= FeedbackWidget::widget(['feedback' => $feedback]); ?>
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
      <b>Version</b> 1.4
    </div>
    <!--<strong>Copyright &copy; Tycol 2017<a href="#"> Boffins Systems</a>.</strong>--> All rights reserved.
</footer>

<?php $this->endBody() ?>
  <!--  MouseStats:Begin  -->
<script type="text/javascript">var MouseStats_Commands=MouseStats_Commands?MouseStats_Commands:[]; (function(){function b(){if(void 0==document.getElementById("__mstrkscpt")){var a=document.createElement("script");a.type="text/javascript";a.id="__mstrkscpt";a.src=("https:"==document.location.protocol?"https://ssl":"http://www2")+".mousestats.com/js/5/6/5671434762617532649.js?"+Math.floor((new Date).getTime()/6E5);a.async=!0;a.defer=!0;(document.getElementsByTagName("head")[0]||document.getElementsByTagName("body")[0]).appendChild(a)}}window.attachEvent?window.attachEvent("onload",b):window.addEventListener("load", b,!1);"complete"===document.readyState&&b()})(); </script>
<!--  MouseStats:End  -->
<?php
$imgs = 'images/emojis/img';
$flash = <<<JS
  setTimeout(function(){ 
      $('#flas').fadeIn('slow');
   }, 10000);
JS;
$this->registerJs($flash);
?>
</body>
	
</html>
<?php $this->endPage() ?>
 