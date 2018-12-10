<?php
use yii\helpers\Html;
use yii\helpers\Url;
use boffins_vendor\components\controllers\RemarkComponentViewWidget;
use yii\widgets\Pjax;
use frontend\models\Onboarding;
$checkUrlz = explode('/',yii::$app->getRequest()->getQueryParam('r'));
$checkUrlParamz = $checkUrlz[0];
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
          <?php if($checkUrlParamz == 'folder'){
            $remarksExists = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::REMARK_ONBOARDING])->exists();
            $getRemarks = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::REMARK_ONBOARDING])->one();
          ?>
            <?php if(!$remarksExists || $getRemarks->status < Onboarding::ONBOARDING_COUNT){ ?>
              <div class="help-tip" id="remark-tipz">
                <p class="tip=text">Take a tour of remarks and find out useful tips.
                  <button type="button" class="btn btn-success" id="remark-tour">Start Tour</button>
                </p>
              </div>
            <?php } ?>
          <?php }?>
          <?php if($checkUrlParamz == 'site'){
            $remarksExists = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::REMARK_ONBOARDING])->exists();
            $getRemarks = Onboarding::find()->where(['user_id' => $userId, 'group_id' => Onboarding::REMARK_ONBOARDING])->one();
          ?>
            <?php if(!$remarksExists || $getRemarks->status < Onboarding::ONBOARDING_COUNT){ ?>
              <div class="help-tip" id="site-remark-tipz">
                  <p class="tip=text">Take a tour of remarks and find out useful tips.
                    <button type="button" class="btn btn-success" id="site-remark-tour">Start Tour</button>
                  </p>
                </div>
            <?php } ?>
          <?php }?>
            <span>COMMENTS</span>
        </div>
        <?php Pjax::begin(['id'=>'remark-refresh']); ?>
	    <div class="col-md-12 box-content"><?= RemarkComponentViewWidget::widget(['remarkModel' => $remarkModel, 'parentOwnerId' => $parentOwnerId, 'remarks'=> $remarks, 'modelName'=> $modelName,'location' => $location]); ?></div>
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
          content: "View all remarks for this folder here.",
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
            },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-reply-all icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='next' class='btn hca-tooltip--okay-btn'>Next</a></div></div></div>",
        },
        {
          element: ".wrapp",
          title: "Add Remarks",
          content: "You can add new remarks here.",
          placement: 'left',
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-pencil-square icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='end' class='btn hca-tooltip--okay-btn'>Close</a></div></div></div>",
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

  var siteRemarkTour = new Tour({
    name: "siteRemarkTour",
    steps: [
        {
          element: "#flux",
          title: "Remarks",            
          content: "You can view all remarks from here, for this folder",
          placement: 'left',
          onShow: function(siteRemarkTour){
                $('#remark-tipz').hide();
          },
          template: "<div class='popover tour hca-tooltip--left-nav'><div class='arrow'></div><div class='row'><div class='col-sm-12'><div data-role='end' class='close'>X</div></div></div><div class='row'><div class='col-sm-2'><i class='fa fa-reply-all icon-tour fa-3x' aria-hidden='true'></i></div><div class='col-sm-10'><p class='popover-content'></p><a id='hca-left-nav--tooltip-ok' href='#' data-role='end' class='btn hca-tooltip--okay-btn'>Close</a></div></div></div>",
        },
      ],
    backdrop: true,  
    storage: false,
    smartPlacement: true,
    onEnd: function (siteRemarkTour) {
            _RemarkOnboarding();
        },
  });
  $('#site-remark-tour').on('click', function(e){
       siteRemarkTour.start();
       e.preventDefault();
    })
 //remarkTour.init();

});


JS;
 
$this->registerJs($remarkJS);
?>