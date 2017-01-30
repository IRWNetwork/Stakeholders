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
									<label class="col-lg-3 control-label">Title</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="title" value="<?php if(isset($contentRow['title'])){ echo $contentRow['title']; }?>" placeholder="Title">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Type</label>
									<div class="col-lg-6">
										<select name="type" class="form-control m-b" id="type">
											<option value="">Select Type</option>
											<option value="Video">Video</option>
											<option value="Audio">Audio</option>
											<option value="Text">Text</option>
											<option value="Podcasts">Podcasts</option>
										</select>
										<?php if(isset($contentRow['type'])){?>
										<script type="text/javascript">
											document.frm.type.value='<?php echo $contentRow['type']?>';
										</script>
										<?php }?>
									</div>
								</div>
								<div class="form-group" id="video_type" style="display:none">
									<label class="col-lg-3 control-label">Video Type</label>
									<div class="col-lg-6">
										<div class="radio">
											<label class="i-checks">
												<input type="radio" name="video_type" required value="file" onchange="showVideo(this.value)" checked="checked">
												<i></i> File
											</label>
											<label class="i-checks">
												<input type="radio" name="video_type" required value="embed_code" onchange="showVideo(this.value)" <?php if(isset($contentRow['embed_code']) && $contentRow['embed_code']=='embed_code'){ echo "checked"; }?> >
												<i></i> Embed Code
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Description</label>
									<div class="col-lg-6">
										<textarea name="description" class="form-control"><?php if(isset($contentRow['description'])){ echo $contentRow['description']; }?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Is Preimum</label>
									<div class="col-lg-6">
										<label class="i-switch i-switch-md bg-info m-t-xs m-r">
											<input type="checkbox" value="yes" name="is_premium" <?php if($contentRow['is_premium']=='yes'){?> checked <?php }?> />
											<i></i>
										</label>
									</div>
								</div>
                                
								<div class="form-group">
									<label class="col-lg-3 control-label">Is Featured</label>
									<div class="col-lg-6">
										<label class="i-switch i-switch-md bg-info m-t-xs m-r">
											<input type="checkbox" value="yes" name="is_featured" <?php if($contentRow['is_featured']=='yes'){?> checked <?php }?> />
											<i></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Picture</label>
									<div class="col-sm-9">
										<input type="file" name="picture" /><br />
										<?php if($contentRow['picture']!=''){?>
										<img src="<?php echo base_url()?>uploads/admin_listing/<?php echo $contentRow['picture']?>" style="width:100px" /><br />
										<span><a href=""><i class="fa fa-trash"></i>&nbsp;Delete</a></span>
										<?php }?>
									</div>
								</div>
								<div class="form-group" id="file">
									<label class="col-sm-3 control-label">File</label>
									<div class="col-sm-9">
										<input type="file" name="file" />
									</div>
								</div>
								<div class="form-group" id="embed_code" style="display:none">
									<label class="col-sm-3 control-label">Youtube Embedcode</label>
									<div class="col-sm-6">
										<textarea name="embed_code" class="form-control"><?php if(isset($contentRow['embed_code'])){ echo $contentRow['embed_code']; }?></textarea>
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
			if(val=='Text'){
				$( "#file" ).fadeOut( 500, "linear" );
			}else{
				$( "#file" ).fadeIn( 200, "linear" );
			}
		});
		<?php if(isset($contentRow['type']) && $contentRow['type']!=''){?>
		$("#type").trigger("change");
		showVideo("<?php echo $contentRow['video_type'] ?>");
		<?php }?>
	});
	
	function showHideVideoContent(val){
		if(val=='Video'){
			$("#video_type").fadeIn( 500, "linear" );
		}else{
			$("#video_type").fadeOut( 500, "linear" );
		}
	}
	function showVideo(type){
		if(type=='embed_code'){
			$("#file").fadeOut( 500, "linear" );
			$("#embed_code").fadeIn( 500, "linear" );
		}else{
			$( "#file" ).fadeIn( 200, "linear" );
			$("#embed_code").fadeOut( 500, "linear" );
		}
	}
</script>