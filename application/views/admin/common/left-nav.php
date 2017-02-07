<aside id="aside" class="app-aside hidden-xs bg-dark">
	<div class="aside-wrap">
		<div class="navi-wrap"> 
			<!-- user -->
			<div class="clearfix hidden-xs text-center hide" id="aside-user">
				<div class="dropdown wrapper"> <a href="app.page.profile"> <span class="thumb-lg w-auto-folded avatar m-t-sm"> <img src="<?php echo base_url(); ?>assets/images/a0.jpg" class="img-full" alt="..."> </span> </a> <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-folded"> <span class="clear"> <span class="block m-t-sm"> <strong class="font-bold text-lt">M.G. Dockery</strong> <b class="caret"></b> </span> <span class="text-muted text-xs block">Ruler     Level 76</span> </span> </a> 
					<!-- dropdown -->
					<ul class="dropdown-menu animated fadeInRight w hidden-folded">
						<li> <a href="<?php echo base_url()?>admin/users/profile">Profile</a> </li>
						<li> <a href="<?php echo base_url()?>admin/users/changepassword">Change Password</a> </li>
						<li class="divider"></li>
						<li> <a href="<?php echo base_url()?>admin/users/logout">Logout</a> </li>
					</ul>
					<!-- / dropdown --> 
				</div>
				<div class="line dk hidden-folded"></div>
			</div>
			<!-- / user --> 
			
			<!-- nav -->
			<nav ui-nav class="navi clearfix">
				<ul class="nav">
					<li class="hidden-folded padder m-t m-b-sm text-muted text-xs"> <span>Navigation</span> </li>
					<li> <a href="<?php echo base_url() ?>admin/dashboard"> <i class="glyphicon glyphicon-stats icon text-primary-dker"></i><span class="font-bold">Dashboard</span> </a> </li>
					<li> <a href class="auto"> <span class="pull-right text-muted"> <i class="fa fa-fw fa-angle-right text"></i> <i class="fa fa-fw fa-angle-down text-active"></i> </span>  <i class="glyphicon glyphicon-th"></i> <span>Contents</span> </a>
						<ul class="nav nav-sub dk">
							<li> <a href="<?php echo base_url()?>admin/content"> <span>Contents</span> </a> </li>
							<li> <a href="<?php echo base_url()?>admin/content/addcontent"> <span>Add Content</span> </a> </li>
						</ul>
					</li>
                    <li> <a href class="auto"> <span class="pull-right text-muted"> <i class="fa fa-fw fa-angle-right text"></i> <i class="fa fa-fw fa-angle-down text-active"></i> </span> <i class="fa fa-video-camera"></i><span>Channels</span> </a>
						<ul class="nav nav-sub dk">
							<li> <a href="<?php echo base_url()?>admin/channel"> <span>Channels</span> </a> </li>
							<li> <a href="<?php echo base_url()?>admin/channel/addchannel"> <span>Add Channel</span> </a> </li>
						</ul>
					</li>

					<li>
						<a href class="auto">
							<span class="pull-right text-muted">
								<i class="fa fa-fw fa-angle-right text"></i>
								<i class="fa fa-fw fa-angle-down text-active"></i>
							</span>
							<i class="fa fa-user-md"></i>
							<span>Admins</span>
						</a>
						<ul class="nav nav-sub dk">
							<li> <a href="<?php echo base_url()?>admin/users/admins"> <span>Admins</span> </a> </li>
							<li> <a href="<?php echo base_url()?>admin/users/add_admin"> <span>Add Admin</span> </a> </li>
						</ul>
					</li>

					<li> <a href class="auto"> <span class="pull-right text-muted"> <i class="fa fa-fw fa-angle-right text"></i> <i class="fa fa-fw fa-angle-down text-active"></i> </span> <i class="fa fa-map-marker" aria-hidden="true"></i> <span>Map</span> </a>
						<ul class="nav nav-sub dk">
							<li> <a href="<?php echo base_url()?>admin/events"> <span>Events</span> </a> </li>
							<li> <a href="<?php echo base_url()?>admin/events/add"> <span>Add Event</span> </a> </li>
							<li> <a href="<?php echo base_url()?>admin/categories"> <span>Categories</span> </a> </li>
							<li> <a href="<?php echo base_url()?>admin/categories/add"> <span>Add Category</span> </a> </li>
						</ul>
					</li>
					<li> <a href class="auto"> <span class="pull-right text-muted"> <i class="fa fa-fw fa-angle-right text"></i> <i class="fa fa-fw fa-angle-down text-active"></i> </span>  <i class="fa fa-newspaper-o" aria-hidden="true"></i>
<span>Pages</span> </a>
						<ul class="nav nav-sub dk">
							<li> <a href="<?php echo base_url()?>admin/pages"> <span>Pages</span> </a> </li>
							<li> <a href="<?php echo base_url()?>admin/pages/add"> <span>Add Page</span> </a> </li>
						</ul>
					</li>
					<li> <a href class="auto"> <span class="pull-right text-muted"> <i class="fa fa-fw fa-angle-right text"></i> <i class="fa fa-fw fa-angle-down text-active"></i> </span>  <i class="fa fa-question" aria-hidden="true"></i> <span>FAQ</span> </a>
						<ul class="nav nav-sub dk">
							<li> <a href="<?php echo base_url()?>admin/faq"> <span>FAQ</span> </a> </li>
							<li> <a href="<?php echo base_url()?>admin/faq/add"> <span>Add FAQ</span> </a> </li>
						</ul>
					</li>

					<li> <a href class="auto"> <span class="pull-right text-muted"> <i class="fa fa-fw fa-angle-right text"></i> <i class="fa fa-fw fa-angle-down text-active"></i> </span>  <i class="fa fa-flask" aria-hidden="true"></i> <span>Analytics</span> </a>
						<ul class="nav nav-sub dk">
							<!--<li> <a href=""><span>Analytics</span> </a></li>-->
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</aside>
