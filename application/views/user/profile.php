<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Profile</h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold">Profile</div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<form method="post" enctype="multipart/form-data" class="bs-example form-horizontal">
							<div class="col-md-12">

								<?php
								/*echo '<pre>';
								print_r($user);
								print_r($this->session->userdata('userGroup'));
								echo '</pre>';*/
								?>
								<div class="form-group">
									<label class="col-lg-3 control-label">First Name</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="first_name" value="<?php echo $user->first_name?>" placeholder="First Name">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Last Name</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="last_name" value="<?php echo $user->last_name?>" placeholder="Last Name">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Phone</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="phone" value="<?php echo $user->phone?>" placeholder="Phone">
									</div>
								</div>


                                <?php if($this->session->userdata('userGroup')==3){ ?>


								<!------ added by yasir  ----->

								<div class="form-group">
									<label class="col-lg-3 control-label">Brand Twitter Followers</label>
									<div class="col-lg-6">
										<input type="text" name="brand_twitter_followers" placeholder="Brand Twitter Followers" value="<?php echo $user->brand_twitter_followers ?>" class="form-control " >										</div>
								</div>


								<div class="form-group">
									<label class="col-lg-3 control-label">Brand Facebook Likes</label>
									<div class="col-lg-6">
										<input type="text" name="brand_facebook_likes" placeholder="Brand Facebook Likes" value="<?php echo $user->brand_facebook_likes?>" class="form-control " >
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label">Brand Instagram Followers</label>
									<div class="col-lg-6">
										<input type="text" name="brand_instagram_followers" placeholder="Brand Instagram Followers" value="<?php echo $user->brand_instagram_followers ?>" class="form-control " >
									</div>
								</div>


								<div class="form-group">
									<label class="col-lg-3 control-label">Brand Name</label>
									<div class="col-lg-6">
										<input type="text" name="brand" value="<?php echo $user->brand_name ?>" placeholder="Brand Name" class="form-control " >
									</div>
								</div>


								<div class="form-group">
									<label class="col-lg-3 control-label">Channel Name</label>
									<div class="col-lg-6">
										<input type="type" name="channel" value="<?php echo $user->channel_name ?>" placeholder="Channel Name" class="form-control " >
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-3 control-label">Sales Pitch</label>
									<div class="col-lg-6">
										<input type="type" name="salespitch" value="<?php echo $user->sales_pitch ?>" placeholder="Sales Pitch" class="form-control ">
									</div>
								</div>

							<div class="form-group">
								<label class="col-lg-3 control-label">Description</label>
								<div class="col-lg-6">
									<textarea name="description" placeholder="Description" class="form-control "><?php echo $user->description ?></textarea>
								</div>
							</div>


							<div class="form-group">
								<label class="col-lg-3 control-label">How Were You Monetizing Content Before</label>
								<div class="col-lg-6">
									<textarea type="text" name="how_were_you_monitizing_content_before" placeholder="How Were You Monitizing Content Before" value="<?php echo $user->how_were_you_monitizing_content_before ?>" class="form-control "><?php echo $user->how_were_you_monitizing_content_before ?></textarea>
								</div>
							</div>


							<div class="form-group">
								<label class="col-lg-3 control-label">Monitization Background</label>
								<input type="hidden" name="monitization_old_pic" value="<?php echo $user->monitization_background; ?>">
								<div class="col-lg-6">
									<input type="file" name="monitization_background_on_brand" placeholder="Monitization Background on Brand" class="form-control ">
								</div>
							</div>

									<div class="form-group">
										<div class="col-lg-6 col-md-offset-3">
											<div><img src="<?php echo  base_url().'uploads/profile_pic/'.$user->monitization_background; ?>" ></div>
										</div>
									</div>



     						<div class="form-group">
								<label class="col-lg-3 control-label">General Background</label>
								<input type="hidden" name="general_old_pic" value="<?php echo $user->general_background; ?>">
								<div class="col-lg-6">
									<input type="file" name="general_background_on_brand" placeholder="General Background On Brand"  class="form-control ">
								</div>
							</div>

									<div class="form-group">
										<div class="col-lg-6 col-md-offset-3">
											<div><img src="<?php echo  base_url().'uploads/profile_pic/'.$user->general_background; ?>" ></div>
										</div>
									</div>




									<div class="form-group">
										<label class="col-lg-3 control-label">Day To Contact</label>
										<input type="hidden" name="general_old_pic" value="<?php echo $user->general_background; ?>">
										<div class="col-lg-6">
											<select type="text" name="day_of_contact" placeholder="Day Of Contact" class="form-control " >
												<option value="mon" <?php if($user->day_of_contact == 'mon') echo 'selected' ?> > Monday </option>
												<option value="tue" <?php if($user->day_of_contact == 'tue') echo 'selected' ?> > Tuesday </option>
												<option value="wed" <?php if($user->day_of_contact == 'wed') echo 'selected' ?> > Wednesday </option>
												<option value="thu" <?php if($user->day_of_contact == 'thu') echo 'selected' ?> > Thursday </option>
												<option value="fri" <?php if($user->day_of_contact == 'fri') echo 'selected' ?> > Friday </option>
											</select>
										</div>
									</div>


									<div class="form-group">
										<label class="col-lg-3 control-label">Time To Contact</label>
										<input type="hidden" name="general_old_pic" value="<?php echo $user->general_background; ?>">
										<div class="col-lg-6">
											<select type="text" name="day_time_of_contact" placeholder="Day & Time To Contact"  class="form-control ">
												<option value="morning" <?php if($user->day_time_of_contact == 'morning') echo 'selected' ?> > Morning </option>
												<option value="afternoon" <?php if($user->day_time_of_contact == 'afternoon') echo 'selected' ?>> Afternoon </option>
												<option value="evening" <?php if($user->day_time_of_contact == 'evening') echo 'selected' ?>> Evening </option>
											</select>
										</div>
									</div>


									<div class="form-group">
										<label class="col-lg-3 control-label">Channel Price</label>
										<div class="col-lg-6">
											<select type="text" name="channel_subscription_price" placeholder="Channel Price in $" class="form-control " >
												<option value="1.99" <?php if($user->channel_subscription_price == '1.99') echo "selected" ; ?> >$1.99</option>
												<option value="2.99" <?php if($user->channel_subscription_price == '2.99') echo "selected" ; ?> >$2.99</option>
												<option value="3.99" <?php if($user->channel_subscription_price == '3.99') echo "selected" ; ?> >$3.99</option>
												<option value="4.99" <?php if($user->channel_subscription_price == '4.99') echo "selected" ; ?> >$4.99</option>
											</select>
										</div>
									</div>

									<!------ added by yasir  ----->

								<?php }?>
                                <div class="form-group">
									<label class="col-lg-3 control-label">Profile Picture</label>
									<div class="col-lg-6">
										<label>
											<input class="form-control" type="file" name="picture" id="picture" />
									  	</label>
										<span>Picture size must be at least 200 x 200</span>
                                    </div>
								</div>
								<?php if($user->picture!=''){?>
								<div class="form-group">
									<input type="hidden" name="old_pic" value="<?php echo $user->picture; ?>">
									<div class="col-lg-6 col-md-offset-3">
										<div><img src="<?php echo  base_url().'/uploads/profile_pic/thumb_200_'.$user->picture; ?>" ></div>
									</div>
								</div>
								<?php }?>

                                <div class="form-group" id="video_type" >
									<label class="col-lg-3 control-label">Video Type</label>
									<div class="col-lg-6">
										<div class="radio">
											<label class="i-checks">
												<input type="radio" name="video_type" required value="file" onchange="showVideo(this.value)" <?php if(isset($user->video_type) && $user->video_type=='file'){ echo "checked"; }else{?> checked="checked" <?php }?>>
												<i></i> File
											</label>
											<label class="i-checks">
												<input type="radio" name="video_type" required value="embed_code" onchange="showVideo(this.value)" <?php if(isset($user->video_type) && $user->video_type=='embed_code'){ echo "checked"; }?> >
												<i></i> Embed Code
											</label>
										</div>
									</div>
								</div>
                                <input type="hidden" name="type" value="Video" />
                                <div class="form-group" id="file">
									<label class="col-sm-3 control-label">Promo Video File (Limit 5GB)</label>
									<div class="col-sm-9">
										<input type="file" name="file" />
									</div>
								</div>

                                <div class="form-group" id="embed_code" style="display:none">
									<label class="col-sm-3 control-label">Youtube Embedcode</label>
									<div class="col-sm-9">
									<textarea name="embed_code" class="form-control"><?php if(isset($user->video_type)&& $user->video_type=="embed_code"){ echo $user->video; }?></textarea>

									</div>
								</div>
                                <!--<div class="form-group">
									<label class="col-lg-3 control-label">Promo Video Link</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="video" value="<?php echo $user->video?>" placeholder="embed video Link">
									</div>
								</div>-->


                                <div class="form-group">
									<label class="col-lg-3 control-label">Promo Banner</label>
									<div class="col-lg-6">

										<label>
										  <input type="file" name="banner" id="banner" />
									  </label>
									  <span>Banner size must be at least 846 X 180</span>
                                    </div>
								</div>




								<?php if($this->session->userdata('userGroup')==3){ ?>

									<div>
										<br/>
										<h3 class="page-header">Bank Information</h3>
									</div>

									<div class="form-group">
										<label class="col-lg-3 control-label">Routung Number</label>
										<div class="col-lg-6">
											<input type="text" name="routing_number" placeholder="Routing Number" value="<?php echo $user->routing_number ?>" class="form-control ">
										</div>
									</div>


									<div class="form-group">
										<label class="col-lg-3 control-label">Account Number</label>
										<div class="col-lg-6">
											<input type="text" name="account_number" placeholder="Account Number" value="<?php echo $user->account_number ?>" class="form-control ">
										</div>
									</div>

								<?php } ?>
								<?php if($user->banner!=''){?>
								<div class="form-group">
									<input type="hidden" name="banner_old_pic" value="<?php echo $user->banner; ?>">
									<div class="col-lg-6 col-md-offset-3">
										<div><img src="<?php echo  base_url().'/uploads/profile_pic/thumb_200_'.$user->banner; ?>" ></div>
									</div>
								</div>
								<?php }?>

								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-10">
										<button type="submit" class="btn btn-sm btn-info">Update</button>
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
<script>
  	function showVideo(type){
		if(type=='embed_code'){
			$("#file").fadeOut( 500, "linear" );
			$("#embed_code").fadeIn( 500, "linear" );
		}else{
			$( "#file" ).fadeIn( 200, "linear" );
			$("#embed_code").fadeOut( 500, "linear" );
		}
	}
	showVideo('<?php echo $user->video_type?>');
</script>
