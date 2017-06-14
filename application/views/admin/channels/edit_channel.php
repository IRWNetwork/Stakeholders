<?php //echo "<pre>"; print_r($usersRow);exit; ?>
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
						<form name="frm" class="bs-example form-horizontal" method="post" enctype="multipart/form-data">
                        	<div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">First Name</label>
                                        <div class="col-lg-6">
                                            <input placeholder="First Name" name="first_name" value="<?php echo $usersRow->first_name ?>" class="form-control " required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Last Name</label>
                                        <div class="col-lg-6">
                                            <input placeholder="Last Name" name="last_name" value="<?php echo $usersRow->last_name ?>" class="form-control " required />
                                        </div>
                                    </div>
                                    <div class="form-group">
									<label class="col-lg-3 control-label">Type</label>
									<div class="col-lg-6">
										<select name="type" class="form-control m-b" id="type">
											<option value="">Select Type</option>
											<option value="3">Channel</option>
											<option value="2">User</option>
                                            <option value="4">Advertiser</option>
										</select>
										<?php //if (isset($usersRow['brand_name'])) { ?>
										<script type="text/javascript">
											document.frm.type.value=<?php 
                                                echo $usersRow->group_id
                                            ?>;
										</script>
										<?php //}?>
									</div>
								</div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Email</label>
                                        <div class="col-lg-6">
                                        	<input type="email" name="email" placeholder="Email" value="<?php echo $usersRow->email?>" class="form-control "  required/>
                                   		</div>
                                    </div>
                                  
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Password</label>
                                        <div class="col-lg-6">
                                        	<input type="password" name="password" placeholder="Password" class="form-control " >
                                   		</div>
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Confirm Password</label>
                                        <div class="col-lg-6">
                                        	<input type="password" name="confirmPassword" placeholder="Confirm Password" class="form-control " >
                                   		</div>
                                    </div>
                                      <div class="form-group">
									<label class="col-lg-3 control-label">Profile Picture</label>
									<div class="col-lg-6">
										
										<label>
										  <input type="file" name="picture" id="picture" />
									  </label>
                                    </div>
								</div>
                                
								<?php if($usersRow->picture != ''){?>
								<div class="form-group">
									<input type="hidden" name="old_pic" value="<?php echo $usersRow->picture ?>">
									<div class="col-lg-6 col-md-offset-3">
										<div><img src="<?php echo  base_url().'/uploads/profile_pic/thumb_200_'.$usersRow->picture ?>" ></div>
									</div>
								</div>
								<?php }?>
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
                                                <input type="text" id="irw_percentage" name="irw_percentage" placeholder="IRW %" value="<?php echo $usersRow->irw_percentage?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Producer Royalty</label>
                                            <div class="col-lg-6">
                                                <input type="text" id="producer_royalty" name="producer_royalty" placeholder="Producer Royalty" value="<?php echo $usersRow->producer_royalty?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Brand Name</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="brand" value="<?php echo $usersRow->brand_name ?>" placeholder="Brand Name" class="form-control " >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Name</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="channel" value="<?php echo $usersRow->channel_name?>" placeholder="Channel Name" class="form-control ">
                                            </div>
                                        </div>
                                                                          
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Price in $</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="channel_price" value="<?php echo $usersRow->channel_subscription_price?>" placeholder="Channel Price" class="form-control " >                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label class="col-lg-3 control-label">Sort Order</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="sorting" value="<?php echo $usersRow->sorting?>" placeholder="Sort Orders" class="form-control " >                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <?php //print_r($usersRow); ?>
                                            <label class="col-lg-3 control-label">Is Deleted</label>
                                            <div class="col-lg-6">
                                               <select class="form-control" name="is_deleted">
                                                 <option <?php echo $usersRow->is_deleted =='0' ? "selected" : ""; ?>  value="0">No</option>
                                                 <option <?php echo $usersRow->is_deleted =='1' ? "selected" : ""; ?> value="1">Yes</option>
                                               </select>
                                            </div>
                                        </div>
                                        <?php if ($usersRow->brand_name != NULL) { ?>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Content Block</label>
                                            <div class="col-lg-6">
                                               <select class="form-control" name="content_block">
                                                 <option <?php echo $usersRow->content_block =='0' ? "selected" : ""; ?>  value="0">No</option>
                                                 <option <?php echo $usersRow->content_block =='1' ? "selected" : ""; ?> value="1">Yes</option>
                                               </select>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Description</label>
                                            <div class="col-lg-6">
                                            	<textarea name="description" class="form-control " > <?php echo $usersRow->description ?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
									<div class="col-lg-offset-3 col-lg-10">
										<button type="submit" id="submit" class="btn btn-sm btn-info">Update</button>
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
			showHideVideoContent(val);
			if(val=='2' || val == '4'){
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