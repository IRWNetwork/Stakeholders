<!-- content -->
<?php //echo "<pre>"; print_r($contents);exit; ?>
<script type="text/javascript">
    function formSubmit(e){
        if(e.keyCode === 13){
            $('#search').submit();

        }
    }
</script>
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
        <div style=" margin-top:-24px;float:right; width:40%" class="input-group">
          <span class="input-group-addon input-sm"><i class="fa fa-search"></i></span>
          <form id="search" method='post'>
          	<input name="name" onkeypress="formSubmit(event)"  class="form-control input-sm ng-pristine ng-valid ng-empty ng-touched" placeholder="search" aria-invalid="false" type="text">
          </form>  
        </div>
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
							<th>File</th>
							<th>Title</th>
							<th>Avg Time Listen</th>
							<th>Type</th>
							<th>Is Premium</th>
							<th>Featured</th>
							<th class=" no-link last"><span class="nobr">Action</span></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($contents)>0){
							foreach($contents as $row){
						?>
						<tr class="odd pointer">
							<td><?php echo $i++;?></td>
							<td><?php if($row->picture!=''){?>
								<img style="width: 62px;height: 62px;" src="<?php echo base_url()?>uploads/listing/<?php echo "thumb_153_".$row->picture?>" />
								<?php }?></td>
							<td><?php echo $row->title?></td>
							<td><?php if ($row->type == 'Podcasts') {
									//echo gmdate("H:i:s", $row->play_time);
									$count = $row->listenCount;
									if ($count > 0) {
										$abc = (gmdate("H:i:s", $row->play_time))/$count;
										echo gmdate("H:i:s", $abc);

									}
									else {
										echo gmdate("H:i:s", 0);
									}
								} ?></td>
							<td><?php echo $row->type?></td>
							<td><?php echo ($row->is_premium == 'yes') ?  'Yes' : 'No' ?></td>
							<td><?php echo ($row->is_featured == 'yes') ? 'Yes' : 'No' ?></td>
							<td class=" last" nowrap="nowrap">
                            	<?php if($row->is_featured=='yes'){?>
                                <a href="<?php echo base_url()?>admin/content/unfeatured/<?php echo $row->id?>" class="btn btn-primary btn-xs"><i class="fa fa-times"></i> Unfeature </a>
                                <?php }else{?>
                                <a href="<?php echo base_url()?>admin/content/featured/<?php echo $row->id?>" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> Make Feature </a>
                                <?php }?>
                                
                                <a href="<?php echo base_url()?>admin/analytics/?id=<?php echo $row->id?>" class="btn btn-info btn-xs"><i class="fa fa-flask"></i>Analytics</a>
                            	<a href="<?php echo base_url()?>admin/content/editcontent?id=<?php echo $row->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> 
                                <a href="<?php echo base_url()?>admin/content/delete?id=<?php echo $row->id?>" onClick="return confirm('Are you sure to delete this product ?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete </a>
                           	</td>
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
