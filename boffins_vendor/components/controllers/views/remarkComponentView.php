<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
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

select {
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

select > option {
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

 a {
    color: #03658c;
    text-decoration: none;
 }

ul {
    list-style-type: none;
}

body {
    font-family: 'Roboto', Arial, Helvetica, Sans-serif, Verdana;
    background: #dee1e3;
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
</style>
<div class="" style="min-height: 200px">
  <div class="row">
    <div class="col-md-12" style="height: 200px;overflow:auto">
      <!-- Contenedor Principal -->
    <div class="comments-container">
        <h4>Recent Comments <a href="http://creaticode.com" style="display: none;">creaticode.com</a></h4>

        <ul id="comments-list" class="comments-list">
            <li>
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_1_zps8e1c80cd.jpg" alt=""></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name by-author"><a href="http://creaticode.com/blog">Agustin Ortiz</a></h6>
                            <span>hace 20 minutos</span>
                            <i class="fa fa-reply"></i>
                            <i class="fa fa-heart"></i>
                        </div>
                        <div class="comment-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                        </div>
                    </div>
                </div>
                <!-- Respuestas de los comentarios -->
                <ul class="comments-list reply-list">
                    <li>
                        <!-- Avatar -->
                        <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name"><a href="http://creaticode.com/blog">Lorena Rojero</a></h6>
                                <span>hace 10 minutos</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>

                    <li>
                        <!-- Avatar -->
                        <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_1_zps8e1c80cd.jpg" alt=""></div>
                        <!-- Contenedor del Comentario -->
                        <div class="comment-box">
                            <div class="comment-head">
                                <h6 class="comment-name by-author"><a href="http://creaticode.com/blog">Agustin Ortiz</a></h6>
                                <span>hace 10 minutos</span>
                                <i class="fa fa-reply"></i>
                                <i class="fa fa-heart"></i>
                            </div>
                            <div class="comment-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                            </div>
                        </div>
                    </li>
                </ul>
            </li>

            <li>
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name"><a href="http://creaticode.com/blog">Lorena Rojero</a></h6>
                            <span>hace 10 minutos</span>
                            <i class="fa fa-reply"></i>
                            <i class="fa fa-heart"></i>
                        </div>
                        <div class="comment-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="comment-main-level">
                    <!-- Avatar -->
                    <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
                    <!-- Contenedor del Comentario -->
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name"><a href="http://creaticode.com/blog">Lorena Rojero</a></h6>
                            <span>hace 10 minutos</span>
                            <i class="fa fa-reply"></i>
                            <i class="fa fa-heart"></i>
                        </div>
                        <div class="comment-content">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                        </div>
                    </div>
                </div>
            </li>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form>
  <div class="form-group">
    <input type="text" class="form-control" id="exampleInputRemark" aria-describedby="remarkHelp" placeholder="Enter remark">
  </div>
  </form>

  <div class="wrapp" style="display: none">
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
            <li id="link"><a href="#"><span title="Attach link"><i class="fa fa-link"></i></span><span id="textLi">Add Link</span></a></li>
            <li id="image"><a href="#"><span title="Insert Image"><i class="fa fa-image"></i></span><span id="textLi">Files and Images</span></a></li>
           
          </ul>
      </span>
      
   </div>
   <div class="editor" id="example-1" contenteditable></div>
</div>


    </div>
  </div>
</div>
  
<?php 
$remarkJs = <<<JS

$('#exampleInputRemark').click(function(){
  $('#exampleInputRemark').hide();
  $('.wrapp').show()
  })



$('#bold').on('click', function() {
   document.execCommand('bold', false, null);
});

$('#link').on('click', function(e) {
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
   document.execCommand('insertUnorderedList', false, null);
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
   $('.editor').css('fontSize', size + 'px');
});

$('#color').spectrum({
   color: '#000',
   showPalette: true,
   showInput: true,
   showInitial: true,
   showInput: true,
   preferredFormat: "hex",
   showButtons: false,
   change: function(color) {
      color = color.toHexString();
      document.execCommand('foreColor', false, color);
   }
});

$('.editor').perfectScrollbar();



var users = [
  {username: 'Nnamdi', fullname: 'Ogundu Nnamdi'},
  {username: 'Kingsley', fullname: 'Achumie Kingsley'},
  {username: 'Emeka', fullname: 'Kanikwu Emeka'},
  {username: 'Anthony', fullname: 'Anthony Okechukwu'},
  {username: 'Paschal', fullname: 'Paschal Soribe'},
];

$('#example-1').suggest('@', {
  data: users,
  filter: {
            casesensitive: true,
            limit: 10
        },
  map: function(user) {
    return {
      value: user.username,
      text: '<strong>'+user.username+'</strong> <small>'+user.fullname+'</small>'
    }
  }
})

JS;
 
$this->registerJs($remarkJs);
?>
