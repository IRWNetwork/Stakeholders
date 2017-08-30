<!-- content -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.1.1/jquery-confirm.min.css">
<style>
@media(max-width:1366px){
.for-width {max-width:102.5%;}
}

@media(max-width:1024px){
.for-tab-height{height: 285px;}
.for-margin-top{margin-top:0px;}
}

@media(max-width:768px){
.for-width {max-width:104%;}
}

@media(max-width:414px){
.for-width {max-width:106%;}
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('.bxslider').bxSlider({
		pager: false,
		auto: true,
		pause: 9000
	});
});
</script>
<div class="app-content-body ">
    <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
    </div>
    <div class="wrapper-md">
       <!-- <div class="panel panel-default">
           <div class="panel-heading"> <?php echo $page_heading?> </div>
         </div> -->
         
          	<?php if(count($bannerDetail)>0){?>
            <div class="row for-height">
                <div class="col-xs-12">
                    <ul class="bxslider">
                        <?php foreach($bannerDetail as $banner_row){ ?>
                        <li>
                            <a href="<?php echo $banner_row["banner_link"]?>" target="<?php echo $banner_row['target'];?>">
                                <img src="<?php echo base_url()."uploads/banner_images/".$banner_row["banner_image"]?>" class="img-responsive" />
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
             </div>
            <?php } ?>
            <div class="row-fluid" >
            <?php $i=0; foreach( $ContentList as $list){ 

                //print_r($list);
                $list[$list['type'].'Total'] = $list['TOTAL'];
                ?>
                <div class="col-md-4 col-xs-12 for-tab-height" style="display:inline-block; min-height: 220px; margin-top:15px;background-color:#4d4d4d; padding-top:6px; box-shadow: 2px 4px 5px 4px #a6a6a6;" >
                	<div class="col-md-11">
                            <div class="col-xs-5"> 
                                <a href="<?php echo base_url()."user/channeldescription/".$list['id']; ?>">
                                    <img src="<?php echo base_url()."uploads/profile_pic/".(($list['picture'])?$list['picture']:"default-thumbnail.jpg")?>" class=" img-responsive"/>
                                 </a>
                            </div>
                            <div class="col-xs-7">
                                 <?php $subscribe_text = "Subscribe Now"; ?>
                                 <?php $a_event        =  base_url() . "user/channelsubscription/".$list['id'];?>
                                 <?php $onclick_log    =  "";?>
                            	 <?php 

								 		if($this->Common_model->checkAlreadyBuy($list['id'])){
                                    	$subscribe_text = "Subscribed";
                                        $a_event     = "javascript:void(0)";
                                        }

									   if (!$this->ion_auth->logged_in()){
                                    	$onclick_log = "click_login()";
                                      	$a_event     = "javascript:void(0)";
                                    }

                                 ?>

                                <?php if($list['stripe_user_id'] != '' && $list['id'] != 555){ ?>

                                        <?php if($this->Common_model->checkAlreadyBuy($list['id'])){ ?>
                                        <a href="<?php echo base_url()."user/channelsubscription/".$list['id']; ?>">
                                            <button   type="button"  style="padding: 3px 10px; color:#fff;background-color:#F60;"class="btn"><?php echo $subscribe_text; ?></button>
                                        </a>
                                        <?php }else{ ?>
                                        <?php //echo base_url()."user/channelsubscription/".$list['id']; ?>
                                        <a href="<?php echo base_url()."user/channelsubscription/".$list['id']; ?>">
                                            <button   type="button"  style="padding: 3px 10px; color:#fff;background-color:#F60;"class="btn"><?php echo $subscribe_text; ?></button>
                                        </a>
                                        <?php } ?>

                                <?php } /*else{ ?>
	                                <?php //echo base_url()."user/channeldescription/".$list['id']; ?>
                                    <a href="<?php echo base_url()."user/channeldescription/".$list['id']; ?>">
                                        <button   type="button"  style="padding: 3px 10px; color:#fff;background-color:#F60;"class="btn"><?php echo $subscribe_text; ?></button>
                                    </a>
                                <?php }*/?>
								<?php if($list['stripe_user_id'] != '' && $list['id'] != 555){ ?>
                                <h3 style="color:#fff;">$<?php echo $list['channel_subscription_price']; ?> / mo</h3>
                                <?php }else{?>
                                <h3 style=" color:#fff;">Content Free Until Launch!</h3>
                                <?php }?>
                            </div>                       
                        <div class="col-xs-12">
                            <h3 class="col-xs-12 for-margin-top" style="color:#fff; margin-top:0px !important;">
                            <a style="font-size:17px; font-weight: bold;" href="javascript:void(0)" data-for="<?php echo base_url() . "user/channeldescription/".$list['id']; ?>" class="channel_area">
                            	<?php echo $list['channel_name']; ?>
                             </a>
                            </h3>
                            <p class="col-xs-12" style="color:#fff;">Audio/Podcasts: <?php if(isset($list['PodcastsTotal'])){ echo $list['PodcastsTotal']; } else{ echo '0';}?><br>Video: <?php if(isset($list['VideoTotal'])){ echo $list['VideoTotal']; } else{ echo '0';}?><br>
                                Editorial: <?php if(isset($list['TextTotal'])){ echo $list['TextTotal']; } else{ echo '0';}?>
                             </p>
                             <a href="<?php echo base_url()."user/channeldescription/".$list['id']; ?>">
                                <button   type="button"  style="padding: 3px 10px; color:#fff;background-color:#F60;"class="btn">View Channel</button>
                            </a>
                            <br /><br />
                        </div>
                	</div>
                  
                </div>             
                <?php
					$i=$i+1;
					if($i%3==0){ ?>
                    <div class="clearfix"></div>
					
					<?php }
				 } ?>
            </div>
        
    </div>
</div>
<script type="text/javascript">
$(".channel_area").click(function () {
var my_url = $(this).attr('data-for');
$.ajax({
    url: my_url,
    type: "POST",
    data : {flag:1},
    success: function (response) {
        $("#content").empty();
        $(".loader").show().delay(1000).fadeOut('slow');
        $("#content").append(response);
        history.pushState(null, null, my_url);
    }
});

});
function click_login(){
    $.dialog({
    title: '',
    content: 'You are not logged in. Please log in to complete this process click <a href="<?php echo base_url()?>user/login" style="color:lightblue">here</a>',
});
}
</script>