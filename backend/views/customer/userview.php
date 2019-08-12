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
		<div class="col-md-6 col-lg-6 col-xlg-6">
			<div class="card card-hover">
				<div class="box ">
					<h2>Users Custormer Domain : <em><strong><?= $model->customer->master_doman;?></strong></em></h2>
					<h4>Users Name: <em><strong><?= $model->nameString;?></strong></em></h4>
					<h4>Users Company Name: <em><strong><?= $model->customer->comOrPersonName;?></strong></em></h4>
					<h4>Users Email: <em><strong><?= $model->email;?></strong></em></h4>
					<h4>Users Role: <em><strong><?= $model->roleName;?></strong></em></h4>
					<h4>Users Last Login: <em><strong><?= $model->last_login;?></strong></em></h4>
					<h4>Users Last Updated: <em><strong><?= $model->last_updated;?></strong></em></h4>
					<h4>Mobile App User: <em><strong><?= !empty($model->pushToken) ? 'Yes':'No';?></strong></em></h4>
					<h4>Users Status: <em><strong><?= $model->deleted == 0 ? 'Active':'Inactive';?></strong></em></h4>
				</div>
			</div>
		</div>
	</div>

	<div id="page-inner">
             
                            <div class="row text-center pad-top">
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-user-email','id' => $model->id])?>" >
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Send Email</h4>
                      </a>
                      </div>
                     
                     
                  </div> 
                 <? if(!empty($model->pushToken)){?>
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-user-push-notification','id' => $model->id])?>" >
 <i class="fa fa-envelope-o fa-5x"></i>
                      <h4>Send Pushnotification</h4>
                      </a>
                      </div>
                     
                  </div>
                 <? }?>
                  
              </div>
                 <!-- /. ROW  --> 
               
                 
                
    </div>

</div>

