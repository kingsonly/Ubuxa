
<?php 
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
?>


<style>
.show-list{
  -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.document-wrapper{
  width:450px;
  margin:30px auto 0;
  background-color:#FFFFFF;
  -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
  doc-box-sizing: border-box;
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
  padding:10px 0 10px 10px;
}

.document-wrapper .doc-box{
  float:left;
  width:100px;
  height:100px;
  margin:0 10px 10px 0;
  background-color:#CCCCCC;
  -webkit-transition:all 1.0s ease;
  -moz-transition:all 1.0s ease;
  transition:all 1.0s ease;
  transition:all 1.0s ease;
}

.document-wrapper.list-mode .doc-container{
  padding-right:10px;
}

.document-wrapper.list-mode .doc-box{
  width:100%;
}
</style>

<div class="document-wrapper">
  <header class="list-type">
      <a href="javascript:void(0)" class="show-list"><i class="fa fa-th-list" aria-hidden="true"></i></a>
        <a href="javascript:void(0)" class="hide-list"><i class="fa fa-th" aria-hidden="true"></i></a>
    </header>
    <div class="doc-container">
      <div class="doc-box"></div>
        <div class="doc-box">Hello</div>
        <div class="doc-box"></div>
        <div class="doc-box"></div>
        <div class="doc-box"></div>
        <div class="doc-box"></div>
        <div class="doc-box"></div>
    </div>
</div>
<?
$list = <<<JS
$('.show-list').click(function(){
  $('.document-wrapper').addClass('list-mode');
});

$('.hide-list').click(function(){
  $('.document-wrapper').removeClass('list-mode');
});
JS;
$this->registerJs($list);
?>