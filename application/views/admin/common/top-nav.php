<header id="header" class="app-header navbar" role="menu">
	<!-- navbar header -->
	<div class="navbar-header bg-dark">
		<button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse"> <i class="glyphicon glyphicon-cog"></i> </button>
		<button class="pull-right visible-xs" ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app"> <i class="glyphicon glyphicon-align-justify"></i> </button>
		<!-- brand -->
		<a href="#/" class="navbar-brand text-lt"> <span class="hidden-folded m-l-xs">IRW</span> Network</a>
		<!-- / brand -->
	</div>
	<!-- / navbar header -->
	
	<!-- navbar collapse -->
	<div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
		<!-- buttons -->
		<div class="nav navbar-nav hidden-xs"> <a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="app-aside-folded" target=".app"> <i class="fa fa-dedent fa-fw text"></i> <i class="fa fa-indent fa-fw text-active"></i> </a></div>
		<!-- / buttons -->
		<!-- nabar right -->
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown"> <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm"> <img src="<?php echo base_url(); ?>assets/images/a0.jpg" alt="..."> <i class="on md b-white bottom"></i> </span> <span class="hidden-sm hidden-md">M.G. Dockery</span> <b class="caret"></b> </a>
				<!-- dropdown -->
				<ul class="dropdown-menu animated fadeInRight w">
					<li> <a href="<?php echo base_url()?>admin/users/profile">Profile</a> </li>
					<li> <a href="<?php echo base_url()?>admin/users/changepassword">Change Password </a> </li>
					<li class="divider"></li>
					<li> <a href="<?php echo base_url()?>admin/users/logout">Logout</a> </li>
				</ul>
				<!-- / dropdown -->
			</li>
		</ul>
		<!-- / navbar right -->
	</div>
	<!-- / navbar collapse -->
</header>