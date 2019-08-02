<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserFeedback */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Feedbacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-feedback-view">

    <div id="page-inner">
             
                            <div class="row text-center pad-top">
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-user-email','id' => $model->user_id])?>" >
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Send Email</h4>
                      </a>
                      </div>
                     
                     
                  </div> 
                 <? if(!empty($model->pushToken)){?>
                  <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/send-user-push-notification','id' => $model->user_id])?>" >
 <i class="fa fa-envelope-o fa-5x"></i>
                      <h4>Send Pushnotification</h4>
                      </a>
                      </div>
                     
                  </div>
                 <? }?>
								
				<div class="col-lg-3 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?//= Url::to(['customer/send-user-email','id' => $model->user_id])?>" >
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Create Task</h4>
                      </a>
                      </div>
                     
                     
                  </div> 
                  
              </div>
                 <!-- /. ROW  --> 
               
                 
                <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'userName',
            'user_comment',
            'user_agent',
            'created_at',
            'last_update',
            'deleted',
            'userCustomer',
        ],
    ]) ?>
    </div>


</div>
