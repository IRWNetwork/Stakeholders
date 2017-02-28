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
							<th>Channel Name</th>
							<th>Price</th>
							<th>Purchase Date</th>
							<th>Expire Date</th>
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
							<td><?php echo $row->channel_name ;?></td>
							<td><?php echo $row->amount?>$</td>
							<td><?php echo $row->date?></td>
							<td><?php echo $row->next_recharge_date?></td>
                            <td class=" last" nowrap="nowrap"><a href="<?php echo base_url()?>user/unsubscribechannel?id=<?php echo $row->channel_id?>" onClick="return confirm('Are you sure to unsubscribe this channel ?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Unsubscribe </a></td>
						</tr>
						<?php }}else{?>
						<tr>
							<td colspan="5">You have not subscribe any channel.</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<div class="col-md-12"><?php echo $links; ?></div>
			</div>
		</div>
	</div>
</div>
