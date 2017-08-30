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
<?php } else {?>
	<tr class="popupSettings">
		<td colspan="5"><p>No records for this page.</p></td>
	</tr>
<?php } ?>

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

	$('input.show_popup').on('change', function() {
	    $('input.show_popup').not(this).prop('checked', false);  
	});

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