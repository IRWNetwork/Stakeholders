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
                <div class="x_content content">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $page_heading;?></h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php if(isset($msg) && $msg!=''){?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                    <?php }?>
                    <table id="userDetail" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date Created</th>
                                <th>Last Login</th>
                                <th class=" no-link last"><span class="nobr">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $user){?>
                            <tr class="odd pointer">
                                <td class=" "><?php echo $user->firstname." ".$user->lastname?></td>
                                <td class=" "><?php echo $user->email?></td>
                                <td class=" "><?php echo $user->created_date?></td>
                                <td class="a-right a-right"><?php echo $user->last_login!='0000-00-00 00:00:00' ? $user->last_login : "" ;?></td>
                                <td class=" last" width="450">
                                    <a href="<?php echo base_url()?>admin/users/editUser?id=<?php echo $user->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                    <a href="<?php echo base_url()?>admin/users/detail/<?php echo $user->id?>" class="btn btn-primary btn-xs"><i class="fa fa-user"></i> User Detail </a>
                                    <?php if($user->activated){ ?>
                                    	<a href="<?php echo base_url()?>admin/users/block/<?php echo $user->id?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure to delete this user ?')"><i class="fa fa-trash-o"></i> Block </a>
                                    <?php }
									else{ ?>
                                    	<a href="<?php echo base_url()?>admin/users/approved/<?php echo $user->id?>" class="btn btn-success btn-xs" onClick="return confirm('Are you sure to delete this user ?')">Approved </a>
                                	<?php }?>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                <div class="clear"></div>
                <!-- footer content -->
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