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
                                        <select name="packageType" class="form-control">
											<option value="prepaid">Prepaid</option>
											<option value="monthly">Monthly</option>
											<option value="quarterly">Quarterly</option>
											<option value="yearly">Yearly</option>											
										</select>
										<?php if($this->input->get('packageType')){?>
										<script type="text/javascript">
											document.frm.packageType.value='<?php echo $this->input->get('packageType'); ?>'
										</script>
										<?php }?>
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
                                <th>Type</th>
                                <th>Message Type</th>
                                <th>Caption</th>
                                <th># of Credits</th>
                                <th>Amount</th>
                                <th class=" no-link last"><span class="nobr">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($packages as $packages){?>
                            <tr class="odd pointer">
                                <td class=" "><?php echo $packages->type; ?></td>
                                <td class=" "><?php echo $packages->message_type; ?></td>
								<td class=" "><?php echo $packages->caption; ?></td>
								<td class=" "><?php echo $packages->number_of_credit; ?></td>
								<td class=" "><?php echo $packages->amount; ?></td>
                                <td class=" last" width="140">
                                    <a href="<?php echo base_url()?>admin/Packages/editPackages?id=<?php echo $packages->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                    
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