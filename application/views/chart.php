<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width">
	<title>Chart example 1</title>
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/Treant.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom-color-plus-scrollbar.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/perfect-scrollbar/perfect-scrollbar.css">
</head>
<body>
	<div class="chart" id="OrganiseChart1"></div>
	<script src="<?php echo base_url()?>assets/js/raphael.js"></script> 
	<script src="<?php echo base_url()?>assets/js/Treant.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery/dist/jquery.js"></script>
	<script src="<?php echo base_url()?>assets/js/perfect-scrollbar/jquery.mousewheel.js"></script> 
	<script src="<?php echo base_url()?>assets/js/perfect-scrollbar/perfect-scrollbar.js"></script> 
<script type="text/javascript">
var config = {
        container: "#OrganiseChart1",
        rootOrientation:  'WEST', // NORTH || EAST || WEST || SOUTH
        // levelSeparation: 30,
        siblingSeparation:   20,
        subTeeSeparation:    60,
        scrollbar: "fancy",
        
        connectors: {
            type: 'step'
        },
        node: {
            HTMLclass: 'nodeExample1'
        }
    },
	<?php echo $charts_data;?>,
    ALTERNATIVE = [
        config,
		<?php echo $ids?>
    ];
	$(document).ready(function(){
		setTimeout(function(){
			$("#main0").css('display','none');
		},100);
	})
</script>
	<script>
        new Treant( ALTERNATIVE );
    </script>
</body>
</html>