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
							<th style="width:45%">Title</th>
							<th>Slug</th>
							<th align="right" class=" no-link last"><span class="nobr">Action</span></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($pages as $page){?>
						<tr class="odd pointer">
							<td class=""><?php echo $page->title;?></td>
							<td><?php echo $page->slug?></td>
							<td class=""><?php echo $page->seo_url?></td>
							<td align="left" class=" last">
								<a href="<?php echo base_url()?>admin/pages/edit?id=<?php echo $page->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> 
								<a href="<?php echo base_url()?>admin/pages/delete/<?php echo $page->id?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure to delete this user ?')"><i class="fa fa-trash-o"></i> Delete </a>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
