<?php $this->load->view('common/common-header');?>
<body>
<div class="app app-header-fixed ">
	<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;"> <a href="<?php echo base_url()?>" class="navbar-brand block m-t">IRW Network</a>
		<div class="m-b-lg">
			<div class="wrapper text-center"> <strong>User Register</strong> </div>
			<?php $this->load->view('common/messages');?>
			<form name="form" class="form-validation" method="post">
            	<input type="hidden" name="flag" value="<?php echo $flag; ?>">
				<div class="text-danger wrapper text-center" ng-show="authError"> </div>
				<div class="list-group list-group-sm">
					<div class="list-group-item">
						<input placeholder="First Name" name="firstname" value="<?php echo $this->input->post('firstname')?>" class="form-control no-border" required />
					</div>
					<div class="list-group-item">
						<input placeholder="Last Name" name="lastname" value="<?php echo $this->input->post('lastname')?>" class="form-control no-border" required />
					</div>
					<div class="list-group-item">
						<input type="email" name="email" placeholder="Email" value="<?php echo $this->input->post('email')?>" class="form-control no-border"  required>
					</div>
					<div class="list-group-item">
						<input type="password" name="password" placeholder="Password" class="form-control no-border"  required>
					</div>
                    <div class="list-group-item">
						<input type="password" name="confirmPassword" placeholder="Confirm Password" class="form-control no-border"  required>
					</div>
                    <?php if($flag==2){ ?>
                    <div class="list-group-item">
						<input type="text" name="brand" value="<?php echo $this->input->post('brand')?>" placeholder="Brand Name" class="form-control no-border"  required>
					</div>
                    <div class="list-group-item">
						<input type="type" name="channel" value="<?php echo $this->input->post('channel')?>" placeholder="Channel Name" class="form-control no-border"  required>
					</div>
                    <div class="list-group-item">
						<input type="type" name="salespitch" value="<?php echo $this->input->post('salespitch')?>" placeholder="Sales Pitch" class="form-control no-border"  required>
					</div>
                    <div class="list-group-item">
						<input type="text" name="channel_price" value="<?php echo $this->input->post('channel_price')?>" placeholder="Channel Price in $" class="form-control no-border" >
					</div>
                    <div class="list-group-item">
						<textarea name="description"  placeholder="Description" class="form-control no-border"  required><?php  if(!empty($this->input->post('description'))){ echo $this->input->post('description');}else{echo "Description";}?> </textarea>
					</div>
                    <?php } ?>
				</div>
				<div class="checkbox m-b-md m-t-none">
					<label class="i-checks">
						<input type="checkbox" name="terms" value="1" required>
						<i></i> Agree the <a href="<?php echo base_url()?>page/terms">terms and policy</a>
					</label>
				</div>
				<button type="submit" class="btn btn-lg btn-primary btn-block">Sign up</button>
				<div class="line line-dashed"></div>
				<p class="text-center"><small>Already have an account?</small></p>
				<a href="<?php echo base_url()?>user/login" class="btn btn-lg btn-default btn-block">Sign in</a>
			</form>
		</div>
		<div class="text-center" ng-include="'tpl/blocks/page_footer.html'">
			<p> <small class="text-muted">IRW Network Insides Rule!<br>
				&copy; 2016</small> </p>
		</div>
	</div>
</div>
<?php $this->load->view('admin/common/footer-js');?>
</body>
</html>