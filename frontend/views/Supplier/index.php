<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    table{
  width:100%;
  table-layout: fixed;
}
.tbl-header{
  background-color: rgba(255,255,255,0.3);
 }
.tbl-contents{
  min-height:300px;
  margin-top: 50px;
  border: 1px solid rgba(255,255,255,0.3);
}
td{
  padding: 15px;
  text-align: left;
  vertical-align:middle;
  font-weight: 300;
  font-size: 12px;
  color: #666;
  border-bottom: solid 1px rgba(255,255,255,0.1);
}
.close-arrow{
    cursor: pointer;
}

.client-info-block{
    min-height: 60px;
    position: relative;
}
.user-avatar {
    border-radius: 50%;
    display: block;
    float: left;
    height: 100px;
    margin-right: 11px;
    width: 100px;

}
.company-name{
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 2px;
    overflow: hidden;
    padding-right: 21px;
    position: relative;
    white-space: nowrap;
    width: 100%;
}
.company-name-id{
    padding-top: 10px;
    padding-left: 24px;
}
.table-headers{
    background: #3c8dbc;
    padding: 20px 15px;
    text-align: left;
    font-weight: 500;
    font-size: 12px;
    color: #fff !important;
    text-transform: uppercase;
}
.table-rows td{
    border-bottom: 1px solid #ccc;
}
.th-table{
    display: none;
    position: fixed;
    background: #367fa9;
    width: 491px;
    z-index: 1;
    /* top: 0; */
    padding: 20px 15px;
    text-align: left;
    font-weight: bold;
    font-size: 16px;
    font-size: 12px;
    color: #fff;
    text-transform: uppercase;
}
.img-corp{
    height: 100px;
    width: 100px;
    padding-left: 17px;
    border-radius: 50%;
}


/* demo styles */

@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
</style>
<div class="client-index">
    <div style="background:#fff;padding: 10px;height:600px;overflow-y:scroll;padding-top:0px">
          <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead class="table-headers">
                <tr>
                  <th class="th-table">A list of your Corporation</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-contents">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <? foreach($suppliers as $supplier){?>
                    <tr class="table-rows"> <a href="#modal">
                      <td>
                        <div class="row">
                          <div class="client-info-block col-md-12">
                            <div class="img-corp col-md-2">
                              <div class="user-avatar user-default-avatar" style="background: url('<?= Url::to('@web/images/company/logo/company2.png'); ?>') no-repeat center center; background-size: cover;"></div>
                              </div>
                              <div class="col-md-10" style="padding:0px">
                                <div class="company-name">
                                    <div class="company-name-id" style="text-transform: uppercase;">
                                        <?= $supplier['name']; ?>
                                    </div>
                                    
                                </div>
                                <div class="company-name">
                                    <div class="company-name-id">
                                        <?= $supplier['notes']; ?>
                                    </div>
                                    
                                </div>
                                <div class="company-name">
                                    <div class="company-name-id">
                                        <button class="btn btn-primary"><?= $supplier['shortName']; ?></button>
                                    </div>
                                    
                                </div>
                              </div>
                          </div>
                        </div>
                    </td>
                    <td style="text-align: center;font-size: 20px">
                        <div class="dropdown">
                             <a class="btn btn-default dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <i class="fa fa-align-justify" style="padding-right: 5px"></i>More
                             </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                 <a class="dropdown-item" href="#">Action</a>
                                 <a class="dropdown-item" href="#">Another action</a>
                                 <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </td></a>
                    </tr>
                <? } ?>
              </tbody>
            </table>
          </div>
        </div>
</div>
<?php 
$clientIndexJs = <<<JS

$('.table-rows').mouseenter(function(){
        $(this).css('background','#ccc');
    }).mouseleave(function(){
            $(this).css('background','transparent');
        })
JS;
 
$this->registerJs($clientIndexJs);
?>
