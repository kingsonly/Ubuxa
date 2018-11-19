<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\RemarkComponentViewWidget;
use yii\widgets\Pjax;
use frontend\models\Onboarding;
$checkUrl = explode('/',yii::$app->getRequest()->getQueryParam('r'));
$checkUrlParam = $checkUrl[0];
?>
<style type="text/css">
    .bg-info {
        background-color: #fff;
        box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
        padding-left: 15px;
        padding-right: 15px;
    }

    .header {
        border-bottom: 1px solid #ccc;
        padding-top: 7px;
        padding-bottom: 7px;
        font-weight: bold
    }

    .box-content {
        min-height: 300px;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .box-input {
        padding-top: 7px;
        padding-bottom: 7px;
    }
</style>

<div class="col-md-8">
    <div class="col-md-12 bg-info">
      	<div class="header">
          <?php if($checkUrlParam == 'folder'){?>
            <?php if(!$onboardingExists){ ?>
                <div class="help-tip" id="remark-tipz">
                  <p class="tip=text">Take a tour of task and find out useful tips.
                    <button type="button" class="btn btn-success" id="remark-tour">Start Tour</button>
                  </p>
                </div>
            <?php }else if($onboardingExists && $onboarding->remark_status == onboarding::ONBOARDING_NOT_STARTED){ ?>
              <div class="help-tip" id="remark-tipz">
                  <p class="tip=text">Take a tour of task and find out useful tips.
                    <button type="button" class="btn btn-success" id="remark-tour">Start Tour</button>
                  </p>
                </div>
            <?php } ?>
          <?php }?>
          <?php if($checkUrlParam == 'site'){?>
            <?php if(!$onboardingExists){ ?>
                <div class="help-tip" id="site-remark-tipz">
                  <p class="tip=text">Take a tour of task and find out useful tips.
                    <button type="button" class="btn btn-success" id="site-remark-tour">Start Tour</button>
                  </p>
                </div>
            <?php }else if($onboardingExists && $onboarding->remark_status == onboarding::ONBOARDING_NOT_STARTED){ ?>
              <div class="help-tip" id="site-remark-tipz">
                  <p class="tip=text">Take a tour of task and find out useful tips.
                    <button type="button" class="btn btn-success" id="site-remark-tour">Start Tour</button>
                  </p>
                </div>
            <?php } ?>
          <?php }?>
            <span>REMARKS</span>
        </div>
        <?php Pjax::begin(['id'=>'remark-refresh']); ?>
	    <div class="col-md-12 box-content"><?= RemarkComponentViewWidget::widget(['remarkModel' => $remarkModel, 'parentOwnerId' => $parentOwnerId, 'remarks'=> $remarks, 'modelName'=> $modelName]); ?></div>
         <?php Pjax::end(); ?>
    </div>
</div>

<?php 
$remarkOnboarding = Url::to(['onboarding/remarkonboarding']);
$remarkJS = <<<JS

function _RemarkOnboarding(){
          $.ajax({
              url: '$remarkOnboarding',
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

  var remarkTour = new Tour({
    name: "remarkTour",
    steps: [
        {
          element: "#flux",
          title: "Remarks",            
          content: "Message 1",
          placement: 'left',
          onShow: function(remarkTour){
                $('#remark-tipz').hide();
          },
          onShown: function(remarkTour) {
                $('#exampleInputRemark').hide();
                $('.wrapp').slideDown(1000);
                $('html, body').animate({ scrollTop: $(".wrapp").offset().top }, 2000,function(){
                $('#remarkSaveForm').show();
                $('#remarkSave').attr('disabled', true);
                });
            }
        },
        {
          element: ".wrapp",
          title: "Add Remarks",
          content: "Message 3",
          placement: 'left',
        },
      ],
    backdrop: true,  
    storage: false,
    smartPlacement: true,
    onEnd: function (remarkTour) {
            _RemarkOnboarding();
        },
  });
  $('#remark-tour').on('click', function(e){
       remarkTour.start();
       e.preventDefault();
    })
 //remarkTour.init();

});

$(function() {

  var remarkTour = new Tour({
    name: "remarkTour",
    steps: [
        {
          element: "#flux",
          title: "Remarks",            
          content: "You can view all remarks from here, for this folder",
          placement: 'left',
          onShow: function(remarkTour){
                $('#remark-tipz').hide();
          },
          onShown: function(remarkTour) {
                $('#exampleInputRemark').hide();
                $('.wrapp').slideDown(1000);
                $('html, body').animate({ scrollTop: $(".wrapp").offset().top }, 2000,function(){
                $('#remarkSaveForm').show();
                $('#remarkSave').attr('disabled', true);
                });
            }
        },
        {
          element: ".wrapp",
          title: "Add Remarks",
          content: "Message 3",
          placement: 'left',
        },
      ],
    backdrop: true,  
    storage: false,
    smartPlacement: true,
    onEnd: function (remarkTour) {
            _RemarkOnboarding();
        },
  });
  $('#remark-tour').on('click', function(e){
       remarkTour.start();
       e.preventDefault();
    })
 //remarkTour.init();

});


JS;
 
$this->registerJs($remarkJS);
?>