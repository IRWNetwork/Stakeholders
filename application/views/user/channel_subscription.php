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
		<h1 class="m-n font-thin h3">Channel Subscription!</h1>
	</div>
    <?php if(count($bannerDetail)>0){?>
    <div class="row for-height">
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
			<div class="col-sm-6 col-sm-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading font-bold">Channel Subscription!</div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<?php if($alreadyBuy && $this->session->flashdata('success')==''){?>
						<div>You Are already Subscribe this channel.</div>
						<?php }else{?>
							<!--<form action="#" method="post" class="grid card-form">-->
                                  <?php  $subscription_amount=0 ?>

								<div class="form-group">
									<label class="col-md-1 control-label">Price</label>
									<div class="col-md-2">
										<img style="width: 50px;" src="<?php echo base_url()."uploads/profile_pic/".(($channelInfo['picture'])?$channelInfo['picture']:"default-thumbnail.jpg")?>" class=" img-responsive"/>
										$<?php echo $channelInfo['channel_subscription_price'];
										$subscription_amount+=$channelInfo['channel_subscription_price'];
										?>/Month
									</div>
									<?php if($flag_div){?>
										<div class="col-md-2">
											<img style="width: 50px;" src="<?php echo base_url()."uploads/profile_pic/".(($officalInfo['picture'])?$officalInfo['picture']:"default-thumbnail.jpg")?>" class=" img-responsive"/>
											$<?php echo $officalInfo['channel_subscription_price'];
											$subscription_amount+=$officalInfo['channel_subscription_price'];
											?>/Month
										</div>
									<?php } ?>
								</div>

								<div class="row">
                                   <div class="col-md-12">
                                        <div style="height: 30px !important;">

										</div>
								   </div>
								</div>

								<input type="hidden" name="chargable_amount" value="<?php echo $subscription_amount;?>" />
								<form  method="post">
                                	<?php //pk_F34Z9EEL7zPhz6gqqzUWutn0zGV6A;?>
                                	<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                          data-key="pk_ZlhI4yEbDZfAzCn1bdsXwColDSg0E"
                                          data-description="Access for a month"
                                          data-amount="<?php echo $subscription_amount*100;?>"
                                          data-locale="auto"></script>
                                </form>
								<?php /*?><?php
								if(!empty($card_number)){
									?>

									<div class="form-group">
										<label class="radio-inline">
											<input type="radio" id="previous_card" class="choose_card" onselect="choose_card(this.value)" value="previous" name="choose_card" checked>Use previous card
                                             <select id="" name="payment_profile_id">
											<?php foreach($card_number as $number ){?>
											    <option value="<?php echo $number->id ?>"><?php echo $number->card_number ?></option>
											<?php } ?>
											 </select>
										</label>
										<br/>
										<label class="radio-inline">
											<input type="radio" id="new_card" class="choose_card" onselect="choose_card(this.value)" value="new" name="choose_card">Use new card
										</label>
									</div>

								<?php
								}else{
									?>
									<input type="hidden" id="new_card" class="choose_card" onselect="choose_card(this.value)" value="new" name="choose_card">
								<?php
								}
								?>

								<div id="form_fields" <?php if(!empty($card_number)) echo 'style="display: none"' ?> >
									<!-- <div class="row">
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
									</div> -->
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
									<input id="submit" type="submit" name="make_transaction" class="btn btn-primary">
									<span><img id="processing" src="<?php echo base_url()."uploads/files/processing.gif" ?>" style="width: 42px; float: right; display: none;" class="img-responsive" /></span>
								</label><?php */?>

							</form>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://js.braintreegateway.com/v2/braintree.js"></script>
<script type="text/javascript">
	$('input:radio[name="choose_card"]').change(
		function(){
			if ($(this).is(':checked') && $(this).val() == 'previous') {
				$("#form_fields").slideUp();
			}else{
				$("#form_fields").slideDown();
			}
		});

	$("#submit").click(function(){
		//$("#submit").prop('disabled', true);
		$("#processing").show();
	})

// We generated a client token for you so you can test out this code
// immediately. In a production-ready integration, you will need to
// generate a client token on your server (see section below).
/*var clientToken = "<?php echo $clientToken;?>";
braintree.setup(clientToken, "dropin", {
  container: "payment-form"
});*/

</script>