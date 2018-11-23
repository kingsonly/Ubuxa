<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;
use boffins_vendor\components\controllers\RemarkComponentViewWidget;
use yii\widgets\Pjax;
use frontend\assets\AppAsset;
AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $model frontend\models\Remark */
?>
<style type="text/css">
   
.wrapp {
   width: 70%;
   min-width: 100%;
   margin: 60px auto 0;
   border-radius: 3px;
   border:1px solid #ccc;
   /*box-shadow: 0 5px 8px 0 rgba(0,0,0,.4);*/
   padding: 10px;
}
.toolbar {
   width: 100%;
   margin: 0 auto 10px;
   padding-left: 20px;
}
.remark-btn {
   width: 30px;
   height: 30px;
   border-radius: 3px;
   background: none;
   border: none;
   box-sizing: border-box;
   padding: 0;
   font-size: 20px;
   color: #a6a6a6;
   cursor: pointer;
   outline: none;
}
.remark-btn:hover {
   border: 1px solid #a6a6a6;
   color: #777;
}
#bold,
#italic,
#underline {
   font-size: 12px;
}
#align-left,
#align-center,
#align-right,
#list-ul,
#list-ol {
    font-size: 12px;
}
#underline,
#align-right {
   margin-right: 17px;
}
#align-left {
   margin-left: 17px;
}
#fonts {
   height: 24px;
   font-size: 12px;
   font-weight: bold;
   color: #444;
   background: #fcfcfc;
   border: 1px solid #a6a6a6;
   border-radius: 3px;
   margin: 0;
   outline: none;
   cursor: pointer;
}
#fonts option {
   font-size: 15px;
   background: #fafafa;
}
#fonts {
   width: 140px;
}
.sp-replacer {
   background: #fcfcfc;
   padding: 1px 2px 1px 3px;
   border-radius: 3px;
   border-color: #a6a6a6;
   margin-top: -1px;
}
.sp-replacer:hover {
   border-color: #a6a6a6;
   color: inherit;
}
.sp-preview {
   width: 15px;
   height: 15px;
   border: none;
   margin-top: 2px;
   margin-right: 3px;
}
.sp-preview-inner, 
.sp-alpha-inner, 
.sp-thumb-inner {
   border-radius: 3px;
}
.editor {
   position: relative;
   width: 100%;
   min-height: 20vh;
   margin: 0 auto;
   padding: 20px;
   background: transparent;
   /*border-radius: 3px;
   box-shadow: inset 0 0 8px 1px rgba(0,0,0,.2);*/
   box-sizing: border-box;
   overflow: hidden;
   word-break: break-all;
   outline: none;
   /*border:1px solid #ccc;*/
}
#link,
#image{
    font-family: calibri;
}
#textLi{
    padding-left: 18px;
}
* {
    margin: 0;
    padding: 0;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
 }
 .comments-container a {
    color: #03658c;
    text-decoration: none;
 }
.comments-container ul {
    list-style-type: none;
}
/** ====================
 * Lista de Comentarios
 =======================*/
.comments-container {
   /* margin: 60px auto 15px;*/
    width: 100%;
}
.comments-container h1 {
    font-size: 36px;
    color: #283035;
    font-weight: 400;
}
.comments-container h1 a {
    font-size: 18px;
    font-weight: 700;
}
.comments-list {
    margin-top: 30px;
    position: relative;
}
/**
 * Lineas / Detalles
 -----------------------*/
.comments-list:before {
    content: '';
    width: 2px;
    height: 100%;
    background: #c7cacb;
    position: absolute;
    left: 32px;
    top: 0;
}
.comments-list:after {
    content: '';
    position: absolute;
    background: #c7cacb;
    bottom: 0;
    left: 27px;
    width: 7px;
    height: 7px;
    border: 3px solid #dee1e3;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
}
.reply-list:before, .reply-list:after {display: none;}
.reply-list li:before {
    content: '';
    width: 60px;
    height: 2px;
    background: #c7cacb;
    position: absolute;
    top: 25px;
    left: -55px;
}
.comments-list li {
    margin-bottom: 15px;
    display: block;
    position: relative;
}
.comments-list li:after {
    content: '';
    display: block;
    clear: both;
    height: 0;
    width: 0;
}
.reply-list {
    padding-left: 88px;
    clear: both;
    margin-top: 15px;
}
/**
 * Avatar
 ---------------------------*/
.comments-list .comment-avatar {
    width: 65px;
    height: 65px;
    position: relative;
    z-index: 99;
    float: left;
    border: 3px solid #FFF;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    -moz-box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    overflow: hidden;
}
.comments-list .comment-avatar img {
    width: 100%;
    height: 100%;
}
.reply-list .comment-avatar {
    width: 50px;
    height: 50px;
}
.comment-main-level:after {
    content: '';
    width: 0;
    height: 0;
    display: block;
    clear: both;
}
/**
 * Caja del Comentario
 ---------------------------*/
.comments-list .comment-box {
    width: 568px;
    float: right;
    position: relative;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.15);
    -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.15);
    box-shadow: 0 1px 1px rgba(0,0,0,0.15);
}
.comments-list .comment-box:before, .comments-list .comment-box:after {
    content: '';
    height: 0;
    width: 0;
    position: absolute;
    display: block;
    border-width: 10px 12px 10px 0;
    border-style: solid;
    border-color: transparent #FCFCFC;
    top: 8px;
    left: -11px;
}
.comments-list .comment-box:before {
    border-width: 11px 13px 11px 0;
    border-color: transparent rgba(0,0,0,0.05);
    left: -12px;
}
.reply-list .comment-box {
    width: 492px;
}
.comment-box .comment-head {
    background: #FCFCFC;
    padding: 10px 12px;
    border-bottom: 1px solid #E5E5E5;
    overflow: hidden;
    -webkit-border-radius: 4px 4px 0 0;
    -moz-border-radius: 4px 4px 0 0;
    border-radius: 4px 4px 0 0;
}
.comment-box .comment-head i {
    float: right;
    margin-left: 14px;
    position: relative;
    top: 2px;
    color: #A6A6A6;
    cursor: pointer;
    -webkit-transition: color 0.3s ease;
    -o-transition: color 0.3s ease;
    transition: color 0.3s ease;
}
.comment-box .comment-head i:hover {
    color: #03658c;
}
.comment-box .comment-name {
    color: #283035;
    font-size: 14px;
    font-weight: 700;
    float: left;
    margin-right: 10px;
}
.comment-box .comment-name a {
    color: #283035;
}
.comment-box .comment-head span {
    float: left;
    color: #999;
    font-size: 13px;
    position: relative;
    top: 1px;
}
.comment-box .comment-content {
    background: #FFF;
    padding: 12px;
    font-size: 15px;
    color: #595959;
    -webkit-border-radius: 0 0 4px 4px;
    -moz-border-radius: 0 0 4px 4px;
    border-radius: 0 0 4px 4px;
}
.comment-box .comment-name.by-author, .comment-box .comment-name.by-author a {color: #03658c;}
.comment-box .comment-name.by-author:after {
    content: 'autor';
    background: #03658c;
    color: #FFF;
    font-size: 12px;
    padding: 3px 5px;
    font-weight: 700;
    margin-left: 10px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}
/** =====================
 * Responsive
 ========================*/
@media only screen and (max-width: 766px) {
    .comments-container {
        width: 480px;
    }
    .comments-list .comment-box {
        width: 390px;
    }
    .reply-list .comment-box {
        width: 320px;
    }
  
  }
  #remarkSaveForm{
    display: none;
  }
  #remarkReplyForm{
    display: none;
  }
  .wrapp{
    display: none;
  }
  .atwho-inserted {
      color: #4183C4;
    }
    .atwho-query {
      color: #4183C4;
    }
</style>
<div class="" style="min-height: 200px">
  <div class="row">
    
    <div class="col-md-12" id="flux" style="height: 200px;overflow:auto">
      <!-- Contenedor Principal -->
    
    <div class="comments-container" id="comments-container">
        <ul id="comments-list" class="comments-list results">
           
    </div>
    
  </div>
  <div id="remark-content-loading" style="text-align: center; display: none; color:#ccc">more content loading...</div>
  <div class="row">
    <div class="col-md-12 remark-textfield">
       <form>
  <div class="form-group">
    <input type="text" data-modelName="<?= $modelName; ?>" class="form-control" id="exampleInputRemark" aria-describedby="remarkHelp" placeholder="Enter remark">
    <input type="hidden" value="<?= $modelName; ?>" class="form-control getModelName" id="exampleInputRemark" aria-describedby="remarkHelp" placeholder="Enter remark">
  </div>
  </form>
  <div class="wrapp">
   <div class="toolbar">
      <button class="remark-btn" id="bold" title="Bold (Ctrl+B)"><i class="fa fa-bold"></i></button>
      <button class="remark-btn" id="italic" title="Italic (Ctrl+I)"><i class="fa fa-italic"></i></button>
      <button class="remark-btn" id="underline" title="Underline (Ctrl+U)"><i class="fa fa-underline"></i></button>
      <select name="fonts" id="fonts">
         <option value="Arial" selected>Arial</option>
         <option value="Georgia">Georgia</option>
         <option value="Tahoma">Tahoma</option>
         <option value="Times New Roman">Times New Roman</option>
         <option value="Verdana">Verdana</option>
         <option value="Impact">Impact</option>
         <option value="Courier New">Courier New</option>
      </select>
      <select name="size" id="size">
         <option value="8">8</option>
         <option value="10">10</option>
         <option value="12">12</option>
         <option value="14">14</option>
         <option value="16" selected>16</option>
         <option value="18">18</option>
         <option value="20">20</option>
         <option value="22">22</option>
         <option value="24">24</option>
         <option value="26">26</option>
      </select>
      <input type="text" id="color" />
      <button  class="remark-btn" id="align-left" title="Left"><i class="fa fa-align-left"></i></button>
      <button  class="remark-btn" id="align-center" title="Center"><i class="fa fa-align-center"></i></button>
      <button  class="remark-btn" id="align-right" title="Right"><i class="fa fa-align-right"></i></button>
      <button  class="remark-btn" id="list-ul" title="Unordered List"><i class="fa fa-list-ul"></i></button>
      <button  class="remark-btn" id="list-ol" title="Ordered List"><i class="fa fa-list-ol"></i></button>
      <span class="dropdown">
          <button class="dropdown-toggle remark-btn" type="button" data-toggle="dropdown">
          <span class="fa fa-angle-down"></span></button>
          <ul class="dropdown-menu">
            <li id="linka"><a href="#"><span title="Attach link"><i class="fa fa-link"></i></span><span id="textLi">Add Link</span></a></li>
            <li id="image"><a href="#"><span title="Insert Image"><i class="fa fa-image"></i></span><span id="textLi">Files and Images</span></a></li>
           
          </ul>
      </span>
      
   </div>
   <div class="editor" id="example-1" contenteditable></div>
</div>
    <?php $form = ActiveForm::begin(['id'=>'create-remark', 'validateOnSubmit' => false]); ?>
    <?= $form->field($remarkModel, 'parent_id')->hiddenInput(['id'=>'parent-id','value' => 0])->label(false) ?>
    <?= $form->field($remarkModel, 'remark_date')->hiddenInput()->label(false) ?>
    <?= $form->field($remarkModel, 'ownerId')->hiddenInput(['id'=>'owner-id','value' => $parentOwnerId])->label(false) ?>
    <?= $form->field($remarkModel, 'cid')->hiddenInput()->label(false) ?>
    
    <div class="form-group" id="remarkSaveForm">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'remarkSave']) ?>
    </div>
    <div class="form-group" id="remarkReplyForm">
        <?= Html::submitButton('Reply', ['class' => 'btn btn-success', 'id' => 'remarkReply']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <img src="<?= Url::to('@web/images/loader/loader.gif'); ?>" style = "display: none" id="remarkLoader">
  
    </div>
  </div>
</div>
  
<?php 
$remarkUrl = Url::to(['remark/index','src' => 'ref1']);
$remarkUrlSave = Url::to(['remark/create']);
$remarkUrlMention = Url::to(['remark/mention']);
$remarkUrlMentionFolder = Url::to(['remark/hashtag']);
$DashboardUrl = explode('/',yii::$app->getRequest()->getQueryParam('r'));
$DashboardUrlParam = $DashboardUrl[0];
$remarkJs = <<<JS
var issues = [
  { name: "1", content: "stay foolish"},
  { name: "2", content: "stay hungry"},
  { name: "3", content: "stay heathly"},
  { name: "14", content: "ubuxa"},
];
$('.editor').atwho({
    at: "@",
    insertTpl: '<a href="#" data-type="mentionable" data-id="\${id}" data-name="\${name}">\${name}</a>',
    data:'$remarkUrlMention'
}).atwho({
    at: "#", 
    displayTpl: '<li><small>\${content}</small></li>',
    insertTpl: '<a href="http://localhost/ubuxa-beta/frontend/web/index.php?r=folder/view&id=\${name}" data-type="mentionable" data-id="\${id}" data-name="\${name}">\${content}</a>',
    data: '$remarkUrlMentionFolder'
  })
var mypage = 1;
var getOwnerId = $('#owner-id').val();
var getModelName = $('.getModelName').val();
mycontent(mypage);
jQuery(
  function($)
  {
    $('#flux').bind('scroll', function()
      {
        if($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight)
        {
          mypage++;
          mycontent(mypage);
        }
      })
  }
);
$('#example-1').keyup(function(){
   if($(this).text().length !=0)
            $('#remarkSave').attr('disabled', false);            
        else
            $('#remarkSave').attr('disabled',true);
  })
$('#create-remark').submit(function(e) { 
           e.preventDefault();
    e.stopImmediatePropagation();
           var remark_value = $('#example-1').html();
           var form = $(this);
           var datas = form.serializeArray();
           datas.push({name: '&moredata', value: remark_value});
           $('#remarkSave').hide();
           $('#remarkLoader').show();
           $.ajax({
                url: '$remarkUrlSave',
                type: 'POST',
                data: datas,
                success: function(response) { 
                    $('#example-1').empty();
                    $.pjax.reload({container:"#remark-refresh",async: false});
                    $('#remarkLoader').hide();
                    $('#remarkSave').show();
                    $('#remarkSave').attr('disabled',true);
                },
              error: function(res, sec){
                  console.log('Something went wrong');
              }
            });  
});
function mycontent(mypage){
    $('#remark-content-loading').show();
    $.post('$remarkUrl',
    {
      page:mypage,
      ownerId:getOwnerId,
      modelName:getModelName,
      DashboardUrlParam:'$DashboardUrlParam'
    },
    function(data){
        if(data.trim().lenght == 0){
            $('#remark-content-loading').text('finished');
        }
        $('#remark-content-loading').hide();
        if ($.trim(data)){ 
        $('.results').append(data);
        }
        $('.welll').animate({srollTop: $('#loading').offset().top},5000,'easeOutBounce');
        $('#ani_img').hide();
        })
}
$('.remark-reply').click(function(){
  $('#remarkSave').hide('slow');
  if($(this).hasClass('reply-clicked')){
    var getRemarkId = $(this).data('id');
    $('.wrapp').slideUp(1000);
    $('#exampleInputRemark').show();
    $('html, body').animate({ scrollTop: $(".wrapp").offset().top }, 1000,function(){
       $('#remarkReplyForm').hide();
    });
    $(this).removeClass('reply-clicked');
  } else {
    var getRemarkId = $(this).data('id');
    $('#exampleInputRemark').hide();
    $('.wrapp').slideDown(1000);
    $('html, body').animate({ scrollTop: $(".wrapp").offset().top }, 2000,function(){
        $('#remarkReplyForm').show('fast');
    });
 
    $('#parent-id').val(getRemarkId);
    $(this).addClass('reply-clicked');
    }
 
  })
$('#exampleInputRemark').click(function(){
  $('#exampleInputRemark').hide();
  $('.wrapp').slideDown(1000);
  $('html, body').animate({ scrollTop: $(".wrapp").offset().top }, 2000,function(){
    $('#remarkSaveForm').show();
    $('#remarkSave').attr('disabled', true);
  });
  
  })
$('#bold').on('click', function() {
   document.execCommand('bold', false, null);
});
$('#linka').on('click', function(e) {
    e.preventDefault();
   document.execCommand('createLink', false, null);
});
$('#image').on('click', function(e) {
    e.preventDefault();
   document.execCommand('insertImage', false, null);
});
$('#italic').on('click', function() {
   document.execCommand('italic', false, null);
});
$('#underline').on('click', function() {
   document.execCommand('underline', false, null);
});
$('#align-left').on('click', function() {
   document.execCommand('justifyLeft', false, null);
});
$('#align-center').on('click', function() {
   document.execCommand('justifyCenter', false, null);
});
$('#align-right').on('click', function() {
   document.execCommand('justifyRight', false, null);
});
$('#list-ul').on('click', function() {
   document.execCommand("insertUnorderedList");
});
$('#list-ol').on('click', function() {
   document.execCommand('insertOrderedList', false, null);
});
$('#fonts').on('change', function() {
   var font = $(this).val();
   document.execCommand('fontName', false, font);
});
$('#size').on('change', function() {
   var size = $(this).val();
   $('.editor').wrapInner("<span></span>").find('span').css('fontSize', size + 'px');
});
$('[data-toggle="tooltip-reply"]').tooltip();
JS;
 
$this->registerJs($remarkJs);
?>