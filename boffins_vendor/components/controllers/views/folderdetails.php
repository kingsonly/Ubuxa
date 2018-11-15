<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use boffins_vendor\components\controllers\ViewWithXeditableWidget;
use frontend\models\Onboarding;
?>

<style type="text/css">
	.folder_image{
		width: 72%;
		height: 92px;
		transition: transform .2s; /* Animation */
	}
	
	.folder-image-cont{
		
		width: 100%;
	}
	.info{
		background: #fff;
	    padding-left: 15px;
	    box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
	    border-bottom: 5px solid rgb(7, 71, 166);
	}
	
	.private-border-bottom-color{
		border-bottom: 5px solid red;
	}
	.author-border-bottom-color{
		border-bottom: 5px solid rgb(7, 71, 166);
	}
	.users-border-bottom-color{
		border-bottom: 5px solid aquamarine;
	}

	.folder-header {
	    padding-top: 7px;
	    padding-bottom: 7px;
	    font-weight: bold;
	}

	.box-content-folder {
		border-top: 1px solid #ccc;
		height:120px;
		
	}

	.folder-side {
		
	}
	.box-folders {
		padding-left: 0px;
    	padding-right: 0px;
		overflow: hidden;
	}
	#folder-description-cont{
		width: 100%;
	}
	.image-update{
		display: none;
	}
	.close-update{
		width: 100%;
		display: block;
		background: red;
	}
</style>
<?php Pjax::begin(['id'=>'folder-details-refresh']); ?>
<div class="col-md-5 folderdetls">

	<div class="col-sm-12 col-xs-12 info column-margin <?= $model->folderColors.'-border-bottom-color'; ?>">
		<div class="folder-header">
			<?php if(!$onboardingExists){ ?>
                <div class="help-tip" id="folder-tipz">
                  <p class="tip=text">Take a tour of task and find out useful tips.
                    <button type="button" class="btn btn-success" id="folder-tour">Start Tour</button>
                  </p>
                </div>
            <?php }else if($onboardingExists && $onboarding->folder_status == onboarding::ONBOARDING_NOT_STARTED){ ?>
              <div class="help-tip" id="folder-tipz">
                  <p class="tip=text">Take a tour of task and find out useful tips.
                    <button type="button" class="btn btn-success" id="folder-tour">Start Tour</button>
                  </p>
                </div>
            <?php } ?>
			<span>FOLDER DETAILS</span>
		</div>
		<div class="col-sm-7 col-xs-7 box-folders">
			<div class="folder-side">
				<div class="box-content-folder">
					<?= ViewWithXeditableWidget::widget(['model'=>$model,'attributues'=>[
					['modelAttribute'=>'title'],
					['modelAttribute'=>'description']
					]]); ?>
				</div>

			</div>
		</div>
		<div class="col-sm-5 col-xs-5 box-folders-count" style="height:125px">
            <div class="folder-image-cont">
				<div class="image-holder" style="text-align:center">
					<?= ViewWithXeditableWidget::widget(['model'=>$model,'imageDisplayUrl'=>$folderDetailsImage,'imageUrlOutput' => $imageUrl,'attributues'=>[
					['modelAttribute'=>'folder_image','xeditable' => 'image'],
					
					]]); ?>
				</div>
				
				</div>
        </div>
	</div>
</div>



<?
$folderdetailsOnboarding = Url::to(['onboarding/folderdetailsonboarding']);
$updateImage = <<<updateImage

function _FolderDetailsOnboarding(){
          $.ajax({
              url: '$folderdetailsOnboarding',
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

$(function() {

  var folderTour = new Tour({
    name: "folderTour",
    steps: [
        {
          element: "#folder-title-cont",
          title: "Folder Title",            
          content: "You can edit your folder title by clicking on it.",
          placement: 'right',
          onShow: function(){
          	$('#folder-tipz').hide();
          }
        },
        {
          element: "#folder-description-cont",
          title: "Folder Description",
          content: "You can edit your folder title by clicking on it.",
          placement: 'right',
        },
        {
          element: "#folder_image",
          title: "Folder Image",
          content: "You can add image to your folder here.",
          placement: 'right',
        },
      ],
    backdrop: true,  
    storage: false,
    smartPlacement: true,
    onEnd: function (remarkTour) {
            _FolderDetailsOnboarding();
        },
  });
  $('#folder-tour').on('click', function(e){
       folderTour.start();
       e.preventDefault();
    })

});

updateImage;
 
$this->registerJs($updateImage);
?>
<?php Pjax::end(); ?>