<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
	</div>
	<div class="wrapper-md" >
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<form name="form" class="bs-example form-horizontal" method="post" enctype="multipart/form-data">
                        	<div class="col-md-12">
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">First Name</label>
                                        <div class="col-lg-6">
                                        	<input placeholder="First Name" name="first_name" value="<?php echo $this->input->post('first_name')?>" class="form-control " required />
                                   		</div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Last Name</label>
                                        <div class="col-lg-6">
                                        	<input placeholder="Last Name" name="last_name" value="<?php echo $this->input->post('last_name')?>" class="form-control " required />
                                   		</div>
                                    </div>
                                    <div class="form-group">
									<label class="col-lg-3 control-label">User Type</label>
									<div class="col-lg-6">
										<select name="type" class="form-control m-b" id="type">
											<option value="">Select Type</option>
											<option value="4">Advertiser</option>
											<option value="3">Channel</option>
											<option value="2">User</option>
										</select>
										<?php if(isset($contentRow['type'])){?>
										<script type="text/javascript">
											document.frm.type.value='<?php echo $contentRow['type']?>';
										</script>
										<?php }?>
									</div>
								</div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Email</label>
                                        <div class="col-lg-6">
                                        	<input type="email" name="email" placeholder="Email" value="<?php echo $this->input->post('email')?>" class="form-control "  required/>
                                   		</div>
                                    </div>
                                  
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Password</label>
                                        <div class="col-lg-6">
                                        	<input type="password" name="password" placeholder="Password" class="form-control "  required>
                                   		</div>
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Confirm Password</label>
                                        <div class="col-lg-6">
                                        	<input type="password" name="confirmPassword" placeholder="Confirm Password" class="form-control"  required>
                                   		</div>
                                    </div>
                                      <div class="form-group">
                                        <label class="col-lg-3 control-label">Profile Picture</label>
                                        <div class="col-lg-6">
                                              <input type="file" name="picture" id="picture" class="form-control" />
                                        </div>
                                    </div>
									<div class="form-group" id="percentage_error" style="display:none;">
										<label class="col-lg-3 control-label">&nbsp;</label>
										<div class="col-lg-6">
											<p style="color:red;">
												Sum of IRW% and Producer royalty should not be less then 100%
											</p>
										</div>
									</div>
									<div id="channel_fields"> <!--- Producer Form Fields Start -->

										<div class="form-group">
											<label class="col-lg-3 control-label">IRW %</label>
											<div class="col-lg-6">
												<input type="text" id="irw_percentage" name="irw_percentage" placeholder="IRW %" value="20" class="form-control">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-3 control-label">Producer Royalty</label>
											<div class="col-lg-6">
												<input type="text" id="producer_royalty" name="producer_royalty" placeholder="Producer Royalty" value="80" class="form-control">
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-3 control-label">Monitization Background</label>
											<div class="col-lg-6">
												<input type="file" name="monitization_background_on_brand" placeholder="Monitization Background on Brand" value="<?php echo $this->input->post('monitization_background_on_brand')?>" class="form-control">
											</div>
										</div>


										<div class="form-group">
											<label class="col-lg-3 control-label">General Background</label>
											<div class="col-lg-6">
												<input type="file" name="general_background_on_brand" placeholder="General Background On Brand" value="<?php echo $this->input->post('general_background_on_brand')?>" class="form-control">
											</div>
										</div>


										<div class="form-group">
											<label class="col-lg-3 control-label">Phone Number</label>
											<div class="col-lg-6">
												<input type="text" name="phone" placeholder="Phone Number" value="<?php echo $this->input->post('phone')?>" class="form-control">
											</div>
										</div>


										<div class="form-group">
											<label class="col-lg-3 control-label">Day To Contact</label>
											<div class="col-lg-6">
												<select type="text" name="day_of_contact" placeholder="Day To Contact" class="form-control">
													<option value="mon"> Monday </option>
													<option value="tue"> Tuesday </option>
													<option value="wed"> Wednesday </option>
													<option value="thu"> Thursday </option>
													<option value="fri"> Friday </option>
												</select>
											</div>
										</div>


										<div class="form-group">
											<label class="col-lg-3 control-label">Time To Contact</label>
											<div class="col-lg-6">
												<select type="text" name="day_time_of_contact" placeholder="Time To Contact" class="form-control">
													<option value="morning"> Morning </option>
													<option value="afternoon"> Afternoon </option>
													<option value="evening"> Evening </option>
												</select>
											</div>
										</div>



										<div class="form-group">
											<label class="col-lg-3 control-label">Brand Twitter Followers</label>
											<div class="col-lg-6">
												<input type="text" name="brand_twitter_followers" placeholder="Brand Twitter Followers" value="<?php echo $this->input->post('brand_twitter_followers')?>" class="form-control">
											</div>
										</div>


										<div class="form-group">
											<label class="col-lg-3 control-label">Brand Facebook Likes</label>
											<div class="col-lg-6">
												<input type="text" name="brand_facebook_likes" placeholder="Brand Facebook Likes" value="<?php echo $this->input->post('brand_facebook_likes')?>" class="form-control">
											</div>
										</div>


										<div class="form-group">
											<label class="col-lg-3 control-label">Brand Instagram Followers</label>
											<div class="col-lg-6">
												<input type="text" name="brand_instagram_followers" placeholder="Brand Instagram Followers" value="<?php echo $this->input->post('brand_instagram_followers')?>" class="form-control">
											</div>
										</div>



										<div class="form-group">
											<label class="col-lg-3 control-label">Sales Pitch</label>
											<div class="col-lg-6">
												<input type="type" name="salespitch" value="<?php echo $this->input->post('salespitch')?>" placeholder="Sales Pitch" class="form-control">
											</div>
										</div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Brand Name</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="brand" value="<?php echo $this->input->post('brand')?>" placeholder="Brand Name" class="form-control " >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Name</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="channel" value="<?php echo $this->input->post('channel')?>" placeholder="Channel Name" class="form-control ">
                                            </div>
                                        </div>
                                                                          
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Price in $</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="channel_price" value="<?php echo $this->input->post('channel_price')?>" placeholder="Channel Price" class="form-control " >                                            </div>
                                        </div>                                  

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Description</label>
                                            <div class="col-lg-6">
                                            	<textarea name="description" class="form-control " > <?php echo $this->input->post('description')?>
                                                </textarea>
                                            </div>
                                        </div>

										<div class="form-group">
											<label class="col-lg-3 control-label">How Were You Monitizing Content Before</label>
											<div class="col-lg-6">
												<textarea type="text" name="how_were_you_monitizing_content_before" placeholder="How Were You Monitizing Content Before" value="<?php echo $this->input->post('how_were_you_monitizing_content_before')?>" class="form-control"></textarea>
											</div>
										</div>


										<div>
											<br/>
											<h3 class="page-header">Bank Information</h3>
										</div>

										<div class="form-group">
											<label class="col-lg-3 control-label">Routung Number</label>
											<div class="col-lg-6">
												<input class="form-control" type="text" name="routing_number" placeholder="Routing Number" value="" class="form-control no-border">
											</div>
										</div>


										<div class="form-group">
											<label class="col-lg-3 control-label">Account Number</label>
											<div class="col-lg-6">
												<input class="form-control" type="text" name="account_number" placeholder="Account Number" value="" class="form-control no-border">
											</div>
										</div>



									</div> <!--- Producer Form Fields End -->
                                    <div class="form-group">
									<div class="col-lg-offset-3 col-lg-10">
										<button type="submit" id="submit" class="btn btn-sm btn-info">Register</button>
									</div>
								</div>
                             </div>  
                    	</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#type").change(function(){
			var val = $("#type").val();
			if(val=='2' || val=='4'){
			 	$( "#channel_fields" ).fadeOut( 500, "linear" );
			}else{
				$( "#channel_fields" ).fadeIn( 200, "linear" );
			}
		});
		
		function showHideVideoContent(val){
			if(val=='3'){
				$("#channel_fields").fadeIn( 500, "linear" );
			}else{
				$("#channel_fields").fadeOut( 500, "linear" );
			}
		}

		$("#irw_percentage, #producer_royalty").focusout(function () {
			var irw_percentage = $("#irw_percentage").val();
			var producer_royalty = $("#producer_royalty").val();
			var sum_both =  parseInt(irw_percentage, 10) + parseInt(producer_royalty, 10);
			if (sum_both <100 || sum_both >100) {
				$("#percentage_error").show();
				$('#submit').prop('disabled', true);
			}
			else {
				$("#percentage_error").hide();
				$('#submit').prop('disabled', false);
			}
		});
	});
</script>