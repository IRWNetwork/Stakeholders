<style type="text/css">
	#footer{
		display: none !important;
	}
</style>
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
	</div>
	<div class="wrapper-md" >
		<?php if ($this->session->flashdata('success')) {?>
		<div class="alert alert-success"> <?php echo $this->session->flashdata('success'); ?> </div>
		<?php }if (validation_errors()) {?>
		<div class="alert alert-danger"> <?php echo validation_errors(); ?> </div>
		<?php }?>
		<?php if ($this->session->flashdata('error')) {?>
		<div class="alert alert-danger"> <?php echo $this->session->flashdata('error'); ?> </div>
		<?php }?>
		<div class="row showAlert" style="display: none;">
			<div class="col-sm-12">
				<div class="alert alert-success">Updated Successfully</div>
			</div>
		</div>
		<div class="row">
            
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
						<div class="panel-body">
							<form method="post">
								<div class="col-md-12">
									<div class="item form-group">
		                                <label class="control-label col-md-2 col-sm-2 col-xs-2" for="instagram_link">
		                                	Show Popup
		                                </label>
		                                <div class="col-md-6 col-sm-6 col-xs-12">
		                                    <label class="i-switch i-switch-md bg-info m-t-xs m-r">
<input type="checkbox" value="yes" id="show_popup" name="show_popup" onclick="changeStatus()"  <?php if ($popup_check == 'yes') {echo 'checked';} ?>/>
												<i></i>
											</label>
		                                </div>
		                            </div>
	                           </div>
	                        </form>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold">All Popups</div>
						<div class="panel-body">
							<table class="table">
								<tr>
									<th>Popup Title</th>
									<th>Page</th>
									<th>Actions</th>
									<td>
										<select name="page" class="form-control m-b" onchange="selectPage(this.value)">
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
	                                </td>
	                                <td>
										<a href="<?php echo base_url(); ?>admin/setting/addPopup" class="btn btn-primary">Add New Popup</a>
									</td>
								</tr>
								<?php if (count($all_popups) > 0) { ?>
									<?php foreach($all_popups as $popup) { ?>
									<tr class="popupSettings">
										<td><?php echo $popup->title; ?></td>
										<td style="text-transform: capitalize;"><?php echo $popup->page; ?></td>
										<td>
											<div class="col-md-3 col-sm-3 col-xs-3">
			                                    <label class="i-switch i-switch-md bg-info m-t-xs m-r">
												<input type="checkbox" class="show_popup" value="yes" id="change_popup" name="show_popup" onclick="" <?php echo $popup->status == 1 ? 'checked' : '' ?> onchange="selectPopup(<?php echo $popup->id; ?>, '<?php echo $popup->page; ?>')"/>
													<i></i>
												</label>
			                                </div>
											<a href="<?php echo base_url(); ?>admin/setting/editPopup/<?php echo $popup->id; ?>" class="btn btn-sm btn-primary">Edit Popup</a>
			                            </div>
										</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<?php } ?>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function changeStatus() {
		var showPopup = 'yes';
		if ($('#show_popup').is(':checked')) {
            showPopup = 'yes';
              
        }
        else {
        	showPopup = 'no';
        }
        var BASE_URL = '<?php echo base_url()?>';
        my_url = BASE_URL+"/admin/setting/updatePopupSettings/";
        $.ajax({
	        type: "POST",
	        url: my_url,
	        data:{'show_popup':showPopup},                 
	        success: function (data) {
	        	if (data = 1) {
	        		$(".showAlert").show();
	        		setTimeout(function(){ 
						$(".showAlert").hide();
					}, 3000);
	        	}
	        }
	    });  

	}

	// $('input.show_popup').on('change', function() {
	//     $('input.show_popup').not(this).prop('checked', false);  
	// });

	function selectPopup(id,page) {
		var BASE_URL = '<?php echo base_url()?>';
        my_url = BASE_URL+"/admin/setting/selectPopup/";
        $.ajax({
	        type: "POST",
	        url: my_url,
	        data:{'id':id,page:page},                 
	        success: function (id) {
	        	if (data = 1) {
	        		$(".showAlert").show();
	        		setTimeout(function(){ 
						$(".showAlert").hide();
					}, 3000);
	        	}
	        }
	    });

	}

	function selectPage(page) {
		var BASE_URL = '<?php echo base_url()?>';
        my_url = BASE_URL+"/admin/setting/selectPage/";
        $.ajax({
	        type: "POST",
	        url: my_url,
	        data:{'page':page},                 
	        success: function (data) {
	        	$(".popupSettings").remove();
	        	$('.table tr:last').after(data);
	        }
	    });
	}
</script>