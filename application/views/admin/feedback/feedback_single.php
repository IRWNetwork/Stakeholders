<style>
.info-feed{
	border: 1px solid #edf1f2;
	border-radius: 4px;
	padding: 10px;
	margin: 10px 0px;
}
.info-label{
		margin: 10px 0px;
}
</style>
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
                     <div style="float:right; padding-right:10px" ><a href="<?php echo base_url()."admin/feedback/"; ?>" class="btn btn-primary btn-sm"> <i class="fa fa-reply" aria-hidden="true"> </i> detail </a></div>
                    	<div class="col-xs-12">
                        <div class="info-label col-xs-4 col-md-2">From:</div>
                        <div class=" info-feed col-xs-6"> <?php  echo $feedbackInfo['first_name'] . ' ' .$feedbackInfo['last_name'];?></div>
                        <div class="clearfix"></div>
                        <div class="info-label col-md-2 col-xs-4">Subject:</div>
                        <div class="info-feed col-xs-6"> <?php  echo $feedbackInfo['subject'];?></div>
                        <div class="clearfix"></div>
                        <div class="info-label  col-md-2 col-xs-4">Message:</div>
                        <div class="info-feed col-xs-6"> <?php echo $feedbackInfo['message'];?></div>
                        <div class="clearfix"></div>
                        <div class="info-label  col-md-2 col-xs-4">Date:</div>
                        <div class="info-feed col-xs-6"><?php  echo date("m-d-Y", strtotime($feedbackInfo['date'])) ;?></div>
                        <div class="clearfix"></div>
                        <form method="post">
	                        <div class="info-label col-md-2 col-xs-4">Response:</div>
	                        <div class="info-feed col-xs-6">
	                        	<textarea name="response" class="form-control"></textarea>
	                        </div>
	                        <div class="clearfix"></div>
	                        <div class="info-label col-md-2 col-xs-4">&nbsp;</div>
	                        <div class="info-feed col-xs-6">
	                        	<input type="submit" class="btn btn-info" value="Save" name="">
	                        </div>
                        </form>
                        <div class="clearfix"></div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

