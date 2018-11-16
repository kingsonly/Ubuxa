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
    table{
  width:100%;
  table-layout: fixed;
}
.tbl-header{
  background-color: rgba(255,255,255,0.3);
 }
.tbl-contents{
  min-height:300px;
  margin-top: 0px;
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
    display: none;
    background: #3c8dbc;
    padding: 20px 15px;
    text-align: left;
    font-weight: 500;
    font-size: 12px;
    color: #fff !important;
    text-transform: uppercase;
}
.table-rows{
    border-bottom: 1px solid #ccc;
}


/* demo styles */

@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
</style>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<div style="display:none">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'corporation_id',
            [
                'label' => 'Name',
                'value' => 'name'
            ],
            'last_updated',
            'deleted',
            'cid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
    <div style="background:#fff;padding: 10px">
          <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead class="table-headers">
                <tr>
                  <th>Company Name</th>
                  <th>Short Name</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-contents">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <? foreach($clients as $client){?>
                    <tr class="table-rows">
                      <td>
                        <div class="row">
                          <div class="client-info-block col-md-12">
                            <div class=" col-md-2">
                              <div class="user-avatar user-default-avatar" style="background: url('<?= Url::to('@web/images/company/logo/company2.png'); ?>') no-repeat center center; background-size: cover;"></div>
                              </div>
                              <div class="col-md-10">
                                <div class="company-name">
                                    <div class="company-name-id" style="text-transform: uppercase;">
                                        <?= $client['name']; ?>
                                    </div>
                                    
                                </div>
                                <div class="company-name">
                                    <div class="company-name-id">
                                        <?= $client['notes']; ?>
                                    </div>
                                    
                                </div>
                                <div class="company-name">
                                    <div class="company-name-id">
                                        <button class="btn btn-primary"><?= $client['shortName']; ?></button>
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
                    </td>
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
