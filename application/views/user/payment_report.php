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
				</div>
			</div>
			<table id="example" class="table table-striped responsive-utilities jambo_table">
			<tr>
				<th>User Name</th>
				<th>Email</th>
				<th>Amount</th>
				<th>Date of Charge</th>
			</tr>
			<?php foreach ($all_records as $key => $report) : ?>
			<tr class="link_label">
				<td><?php echo $report['username']; ?></td>
				<td><?php echo $report['email']; ?></td>
				<td>$<?php echo $report['amount']; ?></td>
				<td>$<?php echo $report['date_of_charge']; ?></td>
			</tr>
			<?php endforeach; ?>
			<tfoot>
				<tr>
					<th>Your Total Royalties This Period</th>
					<td>&nbsp;</td>
					<td><b>$<?php echo round($sum_of_amount, 2); ?></b></td>
					<td>&nbsp;</td>
				</tr>
			</tfoot>
		</table>
		</div>
		
	</div>
</div>