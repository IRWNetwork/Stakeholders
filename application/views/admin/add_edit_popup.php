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
						<form method="post" action="" id="demo-form2" class="form-horizontal form-label-left"  enctype="multipart/form-data">

							<div class="item form-group">
                                <label for="popup" class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="title" value="<?php echo isset($popup_data->title) ? $popup_data->title : '';?>" class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="popup" class="control-label col-md-3 col-sm-3 col-xs-12">Page</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="page" class="form-control m-b" >
                                        <option value="">Select Page</option>
                                        <option value="home">Home</option>
                                        <option value="podcasts">Podcasts</option>
                                        <option value="editorial">Editorial</option>
                                        <option value="videos">Videos</option>
                                        <option value="faq">FAQ</option>
                                        <option value="channel_marketplace">Channel Marketplace</option>
                                        <option value="channel_subscription">Channel Subscription</option>
                                        <option value="upgradepackage">Upgrade Package</option>
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="popup" class="control-label col-md-3 col-sm-3 col-xs-12">PopUp</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea name="value" id="popup" class="form-control" style="height:300px">
                                    <?php 
                                    	if (isset($popup_data->value)) {
                                    		echo base64_decode($popup_data->value);
                                    	}
                                    ?></textarea>
                                </div>
                            </div>
       
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Update</button>
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
<script type="text/javascript">

tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>