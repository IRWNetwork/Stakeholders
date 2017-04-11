<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<form class="bs-example form-horizontal" name="frm" method="post" enctype="multipart/form-data">
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-lg-3 control-label">Banner Link</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="banner_link" value="<?php if(isset($bannerRow['banner_link'])){ echo $bannerRow['banner_link']; }?>" placeholder="Banner Link">									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Page</label>
									<div class="col-lg-6">
										<select name="page" class="form-control m-b" >
                                        	<option value="">Select Page</option>
											<option value="new">New</option>
											<option value="podcasts">Podcasts</option>
											<option value="Arcade">Arcade</option>
											<option value="editorial">Editorial</option>
											<option value="videos">Videos</option>
                                            <option value="fantasy-league">Fantasy League</option>
                                            <option value="ruler_forums">Ruler Forums</option>
                                            <option value="faq">FAQ</option>
                                            <option value="channel_marketplace">Channel Marketplace</option>
                                            <option value="channel_subscription">Channel Subscription</option>
                                            <option value="upgradepackage">Upgrade Package</option>
										</select>
										<?php if(isset($bannerRow['page'])){?>
										<script type="text/javascript">
											document.frm.page.value='<?php echo $bannerRow['page']?>';
										</script>
										<?php }?>
									</div>
								</div>
                                
                                <div class="form-group">
									<label class="col-lg-3 control-label">Target value</label>
									<div class="col-lg-6">
										<select name="target" class="form-control m-b" >
                                        	<option value="_self">Self</option>
											<option value="_blank">Blank</option>
																					</select>
										<?php if(isset($bannerRow['target'])){?>
										<script type="text/javascript">
											document.frm.target.value='<?php echo $bannerRow['target']?>';
										</script>
										<?php }?>
									</div>
								</div>
							
								
								<div class="form-group">
									<label class="col-sm-3 control-label">Banner Image</label>
									<div class="col-sm-9">
										<input type="file" name="banner_picture" />
									</div>
								</div>
                                <?php if($bannerRow['banner_image']!=''){?>
                                <div class="form-group">
									<label class="col-sm-3 control-label">Banner Image</label>
									<div class="col-sm-9">
										<?php if($bannerRow['banner_image']){?>
                                        <img src="<?php echo base_url()."uploads/banner_images/thumb_153_".$bannerRow['banner_image'];?>" />
                                        <?php }?>
                                	</div>
                                </div>
                                <?php }?>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-10">
										<button type="submit" class="btn btn-sm btn-info">Save</button>
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
