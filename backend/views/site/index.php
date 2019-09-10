<?
use yii\helpers\Url;

?>


 <!-- Sales Cards  -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-view-dashboard"><?= $totalCustomers;?></i></h2>
                                <h6 class="text-white">Total Customers</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-4 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-success text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-chart-areaspline"><?= $totalUsers;?></i></h2>
                                <h6 class="text-white">Total Users</h6>
                            </div>
                        </div>
                    </div>
                     <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-warning text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-collage"><?= $totalFolder;?></i></h2>
                                <h6 class="text-white">Total Folders</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-danger text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-border-outside"><?= $totalTasks;?></i></h2>
                                <h6 class="text-white">Total Tasks</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-info text-center">
                                <h2 class="font-light text-white"><i class="mdi mdi-arrow-all"><?= $totalDocuments;?></i></h2>
                                <h6 class="text-white">Total Documents</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
         
                <!-- ============================================================== -->

<div id="page-inner">
             
                            <div class="row text-center pad-top">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?= Url::to(['customer/index'])?>" >
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Customers</h4>
                      </a>
                      </div>
                     
                     
                  </div> 
                 
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="<?=Url::to(['feedback/index'])?>" >
 <i class="fa fa-envelope-o fa-5x"></i>
                      <h4>Feedbacks</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="" >
 <i class="fa fa-lightbulb-o fa-5x"></i>
                      <h4>Leads</h4>
                      </a>
                      </div>
                     
                     
                  </div>
                  
                  
                  
              </div>
                 <!-- /. ROW  --> 
                
                    
                 
                
    </div>