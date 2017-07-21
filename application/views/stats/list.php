<!-- content -->
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
	</div>
    
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading"> <?php echo $page_heading?> </div>
			<div class="table-responsive">
				<div class="col-md-12"><br />
					<?php $this->load->view('common/messages');?>
				</div>
				<table id="example" class="table table-striped responsive-utilities jambo_table">
					<thead>
						<tr class="headings">
							<th>Title</th>
							<th>Off Site</th>
							<th>In Site</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php if (count($analytics_totalPlays) > 0) { ?>
							<?php foreach($analytics_totalPlays as $key => $row) { ?>
							<tr class="odd pointer">
								<td><?php echo $row['title']; ?></td>
								<td><?php echo $row['inSite']; ?></td>
								<td><?php echo $row['offSite']; ?></td>
								<td><?php echo $row['date']; ?></td>
							</tr>
							<?php } ?>
						<?php } else { ?>
							<tr>
								<td colspan="4">No records Found</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
