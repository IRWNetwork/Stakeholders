<?php //echo "<pre>"; print_r($banners);exit; ?>
<?php foreach ($banners as $banner) { ?>
<div class="col-md-12">
	<div class="col-md-5">
		<img src="<?php echo base_url(); ?>/uploads/banners/<?php echo $banner['banner_file']; ?>" width="350">
	</div>
	<div class="col-md-7">
		<div class="col-md-12">
			<p><b>URL: </b><?php echo $banner['url']; ?></p>
			<p><b>Targer: </b><?php echo $banner['target']; ?></p>
			<p><b>Alt Text: </b><?php echo $banner['alt']; ?></p>
		</div>
		<div class="col-md-12">
			<form method="post" action="<?php echo base_url();?>admin/zones/save_booking" id="demo-form2" class="form-horizontal form-label-left" novalidate>
			<table class="table table-striped responsive-utilities jambo_table">
				<tr>
					<input type="hidden" name="zoneid" value="<?php echo $zoneid; ?>">
					<input type="hidden" name="bannerid" value="<?php echo $banner['id']; ?>">
					<td>Limit impression to:</td>
					<td><input type="text" name="impressions_booked" /></td>
				</tr>
				<tr>
					<td>Limit clicks to:</td>
					<td><input type="text" name="clicks_booked" /></td>
				</tr>
				<tr>
					<td>Weight:</td>
					<td><input type="text" name="weight" /></td>
				</tr>
				<tr>
					<td>Active This Banner:</td>
					<td><input type="checkbox" name="status" value="active"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button type="submit" class="btn btn-primary">Submit</button></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>
<?php } ?>