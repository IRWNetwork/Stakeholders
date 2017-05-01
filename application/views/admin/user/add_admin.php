<?php //echo "<pre>"; print_r($admin);exit; ?>
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
						<form class="bs-example form-horizontal" name="frm" method="post" enctype="multipart/form-data">
						<div class="col-md-12">
							<div class="list-group list-group-sm">
								
								<div class="form-group">
									<label class="col-lg-3 control-label">First Name</label>
									<div class="col-lg-6">
										<input placeholder="First Name" name="firstname" value="<?php if(isset($admin['first_name'])){ echo $admin['first_name']; }?>" class="form-control" required />
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label">Last Name</label>
									<div class="col-lg-6">
										<input placeholder="Last Name" name="lastname" value="<?php if(isset($admin['last_name'])){ echo $admin['last_name']; }?>" class="form-control" required />
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label">Last Name</label>
									<div class="col-lg-6">
										<input type="email" name="email" placeholder="Email" value="<?php if(isset($admin['email'])){ echo $admin['email']; }?>" class="form-control"  required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label">Picture</label>
									<div class="col-lg-6">
										<input type="file" name="picture" />
									</div>
								</div>
								<?php //if (!isset($admin)) : ?>
								<div class="form-group">
									<label class="col-lg-3 control-label">Password</label>
									<div class="col-lg-6">
										<input type="password" name="password" placeholder="Password" class="form-control"  required>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Confirm Password</label>
									<div class="col-lg-6">
										<input type="password" name="confirmPassword" placeholder="Confirm Password" class="form-control"  required>
									</div>
								</div>
								<?php //endif; ?>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-1">
										<button type="submit" class="btn btn-primary">Save</button>
										<div class="line line-dashed"></div>
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