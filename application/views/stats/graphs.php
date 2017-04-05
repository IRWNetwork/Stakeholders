<!-- content -->
<div class="app-content-body ">
<div class="bg-light lter b-b wrapper-md">
	<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
</div>
<div class="wrapper-md">
	<?php if($channel_banner['banner1']){ ?>
		<div><img src="<?php echo base_url()."uploads/profile_pic/".$channel_banner['banner1']?>" style="width:100%" /></div>
	<?php }?>
    <div style="background:#F00; padding:20px; color:#FFF; font-weight:bold; font-size:16px">
		<div style="text-align:center"><img src="<?php echo base_url()?>assets/images/logo-old.png" style="width:150px" /></div>
	<div style="line-height:23px; padding-top:5px">IRW Network is committed to statistical accuracy of your analytics. We realize this is an issue with other podcast players and platforms, so for your convenience and comfort, feel free to contact our advertiser relations team directly at <a href="mailto:AdRelations@IRWNetwork.com">AdRelations@IRWNetwork.com</a> for any clarity you might need. We appreciate you partnering with our platform and look forward to helping your brand shine!</div>
	</div>
	<div class="panel panel-default">
		<div class="table-responsive">
			<div class="col-md-12">
				<div id="Total_Plays" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="table-responsive">
			<div class="col-md-12">
				<div id="Top_Plays" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			</div>
		</div>
	</div>
	<div class="panel-default">
		<div class="table-responsive">
			<div class="col-md-6">
				<div id="age_analytics" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			</div>
			<div class="col-md-6">
				<div id="gender_analytics" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			</div>
		</div>
	</div>
	<div class="panel-default">
		<div class="col-md-6" >
			<h3> Top Countries <span class="small"> <?php // print_r ($maxDate['date']);?> - <?php //print_r( $minDate['date']);?> </span> </h3>
			<div class="scroll" style="max-height: 16em; overflow-y: scroll;">
				<table class="table table-bordered " style="background-color:#fff;">
					<tbody>
						<tr class="table_head">
							<th>Country</th>
							<th>Listens</th>
						</tr>
                        <?php foreach($analytics_topCountries as $value){?>
                        <tr></tr>
						<tr>
							<td><?php echo  $value['country']; ?></td>
							<td><?php echo  $value['count']; ?></td>
						</tr>
						
                        <?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-6" >
			<h3> Top Cities <span class="small"> <?php // print_r ($maxDate['date']);?> - <?php //print_r( $minDate['date']);?> </span> </h3>
			<div class="scroll" style="max-height: 16em; overflow-y: scroll;">
				<table class="table table-bordered " style="background-color:#fff;">
					<tbody>
						<tr class="table_head">
							<th>Country</th>
							<th>Listens</th>
						</tr>
                        <?php foreach($analytics_topCities as $value){?>
                        <tr></tr>
						<tr>
							<td><?php echo  $value['city']; ?></td>
							<td><?php echo  $value['count']; ?></td>
						</tr>
						
                        <?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel-default">
		<div class="col-md-12" >
			<h3> Podcast Statistics </h3>
			<table class="table table-bordered " style="background-color:#fff;">
				<tbody>
					<tr class="table_head">
						<th>Metric</th>
						<th>Total</th>
					</tr>
					<tr></tr>
					<tr>
						<td>Episodes:</td>
						<td><?php echo $totalPostcast['total'];?></td>
					</tr>
					<tr></tr>
					<tr>
						<td>Listens:</td>
						<td><?php echo $totalListens['total'];?></td>
					</tr>
					<tr></tr>
					<tr>
						<td>Comments:</td>
						<td>11</td>
					</tr>
					<tr></tr>
					<tr>
						<td>Followings:</td>
						<td>616</td>
					</tr>
					<tr></tr>
					<tr>
						<td>Ratings:</td>
						<td>96</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
    
	<div class="panel-default">
		<div class="col-md-12" >
			<h3> Top 20 Referrals <span class="small"> 30-12-2016 – 05-01-2017 </span> </h3>
			<div class="scroll" style="max-height: 16em; overflow-y: scroll;">
				<table class="table table-bordered " style="background-color:#fff;">
					<tbody>
						<tr class="table_head">
							<th>Source</th>
							<th>Referral path</th>
							<th>Pageviews</th>
						</tr>
						<?php foreach($pagesTotal as $value){?>
                        <tr></tr>
						<tr>
                        	<td></td>
							<td><?php echo  $value['referral_path']; ?></td>
							<td><?php echo  $value['total']; ?></td>
						</tr>
						
                        <?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function () {
    Highcharts.chart('Total_Plays', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Total Plays For Podcast: <?php echo $total_plays;?>'
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
            name: 'Listens',
            // Define the data points. All series have a dummy year
            // of 1970/71 in order to be compared on the same x axis. Note
            // that in JavaScript, months start at 0 for January, 1 for February etc.
            data: [
			<?php 
				foreach( $data_analytics_totalPlays as $data){?>
					[Date.UTC(<?php echo $data['date'];?>), <?php echo $data['count'];?>],
			<?php }
			?>
            
            ]
        }]
    });
});
</script> 
<script type="text/javascript">
	$(function () {
    Highcharts.chart('Top_Plays', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Plays for Top Episodes by Day'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: ''
            },
            min: 0
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
        },

        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        series: [
		<?php foreach( $analytics_topPlays as $title=> $value ){ ?>
		
		{
            name: '<?php echo $title;?>',
            // Define the data points. All series have a dummy year
            // of 1970/71 in order to be compared on the same x axis. Note
            // that in JavaScript, months start at 0 for January, 1 for February etc.
            data: [
			<?php 
				foreach( $value['date'] as $data=> $count){?>
					[Date.UTC(<?php echo $data;?>), <?php echo $count;?>],
			<?php }
			?>

            ]
        }, 
		<?php } ?>
		]
    });
});
</script> 
<script type="text/javascript">
	$(function () {
    Highcharts.chart('age_analytics', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Age'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Age',
            colorByPoint: true,
            data: [{
                name: '25-34',
                y: 38
            }, {
                name: '35-44',
                y: 25
            }, {
                name: '65+',
                y: 10
            }, {
                name: '45-54',
                y: 10
            }, {
                name: '55-64',
                y: 9
            }, {
                name: '18-24',
                y: 8
            }]
        }]
    });
});
</script> 
<script type="text/javascript">
	$(function () {
    Highcharts.chart('gender_analytics', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Gender'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Gender',
            colorByPoint: true,
            data: [{
                name: 'female',
                y: 13
            }, {
                name: 'male',
                y: 87
            }]
        }]
    });
});
</script>