<!DOCTYPE html>
<html lang="en" ng-app="docs">
<head>
<meta charset="utf-8" />
<title><?php echo $page_title;?></title>
<meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
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
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/app/music/videogular.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/audio-player/angular-media-player.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.field').click(function () {
    	var value=$(this).attr('data-fullText');
  		$("#title_1").html(value);
	});
	$('.someclass').click(function() {
    	$varName = $(this).data('fulltext');
    	console.log($varName);
	});
});
</script>
<style>
.progress {
	height: 5px;
	margin-bottom: 0px;
	overflow: hidden;
	background-color: #f5f5f5;
	border-radius: 4px;
	-webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
	box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
	overflow: hidden;
	width: 80%;
}
</style>
<script type="text/javascript">
angular.module('docs', ['mediaPlayer']).config(function ($interpolateProvider) {
	$interpolateProvider.startSymbol('[[');
  	$interpolateProvider.endSymbol(']]');
})
.run(function ($rootScope) {
	$rootScope.seekPercentage = function ($event) {
    	var percentage = ($event.offsetX / $event.target.offsetWidth);
    	if (percentage <= 1) {
      		return percentage;
    	} else {
      		return 0;
    	}
  	};
});
</script>
<script type="text/javascript">
  //angular.module('docs')
     var myApp = angular.module('docs');
    //var post_params = $.param({ request_type: "getListOfUsersWithRolesInfo" });
    var dataObj = {
        task_to_perform: 'getListOfUsersWithRolesInfo'
    };
    myApp.controller('RepeatController', function ($scope, $http) {
        $http({
            method: 'Get',
            dataType: 'json',
            url: '<?php echo site_url('home/audio'); ?>',
            headers: {
                'Content-Type': 'application/json'
            },
          //  data: dataObj,
            //transformRequest: function(){},
            timeout: 30000,
            cache: false
        }).
        success(function (rsp) {
            //console.log("success");
            //console.log(JSON.stringify(rsp));
			
			$scope.audioPlaylist =  rsp;
        }).
        error(function (rsp) {
            console.log("error");
        });
    });
</script>
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
	<div ng-controller="RepeatController">
		<div id="content" class="app-content" role="main"> {content} </div>
		<!-- /content -->
		<audio media-player="mediaPlayer" playlist="audioPlaylist"></audio>
		<!-- footer -->
		<div class="app-footer app-footer-fixed ">
			<div class="progress" ng-click="mediaPlayer.seek(mediaPlayer.duration * seekPercentage($event))">
				<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" ng-style="{ width: mediaPlayer.currentTime*100/mediaPlayer.duration + '%' }"></div>
				<div class="time" ng-show="mediaPlayer.formatTime"> <span>[[ mediaPlayer.formatTime ]]</span><b>/</b><span>[[ mediaPlayer.formatDuration ]]</span> </div>
			</div>
			<div class="player-control" style="background-color:#F0F3F4">
				<div class="btn" ng-click="mediaPlayer.play()"></div>
				<div class="btn" ng-click="mediaPlayer.prev()"> <i class="fa fa-step-backward"></i> <span></span> </div>
				<div class="btn" ng-click="mediaPlayer.playPause()"> <i class="fa" ng-class="{ 'fa-pause': mediaPlayer.playing, 'fa-play': !mediaPlayer.playing }"></i> </div>
				<div class="btn" ng-click="mediaPlayer.next()"> <span></span> <i class="fa fa-step-forward"></i>&nbsp;<span id="title_1"></span> </div>
				<div class="btn btn-noclick"> <span> <span class="badge">[[ mediaPlayer.formatTime ]]</span></span> </div>
				<div class="btn" ng-click="mediaPlayer.toggleMute()"> <span><i class="fa fa-volume-down"></i></span> </div>
			</div>
		</div>
	</div>
	<?php $this->load->view('admin/common/footer');?>
	<!-- / footer -->
</div>
<?php $this->load->view('admin/common/footer-js');?>
</body>
</html>