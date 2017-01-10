<html>
    <head>
    <?php if($dataRow['type']!='text' || $dataRow['type']!= 'Text'){ ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jplayer.pink.flag.css" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.jplayer.min.js"></script>
    <?php $fileExtension = substr($dataRow['file'], strrpos($dataRow['file'], '.') + 1); ?>
    <script type="text/javascript">
		//<![CDATA[
		$(document).ready(function(){
		
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
				<?php if($dataRow['type']=='video' || $dataRow['type']== 'Video'){ ?>
				size: {
                         width: "100%",
                         height: "100%"
                    },
				<?php }
				else {?>
				size: {
				 width: "100%",
				 height: "100%"
                 },
				<?php }?>
				wmode: "window",
				useStateClassSkin: true,
				autoBlur: false,
				smoothPlayBar: true,
				keyEnabled: true,
				remainingDuration: true,
				toggleDuration: true
			});
		});
		//]]>
		</script>
<?php } ?>
    </head>
<body style="margin:0 0;">
<?php if($dataRow['type']=='text' || $dataRow['type']== 'Text'){ ?>
    <div class="col-sm-9">
        <div class="blog-post">
            <div class="panel no-border">
                <div class="wrapper-lg">
                    <h2 class="m-t-none"><?php echo $dataRow['title'] ?></h2>
                    <div>
                        <img src="<?php echo base_url() ?>uploads/files/thumb_400_<?php echo $dataRow['picture']?>" align="left" style="margin:0px 20px 20px 0px" />
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
 		<div id="jp_container_1" class="jp-video" style="width:99.6%; height:85%;" role="application" aria-label="media player">
	<div class="jp-type-single">
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
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
</div>
 <?php }
 else{?>

 	<div style="width:100%; height:84.4%;" ><div id="jquery_jplayer_1" class="jp-jplayer"></div></div>
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
        </div>

 <?php } ?>



<?php }?>
</body>
</html>