<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  .client-index{
    background-image: linear-gradient(#fff, #ccc);
  }
  .list-action, .list-logo, .list-name, .list-email{
    display: inline-block;
    font-family: calibri;
  }
  .list-container{
    width: 100%;
    background-image: linear-gradient('#fff',"#ccc");
  }
  .list-action{
    width: 10%;
    text-align: center
  }
  .list-logo{
    width: 5%;
  }
  .list-name{
    width: 55%;
    display: block;
      overflow: hidden;
      padding-left: 11px;
  }
  .list-email{
    width: 29.2%;
  }
  .list-item-row{
    border:1px solid #ccc;
    padding: 20px 0px;
  }
  .logo-image{
    background: #fff;
    background-size: cover;
      border: 0;
      vertical-align: top;
      height: 48px;
      width: 48px;
      border-radius: 25px;
      position: absolute;
      left: 100px;
      top: 8px;
  }
  .email-corp{
    font-size:15px;
  }
  .content-row{
    display: table-row;
  }
  .contents{
    display: table-cell;
      padding: 24px 10px 26px 63px;
      overflow: hidden;
      vertical-align: top;
      width: 100%;
      position: relative;
      box-sizing: border-box;
      border-bottom: 1px solid #ecedef;
  }

  .corporation-img{
    background: #fff;
    border: 0;
      vertical-align: top;
      height: 48px;
      width: 48px;
      border-radius: 25px;
      position: absolute;
      left: 10px;
      top: 24px;
  }
  .corporation-text{
    display: block;
      overflow: hidden;
      padding-left: 11px;
  }
  .corporation-title{
    font-weight: 600;
      display: block;
      font-size: 16px;
      padding-left: 2px;
      margin-bottom: 8px;
      zoom: 1;
      word-wrap: break-word;
  }
  .corporation-description{
    display: block;
      text-overflow: ellipsis;
      overflow: hidden;
      font-size: 13px;
      width:400px;
      color: #777;
      padding-left: 2px;
      white-space: nowrap;
      margin-bottom: 8px;
      zoom: 1;
  }
  .corporation-users{
    color: #888;
      font-size: 13px;
      padding-left: 2px;
  }
  .wrap-corp{
    border-bottom: 3px solid #eef2f4;
    position: relative;
    margin: -5px 0 0;
    padding-top: 0;
    padding-left: 20px;
    height: 37px;
    color: #38404a;
    vertical-align: top;
    font-size: 12px;
    font-weight: normal;
    text-transform: uppercase;
    font-family: "Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
  }
  .sortby-text{
    height: 27px;
    border-bottom: 1px solid #ecedef;
    color: #38404a;
    vertical-align: top;
    font-size: 12px;
    font-weight: normal;
    text-transform: uppercase;
    font-family: "Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
  }
</style>
<div class="client-index" id="client-index">
  <div class="wrap-corp">
    <span>sort by:</span>
    <span class="sortby-text">
      <input type="text" name="" id="client-search">
    </span>
  </div>
  <? foreach($clients as $client){ ?>
  <div class="content-row">
    <div class="contents">
      <span class="corporation-img" style="background: url('<?= Url::to('@web/images/company/logo/company2.png'); ?>') no-repeat center center; background-size: cover;"></span>
      <span class="corporation-text">
        <span class="corporation-title"><?= $client['name']; ?></span>
        <span class="corporation-description"><?= $client['notes']; ?></span>
        <span class="corporation-users">2 members</span>
      </span>
    </div>
  </div>
  <? } ?>
</div>
<?php 
$clientJs = <<<JS


$(document).on('keyup','#client-search', function(){
  // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('client-search');
    filter = input.value.toUpperCase();
    ul = document.getElementById("client-index");
    li = ul.getElementsByClassName('content-row');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByClassName("corporation-title")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
})

JS;
 
$this->registerJs($clientJs);
?>
