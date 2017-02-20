<!-- content -->
<script type="text/javascript">
	function showCodeWindow(id){
		var win_width="655px";
		var win_height="300px";	
	
		var l= (screen.width - parseInt(win_width))/2 + "px";
		var t= (screen.height - parseInt(win_height))/2 +"px";
	
		var features='width='+win_width+',height='+win_height+',menubar=0,locationbar=0,scrollbars=1,left='+l+',top='+t;
		var w=window.open('scripts/getcode.php?zoneid='+id,'win1',features);
		w.focus();
	}
</script>
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
							<th>Zone</th>
							<th align="right" class=" no-link last"><span class="nobr">Options</span></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($zones as $zone){?>
						<tr class="odd pointer">
							<td class=""><?php echo $zone->id;?></td>
							<td><?php echo $zone->name . " (".$zone->width . ' x '. $zone->width .")"?></td>
							<td align="left" class=" last" nowrap="nowrap">
								<a href="javascript:showCodeWindow(<?php echo $zone->id; ?>)"  class="btn btn-info btn-xs">Get Code</a>
								<a href="<?php echo base_url()?>/<?php echo $zone->id?>" class="btn btn-info btn-xs">Linked Banners </a> 
								<a href="<?php echo base_url()?>/<?php echo $zone->id?>" class="btn btn-info btn-xs">Delete </a> 
								<a href="<?php echo base_url()?>/<?php echo $zone->id?>" class="btn btn-info btn-xs">Rename </a>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
