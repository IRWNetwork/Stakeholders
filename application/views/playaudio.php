<br />
<div class="col-sm-9">
	<div class="blog-post">
		<div class="panel no-border">
			<div>
				<?php if($dataRow['video_type']=='embed_code'){?>
				<?php echo $dataRow['embed_code'];?>
				<?php }else{?>
                
                 <audio style="width:100%" controls>
                      <source src="<?php echo $dataRow['file_url']?>"  type="audio/mpeg">
                      Your browser does not support the audio tag.
                 </audio>  
				<?php }?>
			</div>
			<div class="wrapper-lg">
				<h2 class="m-t-none"><a href=""><?php echo $dataRow['title'] ?></a></h2>
				<a data-item="share" data-toggle="modal" data-target="#share-pop" onclick="showSharePopup('<?php echo $dataRow['id']?>')">Share</a>
				<div>
					<p><?php echo $dataRow['description']?></p>
				</div>
				<div id="disqus_thread"></div>
				<script>
				
				/**
				*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
				
				var disqus_config = function () {
					this.page.url = '<?php echo current_url();?>';
					this.page.identifier = '<?php echo $dataRow['id']?>';
					this.page.title = '<?php echo $dataRow['title'] ?>';
				};
				
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
<div class="col-sm-3">
	<h5 class="font-bold">Recent Posts</h5>
	<div>
		<?php $count=0;
			foreach($featuredcontent as $row){$count++; if($count==5) break; $url = $this->Common_model->getUrl($row);
		?>
		<div> <a class="pull-left thumb thumb-wrapper m-r"> <img src="<?php echo base_url()?>uploads/listing/thumb_153_<?php echo $row->picture?>"> </a>
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


