<link rel="stylesheet" media="all" type="text/css" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
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
						<?php $this->load->view('admin/common/messages');?>
						<form class="bs-example form-horizontal" name="frm" method="post" enctype="multipart/form-data">
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-sm-3 control-label">Upload a CSV File</label>
									<div class="col-sm-9">
										<input type="file" name="csv" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-3 pull-left">
										<button type="submit" class="btn btn-sm btn-info">Upload</button>
										<a href="<?php echo base_url(); ?>uploads/Sample.csv" class="btn btn-sm btn-info" download>
										  Sample CSV File
										</a>
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