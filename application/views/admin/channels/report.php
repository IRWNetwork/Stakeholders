<?php //echo "<pre>";print_r($report_array);die(); ?>
<style type="text/css">
	.link_label a:hover{
		color: #23b7e5;
	}
</style>
<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url()?>assets/css/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui-timepicker-addon.js"></script>
<div class="app-content-body ">
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-2">
						<?php echo $page_heading?>
					</div>
					<form method="post" name="frm">
						<div class="col-md-3">
							<input type="text" name="name" value="<?php echo $search_name; ?>" class="form-control input-sm" placeholder="Search By Channel">
						</div>
						<div class="col-md-2">
							<input type="text" name="date_from" value="<?php echo $date_from; ?>" class="form-control show_date input-sm" placeholder="Date Of Charge From">
						</div>
						<div class="col-md-2">
							<input type="text" name="date_to" value="<?php echo $date_to; ?>"  class="form-control show_date input-sm" placeholder="Date Of Charge To">
						</div>
						<div class="col-md-1">
							<input type="submit" class="btn btn-info btn-md" value="Search" name="search">
					    </div>
					</form>
				</div>
			</div>
			<table id="example" class="table table-striped responsive-utilities jambo_table">
			<tr>
				<th>Channel Name</th>
				<th>No Of people Who Paid</th>
				<th>Total Sales</th>
				<th>Producer's Royalty</th>
				<th>IRW Fee</th>
			</tr>
			<?php foreach ($report_array as $key => $report) : ?>
			<tr class="link_label">
				<td><a href="<?php echo base_url().'admin/channel/producer_detail_report/'. $report['channel_id'] ?>"><?php echo $report['channel_name']; ?></a></td>
				<td><?php echo $report['total_users_who_paid']; ?></td>
				<td>$<?php echo round ($report['total_amount'], 2); ?></td>
				<td>$<?php echo round ($report['producer_royalty'], 2); ?></td>
				<td>$<?php echo round ($report['irw_amount'], 2); ?></td>
			</tr>
			<?php endforeach; ?>
			<tfoot>
				<tr>
					<th>Total</th>
					<td>&nbsp;</td>
					<?php foreach ($sum_of_all as $key => $all): ?>
						<td><b>$<?php echo round ($all, 2); ?></b></td>
					<?php endforeach; ?>
				</tr>
			</tfoot>
		</table>
		</div>
		
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.show_date').datepicker({
		dateFormat: 'yy-mm-dd'
	});
});
</script>	