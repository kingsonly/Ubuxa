<?php
  use frontend\assets\AppAsset;
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  use yii\base\view;
  use kartik\popover\PopoverX;
  use kartik\widgets\FileInput;
  AppAsset::register($this);
  $docUrl = Url::to(['edocument/upload']);
?>
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<style>
.click-upload{border: 2px dashed #949090;background: azure;}
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
    border: 0.2px solid rgba(0, 0, 0, 0.5);
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
    background: #264787;
    /*background: linear-gradient(to bottom, #666, #444);*/
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
.nadaaa{
    pointer-events: none;
}
.close-upload{
    float: right;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
}
.upload-dropzones{
    display: none;
}
.add-attachments{
    font-size: 16px;
    cursor: pointer;
}
</style>

<!-- Main edocument widget -->
<?php if($edocument == 'dropzone'){ ?>
<main class="dropzone-main <?=!empty($tasklist)?$tasklist:'';?> remove-zindex" id="dropzone-main<?=$target;?>" style="width: <?=$docsize;?>%">
        <div class="dropzones <?=!empty($tasklist)?$tasklist:'';?>" id="dynamic-drop<?=$target;?>">
              <?php $form = ActiveForm::begin(['action'=>Url::to(['edocument/upload']),'id' => 'dropupload'.$target, 'options' => ['class'=>'dropzone'.$target.' dropzonex dz-clickable dummy','style'=>'padding:'.$iconPadding.'px'.' '.$iconPadding.'px']]); ?>
              <div class="nadaaa">
                <span class="dz-message doc-message" style="padding-top: <?=$textPadding;?>px">
                  Drop files here.
                </span>
                <!-- show attachment icon -->
                <?php if($attachIcon === 'yes'){ ?>
                    <div class="dz-message">
                        <i class="fa fa-paperclip doc-icons" aria-hidden="true"></i>
                    </div>
                <?php }?>
            </div>
              <?php ActiveForm::end(); ?>
        </div>
</main>
<?php }else if($edocument == 'clickUpload'){ 
    
    ?>
        <a class="add-attachments">Add attachments</a>
        <div class="upload-dropzones">
              <?php $form = ActiveForm::begin(['action'=>Url::to(['edocument/upload']),'id' => 'dropupload'.$target, 'options' => ['class'=>'dropzone dz-clickable click-upload']]); ?>
              <span class="close-upload" style="cursor: pointer;"> X </span>
                <span class="dz-message doc-message">
                  click to upload files.
                </span>
              <?php ActiveForm::end(); ?>
        </div>
<?php }?>

<?php if($edocument == 'dropzone'){ ?>
<?
$taskUrl = Url::to(['task/view']);
$doctype = Url::to('@web/images/edocuments');
$dropzone = <<<JS
// Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';

jQuery.fn.getParent = function(num) {
    var last = this[0];
    for (var i = 0; i < num; i++) {
        last = last.parentNode;
    }
    return jQuery(last);
};
var lastTarget = null;
 
    $('#dropzone-main$target').on("dragenter", function(e)
    {
        lastTarget = e.target; // cache the last target here
        if($(e.target).hasClass('subfolders')){
            $('#dropzone-mainfolder').css('display', 'none');
        }
        //check if menu is open before showing widget
        if($('.menu-icon').hasClass('closed')){ 
            $(".dropzone$target").removeClass("dummy"); //make widgte visible on drag enter
            $('#dropzone-mainfolder').css('display', 'block');
            $('#dropzone-mainhidetasklist').addClass('folderDoc');
        }else{
            $(".dropzone$target").removeClass("dummy");
            //$('#dropzone-mainfolder').removeClass('folderDoc');
            //$('#dropzone-mainfolder').addClass('hideFolderDoc');
            $('#dropzone-mainfolder').css('display','none');
            $('.hidetasklist').removeClass('folderDoc');
            $('.hidetasklist').addClass('hideFolderDoc');
        }
    }).bind("dragleave", function (e) {
        e.preventDefault();
        if (e.target === document || e.target === lastTarget) {
            return false;
        }
        //$('#dropzone-mainfolder').removeClass("add-zindex"); //remove z-index on drag leave
        //$('#dropzone-main$target').removeClass("add-zindex"); //remove z-index on drag leave
        $(".dropzone$target").addClass("dummy"); //hide widget on drag leave

        $(this).addClass("remove-zindex");
        $(this).removeClass("add-zindex");
        if($('#dropzone-mainfolder').hasClass('add-zindex')){    
            $('#dropzone-mainfolder').removeClass("add-zindex");
            $('#dropzone-mainfolder').addClass("remove-zindex");
        }
        if($('.for-kanban').hasClass('add-zindex')){
            $('.for-kanban').removeClass("add-zindex");
            $('.for-kanban').addClass("remove-zindex");
        }
        
    }).bind("dragover", function (e) {
        e.preventDefault();
    }).bind("drop", function (e) {
        e.preventDefault();
        $(".dropzone$target").addClass("dummy"); //hide widget on drop
    });
var counter = 0;

$(document).on('dragenter', function(e){
    lastTarget = e.target;
    counter++;
    $('.dropzone-main').removeClass("remove-zindex"); //make div holding widget visble on window drag enter
    $('.dropzone-main').addClass("add-zindex"); // add z-index on window drag enter
    if($('.menu-icon').hasClass('closed')){
        $('#dropzone-mainfolder').css('display', 'block'); //hide folder drag event if board is opened
    }
    if(($('#dropzone-mainfolder').hasClass('hideFolderDoc')) && ($('.menu-icon').hasClass('closed'))){
        $('#dropzone-mainfolder').addClass('folderDoc');
        $('.hidetasklist').removeClass('hideFolderDoc');
        $('.hidetasklist').addClass('folderDoc');
    }
}).bind('dragover', function(e){
    e.preventDefault();
}).bind('dragleave', function(e){
    if(e.target === lastTarget) {
        $('.dropzone-main').removeClass("add-zindex");
        $('.dropzone-main').addClass("remove-zindex");
        if($('#dropzone-mainfolder').hasClass('add-zindex')){    
            $('#dropzone-mainfolder').removeClass("add-zindex");
            $('#dropzone-mainfolder').addClass("remove-zindex");
        }
        if($('.for-kanban').hasClass('add-zindex')){
            $('.for-kanban').removeClass("add-zindex");
            $('.for-kanban').addClass("remove-zindex");
        }
    } 
})


var dropzone = new Dropzone('#dropupload$target', {
  init: function() {
    this.on("queuecomplete", function(file, response) {
     $(".dropzone$target").addClass("dummy"); //hide widget on complete
     $('.dropzone-main').addClass("remove-zindex");
     $('.dropzone-main').removeClass("add-zindex");
    });
    this.on("complete", function(file) {
        this.removeFile(file); //remove file thumbanil on complete
    });
    this.on("success", function(file, response) {
        console.log(response);
        var taskId = $('#dropupload$target').getParent(3).attr('data-taskId');
        var folderId =$('#dropupload$target').getParent(3).attr('data-folderId');
        toastr.success('File uploaded successfully');
        $.pjax.reload({container:"#kanban-refresh",async: false});
        $.pjax.reload({container:"#task-list-refresh",async: false});
        if($('#dropupload$target').hasClass('dropzonetaskboard')){
            $.pjax.reload({container:"#task-edoc",replace: false, async:false, url: '$taskUrl&id='+taskId+'&folderId='+folderId});
        }
        if($('#dropupload$target').hasClass('dropzonefolderdetails')){
            $.pjax.reload({container:"#folder-details-refresh", async:false});
        }
        if($('#dropupload$target').hasClass('dropzonefolder')){
            $.pjax.reload({container:"#folder-edoc", async:false});
        }
    });
    this.on('error', function(file, response) {
        if(!$('#dropupload$target').hasClass('dropzonefolderdetails')){
            toastr.error("Something went wrong,try again!");
        }
    });
    this.on("sending", function(file, xhr, formData) {
      formData.append("reference", '$reference'); //get reference location
      formData.append("referenceID", '$referenceID'); //get reference location id
    });
    this.on("maxfilesexceeded", function(file){
        toastr.error("You can only upload one file here");
    });
  },
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 50, // MB. maximum limit for upload
  clickable: false,
  maxFiles: $('#dropupload$target').hasClass('dropzonefolderdetails') ? 1 : 10,
  /*addRemoveLinks: true,*/
  acceptedFiles: $('#dropupload$target').hasClass('dropzonefolderdetails') ? 'image/*' : '',
  accept: function(file, done) {
    var ext = file.name.split('.').pop(); //get file extension
    //show thumbnail of file depending on extension
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
<?php }else if($edocument == 'clickUpload'){?>
<?php
$doctype = Url::to('@web/images/edocuments');
$taskUrl = Url::to(['task/view']);
$upload = <<<JS
$('.mybtnz').on('click', function(e){
    $(this).next('.popover').show();
})

$('.add-attachments').on('click', function(e){
    $(this).hide();
    $(this).next('.upload-dropzones').slideDown();
})

$('.close-upload').on('click', function(e){
   $(this).parent().parent().slideUp();
   $(this).parent().parent().prev('.add-attachments').show();
})

var dropzone = new Dropzone('#dropupload$target', {
  init: function() {
    this.on("queuecomplete", function(file) {
        $('#dropupload$target').parent().slideUp();
    });
    this.on("success", function(file, response) {
        toastr.success("File uploaded successfully");
        this.removeFile(file);
        $('#dropupload$target').parent().prev('.add-attachments').show();
        var taskId = $('#dropupload$target').getParent(2).attr('data-taskId');
        var folderId =$('#dropupload$target').getParent(2).attr('data-folderId');
        $.pjax.reload({container:"#kanban-refresh",async: false});
        $.pjax.reload({container:"#task-list-refresh",async: false});
        if($('#dropupload$target').hasClass('click-upload')){
            $.pjax.reload({container:"#task-edoc",replace: false, async:false, url: '$taskUrl&id='+taskId+'&folderId='+folderId});
        }
        if($('#dropupload$target').hasClass('dropzonefolder')){
            $.pjax.reload({container:"#folder-edoc", async:false});
        }
    });
    this.on('error', function(file, response) {
        toastr.error("Something went wrong,try again!");
    });
    this.on("sending", function(file, xhr, formData) {
      formData.append("reference", '$reference'); //get reference location
      formData.append("referenceID", '$referenceID'); //get reference location id
    });
  },
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 50, // MB. maximum limit for upload
  maxFiles: 10,
  clickable: true,
  accept: function(file, done) {
    var ext = file.name.split('.').pop(); //get file extension
    //show thumbnail of file depending on extension
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
$this->registerJs($upload);
?>
<?php }?>