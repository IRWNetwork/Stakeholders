<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Upgrade Package</h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold">Upgrade Package</div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<?php if($this->ion_auth->user()->row()->is_premium=='yes' && $this->session->flashdata('success')==''){?>
						<div>You Are already premium user</div>
						<?php }else{?>
						<form class="bs-example form-horizontal" method="post" id="frm" name="frm" role="form" autocomplete="off">
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-lg-3 control-label">Price</label>
									<div class="col-lg-6">
										$45/Month
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Payment Type</label>
									<div class="col-lg-6">
										<div id="payment-form"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-10">
										<button type="submit" class="btn btn-sm btn-info">Update</button>
									</div>
								</div>
							</div>
						</form>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
<script>
// We generated a client token for you so you can test out this code
// immediately. In a production-ready integration, you will need to
// generate a client token on your server (see section below).
var clientToken = "<?php echo $clientToken;?>";
braintree.setup(clientToken, "dropin", {
  container: "payment-form"
});
</script>