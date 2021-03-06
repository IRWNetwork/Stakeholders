<style>
@media (max-width:768px){
.for-height {max-height: 187px !important;}
.for-margin-left {margin-left: 0px !important;}
.field{ width: 49% !important;
    float: none;
    display: inline-block;
    vertical-align: top;}
}


</style>

<?php 
if (isset($_COOKIE['customer_logout'])) {
	//echo 'hi';exit;
	session_unset();
	setcookie('customer_logout', '', 1, '/', null);
	redirect('/');

}
?>
<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>
<script type="text/javascript">
function loadRssFeed(id){
	$.post("<?php echo base_url()?>home/rss_feeds?id="+id,function(data){
		$("#feeds_content").html(data);
	});
}
$(document).ready(function(){
	$('.bxslider').bxSlider({
		pager: false,
		auto: true,
		pause: 9000
	});

	$(".smallText").click(function () {
		$(".dropdown-menu").css("display", "none");
	});

	$(".dropdown-toggle").click(function () {
		$(".dropdown-menu").css("display", "block");
	});
});
</script>
<div class="hbox hbox-auto-xs hbox-auto-sm"> 
	<!-- main -->
	<div class="col wrapper-lg">
    <?php $this->load->view('common/messages');?>
		<h3 class="font-thin m-t-n-xs m-b">Featured</h3>
        <?php if(count($bannerDetail)>0){?>
        <div class="row for-height">
         	<div class="col-xs-12">
                <ul class="bxslider">
                	<?php foreach($bannerDetail as $banner_row){ ?>
                    <li>
                        <a href="<?php echo $banner_row["banner_link"]?>" target="<?php echo $banner_row['target'];?>">
                            <img src="<?php echo base_url()."uploads/banner_images/".$banner_row["banner_image"]?>" class="img-responsive" />
                        </a>
                    </li>
                    <?php }?>
                </ul>
            </div>
         </div>
		<?php } ?>

		<!--start -->
		<div class="row row-sm">

			<?php
				$count=0;
				foreach($featured as $row){

					$url = $this->Common_model->getUrl($row);
			?>
			<div class="col-xs-6 col-sm-4 col-md-4 field" data-fullText="<?php echo $row->title?>">
				<div class="item">
					<div class="pos-rlt">
						<?php if($row->is_premium=='yes'){?>
						<div class="top"> <span class="badge bg-info m-l-sm m-t-sm">Premium</span> </div>
						<?php }?>
						<div class="item-overlay bg-black-opacity r r-2x r r-2x" data-url='<?php echo $url; ?>'>
							<div class="center text-center m-t-n w-full dropdown">
								<?php
									$featured_class = $this->Content_model->checkIsFeatured($row->id);
									if($row->type=='Video'){
								?>
								<a href="javascript:void(0)" class="ellips featured featured<?php echo $row->id?>" data-id="<?php echo $row->id?>"><i class="<?php echo $featured_class;?>"></i></a>
								<a href="<?php echo $url;?>"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<a href="#" class="ellips dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-h text-white"></i><b class="caret"></b></a>
								<?php }else if($row->type=='Text'){?>
								<a href="javascript:void(0)" class="ellips featured featured<?php echo $row->id?>" data-id="<?php echo $row->id?>"><i class="<?php echo $featured_class;?>"></i></a>
								<a href="<?php echo $url;?>"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<a href="#" class="ellips dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-h text-white"></i><b class="caret"></b></a>
								<?php }else{?>
								<a href="javascript:void(0)" class="ellips featured featured<?php echo $row->id?>" data-id="<?php echo $row->id?>"><i class="<?php echo $featured_class;?>"></i></a>
								<a href="<?php echo $url;?>" data-image='<?php echo $row->picture?>' data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>' class="playSong"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<a href="#" class="ellips dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-h text-white"></i><b class="caret"></b></a>
								<?php }?>
								<ul class="dropdown-menu">
									<div class="ui-widget ui-widget-content ui-corner-all ui-front ui-dialog ui-dialog--context-menu undefined contextmenu__arrow-top-left" tabindex="-1" role="dialog" aria-describedby="ui-id-3" aria-labelledby="ui-id-4" style="height: auto; width: 215px; top: 105px; left: 628px;">
										<div class="contextmenu-dialog ui-dialog-content ui-widget-content" id="ui-id-3" style="width: auto; min-height: 0px; max-height: none; height: auto;">
											<div id="contextmenu">
												<div>
													<div class="add_play_list_menu_box">
														<div class="add-to-playlist__heading">Select Playlist</div>
														<div class="add-to-playlist__lists">
															<ul class="grid__item__menu item-actions add_play_list_menu">
																<?php foreach($playlists as $playlist){?>
																<li class="add-to-playlist__item smallText playlist_li" data-playlist-id="<?php echo $playlist->id?>" data-song-id="<?php echo $row->id?>"> <a class="js-add-to-playlist-item" href="javascript:void(0)"> <i class="fa fa-music"></i> <span><?php echo $playlist->title;?></span> </a> </li>
																<?php }?>
															</ul>
														</div>
														<div class="create_list_btn"> <a href="#" data-toggle="modal" data-target="#createPlayList">Create New</a> </div>
													</div>
													<ul class="main-grid-menu grid__item__menu item-actions">
														<li class="item-actions__item item-actions__album" data-bind-class="type" data-item="header">
															<div class="item-actions__count" data-bind="bundleCount"></div>
															<img class="item-actions__cover" src="<?php echo base_url()?>uploads/listing/thumb_153_<?php echo $row->picture?>" data-bind-src="imgUrl" data-bind-width="width" data-bind-height="height" width="32" height="32"> <span class="item-actions__title" data-bind="title" data-test-id="contextmenu-title"><?php echo substr($row->title,0,20);?></span>
														</li>
														<?php if($row->type!='Video' && $row->type!='Text'){?>
														<li class="item-actions__item" data-item="play"> <a href="<?php echo $url;?>" class="js-item-action js-play-now playSong" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'> <i class="item-actions__icon icon-play-circle fa fa-play-circle-o"></i> <span class="smallText" data-i18n="t-play-now">Play Now</span> </a> </li>
														<li class="item-actions__item" data-item="play"> <a href="<?php echo $url;?>" class="js-item-action js-play-next playNext" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'> <span class="smallText" data-i18n="t-play-next">Play Next</span> </a> </li>
														<li class="item-actions__item" data-item="play"> <a href="<?php echo $url;?>" class="js-item-action js-play-last add_in_queue"  data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'> <i class="item-actions__icon icon-queue-add fa fa-file-text-o"></i> <span class="smallText" data-i18n="t-add-to-queue">Add to Play Queue</span> </a> </li>
														<?php }?>
														<li class="item-actions__divider" data-item="play"></li>
														<?php if(!$this->ion_auth->logged_in()){?>
														<li class="item-actions__item"> <a href="<?php echo $url;?>" onclick="showLoginMsg()"> <i class="item-actions__icon icon-playlist-add fa fa-file-audio-o"></i> <span class="smallText" data-i18n="t-add-to-playlist">Add to Playlist</span> </a> </li>
														<?php }else{?>
														<li class="item-actions__item add-play-list-btn" data-item="add-to-playlist"> <a href="<?php echo $url;?>" class="js-item-action js-add-to-playlist" data-test-id="contextmenu-add-to-playlist"> <i class="item-actions__icon icon-playlist-add fa fa-file-audio-o"></i> <span class="smallText" data-i18n="t-add-to-playlist">Add to Playlist</span> </a> </li>
														<?php }?>
														<li class="item-actions__divider" data-item="add-to-playlist"></li>
														<li class="item-actions__item" data-item="favorite"> <a href="javascript:void(0)" class="favorite" data-id="<?php echo $row->id?>"> <i class="item-actions__icon icon-star <?php echo $featured_class ?>" data-bind-class="favorite-star"></i> <span class="smallText" data-i18n="t-add-to-favorites">Add to Favorites</span> </a> </li>
														<li class="item-actions__divider" data-item="favorite"></li>
														<li class="item-actions__item share_click" data-item="share" data-toggle="modal" data-target="#share-pop"> <a href="javascript:void(0)" class="js-item-action js-share share_click" data-test-id="contextmenu-share" onclick="showSharePopup('<?php echo $row->id?>')"> <i class="item-actions__icon icon-links fa fa-share-alt-square"></i> <span class="smallText" >Share</span> </a> </li>
														<li class="item-actions__divider" data-item="share"></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</ul>
							</div>
						</div>
						<a href="<?php echo $url;?>" class="playSong" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'><img src="<?php echo base_url()?>uploads/listing/thumb_400_<?php echo $row->picture?>" alt="" class="img-full r r-2x" ></a>
					</div>
					<div class="padder-v"> <a href="<?php echo $url;?>" class="playSong" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'><?php echo nl2br($row->title);?></a>
                    	<br />
						<?php if($this->ion_auth->get_users_groups($row->user_id)->row()->id == 3){ ?>
                    		<small><strong>Posted by:</strong>&nbsp;<a href="<?php echo base_url()?>user/channeldescription/<?php echo $row->user_id?>"><?php echo $row->channel_name;?></a></small>
                    	<?php }
						  else{
						?>
                       	 <small><strong>Posted by:</strong>&nbsp;IRW Network</small>
                    	<?php } ?>
						<br/>
                        <small>
                			<strong>Type:</strong>&nbsp;
                			<?php echo $row->type; ?>
                		</small>
                    </div>
				</div>
			</div>
			<?php ++$count; }?>
		</div>


		<!-- till here-->


		<div style="clear:both"></div>
		<br />
		<h3 class="font-thin m-t-n-xs m-b">Latest Content</h3>
		<div class="row row-sm">
			<?php 
				$count=0; 
				foreach($contents as $row){
					$url = $this->Common_model->getUrl($row);
			?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2-4 field float_none" >
				<div class="item">
					<div class="pos-rlt">
						<?php if($row->is_premium=='yes'){?>
						<div class="top"> <span class="badge bg-info m-l-sm m-t-sm">Premium</span> </div>
						<?php }?>
						<div class="item-overlay bg-black-opacity r r-2x r r-2x" data-url='<?php echo $url; ?>'>
							<div class="center text-center m-t-n w-full dropdown">
								<?php 
									$featured_class = $this->Content_model->checkIsFeatured($row->id);
									if($row->type=='Video'){
								?>
								<a href="javascript:void(0)" class="ellips featured featured<?php echo $row->id?>" data-id="<?php echo $row->id?>"><i class="<?php echo $featured_class?>"></i></a> 
								<a href="<?php echo $url?>" data-fullText="<?php echo $row->title?>" ><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<a href="#" class="ellips dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-h text-white"></i><b class="caret"></b></a>
								<?php }else if($row->type=='Text'){?>
								<a href="javascript:void(0)" class="ellips featured featured<?php echo $row->id?>" data-id="<?php echo $row->id?>"><i class="<?php echo $featured_class?>"></i></a>
								<a href="<?php echo $url;?>" data-fullText="<?php echo $row->title?>" ><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<a href="#" class="ellips dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-h text-white"></i><b class="caret"></b></a>
								<?php }else{ ?>
								<a href="javascript:void(0)" class="ellips featured featured<?php echo $row->id?>" data-id="<?php echo $row->id?>"><i class="<?php echo $featured_class?>"></i></a> 
								<a href="<?php echo $url;?>" class="playSong" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'><i class="fa fa-2x fa-play-circle-o text-white"></i></a> 
								<a href="#" class="ellips dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-h text-white"></i><b class="caret"></b></a>
								<?php }?>
								<ul class="dropdown-menu">
									<div class="ui-widget ui-widget-content ui-corner-all ui-front ui-dialog ui-dialog--context-menu undefined contextmenu__arrow-top-left" tabindex="-1" role="dialog" aria-describedby="ui-id-3" aria-labelledby="ui-id-4" style="height: auto; width: 215px; top: 105px; left: 628px;"> 
										<div class="contextmenu-dialog ui-dialog-content ui-widget-content" id="ui-id-3" style="width: auto; min-height: 0px; max-height: none; height: auto;">
											<div id="contextmenu">
												<div>
													<div class="add_play_list_menu_box">
														<div class="add-to-playlist__heading">Select Playlist</div>
														<div class="add-to-playlist__lists">
															<ul class="grid__item__menu item-actions add_play_list_menu">
																<?php foreach($playlists as $playlist){?>
																<li class="add-to-playlist__item smallText playlist_li" data-playlist-id="<?php echo $playlist->id?>" data-song-id="<?php echo $row->id?>"> <a class="js-add-to-playlist-item" href="javascript:void(0)"> <i class="fa fa-music"></i> <span><?php echo $playlist->title;?></span> </a> </li>
																<?php }?>
															</ul>
														</div>
														<div class="create_list_btn"> <a href="#" data-toggle="modal" data-target="#createPlayList">Create New</a> </div>
													</div>
													<ul class="main-grid-menu grid__item__menu item-actions">
														<li class="item-actions__item item-actions__album" data-bind-class="type" data-item="header">
															<div class="item-actions__count" data-bind="bundleCount"></div>
															<img class="item-actions__cover" src="<?php echo base_url()?>uploads/listing/thumb_153_<?php echo $row->picture?>" data-bind-src="imgUrl" data-bind-width="width" data-bind-height="height" width="32" height="32"> <span class="item-actions__title" data-bind="title" data-test-id="contextmenu-title"><?php echo substr($row->title,0,20);?></span> </li>
														<?php if($row->type!='Video' && $row->type!='Text'){?>
														<li class="item-actions__item" data-item="play"> <a href="<?php echo $url;?>" class="js-item-action js-play-now playSong" data-title="<?php echo $row->title?>" data-image="<?php echo $row->picture; ?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'> <i class="item-actions__icon icon-play-circle fa fa-play-circle-o"></i> <span class="smallText" data-i18n="t-play-now">Play Now</span> </a> </li>
														<li class="item-actions__item" data-item="play"> <a href="<?php echo $url;?>" class="js-item-action js-play-next playNext" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'> <span class="smallText" data-i18n="t-play-next">Play Next</span> </a> </li>
														<li class="item-actions__item" data-item="play"> <a href="<?php echo $url;?>" class="js-item-action js-play-last add_in_queue" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'> <i class="item-actions__icon icon-queue-add fa fa-file-text-o"></i> <span class="smallText" data-i18n="t-add-to-queue">Add to Play Queue</span> </a> </li>
														<?php }?>
														<li class="item-actions__divider" data-item="play"></li>
														<?php if(!$this->ion_auth->logged_in()){?>
														<li class="item-actions__item"> <a href="<?php echo $url;?>" onclick="showLoginMsg()"> <i class="item-actions__icon icon-playlist-add fa fa-file-audio-o"></i> <span class="smallText" data-i18n="t-add-to-playlist">Add to Playlist</span> </a> </li>
														<?php }else{?>
														<li class="item-actions__item add-play-list-btn" data-item="add-to-playlist"> <a href="<?php echo $url;?>" class="js-item-action js-add-to-playlist" data-test-id="contextmenu-add-to-playlist"> <i class="item-actions__icon icon-playlist-add fa fa-file-audio-o"></i> <span class="smallText" data-i18n="t-add-to-playlist">Add to Playlist</span> </a> </li>
														<?php }?>
														<li class="item-actions__divider" data-item="add-to-playlist"></li>
														<li class="item-actions__item" data-item="favorite"> <a href="javascript:void(0)" class="favorite" data-id="<?php echo $row->id?>"> <i class="item-actions__icon icon-star <?php echo $featured_class ?>" data-bind-class="favorite-star"></i> <span class="smallText" data-i18n="t-add-to-favorites">Add to Favorites</span> </a> </li>
														<li class="item-actions__divider" data-item="favorite"></li>
														<li class="item-actions__item share_click" data-item="share" data-toggle="modal" data-target="#share-pop"> <a href="javascript:void(0)" class="js-item-action js-share share_click" data-test-id="contextmenu-share" onclick="showSharePopup('<?php echo $row->id?>')"> <i class="item-actions__icon icon-links fa fa-share-alt-square"></i> <span class="smallText" >Share</span> </a> </li>
														<li class="item-actions__divider" data-item="share"></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</ul>
							</div>
						</div>
                        
						<a href="<?php echo $url;?>" class="playSong" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'><img src="<?php echo base_url()?>uploads/listing/thumb_153_<?php echo $row->picture?>" alt="" class="img-full r r-2x" ></a> </div>
					<div class="padder-v"><a href="<?php echo $url;?>" class="playSong" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title?>" data-song='<?php echo $row->file_url?>' data-id='<?php echo $row->id?>'><?php echo nl2br($row->title);?></a> 
                    	<br />
						<?php if($this->ion_auth->get_users_groups($row->user_id)->row()->id == 3){ ?>
                    		<small><strong>Posted by:</strong>&nbsp;<a href="<?php echo base_url()?>user/channeldescription/<?php echo $row->user_id?>"><?php echo $row->channel_name;?></a></small>
                    	<?php } 
						  else{
						?> 
                       	 <small><strong>Posted by:</strong>&nbsp;IRW Network</small>
                    	<?php } ?>
						<br/>
                        <small>
                			<strong>Type:</strong>&nbsp;
                			<?php echo $row->type; ?>
                		</small>
                    </div>
					
                </div>
			</div>
			<?php ++$count; }?>
		</div>
	</div>
	<div class="col w-md bg-light dker b-l bg-auto no-border-xs">
    	<div class="wrapper-md " style="padding-bottom: 0;">
        <div class="m-b-sm text-md">IRW Social</div>
        	<div class="row for-margin-left">
            	<ul style="list-style-type: none;padding:0;" class=" col-xs-12">
                	 <li class="col-xs-2">
                     	<a href="<?php echo $facebook_link;?>" target="_blank" >
                        	<i style="font-size:30px;" class="fa fa-facebook-square" aria-hidden="true"></i>
						 </a>
                     </li>
                     
                     <li  class="col-xs-2">
                     	<a href="<?php echo $twitter_link;?>" target="_blank" >
                        	<i style="font-size:30px;" class="fa fa-twitter-square" aria-hidden="true"></i>
                        </a>
                     </li>
                     
                     <li class="col-xs-2">
                     	<a href="<?php echo $instagram_link;?>" target="_blank" >
                        	<i style="font-size:30px;" class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                     </li>
                </ul>
            	
            </div>
        </div>
		<div class="wrapper-md" style="padding-top: 2px;">
        <div class="m-b-sm text-md">Feed Aggregator</div>
        	<div class="row for-margin-left">
				<?php foreach($rssRows as $row){?>
            	<button class="col-xs-5 new_feeds_link" onclick="loadRssFeed('<?php echo $row->id?>')"><?php echo $row->name?></button>
				<?php }?>
            </div>
            <div id="feeds_content">
            <div class="m-b-sm text-md">Wrestle Zone</div>
                <ul class="list-group no-bg no-borders pull-in">
                    <?php $i=0;foreach($rss_data as $row){?>
                    <li class="list-group-item">
                    	<?php if($row['image']!=''){?>
                        <a herf="<?php echo $row['link'];?>" class="pull-left thumb-sm m-r" style="width:60px" target="_blank"><img src="<?php echo $row['image']?>" style="width:300px; !important"></a>
                        <?php }?>
                        <div class="clear">
                            <div><a href="<?php echo $row['link'];?>" target="_blank"><?php echo substr($row['title'],0,50);?></a></div>
                        </div>
                    </li>
                    <?php }?>
                </ul>
            </div>
		</div>
	</div>
	<!-- / right col --> 
</div>
<?php //if($this->session->userdata('websiteloaded')!='yes'){?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colorbox.css" type="text/css" />
<script src="<?php echo base_url()?>assets/js/jquery.colorbox.js"></script> 
<script type="text/javascript">

<?php
	if(!isset($_COOKIE['popup_check']) && $popup_check != "no"){
?>

$(document).ready(function(){
	setTimeout(function(){
		$.colorbox({
			iframe:true,
			innerWidth:"50%",
			innerHeight:"70%",
			href: "<?php echo base_url()?>home/mainpopup",
		});
	},4000);
});


<?php

	setcookie('popup_check', 'triggered', time() + (10 * 365 * 24 * 60 * 60));

	}
?>
</script>

<?php// }?>
