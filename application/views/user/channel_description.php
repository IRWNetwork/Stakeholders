
<div class="app-content-body fade-in-up ng-scope" ui-view="">
	<div class="hbox hbox-auto-xs hbox-auto-sm ng-scope"> 
		<!-- main -->
		<div class="col w-xxl bg-light dker bg-auto">
			<h4 class="m-n wrapper">Channel Description</h4>
            <?php if(count($contents)){ ?>
			<ul class="list-group no-radius no-border no-bg list-group-lg">
				<?php $count=0;foreach($contents as $row){?>
				<li class="list-group-item">
					<div class="pull-right m-l"> <a ><i class="icon-close"></i></a> </div>
					<a class="m-r-sm pull-left play_list_song" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title; ?>" data-song="<?php echo $row->file; ?>" href="javascript:void(0)" data-fullText="<?php echo $row->title; ?>" ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }"> <i class="icon-control-play text"></i> <i class="icon-control-pause text-active"></i> </a>
					<div class="clear text-ellipsis"> <span><?php echo substr($row->title,0,35)?></span> </div>
				</li>
				<?php ++$count;}?>
			</ul>
            <?php }else{
				echo "<p style='padding-left:15px;'> No Record Found.</p>";
			}?>
		</div>
		<!-- / main --> 
		<!-- right col -->
		<div class="col">
			<div class="wrapper-md">
				<div class="row">
					<div class="col-md-12">
						<h3 class="m-t-none text-black"><?php echo $channelDetail['channel_name']?></h3>
                        <h4 style="padding-left:5px;" class="m-t-none text-black"><?php echo $channelDetail['sales_pitch']?></h4>
					</div>
                    <div class="col-md-3">
                    	<img src="<?php echo base_url()."uploads/profile_pic/".$channelDetail['picture']?>" class=" img-responsive"/>
                    </div>
				</div>
				<p class="text-muted m-b-md" style="padding-top:10px;"><?php echo $channelDetail['description']?></p>
                
				<h4 class="m-b-md">Price: <br>
                <?php if($channelDetail['channel_subscription_price']==0){echo "Free"; } else{ echo $channelDetail['channel_subscription_price']."$"; } ?>
                </h4>
				
			</div>
		</div>
		<!-- / right col --> 
	</div>
</div>
