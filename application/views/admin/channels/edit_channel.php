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
									<label class="col-lg-3 control-label">Type</label>
									<div class="col-lg-6">
										<select name="type" class="form-control m-b" id="type">
											<option value="">Select Type</option>
											<option value="4">Channel</option>
											<option value="3">User</option>
										</select>
										<?php if(isset($usersRow['brand_name'])){?>
										<script type="text/javascript">
											document.frm.type.value=<?php if($usersRow['brand_name'] != NULL){ echo 4; }else{
												echo 4;}?>;
										</script>
										<?php }?>
									</div>
								</div>
                                    <div class="form-group">
                                    	<label class="col-lg-3 control-label">Email</label>
                                        <div class="col-lg-6">
                                        	<input type="email" name="email" placeholder="Email" value="<?php echo $usersRow['email'];?>" class="form-control "  required/>
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
                                
								<?php if($usersRow['picture']!=''){?>
								<div class="form-group">
									<input type="hidden" name="old_pic" value="<?php echo $usersRow['picture']; ?>">
									<div class="col-lg-6 col-md-offset-3">
										<div><img src="<?php echo  base_url().'/uploads/profile_pic/thumb_200_'.$usersRow['picture']; ?>" ></div>
									</div>
								</div>
								<?php }?>
                                    
									<div id="channel_fields">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Brand Name</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="brand" value="<?php echo $usersRow['brand_name'];?>" placeholder="Brand Name" class="form-control " >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Name</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="channel" value="<?php echo $usersRow['channel_name']?>" placeholder="Channel Name" class="form-control ">
                                            </div>
                                        </div>
                                                                          
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Price in $</label>
                                            <div class="col-lg-6">
                                                <input type="text" name="channel_price" value="<?php echo $usersRow['channel_subscription_price']?>" placeholder="Channel Price" class="form-control " >                                            </div>
                                        </div>                                  
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Channel Description</label>
                                            <div class="col-lg-6">
                                            	<textarea name="description" class="form-control " > <?php echo $usersRow['description']?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
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
<script type="text/javascript">
	$(document).ready(function(){
		$("#type").change(function(){
			var val = $("#type").val();
			showHideVideoContent(val);
			if(val=='3'){
			 	$( "#channel_fields" ).fadeOut( 500, "linear" );
			}else{
				$( "#channel_fields" ).fadeIn( 200, "linear" );
			}
		});
		
		function showHideVideoContent(val){
			if(val=='4'){
				$("#channel_fields").fadeIn( 500, "linear" );
			}else{
				$("#channel_fields").fadeOut( 500, "linear" );
			}
		}
	});
</script>