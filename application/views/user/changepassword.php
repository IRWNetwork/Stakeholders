<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Change Password</h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold">Change Password</div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<form class="bs-example form-horizontal" method="post">
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-lg-3 control-label">Old Password</label>
									<div class="col-lg-6">
										<input type="password" class="form-control" name="old_password" placeholder="Old Password">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Password</label>
									<div class="col-lg-6">
										<input type="password" class="form-control" name="password" placeholder="Password">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Confirm Password</label>
									<div class="col-lg-6">
										<input type="password" class="form-control" name="repassword" placeholder="Confirm Password">
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
