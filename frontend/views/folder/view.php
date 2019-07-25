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


$this->title = 'Folder Dashboard';


use boffins_vendor\components\controllers\MenuWidget;

/* @var $this yii\web\View */

$img = $model->folder_image; 
?>
<style>
.row.content {
	 height: 1500px;
}
 .onboardnav {
	 background-color: #f1f1f1;
	 height: 100%;
}
}
 footer {
	 background-color: #555;
	 color: white;
	 padding: 15px;
}
 @media screen and (max-width: 767px) {
	 .onboardnav {
		 height: auto;
		 padding: 15px;
	}
	 .row.content {
		 height: auto;
	}
}
 .popover {
	 max-width: 375px;
}
 .popover .fa {
	 color: #D47075;
	 padding-top: 5px;
}
 .popover-content {
	 /* padding: 5px 0; */
}
 .hca-tooltip--left-nav {
	 position: absolute;
	 background-color: #fff;
	 border-radius: 6px;
	 border: 1px solid #efefef;
	 left: 78px;
	 top: 60px;
	 padding: 10px 10px 15px 15px;
	 font-size: 1em;
	 width: 340px;
	 box-shadow: 0 2px 8px rgba(0,0,0,0.4);
	 color: #000;
	 z-index: 1000;
	 text-decoration: none;
}
 .hca-tooltip--left-nav .hca-tooltip--okay-btn {
	 padding: 12px 20px;
	 line-height: 15px;
	 background-color: #408DDD;
	 border: none;
	 color: #fff;
}
 .hca-tooltip--left-nav .hca-border-circle--40 {
	 width: 40px;
	 height: 40px;
	 margin-top: 10px;
	 border-radius: 50%;
	 font-size: .8em;
	 color: #F07C8B;
	 line-height: 38px;
	 text-align: center;
	 background: #fff;
	 border: 1px solid #F07C8B;
}

*{
	text-decoration: none;
}
	#flash {
		display: none;
	}

	#dashboard-content {
		display: grid;
		grid-gap: 50px 10px;
		grid-template-columns: 40% 20% 40%;
		grid-template-areas: 	'folders folders folders'
								'flash flash flash'
								'remarks tasks tasks';
	}
	
	.grid-item {
		
	}
	
	.grid-item.folder {
		grid-area: folders;
	}
	
	.grid-item.flash {
		grid-area: flash;
	}
	
	.grid-item.remark-box {
		grid-area: remarks;
	}
	
	.grid-item.task-box {
		grid-area: tasks;
	}

	.folderdiv{
		height: 50px;
	}

	.top-box {
		padding-bottom: 50px;
	}
	
	@media screen and (min-width: 280px) and (max-width: 599px) {
			#dashboard-content {
				grid-gap: 0px 20px;
				grid-template-columns: 100%;
				grid-template-areas: 	'folders'
										'flash'
										'tasks'
										'remarks';
			}
	}

	@media (max-width:991px) {
 	 	.column-margin { 
 	 		margin: 20px 0; 
 	 	}
 	 	.act-margin {
 	 		margin: 5px 0;
 	 	}
 	 	.info-1 {
			margin-left: 8%;
			width: 80%;
		}
	}
    .content-header{
        display:none;
    }
    .just-for-test{
      background-color: red;
    }
  /* toast */
.toastit {
    line-height: 1.5;
    margin-bottom: 1em;
    padding: 1.25em;
    position: fixed;
    right: 47px;
    top: 1em;
    transition: 0.15s ease-in-out;
    width: 300px;
    z-index: 9999;
}
.hide-loads{
  display: none;
}

.toastit.on {
  transform: translateX(-220px);
}

.closeit {
  cursor: pointer;
  float: right;
  font-size: 2.25rem;
  line-height: 0.7;
  margin-left: 1em;
  opacity: .8;
}

.jamit {
  background-color: #62b168;
  color: #fff;
  border-radius: 3px;
  box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
}  
	
	
	
	

.floating-chat {
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  position: fixed;
  bottom: 10px;
  right: 10px;
  width: 40px;
  height: 40px;
  transform: translateY(70px);
  transition: all 250ms ease-out;
  border-radius: 50%;
  opacity: 0;
  background: -moz-linear-gradient(-45deg, #183850 0, #183850 25%, #192c46 50%, #22254c 75%, #22254c 100%);
  background: -webkit-linear-gradient(-45deg, #183850 0, #183850 25%, #192c46 50%, #22254c 75%, #22254c 100%);
  background-repeat: no-repeat;
  background-attachment: fixed;
}
.floating-chat.enter:hover {
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
  opacity: 1;
}
.floating-chat.enter {
  transform: translateY(0);
  opacity: 0.6;
  box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.12), 0px 1px 2px rgba(0, 0, 0, 0.14);
}
.floating-chat.expand {
  width: 250px;
  max-height: 400px;
  height: 400px;
  border-radius: 5px;
  cursor: auto;
  opacity: 1;
}
.floating-chat :focus {
  outline: 0;
  box-shadow: 0 0 3pt 2pt rgba(14, 200, 121, 0.3);
}
.floating-chat button {
  background: transparent;
  border: 0;
  color: white;
  text-transform: uppercase;
  border-radius: 3px;
  cursor: pointer;
}
.floating-chat .chat {
  display: flex;
  flex-direction: column;
  position: absolute;
  opacity: 0;
  width: 1px;
  height: 1px;
  border-radius: 50%;
  transition: all 250ms ease-out;
  margin: auto;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.floating-chat .chat.enter {
  opacity: 1;
  border-radius: 0;
  margin: 10px;
  width: auto;
  height: auto;
}
.floating-chat .chat .header {
  flex-shrink: 0;
  padding-bottom: 10px;
  display: flex;
  background: transparent;
}
.floating-chat .chat .header .title {
  flex-grow: 1;
  flex-shrink: 1;
  padding: 0 5px;
}
.floating-chat .chat .header button {
  flex-shrink: 0;
}
.floating-chat .chat .messages {
  padding: 10px;
  margin: 0;
  list-style: none;
  overflow-y: scroll;
  overflow-x: hidden;
  flex-grow: 1;
  border-radius: 4px;
  background: transparent;
}
.floating-chat .chat .messages::-webkit-scrollbar {
  width: 5px;
}
.floating-chat .chat .messages::-webkit-scrollbar-track {
  border-radius: 5px;
  background-color: rgba(25, 147, 147, 0.1);
}
.floating-chat .chat .messages::-webkit-scrollbar-thumb {
  border-radius: 5px;
  background-color: rgba(25, 147, 147, 0.2);
}
.floating-chat .chat .messages li {
  position: relative;
  clear: both;
  display: inline-block;
  padding: 14px;
  margin: 0 0 20px 0;
  font: 12px/16px "Noto Sans", sans-serif;
  border-radius: 10px;
  background-color: rgba(25, 147, 147, 0.2);
  word-wrap: break-word;
  max-width: 81%;
}
.floating-chat .chat .messages li:before {
  position: absolute;
  top: 0;
  width: 25px;
  height: 25px;
  border-radius: 25px;
  content: "";
  background-size: cover;
}
.floating-chat .chat .messages li:after {
  position: absolute;
  top: 10px;
  content: "";
  width: 0;
  height: 0;
  border-top: 10px solid rgba(25, 147, 147, 0.2);
}
.floating-chat .chat .messages li.other {
  animation: show-chat-odd 0.15s 1 ease-in;
  -moz-animation: show-chat-odd 0.15s 1 ease-in;
  -webkit-animation: show-chat-odd 0.15s 1 ease-in;
  float: right;
  margin-right: 45px;
  color: #0ad5c1;
}
.floating-chat .chat .messages li.other:before {
  right: -45px;
  background-image: url(https://github.com/Thatkookooguy.png);
}
.floating-chat .chat .messages li.other:after {
  border-right: 10px solid transparent;
  right: -10px;
}
.floating-chat .chat .messages li.self {
  animation: show-chat-even 0.15s 1 ease-in;
  -moz-animation: show-chat-even 0.15s 1 ease-in;
  -webkit-animation: show-chat-even 0.15s 1 ease-in;
  float: left;
  margin-left: 45px;
  color: #0ec879;
}
.floating-chat .chat .messages li.self:before {
  left: -45px;
  background-image: url(https://github.com/ortichon.png);
}
.floating-chat .chat .messages li.self:after {
  border-left: 10px solid transparent;
  left: -10px;
}
.floating-chat .chat .footer {
  flex-shrink: 0;
  display: flex;
  padding-top: 10px;
  max-height: 90px;
  background: transparent;
}
.floating-chat .chat .footer .text-box {
  border-radius: 3px;
  background: rgba(25, 147, 147, 0.2);
  min-height: 100%;
  width: 100%;
  margin-right: 5px;
  color: #0ec879;
  overflow-y: auto;
  padding: 2px 5px;
}
.floating-chat .chat .footer .text-box::-webkit-scrollbar {
  width: 5px;
}
.floating-chat .chat .footer .text-box::-webkit-scrollbar-track {
  border-radius: 5px;
  background-color: rgba(25, 147, 147, 0.1);
}
.floating-chat .chat .footer .text-box::-webkit-scrollbar-thumb {
  border-radius: 5px;
  background-color: rgba(25, 147, 147, 0.2);
}
@keyframes show-chat-even {
  0% {
    margin-left: -480px;
  }
  100% {
    margin-left: 0;
  }
}
@-moz-keyframes show-chat-even {
  0% {
    margin-left: -480px;
  }
  100% {
    margin-left: 0;
  }
}
@-webkit-keyframes show-chat-even {
  0% {
    margin-left: -480px;
  }
  100% {
    margin-left: 0;
  }
}
@keyframes show-chat-odd {
  0% {
    margin-right: -480px;
  }
  100% {
    margin-right: 0;
  }
}
@-moz-keyframes show-chat-odd {
  0% {
    margin-right: -480px;
  }
  100% {
    margin-right: 0;
  }
}
@-webkit-keyframes show-chat-odd {
  0% {
    margin-right: -480px;
  }
  100% {
    margin-right: 0;
  }
}

	.chatindicator-container{
		display: block;
		width: auto;
		
	}
</style>
<div class="toastit jamit hide-loads" id="edocument-io" aria-hidden="true">
  <!--<span class="closeit" aria-role="button" tabindex="0">&times;</span>-->
  <span id="folder-doc-loader"></span>
</div>
<div class="board-specfic" data-folderId="<?=$model->id;?>"></div>

<?= EdocumentWidget::widget(['docsize'=>100,'target'=>'folder', 'textPadding'=>100,'attachIcon'=>'yes','referenceID'=>$model->id,'reference'=>'folder','iconPadding'=>10, 'edocument' => 'dropzone']);?>
<? $onboardingExists = true; ?>
<section>
    <div class="container-fluid">
        <div class="row">
            <section>
                  <div class="row top-box">
                  	<?= ActivitiesWidget::widget() ?>
                  	<?= OnlineClients::widget(['model' => $model, 'taskStats' => $model->clipOn['task'], 'users' => $model->users]) ?>
                  </div>  
                    	<div class="row">
							
   						 	<?= FolderDetails::widget(['model' => $model,'author'=> $model->folderManagerByRole->user->nameString,'onboardingExists' => $onboardingExists, 'onboarding' => $onboarding,'userId' => $userId, 'folderDetailsImage' => $img ,'imageUrl' => Url::to(['folder/update-folder-image','id' => $model->id])]) ?>
   						 	<?= SubFolders::widget(['placeHolderString'=> 'a new sub','folderCarouselWidgetAttributes' =>['class' => 'folder','folderPrivacy'=>$model->private_folder],'createButtonWidgetAttributes' =>['class' => 'folder'],'displayModel' => $model->subFolders,'onboardingExists' => $onboardingExists, 'onboarding' => $onboarding,'userId' => $userId,]) ?>
                    	</div>
            </section>
        </div>
 
        <div class="row">
			<?php Pjax::begin(['id'=>'component-pjax']); ?>
			<?

				$components  = ['PAYMENT','PROJECT','INVOICE','ORDER','CORRESPONDECE'];
			
			?>
			
        	<?= ComponentWidget::widget(['users'=>$model->users,'components' => $components,'otherAttributes' =>['height'=>45],'id'=>$id,'formAction' => $componentCreateUrl,'model' => $componentModel,'displayModel' => $model->folderComponentTemplate,'folderId'=>$model->id]) ?>
			<?php Pjax::end(); ?>
            <section>
            	<div class="row test5">
            		<?php Pjax::begin(['id'=>'task-list-refresh']); ?>
            				<?= TaskWidget::widget(['task' => $model->clipOn['task'], 'taskModel' => $taskModel,'parentOwnerId' => $id, 'onboardingExists' => $onboardingExists, 'onboarding' => $onboarding,'userId' => $userId, 'folderId' => $model->id]) ?>
            		<?php Pjax::end(); ?>

            		<?= RemarksWidget::widget(['remarkModel' => $remarkModel, 'parentOwnerId' => $id,'modelName'=>'folder', 'remarks' => $model->clipOn['remark'], 'onboardingExists' => $onboardingExists, 'onboarding' => $onboarding, 'userId' => $userId]) ?>
            	</div>
            </section>
        </div>
    </div>


      <? $this->beginBlock('edocument')?>
      <?php Pjax::begin(['id'=>'folder-edoc']); ?>
        <?= EdocumentWidget::widget(['referenceID'=>$model->id,'reference'=>'folder','edocument' => 'clickUpload','target' => 'folderUpload', 'attachIcon' => 'yes']);?>
        
      <?php Pjax::end(); ?>
      <? $this->endBlock();?>

  <? $this->beginBlock('subfolders')?>
  <label class="accord-label" for="group-1"><i class="fa fa-folder-open iconz"></i>Subfolders
  	<?php if(!empty($model->subFolders)){ ?>
  		<i class="fa fa-chevron-down iconz-down"></i>
  	<?php }?>
  </label>
          <ul class="first-list">
  	<?php 
    	$num = 1;
        foreach ($model->subFolders as $subfolders) {
        $folderUrl = Url::to(['folder/view', 'id' => $subfolders->id]);
        $menuId = $subfolders->id;
    ?>		
    <li class="has-children">
	         	<input type="checkbox" class="accord-input" name ="sub-group-<?=$num; ?>" id="sub-group-<?=$num; ?>"> 
	            <label class="accord-label menu-check toggled" for="sub-group-<?=$num; ?>" data-menuId="<?=$menuId;?>" id="menu-folders<?=$menuId ?>"><i class="fa fa-folder iconz"></i><?= $subfolders->title ?>
			            <?php if(!empty($subfolders->subFolders)){ ?>
			            	<i class="fa fa-chevron-down iconz-down"></i>
			            <?php }?>
	            	<input type="hidden" value="false" name="">
	        	</label>	            
	            <span id="folder-content-loading" style="text-align: center; display: none; color:#ccc"> loading...</span>
            </li>
           
        <?php $num++; }?>
        </ul>
  <? $this->endBlock();?>

	
  </section>

<? 
    Modal::begin([
        'header' =>'<h1 id="headers"></h1>',
        'id' => 'boardContent',
        'size' => 'modal-md', 
    ]);
?>
<div id="viewcontent">
</div>
<?
    Modal::end();
?>
<!--
to be fixed after launch
<div class="chatindicator-container">
<div class="floating-chat">
    <i class="fa fa-comments" aria-hidden="true"></i>
    <div class="chat">
        <div class="header">
            <span class="title">
                
            </span>
            <button>
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
                         
        </div>
        <ul class="messages">
            <li class="other">asdasdasasdasdasasdasdasasdasdasasdasdasasdasdasasdasdas</li>
            
        </ul>
        
    </div>
</div>
	</div>
-->
<?php 
$menuFolderId = $id;
$subfoldersUrl = Url::to(['folder/menusubfolders','src' => 'ref1']);
$mainOnboarding = Url::to(['onboarding/main-onboarding']);
$getuserId = Yii::$app->user->identity->id;
$edocUrl = Url::to(['edocument/index','folderId' => $id]);
$indexJs = <<<JS
var RedisSocket = io('//127.0.0.1:4000/redis');
localStorage.setItem("skipValidation", "");
RedisSocket.on('redis message', function(msg){
$(document).find('.stream_activity').append('<p class="act_str">'+msg+'</p>')
$('.act_count').text($('.act_str').length)

})
RedisSocket.on('messages', function(msg){
  console.log(msg)
})
var mymenu = 1;
$(document).on('click', '.menu-check', function(){
	var getInput = $(this).find('input').val();
	
	if(getInput == 'true'){
		return false;
	} else {
		$(this).addClass('clicked');
		var getThis = $(this);
		var menuIds;
		menuIds = $(this).attr('data-menuId');
  		mymenu++;
  		mymenus(mymenu, menuIds, getThis);
  		$(this).find('input').val('true');

	}
});
function mymenus(mymenu, menuIds, getThis){
    $('#folder-content-loading').show();
    $.post('$subfoldersUrl',
    {
      page:mymenu,
      id: menuIds,
    },
    function(data){
        if(data.trim().length == 0){
            $('#folder-content-loading').text('finished');
            getThis.removeClass('clicked');
        }
        $('#folder-content-loading').hide();
        if ($.trim(data)){
	        $('.clicked').after(data);
	        getThis.removeClass('clicked');
	        getThis.nextAll().css('padding-left','30px');
        }
        })
}

function _MainOnboarding(){
          $.ajax({
              url: '$mainOnboarding',
              type: 'POST', 
              data: {
                  user_id: $userId,
                },
              success: function(res, sec){
                   console.log('Status updated');
              },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
          });
}
function defaultOnboarding() {

  var folderTour = new Tour({
    name: "folderTour",
    steps: [
        {
          element: ".folderdetls",
          title: "Folder Details",            
          content: "You can view your folder details here",
          placement: 'right',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-folder icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".subfolder-container",
          title: "Sub-folders",            
          content: "View subfolders for this folder here, you also create new folders from here",
          placement: 'left',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-folder-open icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".taskz-listz",
          title: "Task management",            
          content: "You can create, manage and view all task from here",
          placement: 'right',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-tasks icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: "#flux",
          title: "Comments",            
          content: "You can view all comments from here, for this folder",
          placement: 'left',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-reply-all icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: "#folder-tipz",
          title: "Tips",            
          content: "Click on the question mark icon to view more tips",
          placement: 'left',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='next' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-question icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".menu-plus",
          title: "Tips",            
          content: "Do more from the side menu.",
          placement: 'right',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='next' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-plus icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
          onShown: function(taskTour){
            $(".tour-backdrop").appendTo(".menu-icon ");
            $(".tour-step-background").appendTo(".menu-icon ");
            $(".tour-step-background").css("left", "0px");
            },
        },
        {
          element: ".board-open",
          title: "Task board",
          content: "You can get access to more features for task management from the action menu.",
          onShow: function(taskTour){
                //$('.side_menu').addClass('side-drop');
                $('.list_load, .list_item').stop();
                $(this).removeClass('closed').addClass('opened');

                $('.side_menu').css({ 'left':'0px' });

                var count = $('.list_item').length;
                $('.list_load').slideDown( (count*.6)*100 );
                $('.list_item').each(function(i){
                var thisLI = $(this);
                timeOut = 100*i;
                setTimeout(function(){
                  thisLI.css({
                    'opacity':'1',
                    'margin-left':'0'
                  });
                },100*i);
              });
            },
          onShown: function(taskTour){
            $(".tour-backdrop").appendTo("#content");
            $(".tour-step-background").appendTo("#content");
            $(".tour-step-background").css("left", "0px");
            },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-tasks icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".edoc-label",
          title: "Add Documents",
          content: "You can add files here and also view and manage documents",
          onShown: function(taskTour){
            $(".tour-backdrop").appendTo("#content");
            $(".tour-step-background").appendTo("#content");
            $(".tour-step-background").css("left", "0px");
            },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-file-text-o icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='end' class='btn hca-tooltip--okay-btn'>Close</a></div></div></div>",
        },
       
      ],
    backdrop: true,  
    storage: false,
    smartPlacement: true,
    onEnd: function (folderTour) {
            _MainOnboarding();
            $('.edocument-container').css({
               'width':'300px',
               'min-height':'1px',
               'visibility':'hidden'
              }).removeClass('opened');
              $('.edocument-content').hide();
              setTimeout(function() { 
                $('.sider').show('slow');
            }, 900);
            $('.side_menu').addClass('side-drop');
            $('#mySidenav').css({'width':'0'})
            $('.list_load, .list_item').stop();

            $('.side_menu').css({ 'left':'-300px' });

            var count = $('.list_item').length;
            $('.list_item').css({
              'opacity':'0',
              'margin-left':'-20px'
            });
            $('.list_load').slideUp(300);
        },
  });
 folderTour.init();
 folderTour.start();
};




JS;
 
$this->registerJs($indexJs);
?>

<?php if(!$onboardingExists){ ?>
	<?php
$script = <<< JS
    defaultOnboarding();
JS;
$this->registerJs($script);
	?>
<?php }?>