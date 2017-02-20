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
						<form method="post" name="frm" action="" id="demo-form2" class="form-horizontal form-label-left" novalidate>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Zone Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($zones['name']) ? $zones['name'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Dimensions <span class="required">*</span>
                                </label>
                                <div class="col-md-3">
                                    <input type="text" id="width" name="width" placeholder="Width" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($zones['width']) ? $zones['width'] : '';?>" />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="height" name="height" placeholder="Height" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($zones['height']) ? $zones['height'] : '';?>" />
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url()?>assets/tinymce/tinymce.min.js"></script>