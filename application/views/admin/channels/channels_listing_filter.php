<?php //echo "<pre>"; print_r($channels);exit; ?>
<table id="example" class="table table-striped responsive-utilities jambo_table">
	<thead>
		<tr class="headings">
			<th>&nbsp;</th>
			<th>Email</th>
			<th>Type</th>
			<th>Brand Name</th>
			<th>Channel Name</th>
            <th>Sort Order</th>
            <th>Subscription Price</th>
            <th>Deleted</th>
            <th>Created Date</th>
			<th class=" no-link last"><span class="nobr">Action</span></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=1;
			if(count($channels)>0){
			foreach($channels as $row){
				if ($row->group_id == 3 && $row->is_approved == 0) {
					continue;
				}
		?>
		<tr class="odd pointer">
			<td><?php echo $i++;?></td>
			<td><?php echo $row->username;?></td>
			<td><?php 
				if($row->group_id == 2) {
					echo "Users"; 
				}
				elseif ($row->group_id == 3) {
					echo "Producer";
				}
				else {
					echo "Advertiser";
				}?>
			</td>
			<td><?php echo $row->brand_name;?></td>
			<td><?php echo $row->channel_name;?></td>
            <td><?php echo $row->sorting;?></td>
            <td><?php echo $row->channel_subscription_price;?></td>
            <td><?php echo ($row->is_deleted == 1) ? "Yes" : "No" ; ?></td>
			<td><?php echo date("m-d-Y",$row->created_on);?></td>
			<td class=" last" nowrap="nowrap"><a href="<?php echo base_url()?>admin/channel/editcontent?id=<?php echo $row->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> <a href="<?php echo base_url()?>admin/channel/deletecontent/<?php echo $row->id?>" class="btn btn-danger btn-xs"  onClick="return confirm('Are you sure to delete this channel ?')" >Delete </a></td>
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