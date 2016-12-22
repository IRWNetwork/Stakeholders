<aside id="aside" class="app-aside hidden-xs bg-dark" style="height:100%">
	<div class="aside-wrap">
		<div class="navi-wrap"> 
			<!-- user -->
			<div class="clearfix hidden-xs text-center hide" id="aside-user">
				<div class="dropdown wrapper"> 
				<?php if($this->session->userdata('profile_pic')!=''){?>
				<a href="app.page.profile"> 
				<span class="thumb-lg w-auto-folded avatar m-t-sm"><img src="<?php echo base_url().'/uploads/profile_pic/thumb_200_'.$this->session->userdata('profile_pic'); ?>" class="img-full" alt="..."> </span> 
				</a>
				<?php }?>
				<a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-folded"> <span class="clear"> <span class="block m-t-sm">
				<strong class="font-bold text-lt"><?php echo $this->session->userdata('uname');?></strong> <b class="caret"></b> </span>
				<span class="text-muted text-xs block">Ruler     Level 76</span> </span> </a> 
					<!-- dropdown -->
					<ul class="dropdown-menu animated fadeInRight w hidden-folded">
						<li> <a href="<?php echo base_url()?>user/profile">Profile</a> </li>
						<li> <a href="<?php echo base_url()?>user/changepassword">Change Password</a> </li>
						<li class="divider"></li>
						<li> <a href="<?php echo base_url()?>user/logout">Logout</a> </li>
					</ul>
					<!-- / dropdown --> 
				</div>
				<div class="line dk hidden-folded"></div>
			</div>
			<!-- / user --> 
			
			<!-- nav -->
			<div class="navi-wrap"> 
			<!-- nav -->
			<nav ui-nav="" class="navi clearfix"> 
				<!-- list -->
				<ul class="nav dk">
					<li class="hidden-folded padder m-t m-b-sm text-muted text-u-c text-xs"> <span>Discovery</span> </li>
					<li ui-sref-active="active" class="active"> <a href="<?php echo base_url()?>"> <i class="icon-disc icon"></i> <span>New</span> </a> </li>
					<li ui-sref-active="active"> <a href="<?php echo base_url()?>podcasts"> <i class="fa fa-podcast"></i> <span>Podcasts</span> </a> </li>
					<li ui-sref-active="active"> <a href="<?php echo base_url()?>podcasts"> <i class="fa fa-gamepad"></i> <span>Arcade</span> </a> </li>
					<li ui-sref-active="active"> <a href="#"> <i class="icon-list icon"></i> <span>Editorial</span> </a> </li>
					<li ui-sref-active="active"> <a href="#"> <i class="icon-social-youtube icon"></i> <span>Videos</span> </a> </li>
					<li ui-sref-active="active"> <a href="#"> <i class="fa fa-futbol-o"></i> <span>Fantasy League</span> </a> </li>
					<li ui-sref-active="active"> <a href="<?php echo base_url()?>home/map"> <i class="fa fa-calendar"></i> <span>World Calendar</span> </a> </li>
					<li ui-sref-active="active"> <a href="#"> <i class="fa fa-shopping-cart "></i> <span>Store</span> </a> </li>
					<li ui-sref-active="active"> <a href="<?php echo base_url()?>forum"> <i class="fa fa-comments-o"></i> <span>Ruler Forums</span> </a> </li>
					<li ui-sref-active="active"> <a href="#"> <i class="fa fa-comment-o"></i> <span>FAQ</span> </a> </li>
				</ul>
				<ul class="nav">
					<li class="hidden-folded padder m-t m-b-sm text-muted text-u-c text-xs"> <span>YOUR VAULT</span> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/bookmarkd"> <i class="icon-star icon"></i> <span>Bookmarked</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/loved"> <i class="icon-heart icon"></i> <span>Loved</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/history"> <i class="icon-clock icon"></i> <span>History</span> </a> </li>
					<li class="hidden-folded padder m-t m-b-sm text-muted text-u-c text-xs"> <span>Playlists</span> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/nature"> <b class="badge bg-info pull-right">3</b> <i class="icon-playlist icon"></i> <span>Wrestling Docs</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/nature"> <b class="badge bg-info pull-right">3</b> <i class="icon-playlist icon"></i> <span>Backyard</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/nature"> <b class="badge bg-info pull-right">3</b> <i class="icon-playlist icon"></i> <span>WCW</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/nature"> <b class="badge bg-info pull-right">3</b> <i class="icon-playlist icon"></i> <span>Politics</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/nature"> <b class="badge bg-info pull-right">3</b> <i class="icon-playlist icon"></i> <span>Music</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/soundtracks"> <b class="badge dk pull-right">5</b> <i class="icon-playlist icon"></i> <span>CoolCasts</span> </a> </li>
				</ul>
				<!-- / list --> 
			</nav>
			<!-- nav --> 
		</div>
			<!-- nav --> 
		</div>
	</div>
</aside>
