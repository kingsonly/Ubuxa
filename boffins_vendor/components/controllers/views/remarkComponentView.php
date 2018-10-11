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

button {
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

button:hover {
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
   background: #fcfcfc;
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
</style>

  <div class="wrapp">
   <div class="toolbar">
      <button id="bold" title="Bold (Ctrl+B)"><i class="fa fa-bold"></i></button>
      <button id="italic" title="Italic (Ctrl+I)"><i class="fa fa-italic"></i></button>
      <button id="underline" title="Underline (Ctrl+U)"><i class="fa fa-underline"></i></button>
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
      <button id="align-left" title="Left"><i class="fa fa-align-left"></i></button>
      <button id="align-center" title="Center"><i class="fa fa-align-center"></i></button>
      <button id="align-right" title="Right"><i class="fa fa-align-right"></i></button>
      <button id="list-ul" title="Unordered List"><i class="fa fa-list-ul"></i></button>
      <button id="list-ol" title="Ordered List"><i class="fa fa-list-ol"></i></button>
      <span class="dropdown">
          <button class="dropdown-toggle" type="button" data-toggle="dropdown">
          <span class="fa fa-angle-down"></span></button>
          <ul class="dropdown-menu">
            <li id="link"><a href="#"><span title="Attach link"><i class="fa fa-link"></i></span><span id="textLi">Add Link</span></a></li>
            <li id="image"><a href="#"><span title="Insert Image"><i class="fa fa-image"></i></span><span id="textLi">Files and Images</span></a></li>
           
          </ul>
      </span>
      
   </div>
   <div class="editor" id="example-1" contenteditable></div>
</div>


<?php 
$remarkJs = <<<JS


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


JS;
 
$this->registerJs($remarkJs);
?>
