<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
	<div id="page-inner">
		<h1><?= Html::encode($this->title) ?></h1>
             
                            <div class="row text-center pad-top">
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-all-customer-email'])?>" >
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Send Customers Email</h4>
                      </a>
                      </div>
                     
                     
                  </div> 
                 
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-all-customer-push-notification'])?>" >
 <i class="fa fa-envelope-o fa-5x"></i>
                      <h4>Send Customer Pushnotification</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-all-customer-users-email'])?>" >
 <i class="fa fa-lightbulb-o fa-5x"></i>
                      <h4>Send Users Email</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-all-customer-users-push-notification'])?>" >
 <i class="fa fa-users fa-5x"></i>
                      <h4>Send Users Pushnotification
							   </h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  
                  
              </div>
                 <!-- /. ROW  --> 
               
          <div class="customer-index">

    <br/>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'entityName',
            'cid',
            'master_email:email',
            'master_doman',
            'comOrPersonName',
            //'billing_date',
            //'account_number',
            //'has_admin',

            ['class' => 'yii\grid\ActionColumn',
			'template' => '{view}',
			],
        ],
    ]); ?>
</div>
       
                
    </div>
