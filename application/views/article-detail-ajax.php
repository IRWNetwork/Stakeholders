<br />
<div class="col-sm-12">
	<div class="blog-post">
		<div class="panel no-border">
			<div class="wrapper-lg">
				<h2 class="m-t-none"><a href=""><?php echo nl2br($dataRow['title']); ?></a></h2>
				<a data-item="share" data-toggle="modal" data-target="#share-pop" onclick="showSharePopup('<?php echo $dataRow['id']?>')">Share</a>
				<div>
					<img src="<?php echo base_url() ?>uploads/listing/thumb_400_<?php echo $dataRow['picture']?>" align="left" style="margin:0px 20px 20px 0px" />
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
