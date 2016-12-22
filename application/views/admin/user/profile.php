<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Profile</h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold">Profile</div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<form class="bs-example form-horizontal" method="post">
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-lg-3 control-label">First Name</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="first_name" value="<?php echo $user->first_name?>" placeholder="First Name">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Last Name</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="last_name" value="<?php echo $user->last_name?>" placeholder="Last Name">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Phone</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="phone" value="<?php echo $user->phone?>" placeholder="Phone">
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-10">
										<button type="submit" class="btn btn-sm btn-info">Update</button>
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
