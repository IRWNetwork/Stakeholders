<?php $this->load->view('common/common-header');?>
<body>
<div class="app app-header-fixed">
	<div class="container w-auto-xs <?php if($flag!=2) echo 'col-md-4 col-md-offset-4' ?>" ng-controller="SigninFormController" ng-init="app.settings.container = false;"> <a href="<?php echo base_url()?>" class="navbar-brand block m-t">IRW Network</a>

		<!--<pre>
			<?php /*//print_r($this->session->userdata()); */?>
		</pre>-->

		<div class="m-b-lg">
			<div class="wrapper text-center"> <strong>User Register</strong> </div>
			<?php $this->load->view('common/messages');?>
			<form name="form" class="form-validation" method="post" enctype="multipart/form-data">
            	<input type="hidden" name="flag" value="<?php echo $flag; ?>">
				<div class="text-danger wrapper text-center" ng-show="authError"> </div>

				<div class="list-group list-group-sm">

					<?php if(!$this->ion_auth->logged_in()){ ?>

					<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input placeholder="First Name" name="firstname" value="<?php echo $this->input->post('firstname')?>" class="form-control no-border" required />
					</div>

					<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input placeholder="Last Name" name="lastname" value="<?php echo $this->input->post('lastname')?>" class="form-control no-border" required />
					</div>

					<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input type="email" name="email" placeholder="Email" value="<?php echo $this->input->post('email')?>" class="form-control no-border"  required>
					</div>

					<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input type="password" name="password" placeholder="Password" class="form-control no-border"  required>
					</div>

                    <div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input type="password" name="confirmPassword" placeholder="Confirm Password" class="form-control no-border"  required>
					</div>

					<?php } ?>


                    <?php if($flag==2){ ?>


						<?php if($this->session->userdata('userGroup') == 2){ ?>

							<input type="hidden" name="upgrade_to_producer" value="1" />

						<?php } ?>



						<div class="" style="width: 100% !important; clear: both;">
							<br/>
							<h3 class="page-header">For Producers</h3>
						</div>

						<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
							<label><strong>Monitization Background</strong></label>
							<input type="file" name="monitization_background_on_brand" placeholder="Monitization Background on Brand" value="<?php echo $this->input->post('monitization_background_on_brand')?>" class="form-control no-border"  required>
						</div>

						<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
							<label><strong>General Background</strong></label>
							<input type="file" name="general_background_on_brand" placeholder="General Background On Brand" value="<?php echo $this->input->post('general_background_on_brand')?>" class="form-control no-border"  required>
						</div>

						<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
							<label><strong>Day to Contact</strong></label>
							<select type="text" name="day_of_contact" placeholder="Day To Contact" class="form-control no-border"  required>
								<option value="mon"> Monday </option>
								<option value="tue"> Tuesday </option>
								<option value="wed"> Wednesday </option>
								<option value="thu"> Thursday </option>
								<option value="fri"> Friday </option>
							</select>
						</div>


						<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
							<label><strong>Time to Contact</strong></label>
							<select type="text" name="day_time_of_contact" placeholder="Time To Contact" class="form-control no-border"  required>
								<option value="morning"> Morning </option>
								<option value="afternoon"> Afternoon </option>
								<option value="evening"> Evening </option>
							</select>
						</div>

						<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
							<input type="text" name="brand_twitter_followers" placeholder="Brand Twitter Followers" value="<?php echo $this->input->post('brand_twitter_followers')?>" class="form-control no-border"  required>
						</div>

						<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
							<input type="text" name="brand_facebook_likes" placeholder="Brand Facebook Likes" value="<?php echo $this->input->post('brand_facebook_likes')?>" class="form-control no-border"  required>
						</div>

						<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
							<input type="text" name="brand_instagram_followers" placeholder="Brand Instagram Followers" value="<?php echo $this->input->post('brand_instagram_followers')?>" class="form-control no-border"  required>
						</div>

					<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input type="phone_number" name="phone" placeholder="Phone Number" value="<?php echo $this->input->post('phone')?>" class="form-control no-border"  required>
					</div>
                    <div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input type="text" name="brand" value="<?php echo $this->input->post('brand')?>" placeholder="Brand Name" class="form-control no-border"  required>
					</div>
                    <div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input type="type" name="channel" value="<?php echo $this->input->post('channel')?>" placeholder="Channel Name" class="form-control no-border"  required>
					</div>
                    <div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<input type="type" name="salespitch" value="<?php echo $this->input->post('salespitch')?>" placeholder="Sales Pitch" class="form-control no-border"  required>
					</div>
                    <div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>">
						<select type="text" name="channel_price" value="<?php echo $this->input->post('channel_price')?>" placeholder="Channel Price in $" class="form-control no-border" >
							<option value="1.99">$1.99</option>
							<option value="2.99">$2.99</option>
							<option value="3.99">$3.99</option>
							<option value="4.99">$4.99</option>
						</select>
					</div>
                    <div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>" style="width: 100% !important;">
						<textarea name="description" placeholder="Description" class="form-control no-border"  required><?php echo $this->input->post('description')?></textarea>
					</div>

					<div class="list-group-item <?php if($flag==2) echo 'list-group-item_extended' ?>" style="width: 100% !important;">
						<textarea type="text" name="how_were_you_monitizing_content_before" placeholder="How Were You Monitizing Content Before" value="<?php echo $this->input->post('how_were_you_monitizing_content_before')?>" class="form-control no-border"  required></textarea>
					</div>


						<!--<div class="" style="width: 100%; display: none; !important; clear: both;">
							<br/>
							<h3 class="page-header">Banking Information</h3>
						</div>
						<div style="display: none; " class="list-group-item <?php /*if($flag==2) echo 'list-group-item_extended' */?>">
							<input type="text" name="routing_number" placeholder="Routing Number" value="<?php /*echo $this->input->post('routing_number')*/?>" class="form-control no-border"  required>
						</div>

						<div style="display: none; " class="list-group-item <?php /*if($flag==2) echo 'list-group-item_extended' */?>">
							<input type="text" name="account_number" placeholder="Account Number" value="<?php /*echo $this->input->post('account_number')*/?>" class="form-control no-border"  required>
						</div>-->

					<?php } ?>
				</div>
						<br/>
				<div class="checkbox m-b-md m-t-none" style="clear: both">
					<label class="i-checks" style="margin-top: 10px;">
						<input type="checkbox" name="terms" value="1" required>
                        <?php if($this->uri->segment(1)=='producer'){?>
                        <i></i> Agree the <a href="<?php echo base_url()?>page/content-contributor-terms-of-use-agreement" target="_blank">terms and policy</a>
                        <?php }else{?>
						<i></i> Agree the <a href="<?php echo base_url()?>page/terms" target="_blank">terms and policy</a>
                        <?php }?>
					</label>
				</div>

				<button type="submit" class="btn btn-lg btn-primary btn-block">Sign up</button>
				<div class="line line-dashed"></div>
				<p class="text-center"><small>Already have an account?</small></p>
				<a href="<?php echo base_url()?>user/login" class="btn btn-lg btn-default btn-block">Sign in</a>
			</form>
		</div>
		<div class="text-center" ng-include="'tpl/blocks/page_footer.html'">
			<p> <small class="text-muted">IRW Network Insides Rule!<br>
				&copy; 2016</small> </p>
		</div>
	</div>
</div>
<?php $this->load->view('admin/common/footer-js');?>
</body>
</html>