<html>
    <head>
    <?php if($dataRow['type']=='Podcasts' || $dataRow['type']== 'podcasts'){ ?>
    <style>
	body{
		 background: url("<?php echo base_url() ?>uploads/listing/thumb_400_<?php echo $dataRow['picture']?>") no-repeat;
		/* background: url("../images/maxresdefault.jpg") no-repeat center center fixed;
	   background-repeat: repeat-y;
		background-size: 100% auto;
		padding-top: 20px;
		padding-bottom: 20px;*/
		-webkit-background-size: 100% 100%;
		-moz-background-size: 100% 100%;
		-o-background-size: 100% 100%;
		background-size: 100% 100%;
		}
	</style>
	<?php } ?>
    
    
    <?php if($dataRow['type']!='text' || $dataRow['type']!= 'Text'){ ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ribbon.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jplayer.pink.flag.css" type="text/css" />
    <link rel="screenshot" itemprop="screenshot" href="https://katspaugh.github.io/wavesurfer.js/example/screenshot.png" />
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/wavesurfer.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/wavesurfer.regions.js"></script>
   
    <script src="<?php echo base_url(); ?>assets/js/jquery.jplayer.min.js"></script>
    <?php $fileExtension = substr($dataRow['file'], strrpos($dataRow['file'], '.') + 1); ?>
    <script type="text/javascript">
	<?php if($dataRow['type']=='podcasts' || $dataRow['type']== 'Podcasts'){ ?>	
    	// Create an instance
			var wavesurfer = Object.create(WaveSurfer);
			
			$(document).ready(function(){
				$(".play-button").click(function(){		
					var imageSource = $('#play-icon').attr('src');
					if( $('.play-button').attr('data-status') == 'play'){
						$('.play-button').attr('data-status','pause');
						$('#play-icon').attr('src','<?php echo base_url() ?>uploads/data/pause.png');
					}else{
						$('.play-button').attr('data-status','play');
						$('#play-icon').attr('src','<?php echo base_url() ?>uploads/data/play.png');
					}
				});
				$('body').on('click',function(){
					var imageSource = $('#play-icon').attr('src');
					if( $('.play-button').attr('data-status') == 'play'){
						$('.play-button').attr('data-status','pause');
						$('#play-icon').attr('src','<?php echo base_url() ?>uploads/data/pause.png');
					}else{
						$('.play-button').attr('data-status','play');
						$('#play-icon').attr('src','<?php echo base_url() ?>uploads/data/play.png');
					}
				});
			});
			
			// Init & load audio file
			document.addEventListener('DOMContentLoaded', function () {
				// Init
				wavesurfer.init({
					container: document.querySelector('#waveform'),
					waveColor: 'white',
					progressColor: '#2e3344',
					backend: 'MediaElement'
				});
			
				// Load audio from URL
				wavesurfer.load('<?php echo base_url()?>uploads/files/<?php echo $dataRow['file']?>');
			
				document.querySelector(
					'[data-action="play"]'
				).addEventListener('click', wavesurfer.playPause.bind(wavesurfer));
			
				document.querySelector(
					'[data-action="peaks"]'
				).addEventListener('click', function () {
					wavesurfer.load('<?php echo base_url()?>uploads/files/<?php echo $dataRow['file']?>', [
			0.0218, 0.0183, 0.0165, 0.0198, 0.2137, 0.2888, 0.2313, 0.15, 0.2542, 0.2538, 0.2358, 0.1195, 0.1591, 0.2599, 
			0.2742, 0.1447, 0.2328, 0.1878, 0.1988, 0.1645, 0.1218, 0.2005, 0.2828, 0.2051, 0.1664, 0.1181, 0.1621, 0.2966, 0.189, 0.246, 0.2445, 0.1621, 0.1618, 0.189, 0.2354, 0.1561, 0.1638, 0.2799, 0.0923, 0.1659, 0.1675, 0.1268, 0.0984, 0.0997, 0.1248, 0.1495, 0.1431, 0.1236, 0.1755, 0.1183, 0.1349, 0.1018, 0.1109, 0.1833, 0.1813, 0.1422, 0.0961, 0.1191, 0.0791, 0.0631, 0.0315, 0.0157, 0.0166, 0.0108
					]);
					document.body.scrollTop = 0;
				});
			});
	<?php } 
		else{?>
		'use strict';

		// Create an instance
		var wavesurfer = Object.create(WaveSurfer);
		$(document).ready(function(){
			$(".play-button").click(function(){
				$('#play-icon').attr('src','../images/pause.png');
				var imageSource = $('#play-icon').attr('src');
				/*$('#play-icon').attr('src','../images/pause.png');*/
				/*if( $('#play-icon').attr('src') == '../images/pause.png'){
					
					
				}else{
					$('#play-icon').attr('src','../images/play.png');
					
				}*/
				});
		});
		// Init & load audio file
		document.addEventListener('DOMContentLoaded', function () {
			// Init
			wavesurfer.init({
				container: document.querySelector('#waveform'),
				waveColor: '#A8DBA8',
				progressColor: '#3B8686',
				backend: 'MediaElement'
			});
		
			// Load audio from existing media element
			var mediaElt = document.querySelector('video');
		
			wavesurfer.load(mediaElt);
		
			document.querySelector(
				'[data-action="play"]'
			).addEventListener('click', wavesurfer.playPause.bind(wavesurfer));
		
			document.querySelector(
				'[data-action="peaks"]'
			).addEventListener('click', function () {
				wavesurfer.load(mediaElt, [
		0.0218, 0.0183, 0.0165, 0.0198, 0.2137, 0.2888, 0.2313, 0.15, 0.2542, 0.2538, 0.2358, 0.1195, 0.1591, 0.2599, 0.2742, 0.1447, 0.2328, 0.1878, 0.1988, 0.1645, 0.1218, 0.2005, 0.2828, 0.2051, 0.1664, 0.1181, 0.1621, 0.2966, 0.189, 0.246, 0.2445, 0.1621, 0.1618, 0.189, 0.2354, 0.1561, 0.1638, 0.2799, 0.0923, 0.1659, 0.1675, 0.1268, 0.0984, 0.0997, 0.1248, 0.1495, 0.1431, 0.1236, 0.1755, 0.1183, 0.1349, 0.1018, 0.1109, 0.1833, 0.1813, 0.1422, 0.0961, 0.1191, 0.0791, 0.0631, 0.0315, 0.0157, 0.0166, 0.0108
				]);
				document.body.scrollTop = 0;
			});
		
		});

		
		<?php }?>
    </script>
    <script type="text/javascript">
		//<![CDATA[
		/*
		$(document).ready(function(){
			var wavesurfer = WaveSurfer.create({
    container: '#waveform',
    waveColor: 'violet',
    progressColor: 'purple'
});



wavesurfer.on('ready', function () {alert(1);
    wavesurfer.play();
});

//wavesurfer.load('<?php echo base_url()?>uploads/files/demo.wav');
wavesurfer.load('<?php echo base_url()?>uploads/files/BoWEp03.mp3');
			
			
		
			return true;
			
			
		
			$("#jquery_jplayer_1").jPlayer({
				ready: function (event) {
					$(this).jPlayer("setMedia", {
						title: "<?php echo $dataRow['title'] ?>",
						<?php echo $fileExtension; ?>: "<?php echo base_url()?>uploads/files/<?php echo $dataRow['file']?>",
						poster: "<?php echo base_url() ?>uploads/files/thumb_400_<?php echo $dataRow['picture']?>"
					});
				},
				swfPath: "<?php echo base_url(); ?>assets/js",
				supplied: "<?php echo $fileExtension; ?>",
				size: {
				 width: "100%",
				 height: "100%"
                 },
				wmode: "window",
				useStateClassSkin: true,
				autoBlur: true,
				smoothPlayBar: true,
				keyEnabled: true,
				remainingDuration: true,
				toggleDuration: true
			});
		});*/
		//]]>
		</script>
<?php } ?>
    </head>
<body data-action="play" style="margin:0 0;">
<?php if($dataRow['type']=='text' || $dataRow['type']== 'Text'){ ?>
    <div class="col-sm-9">
        <div class="blog-post">
            <div class="panel no-border">
                <div class="wrapper-lg">
                    <h2 class="m-t-none"><?php echo $dataRow['title'] ?></h2>
                    <div>
                        <img src="<?php echo base_url() ?>uploads/listing/thumb_400_<?php echo $dataRow['picture']?>" align="left" style="margin:0px 20px 20px 0px" />
                        <?php echo $dataRow['description']?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
else {	
?>
 
 <?php if($dataRow['type']=='video' || $dataRow['type']== 'Video'){ ?>
 
 	<div id="Container" class="container content">
            <video id="my-video" data-action="play" class="video" src="<?php echo base_url()?>uploads/files/<?php echo $dataRow['file']?>" type="video/mpeg" ></video>

             <div class="container-fluid ">
            <div class="row">
                <div class="col-md-12">
                   <div class="controls">
                            <a class="play-button" data-action="play" href="javascript:void(0)" >
                                <img id="play-icon" src="<?php echo base_url() ?>uploads/data/play.png" width="60">
                            </a>
                            <div class="song-title pull-right">
                                <a href="" class="title"><span><?php echo $dataRow['title']; ?></span></a>
                            </div>
                            
                        </div>
                        <div class="pull-right"><div class="player-logo"><img  src="<?php echo base_url() ?>uploads/data/logo-old.png" width="50"/></div> 
                                <a href="">
                                    <i class="glyphicon glyphicon-heart heart-icon"></i>
                                </a>
                                <button class="share-button glyphicon glyphicon-share">Share</button>
                            </div>
                </div>
            </div>
        </div>
            <div id="demo">
                <div id="waveform">
                    <!-- Here be the waveform -->
                     <!--<div class="player-logo"><img  src="<?php echo base_url() ?>uploads/data/logo-old.png" width="50" height="50"/></div> -->
                </div>
            </div>


        </div>
    <!-- <div id="jp_container_1" class="jp-video" style="width:99.6%; height:85%;" role="application" aria-label="media player">
        <div class="jp-type-single">
            <div id="jquery_jplayer_1" class="jp-jplayer video-responsive"></div>
            <div class="jp-gui">
                <div class="jp-video-play">
                    <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                </div>
                <div class="jp-interface">
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>
                    <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                    <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                    <div class="jp-details">
                        <div class="jp-title" aria-label="title">&nbsp;</div>
                    </div>
                    <div class="jp-controls-holder">
                        <div class="jp-volume-controls">
                            <button class="jp-mute" role="button" tabindex="0">mute</button>
                            <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                            <div class="jp-volume-bar">
                                <div class="jp-volume-bar-value"></div>
                            </div>
                        </div>
                        <div class="jp-controls">
                            <button class="jp-play" role="button" tabindex="0">play</button>
                            <button class="jp-stop" role="button" tabindex="0">stop</button>
                        </div>
                        <div class="jp-toggles">
                            <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                            <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jp-no-solution">
                <span>Update Required</span>
                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
            </div>
        </div>
    </div> -->
 <?php }
 else{?>
         <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="controls"> <a class="play-button" data-action="play" data-status="play"  > <img id="play-icon" src="<?php echo base_url() ?>uploads/data/play.png" width="60"> </a>
                        <div class="song-title pull-right"> <a href="#" class="tag"><?php echo $dataRow['title']; ?></a>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="player-logo"><img  src="<?php echo base_url() ?>uploads/data/logo-old.png" width="50" /></div>
                        <a href=""> <i class="glyphicon glyphicon-heart heart-icon"></i> </a>
                        <button class="share-button glyphicon glyphicon-share">Share</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="demo">
                <div class="row">
                    <div class="col-md-12">
                        <div id="waveform"> 
                            <!-- Here be the waveform --> 
                            <!--<img  src="../images/logo-old.png" width="50" />--> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

 	<!--<div style="width:100%; height:84.4%;" ><div id="jquery_jplayer_1" class="jp-jplayer"></div></div>
        <div id="jp_container_1" class="jp-audio" style=" width:97%; height:5.6%;" role="application" aria-label="media player">
            <div class="jp-type-single">
                <div class="jp-gui jp-interface">
                    <div class="jp-controls">
                        <button class="jp-play" role="button" tabindex="0">play</button>
                        <button class="jp-stop" role="button" tabindex="0">stop</button>
                    </div>
                    <div class="jp-toggles">
                            <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                     </div>
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>
                    <div class="jp-volume-controls">
                        <button class="jp-mute" role="button" tabindex="0">mute</button>
                        <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>
                    <div class="jp-time-holder">
                        <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                        <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                        
                    </div>
                </div>
                <div class="jp-details">
                    <div class="jp-title" aria-label="title">&nbsp;</div>
                </div>
                <div class="jp-no-solution">
                    <span>Update Required</span>
                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                </div>
            </div>
        </div> -->

 <?php } ?>



<?php }?>
</body>
</html>