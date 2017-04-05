<br />

<div class="col-sm-9">
	<div class="blog-post">
		<div class="panel no-border">
			<div>
				<?php if ($dataRow['video_type']=='embed_code') { ?>
				<?php echo $dataRow['embed_code']; ?>
				<?php } ?>
			</div>
			<div class="wrapper-lg">
				<h2 class="m-t-none"><a href=""><?php echo $dataRow['title'] ?></a></h2>
				<a data-item="share" data-toggle="modal" data-target="#share-pop" onclick="showSharePopup('<?php echo $dataRow['id']?>')">Share</a>
				<div>
					<p><?php echo $dataRow['description']?></p>
				</div>
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
				//load the comments
	(function() {

				 // DON'T EDIT BELOW THIS LINE
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
	<div class="col w-md bg-light dker b-l bg-auto no-border-xs">
		<div class="wrapper-md">
			<div class="m-b-sm text-md">Wrestle Zone</div>
			<ul class="list-group no-bg no-borders pull-in">
				<?php $i=0;foreach($rss_data as $row){?>
				<li class="list-group-item">
					<a herf="<?php echo $row['link'];?>" class="pull-left thumb-sm m-r" style="width:60px" target="_blank"><img src="<?php echo $row['image']?>" style="width:300px; !important"></a>
					<div class="clear">
						<div><a href="<?php echo $row['link'];?>" target="_blank"><?php echo substr($row['title'],0,50);?></a></div>
					</div>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
	
</div>
<script type="text/javascript">
	
	// function play_video() {
	// 	var video = '<?= $video ?>';
	// 	$("#skip_add").click(function(){
	// 		$("#myvideo").attr('src', video);
	// 		var myvid = document.getElementById('myvideo');
	// 		myvid.play();
	// 		$("#skip_add").hide();
	// 	});
	// }
</script>
<script type="text/javascript">
	// var myvid = document.getElementById('myvideo');
	// var myvids = ['<?= $video; ?>'];
	// var activeVideo = 0;

	// myvid.addEventListener('ended', function(e) {
	//   // update the active video index
	//   activeVideo = (++activeVideo) % myvids.length;

	//   // update the video source and play
	//   myvid.src = myvids[activeVideo];
	//   myvid.play();
	// });

</script>

