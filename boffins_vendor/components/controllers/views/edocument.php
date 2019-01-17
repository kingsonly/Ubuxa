<?php
  use frontend\assets\AppAsset;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  use yii\base\view;
  AppAsset::register($this);
  $profileUrlz = Url::to(['user/update']);
?>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<style>
.dz-image img{width: 100%;height: 100%;}
.dz-filename{display: none;}
.dz-size{display: none;}
.dropzones{height: 100%;}
.dummy{visibility: hidden;}
.dropzonex { 
  /*border: 2px dashed #0087F7;*/ 
  border-radius: 5px; 
  background: transparent;
  box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1); 
}
.dropzonex .dz-message { font-weight: 400; }
.doc-message{
    display: flex;
    justify-content: center;
    align-items: center;
}
.dropzone-main{
    position: absolute;
    top: 0;
    /*z-index: 9999;*/
}
.dropzonex .dz-message .note { font-size: 0.8em; font-weight: 200; display: block; margin-top: 1.4rem; }

.dropzone-main { height: 100%; font-family: Roboto, "Open Sans", sans-serif; font-size: 20px; font-weight: 300; line-height: 1.4rem; color: #646C7F; text-rendering: optimizeLegibility; }
@media (max-width: 600px) { html, body { font-size: 18px; } }
@media (max-width: 400px) { html, body { font-size: 16px; } }

.dropzone-main{ margin-left: auto; margin-right: auto; }

.dropzonex, .dropzonex * {
    box-sizing: border-box;
}
.dropzonex {
    /* min-height: 200px; */
    height: 100%;
    /*border: 2px dashed #0087F7;*/
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px 10px;
}
.dropzonex.dz-clickable {
    cursor: pointer;
}
.dropzonex.dz-clickable * {
    cursor: default;
}
.dropzonex.dz-clickable .dz-message, .dropzonex.dz-clickable .dz-message * {
    cursor: pointer;
}
.dropzonex.dz-started .dz-message {
    display: none;
}
.dropzonex.dz-drag-hover {
    border-style: solid;
}
.dropzonex.dz-drag-hover .dz-message {
    opacity: 0.5;
}
.dropzonex .dz-message {
    text-align: center;
    margin: -0.3em 0;
    color: white;
}
.dropzonex .dz-preview {
    position: relative;
    display: inline-block;
    vertical-align: top;
    margin: 1px;
    min-height: 1px;
}
.dropzonex .dz-preview:hover {
    z-index: 1000;
}
.dropzonex .dz-preview:hover .dz-details {
    opacity: 1;
}
.dropzonex .dz-preview.dz-file-preview .dz-image {
    border-radius: 20px;
    background: #999;
    background: linear-gradient(to bottom, #eee, #ddd);
}
.dropzonex .dz-preview.dz-file-preview .dz-details {
    opacity: 1;
}
.dropzonex .dz-preview.dz-image-preview {
    /*background: white;*/
}
.dropzonex .dz-preview.dz-image-preview .dz-details {
    -webkit-transition: opacity 0.2s linear;
    -moz-transition: opacity 0.2s linear;
    -ms-transition: opacity 0.2s linear;
    -o-transition: opacity 0.2s linear;
    transition: opacity 0.2s linear;
}
.dropzonex .dz-preview .dz-remove {
    font-size: 14px;
    text-align: center;
    display: block;
    cursor: pointer;
    border: none;
}
.dropzonex .dz-preview .dz-remove:hover {
    text-decoration: underline;
}
.dropzonex .dz-preview:hover .dz-details {
    opacity: 1;
}
.dropzonex .dz-preview .dz-details {
    z-index: 20;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    font-size: 13px;
    min-width: 100%;
    max-width: 100%;
    padding: 2em 1em;
    text-align: center;
    color: rgba(0, 0, 0, 0.9);
    line-height: 150%;
}
.dropzonex .dz-preview .dz-details .dz-size {
    margin-bottom: 1em;
    font-size: 16px;
}
.dropzonex .dz-preview .dz-details .dz-filename {
    white-space: nowrap;
}
.dropzonex .dz-preview .dz-details .dz-filename:hover span {
    border: 1px solid rgba(200, 200, 200, 0.8);
    background-color: rgba(255, 255, 255, 0.8);
}
.dropzonex .dz-preview .dz-details .dz-filename:not(:hover) {
    overflow: hidden;
    text-overflow: ellipsis;
}
.dropzonex .dz-preview .dz-details .dz-filename:not(:hover) span {
    border: 1px solid transparent;
}
.dropzonex .dz-preview .dz-details .dz-filename span, .dropzonex .dz-preview .dz-details .dz-size span {
    background-color: rgba(255, 255, 255, 0.4);
    padding: 0 0.4em;
    border-radius: 3px;
}
.dropzonex .dz-preview:hover .dz-image img {
    -webkit-transform: scale(1.05, 1.05);
    -moz-transform: scale(1.05, 1.05);
    -ms-transform: scale(1.05, 1.05);
    -o-transform: scale(1.05, 1.05);
    transform: scale(1.05, 1.05);
    -webkit-filter: blur(8px);
    filter: blur(8px);
}
.dropzonex .dz-preview .dz-image {
    border-radius: 20px;
    overflow: hidden;
    width: 50px;
    height: 50px;
    position: relative;
    display: block;
    z-index: 10;
}
.dropzonex .dz-preview .dz-image img {
    display: block;
}
.dropzonex .dz-preview.dz-success .dz-success-mark {
    -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
}
.dropzonex .dz-preview.dz-error .dz-error-mark {
    opacity: 1;
    -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
}
.dropzonex .dz-preview .dz-success-mark, .dropzonex .dz-preview .dz-error-mark {
    pointer-events: none;
    opacity: 0;
    z-index: 500;
    position: absolute;
    display: block;
    top: 50%;
    left: 50%;
    margin-left: -27px;
    margin-top: -27px;
}
.dropzonex .dz-preview .dz-success-mark svg, .dropzonex .dz-preview .dz-error-mark svg {
    display: block;
    width: 54px;
    height: 54px;
}
.dropzonex .dz-preview.dz-processing .dz-progress {
    opacity: 1;
    -webkit-transition: all 0.2s linear;
    -moz-transition: all 0.2s linear;
    -ms-transition: all 0.2s linear;
    -o-transition: all 0.2s linear;
    transition: all 0.2s linear;
}
.dropzonex .dz-preview.dz-complete .dz-progress {
    opacity: 0;
    -webkit-transition: opacity 0.4s ease-in;
    -moz-transition: opacity 0.4s ease-in;
    -ms-transition: opacity 0.4s ease-in;
    -o-transition: opacity 0.4s ease-in;
    transition: opacity 0.4s ease-in;
}
.dropzonex .dz-preview:not(.dz-processing) .dz-progress {
    -webkit-animation: pulse 6s ease infinite;
    -moz-animation: pulse 6s ease infinite;
    -ms-animation: pulse 6s ease infinite;
    -o-animation: pulse 6s ease infinite;
    animation: pulse 6s ease infinite;
}
.dropzonex .dz-preview .dz-progress {
    opacity: 1;
    z-index: 1000;
    pointer-events: none;
    position: absolute;
    height: 16px;
    left: 80%;
    top: 50%;
    margin-top: -8px;
    width: 50px;
    margin-left: -40px;
    background: rgba(255, 255, 255, 0.9);
    -webkit-transform: scale(1);
    border-radius: 8px;
    overflow: hidden;
}
.dropzonex .dz-preview .dz-progress .dz-upload {
    background: #333;
    background: linear-gradient(to bottom, #666, #444);
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 0;
    -webkit-transition: width 300ms ease-in-out;
    -moz-transition: width 300ms ease-in-out;
    -ms-transition: width 300ms ease-in-out;
    -o-transition: width 300ms ease-in-out;
    transition: width 300ms ease-in-out;
}
.dropzonex .dz-preview.dz-error .dz-error-message {
    display: block;
}
.dropzonex .dz-preview.dz-error:hover .dz-error-message {
    opacity: 1;
    pointer-events: auto;
}
.dropzonex .dz-preview .dz-error-message {
    pointer-events: none;
    z-index: 1000;
    position: absolute;
    display: block;
    display: none;
    opacity: 0;
    -webkit-transition: opacity 0.3s ease;
    -moz-transition: opacity 0.3s ease;
    -ms-transition: opacity 0.3s ease;
    -o-transition: opacity 0.3s ease;
    transition: opacity 0.3s ease;
    border-radius: 8px;
    font-size: 13px;
    top: 130px;
    left: -10px;
    width: 140px;
    background: #be2626;
    background: linear-gradient(to bottom, #be2626, #a92222);
    padding: 0.5em 1.2em;
    color: white;
}
.dropzonex .dz-preview .dz-error-message:after {
    content:'';
    position: absolute;
    top: -6px;
    left: 64px;
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid #be2626;
}
.doc-icons{
  font-size: 120px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-top: 50px;
}
.add-zindex{
    z-index: 9999;
}
.remove-zindex{
    z-index: -9999;
}
.folderDoc{
    display: block;
}
.hideFolderDoc{
    display: none;
}
</style>

<main class="dropzone-main remove-zindex" id="dropzone-main<?=$target;?>" style="width: <?=$docsize;?>px">
        <div class="dropzones" id="dynamic-drop<?=$target;?>">
              <?php $form = ActiveForm::begin(['action'=>Url::to(['edocument/upload']),'id' => 'dropupload'.$target, 'options' => ['class'=>'dropzone'.$target.' dropzonex dz-clickable dummy']]); ?>
              <?= $form->field($model, 'fromWhere')->hiddenInput(['value' => $location])->label(false) ?>
                <span class="dz-message doc-message" style="padding-top: <?=$textPadding;?>px">
                  Drop files here.
                </span>
                <?php if($attachIcon === 'yes'){ ?>
                    <div class="dz-message">
                        <i class="fa fa-paperclip doc-icons" aria-hidden="true"></i>
                    </div>
                <?php }?>
              <?php ActiveForm::end(); ?>
        </div>
</main>

<?
$doctype = Url::to('@web/images/edocuments');
$dropzone = <<<JS

var lastTarget = null;
 
    $('#dropzone-main$target').on("dragenter", function(e)
    {
        lastTarget = e.target; // cache the last target here

        if($('.menu-icon').hasClass('closed')){
            $(".dropzone$target").removeClass("dummy");
            $('#dropzone-mainfolder').addClass('folderDoc');
        }else{
            $(".dropzone$target").removeClass("dummy");
            $('#dropzone-mainfolder').removeClass('folderDoc');
            $('#dropzone-mainfolder').addClass('hideFolderDoc');
        }
    }).bind("dragleave", function (e) {
        e.preventDefault();
        if (e.target === document || e.target === lastTarget) {
            return false;
        }
        $(".dropzone$target").addClass("dummy");
    }).bind("dragover", function (e) {
        e.preventDefault();
    }).bind("drop", function (e) {
        e.preventDefault();
        $(".dropzone$target").addClass("dummy");
    });

$(document).on('dragenter', function(e){
    $('.dropzone-main').removeClass("remove-zindex");
    $('.dropzone-main').addClass("add-zindex");
    if(($('#dropzone-mainfolder').hasClass('hideFolderDoc')) && ($('.menu-icon').hasClass('closed'))){
        $('#dropzone-mainfolder').addClass('folderDoc');
        $('#dropzone-mainfolder').removeClass('hideFolderDoc');
    }
}).bind('dragover', function(){
    $('.dropzone-main').removeClass("add-zindex");
    $('.dropzone-main').addClass("remove-zindex");
}).bind('dragleave', function(e){
    if($('#dropzone-mainfolder').hasClass('add-zindex')){
        $('.dropzone-mainfolder').removeClass("add-zindex");
    }
})

var dropzone = new Dropzone('#dropupload$target', {
  init: function() {
    this.on("queuecomplete", function(file) {
     $(".dropzone$target").addClass("dummy");
     $('.dropzone-main').addClass("remove-zindex");
     $('.dropzone-main').removeClass("add-zindex");
    });
    this.on("complete", function(file) {
        this.removeFile(file);
    });
    this.on("success", function(file, response) {
        console.log(response);
    });
    this.on('error', function(file, response) {
        toastr.error(response);
    });
    this.on("sending", function(file, xhr, formData) {
      formData.append("reference", '$reference');
      formData.append("referenceID", '$referenceID');
    });
  },
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 256, // MB
  /*addRemoveLinks: true,*/
  accept: function(file, done) {
    var ext = file.name.split('.').pop();
    if (ext == "pdf") {
        $(file.previewElement).find(".dz-image img").attr("src", "$doctype/pdf.png");
    } else if (ext.indexOf("docx") != -1) {
        $(file.previewElement).find(".dz-image img").attr("src", "$doctype/word.png");
    } else if (ext.indexOf("xls") != -1) {
        $(file.previewElement).find(".dz-image img").attr("src", "$doctype/excel.png");
    }else if (ext.indexOf("ppt") != -1) {
        $(file.previewElement).find(".dz-image img").attr("src", "$doctype/powerpoint.png");
    }else{
        $(file.previewElement).find(".dz-image img").attr("src", "$doctype/file.png");
    }
    done();
  }
});
Dropzone.autoDiscover = false;
JS;
$this->registerJs($dropzone);
?>