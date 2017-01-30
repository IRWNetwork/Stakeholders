<!-- content -->

<div class="app-content-body ">
    <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
    </div>
    <div class="wrapper-md">
       <!-- <div class="panel panel-default">
           <div class="panel-heading"> <?php echo $page_heading?> </div>
         </div> -->
         <div class="row">
         	<div class="col-xs-12"><img src="<?php echo base_url()?>assets/images/Marketplace_Banner.png" class="img-responsive"  /></div>
          </div>
            <div class="row-fluid" >
            <?php foreach( $ContentList as $list){ ?>
                <div class="col-md-4" style="margin-top:15px;" >
                <div class="row">
                	<div class="col-md-11" style="background-color:#4d4d4d; padding-top:6px; box-shadow: 2px 4px 5px 4px #a6a6a6;">
                        <div class="row-fluid">
                            <div class="col-xs-5"> 
                                <a href="<?php echo base_url()."user/channeldescription/".$list['id']; ?>">
                                    <img src="<?php echo base_url()."uploads/profile_pic/".$list['picture']?>" class=" img-responsive"/>
                                    
                                 </a>
                            </div>
                            <div class="col-xs-7">
                                <button  type="button"  style="padding: 3px 10px; color:#fff;background-color:#F60;"class="btn">Subscribe Now!</button>
                                <h3 style="color:#fff;">$<?php echo $list['channel_subscription_price']; ?> / mo</h3>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <h3 class="col-xs-12" style="color:#fff;">
                            <a href="<?php echo base_url()."user/channeldescription/".$list['id']; ?>">
                            	<?php echo $list['channel_name']; ?>
                             </a>
                            </h3>
                            <p class="col-xs-12" style="color:#fff;">Audio/Podcasts: <?php if(isset($list['PodcastsTotal'])){ echo $list['PodcastsTotal']; } else{ echo '0';}?><br>                                Video: <?php if(isset($list['VideoTotal'])){ echo $list['VideoTotal']; } else{ echo '0';}?><br>
                                Editorial: <?php if(isset($list['TextTotal'])){ echo $list['TextTotal']; } else{ echo '0';}?>
                             </p>
                        </div>
                	</div>
                   </div>
                </div>             
                <?php } ?>
            </div>
        
    </div>
</div>
