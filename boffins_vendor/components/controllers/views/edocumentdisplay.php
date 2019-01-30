<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\Pjax;
    use yii\bootstrap\Modal;
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
  width:273px;
  min-height:100px;
  margin:0 10px 10px 0;
  background-color:#fff;
  border-radius: 20px;
  -webkit-transition:all 1.0s ease;
  -moz-transition:all 1.0s ease;
  transition:all 1.0s ease;
  transition:all 1.0s ease;
  box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
}

.doc-box .doc-box-inner{
  float:left;
  width:25%;
  height:80px;
  -webkit-transition:all 1.0s ease;
  -moz-transition:all 1.0s ease;
  transition:all 1.0s ease;
  transition:all 1.0s ease;
}

.doc-info{
  margin: 15px 0px 0px 135px;
}

.document-wrapper.list-mode .doc-container{
  padding-right:10px;
}

.document-wrapper.list-mode .doc-box{
  width:100%;
}
.doc-img{
    background-position: 50%;
    background-size: cover;
    background-repeat: no-repeat;
    border-radius: 20px;
    height: 100px;
    position: absolute;
    text-align: center;
    z-index: 1;
    width: 120px;
}
.download-doc{
    cursor: pointer;
}
.doc-date{
    font-family: calibri;
    color: #707070;
    font-size: 13px;
}
.file_basename{
    font-size: 13px;
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
  box-shadow: 0 1px 0 0 #b04632;
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
</style>
  <div class="document-wrapper">
    <div class="doc-container">
        <div style="margin-top:<?= !empty($searchMargin) ? $searchMargin : 0;?>px">
      <?php foreach ($edocument as $key => $value) {
        $filename = $value->file_location;
        $filepath = Url::to('@web/'.$filename);
        $gview = 'https://docs.google.com/viewer?embedded=true&url=';
      ?>
        <div class="doc-box" value="<?=$gview.$filepath;?>">
          <div class="doc-box-inner">
            <?php
              $value->fileExtension($filename);
            ?>
          </div>
          <div class="doc-info">
            <a href="<?= $filepath;?>" class="download-documents" ria-hidden="true" data-toggle="tooltip" title="Download" download>
              <i class="fa fa-download download-doc" aria-hidden="true"></i>
            </a>
            <div id="basename-container">
              <span class="file_basename">
                <?=basename($value->file_location);?>
              </span>
            </div>
            <div>
              <span class="doc-date">Added <?=$value->timeElapsedString;?></span>
            </div>
            <div class="dropdown">
            <span class="delete-document dropdown-toggle" id="dropdownMenuButton-doc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-docid="<?= $value->id;?>">Delete</span>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <div class="delete-header-holder">
                <span class="delete-header">
                  Confirm Delete
                </span>
                  <a href="#" class="close-dropdown">X</a>
              </div>
              <div class="text-delete">
                <div>
                  <p>Are you sure you want to delete this document?</p>
                  <?= Html::button('Delete', ['class' => 'btn btn-success confirm-doc-delete', 'name' => 'add', 'id' => 'delete-edoc'.$value->id, 'data-docid' => $value->id]) ?>
                </div>
              </div>
            </div>
          </div>              
          </div>
        </div>
      <?php } ?>
    </div>
    </div>
  </div>

<?
$deleteEdocument = Url::to(['edocument/delete']);
$list = <<<JS

$('.show-list').click(function(){
  $('.document-wrapper').addClass('list-mode');
});

$('.hide-list').click(function(){
  $('.document-wrapper').removeClass('list-mode');
});

$('.doc-box').click(function(e){
  //if(e.target !== e.currentTarget) return;
  //$(this).children(".doc-info").toggle();
    var value = $(this).attr('value')
        $('#kvFileinputModal').modal('show')
            .find('.kv-zoom-body')
            .html('<iframe class="document-preview" src="'+value+'" height="100%" width="100%"></iframe>');
});

$(".delete-document").on('click',function(e) {
    e.stopPropagation();
    $(this).next('.dropdown-menu').toggle();
    $(this).next('.dropdown-menu').addClass('delete-opened');
});

$(document).click(function(){
  //$(".dropdown-menu").hide();
});

$(".confirm-doc-delete").on('click', function(e){
  e.stopPropagation();
  var edocId;
  edocId = $(this).data('docid');
  console.log(edocId)
  //$('.loading-delete-task').show();
  _deleteEdocument(edocId);  
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

function _deleteEdocument(edocId){
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
          //$.pjax.reload({container:"#task-modal",async: false});
          $(".dropdown-menu").hide();
        },
        error: function(res, sec){
            console.log('Something went wrong');
        }
  });
}

JS;
$this->registerJs($list);
?>