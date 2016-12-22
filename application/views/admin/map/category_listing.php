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
							<th>Sr#</th>
							<th>Title</th>
							<th class=" no-link last"><span class="nobr">Action</span></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($categories)>0){
							foreach($categories as $row){
						?>
						<tr class="odd pointer">
							<td><?php echo $i++;?></td>
							<td><?php echo $row->name?></td>
							<td class=" last" nowrap="nowrap"><a href="<?php echo base_url()?>admin/categories/edit?id=<?php echo $row->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> 
							<a href="<?php echo base_url()?>admin/categories/delete?id=<?php echo $row->id?>" onClick="return confirm('Are you sure to delete this ?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a></td>
						</tr>
						<?php }}else{?>
						<tr>
							<td colspan="7">No Record Found</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<div class="col-md-12"><?php echo $links; ?></div>
			</div>
		</div>
	</div>
</div>
