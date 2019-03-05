<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\Pjax;
    use yii\bootstrap\Modal;
    use boffins_vendor\components\controllers\ViewEdocumentWidget;
?>

<style>
    /*-- For document view--*/
.show-list{
  -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.document-wrapper{
  width:100%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.forfolderDocs{
  height: 475px;
  overflow: scroll;
  position: relative;
  transition: all 0.3s ease;
  margin-top: 10px;
}

.list-type{
  text-align:right;
  padding:10px;
  margin-bottom:10px;
  background-color:#5DBA9D;
}

.list-type a{
  font-size:20px;
  color:#FFFFFF;
  width:40px;
  height:40px;
  line-height:40px;
  margin-left:10px;
  text-align:center;
  display:inline-block;
}

.list-type a:hover, .list-mode .list-type a.hide-list:hover{
  background-color:#11956c;
}

.list-type a.hide-list{
  background-color:#11956c;
}

.list-mode .list-type a.hide-list{
  background-color:#5DBA9D;
}

.list-mode .list-type a.show-list{
  background-color:#11956c;
}

.doc-container:after{
  content:"";
  clear:both;
  display:table;
}

.doc-container{
  /*padding:10px 0 10px 10px;*/
}

.document-wrapper .doc-box{
  float:left;
  width:97%;
  height:70px;
  background-color:#fff;
  -webkit-transition:all 1.0s ease;
  -moz-transition:all 1.0s ease;
  transition:all 1.0s ease;
  transition:all 1.0s ease;
  box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
  border-bottom: 1px solid #828080;
  position: relative;
}

.doc-box .doc-box-inner{
  float:left;
  width:13%;
  height:80px;
  -webkit-transition:all 1.0s ease;
  -moz-transition:all 1.0s ease;
  transition:all 1.0s ease;
  transition:all 1.0s ease;
}

.document-wrapper.list-mode .doc-container{
  padding-right:10px;
}

.dropzone .dz-preview .dz-progress .dz-upload { background: #32A336;  }

.document-wrapper.list-mode .doc-box{
  width:100%;
}
.doc-img{
    background-position: 50%;
    background-size: cover;
    background-repeat: no-repeat;
    border-radius: 0;
    height: 45px;
    position: absolute;
    text-align: center;
    z-index: 1;
    width: 45px;
    left: 18px;
    top: 12px;
}
.download-doc{
    cursor: pointer;
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 19px;
}
.doc-date{
    font-family: calibri;
    color: #707070;
    font-size: 13px;
}
.file_basename{
    font-size: 16px;
    font-weight: 550;
    color: #1d1c1d;
    display: block;
    display: -webkit-box;
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap: break-word;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.document-preview{
    background-color: #ccccccd1;
    border-radius: 3px;
    border: 0;
    box-sizing: border-box;
    height: 100%;
    padding: 12px;
    width: 100%;
}
.doc-box{
  cursor: pointer;
}
.document-wrapper .doc-box: hover{
  background-color: rgba(9,45,66,.08);
}
.delete-document{
  font-family: calibri;
  color: #6b808c;
  font-size: 14px;
  text-decoration: underline;
}
.delete-header{
  box-sizing: border-box;
  color: #6b808c;
  display: block;
  line-height: 40px;
  border-bottom: 1px solid rgba(9,45,66,.13);
  margin: 0 12px;
  overflow: hidden;
  padding: 0 32px;
  position: relative;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.close-dropdown{
  position: absolute;
  top: 0;
  right: 0;
  padding: 12px 17px 10px 8px;
  font-size: 12px;
  color: #728894;
  text-decoration: none;
}
.text-delete{
  padding: 0 12px 12px;
}
.confirm-doc-delete{
  background-color: #eb5a46;
  /*box-shadow: 0 1px 0 0 #b04632;*/
  border: none;
  width: 100%;
}
.delete-header-holder{
  height: 40px;
  position: relative;
  margin-bottom: 8px;
  text-align: center;
}
.btn-toggleheader, .btn-fullscreen, .btn-borderless, .glyphicon-triangle-right, .glyphicon-triangle-left {
    display: none !important;
}
#loading-edoc{
  position: absolute;
  left: 40%;
  top: 27px;
  display: none;
}
.for-edoc-loader{
  position: relative;
}
.show-docs {
  display: none;
  color: #6b808c;
  width:200px;
  font-size: 14px;
}

.show-docs:hover {
    cursor: pointer;
}

/* Hide 5th div and all the ones after it */
.edocs-list div:nth-child(n+5) {
    display: none;
}
#basename-container{
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
</style>
  <div class="document-wrapper <?= !empty($forFolder) ? $forFolder : '';?>" id="document-wrapper<?=$target;?>">
    <div class="doc-container" id="doc-container<?=$target;?>">
        <div class="edocs-list" style="margin-top:<?= !empty($searchMargin) ? $searchMargin : 0;?>px">
      <?php 
      $count = 0;
      foreach ($edocument as $key => $value) {
        $filename = $value->file_location; //get file location
        $filepath = Url::base('http').Url::to('@web/'.$filename); //set file path
        $gview = 'https://docs.google.com/viewer?embedded=true&url=';
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $count++;
      ?>
        <div class="doc-box" value="
        <?php 
            switch($ext){
              case 'JPG': case 'jpg': case 'PNG': case 'png': case 'gif': case 'GIF': case 'jpeg': case 'JPEG':
                echo $filepath;
              break;
              default:
                echo $gview.$filepath;
            }
        ?>">
          <div class="doc-box-inner">
            <?php
              $value->fileExtension($filename);//show file thumbnail image based on extension
            ?>
          </div>
          <div class="doc-info">
            <a href="<?= $filepath;?>" class="download-documents" download>
              <i class="fa fa-cloud-download download-doc" aria-hidden="true" data-toggle="tooltip" title="Download"></i>
            </a>
            <div id="basename-container">
              <span class="file_basename" data-toggle="tooltip" title="<?=basename($value->file_location);?>">
                <?=basename($value->file_location); //get basename of file?> 
              </span>
            </div>
            <div>
              <span class="doc-date">Added <?=$value->timeElapsedString; //show how long ago the file was uploaded?></span> <span> <?= !empty($value->owner_id) ? 'by '.$value->username : ''?></span>
            </div>
            <div class="dropdown" id="edoc-display<?=$value->id?>">
            <span class="delete-document dropdown-toggle" id="dropdownMenuButton-doc<?=$value->id;?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-docid="<?= $value->id;?>">Delete</span>
            <div class="dropdown-menu edoc-drop" id="dropdownMenuButton<?=$value->id;?>" aria-labelledby="dropdownMenuButton">
              <div class="delete-header-holder">
                <span class="delete-header">
                  Confirm Delete
                </span>
                  <a href="#" class="close-dropdown">X</a>
              </div>
              <div class="text-delete">
                <div class="for-edoc-loader">
                  <p>Are you sure you want to delete this document?</p>
                  <span>
                    <?= Html::button('Delete', ['class' => 'btn btn-success confirm-doc-delete', 'name' => 'add', 'id' => 'delete-edoc'.$value->id, 'data-docid' => $value->id]) ?>
                    <span id="loading-edoc"><?= Yii::$app->settingscomponent->boffinsLoaderImage()?></span>
                  </span>
                </div>
              </div>
            </div>
          </div>              
          </div>
        </div>
      <?php } ?>
      <?php if($count > 4){ ?>
        <div class="show-docs more-docs">View all documents (<?= $count - 4;?>)</div>
        <div class="show-docs less-docs">Show Less</div>
      <?php }?>
    </div>
    </div>
  </div>

<?
$deleteEdocument = Url::to(['edocument/delete']); //path for delete action
$taskUrl = Url::to(['task/view']);
$list = <<<JS
//useful function to find nested parents of DOM
jQuery.fn.getParent = function(num) {
    var last = this[0];
    for (var i = 0; i < num; i++) {
        last = last.parentNode;
    }
    return jQuery(last);
};

$(document).ready(function() {
    var threshold = 4;

    if ($("div.edocs-list").children().not(".show-docs").length > threshold) {
        $(".show-docs.more-docs").css("display", "block");
    }


    $(".show-docs.more-docs").on("click", function() {
        $(this).parent().children().not(".show-docs").css("display", "block");
        $(this).parent().find(".show-docs.less-docs").css("display", "block");
        $(this).hide();
    });

    $(".show-docs.less-docs").on("click", function() {
        $(this).parent().children(":nth-child(n+" + (threshold + 1) + ")").not(".show-docs").hide();
        $(this).parent().find(".show-docs.more-docs").css("display", "block");
        $(this).hide();
    });

});

$('.show-list').click(function(){
  $('.document-wrapper').addClass('list-mode'); //unused
});

$('.hide-list').click(function(){
  $('.document-wrapper').removeClass('list-mode'); //unused
});

//on click of element show document preview
$('.doc-box').click(function(e){
    var value = $(this).attr('value')
        $('#kvFileinputModal').modal('show')
            .find('.kv-zoom-body')
            .html('<embed class="document-preview" src="'+value+'" height="100%" width="100%">');
});

//for deleting documents
$(".delete-document").unbind('click').bind('click',function(e) {
    console.log(123);
    e.stopPropagation();
    $(this).next().toggle();
    $(this).next().addClass('delete-opened');
});

$(document).click(function(){
  if($('.dropdown-menu').hasClass('delete-opened')){
    $(".edoc-drop").hide();
    $('.dropdown-menu').removeClass('delete-opened');
  }
});

//for deleting documents
$(".confirm-doc-delete").on('click', function(e){
  e.stopPropagation();
  //e.preventDefault();
  var edocId;
  edocId = $(this).data('docid');
  $(this).hide();
  var getThis;
  getThis = $(this);
  $(this).next().show();
  //var taskId = $('#document-wrappertask').getParent(3).attr('data-taskId');
  //var folderId =$('#document-wrappertask').getParent(3).attr('data-folderId');
  //console.log(taskId, folderId);
  _deleteEdocument(edocId,getThis) ;  
})

$('.close-dropdown').on('click', function(e){
  e.stopPropagation();
  if($('.dropdown-menu').hasClass('delete-opened')){
    $('.delete-opened').toggle();
    $('.dropdown-menu').removeClass('delete-opened');
  }
})

$('.download-documents').click(function(event){
    event.stopPropagation();
});

//ajax call to delete a document
function _deleteEdocument(edocId, getThis,taskId,folderId){
  setTimeout(function(){
    $.ajax({
        url: '$deleteEdocument',
        type: 'POST',
        async: false,
        data: {
            id: edocId, 
          },
        success: function(res, sec){
          toastr.success('Document Deleted');
          $.pjax.reload({container:"#kanban-refresh",async: false});
          $.pjax.reload({container:"#task-list-refresh",async: false});
         
          getThis.getParent(7).hide();
          //getThis.show();
          //getThis.next().hide();
        },
        error: function(res, sec){
            console.log('Something went wrong');
        }
    });
  }, 50);
}

JS;
$this->registerJs($list);
?>