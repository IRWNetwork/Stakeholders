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
                            <?php if($this->ion_auth->in_group(3)){?>
                            <th>Purchased By</th>
                            <?php }else{?>
                            <th>Channel Name</th>
                            <?php }?>
							<th>Total Amount</th>
							<th>IRW Amount</th>
							<th>Producer Royality</th>
							<th>Purchase Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($payment_logs)>0){
							foreach($payment_logs as $row){

						?>
						<tr class="odd pointer">
							<td><?php echo $i++;?></td>
                            <?php if($this->ion_auth->in_group(3)){?>
                            <td><?php echo $this->Users_model->getUserName($row->user_id);?></td>
                            <?php }else{ ?>
							<td><?php $c_row = $this->Users_model->getChannelNameById($row->channel_id); echo $c_row['channel_name']?></td>
                            <?php }?>
							<td>$<?php echo $row->amount?></td>
                            <td>$<?php echo $row->irw_amount; ?></td>
                            <td>$<?php echo $row->producer_royality_amount; ?></td>
							<td><?php echo date('m/d/Y',strtotime($row->date_of_charge));?></td>
						</tr>
						<?php }}else{?>
						<tr>
							<td colspan="9">You have not Payment History.</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<div class="col-md-12"><?php echo $links; ?></div>
			</div>
		</div>
	</div>
</div>
