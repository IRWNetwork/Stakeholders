<div class="hbox hbox-auto-xs hbox-auto-sm"> 
	<!-- main -->
	<div class="col wrapper-lg">
		<h3 class="font-thin m-t-n-xs m-b">Podcasts</h3>
		<div class="row row-sm">
			<?php 
			if(count($contents)>0){
				foreach($contents as $row){
			?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2-4">
				<div class="item">
					<div class="pos-rlt">
						<?php if($row->is_premium=='yes'){?>
						<div class="top"> <span class="badge bg-info m-l-sm m-t-sm">Premium</span> </div>
						<?php }?>
						<div class="item-overlay bg-black-opacity r r-2x r r-2x">
							<div class="center text-center m-t-n w-full"> 
								<?php $url = $this->Common_model->getUrl($row);?>
								<a href="javascript:void(0)" onclick="play('<?php echo $url ?>')"><i class="fa fa-2x fa-play-circle-o text-white"></i></a>
							</div>
						</div>
						<a ui-sref="music.detail"><img src="<?php echo base_url()?>uploads/files/thumb_153_<?php echo $row->picture?>" alt="" class="img-full r r-2x"></a> </div>
					<div class="padder-v"> <a href="javascript:void(0)" onclick="play('<?php echo $url ?>','<?php echo $row->title?>')" class="text-ellipsis"><?php echo substr($row->title,0,20);?></a> </div>
				</div>
			</div>
			<?php }
			}else{
			?>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2-4">
				<div class="item">
					<div class="pos-rlt">
					No Record Found
					</div>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
	<!-- / main --> 
	<!-- right col -->
	<div class="col w-md bg-light dker b-l bg-auto no-border-xs">
		<div class="wrapper-md">
			<div class="m-b-sm text-md">Top Plays</div>
			<ul class="list-group no-bg no-borders pull-in">
				<li class="list-group-item"> <a herf class="pull-left thumb-sm m-r"> <img src="<?php echo base_url()?>assets/images/b1.jpg" alt="..." class="r"> </a>
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
				</li>
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
