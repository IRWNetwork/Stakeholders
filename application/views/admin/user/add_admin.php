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
							<div class="text-danger wrapper text-center" ng-show="authError"> </div>
							<div class="list-group list-group-sm">
								<div class="list-group-item">
									<input placeholder="First Name" name="firstname" value="<?php if(isset($admin['first_name'])){ echo $admin['first_name']; }?>" class="form-control no-border" required />
								</div>
								<div class="list-group-item">
									<input placeholder="Last Name" name="lastname" value="<?php if(isset($admin['last_name'])){ echo $admin['last_name']; }?>" class="form-control no-border" required />
								</div>
								<div class="list-group-item">
									<input type="email" name="email" placeholder="Email" value="<?php if(isset($admin['email'])){ echo $admin['email']; }?>" class="form-control no-border"  required>
								</div>
								<div class="list-group-item">Picture
									<input type="file" name="picture" />
								</div>
								<?php if (!isset($admin)) : ?>
									<div class="list-group-item">
										<input type="password" name="password" placeholder="Password" class="form-control no-border"  required>
									</div>
				                    <div class="list-group-item">
										<input type="password" name="confirmPassword" placeholder="Confirm Password" class="form-control no-border"  required>
									</div>
								<?php endif; ?>									
							</div>
							<button type="submit" class="btn btn-primary">Save</button>
							<div class="line line-dashed"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>