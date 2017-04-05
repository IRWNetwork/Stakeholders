<!DOCTYPE html>
<html lang="en" ng-app="docs">
<head>
<meta charset="utf-8" />
<title><?php echo $page_title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.png"  />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/animate.css/animate.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css" type="text/css" />
<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery/dist/jquery.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/js/app/music/theme.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/soundmanager2.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bar-ui.css" />
<script src="<?php echo base_url(); ?>assets/js/demo.js"></script>
<script type="text/javascript">
var BASE_URL = '<?php echo base_url()?>';
$(document).ready(function(){
	$(document).on('click', '.play_list_song', function() {
	// $(".play_list_song").click(function(){
		$("i.fa-pause").removeClass("icon-control-pause");
		$(".play_list_song i").addClass("icon-control-play");
		$(".player-custom").show();
		var current_play_button = $(this).children('i');
		current_play_button.removeClass('icon-control-play');
		current_play_button.addClass('icon-control-pause');
		var current_play_button = $(this).children('i');
		current_play_button.removeClass('fa-play-circle-o');
		current_play_button.addClass('fa-pause');
		var title = $(this).attr('data-title');
		var song = $(this).attr('data-song');
		var id = $(this).attr('data-id');
		var image = $(this).attr("data-image");
		var base_url = window.location.origin;
		var current_song_image = '<img src='+base_url+'/uploads/listing/thumb_153_'+image+' class="img-small r r-2x"/>';
		$(".song-img").empty();
		$(".song-img").append(current_song_image);
		
		$(".song-name h3").text(title);
		addSong(song,title,id);
		$(".sm2-playlist-target ul.sm2-playlist-bd").hide();
		var playlist_id = $(this).attr('playlist-id');
		playlist_id = { id : playlist_id };
		var base_url = window.location.origin;
		$.ajax({
	        url: base_url+"/playlist/get_playlist_by_id_json",
	        type: "post",
	        data: playlist_id,
	        success: function (response) {
	        	 $.each($.parseJSON(response), function() {
					//console.log(this);
	        	 	var title = this.title;
				    var id = this.id;
				    var song = this.song;
				    var image = this.picture;
				    addInQueue(song,title,id,image);
	        	 });
	        }
	    });

	});

	$(".icon-close").click(function() {
		var my_selec = $(this).parent("a");
		var playlist_id = $(this).parent("a");
		var playlist_id = playlist_id.parent("div.pull-right").next("a").attr("playlist-id");
		var song_id = $(this).parent("a");
		var song_id = song_id.parent("div.pull-right").next("a").attr("data-id");
		delete_song_data = { playlistId : playlist_id, songId : song_id };

		var base_url = window.location.origin;
		$.ajax({
	        url: base_url+"/playlist/remove_song_from_playlist",
	        type: "post",
	        data: delete_song_data,
	        success: function (response) {
	        	 if (response == 'true') {
	        	 	response_messages("Song Removed From This Playlist!");
	        	 	my_selec.parent("div.pull-right").parent("li").hide();
	        	 }
	        }
	    });
		
	})
$(document).on('click', '.playSong', function() {
	// $(".playSong").click(function(){
		$("i.fa-pause").removeClass("fa-pause");
		$(".playSong i").addClass("fa-play-circle-o");
		$(".player-custom").show();
		var current_play_button = $(this).children('i');
		current_play_button.removeClass('fa-play-circle-o');
		current_play_button.addClass('fa-pause');
		var title = $(this).attr('data-title');
		var song = $(this).attr('data-song');
		var id = $(this).attr('data-id');
		var image = $(this).attr("data-image");
		var base_url = window.location.origin;
		var current_song_image = '<img src='+base_url+'/uploads/listing/thumb_153_'+image+' class="img-small r r-2x"/>';
		$(".song-img").empty();
		$(".song-img").append(current_song_image);
		
		$(".song-name h3").text(title);
		addSong(song,title,id);
	});
	$(".playNext").click(function(){
		var title = $(this).attr('data-title');
		var song = $(this).attr('data-song');
		var id = $(this).attr('data-id');
		addNextPlay(song,title,id);
	});
	$(".add_in_queue").click(function(){
		var title = $(this).attr('data-title');
		var song = $(this).attr('data-song');
		var id = $(this).attr('data-id');
		var image = $(this).attr('data-image');
		addInQueue(song,title,id,image);
	});

});

function addSong(song,title,id){
	$(".sm2-playlist-bd").html("<li id='song"+id+"' data-id='song"+id+"'><a href='<?php echo base_url()?>uploads/listing/"+song+"'></a></li>");
	window.sm2BarPlayers[0].actions.play(0);
}
function addNextPlay(song,title,id){
	var liNumber = $('.sm2-playlist-bd li.selected').attr('data-id');
	$("#"+liNumber ).after( "<li id='song"+id+"' data-id='song"+id+"'> <a href='<?php echo base_url()?>uploads/listing/"+song+"'>"+title+"</a></li>");
}
function addInQueue(song,title,id,image){
	$(".sm2-playlist-bd" ).append( "<li id='song"+id+"' class='playlist_item' data-id='song"+id+"' data-image="+image+"> <a href='<?php echo base_url()?>uploads/listing/"+song+"'>"+title+"</a></li>");
}

$(document).on('click', '.sm2-playlist-wrapper .sm2-playlist-bd li', function() {
	$(".sm2-playlist-target ul.sm2-playlist-bd").hide();
	var image = $(this).attr('data-image');
	var title = $(this).find('a').text();
	$(".song-name h3").text(title);
	var base_url = window.location.origin;
	var current_song_image = '<img src='+base_url+'/uploads/listing/thumb_153_'+image+' class="img-small r r-2x"/>';
	$(".song-img").empty();
	$(".song-img").append(current_song_image);

});
</script>
<?php if(isset($dataRow)){?>
<meta name="description" content="<?php echo $dataRow['description'];?>" />
<meta name="twitter:card" content="player">
<meta name="twitter:title" content="<?php echo $dataRow['title'];?>">
<meta name="twitter:description" content="<?php echo $dataRow['description'];?>">
<meta name="twitter:image:src" content="<?php echo base_url() ?>uploads/listing/<?php echo $dataRow['picture']?>">
<meta property="og:title" content="<?php echo $dataRow['title'];?>">
<meta property="og:image" content="<?php echo base_url() ?>uploads/listing/thumb_469_<?php echo $dataRow['picture']?>">
<meta property="og:url" content="<?php echo current_url();?>">
<meta property="og:type" content="article"/>
<meta property="og:description" content="<?php echo $dataRow['description'];?>">
<?php }?>
</head>
<body>
<div class="app app-header-fixed "> 
	<!-- header -->
	<?php $this->load->view('common/top-nav');?>
	<!-- / header --> 
	<!-- aside -->
	<?php $this->load->view('common/left-nav');?>
	<!-- / aside --> 
	<!-- content -->
	<div>
		<div id="content" class="app-content" role="main"> {content} </div>
		<!-- footer -->
		<div class="sm2-bar-ui full-width fixed player-custom" style="display: none">
			<div class="bd sm2-main-controls">
								<div class="progress-bar-main">
					<div class="sm2-inline-element sm2-inline-status">
						<div class="sm2-playlist">
							<div class="sm2-playlist-target"> 
								<!-- playlist <ul> + <li> markup will be injected here --> 
								<!-- if you want default / non-JS content, you can put that here. -->
								<!-- <noscript>
								<p>JavaScript is required.</p>
								</noscript> -->
								<ul class="sm2-playlist-bd"></ul>
							</div>
						</div>
						<div class="sm2-progress">
							<div class="sm2-row">
								<div class="sm2-inline-time">0:00</div>
								<div class="sm2-progress-bd">
									<div class="sm2-progress-track">
										<div class="sm2-progress-bar"></div>
										<div class="sm2-progress-ball">
											<div class="icon-overlay"></div>
										</div>
									</div>
								</div>
								<div class="sm2-inline-duration">0:00</div>
							</div>
						</div>
					</div>				</div>				<div class="all-controls">					<div class="almb-img">						
					<div class="song-img">
						
					</div>
									<div class="song-name">							<h3></h3>							<h6><a href="#">Claudia Leitte																																									</a></h6>						</div>					</div>					<div class="player-controls">						<!--//-->						<div class="sm2-inline-element sm2-button-element">							<div class="sm2-button-bd"> <a href="#prev" title="Previous" class="sm2-inline-button previous">&lt; previous</a> </div>						</div>						<!--//-->						<div class="sm2-inline-element sm2-button-element">							<div class="sm2-button-bd"> <a href="#play" class="sm2-inline-button play-pause" id="paly">Play / pause</a> </div>						</div>						<!--//-->						<div class="sm2-inline-element sm2-button-element">							<div class="sm2-button-bd"> <a href="#next" title="Next" class="sm2-inline-button next">&gt; next</a> </div>						</div>						<!--//-->						<div class="sm2-inline-element sm2-button-element">							<div class="sm2-button-bd"> <a href="#repeat" title="Repeat playlist" class="sm2-inline-button repeat">&infin; repeat</a> </div>						</div>					</div>					<div class="player-right">						<div class="sm2-inline-element sm2-button-element sm2-volume">							<div class="sm2-button-bd"> <span class="sm2-inline-button sm2-volume-control volume-shade"></span> 							<a href="#volume" class="sm2-inline-button sm2-volume-control">volume</a> </div>						</div>						<div class="sm2-inline-element sm2-button-element sm2-menu">							<div class="sm2-button-bd"> <a href="#menu" class="sm2-inline-button menu">menu</a> </div>						</div>					</div>				</div>
			</div>
			<div class="bd sm2-playlist-drawer sm2-element">
				<div class="sm2-inline-texture">
					<div class="sm2-box-shadow"></div>
				</div>
				<!-- playlist content is mirrored here -->
				<div class="sm2-playlist-wrapper">
					<ul class="sm2-playlist-bd">
						<!-- item with "download" link -->
						<!--<li>
							<div class="sm2-row">
								<div class="sm2-col sm2-wide"> <a href="http://freshly-ground.com/data/audio/sm2/SonReal%20-%20LA%20%28Prod%20Chin%20Injetti%29.mp3"><b>SonReal</b> - LA<span class="label">Explicit</span></a> </div>
								<div class="sm2-col"> <a href="http://freshly-ground.com/data/audio/sm2/SonReal%20-%20LA%20%28Prod%20Chin%20Injetti%29.mp3" target="_blank" title="Download &quot;LA&quot;" class="sm2-icon sm2-music sm2-exclude">Download this track</a> </div>
							</div>
						</li>-->
						<!-- standard one-line items -->
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="general-msg-bar"></div>
	<?php $this->load->view('common/footer');?>
	<!-- / footer -->
</div>
<?php $this->load->view('common/footer-js');?>
<script id="dsq-count-scr" src="//irw-1.disqus.com/count.js" async></script>
</body>
</html>