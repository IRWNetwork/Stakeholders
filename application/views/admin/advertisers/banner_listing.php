<!-- content -->
<?php //echo "<pre>"; print_r($banners); exit;?>
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
	</div>
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php echo $page_heading?> 
				<a href="<?php echo base_url(); ?>admin/advertisers/new_banner/<?php echo $advertiser_id; ?>" class="btn btn-primary btn-sm pull-right">
					New Banner
				</a>
			</div>
			<div class="table-responsive">
				<div class="col-md-12"><br />
					<?php $this->load->view('admin/common/messages');?>
				</div>
				<table id="example" class="table table-striped responsive-utilities jambo_table">
					<thead>
						<tr class="headings">
							<th>&nbsp;</th>
							<th>Name</th>
							<th>Type</th>
							<th>Banner</th>
							<th>URL</th>
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
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['type'];?></td>
                            <td>
							<?php if ($row['banner_file'] != '') { ?>
                            <img src="<?php echo base_url()."uploads/banners/".$row['banner_file'];?>" width="60" height="60"/>
							<?php } ?>
							</td>
							<td><?php echo $row['url'];?></td>
							<td class=" last" nowrap="nowrap"><a href="<?php echo base_url()?>admin/banner/changebanner/<?php echo $row['id']?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a></td>						</tr>
						<?php }}else{?>
						<tr>
							<td colspan="6">No Record Found</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<div class="col-md-12"><?php //echo $links; ?></div>
			</div>
		</div>
	</div>
</div>
