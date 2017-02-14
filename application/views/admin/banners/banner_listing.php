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
							<th>&nbsp;</th>
							<th>Banner Link</th>
							<th>Banner Page</th>
							<th>Banner Image</th>
							<th>Link Target Value</th>
							<th class=" no-link last"><span class="nobr">Action</span></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($banners)>0){
							foreach($banners as $row){
						?>
						<tr class="odd pointer">
							<td><?php echo $i++;?></td>
							<td><?php echo $row->banner_link;?></td>
							<td><?php echo $row->page;?></td>
                            <td><img src="<?php echo base_url()."uploads/banner_images/thumb_153_".$row->banner_image;?>"/></td>
							<td><?php echo $row->target;?></td>
							<td class=" last" nowrap="nowrap"><a href="<?php echo base_url()?>admin/banner/changebanner?id=<?php echo $row->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a></td>						</tr>
						<?php }}else{?>
						<tr>
							<td colspan="6">No Record Found</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<div class="col-md-12"><?php echo $links; ?></div>
			</div>
		</div>
	</div>
</div>
