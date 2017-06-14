<!-- content -->
<?php //echo "<pre>"; print_r($channels);exit; ?>
<script type="text/javascript">
    function formSubmit(e){
        if(e.keyCode === 13){
            $('#search').submit();

        }
    }
    function filter_users_form(val) {
		$('#search').submit();    	
    }
</script>
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<div class="row">
			<div class="col-md-3">
				<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
			</div>
			<div class="col-md-4">
			    <div class="input-group">
			      <span class="input-group-addon input-sm"><i class="fa fa-search"></i></span>
			      <form id="search" method='post' name="frm">
			      	<input name="name" onkeypress="formSubmit(event)"  class="form-control input-sm ng-pristine ng-valid ng-empty ng-touched" placeholder="search" aria-invalid="false" type="text" id="name">
			    </div>
		    </div>
		    <div class="col-md-2">
			    <div class="input-group">
				  <?php 
				  		$options = array(
						        ''         => 'Filer By Type',
						        '2'           => 'User',
						        '3'         => 'Channel',
						        '4'        => 'Advertiser',
						);
						echo form_dropdown('shirts', $options, $type, 'class="form-control m-b" id="type"');
				  ?>
			    </div>
		    </div>
		    <div class="col-md-3">
				<input type="submit"  class="btn btn-info btn-md" value="Search" name="search">
		    </div>
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
							<th>Email</th>
							<th>Type</th>
							<th>Brand Name</th>
							<th>Channel Name</th>
                            <th>Sort Order</th>
                            <th>Subscription Price</th>
                            <th>Deleted</th>
<!--                             <th>Created Date</th> -->
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
							<td><?php echo $row->email;?></td>
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
<!-- 							<td><?php //echo date("m-d-Y",$row->created_on);?></td> -->
							<td class=" last" nowrap="nowrap">
							<a href="<?php echo base_url()?>admin/channel/editcontent?id=<?php echo $row->id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a> <a href="<?php echo base_url()?>admin/channel/deletecontent/<?php echo $row->id?>" class="btn btn-danger btn-xs"  onClick="return confirm('User will be permanently Deleted. Are you sure to delete this channel ?')" >Delete </a>
							<a href="<?php echo base_url()?>admin/channel/viewDetails?id=<?php echo $row->id?>" class="btn btn-success btn-xs">Details</a>
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

	$('#search').on('submit', function(e){

		e.preventDefault();
		var BASE_URL = '<?php echo base_url()?>';
		var flag = 1;
		var type = $('#type').val();
		var name = $('#name').val();

		my_url = BASE_URL+"admin/channel/user_filter";

	    $.ajax({
	        url: my_url,
	        type: "POST",
	        data : {flag : flag, type: type, name: name},
	        success: function (response) {
	        	if (response != "") {
	        		$(".table-responsive").empty();
	        		$(".table-responsive").append(response);
	        	}
	        }
	    });

	});
</script>
