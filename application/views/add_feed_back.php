<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url()?>assets/css/jquery-ui-timepicker-addon.css" />
<div class="app-content-body">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
						<?php $this->load->view('common/messages');?>
						<form class="bs-example form-horizontal" name="frm" method="post" >
							<div class="col-md-12">
                                   <div class="form-group">
                                        <label class="col-lg-3 control-label">Subject</label>
                                        <div class="col-lg-6">
                                            <input required type="text" class="form-control" name="subject" id="subject" value="<?php if(isset($feedBackRow['subject'])){ echo $feedBackRow['subject']; }?>" placeholder="Subject">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Message</label>
                                        <div class="col-lg-6">
                                            <textarea required id="message" class="form-control" name="message"><?php if(isset($feedBackRow['message'])){ echo $feedBackRow['message']; }?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
									<div class="col-lg-offset-3 col-lg-1">
										<button type="submit" class="btn btn-sm btn-info" id="show_load">Send</button>
									</div>
									<div class="col-lg-2">
										<div class="loader_div">
											<img src="<?php echo base_url(); ?>uploads/files/g_upload.gif" width="100">
											<span>Please Wait...</span>
										</div>
									</div>
								</div>
								
								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url()?>assets/tinymce/tinymce.min.js"></script>

<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>

