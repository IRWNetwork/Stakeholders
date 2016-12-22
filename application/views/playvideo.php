<br />
<div class="col-sm-9">
	<div class="blog-post">
		<div class="panel no-border">
			<div>
				<?php if($video_row['video_type']=='embed_code'){?>
				<?php echo $video_row['embed_code'];?>
				<?php }else{?>
				<video width="100%" height="400" controls>
  					<source src="<?php echo base_url()?>uploads/files/<?php echo $video_row['file']?>" type="video/mp4">
					Your browser does not support the video tag.
				</video> 
				<?php }?>
			</div>
			<div class="wrapper-lg">
				<h2 class="m-t-none"><a href=""><?php echo $video_row['title'] ?></a></h2>
				<div>
					<p><?php echo $video_row['description']?></p>
				</div>
			</div>
		</div>
	</div>
	
	
</div>
<div class="col-sm-3">
	<h5 class="font-bold">Recent Posts</h5>
	<div>
		<?php $count=0;
			foreach($featuredcontent as $row){$count++; if($count==5) break; $url = $this->Common_model->getUrl($row);
		?>
		<div> <a class="pull-left thumb thumb-wrapper m-r"> <img src="<?php echo base_url()?>uploads/files/thumb_153_<?php echo $row->picture?>"> </a>
			<div class="clear"> 
				<?php 
					$url = $this->Common_model->getUrl($row);
					if($row->type=='Video'){
				?>
					<a href="<?php echo base_url()?>home/playvideo?id=<?php echo $row->id?>"><?php echo $row->title;?></a>
				<?php }else if($row->type=='Text'){?>
					<a href="<?php echo base_url()?>home/showArticle?id=<?php echo $row->id?>"><?php echo $row->title;?></a>
				<?php }else{?>
					<a href="javascript:void(0)" data-fullText="<?php echo $row->title?>" ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }"><?php echo $row->title;?></a>
				<?php }?>
				<div class="text-xs block m-t-xs"><a href="">Travel</a> 2 minutes ago</div>
			</div>
			<br />
		</div>
		<?php }?>
	</div>
</div>


