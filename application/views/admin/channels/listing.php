<!-- content -->
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
         <div style=" margin-top:-24px;float:right; width:40%;" class="input-group">
          <span class="input-group-addon input-sm"><i class="fa fa-search"></i></span>
          <form id="search" method='post'>
          	<input name="name" onkeypress="formSubmit(event)"  class="form-control input-sm ng-pristine ng-valid ng-empty ng-touched" placeholder="search" aria-invalid="false" type="text">
          </form>  
        </div>
         <div style=" margin-top:-24px;float:right; width:30%;margin-right: 50px;" class="input-group">
		  <select name="type" class="form-control m-b" id="type" onchange="filter_users(this.value)">
				<option value="">Filer By Type</option>
				<option value="2">User</option>
				<option value="3">Channel</option>
				<option value="4">Advertiser</option>
		  </select>
        </div>
        <div style=" margin-top:-24px;width:10%;margin-right: 50px;float: right;" class="input-group">
		  <a href="" class="btn btn-info btn-sm">Clear Filter</a>
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
                            <th>Created Date</th>
							<th class=" no-link last"><span class="nobr">Action</span></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($channels)>0){
							foreach($channels as $row){
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
		</div>
	</div>
</div>
<script type="text/javascript">
	function filter_users(type) {
		var BASE_URL = '<?php echo base_url()?>';
		var flag = 1;

		my_url = BASE_URL+"admin/channel/user_filter";

	    $.ajax({
	        url: my_url,
	        type: "POST",
	        data : {flag : flag, type: type},
	        success: function (response) {
	        	if (response != "") {
	        		$(".table-responsive").empty();
	        		$(".table-responsive").append(response);
	        	}
	        }
	    });
	}
</script>
