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
  height:100px;
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
</style>
<?php if(!empty($edocument)){ ?>
    <div class="document-wrapper">
        <div class="doc-container">
            <?php foreach ($edocument as $key => $value) { ?>
                <div class="doc-box">
                    <div class="doc-box-inner">
                        <?php
                            $filename = $value->file_location;
                            $filepath = Url::to('@web/'.$filename);
                            $value->fileExtension($filename);
                        ?>
                    </div>
                        <div class="doc-info">
                            <a href="<?= $filepath;?>" download><i class="fa fa-download download-doc" aria-hidden="true"></i></a>
                            <div><span class="file_basename"><?=basename($value->file_location);?></span></div>
                            <div>
                                <span class="doc-date">Added <?=$value->timeElapsedString;?></span>
                            </div>
                        </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php }else{
    echo 'no documents';
} ?>

<? 
    Modal::begin([
        'header' => '<h4>Destination</h4>',
        'id' => 'modelx',
        'size' => 'modal-lg', 
    ]);
?>
<div id="modelContentx"></div>
<?
    Modal::end();
?>

<?
$list = <<<JS
$('.show-list').click(function(){
  $('.document-wrapper').addClass('list-mode');
});

$('.hide-list').click(function(){
  $('.document-wrapper').removeClass('list-mode');
});

$('.doc-img').click(function(){
        $('.modal').modal('show')
            .find('.kv-zoom-body')
            .load($(this).attr('value'));
});
JS;
$this->registerJs($list);
?>