
			   <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
                
              <li class="active"><a href="#tab_1-1" data-toggle="tab">Project Remarks</a></li>
              <li><a href="#tab_2-2" data-toggle="tab">Invoice Remarks</a></li>
              <li><a href="#tab_3-2" data-toggle="tab">Order Remarks</a></li>
              <li><a href="#tab_4_4" data-toggle="tab">All Remarks</a></li>
              
              <li class="pull-left header"><i class=""></i>Remarks </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1">
                <div class="box">
                    <h1 style="text-align:center;">Project Remarks</h1>
                    <div class="folder-index">

                    <h1><?= Html::encode($this->title) ?></h1>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
               
    
                  <div class="box-body">
                    
                    <table id="project_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th></th>
                              
                  
                            </tr>
                        </thead>
                        <tbody>
                          <td>
							    <!-- USERS LIST -->
              <div class="box box-danger">
               
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <li>
                      <img src="dist/img/user1-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Alexander Pierce</a>
                      <span class="users-list-date">Today</span>
                    </li>
                    <li>
                      <img src="dist/img/user8-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Norman</a>
                      <span class="users-list-date">Yesterday</span>
                    </li>
                    <li>
                      <img src="dist/img/user7-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Jane</a>
                      <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user6-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">John</a>
                      <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user2-160x160.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Alexander</a>
                      <span class="users-list-date">13 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user5-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Sarah</a>
                      <span class="users-list-date">14 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user4-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Nora</a>
                      <span class="users-list-date">15 Jan</span>
                    </li>
                    <li>
                      <img src="dist/img/user3-128x128.jpg" alt="User Image">
                      <a class="users-list-name" href="#">Nadia</a>
                      <span class="users-list-date">15 Jan</span>
                    </li>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
						  </td>  
                            <!-- content here -->
                   
                  </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                            </tr>
                </tfoot>
                
                    </table>
                </div>
              </div>
            </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2-2">
               
                  
                 <div class="box">
                    <h1 style="text-align:center;">Invoice Remarks</h1>
                    <div class="folder-index">

                <h1><?= Html::encode($this->title) ?></h1>
                  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
               
    
                  <div class="box-body">
                    
                    <table id="invoice_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th></th>
                              
                  
                            </tr>
                        </thead>
                        <tbody>
                            
                             <!-- content here -->
                   
                  </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                            </tr>
                </tfoot>
                
                    </table>
                </div>
              </div>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3-2">
                
                 <div class="box">
                 <h1 style="text-align:center;">Order Remarks</h1>
                 <div class="folder-index">

                <h1><?= Html::encode($this->title) ?></h1>
                  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
               
    
                  <div class="box-body">
                    
                    <table id="order_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th></th>
                              
                  
                            </tr>
                        </thead>
                        <tbody>
                            
                            
							 <!-- /.content here  -->
                   
                  </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                            </tr>
                </tfoot>
                
                    </table>
                </div>
              </div>
                </div>
              </div>
                
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4_4">
                <div class="box">
                    <h1 style="text-align:center;">All Remarks</h1>
                    <div class="folder-index">

                    <h1><?= Html::encode($this->title) ?></h1>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
               
    
                  <div class="box-body">
                    
                    <table id="all_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th></th>
                              
                  
                            </tr>
                        </thead>
                        <tbody>
                            <!-- content here  --> 
                   
                  </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                            </tr>
                </tfoot>
                
                    </table>
                </div>
              </div>
            </div>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>