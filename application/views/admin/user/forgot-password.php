<?php $this->load->view('admin/common/common-header');?>
<body>
<div class="app app-header-fixed ">
	<div class="container w-xl w-auto-xs" ng-init="app.settings.container = false;"> <a href class="navbar-brand block m-t">Angulr</a>
		<div class="m-b-lg">
			<div class="wrapper text-center"> <strong>Input your email to reset your password</strong> </div>
			<?php $this->load->view('admin/common/messages');?>
			<form name="reset" method="post">
				<div class="list-group list-group-sm">
					<div class="list-group-item">
						<input type="email" name="email" placeholder="Email" class="form-control no-border" required>
					</div>
				</div>
				<button type="submit" class="btn btn-lg btn-primary btn-block">Send</button>
			</form>
			<div class="text-center m-t m-b"><a href="<?php echo base_url()?>admin/users">Have Account?</a></div>
			<div class="line line-dashed"></div>
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
