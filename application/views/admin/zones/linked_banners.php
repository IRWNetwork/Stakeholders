<?php //echo "<pre>"; print_r($banners);exit; ?>
<!-- content -->
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_title;?></h1>
	</div>
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading">
			<?php echo $page_heading?>
			<a href="<?php echo base_url() ?>admin/zones/link_banner/<?php echo $zone_id; ?>"" class="btn btn-primary btn-sm pull-right">Link Banner</a>
			</div>
			<div class="table-responsive">
				<div class="col-md-12"><br />
					<?php $this->load->view('admin/common/messages');?>
				</div>
				<?php if (count($banners) > 0) { ?>
					<?php foreach ($banners as $banner) { ?>
				<div class="col-md-12">
					<div class="col-md-6">
						<span><b>test (2482x3507)</b></span>
					</div>
					<div class="col-md-6">
						<span class=" pull-right">
							<b>Activated On: <?php echo date('Y-m-d', $banner->date_activated); ?></b>
						</span>
					</div>
				</div>
				
				<div class="col-md-12" style="background-color: #ccc">
					<div class="col-md-6">
						<img src="<?php echo base_url();?>/uploads/banners/<?php echo $banner->banner_file; ?>" width="350">
					</div>
					<div class="col-md-6">
						<div class="col-md-6">
							<p><b>URL:</b> <?php echo $banner->url; ?></p>
							<p><b>CLICK:</b> <?php echo $banner->clicks_booked; ?></p>
							<p><b>Target:</b> <?php echo $banner->target; ?></p>
							<p><b>Alt Text:</b> <?php echo $banner->alt; ?></p>
						</div>
						<table class="table responsive-utilities">
							<tr>
								<td>Impressions Booked:</td>
								<td><?php echo $banner->impressions_booked; ?></td>
							</tr>
							<tr>
								<td>Impressions Performed:</td>
								<td><?php echo $banner->impressions_performed; ?></td>
							</tr>
							<tr>
								<td>Clicks Booked:</td>
								<td><?php echo $banner->clicks_booked; ?></td>
							</tr>
							<tr>
								<td>Clicks Performed:</td>
								<td><?php echo $banner->clicks_performed; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
								<a href="<?php echo base_url();?>/admin/zones/unlink_banner/<?php echo $banner->bannerid; ?>" class="btn btn-primary btn-sm">unlink This Banner</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<?php } ?>
				<?php }  else {?>
					<div class = "col-md-12">No Banners Found</div>
				<?php } ?>					
			</div>
		</div>
	</div>
</div>
