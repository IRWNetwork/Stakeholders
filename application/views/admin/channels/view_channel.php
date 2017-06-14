<?php //echo "<pre>";print_r($usersRow);die(); ?>
<div class="app-content-body ">
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading"> <?php echo $page_heading?> </div>
			<table id="example" class="table table-striped responsive-utilities jambo_table">
			<tr>
				<th>Channel Name</th>
				<td><?php echo $usersRow->channel_name; ?></td>
			</tr>
			<tr>
				<th>First Name</th>
				<td><?php echo $usersRow->first_name; ?></td>
			</tr>
			<tr>
				<th>Last Name</th>
				<td><?php echo $usersRow->last_name; ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><?php echo $usersRow->email; ?></td>
			</tr>
			<tr>
				<th>Monitization Background</th>
				<td><img src="<?php echo base_url() . '/uploads/profile_pic/' . $usersRow->monitization_background ?>" width="100" height="80" /> </td>
			</tr>
			<tr>
				<th>General Background</th>
				<td><img src="<?php echo base_url() . '/uploads/profile_pic/' . $usersRow->general_background; ?>" width="100" height="80"  /> </td>
			</tr>
			<tr>
				<th>Profile Picture</th>
				<td><img src="<?php echo base_url() . '/uploads/profile_pic/' . $usersRow->picture?> width="100" height="80" /> </td>
			</tr>
			<tr>
				<th>User Name</th>
				<td><?php echo $usersRow->username ?></td>
			</tr>
			<tr>
				<th>Premium</th>
				<td><?php echo $usersRow->is_premium ?></td>
			</tr>
			<tr>
				<th>Phone</th>
				<td><?php echo $usersRow->phone ?></td>
			</tr>
			<tr>
				<th>Brand Twitter Followers</th>
				<td><?php echo $usersRow->brand_twitter_followers ?></td>
			</tr>
			<tr>
				<th>Brand Facebook Likes</th>
				<td><?php echo $usersRow->brand_facebook_likes ?></td>
			</tr>
			<tr>
				<th>Brand Instagram Followers</th>
				<td><?php echo $usersRow->brand_instagram_followers ?></td>
			</tr>
			<tr>
				<th>Brand Name</th>
				<td><?php echo $usersRow->brand_name ?></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><?php echo $usersRow->description ?></td>
			</tr>
			<tr>
				<th>Sales Pitch</th>
				<td><?php echo $usersRow->sales_pitch ?></td>
			</tr>
			<tr>
				<th>How Were You Monetizing Content Before</th>
				<td><?php echo $usersRow->how_were_you_monitizing_content_before ?></td>
			</tr>
			<tr>
				<th>Day Of Contact</th>
				<td><?php echo $usersRow->day_of_contact ?></td>
			</tr>
			<tr>
				<th>Time Of Contact</th>
				<td><?php echo $usersRow->day_time_of_contact; ?></td>
			</tr>
			<tr>
				<th>Channel Price</th>
				<td><?php echo $usersRow->channel_subscription_price; ?></td>
			</tr>
			<tr>
				<th>Routung Number</th>
				<td><?php echo $usersRow->routing_number ?></td>
			</tr>
			<tr>
				<th>Account Number</th>
				<td><?php echo $usersRow->account_number ?></td>
			</tr>
			<tr>
				<th>Admin Comments</th>
				<td><?php echo $usersRow->admin_comment ?></td>
			</tr>
		</table>
		</div>
		
	</div>
</div>			