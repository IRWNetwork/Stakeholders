
<div class="app-content-body ">
	<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="
    app.settings.asideFolded = false; 
    app.settings.asideDock = false;
  "> 
		<!-- main -->
		<div class="col"> 
			<!-- main header -->
			<div class="bg-light lter b-b wrapper-md">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<h1 class="m-n font-thin h3 text-black">Dashboard</h1>
						<small class="text-muted">Welcome to IRW Network</small> </div>
					<div class="col-sm-6 text-right hidden-xs">
						<!-- <div class="inline m-r text-left">
							<div class="m-b-xs">1290 <span class="text-muted">items</span></div>
						<div class="inline text-left">
							<div class="m-b-xs">$30,000 <span class="text-muted">revenue</span></div>
						</div>
						</div> -->
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="wrapper-md">
		                     <div class="panel panel-default">
			                    <div class="col-md-12">
			                    <div class="table-responsive">
					            <table id="example" class="table table-striped responsive-utilities jambo_table">
					            <thead>
						            <tr class="headings">
							           <th>Registered Users</th>
							           <th>Registered Producers</th>
							           <th>IRW Revenue</th>
							           <th>Producer Royalty Revenue</th>
						            </tr>
					            </thead>
					            <tbody>
									<th><?php echo $allData['registeredUsers']; ?></th>
									<th><?php echo $allData['registeredProducers']; ?></th>
									<th><?php echo number_format($allData['totalRevenue']['irwRevenue'],2); ?></th>
									<th><?php echo number_format($allData['totalRevenue']['producerRoyaltyRevenue'],2); ?></th>
					            </tbody>
				                </table>
			                    </div>
		                        </div>
		                        </div>
	                            </div>
					    </div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div id="container"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div id="container2"></div>
					</div>
				</div>
			<!-- / main header -->
			<div class="wrapper-md" ng-controller="FlotChartDemoCtrl"> 
 
			</div>
		</div>
		<!-- / main --> 
		<!-- right col -->
		<!-- / right col -->

		</div>
</div>

<script type="text/javascript">
	var chart = Highcharts.chart('container', {

    chart: {
        type: 'column'
    },

    title: {
        text: 'Analytics upload last week'
    },

    subtitle: {
        text: ''
    },

    legend: {
        align: 'right',
        verticalAlign: 'middle',
        layout: 'vertical'
    },

    xAxis: {
        categories: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
        labels: {
            x: -10
        }
    },

    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Count'
        }
    },

    series: [{
        name: 'Podcast',
        data: [<?php echo implode(',', $allanalytics['weekPodcasts']); ?>]
    }, 
    {
        name: 'Videos',
        data: [<?php echo implode(',', $allanalytics['weekVideos']); ?>]
    }, 
    {
        name: 'Editoral',
        data: [<?php echo implode(',', $allanalytics['weekArticles']); ?>]
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    align: 'center',
                    verticalAlign: 'bottom',
                    layout: 'horizontal'
                },
                yAxis: {
                    labels: {
                        align: 'left',
                        x: 0,
                        y: -5
                    },
                    title: {
                        text: null
                    }
                },
                subtitle: {
                    text: null
                },
                credits: {
                    enabled: false
                }
            }
        }]
    }
});
</script>
<script type="text/javascript">
	
// 	var chart = Highcharts.chart('container2', {

//     chart: {
//         type: 'column'
//     },

//     title: {
//         text: 'Analytics For Last Week'
//     },

//     subtitle: {
//         text: ''
//     },

//     legend: {
//         align: 'right',
//         verticalAlign: 'middle',
//         layout: 'vertical'
//     },

//     xAxis: {
//         categories: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
//         labels: {
//             x: -10
//         }
//     },

//     yAxis: {
//         allowDecimals: false,
//         title: {
//             text: 'Count'
//         }
//     },

//     series: [{
//         name: 'Podcast',
//         data: [<?php echo implode(',', $allAnalyticsClicks['weekPodcastsClick']); ?>]
//     }, 
//     {
//         name: 'Videos',
//         data: [<?php echo implode(',', $allAnalyticsClicks['weekVideosClick']); ?>]
//     }, 
//     {
//         name: 'Editoral',
//         data: [<?php echo implode(',', $allAnalyticsClicks['weekArticlesClick']); ?>]
//     }],

//     responsive: {
//         rules: [{
//             condition: {
//                 maxWidth: 500
//             },
//             chartOptions: {
//                 legend: {
//                     align: 'center',
//                     verticalAlign: 'bottom',
//                     layout: 'horizontal'
//                 },
//                 yAxis: {
//                     labels: {
//                         align: 'left',
//                         x: 0,
//                         y: -5
//                     },
//                     title: {
//                         text: null
//                     }
//                 },
//                 subtitle: {
//                     text: null
//                 },
//                 credits: {
//                     enabled: false
//                 }
//             }
//         }]
//     }
// });

</script>
