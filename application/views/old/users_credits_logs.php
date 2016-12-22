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
                        <div class="title_right">
                            <form name="frm">
                                <div class="col-md-10 col-sm-5 col-xs-12 pull-right top_search">
                                    <div class="col-md-5 col-sm-5 col-xs-12 pull-right top_search">
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="name" placeholder="Search User..." value="<?php echo ($this->input->get('name')) ?$this->input->get('name') : ''; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">Go!</button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php if(isset($msg) && $msg!=''){?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                    <?php }?>
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                        <thead>
                            <tr class="headings">
                                <th>Name</th>
                                <th>Use Type</th>
                                <th>Package Type</th>
                                <th>Text</th>
                                <th>Document</th>
                                <th>Video</th>
                                <th>Audio</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($creditsLogs as $logs){?>
                            <tr class="odd pointer">
                                <td><?php echo $logs['user_id'];?></td>
                                <td><?php echo $logs['use_type'];?></td>
                                <td><?php echo $logs['package_type'];?></td>
                                <td><?php echo $logs['text'];?></td>
                                <td><?php echo $logs['document'];?></td>
                                <td><?php echo $logs['video'];?></td>
                                <td><?php echo $logs['audio'];?></td>
                                <td><?php echo $logs['created_date'];?></td>
                             
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                    <p><?php echo $links; ?></p>
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