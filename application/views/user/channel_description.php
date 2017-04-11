<?php 
//session_start();
$_SESSION['after_login'] = $_SERVER['REQUEST_URI'];
?>
<div class="app-content-body fade-in-up ng-scope" ui-view="">
	<div class="hbox hbox-auto-xs hbox-auto-sm ng-scope"> 
		<!-- main -->
		<div class="col w-xxl bg-light dker bg-auto">
			<h4 class="m-n wrapper">Channel's Content</h4>
            <ul class="list-group no-radius no-border no-bg list-group-lg">
            	<li class="list-group-item" style="border-color: #dde7e9;" >
                	<form name="frm">
                    	Filter
                        <select name="filter" style="width:80%" onchange="filterData(this.value)">
                            <option value="">All</option>
                            <option value="Video">Video</option>
                            <option value="Audio">Audio</option>
                            <option value="Text">Text</option>
                            <option value="Podcasts">Podcasts</option>
                        </select>
                        <?php if($this->input->get('filter')){?>
                        <script type="text/javascript">
							document.frm.filter.value='<?php echo $this->input->get('filter')?>';
                        </script>
                        <?php }?>
                    </form>
                </li>
            </ul>
			<ul class="list-group no-radius no-border no-bg list-group-lg" style="height: 450px;overflow: scroll;overflow-x: hidden;" id="channel_content_listing">
               	<?php if(count($contents)){ ?>
				<?php $count=0;foreach($contents as $row){ //echo "<pre>"; print_r($row);?>
				<li class="list-group-item">
					<!-- <div class="pull-right m-l"> <a ><i class="icon-close"></i></a> </div> -->
                    <?php 
                       $url = $this->Common_model->getUrl($row);
                       
                       $data_for = $url;
                       $my_href = 'javascript:void(0)';
                       $item_play = 'item_play';
                       $premium_label = '';
                       // if ($row->is_premium == 'yes') {
                       //      $premium_label = 'Premium';
                       //      if (!($this->ion_auth->logged_in())) {
                       //          $data_for = '';
                       //          $my_href = base_url().'user/login';
                       //          $item_play = '';
                       //      }
                       //      else {
                       //          $data_for = '';
                       //          $my_href = base_url().'user/channelsubscription/'.$row->user_id;
                       //          $item_play = '';   
                       //      }   
                       // }

					   if($row->type=='Video' || $row->type=='Text'){
                    ?>
                         <a class="m-r-sm pull-left play_list_song <?php echo $item_play; ?>" type="<?php echo $row->type; ?>" data-for="<?php echo $data_for; ?>" href="<?php echo $my_href; ?>"> <i class="icon-control-play text" style="position: absolute;left: 22px;top: 22px;color:#fff"></i> <i class="icon-control-pause text-active" style="position: absolute;left: 22px;top: 22px;color:#fff"></i>
                        <img src="<?php echo base_url() ."uploads/listing/".$row->picture; ?>" width="30">
                        </a>
                        <div class="clear text-ellipsis"><a class="m-r-sm pull-left play_list_song <?php echo $item_play; ?>" type="<?php echo $row->type; ?>" data-for="<?php echo $data_for; ?>"  href="<?php echo $my_href; ?>" style="width:100%"><span><spanclass="badge bg-info m-l-sm m-t-sm"><?php echo $premium_label; ?></span><?php echo substr($row->title,0,35)?></span><span class="badge bg-info prem-btn m-l-sm m-t-sm"><?php echo $premium_label; ?></span></a></div>
                    <?php }else{?>
                        <a class="m-r-sm pull-left play_list_song <?php echo $item_play; ?>" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title; ?>" data-song="<?php echo $row->file_url; ?>" href="<?php echo $my_href; ?>" type="<?php echo $row->type; ?>" type="<?php echo $row->type; ?>" data-for="<?php echo $data_for; ?>" data-fullText="<?php echo $row->title; ?>" ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }"> <i class="icon-control-play text" style="position: absolute;left: 22px;top: 22px;color:#fff"></i> <i class="icon-control-pause text-active" style="position: absolute;left: 22px;top: 22px;color:#fff"></i><img src="<?php echo base_url() ."uploads/listing/".$row->picture; ?>"  width="30"></a>
                        <div class="clear text-ellipsis"><a class="m-r-sm pull-left play_list_song <?php echo $item_play; ?>" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title; ?>" type="<?php echo $row->type; ?>" data-for="<?php echo $data_for; ?>"   data-song="<?php echo $row->file_url; ?>" href="<?php echo $my_href; ?>" data-fullText="<?php echo $row->title; ?>" ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }" style="width:100%"><span><?php echo substr($row->title,0,35)?></span><span class="badge prem-btn bg-info m-l-sm m-t-sm"><?php echo $premium_label; ?></span></a></div>
                    <?php }?>
				</li>
				<?php ++$count;}?>
                <div class="loader_2" style="margin: 0 auto;text-align: center;display: none">
                    <img src="<?php echo base_url(); ?>uploads/listing/loading_small.gif" width="50" height="50">
                </div>
                <?php }else{
					echo "<li class=\"list-group-item\"><p style='padding-left:15px;'> No Record Found.</p></li>";
				}?>
			</ul>
            
		</div>
        
		<!-- / main --> 
		<!-- right col -->
		<div class="col" id="right_content">
			<div class="wrapper-md">
				<div class="row">
                        
                        <div class="col-xs-12">
                            <h3 class="m-t-none text-black"><?php echo $channelDetail['channel_name']?></h3>
                            <h4 style="padding-left:5px;" class="m-t-none text-black"><?php echo $channelDetail['sales_pitch']?></h4>
                        </div>
                 </div>
                <div class="row">
                    
                    <div class="col-xs-4 col-md-3">
                        <img src="<?php echo base_url()."uploads/profile_pic/".(($channelDetail['picture'])?$channelDetail['picture']:"default-thumbnail.jpg")?>" class=" img-responsive"/>
                    </div>
                   
                    <div class="col-xs-8 col-md-9">
                        <p class="text-muted m-b-md" style="padding-top:10px;"><?php echo $channelDetail['description']?></p>
                        <h4 class="m-b-md">Price: <br>
                        <?php if($channelDetail['channel_subscription_price']==0){echo "Free"; } else{ echo $channelDetail['channel_subscription_price']."$"; } ?>
                        </h4>
                    </div>

                </div>
				
                <div class="row">
                		<hr style=" color:#b4b6bd;"/>
                        <?php if($channelDetail['banner']){?>
                        <div class=" col-xs-12 col-md-12">
                            <img src="<?php echo base_url()."uploads/profile_pic/".$channelDetail['banner']?>" class=" img-responsive"/>
                        </div>
                        <?php }?>
                        
				</div>
                
                <?php if($channelDetail['video']!=""){?>
                <div class="row" style="margin-top:20px;">
                	<div class="col-xs-12">
                    	<!--<video width="100%" height="400" id="myvideo" controls>
                            <source src="<?php echo $channelDetail['video']; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>-->
                        <?php 
							if($channelDetail['video_type']=="embed_code"){ 
								$pos = strpos($channelDetail['video'],'<iframe');
								if($pos === false){
						?>
                        <iframe width="100%" height="315" src="<?php echo $channelDetail['video']; ?>?autoplay=1" frameborder="0" ></iframe>
						<?php	
                            	}else{
									$iframe = $channelDetail['video'];
									$iframe = str_replace('" frameborder="0" ','?autoplay=1" frameborder="0"',$iframe);
									echo $iframe;
						?>
                        <?php }}else{?>
                        <video controls="controls" width="100%" height="400" src="<?php echo $channelDetail['video']?>"></video>
                        <?php }?>	
                    </div>
                </div>
                <?php }?>
				
			</div>
		</div>
		<!-- / right col --> 
	</div>
</div>
<script type="text/javascript">
$("#channel_content_listing").scroll(function() {

    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
        //var value = parseInt(document.getElementById('limit_count').value, 10);
        var value = document.getElementById('limit_count').value;
        var max_limit = $("#max_limit").val();
            value = isNaN(value) ? 0 : value;
    
            my_url = BASE_URL+"user/channeldescription_ajax/"+value;
            var id = <?php echo $id; ?>;

            $.ajax({
                url: my_url,
                type: "get",
                data : {id:id},
                success: function (response) {
                    if (response != "") {
                        $(".loader_2").show().delay(2000).fadeOut();
                    }
                    value = value+5;
                    document.getElementById('limit_count').value = value;
                    setTimeout(function() {
                        $("#channel_content_listing").append(response);
                    }, 2000);
                }
            });
       }
       else{
            return false;
       }
}); 
</script>
<script type="text/javascript">
function filterData(val){
	$("#channel_content_listing").html("<div style='text-align:center'><img src='<?php echo base_url()?>uploads/listing/loading.gif' width='50px'></diiv>");
	$.ajax({
		url: BASE_URL+"/user/filterchanneldescription/<?php echo $channelDetail['id']?>/"+val,
		type: "post",
		data: {"filter":val},
		success: function (response) {
			$("#channel_content_listing").html(response);
		}
	});
}
</script>
<script type="text/javascript">
$(".item_play").click(function () {
var my_url = $(this).attr('data-for');
$.ajax({
    url: my_url,
    type: "POST",
    data : {flag:1},
    success: function (response) {
        $("#right_content").empty();
        $(".loader").show().delay(1000).fadeOut('slow');
        $("#right_content").append(response);
    }
});

});
</script>