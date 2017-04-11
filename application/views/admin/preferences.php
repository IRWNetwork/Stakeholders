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
					<?php if(isset($msg) && $msg!=''){?>
                        <div class="success_message"><?php echo $msg; ?></div>
                        <?php }?>
                        <div class="x_content">
                            <div class="x_panel">
                            <?php if(isset($success) && $success!=''){?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                            <?php }if(validation_errors() || isset($error)) {?>
                            <div class="clear"></div>
                            <div class="alert alert-danger"><?php echo validation_errors(); echo isset($error) ? $error : ''; ?></div>
                            <?php }?>
                            <form method="post" action="" id="demo-form2" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo isset($userDetail['id']) ? $userDetail['id'] : '';?>">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook_link">Facebook Link<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="facebook_link" name="facebook_link" class="form-control col-md-7 col-xs-12" value="<?php echo $facebook_link;?>" />
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twitter_link">Twitter Link<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="twitter_link" name="twitter_link" class="form-control col-md-7 col-xs-12" value="<?php echo $twitter_link;?>" />
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="instagram_link">Instagram Link<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="instagram_link" name="instagram_link" class="form-control col-md-7 col-xs-12" value="<?php echo $instagram_link;?>" />
                                    </div>
                                </div>
                                
                                
                    
                    
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                    
                            </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


	