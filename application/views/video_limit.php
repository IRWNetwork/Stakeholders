<div class="hbox hbox-auto-xs hbox-auto-sm"> 
	<!-- main -->
	<div class="col wrapper-lg">
		<div class="row row-sm">
			<?php 
			if(count($contents)>0){
				foreach($contents as $row){
					$url = $this->Common_model->getUrl($row);
			?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2-4 float_none">
				<div class="item">
					<div class="pos-rlt">
						<?php if($row->is_premium=='yes'){?>
						<div class="top"> <span class="badge bg-info m-l-sm m-t-sm">Premium</span> </div>
						<?php }?>
						<div class="item-overlay bg-black-opacity r r-2x r r-2x" data-url='<?php echo $url; ?>'>
							<div class="center text-center m-t-n w-full dropdown"> 
								<?php 
									$featured_class = $this->Content_model->checkIsFeatured($row->id);
								?>

								<a href="javascript:void(0)" class="ellips featured featured<?php echo $row->id?>" data-id="<?php echo $row->id?>"><i class="<?php echo $featured_class?>"></i></a> 
								<a href="<?php echo base_url()?>home/playvideo?id=<?php echo $row->id?>"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<a href="#" class="ellips dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-h text-white"></i><b class="caret"></b></a>
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
															<img class="item-actions__cover" src="<?php echo base_url()?>uploads/files/thumb_153_<?php echo $row->picture?>" data-bind-src="imgUrl" data-bind-width="width" data-bind-height="height" width="32" height="32"> <span class="item-actions__title" data-bind="title" data-test-id="contextmenu-title"><?php echo substr($row->title,0,20);?></span> </li>
														<li class="item-actions__item" data-item="play"> <a href="#" class="js-item-action js-play-now" data-test-id="contextmenu-play-now"> <i class="item-actions__icon icon-play-circle fa fa-play-circle-o"></i> <span class="smallText" data-i18n="t-play-now">Play Now</span> </a> </li>
														<li class="item-actions__item" data-item="play" data-sub-item="play-next"> <a href="#" class="js-item-action js-play-next" data-test-id="contextmenu-play-next"> <span class="smallText" data-i18n="t-play-next">Play Next</span> </a> </li>
														<li class="item-actions__item" data-item="play" data-sub-item="add-to-queue"> <a href="javascript:void(0)" class="js-item-action js-play-last" data-test-id="contextmenu-play-last"> <i class="item-actions__icon icon-queue-add fa fa-file-text-o"></i> <span class="smallText" data-i18n="t-add-to-queue">Add to Play Queue</span> </a> </li>
														<li class="item-actions__divider" data-item="play"></li>
														<?php if(!$this->ion_auth->logged_in()){?>
														<li class="item-actions__item"> <a href="javascript:void(0)" onclick="showLoginMsg()"> <i class="item-actions__icon icon-playlist-add fa fa-file-audio-o"></i> <span class="smallText" data-i18n="t-add-to-playlist">Add to Playlist</span> </a> </li>
														<?php }else{?>
														<li class="item-actions__item add-play-list-btn" data-item="add-to-playlist"> <a href="javascript:void(0)" class="js-item-action js-add-to-playlist" data-test-id="contextmenu-add-to-playlist"> <i class="item-actions__icon icon-playlist-add fa fa-file-audio-o"></i> <span class="smallText" data-i18n="t-add-to-playlist">Add to Playlist</span> </a> </li>
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
						<a href="<?php echo $url;?>"><img src="<?php echo base_url()?>uploads/files/thumb_153_<?php echo $row->picture?>" alt="" class="img-full r r-2x"></a> </div>
					<div class="padder-v"> <a href="<?php echo $url;?>"><?php echo $row->title;?></a> </div>
				</div>
			</div>
			<?php }
			}?>
		</div>
		<div class="loader" style="margin: 0 auto;text-align: center;display: none">
			<img src="<?php echo base_url()?>uploads/files/loading.gif" width="200" height="200">
		</div>
	</div>
	<!-- / main --> 
	<!-- right col -->
	<div class="col w-md bg-light dker b-l bg-auto no-border-xs">
		<div class="wrapper-md">
			<ul class="list-group no-bg no-borders pull-in"></ul>
		</div>
		<!-- streamline -->
		<div class="list-group no-borders no-bg m-l-xs m-r-xs m-t-n"></div>
		<!-- / streamline --> 
	</div>
	<!-- / right col --> 
	
</div>