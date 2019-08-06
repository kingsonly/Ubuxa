<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Customer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">
           
	<div class="row">
		<div class="col-md-6 col-lg-4 col-xlg-3">
			<div class="card card-hover">
				<div class="box ">
					<h2>Custormer Domain : <em><strong><?= $model->master_doman;?></strong></em></h2>
					<h4>Custormer Email: <em><strong><?= $model->master_email;?></strong></em></h4>
					<h4>Custormer Company Name: <em><strong><?= $model->comOrPersonName;?></strong></em></h4>
					<h4>Custormer Billing Date: <em><strong><?= $model->billing_date;?></strong></em></h4>
					<h4>Custormer Has Admin: <em><strong><?= $model->has_admin == 1?'Yes':'No';?></strong></em></h4>
				</div>
			</div>
		</div>
	</div>
<div class="row">
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-success text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-chart-areaspline"><?= $customerUsers;?></i></h2>
                                <h6 class="text-white">Total Users</h6>
                            </div>
                        </div>
                    </div>
                     <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-warning text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-collage"><?= $customerFolders;?></i></h2>
                                <h6 class="text-white">Total Folders</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-danger text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-border-outside"><?= $customerTasks;?></i></h2>
                                <h6 class="text-white">Total Tasks</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-info text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-arrow-all"><?= $customerDocuments;?></i></h2>
                                <h6 class="text-white">Total Documents</h6>
                            </div>
                        </div>
                    </div>
	</div>
	<div id="page-inner">
             
                            <div class="row text-center pad-top">
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-customer-email','id' => $model->id])?>" >
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Send Customers Email</h4>
                      </a>
                      </div>
                     
                     
                  </div> 
                 
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-customer-push-notification','id' => $model->id])?>" >
 <i class="fa fa-envelope-o fa-5x"></i>
                      <h4>Send Customer Pushnotification</h4>
                      </a>
                      </div>
                     
                  </div>
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-customer-users-email','id' => $model->id])?>" >
 <i class="fa fa-lightbulb-o fa-5x"></i>
                      <h4>Send Users Email</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-customer-users-push-notification','id' => $model->id])?>" >
 <i class="fa fa-users fa-5x"></i>
                      <h4>Send Users Pushnotification
							   </h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  
                  
              </div>
                 <!-- /. ROW  --> 
               
                 
                
    </div>
	<div id="page-inner">
		<table class="table">
			<tr>
				<td>SN</td>
				<td>Full Name</td>
				<td>Company Basic Role</td>
				<td>Last Login</td>
				<td>Last Updated</td>
				<td>Status</td>
				<td>Action</td>
				
			</tr>
		<? $i = 1; ?>
		<? foreach($users as $key => $value){?>
		<tr>
			<td><?= $i; ?></td>
			<td><?= !empty($value->nameString)?$value->nameString:'Not Available';?></td>
			<td><?= $value->roleName;?></td>
			<td><?= $value->last_login;?></td>
			<td><?= $value->last_updated;?></td>
			<td><?= $value->deleted == 0 ? 'Active':'Inactive';?></td>
			<td>
				<a href="<?= Url::to(['customer/user-view','id' => $value->id])?>" >
					<span class="glyphicon glyphicon-eye-open"></span>
				</a>			
			</td>
			
		</tr>
		<? $i++; ?>
		<? }?>
		</table>
	</div>
</div>

