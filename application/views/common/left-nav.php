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
				<span class="text-muted text-xs block">Ruler Level 76</span> </span> </a> 
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
				<ul class="nav dk load_data_ajax">
					<li class="hidden-folded padder m-t m-b-sm text-muted text-u-c text-xs"> <span>Discovery</span> </li>
					<li ui-sref-active="active" class="active"> <a href="javascript:void(0)" data-for=""> <i class="icon-disc icon"></i> <span>New</span> </a> </li>
                   	<li ui-sref-active="active"> <a href="javascript:void(0)" data-for="user/channelmarketplace" > <i class="icon-list icon"></i> <span style="font-size:13px">Channel Marketplace</span> </a> </li>
					<li ui-sref-active="active">
						<a href="javascript:void(0)" data-for="podcasts">
							<i class="fa fa-microphone" ></i>
							<span>Podcasts</span>
						</a>
						</li>
					<!--<li ui-sref-active="active"> <a href="javascript:void(0)" data-for="page/Arcade"> <i class="fa fa-gamepad"></i> <span>Arcade</span> </a> </li>-->
					<li ui-sref-active="active"> <a href="javascript:void(0)" data-for="editorial"> <i class="icon-list icon"></i> <span>Editorial</span> </a> </li>
					<li ui-sref-active="active"> <a href="javascript:void(0)" data-for="videos"> <i class="icon-social-youtube icon"></i> <span>Videos</span> </a> </li>
					<!--<li ui-sref-active="active"> <a href="javascript:void(0)" data-for="page/fantasy-league"> <i class="fa fa-futbol-o"></i> <span>Fantasy League</span> </a> </li>-->
					<!-- <li ui-sref-active="active"> <a href="javascript:void(0)" data-for="home/map"> <i class="fa fa-calendar"></i> <span>World Calendar</span> </a> </li> -->
					<!--<li ui-sref-active="active"> <a href="<?php echo base_url()?>store"> <i class="fa fa-shopping-cart "></i> <span>Store</span> </a> </li>
					<li ui-sref-active="active"> <a href="javascript:void(0)" data-for="forum"> <i class="fa fa-comments-o"></i> <span>Ruler Forums</span> </a> </li>-->
					<li ui-sref-active="active"> <a href="<?php echo base_url()?>forum/thread" data-for="forum"> <i class="fa fa-comments-o"></i> <span>Ruler Forums</span> </a> </li>
                    <li ui-sref-active="active"> <a href="javascript:void(0)" data-for="faq"> <i class="fa fa-question" aria-hidden="true"></i><span>FAQ</span> </a> </li>
                    <!--<li ui-sref-active="active"> <a href="javascript:void(0)" data-for="home/contact_irw"> <i class="fa fa-comment-o"></i> <span>Contact IRW</span> </a> </li>-->
                    <!-- <li ui-sref-active="active"> <a href="javascript:void(0)" data-for="home/refund_policy"><i class="fa fa-usd" aria-hidden="true"></i> <span>Refund Policy</span> </a> </li> -->
                   <!-- <li ui-sref-active="active"> <a href="javascript:void(0)" data-for="user/channelmarketplace"> <i class="icon-list icon"></i> <span>Channel Marketplace</span> </a> </li>-->
				</ul>
				<ul class="nav load_data_ajax">
					<li class="hidden-folded padder m-t m-b-sm text-muted text-u-c text-xs"> <span>YOUR VAULT</span> </li>
					<li ui-sref-active="active"> <a href="javascript:void(0)" data-for="user/favorite"> <i class="icon-star icon"></i> <span>Favorite</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/loved"> <i class="icon-heart icon"></i> <span>Loved</span> </a> </li>
					<li ui-sref-active="active"> <a href="#/music/playlist/history"> <i class="icon-clock icon"></i> <span>History</span> </a> </li>
					<?php if($this->ion_auth->logged_in()){?>
					<li class="hidden-folded padder m-t m-b-sm text-muted text-u-c text-xs"> <span>Playlists</span> </li>
                    <?php 
					if(isset($playlists)){
					 foreach($playlists as $playlist_row){?>
					<li ui-sref-active="active"> <a href="<?php echo base_url()?>playlist/<?php echo $playlist_row->id?>"> <b class="badge bg-info pull-right"><?php echo $this->Content_model->countSongsInPlaylist($user_id,$playlist_row->id)?></b> <i class="icon-playlist icon"></i> <span><?php echo $playlist_row->title?></span> </a> </li>
					<?php }}}?>
				</ul>
				<!-- / list --> 
			</nav>
			<!-- nav --> 
		</div>
			<!-- nav --> 
		</div>
	</div>
	
</aside>

<script type="text/javascript">
$("document").ready(function() {
$("ul.load_data_ajax li").click(function() {
	var my_url = $(this).children('a').attr("data-for");
	
	//var base_url = window.location.origin;
	//my_url = base_url+"/"+my_url;
	
	my_url = BASE_URL+""+my_url;
	
	//alert(my_url);
	$.ajax({
        url: my_url,
        type: "POST",
        data : {flag:1},
        success: function (response) {
    		$("#content").empty();
    		$(".loader").show().delay(1000).fadeOut('slow');
    		$("#content").append(response);
    		history.pushState(null, null, my_url);
        }
    });
});
});

</script>