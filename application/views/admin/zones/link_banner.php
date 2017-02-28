<?php //echo "<pre>"; print_r($banners);exit; ?>
<!-- content -->
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_title;?></h1>
	</div>
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading">
			<?php echo $page_heading?>
			</div>
			<div class="table-responsive">
				<div class="col-md-12"><br />
					<?php $this->load->view('admin/common/messages');?>
				</div>
				<div class="col-md-10">
				<?php if (count($advertisers) > 0) { ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
					<select class="form-control m-b" id="select_advertisers">
						<option>-Select Advertisers-</option>
						<?php foreach ($advertisers as $advertiser) { ?>
							<option value="<?php echo $advertiser->id; ?>"><?php echo $advertiser->fullname; ?></option>
						<?php } ?>
					</select>
					</div>
				<?php } ?>
				</div>
				<div class="col-md-12" id="advertiser_banner">
					
				</div>	
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var BASE_URL = '<?php echo base_url();?>';
	$("#select_advertisers").change(function (){
		var advertiser_id = $(this).val();
		var zoneid = <?=$zoneid; ?>
		//alert(advertiser_id);
		var my_url = 'admin/zones/link_banner/'+advertiser_id;
		my_url = BASE_URL+""+my_url;
		$.ajax({
        url: my_url,
        type: "POST",
        data : {advertiser_id:advertiser_id,zoneid:zoneid},
        success: function (response) {
	    		$("#advertiser_banner").empty();
	    		$("#advertiser_banner").append(response);
	        }
	    });
	});
</script>
