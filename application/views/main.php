<div class="hbox hbox-auto-xs hbox-auto-sm">
	<!-- main -->
	<div class="col wrapper-lg">
		<h3 class="font-thin m-t-n-xs m-b">Featured</h3>
		<div class="row row-sm">
			<?php 
				$count=0; 
				foreach($featured as $row){
			?>
			<div class="col-xs-6 col-sm-4 col-md-4 field" data-fullText="<?php echo $row->title?>"   ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }">
				<div class="item">
				    
					<div class="pos-rlt">
					
						<?php if($row->is_premium=='yes'){?>
						<div class="top"> <span class="badge bg-info m-l-sm m-t-sm">Premium</span> </div>
						<?php }?>
						<div class="item-overlay bg-black-opacity r r-2x r r-2x">
							<div class="center text-center m-t-n w-full "> 
								<?php 
									$url = $this->Common_model->getUrl($row);
									if($row->type=='Video'){
								?>
									<a href="<?php echo base_url()?>home/playvideo?id=<?php echo $row->id?>"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<?php }else if($row->type=='Text'){?>
									<a href="<?php echo base_url()?>home/showArticle?id=<?php echo $row->id?>"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<?php }else{?>
									<a href="javascript:void(0)" data-fullText="<?php echo $row->title?>" ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<?php }?>
							</div>
						</div>
						<a href="javascript:void(0)" onclick="play('<?php echo $url ?>',,'<?php echo $row->title?>')"><img src="<?php echo base_url()?>uploads/files/thumb_400_<?php echo $row->picture?>" alt="" class="img-full r r-2x" ></a> </div>
					<div class="padder-v"> <a href="javascript:void(0)" onclick="play('<?php echo $url ?>',,'<?php echo $row->title?>')" class="text-ellipsis"><?php echo substr($row->title,0,40);?></a> </div>
				</div>
			</div>
			<?php ++$count; }?>
		</div>
		<div style="clear:both"></div>
		<br />
		<h3 class="font-thin m-t-n-xs m-b">Recommended for you</h3>
		<div class="row row-sm">
			<?php 
				$count=0; 
				foreach($contents as $row){
			?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2-4 field" data-fullText="<?php echo $row->title?>"   ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }">
				<div class="item">
				    
					<div class="pos-rlt">
					
						<?php if($row->is_premium=='yes'){?>
						<div class="top"> <span class="badge bg-info m-l-sm m-t-sm">Premium</span> </div>
						<?php }?>
						<div class="item-overlay bg-black-opacity r r-2x r r-2x">
							<div class="center text-center m-t-n w-full "> 
								<?php 
									$url = $this->Common_model->getUrl($row);
									if($row->type=='Video'){
								?>
									<a href="<?php echo base_url()?>home/playvideo?id=<?php echo $row->id?>"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<?php }else if($row->type=='Text'){?>
									<a href="<?php echo base_url()?>home/showArticle?id=<?php echo $row->id?>"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<?php }else{?>
									<a href="javascript:void(0)" data-fullText="<?php echo $row->title?>" ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
								<?php }?>
							</div>
						</div>
						<a href="javascript:void(0)" onclick="play('<?php echo $url ?>',,'<?php echo $row->title?>')"><img src="<?php echo base_url()?>uploads/files/thumb_153_<?php echo $row->picture?>" alt="" class="img-full r r-2x" ></a> </div>
					<div class="padder-v"><a href="javascript:void(0)" onclick="play('<?php echo $url ?>',,'<?php echo $row->title?>')" class="text-ellipsis"><?php echo substr($row->title,0,40);?></a> </div>
				</div>
			</div>
			<?php ++$count; }?>
		</div>
	</div>
	<!-- / main --> 
	<!-- right col -->
	<!--<div class="col w-md bg-light dker b-l bg-auto no-border-xs">
		<div class="wrapper-md">
			<div class="m-b-sm text-md">Top Plays</div>
			<ul class="list-group no-bg no-borders pull-in">
				<?php /*$i=0;foreach($contents as $row){$i++; if($i==5) break;?>
				<li class="list-group-item"> <a herf href="javascript:void(0)" onclick="play('<?php echo $url ?>','<?php echo $row->title?>')"> <img src="<?php echo base_url()?>uploads/files/thumb_153_<?php echo $row->picture?>" class="r" style="width:30px"> </a>
					<div class="clear">
						<div><a href="javascript:void(0)" onclick="play('<?php echo $url ?>','<?php echo $row->title?>')"><?php echo substr($row->title,0,15);?></a></div>
					</div>
				</li>
				<?php }*/?>
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b2.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>Find a way</a></div>
						<small class="text-muted">by Lucy</small> </div>
				</li>
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b3.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>Nothing to lose</a></div>
						<small class="text-muted">Joge Lucky</small> </div>
				</li>
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b4.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>New day</a></div>
						<small class="text-muted">by Folisise Chosielie</small> </div>
				</li>
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b5.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>Running</a></div>
						<small class="text-muted">by Aron Gonzalez</small> </div>
				</li>
			</ul>
			<div class="text-center"> <a href class="btn btn-sm btn-info padder-md m-b">More</a> </div>
		</div>
		
	</div>-->
	<div class="col w-md bg-light dker b-l bg-auto no-border-xs">
		<div class="wrapper-md">
			<div class="m-b-sm text-md">Top Plays</div>
			<ul class="list-group no-bg no-borders pull-in">
				<?php $i=0;foreach($contents as $row){$i++; if($i==5) break;?>
				<li class="list-group-item"> <a herf href="javascript:void(0)" onclick="play('<?php echo $url ?>','<?php echo $row->title?>')"> <img src="<?php echo base_url()?>uploads/files/thumb_153_<?php echo $row->picture?>" class="r" style="width:30px"> </a>
					<div class="clear">
						<div><a href="javascript:void(0)" onclick="play('<?php echo $url ?>','<?php echo $row->title?>')"><?php echo substr($row->title,0,15);?></a></div>
					</div>
				</li>
				<?php }?>
				<!--<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b1.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>On the road</a></div>
						<small class="text-muted">by Chris Fox</small> </div>
				</li>
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b2.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>Find a way</a></div>
						<small class="text-muted">by Lucy</small> </div>
				</li>
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b3.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>Nothing to lose</a></div>
						<small class="text-muted">Joge Lucky</small> </div>
				</li>
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b4.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>New day</a></div>
						<small class="text-muted">by Folisise Chosielie</small> </div>
				</li>
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b5.jpg" alt="..." class="r"> </a>
					<div class="clear">
						<div><a href>Running</a></div>
						<small class="text-muted">by Aron Gonzalez</small> </div>
				</li>-->
			</ul>
			<div class="text-center"> <a href class="btn btn-sm btn-info padder-md m-b">More</a> </div>
		</div>
		<!-- streamline -->
		<div class="text-md wrapper-md">Activity</div>
		<div class="list-group no-borders no-bg m-l-xs m-r-xs m-t-n">
			<div class="list-group-item">
				<div class="text-muted">5 minutes ago</div>
				<div><a href class="text-info">Jessi</a> commented your post.</div>
			</div>
			<div class="list-group-item">
				<div class="text-muted">11:30</div>
				<div><a ui-sref="music.detail">Jone</a> published a song</div>
			</div>
			<div class="list-group-item">
				<div class="text-muted">Sun, 11 Feb</div>
				<div><a href class="text-info">Jessi</a> upload a video <a href class="text-info">Cat</a>.</div>
			</div>
			<div class="list-group-item">
				<div class="text-muted">Thu, 17 Jan</div>
				<div>Mike Followed you</div>
			</div>
		</div>
		<!-- / streamline --> 
	</div>
	<!-- / right col -->
</div>
<?php if($this->session->userdata('websiteloaded')!='yes'){?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colorbox.css" type="text/css" />
<script src="<?php echo base_url()?>assets/js/jquery.colorbox.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function(){
		$.colorbox({
			iframe:true, 
			innerWidth:"90%", 
			innerHeight:"90%",
			href: "<?php echo base_url()?>home/mainpopup",
		});
	},4000);
});
</script>
<?php }?>