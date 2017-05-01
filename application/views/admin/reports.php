<!-- content -->
<div class="app-content-body ">
<div class="bg-light lter b-b wrapper-md">
	<h1  class="m-n font-thin h3"><?php echo $page_heading;?></h1>
    <div style="float:right;margin-top: -22px;">
         <div style="display:inline-block; padding-right:8px;">
            <select class="form-control" id="month">
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
         </div>
          <div style="display:inline-block; padding-right:8px;">
            <select class="form-control" id="year">
            <?php $date = (int) date("Y"); 
				for($i=1; $date >= 2017 && $i<= 3 ; $date--, $i++  ){
			?>
                <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
              <?php }?>  
            </select>
         </div>
          <div style="display:inline-block">
            <button id="search" class="btn btn-info btn-sm" >Search</button>
         </div>
     </div>
    
</div>
<div class="wrapper-md">
	<div class="panel panel-default">
		<div class="table-responsive">
			<div class="col-md-12">
				<div id="Total_Users" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function () {
		$('#search').on('click',function(){
			var m = $('#month').val();
			var y = $('#year').val();
   			window.location = '<?php echo base_url().'admin/reports/user_statistics?date=';?>'+ y+'-'+m;
		});
		<?php 
		if(count($selectValues)>0){?>
			$('#month').val('<?php echo $selectValues[1];?>');
			$('#year').val('<?php echo $selectValues[0];?>');
		<?php }
		?>
		Highcharts.chart('Total_Users', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Register Users'
			},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: { // don't display the dummy year
					month: '%e. %b',
					year: '%b'
				},
				title: {
					text: ''
				}
			},
			yAxis: {
				title: {
					text: ''
				},
				min: 0
			},
			tooltip: {
				headerFormat: '<b>{series.name}: {point.y}</b><br>',
				pointFormat: '{point.x:%e. %b}'
			},
	
			plotOptions: {
				spline: {
					marker: {
						enabled: true
					}
				}
			},
	
			series: [{
				name: 'Register Users',
				// Define the data points. All series have a dummy year
				// of 1970/71 in order to be compared on the same x axis. Note
				// that in JavaScript, months start at 0 for January, 1 for February etc.
				data: [
				<?php 
					foreach( $userData as $row){?>
						[Date.UTC(<?php echo $row['niceDate'];?>), <?php echo $row['total'];?>],
				<?php }
				?>
				
				]
			}]
		});
		
	});
</script> 
  
