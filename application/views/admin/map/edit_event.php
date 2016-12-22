<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url()?>assets/css/jquery-ui-timepicker-addon.css" />
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
							<input type="hidden" name="id" value="<?php echo $eventDetail['id'];?>" />
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="category_id" id="category_id" class="form-control">
										<option value="">Select Categories</option>
										<?php foreach($categories as $cat){?>
										<option value="<?php echo $cat->id?>"><?php echo $cat->name?></option>
										<?php }?>
									</select>
									<?php if(isset($eventDetail['category_id'])){?>
									<script type="text/javascript">
										document.frm.category_id.value='<?php echo $eventDetail['category_id'];?>'
									</script>
									<?php }?>
                                </div>
                            </div>
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Type <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="type" id="type" class="form-control">
										<option value="">Select Type</option>
										<option value="event">Event</option>
										<option value="producers">Producers</option>
									</select>
									<?php if(isset($eventDetail['type'])){?>
									<script type="text/javascript">
										document.frm.type.value='<?php echo $eventDetail['type'];?>'
									</script>
									<?php }?>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($eventDetail['name']) ? $eventDetail['name'] : '';?>" />
                                </div>
                            </div>
							
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start Date <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="start_date" name="start_date" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($eventDetail['start_date']) ? date("m-d-Y H:i",strtotime($eventDetail['start_date'])) : '';?>" />
                                </div>
                            </div>
							
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End Date <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="end_date" name="end_date" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($eventDetail['end_date']) ? date("m-d-Y H:i",strtotime($eventDetail['end_date'])) : '';?>" />
                                </div>
                            </div>
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Produced By<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="produced_by" name="produced_by" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($eventDetail['produced_by']) ? $eventDetail['produced_by'] : '';?>" />
                                </div>
                            </div>
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ticket Link<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="link" name="link" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($eventDetail['link']) ? $eventDetail['link'] : '';?>" />
                                </div>
                            </div>
							
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="address" onblur="getlatlong(this.value)" name="address" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($eventDetail['address']) ? $eventDetail['address'] : '';?>" />
                                </div>
                            </div>
							
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Latitude<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="latitude" name="latitude" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($eventDetail['latitude']) ? $eventDetail['latitude'] : '';?>" />
                                </div>
                            </div>
							
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Longitude<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="longitude" name="longitude" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($eventDetail['longitude']) ? $eventDetail['longitude'] : '';?>" />
                                </div>
                            </div>
							
							
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="description" class="form-control"><?php echo isset($eventDetail['description']) ? $eventDetail['description'] : '';?></textarea>
                                </div>
                            </div>
							<div class="item form-group">
								<div class="col-md-3"></div>
								<div class="col-md-6">
									<div id="map" style="width:500px; height:500px"></div>
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
var placeSearch, autocomplete;
      

function initAutocomplete() {
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */(document.getElementById('address')),
		{types: ['geocode']});

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	//autocomplete.addListener('place_changed', fillInAddress);
}
</script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui-timepicker-addon.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIBVsXZSVca_DzD0hAQ0Kt2Nn-8vrjmTA&v=3.exp&sensor=false&libraries=places&callback=initAutocomplete"></script>

<script type="text/javascript">

$(document).ready(function(){
	$('#start_date').datetimepicker({
		dateFormat: 'm-d-yy'
	});
	$('#end_date').datetimepicker({
		dateFormat: 'm-d-yy'
	});
});


var geocoder = new google.maps.Geocoder();
var marker = null;
var map = null;
function initialize() {
	var $latitude = document.getElementById('latitude');
	var $longitude = document.getElementById('longitude');
	var latitude = 50.715591133433854
	var longitude = -3.53485107421875;
	var zoom = 16;

	var LatLng = new google.maps.LatLng(latitude, longitude);

	var mapOptions = {
		zoom: zoom,
		center: LatLng,
		panControl: false,
		zoomControl: false,
		scaleControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById('map'), mapOptions);
	if (marker && marker.getMap) marker.setMap(map);
		marker = new google.maps.Marker({
			position: LatLng,
			map: map,
			title: 'Drag Me!',
			draggable: true
		});

		google.maps.event.addListener(marker, 'dragend', function(marker) {
			var latLng = marker.latLng;
			$latitude.value = latLng.lat();
			$longitude.value = latLng.lng();
		});
}
initialize();
function getlatlong(val){
	if(val!=''){
		var address = val;
		geocoder.geocode({ 'address': address }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				marker.setPosition(results[0].geometry.location);
				$(latitude).val(marker.getPosition().lat());
				$(longitude).val(marker.getPosition().lng());
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
}
</script>

