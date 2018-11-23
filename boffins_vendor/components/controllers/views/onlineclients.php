<style type="text/css">
   .infos{
      background-color: #fff;
      box-shadow: 2px 8px 25px -2px rgba(0,0,0,0.1);
      padding: 10px;
    }
    
    .box-clients{
      height: 80px;
      border-right: 1px solid #e9ecf2;
    }
    .box-clients-count{
      border-right: 1px solid #e9ecf2;
      height: 80px;
      text-align: center;
    }
    .box-clients-count1{
      height: 80px;
    }
    .active-client{
      font-family: calibri;
      font-size: 19px;
    }
    .active-client-number{
      font-family: calibri;
      font-weight: bold;
      font-size: 23px;
    }
      
   .active-header {
      padding-top: 25px;
   }
   .client-active{
      background-color: #fff;
   }
</style>
<?php
  $siteUrl = explode('/',yii::$app->getRequest()->getQueryParam('r'));
  $siteUrlParam = $siteUrl[0];
?>
<div class="col-md-6">
  <div class="row">
    <?php if($siteUrlParam == 'folder'){?>
						    	<div class="infos col-sm-12 col-xs-12">
                      <div class="col-sm-4 col-xs-4 box-clients" style="text-align:center">
                        <em class="fa fa-xl fa-users color-teal" style="font-size: 2em; color:#1ebfae !important"></em>
                        <div class="active-client" style="font-size: 2em;">
                          <?php if(!empty($usersStat)){ ?>
                          <? 
                            $usersStat = count($users); 
                            echo $usersStat;
                          ?>
                        <?php } ?>
                        </div>
                        <div class="active-client-clients" style="margin-top: -6px;text-transform: uppercase;font-weight: bold;font-size: 0.8em;color:#c5c7cc">Folder Users</div>
                    </div>
                    <div class="col-sm-4 col-xs-4 box-clients-count">
                      <em class="fa fa-circle-o-notch" style="font-size: 2em; color:#d9534f !important"></em>
                      <div class="active-client-number" style="font-size: 2em;">
                        <?php if(!empty($taskStats)){ ?>
                        <?php
                          $i = 0;
                          foreach ($taskStats as $key => $assignedTo) {
                            $i++;
                          }
                          echo $i;
                        ?>
                      <?php } ?>
                      </div>
                      <div class="active-client-clients" style="margin-top: -6px;text-transform: uppercase;font-weight: bold;font-size: 0.8em;color:#c5c7cc">Task Assigned</div>

                    </div>
                    <div class="col-sm-4 col-xs-4 box-clients-count1" style="text-align:center">
                     <em class="fa fa-circle-o" style="font-size: 2em; color: #5cb85c !important"></em>
                      <div class="active-client-number" style="font-size: 2em;">
                        <?php if(!empty($taskStats)){ ?>
                          <?php
                            $i = 0;
                            foreach ($taskStats as $key => $completed) {
                              if($completed->status_id == 24){
                                $i++;
                              }
                            }
                            echo $i;
                          ?>
                        <?php } ?>
                      </div>
                      <div class="active-client-clients" style="margin-top: -6px;text-transform: uppercase;font-weight: bold;font-size: 0.8em;color:#c5c7cc">Task Completed</div>
                    </div>
                      
                  </div>
      <?php }else if($siteUrlParam == 'site'){?>
                  <div class="infos col-sm-12 col-xs-12">
                      <div class="col-sm-4 col-xs-4 box-clients" style="text-align:center">
                        <em class="fa fa-xl fa-users color-teal" style="font-size: 2em; color:#1ebfae !important"></em>
                        <div class="active-client" style="font-size: 2em;">
                          <?php 
                            $allUsers = $users->find()->count();
                            echo $allUsers; 
                          ?>
                        </div>
                        <div class="active-client-clients" style="margin-top: -6px;text-transform: uppercase;font-weight: bold;font-size: 0.8em;color:#c5c7cc">Users</div>
                    </div>
                    <div class="col-sm-4 col-xs-4 box-clients-count">
                      <em class="fa fa-folder" style="font-size: 2em; color:#d9534f !important"></em>
                      <div class="active-client-number" style="font-size: 2em;">
                        <?php 
                            $allFolders = $folder->find()->count();
                            echo $allFolders; 
                        ?>
                      </div>
                      <div class="active-client-clients" style="margin-top: -6px;text-transform: uppercase;font-weight: bold;font-size: 0.8em;color:#c5c7cc">Folders</div>

                    </div>
                    <div class="col-sm-4 col-xs-4 box-clients-count1" style="text-align:center">
                     <em class="fa fa-circle-o" style="font-size: 2em; color: #5cb85c !important"></em>
                      <div class="active-client-number" style="font-size: 2em;">
                          <?php 
                            $allTasks = $task->find()->count();
                            echo $allTasks;
                          ?>
                      </div>
                      <div class="active-client-clients" style="margin-top: -6px;text-transform: uppercase;font-weight: bold;font-size: 0.8em;color:#c5c7cc">Tasks</div>
                    </div>
                      
                  </div>
      <?php }?>
  </div>
</div>