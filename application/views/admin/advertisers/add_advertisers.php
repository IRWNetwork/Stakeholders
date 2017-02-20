<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<form method="post" name="frm" action="" id="demo-form2" class="form-horizontal form-label-left" novalidate>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullname">Full Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="Full Name" name="fullname" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($advertiser['fullname']) ? $advertiser['fullname'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" name="email" placeholder="Email" value="<?php if(isset($advertiser['email'])){ echo $advertiser['email']; }?>" class="form-control"  required>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="weburl">Web URL</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="weburl" placeholder="Web URL" value="<?php if(isset($advertiser['weburl'])){ echo $advertiser['weburl']; }?>" class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="address" placeholder="Address" value="<?php if(isset($advertiser['address'])){ echo $advertiser['address']; }?>" class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Phone No</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="phoneno" placeholder="Phone No" value="<?php if(isset($advertiser['phoneno'])){ echo $advertiser['phoneno']; }?>" class="form-control">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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