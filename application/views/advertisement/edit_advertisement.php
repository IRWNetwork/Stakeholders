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
								<div class="form-group" id="add_name">
									<label class="col-sm-3 control-label">Add Name</label>
									<div class="col-sm-6">
										<input type="text" name="add_name" class="form-control" value="<?php if(isset($advertisementRow['add_name'])){ echo $advertisementRow['add_name']; }?>" />
									</div>
								</div>
								<div class="form-group" id="add_name">
									<label class="col-sm-3 control-label">Add Link</label>
									<div class="col-sm-6">
										<input type="text" name="add_link" class="form-control" value="<?php if(isset($advertisementRow['add_link'])){ echo $advertisementRow['add_link']; }?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Advertisement Thumbnail</label>
									<div class="col-sm-9">
										<input type="file" name="picture" />
									</div>
								</div>
								<div class="form-group" id="file">
									<label class="col-sm-3 control-label">Video File (Limit 5GB)</label>
									<div class="col-sm-9">
										<input type="file" name="file" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-1">
										<button type="submit" class="btn btn-sm btn-info" id="show_load">Save</button>
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