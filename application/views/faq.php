<br />
<div class="col-sm-12">
<?php if(count($bannerDetail)>0){?>
 <div style="margin-bottom:25px;" class="row">
    <div class="col-xs-12">
    <a href="<?php echo $bannerDetail["banner_link"]?>" target="<?php echo $bannerDetail['target'];?>">
        <img src="<?php echo base_url()."uploads/banner_images/".$bannerDetail["banner_image"]?>" class="img-responsive"  /></a>
    </div>
  </div>
  <?php }?>
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