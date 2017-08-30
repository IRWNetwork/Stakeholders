<style>
@media (max-width:1024px){
#footer{margin-top: 688px !important;}
}

@media (max-width: 768px){
	#footer {
		margin-top: 360px !important;
	}
}


@media (max-width: 414px){
	#footer {
		margin-top: 142px !important;
	}
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
<br />
<div class="col-sm-12">
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
	<div class="blog-post">
		<div class="panel no-border">
			<div class="wrapper-lg">
				<h2 class="m-t-none">FAQ</h2>
				<br />
				<?php foreach($Allfaq as $row){?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $row->id?>">
							<div class="row">
								<div class="col-md-9">
									<h4 class="panel-title">
										<?php echo $row->question?>
									</h4>
								</div>
								<div class="col-md-3 text-right"><i class="fa fa-chevron-down"></i></div>
							</div>
						</a>
					</div>
					<div id="<?php echo $row->id?>" class="panel-collapse collapse">
						<div class="panel-body">
							<?php echo $row->answer?>
						</div>
					</div>
				</div>
				<?php }?>
                <h3>Contact IRW</h3>
                <p>You can reach IRWNetwork for most purposes at CS@IRWNetwork.com</p>
				<p>IRW network is a subsidiary of Binge Indy, LLC</p>
				<!-- <p>Columbia, TN 38401 </p> -->
                <!-- <p>Phone: 9316262045</p> -->
			</div>
		</div>
	</div>
</div>
<style>
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {

        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colorbox.css" type="text/css" />
<script src="<?php echo base_url()?>assets/js/jquery.colorbox.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function(){
		$.colorbox({
			iframe:true,
			innerWidth:"50%",
			innerHeight:"70%",
			href: "<?php echo base_url()?>home/pagePopup?page=faq",
		});
	},4000);
});