<br />
<div class="col-sm-9">
	<div class="blog-post">
		<div class="panel no-border">
			<div class="wrapper-lg">
				<h2 class="m-t-none"><a href=""><?php echo $article_row['title'] ?></a></h2>
				<div>
					<img src="<?php echo base_url() ?>uploads/files/thumb_400_<?php echo $article_row['picture']?>" align="left" style="margin-right:20px" />
					<?php echo $article_row['description']?>
					<div style="clear:both"></div>
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
