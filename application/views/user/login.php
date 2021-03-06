<?php $this->load->view('admin/common/common-header');?>
<body>
<div class="app app-header-fixed ">
	<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;"> <a href="<?php echo base_url()?>" class="navbar-brand block m-t">IRW Network</a>
		<div class="m-b-lg">
			<div class="wrapper text-center"> <strong>User Login</strong> </div>
			<?php $this->load->view('admin/common/messages');?>
			<form name="form" class="form-validation" method="post">
				<div class="text-danger wrapper text-center" ng-show="authError"> </div>
				<div class="list-group list-group-sm">
					<div class="list-group-item">
						<input type="email" name="email" placeholder="Email" class="form-control no-border" required>
					</div>
					<div class="list-group-item">
						<input type="password" name="password" placeholder="Password" class="form-control no-border" required>
					</div>
				</div>
				<button type="submit" class="btn btn-lg btn-primary btn-block">Log in</button>
				<div class="text-center m-t m-b"><a href="<?php echo base_url()?>user/forgotpassword">Forgot password?</a></div>
				<div class="line line-dashed"></div>
				<p class="text-center"><small>Do not have an account?</small></p>
				<a href="<?php echo base_url()?>user/register/1" class="btn btn-lg btn-default btn-block">Create an account</a>
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