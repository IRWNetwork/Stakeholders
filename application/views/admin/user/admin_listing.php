<!-- content -->
<?php //echo "<pre>"; print_r($admins);exit; ?>
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
	</div>
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php echo $page_heading?> 
				<a href="<?php echo base_url()?>admin/users/add_admin" class="btn btn-info pull-right">Create Admin</a>
			</div>
			<div class="table-responsive">
				<div class="col-md-12"><br />
					<?php $this->load->view('admin/common/messages');?>
				</div>
				<table id="example" class="table table-striped responsive-utilities jambo_table">
					<thead>
						<tr class="headings">
							<th>&nbsp;</th>
							<th>Image</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>User Name</th>
							<th class=" no-link last"><span class="nobr">Action</span></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($admins)>0){
							foreach($admins as $row){
						?>
						<tr class="odd pointer">
							<td><?php echo $i++;?></td>
							<td><?php if($row->picture!=''){?>
								<img style="width: 62px;height: 62px;" src="<?php echo base_url()?>uploads/listing/<?php echo $row->picture?>" />
								<?php }?></td>
							<td><?php echo $row->first_name; ?></td>
							<td><?php echo $row->last_name; ?></td>
							<td><?php echo $row->username; ?></td>
							<td class=" last" nowrap="nowrap"><a href="<?php echo base_url()?>admin/users/edit_admin/<?php echo $row->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a></td>
						</tr>
						<?php }}else{?>
						<tr>
							<td colspan="7">No Record Found</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<div class="col-md-12"><?php// echo $links; ?></div>
			</div>
		</div>
	</div>
</div>
