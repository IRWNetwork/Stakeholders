<script type="text/javascript">
$(document).ready(function(){
	$('.bxslider').bxSlider({
		pager: false,
		auto: true,
		pause: 9000
	});
});
</script>


<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Membership Upgrade!</h1>
	</div>
	<?php $this->load->view('admin/common/messages');?>
    <?php if(count($bannerDetail)>0){?>
    <div style="padding: 20px 20px 0 20px;" class="row">
        <div class="col-xs-12">
            <ul class="bxslider">
                <?php foreach($bannerDetail as $banner_row){ ?>
                <li>
                    <a href="<?php echo $banner_row["banner_link"]?>" target="<?php echo $banner_row['target'];?>">
                        <img src="<?php echo base_url()."uploads/banner_images/".$banner_row["banner_image"]?>" class="img-responsive" />
                    </a>
                </li>
                <?php }?>
            </ul>
        </div>
     </div>
    <?php } ?>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading font-bold">Membership Upgrade!</div>
					<div class="panel-body">
						<?php if($this->ion_auth->user()->row()->is_premium=='yes' && $this->session->flashdata('success')==''){?>
						<div>You Are already premium user</div>
						<?php }else{?>

							<form action="#" method="post" class="grid card-form">
								<?php  $subscription_amount=0 ?>

								<div class="row">
									<div class="col-md-12">
										<div style="height: 30px !important;">

										</div>
									</div>
								</div>

								<input type="hidden" name="chargable_amount" value="1.99" />

								<div id="form_fields" <?php if(!empty($card_number)) echo 'style="display: none"' ?> >
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" for="expiration">
												<span class="field-name">First Name</span>
												<input id="credit-card-number" name="fname" class="card-field form-control" inputmode="fname" maxlength="16" placeholder="First Name" autocomplete="off" type="text">
												<div class="invalid-bottom-bar"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group" for="expiration">
												<span class="field-name">Last Name</span>
												<input id="credit-card-number" name="lname" class="card-field form-control" inputmode="lname" maxlength="16" placeholder="Last Name" autocomplete="off" type="text">
												<div class="invalid-bottom-bar"></div>
											</div>
										</div>
									</div>
									<div class="form-group" for="credit-card-number">
										<span class="field-name">Card Number</span>
										<input id="credit-card-number" name="credit-card-number" class="card-field form-control" inputmode="numeric" maxlength="16" placeholder="Card Number" autocomplete="off" type="tel">
										<div class="invalid-bottom-bar"></div>
									</div>

									<!--<div class="form-group" for="expiration">
										<span class="field-name">MM / YY</span>
										<input id="expiration" name="expiration" class="expiration card-field form-control"  maxlength="5" inputmode="numeric" placeholder="Expiration Date" autocomplete="off" type="tel">
										<div class="invalid-bottom-bar"></div>
									</div>-->


									<div class="row">
										<div class="col-md-6">
											<div class="form-group" for="expiration">
												<span class="field-name">Month</span>
												<select id="expiration_month" name="expiration_month" class="expiration card-field form-control">
													<option value="01">Jan</option>
													<option value="02">Feb</option>
													<option value="03">Mar</option>
													<option value="04">Apr</option>
													<option value="05">May</option>
													<option value="06">Jun</option>
													<option value="07">Jul</option>
													<option value="08">Aug</option>
													<option value="09">Sep</option>
													<option value="10">Oct</option>
													<option value="11">Nov</option>
													<option value="12">Dec</option>
												</select>
												<div class="invalid-bottom-bar"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group" for="expiration">
												<span class="field-name">Year</span>
												<select id="expiration_year" name="expiration_year" class="expiration card-field form-control">
													<option value="17">17</option>
													<option value="18">18</option>
													<option value="19">19</option>
													<option value="20">20</option>
													<option value="21">21</option>
													<option value="22">22</option>
													<option value="23">23</option>
													<option value="24">24</option>
													<option value="25">25</option>
													<option value="26">26</option>
													<option value="27">27</option>
													<option value="28">28</option>
													<option value="29">29</option>
													<option value="30">30</option>
												</select>
												<div class="invalid-bottom-bar"></div>
											</div>
										</div>
									</div>


									<div class="form-group" for="CVV">
										<span class="field-name">CVV</span>
										<input id="cvv" name="cvv" class="expiration card-field form-control"  maxlength="3" inputmode="numeric" placeholder="CVV" autocomplete="off" type="text">
										<div class="invalid-bottom-bar"></div>
									</div>

								</div>

								<label class="card-label expiration-label  form-group" for="expiration">
									<input type="submit" name="make_transaction" class="btn btn-primary">
								</label>

							</form>

						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--<script src="https://js.braintreegateway.com/v2/braintree.js"></script>-->
<!--<script>
// We generated a client token for you so you can test out this code
	// immediately. In a production-ready integration, you will need to
    // generate a client token on your server (see section below).
var clientToken = "<?php /*echo $clientToken;*/?>";
 braintree.setup(clientToken, "dropin", {
 container: "payment-form"
 });

</script>-->