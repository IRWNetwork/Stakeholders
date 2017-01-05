<!DOCTYPE html>
<html lang="en" class="">
<head>
<meta charset="utf-8" />
<title><?php echo $page_title;?></title>
<meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/animate.css/animate.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />
<link rel="stylesheet" href="https://code.highcharts.com/css/highcharts.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css" type="text/css" />
<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery/dist/jquery.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
<div class="app app-header-fixed ">
	<!-- header -->
    <?php $this->load->view('admin/common/top-nav');?>
	<!-- / header -->
	<!-- aside -->
    <?php $this->load->view('admin/common/left-nav');?>
	<!-- / aside -->
	<!-- content -->
	<div id="content" class="app-content" role="main">
		{content}
	</div>
	<!-- /content -->
	<!-- footer -->
    <?php $this->load->view('admin/common/footer');?>
	<!-- / footer -->
</div>
<?php $this->load->view('admin/common/footer-js');?>
</body>
</html>
