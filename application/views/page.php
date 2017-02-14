
<br />
<?php if(count($bannerDetail)>0){?>

<div class="col-xs-12">
    <a href="<?php echo $bannerDetail["banner_link"]?>" target="<?php echo $bannerDetail['target'];?>">
    <img src="<?php echo base_url()."uploads/banner_images/".$bannerDetail["banner_image"]?>" class="img-responsive"  /></a>
</div>
 
<?php }?>

<div class="col-sm-12">
    <div class="blog-post">
        <div class="panel no-border">
            <div class="wrapper-lg">
                <h2 class="m-t-none"><a href=""><?php echo $pagerow['title'] ?></a></h2>
                <div>
                    <p><?php echo $pagerow['body']?></p>
                </div>
            </div>
        </div>
    </div>
</div>
