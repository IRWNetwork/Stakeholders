<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-ui.css">
<style>
.chkbox{ padding:5px 10px 0px 10px; }
#main{
	width:280px;
	top:0 !important;
	left:0 !important;
	text-align:center;
	background-color:#FFF;
}
#gray_bar{
	background: #ccc;
	text-align: center;
	font-weight: bold;
	padding: 5px;
}
#date_map{padding:5px;}
.gm-style-iw{
	width: 280px !important;
   	top: 0 !important;
   	left: 0 !important;
	margin-top:19px !important;
}
.textLeft{
	padding-top:10px;
	padding-bottom:5px;
	text-align:left !important;
	float:left;
	width:140px;
	padding-left:20px;
	border-right:1px solid #ccc;
}
.textRight{
	padding-top:10px;
	padding-bottom:5px;
	text-align:left !important;
	float:left;
	width:140px;
	padding-left:20px
}
#date_main{
	border-bottom:1px solid #ccc;
}
#address, #producer_text{
	padding:5px;
}
#buy_ticket{
	background-color:#FEA0AE;
	padding:10px;
	font-weight:bold;
	color:#000;
}

@media(max-width:1024px){
	#draggable{left: 20.5% !important; top: 7.1% !important;}
}

@media(max-width:768px){
	#draggable{left: 27.3% !important; top: 9.3% !important;}
}

@media(max-width:414px){
	#draggable{left: 2.7% !important; top: 9.3% !important;}
}

@media (max-width: 414px){
	#footer {
		margin-top: 0px;
	}
}

@media (max-width:768px){
  #footer{margin-top: 130px;}
}

@media (min-width:1024px){
  #footer{margin-top: 464px;}
}

</style>
<div id="map" style="height:800px;"></div>
<script>

var locations = "";
var map;
var marker;
locations = <?php echo $events;?>;
function initMap() {
// Styles a map in night mode.
	map = new google.maps.Map(document.getElementById('map'), {
  		center: {lat: 40.674, lng: -73.945},
  		zoom: 3,
  		styles: [
			{
			"elementType": "geometry",
			"stylers": [
			  {
				"color": "#212121"
			  }
			]
		  },
		  {
			"elementType": "labels.icon",
			"stylers": [
			  {
				"visibility": "off"
			  }
			]
		  },
		  {
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#757575"
			  }
			]
		  },
		  {
			"elementType": "labels.text.stroke",
			"stylers": [
			  {
				"color": "#212121"
			  }
			]
		  },
		  {
			"featureType": "administrative",
			"elementType": "geometry",
			"stylers": [
			  {
				"color": "#757575"
			  }
			]
		  },
		  {
			"featureType": "administrative.country",
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#9e9e9e"
			  }
			]
		  },
		  {
			"featureType": "administrative.land_parcel",
			"stylers": [
			  {
				"visibility": "off"
			  }
			]
		  },
		  {
			"featureType": "administrative.locality",
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#bdbdbd"
			  }
			]
		  },
		  {
			"featureType": "poi",
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#757575"
			  }
			]
		  },
		  {
			"featureType": "poi.park",
			"elementType": "geometry",
			"stylers": [
			  {
				"color": "#181818"
			  }
			]
		  },
		  {
			"featureType": "poi.park",
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#616161"
			  }
			]
		  },
		  {
			"featureType": "poi.park",
			"elementType": "labels.text.stroke",
			"stylers": [
			  {
				"color": "#1b1b1b"
			  }
			]
		  },
		  {
			"featureType": "road",
			"elementType": "geometry.fill",
			"stylers": [
			  {
				"color": "#2c2c2c"
			  }
			]
		  },
		  {
			"featureType": "road",
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#8a8a8a"
			  }
			]
		  },
		  {
			"featureType": "road.arterial",
			"elementType": "geometry",
			"stylers": [
			  {
				"color": "#373737"
			  }
			]
		  },
		  {
			"featureType": "road.highway",
			"elementType": "geometry",
			"stylers": [
			  {
				"visibility": "off"
			  }
			]
		  },
		  {
			"featureType": "road.highway.controlled_access",
			"elementType": "geometry",
			"stylers": [
			  {
				"color": "#4e4e4e"
			  }
			]
		  },
		  {
			"featureType": "road.local",
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#616161"
			  }
			]
		  },
		  {
			"featureType": "transit",
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#757575"
			  }
			]
		  },
		  {
			"featureType": "water",
			"elementType": "geometry",
			"stylers": [
			  {
				"color": "#000000"
			  }
			]
		  },
		  {
			"featureType": "water",
			"elementType": "labels.text.fill",
			"stylers": [
			  {
				"color": "#3d3d3d"
			  }
			]
		  }
		]
	});
	
	setMarkers();
}

function setMarkers(){
	for (var i = 0; i < locations.length; i++){ 
		var obj 		= locations[i];
		var lat 		= obj.latitude;
		var long 		= obj.longitude;
		var name 		= obj.name;
		var address		= obj.address;
		var e_link		= obj.link;
		var date		= obj.date;
		var time		= obj.time;
		var produced_by	= obj.produced_by;
		
 		latlngset = new google.maps.LatLng(lat, long);

  		marker = new google.maps.Marker({  
        	map: map, title: name , position: latlngset  
        });
        map.setCenter(marker.getPosition());
		var content = "";
        content+= "<div id='main'><div id='gray_bar'>"+name+"</div>";
		content+= "<div id='date_main'><div class='textLeft'>"+date+"</div><div class='textRight'>"+time+"</div><div style='clear:both'></div></div>";
		content+= "<div id='address'> At: "+address+"</div>";
		content+="<div id='gray_bar'>Produced By</div><div id='producer_text'>"+produced_by+"</div>";
		content+="<div id='buy_ticket'><a href='"+e_link+"' target='_blank'>Buy Tickets!</a></div></div>";
		
  		var infowindow = new google.maps.InfoWindow();
		google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
		
        	return function() {
           		infowindow.setContent(content);
           		infowindow.open(map,marker);
        	};
    	})(marker,content,infowindow)); 
		
		google.maps.event.addListener(infowindow, 'domready', function() {
			// Reference to the DIV which receives the contents of the infowindow using jQuery
			var iwOuter = $('.gm-style-iw');
			
			/* The DIV we want to change is above the .gm-style-iw DIV.
			* So, we use jQuery and create a iwBackground variable,
			* and took advantage of the existing reference to .gm-style-iw for the previous DIV with .prev().
			*/
			var iwBackground = iwOuter.prev();
			// Remove the background shadow DIV
			iwBackground.children(':nth-child(2)').css({'display' : 'none'});
			// Remove the white background DIV
			iwBackground.children(':nth-child(4)').css({'display' : 'none'});

			
			var iwCloseBtn = iwOuter.next();

			// Apply the desired effect to the close button
			iwCloseBtn.css({
			  opacity: '1', // by default the close button has an opacity of 0.7
			  right: '50px', top: '15px', // button repositioning
			 
			  });
			
			// The API automatically applies 0.7 opacity to the button after the mouseout event.
			// This function reverses this event to the desired value.
			iwCloseBtn.mouseout(function(){
			  $(this).css({opacity: '1'});
			});
			
		});
		
	}
}


function updateMarker(){
	var allEvents = [];
	var allProducers = [];
	$('#events :checked').each(function() {
		allEvents.push($(this).val());
	});
	$('#producters :checked').each(function() {
		allProducers.push($(this).val());
	});
	$.post("<?php echo base_url()?>home/get_events_by_categories",{events:allEvents,producers:allProducers},function( data ) {
		 //Remove previous Marker.
		map = new google.maps.Map(document.getElementById('map'), {
  			center: {lat: 40.674, lng: -73.945},
  			zoom: 3,
  			styles: [
				{
				"elementType": "geometry",
				"stylers": [
				  {
					"color": "#212121"
				  }
				]
			  },
			  {
				"elementType": "labels.icon",
				"stylers": [
				  {
					"visibility": "off"
				  }
				]
			  },
			  {
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#757575"
				  }
				]
			  },
			  {
				"elementType": "labels.text.stroke",
				"stylers": [
				  {
					"color": "#212121"
				  }
				]
			  },
			  {
				"featureType": "administrative",
				"elementType": "geometry",
				"stylers": [
				  {
					"color": "#757575"
				  }
				]
			  },
			  {
				"featureType": "administrative.country",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#9e9e9e"
				  }
				]
			  },
			  {
				"featureType": "administrative.land_parcel",
				"stylers": [
				  {
					"visibility": "off"
				  }
				]
			  },
			  {
				"featureType": "administrative.locality",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#bdbdbd"
				  }
				]
			  },
			  {
				"featureType": "poi",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#757575"
				  }
				]
			  },
			  {
				"featureType": "poi.park",
				"elementType": "geometry",
				"stylers": [
				  {
					"color": "#181818"
				  }
				]
			  },
			  {
				"featureType": "poi.park",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#616161"
				  }
				]
			  },
			  {
				"featureType": "poi.park",
				"elementType": "labels.text.stroke",
				"stylers": [
				  {
					"color": "#1b1b1b"
				  }
				]
			  },
			  {
				"featureType": "road",
				"elementType": "geometry.fill",
				"stylers": [
				  {
					"color": "#2c2c2c"
				  }
				]
			  },
			  {
				"featureType": "road",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#8a8a8a"
				  }
				]
			  },
			  {
				"featureType": "road.arterial",
				"elementType": "geometry",
				"stylers": [
				  {
					"color": "#373737"
				  }
				]
			  },
			  {
				"featureType": "road.highway",
				"elementType": "geometry",
				"stylers": [
				  {
					"visibility": "off"
				  }
				]
			  },
			  {
				"featureType": "road.highway.controlled_access",
				"elementType": "geometry",
				"stylers": [
				  {
					"color": "#4e4e4e"
				  }
				]
			  },
			  {
				"featureType": "road.local",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#616161"
				  }
				]
			  },
			  {
				"featureType": "transit",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#757575"
				  }
				]
			  },
			  {
				"featureType": "water",
				"elementType": "geometry",
				"stylers": [
				  {
					"color": "#000000"
				  }
				]
			  },
			  {
				"featureType": "water",
				"elementType": "labels.text.fill",
				"stylers": [
				  {
					"color": "#3d3d3d"
				  }
				]
			  }
			]
		});
		locations = jQuery.parseJSON(data);
		initMap();
	});
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIBVsXZSVca_DzD0hAQ0Kt2Nn-8vrjmTA&callback=initMap" async defer></script>
<script src="<?php echo base_url()?>assets/js/jquery-ui.js"></script>
<script>
	$(document).ready(function() {
    	$("#draggable").draggable();
		$(".events_div").click(function (){
		   	$(this).parent().find('input[type=checkbox]').prop("checked", !$(this).parent().find('input[type=checkbox]').prop("checked"));
			updateMarker();
		});
		$(".producters_div").click(function (){
		   	$(this).parent().find('input[type=checkbox]').prop("checked", !$(this).parent().find('input[type=checkbox]').prop("checked"));
			updateMarker();
		});
  	});
</script>
<div id="draggable" class="ui-widget-content" style="width:200px; z-index:999; position:absolute; left:17.1%; top:6.6%; cursor:pointer">
	<?php foreach($categories as $cat){?>
	<div style="background:#ccc; text-align:center; font-weight:bold; font-size:13px; padding:5px"><?php echo $cat->name?></div>
	<form name="frm" id="map_frm" method="post">
	<div class="row" style="padding:5px 0px 5px 0">
		<div class="col-md-6 text-right" id="events"><input type="checkbox" value="<?php echo $cat->id?>" name="checkbox[]" onchange="updateMarker()" checked="checked" />&nbsp;<span class="events_div">Events</span></div>
		<div class="col-md-6" id="producters"><input type="checkbox"  value="<?php echo $cat->id?>" name="producers[]" onchange="updateMarker()" checked="checked" />&nbsp;<span class="producters_div">Producers</span></div>
	</div>
	</form>
  	<?php }?>
</div>