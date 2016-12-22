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
                        <div class="x_content">
                    <form id="package_form" name="frm" method="post" class="form-horizontal form-label-left">
						<input type="hidden" name="id" value="<?php echo $packages->id?>" />
						<div class="item form-group">
                        	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">Package Type</label>
                        	<div class="col-md-6 col-sm-6 col-xs-12">
                          		<select class="form-control" name="type">
									<option value="prepaid">PerPaid</option>
									<option value="monthly">Monthly</option>
									<option value="quarterly">Quarterly</option>
									<option value="yearly">Yearly</option>
								</select>
								<?php if($packages->type){?>
								<script type="text/javascript">
									document.frm.type.value='<?php echo $packages->type?>';
								</script>
								<?php }?>
                        	</div>
                      	</div>
						<div class="item form-group">
                        	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="text_price">Message Type</label>
                        	<div class="col-md-6 col-sm-6 col-xs-12">
                          		<select class="form-control" name="message_type">
									<option value="text">Text Messages</option>
									<option value="documents">Documents</option>
									<option value="audio">Audio</option>
									<option value="video">Video</option>
								</select>
								<?php if($packages->message_type){?>
								<script type="text/javascript">
									document.frm.message_type.value='<?php echo $packages->message_type?>';
								</script>
								<?php }?>
                        	</div>
                      	</div>
						<div class="item form-group">
                        	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="document_price">Caption</label>
                        	<div class="col-md-6 col-sm-6 col-xs-12">
                          		<input id="caption" value="<?php if($packages->caption){ echo $packages->caption;}?>"  name="caption" class="form-control col-md-7 col-xs-12"  type="text">
                        	</div>
                      	</div>
						<div class="item form-group">
                        	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="text_price">Credits</label>
                        	<div class="col-md-6 col-sm-6 col-xs-12">
                          		<input id="credits" value="<?php if($packages->number_of_credit){ echo $packages->number_of_credit;}?>" name="credits" class="form-control col-md-7 col-xs-12"  type="text">
                        	</div>
                      	</div>
						<div class="item form-group">
                        	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="video_price">Amount</label>
                        	<div class="col-md-6 col-sm-6 col-xs-12">
                          		<input id="video_price" value="<?php if($packages->amount){ echo $packages->amount;}?>" name="amount" class="form-control col-md-7 col-xs-12"  type="text">
                        	</div>
                      	</div>
						<div class="item form-group">
                        	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="text_price">Visible</label>
                        	<div class="col-md-6 col-sm-6 col-xs-12">
                          		<select class="form-control" name="visible">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
								<?php if($packages->visible){?>
								<script type="text/javascript">
									document.frm.visible.value='<?php echo $packages->visible?>';
								</script>
								<?php }?>
                        	</div>
                      	</div>
                      	<div class="ln_solid"></div>
                      	<div class="form-group">
                        	<div class="col-md-6 col-md-offset-3">
								<button id="send" type="submit" class="btn btn-primary">Save</button>
                        	</div>
                      	</div>
                    </form>
                  </div>
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
<script type="text/javascript">
	/*$(document).ready(function() {
		$("input#reset").click(function(){
			document.getElementById("package_form").reset();
		});
		$("#send").click(function(event) {
			event.preventDefault();
			var type = $("input#type").val();
			var email = $("select#text)price").val();
			var message = $("textarea#message").val();
			var page = $("input#page").val();
			var user_type = $("input.user_type").val();
			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "admin/Packages/updatePackageInfo",
				dataType: 'json',
				data: {
					subject   : subject,
					message   : message,
					email	  : email,
					page	  : page,
					user_type : user_type
				},
				success: function(res) {
					if (res.status) {
						document.getElementById("textForm").reset();
						jQuery("div#success").html(res.successMessage);
						jQuery("div#error").hide();
						jQuery('div#success')
    					.show({duration: 200, queue: true})
    					.delay(4000)
    					.fadeOut({duration: 200, queue: true});
					}
					else{
						jQuery("div#error").html(res.errorMessage);
						jQuery("div#error").show();
						jQuery("div#success").hide();
					}
				}
			});
		});
	});*/
</script> 