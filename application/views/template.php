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
<script src="<?php echo base_url(); ?>assets/js/bar-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bar-ui.css" />
<script src="<?php echo base_url(); ?>assets/js/demo.js"></script>
<script type="text/javascript">
var BASE_URL = '<?php echo base_url()?>';
$(document).ready(function(){
	$(".playSong").click(function(){
		var title = $(this).attr('data-title');
		var song = $(this).attr('data-song');
		var id = $(this).attr('data-id');
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
		addInQueue(song,title,id);
	});
});
function addSong(song,title,id){
	$(".sm2-playlist-bd").html("<li id='song"+id+"' data-id='song"+id+"'><a href='<?php echo base_url()?>uploads/files/"+song+"'>"+title+"</a></li>");
	window.sm2BarPlayers[0].actions.play(0);
}
function addNextPlay(song,title,id){
	var liNumber = $('.sm2-playlist-bd li.selected').attr('data-id');
	$("#"+liNumber ).after( "<li id='song"+id+"' data-id='song"+id+"'> <a href='<?php echo base_url()?>uploads/files/"+song+"'>"+title+"</a></li>");
}
function addInQueue(song,title,id){
	$(".sm2-playlist-bd" ).append( "<li id='song"+id+"' data-id='song"+id+"'> <a href='<?php echo base_url()?>uploads/files/"+song+"'>"+title+"</a></li>");
}
</script>
<?php if(isset($dataRow)){?>
<meta name="description" content="<?php echo $dataRow['description'];?>" />
<meta name="twitter:card" content="player">
<meta name="twitter:title" content="<?php echo $dataRow['title'];?>">
<meta name="twitter:description" content="<?php echo $dataRow['description'];?>">
<meta name="twitter:image:src" content="<?php echo base_url() ?>uploads/files/<?php echo $dataRow['picture']?>">
<meta property="og:title" content="<?php echo $dataRow['title'];?>">
<meta property="og:image" content="<?php echo base_url() ?>uploads/files/thumb_469_<?php echo $dataRow['picture']?>">
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
		<div class="sm2-bar-ui full-width fixed">
			<div class="bd sm2-main-controls">
				<div class="sm2-inline-texture"></div>
				<div class="sm2-inline-gradient"></div>
				<div class="sm2-inline-element sm2-button-element">
					<div class="sm2-button-bd"> <a href="#play" class="sm2-inline-button play-pause" id="paly">Play / pause</a> </div>
				</div>
				<div class="sm2-inline-element sm2-inline-status">
					<div class="sm2-playlist">
						<div class="sm2-playlist-target"> 
							<!-- playlist <ul> + <li> markup will be injected here --> 
							<!-- if you want default / non-JS content, you can put that here. -->
							<noscript>
							<p>JavaScript is required.</p>
							</noscript>
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
				</div>
				<div class="sm2-inline-element sm2-button-element sm2-volume">
					<div class="sm2-button-bd"> <span class="sm2-inline-button sm2-volume-control volume-shade"></span> <a href="#volume" class="sm2-inline-button sm2-volume-control">volume</a> </div>
				</div>
				<div class="sm2-inline-element sm2-button-element">
					<div class="sm2-button-bd"> <a href="#prev" title="Previous" class="sm2-inline-button previous">&lt; previous</a> </div>
				</div>
				<div class="sm2-inline-element sm2-button-element">
					<div class="sm2-button-bd"> <a href="#next" title="Next" class="sm2-inline-button next">&gt; next</a> </div>
				</div>
				<div class="sm2-inline-element sm2-button-element">
					<div class="sm2-button-bd"> <a href="#repeat" title="Repeat playlist" class="sm2-inline-button repeat">&infin; repeat</a> </div>
				</div>
				<div class="sm2-inline-element sm2-button-element sm2-menu">
					<div class="sm2-button-bd"> <a href="#menu" class="sm2-inline-button menu">menu</a> </div>
				</div>
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