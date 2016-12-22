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
						<form method="post" name="frm_reg" action="" id="demo-form2" class="form-horizontal form-label-left" novalidate>
							
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($productDetail['name']) ? $productDetail['name'] : '';?>" />
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">Save</button>
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