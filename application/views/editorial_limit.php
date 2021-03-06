<div class="hbox hbox-auto-xs hbox-auto-sm"> 
	<!-- main -->
	<div class="col wrapper-lg">
		<div class="row row-sm">
			<?php 
			if(count($contents)>0){
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
								?>
								<a href="javascript:void(0)" class="ellips featured featured<?php echo $row->id?>" data-id="<?php echo $row->id?>"><i class="<?php echo $featured_class?>"></i></a>
								<a href="<?php echo base_url()?>home/showArticle?id=<?php echo $row->id?>" ><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
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
															<img class="item-actions__cover" src="<?php echo base_url()?>uploads/listing/<?php echo $row->picture?>" data-bind-src="imgUrl" data-bind-width="width" data-bind-height="height" width="32" height="32"> <span class="item-actions__title" data-bind="title" data-test-id="contextmenu-title"><?php echo substr($row->title,0,20);?></span> </li>
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
                        
						<a href="<?php echo $url;?>"><img src="<?php echo base_url()?>uploads/listing/thumb_153_<?php echo $row->picture?>" alt="" class="img-full r r-2x" ></a> </div>
					<div class="padder-v"><a href="<?php echo $url?>" class="text-ellipsis"><?php echo nl2br($row->title);?></a> 
                    	<br />
						<?php if($this->ion_auth->get_users_groups($row->user_id)->row()->id == 3){ ?>
                    		<small><strong>Posted by:</strong>&nbsp;<a href="<?php echo base_url()?>user/channeldescription/<?php echo $row->user_id?>"><?php echo $row->channel_name;?></a></small>
                    	<?php } 
						  else{
						?> 
                       	 <small><strong>Posted by:</strong>&nbsp;IRW Network</small>
                    	<?php } ?>
                    </div>
				</div>
			</div>
			<?php }
			}?>
		</div>
		<div class="loader" style="margin: 0 auto;text-align: center;display: none">
			<img src="<?php echo base_url()?>uploads/listing/loading.gif" width="200" height="200">
		</div>
	</div>
	<!-- / main --> 
	<!-- right col -->
	<div class="col w-md bg-light dker b-l bg-auto no-border-xs">
		<div class="wrapper-md">
			<div class="m-b-sm text-md"></div>
			<ul class="list-group no-bg no-borders pull-in"></ul>
		</div>
	</div>
	<!-- / right col --> 
	
</div>
