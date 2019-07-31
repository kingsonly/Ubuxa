<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\FolderCarouselWidget;
use boffins_vendor\components\controllers\CreateButtonWidget;
use boffins_vendor\components\controllers\SearchFormWidget;
use yii\widgets\Pjax;
use frontend\models\Onboarding;
?>

<style type="text/css">
	.subfolder-container{
		padding-left: 15px;
	    background: #fff;
	    padding-right: 15px;
	    box-shadow: 4px 19px 25px -2px rgba(0,0,0,0.1);
		height: 160px;
		overflow: hidden;
	}

.box-sub-folders {
		height:122px;
	}

	.box-subfolders {
		height:122px;
	}
	.subheader {
	    padding-top: 7px;
	    padding-left: 0px !important;
	    padding-right: 26px !important;
	    padding-bottom: 7px;
	    font-weight: bold;
	    background-color: #fff;
	    border-bottom: 1px solid #ccc;
	}
	
	.sub-folder{
		padding-left: 0px !important;
	    padding-right: 0px !important;
	}
	.sub-second {
		padding-right: 0px !important;
    	padding-left: 0px !important;
	}
	.subfirst {
		background-color: transparent;
    padding-left: 0px !important;
    padding-right: 0px !important;
    background: #fff;
	}
	.info-2 {
		background-color: #fff;
	}
	.subheader{
		margin-bottom: 20px;
	}
	.subfolder-tips{
		right: 2px !important;
	}
 .popover {
	 max-width: 375px;
}
 .popover .fa {
	 color: #545e83;
	 padding-top: 5px;
}
.icon-tour{
	color: #545e83 !important;
}
 .popover-content {
	 padding: 5px 0;
}
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
 
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php Pjax::begin(['id'=>'create-folder-refresh']); ?>
<div class="col-md-7">
	<div class="col-sm-12 col-xs-12 subfolder-container column-margin">
		<div class="col-sm-12 col-xs-12 subheader">
			<div class="col-sm-3 col-xs-3 sub-folder">
				<span class="subfolder">SUB FOLDERS</span> 
			</div>
			
			<div class="col-sm-9 col-xs-9 form-widget" >
				<?= SearchFormWidget::widget(['filterContainer'=>$folderCarouselWidgetAttributes['class']]);?>
			</div>
			<?php 
				$subfolderOnboarding = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::SUBFOLDER_ONBOARDING_GROUP_ID]);
				$subfoldersExists = $subfolderOnboarding->exists();
                $getSubfolders = $subfolderOnboarding->one();
			?>
	        <?php if(!$subfoldersExists || $getSubfolders->status < Onboarding::MAX_ONBOARDING  ){ ?>
	            <div class="help-tip" id="subfolder-tips">
	                <p class="tip=text">Take a tour of subfolders and find out useful tips.
	                	<button type="button" class="btn btn-success" id="subfolders-tour">Start Tour</button>
	                </p>
	            </div>
            <?php } ?>
		</div>
		<? if(!empty($displayModel)){?>
		<div class="col-xs-5 col-sm-2 sub-second">
				<div class="info-2">
					<div class="box-subfolders"><?= CreateButtonWidget::widget(['htmlAttributes'=>['class'=>$createButtonWidgetAttributes['class']]]);?></div>
				</div>
   		</div>
		<? }?>
		<? if(!empty($displayModel)){?>
		
			<div class="col-xs-7 col-sm-10 subfirst ">
		<? }else{?>
			<div class="col-xs-12 col-sm-12 subfirst ">
		<? }?>
			<div class="info-2">
				<div class="box-sub-folders">
					<?= FolderCarouselWidget::widget(['placeHolderString' => $placeHolderString,'model' => $displayModel,'numberOfDisplayedItems' => 3,'htmlAttributes'=>$folderCarouselWidgetAttributes['class'],'createFormWidgetAttribute'=>['formId'=>'test', 'formAction'=>$formAction,'refreshSectionElement'=>'create-folder-refresh','folderPrivacy'=>$folderPrivacy]]) ?>
					
				</div>
			</div>
		</div>
	</div>
</div>

<?
$subfoldersOnboarding = Url::to(['onboarding/onboarding']);
$subfolders = <<<subfolders

function _SubfoldersOnboarding(){
          $.ajax({
              url: '$subfoldersOnboarding',
              type: 'POST', 
              data: {
                  user_id: $userId,
                  group: 'subfolders'
                },
              success: function(res, sec){
                   console.log('Status updated');
              },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
          });
}

$(function() {

  var subfolderTour = new Tour({
    name: "subfolderTour",
    steps: [
        {
          element: ".subfolder-container",
          title: "Subfolders",            
          content: "Find all subfolders for this folder here.",
          placement: 'left',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-folder-open icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
          onShow: function(subfolderTour){
          	$('#subfolder-tips').hide();
          },
        },
        {
          element: "#folder-image",
          title: "Create subfolders",
          content: "You can create new subfolders for this folder here.",
          placement: 'left',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-plus-square icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: "#search_submit",
          title: "Folder Image",
          content: "You can search for subfolders here.",
          placement: 'left',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-search icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='end' class='btn hca-tooltip--okay-btn'>Close</a></div></div></div>",
          onShown: function(subfolderTour){
            $(".tour-backdrop").appendTo("#wrap");
            $(".tour-step-background").appendTo("#wrap");
            $(".tour-step-background").css("left", "0px");
            },
        },
      ],
    backdrop: true,  
    storage: false,
    smartPlacement: true,
    onEnd: function (subfolderTour) {
            _SubfoldersOnboarding();
        },
  });
  $('#subfolders-tour').on('click', function(e){
       subfolderTour.start();
       e.preventDefault();
    })

});

subfolders;
 
$this->registerJs($subfolders);
?>
	
<?php Pjax::end(); ?>

