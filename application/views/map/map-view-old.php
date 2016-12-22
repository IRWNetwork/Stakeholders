<!-- Step 1. Add CSS for the mapping components -->
<link rel="stylesheet" type="text/css" href="http://js.arcgis.com/3.13/esri/css/esri.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/map/css/fullmap-template.css">
<style type="text/css">
#mapDiv {
	position: absolute;
  	height: 100%;
	min-height: 100%;
  	width: 100%;
	min-width: 100%;
  	margin: 0;
 	padding: 0;
}
.app-header-fixed {
	padding-top: 0px !important;
}
.wrapper-lg{
	padding:0px !important;
}
html body {
    height: 100%;
    min-height: 100%;
}
#mapDiv_root{ height:900px !important;}
</style>
<!-- HTML5 IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
      <script src="../assets/js/respond.min.js"></script>
    <![endif]-->

		<!-- Step 2. Add HTML to define the layout of the page and the map -->
		
		<div id="mapDiv" style="height:800px; width:100%;position: absolute; height: 100%; width: 100%; margin: 0; padding: 0;"></div>
<!-- Step 3. Add JS to load the responsive map --> 
<script type="text/javascript">
	var package_path = "<?php echo base_url(); ?>/assets/map/js";
	var dojoConfig = {
		packages: [{
			name: "application",
			location: package_path
		}]
	};
	var scalebar = new Scalebar({
		  map: map,
		  scalebarUnit: "dual"
		});
</script> 
<script src="http://js.arcgis.com/3.13compact"></script> 
<script>
	require(["esri/map", "esri/dijit/Scalebar", "application/bootstrapmap", "dojo/domReady!"],
	  function(Map, Scalebar, BootstrapMap) {
		// Get a reference to the ArcGIS Map class
		var map = BootstrapMap.create("mapDiv", {
		  basemap: "dark-gray",
		  zoom: 4,
		  height: '900px',
		  scrollWheelZoom: true
		});
		var scalebar = new Scalebar({
		  map: map,
		  scalebarUnit: "dual"
		});
	   $(document).ready(function () {
		  $("#basemapList li").click(function (e) {
			switch (e.target.text) {
			  case "Streets":
				map.setBasemap("streets");
				break;
			  case "Imagery":
				map.setBasemap("hybrid");
				break;
			  case "National Geographic":
				map.setBasemap("national-geographic");
				break;
			  case "Topographic":
				map.setBasemap("topo");
				break;
			  case "Gray":
				map.setBasemap("gray");
				break;
			  case "Open Street Map":
				map.setBasemap("osm");
				break;
			}
		  });
		  	
		});
		
	});
	
</script>
