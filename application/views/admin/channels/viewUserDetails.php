<?php //echo "<pre>";print_r($user);die(); ?>
<div class="app-content-body ">
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading"> <?php echo $page_heading?> </div>
			<table id="example" class="table table-striped responsive-utilities jambo_table">
			<tr>
				<th>Name</th>
				<td><?php echo $user['first_name']; ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $user['email']; ?></td>
			</tr>
			<tr>
				<th>Background</th>
				<td><img src="<?php echo base_url() . '/uploads/profile_pic/' . $user['monitization_background'] ?>" width="100" height="80" /> </td>
			</tr>
			<tr>
				<th>General Background</th>
				<td><img src="<?php echo base_url() . '/uploads/profile_pic/' . $user['general_background']; ?>" width="100" height="80"  /> </td>
			</tr>
			<tr>
				<th>Profile Picture</th>
				<td><img src="<?php echo base_url() . '/uploads/profile_pic/' . $user['picture']?> width="100" height="80" /> </td>
			</tr>
			<tr>
				<th>User Name</th>
				<td><?php echo $user['username']; ?></td>
			</tr>
			<tr>
				<th>Premium</th>
				<td><?php echo $user['is_premium']; ?></td>
			</tr>
			<tr>
				<th>Phone</th>
				<td><?php echo $user['phone']; ?></td>
			</tr>
			<tr>
				<th>Brand Twitter Followers</th>
				<td><?php echo $user['brand_twitter_followers']; ?></td>
			</tr>
			<tr>
				<th>Brand Facebook Likes</th>
				<td><?php echo $user['brand_facebook_likes']; ?></td>
			</tr>
			<tr>
				<th>Brand Instagram Followers</th>
				<td><?php echo $user['brand_instagram_followers']; ?></td>
			</tr>
			<tr>
				<th>Brand Name</th>
				<td><?php echo $user['brand_name']; ?></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><?php echo $user['description']; ?></td>
			</tr>
			<tr>
				<th>Sales Pitch</th>
				<td><?php echo $user['sales_pitch']; ?></td>
			</tr>
			<tr>
				<th>How Were You Monetizing Content Before</th>
				<td><?php echo $user['how_were_you_monitizing_content_before']; ?></td>
			</tr>
			<tr>
				<th>Day Of Contact</th>
				<td><?php echo $user['day_of_contact']; ?></td>
			</tr>
			<tr>
				<th>Time Of Contact</th>
				<td><?php echo $user['day_time_of_contact']; ?></td>
			</tr>
			<tr>
				<th>Channel Price</th>
				<td><?php echo $user['channel_subscription_price']; ?></td>
			</tr>
			<tr>
				<th>Routung Number</th>
				<td><?php echo $user['routing_number']; ?></td>
			</tr>
			<tr>
				<th>Account Number</th>
				<td><?php echo $user['account_number']; ?></td>
			</tr>
			<tr>
				<th>Admin Comments</th>
				<td><?php echo $user['admin_comment']; ?></td>
			</tr>
		</table>
			<?php if (count($producerMerchantInfo) > 0) : ?>
				<div class="col-md-12" align="center">
					<p style="font-size:20px"><b>Banking Information</b></p>
				</div>
				<table class="table">
					<tr>
						<th>Name</th>
						<td><?php echo $producerMerchantInfo['first_name'] .' '. $producerMerchantInfo['last_name']; ?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?php echo $producerMerchantInfo['email'] ?></td>
					</tr>
					<tr>
						<th>Phone</th>
						<td><?php echo $producerMerchantInfo['phone'] ?></td>
					</tr>
					<tr>
						<th>ssn</th>
						<td><?php echo $producerMerchantInfo['ssn'] ?></td>
					</tr>
					<tr>
						<th>Street Address</th>
						<td><?php echo $producerMerchantInfo['street_address'] ?></td>
					</tr>
					<tr>
						<th>City</th>
						<td><?php echo $producerMerchantInfo['city'] ?></td>
					</tr>
					<tr>
						<th>State</th>
						<td><?php echo $producerMerchantInfo['state'] ?></td>
					</tr>
					<tr>
						<th>Zip</th>
						<td><?php echo $producerMerchantInfo['zip'] ?></td>
					</tr>
					<tr>
						<th>Country</th>
						<td><?php echo $producerMerchantInfo['country'] ?></td>
					</tr>
					<tr>
						<th>Account Number</th>
						<td><?php echo $producerMerchantInfo['account_number'] ?></td>
					</tr>
					<tr>
						<th>Routing Number</th>
						<td><?php echo $producerMerchantInfo['routing_number'] ?></td>
					</tr>
					<tr>
						<th>Legal Name</th>
						<td><?php echo $producerMerchantInfo['legal_name'] ?></td>
					</tr>
					<tr>
						<th>DBA Name</th>
						<td><?php echo $producerMerchantInfo['dba_name'] ?></td>
					</tr>
					<tr>
						<th>Tax ID</th>
						<td><?php echo $producerMerchantInfo['tax_id'] ?></td>
					</tr>
					<tr>
						<th>Bussiness Street Address</th>
						<td><?php echo $producerMerchantInfo['buss_street_address'] ?></td>
					</tr>
					<tr>
						<th>Bussiness State</th>
						<td><?php echo $producerMerchantInfo['buss_state'] ?></td>
					</tr>
					<tr>
						<th>Bussiness Zip</th>
						<td><?php echo $producerMerchantInfo['buss_zip'] ?></td>
					</tr>
					<tr>
						<th>Bussiness Country</th>
						<td><?php echo $producerMerchantInfo['buss_country'] ?></td>
					</tr>
					<tr>
						<th>Bussiness Email</th>
						<td><?php echo $producerMerchantInfo['buss_email'] ?></td>
					</tr>
					<tr>
						<th>Bussiness Mobile</th>
						<td><?php echo $producerMerchantInfo['buss_mobile'] ?></td>
					</tr>
					<tr>
						<th>Bussiness ACC No</th>
						<td><?php echo $producerMerchantInfo['buss_acc_num'] ?></td>
					</tr>
					<tr>
						<th>Bussiness Routing No</th>
						<td><?php echo $producerMerchantInfo['buss_acc_num'] ?></td>
					</tr>
					<tr>
						<th>Merchant Account No</th>
						<td><?php echo $producerMerchantInfo['merchant_account_number'] ?></td>
					</tr>
				</table>
			<?php endif ?>
		</div>
		
	</div>
</div>			