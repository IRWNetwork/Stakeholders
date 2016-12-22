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
						<form method="post" enctype="multipart/form-data" class="bs-example form-horizontal">
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
									<label class="col-lg-3 control-label">Profile Picture</label>
									<div class="col-lg-6">
										
										<label>
										  <input type="file" name="picture" id="picture" />
									  </label>
                                    </div>
								</div>
								<?php if($user->picture!=''){?>
								<div class="form-group">
									<input type="hidden" name="old_pic" value="<?php echo $user->picture; ?>">
									<div class="col-lg-6 col-md-offset-3">
										<div><img src="<?php echo  base_url().'/uploads/profile_pic/thumb_200_'.$user->picture; ?>" ></div>
									</div>
								</div>
								<?php }?>
                                
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
