<?php $this->load->view('admin/common/common-header');?>
<body>
<div class="app app-header-fixed ">
	<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;"> <a href class="navbar-brand block m-t">IRW</a>
		<div class="m-b-lg">
			<div class="wrapper text-center"> <strong>Rest Admin Password</strong> </div>
			<?php $this->load->view('admin/common/messages');?>
			<form name="form" class="form-validation" method="post">
				<input type="hidden" name="user_id" value="<?php echo $user_id?>" />
				<div class="text-danger wrapper text-center" ng-show="authError"> </div>
				<div class="list-group list-group-sm">
					<div class="list-group-item">
						<input type="password" name="password" placeholder="Password"  class="form-control no-border"  required>
					</div>
					<div class="list-group-item">
						<input class="form-control no-border" id="repassword" name="repassword" type="password" required="required" placeholder="Confirm Password" maxlength="20">
					</div>
				</div>
				<button type="submit" class="btn btn-lg btn-primary btn-block">Log in</button>
				<div class="text-center m-t m-b"><a href="<?php echo base_url()?>admin/users/forgotpassword">Forgot password?</a></div>
				<div class="line line-dashed"></div>
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
