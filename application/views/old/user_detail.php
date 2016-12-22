<?php $this->load->view('admin/common/common-header');?>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <?php $this->load->view('admin/common/left-nav');?>
            <!-- top navigation -->
            <?php $this->load->view('admin/common/top-nav');?>
            <!-- /top navigation -->
            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $page_heading?></h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                                        <div class="profile_img">
                                            <!-- end of image cropping -->
                                            <div id="crop-avatar">
                                                <!-- Current avatar -->
                                                <div class="avatar-view" title="Change the avatar">
                                                    <?php if($userRow['picture']==''){?>
                                                    <img src="<?php echo base_url()?>uploads/data/no_logo.png" alt="">
                                                    <?php }else{?>
                                                    <img src="<?php echo base_url()?>uploads/data/<?php echo $userRow['picture']?>" alt="">
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                        <h3><?php echo $userRow['firstname']." ".$userRow['lastname']?></h3>
                                        <ul class="list-unstyled user_data">
                                            <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $userRow['address']?>, <?php echo $userRow['city']?>, <?php echo $userRow['state']?> <?php echo $userRow['zipcode']?>,<?php echo $userRow['country']?></li>
                                        </ul>
                                        <a href="<?php echo base_url()?>admin/Users/editUser?id=<?php echo $userRow['id'];?>" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                                        <br />
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>User Detail</h2>
                                            </div>
                                            
                                        </div>
                                        <!-- start of user-activity-graph -->
                                        <div style="width:100%; height:320px;">
                                            <table class="table table-striped">
                                                <tr>
                                                    <td>Phone:</td>
                                                    <td><?php echo $userRow['phone']?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                   <?php if($currentPackageDetail){ ?>
									<div class="col-md-9 col-sm-9 col-xs-12">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Package Detail</h2>
                                            </div>
                                        </div>
                                        <!-- start of user-activity-graph -->
                                        <div style="width:100%;">
                                            <table class="table table-striped">
                                     
											   		<tr>
                                                    	<td><strong>Package Type</strong></td>
                                                        <td><strong>Text Cridet</strong></td>
                                                        <td><strong>Document Credit</strong></td>
                                                        <td><strong>Video Credit</strong></td>
                                                        <td><strong>Audio Credits</strong></td>
                                                        <td><strong>Expire Date</strong></td>
                                                    </tr>
													<?php foreach($currentPackageDetail as $detail){ ?>
													<tr>
														
														<td><?php echo $detail['type'] ?></td>
														<td> <?php echo $detail['text'] ?></td>
														<td> <?php echo $detail['document'] ?></td>
														<td> <?php echo $detail['video'] ?></td>
														<td> <?php echo $detail['audio'] ?></td>
														<td><?php echo $detail['expiry_date'] ?></td>
													</tr>
                                              <?php	}?>
                                            </table>
                                        </div>
                                        <!-- end of user-activity-graph -->
                                    </div>
                                    <?php	}?>
                                     <?php if($PackageLogs){ ?>
									<div class="col-md-9 col-sm-9 col-xs-12">
                                        <div class="profile_title">
                                            <div class="col-md-6">
                                                <h2>Package Logs</h2>
                                            </div>    
                                        </div>
                                        <!-- start of user-activity-graph -->
                                        <div style="width:100%;">
                                            <table class="table table-striped">
                                                <tr>
                                                    <td><strong>Use Type</strong></td>
                                                    <td><strong>Package Type</strong></td>
                                                    <td><strong>Text Cridets</strong></td>
                                                    <td><strong>Document Credits</strong></td>
                                                    <td><strong>Video Credits</strong></td>
                                                     <td><strong>Audio Credits</strong></td>
                                                     <td><strong>Created Date</strong></td>
                                                </tr>
											<?php foreach($PackageLogs as $logs){ ?>
                                                <tr>
                                                    <td><?php echo $logs['use_type'] ?></td>
                                                    <td><?php echo $logs['package_type'] ?></td>
                                                    <td> <?php echo $logs['text'] ?></td>
                                                    <td> <?php echo $logs['document'] ?></td>
                                                    <td> <?php echo $logs['video'] ?></td>
                                                    <td> <?php echo $logs['audio'] ?></td>
                                                    <td><?php echo $logs['created_date'] ?></td>
                                                </tr>
                                              <?php	}?>
                                            </table>
                                        </div>
                                        <!-- end of user-activity-graph -->
                                        
                                    </div>
                                     <?php }?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
               <?php $this->load->view('admin/common/footer');?>
                <!-- /footer content -->
            </div>
            <!-- /page content -->
        </div>
    </div>
    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
    <?php $this->load->view('admin/common/common-scripts.php')?>
    <!-- /datepicker -->
</body>
</html>