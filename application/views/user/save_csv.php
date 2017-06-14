<?php $this->load->view('admin/common/common-header');?>
<body>
<div class="app app-header-fixed ">
	<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;"> <a href="<?php echo base_url()?>" class="navbar-brand block m-t">IRW Network</a>
		<div class="m-b-lg">
			<div class="wrapper text-center"> <strong>Save CSV</strong> </div>
			<?php $this->load->view('admin/common/messages');?>
			<form name="form" class="form-validation" method="post" enctype="multipart/form-data">
				<div class="text-danger wrapper text-center" ng-show="authError"> </div>
				<div class="list-group list-group-sm">
					<div class="list-group-item">
						<input type="file" name="file" placeholder="Upload CSV" class="form-control no-border" required>
					</div>
				</div>
				<button type="submit" name="import_csv" class="btn btn-lg btn-primary btn-block">Save</button>
			</form>
		</div>
		<div class="text-center" ng-include="'tpl/blocks/page_footer.html'">
			<p> <small class="text-muted">IRW Network Insides Rule!<br>
				&copy; 2016</small> </p>
		</div>
	</div>
</div>
</body>
<?php $this->load->view('admin/common/footer-js');?>
</html>