<script type="text/javascript">
$(document).ready(function(){
	$('.bxslider').bxSlider({
		pager: false,
		auto: true,
		pause: 9000
	});
});
</script>
<br />
<?php if(count($bannerDetail)>0){?>
<div style="padding: 20px 20px 0 20px;" class="row">
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
