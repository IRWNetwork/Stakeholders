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
                            <th> Payment Type</th>
							<th>Price</th>
                            <td>Transaction ID</td>
							<td>Card Number</td>
							<th>Purchase Date</th>
							<th>Status</th>
                            <th>Recourse Type</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($payment_logs)>0){
							foreach($payment_logs as $row){ $data = json_decode($row->merchant_responce);
						?>
						<tr class="odd pointer">
							<td><?php echo $i++;?></td>
							<td><?php if($row->channel_id!=0){ echo $row->channel_name ;}
								else{      echo "IRW";   }?></td>
                            <td><?php echo $row->type?></td>
							<td><?php echo $row->amount?>$</td>
                            <td><?php echo $data->transaction->_attributes->id; ?></td>
                            <td><?php if($data->transaction->_attributes->paymentInstrumentType=='credit_card'){ echo $data->transaction->_attributes->creditCard->bin."******".$data->transaction->_attributes->creditCard->last4?>
									<?php }else{ echo $data->transaction->_attributes->paypal->payerEmail;?>
									<?php }?></td>
							<td><?php echo $row->date_of_charge?></td>
							<td><?php echo $row->status?></td>
                            <td><?php if($data->transaction->_attributes->paymentInstrumentType=='credit_card'){ ?>
                                <img src="<?php echo $data->transaction->_attributes->creditCard->imageUrl; ?>" width="40px">
                                <?php }else{ ?>
                                <img src="<?php echo $data->transaction->_attributes->paypal->imageUrl; ?>" width="40px">
                                <?php }?></td>
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
