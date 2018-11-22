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
.user-avatars {
    border-radius: 50%;
    display: block;
    float: left;
    height: 50px;
    /*margin-right: 11px;*/
    width: 50px;

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
.img-corps{
    height: 50px;
    width: 50px;
   /* padding-left: 17px;*/
    border-radius: 50%;
}
.active-users:before{
	background-color: #baed21;
    border-radius: 50%;
    content: '';
    height: 9px;
    left: 4px;
    top: 9px;
    position: absolute;
    width: 9px;
}
.employ-head{
    padding: 5px;
    background: #ccc;
    border-radius:3px;
}
.head-left{
	padding-left: 27px;
    font-size: 18px;
    font-family: calibri;
    color: #666;
    font-weight: bold;
}
.head-center{
    font-size: 18px;
    font-family: calibri;
    cursor: pointer;
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
                  <th class="th-table">Employees</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="col-md-12">
          	<div class="row employ-head">
          		<div class="col-md-4 head-left">Employees</div>
          		<div class="col-md-2">
          			<div class="">
          				<span class="active-users head-center">Active</span>
          			</div>
          		</div>
          		<div class="col-md-6">
          			<div class="bx24-top-bar-search-wrap employee-search-wrap">
						<form method="GET" name="FILTER_company_search_adv" action="/company/">
						<input type="hidden" name="show_user" value="active">
						<input type="hidden" name="current_filter" value="adv">
						<input class="bx24-top-bar-search" type="text" id="user-search" name="company_search_FIO" value="">
						<input type="hidden" name="set_filter_company_search" value="Y">
						<div class="btn btn-default ">
							<span class="fa fa-search" id="button-search-user"></span>
						</div> 
						
						</form>
					</div>
				</div>
          	</div>
          </div>
          <div class="tbl-contents">
            <table cellpadding="0" cellspacing="0" border="0">
              <tbody id="table-body">
                <? foreach($dataProvider as $data){?>
                    <tr class="table-rows" id="table-rows">
                      <td>
                        <div class="row">
                          <div class="client-info-block col-md-12">
                            <div class="img-corps col-md-2">
                              <div class="user-avatars user-default-avatar" style="background: url('<?= Url::to('@web/images/users/default-user.png'); ?>') no-repeat center center; background-size: cover;"></div>
                              </div>
                              <div class="col-md-10" style="padding:0px">
                                <div class="company-name">
                                    <div class="company-name-id" style="text-transform: uppercase;">
                                        <?= $data->fullname; ?>
                                    </div>
                                    
                                </div>
                                <div class="company-name">
                                    <div class="company-name-id">
                                        <?//= $supplier['notes']; ?>
                                    </div>
                                    
                                </div>
                                <div class="company-name">
                                    <div class="company-name-id">
                                        <button class="btn btn-primary"><?= $data->role->name; ?></button>
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
<div class="supplier-index" id="supplier-index">
  <div class="wrap-corp">
    <span>sort by:</span>
    <span class="sortby-text">
      <input type="text" name="" id="supplier-search">
    </span>
  </div>
  <? foreach($dataProvider as $data){ ?>
  <div class="content-row">
    <div class="contents">
      <span class="corporation-img" style="background: url('<?= Url::to('@web/images/users/default-user.png'); ?>') no-repeat center center; background-size: cover;"></span>
      <span class="corporation-text">
        <span class="corporation-title"><?= $data->fullname; ?></span>
        <span class="corporation-description"><?= $supplier['notes']; ?></span>
        <span class="corporation-users">2 members</span>
      </span>
    </div>
  </div>
  <? } ?>
</div>

<?php 
$clientIndexJs = <<<JS

$('.table-rows').mouseenter(function(){
        $(this).css('background','#ccc');
    }).mouseleave(function(){
            $(this).css('background','transparent');
        })
$(document).on('keyup','#user-search', function(){
	// Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('user-search');
    filter = input.value.toUpperCase();
    ul = document.getElementById("table-body");
    li = ul.getElementsByTagName('tr');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByClassName("company-name-id")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
})
JS;
 
$this->registerJs($clientIndexJs);
?>

