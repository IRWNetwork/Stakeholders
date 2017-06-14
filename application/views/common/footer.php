<footer id="footer" style="bottom: 0;position: fixed;width: 100%;">
	<div class="wrapper b-t bg-light"> <span class="pull-right">2.6.9 <a href ui-scroll="app" class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span> &copy; copyright IRW Network, LLC. </div>
</footer>
<div id="share-pop" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	<div id="share_popup_detail"></div>
</div>
<div class="modal fade" id="createPlayList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-music"></i> Create New Playlist</h4>
			</div>
			<div class="modal-body">
				<form method="post" name="frm_playlist">
					<div class="form-group">
						<input type="text" class="form-control" id="playlist_tilte" placeholder="Title" required>
					</div>
					<div class="form-group">
						<textarea class="form-control" id="playlist_description" placeholder="Write a description" rows="3" required></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btn-create-playlist">Save</button>
			</div>
		</div>
	</div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-100200804-1', 'auto');
  ga('send', 'pageview');

</script>