<div class="app-content-body ">
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
							<th>Email</th>
							<th>Channel Name</th>
							<th class=" no-link last" colspan="5"><span class="nobr">Action</span></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($producers)>0){
							foreach($producers as $row){ 
						?>
						<tr class="odd pointer">
							<td><?php echo $i++;?></td>
							<td><?php echo $row->email;?></td>
							<td><?php echo $row->channel_name;?></td>
							<td class=" last" nowrap="nowrap" colspan="5">
								<input type="checkbox" class="makeApproved" onClick="return confirm('Are you sure to approve this channel ?')" name="is_approved" value="<?php echo $row->id; ?>">
								<b>Approve? | </b>
								<textarea rows="3" cols="30" userId="<?php echo $row->id; ?>" class="admin_comments" placeholder="Write A comments" name="admin_comments"><?php if ($row->admin_comment && $row->admin_comment != '') { echo $row->admin_comment;} ?></textarea> |
								<a  href="<?php echo base_url(); ?>/admin/Channel/view_channel/<?php echo $row->id; ?>" class="btn btn-info btn-sml">View</a>
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
<script type="text/javascript">

$(".makeApproved").change(function () {
	var BASE_URL = '<?php echo base_url()?>';
	var userId = $(this).val();
	my_url = BASE_URL+"admin/channel/makeProducerApproved";

    $.ajax({
        url: my_url,
        type: "POST",
        data : {userId: userId},
        success: function (response) {
        	if (response != "" && response == 'true') {
        		location.reload();
        	}
        	else {
        		alert('Error while approving');
        	}
        }
    });
}); 


$(".admin_comments").focusout(function () {
	var comment = $(this).val();
	if (comment == '') {
		return false;
	}
	var BASE_URL = '<?php echo base_url()?>';
	var userId = $(this).attr('userId');
	my_url = BASE_URL+"admin/channel/addAdminComment";

	$.ajax({
        url: my_url,
        type: "POST",
        data : {userId: userId, comment:comment},
        success: function (response) {
        	if (response != "" && response == 'true') {
        		
        	}
        	else {
        		alert('Error');
        	}
        }
    });

});
</script>