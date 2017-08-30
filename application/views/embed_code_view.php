<?php //echo "<pre>"; print_r($dataRow);exit; ?>
<html>
    <head>
    <script type="text/javascript">
        var BASE_URL = '<?php echo base_url()?>';
        var premiumPopup = '<?php echo $dataRow['is_premium'];?>';
        var contentId = '<?php echo $dataRow['id'];?>';
    </script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css" type="text/css" />
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.css">
       <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css" />
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" />
      <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
   
    <?php if($dataRow['type']!='text' || $dataRow['type']!= 'Text'){?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ribbon.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jplayer.pink.flag.css" type="text/css" />
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/justwave.player.css" type="text/css" />
    <link rel="screenshot" itemprop="screenshot" href="https://katspaugh.github.io/wavesurfer.js/example/screenshot.png" />
    <script src="<?php echo base_url(); ?>assets/js/wavesurfer.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/wavesurfer.regions.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/demo1.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/justwave.player.js"></script>
   
    <script src="<?php echo base_url(); ?>assets/js/jquery.jplayer.min.js"></script>
    <?php $fileExtension = substr($dataRow['file'], strrpos($dataRow['file'], '.') + 1); ?>
    <script type="text/javascript">
	<?php if($dataRow['type']=='podcasts' || $dataRow['type']== 'Podcasts'){ ?>	
    	// Create an instance
			var wavesurfer = Object.create(WaveSurfer);
			
			/*$(document).ready(function(){
				$(".play-button").click(function(){
					var imageSource = $('#play-icon').attr('src');
					if( $('.play-button').attr('data-status') == 'play'){
						
						$('.play-button').attr('data-status','pause');
						$('#play-icon').attr('src','<?php echo base_url(); ?>uploads/data/pause.png');
					}
                    else{
						$('.play-button').attr('data-status','play');
						$('#play-icon').attr('src','<?php echo base_url(); ?>uploads/data/play.png');
					}
				});

			});*/
			
			// Init & load audio file
			document.addEventListener('DOMContentLoaded', function () {
				// Init
				wavesurfer.init({
					container: document.querySelector('#waveform'),
					//waveColor: 'white',
					//progressColor: '#2e3344',
					//backend: 'MediaElement'
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
		else{ ?>
		'use strict';

		// Create an instance
		var wavesurfer = Object.create(WaveSurfer);
		/*$(document).ready(function(){
			$(".play-button").click(function(){
				 var video = $('#my-video').get(0);
        			
                var imageSource = $('#play-icon').attr('src');
                if( $('.play-button').attr('data-status') == 'play'){
        			video.play();
                    $('.play-button').attr('data-status','pause');
                    $('#play-icon').attr('src','<?php echo base_url(); ?>uploads/data/pause.png');
                }
                else{
					video.pause()
                    $('.play-button').attr('data-status','play');
                    $('#play-icon').attr('src','<?php echo base_url(); ?>uploads/data/play.png');
                }
			});
		});*/
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
    
<?php } ?>
    </head>
<body data-action="play" style="margin:0 0;">
<?php if($dataRow['type']=='text' || $dataRow['type']== 'Text'){ ?>
	<div class="container-fluid ">
		<div class="row">
               
               <div style="padding-right: 5%;padding-bottom: 3%;" class="pull-right">
                        <div class="player-logo"><a href="<?php echo base_url()?>home" target="_blank" ><img  src="<?php echo base_url() ?>uploads/listing/logo-old.png" width="50" /></a></div>
                        <a class="share-button glyphicon glyphicon-share js-item-action js-share share_click" data-test-id="contextmenu-share" href="javascript:void(0)" onClick="showSharePopup('<?php echo $dataRow['id'] ?>')">Share</a>
                    </div>
                    
                  <h3 style="padding-left: 4%;" class="col-xs-10"><?php echo $dataRow['title'] ?></h3> 
                  <div style="clear:both"></div>  
               	<div style="padding:0 5%;">
                    <img  src="<?php echo base_url() ?>uploads/listing/thumb_400_<?php echo $dataRow['picture']?>" align="left" style=" max-width:20%; min-width:10%;margin:0px 20px 20px 0px" />
                
               
                    <?php echo $dataRow['description']?>
                </div>
                <div style="clear:both"></div>
                
         </div>
    </div>
<?php }
else {	
?>
 
 <?php if($dataRow['type']=='video' || $dataRow['type']== 'Video'){ ?>
 
 	<div id="Container" class="container content">
        
        <video id="my-video" controls data-action="play" class="video" src="<?php echo $dataRow['file_url']; ?>" type="video/mpeg" ></video>
      <!--  <video id="my-video" data-action="play" class="video" src="http://irwnetwork.com/uploads/files/file_1489176912.mov" type="video/mpeg" ></video> -->

        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-12">
                   <div class="controls">
                       <!-- <a class="play-button" data-action="play" href="javascript:void(0)" >
                            <img id="play-icon" src="<?php echo base_url() ?>uploads/data/play.png" width="60">
                        </a>-->
                        <div class="song-title pull-right">
                            <a target="_blank" href="<?php echo base_url() ?>home/playvideo?id=<?php echo $id; ?>" class="title"><span><?php echo $dataRow['title']; ?></span></a>
                        </div>
                        
                    </div>
                    <div class="pull-right">
                        <div class="player-logo"><a href="<?php echo base_url()?>home" target="_blank" ><img  src="<?php echo base_url() ?>uploads/listing/logo-old.png" width="50" /></a></div>
                        <a class="share-button glyphicon glyphicon-share js-item-action js-share share_click" data-test-id="contextmenu-share" href="javascript:void(0)" onClick="showSharePopup('<?php echo $dataRow['id'] ?>')">Share</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
 <?php }
 else{ ?>
         <audio data-chained="1" class="justwave" src="<?php echo $dataRow['file_url']; ?>" data-wave_color="#2D2D2D" data-prog_color="#CCCCCC" data-back_color="#444444" data-type="gif" width="100%" height="80" data-buttonsize="70" data-buttoncolor="#111111" data-showtimes="1"></audio>
         <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="controls"> <!-- <a class="play-button" data-action="play" data-status="play"  > <img id="play-icon" src="<?php echo base_url() ?>uploads/data/play.png" width="60"> </a> -->
                        <div class="song-title pull-right"> <a target="_blank" href="<?php echo base_url() ?>home/playaudio?id=<?php echo $dataRow['id']; ?>" class="tag"><?php echo $dataRow['title']; ?></a>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="player-logo"><a href="<?php echo base_url()?>home" target="_blank" ><img  src="<?php echo base_url() ?>uploads/listing/logo-old.png" width="50" /></a></div>
                        <a class="share-button glyphicon glyphicon-share js-item-action js-share share_click" data-test-id="contextmenu-share" href="javascript:void(0)" onClick="showSharePopup('<?php echo $dataRow['id'] ?>')">Share</a>
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

<script type="text/javascript">
function showSharePopup(id){

    $.ajax({
        url: BASE_URL+"home/showpopup/",
        type: "post",
        data: {id:id},
        success: function (response) {
            $("#share_popup_detail").html( response );
            $(".modal").show();
        }
    });
}
function show_code(){
    $("#embed_code").show(350);
}

$("body").click(function () {
    
});
</script>

<div id="share-pop" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="share_popup_detail"></div>
</div>
</body>
</html>