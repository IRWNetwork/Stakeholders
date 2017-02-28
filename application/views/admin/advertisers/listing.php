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
					<?php $this->load->view('admin/common/messages');?>
				</div>
				<table id="example" class="table table-striped responsive-utilities jambo_table">
					<thead>
						<tr class="headings">
							<th>Serial</th>
							<th>Full Name</th>
							<th>Email</th>
							<th align="right" class=" no-link last"><span class="nobr">Options</span></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($advertisers as $advertiser) { ?>
						<tr class="odd pointer">
							<td><?php echo $advertiser->id; ?></td>
							<td><?php echo $advertiser->fullname; ?></td>
							<td><?php echo $advertiser->email; ?></td>
							<td align="left" class=" last" nowrap="nowrap">
								<a href="<?php echo base_url()?>admin/advertisers/edit_advertiser/<?php echo $advertiser->id?>" class="btn btn-info btn-xs">Edit</a> 
								<a href="<?php echo base_url()?>admin/advertisers/delete_advertiser/<?php echo $advertiser->id?>" class="btn btn-info btn-xs" onClick="return confirm('Are you sure to delete ?')">Delete</a> 
								<a href="<?php echo base_url()?>admin/advertisers/view_banners/<?php echo $advertiser->id?>" class="btn btn-info btn-xs">View Banner</a> 
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
