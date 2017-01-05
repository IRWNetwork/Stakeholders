<br />
<div class="col-sm-9">
	<div class="blog-post">
		<div class="panel no-border">
			<div class="wrapper-lg">
				<h2 class="m-t-none"><a href=""><?php echo $dataRow['title'] ?></a></h2>
				<a data-item="share" data-toggle="modal" data-target="#share-pop" onclick="showSharePopup('<?php echo $dataRow['id']?>')">Share</a>
				<div>
					<img src="<?php echo base_url() ?>uploads/files/thumb_400_<?php echo $dataRow['picture']?>" align="left" style="margin:0px 20px 20px 0px" />
					<?php echo $dataRow['description']?>
					<div style="clear:both"></div>
					<div id="disqus_thread"></div>
                    <?php if($this->session->userdata('id')){
						$login = true;
					}
					else{
						$login = false;
					}
			echo $this->disqus->configure_sso($login,current_url(), $dataRow['id'], $dataRow['title'], $this->session->userdata('id'), $this->session->userdata('email'));?>
					<script>
					/**
					*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
					*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
					
					(function() { // DON'T EDIT BELOW THIS LINE
					var d = document, s = d.createElement('script');
					s.src = '//irw-1.disqus.com/embed.js';
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
					})();
					</script>
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
