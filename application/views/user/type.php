<?php $this->load->view('common/common-header');?>
<body>
<div class="app app-header-fixed ">
	<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;"> <a href="<?php echo base_url()?>" class="navbar-brand block m-t">IRW Network</a>
		<div class="m-b-lg">
			<div class="wrapper text-center"> <strong>User Type</strong> </div>
			<div class="row">
            <?php $this->load->view('common/messages');?>
            	<div class="col-sm-6">
                	<a href="<?php echo base_url()."user/register/1" ?>"><button class="btn-info btn-lg"> SignUp as Ruler </button></a>
               	</div>
                
            	<div class="col-sm-6">
                	<a href="<?php echo base_url()."user/register/2" ?>"><button class="btn-info btn-lg"> SignUp as Producer/Channel  </button></a>
               	</div>
            </div>
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