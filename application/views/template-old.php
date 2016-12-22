<!DOCTYPE html>
<html lang="en" class="">
<head>
<meta charset="utf-8" />
<title><?php echo $page_title;?></title>
<meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/animate.css/animate.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css" type="text/css" />
<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery/dist/jquery.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/js/app/music/theme.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/app/music/videogular.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
	<div id="content" class="app-content" role="main"> 
		{content} 
	</div>
	<!-- /content --> 
	
	<!-- footer -->
	<div class="app-footer app-footer-fixed ng-scope" data-ng-include=" 'tpl/music.player.html' ">
		<div class="videogular-container bg-light lter ng-scope">
			<videogular vg-player-ready="onPlayerReady" vg-complete="onComplete" vg-theme="config.theme.url" vg-autoplay="config.autoPlay" class="videogular-container audio ng-isolate-scope">
				<vg-audio vg-src="config.sources" class="ng-isolate-scope">
					<audio vg-source="vgSrc" class="ng-scope" src="http://flatfull.com/themes/assets/musics/Miaow-03-Lentement.mp3" type="audio/mpeg"></audio>
				</vg-audio>
				<vg-controls class="ng-isolate-scope">
					<div id="controls-container" ng-mousemove="onMouseMove()" ng-class="animationClass" ng-transclude="">
						<vg-button ng-show="audios.length-1" ng-click="play('prev')" class="ng-scope" role="button" tabindex="0" aria-hidden="false"><i class="fa fa-backward"></i></vg-button>
						<vg-play-pause-button class="ng-scope">
							<span id="play_button"><i class="fa fa-play"></i></span>
						</vg-play-pause-button>
						<vg-button ng-show="audios.length-1" ng-click="play('next')" class="ng-scope" role="button" tabindex="0" aria-hidden="false"><i class="fa fa-forward"></i></vg-button>
						<vg-timedisplay class="hidden-xs ng-binding ng-scope">02:30</vg-timedisplay>
						<vg-scrubbar class="ng-scope">
							<div role="slider" aria-valuemax="-17656" aria-valuenow="-17850" aria-valuemin="0" aria-label="Time scrub bar" tabindex="0" ng-transclude="" ng-keydown="onScrubBarKeyDown($event)">
								<vg-title class="hidden-xs ng-binding ng-scope" id="player_title"></vg-title> 
							</div>
						</vg-scrubbar>
						<vg-timedisplay class="ng-binding ng-scope">03:14</vg-timedisplay>
						<vg-button ng-click="toggleShuffle()" title="Shuffle" class="ng-scope" role="button" tabindex="0"><i class="fa fa-random" ng-class="{'text-info':config.shuffle}"></i></vg-button>
						<vg-button ng-click="toggleRepeat()" title="Repeat" class="ng-scope" role="button" tabindex="0"><i class="fa fa-retweet" ng-class="{'text-info':config.repeat}"></i></vg-button>
						<vg-volume class="ng-scope">
							<vg-mutebutton>
								<button class="iconButton level3" ng-class="muteIcon" ng-click="onClickMute()" ng-focus="onMuteButtonFocus()" ng-blur="onMuteButtonLoseFocus()" ng-keydown="onMuteButtonKeyDown($event)" aria-label="Mute" type="button"></button>
							</vg-mutebutton>
						</vg-volume>
					</div>
				</vg-controls>
			</videogular>
		</div>
	</div>
	<?php $this->load->view('admin/common/footer');?>
	<!-- / footer --> 
	
</div>
<?php $this->load->view('admin/common/footer-js');?>
<script type="text/javascript">
$(document).ready(function() {
    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', 'http://www.soundjay.com/misc/sounds/bell-ringing-01.mp3');
    
    audioElement.addEventListener('ended', function() {
        this.play();
    }, false);
    
    audioElement.addEventListener("canplay",function(){
        $("#length").text("Duration:" + audioElement.duration + " seconds");
        $("#source").text("Source:" + audioElement.src);
        $("#status").text("Status: Ready to play").css("color","green");
    });
    
    audioElement.addEventListener("timeupdate",function(){
        $("#currentTime").text("Current second:" + audioElement.currentTime);
    });
    
    $('#play').click(function() {
        audioElement.play();
        $("#status").text("Status: Playing");
    });
    
    $('#pause').click(function() {
        audioElement.pause();
        $("#status").text("Status: Paused");
    });
    
    $('#restart').click(function() {
        audioElement.currentTime = 0;
    });
});
var audioElement=null;
var url = "";
function play(url,title){
	if(audioElement!=null){
		audioElement.pause();
		audioElement.currentTime = 0;
	}
	audioElement = document.createElement('audio');
    audioElement.setAttribute('src', url);
	audioElement.addEventListener('ended', function() {
    	this.play();
    }, false);
 	
    audioElement.play();
	$("#player_title").html(title);
	$("#play_button").html("<i class='fa fa-pause' onclick='pause()'></i>");
}
function replay(){
	$("#play_button").html("<i class='fa fa-pause' onclick='pause()'></i>");
	audioElement.play();
}
function pause(){
	audioElement.pause();
	$("#play_button").html("<i class='fa fa-play' onclick='replay()'></i>");
}
</script>
</body>
</html>
