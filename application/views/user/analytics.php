<?php //echo implode('", "', $byEpisode['episodeDates']);exit; ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_title;?></h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
						<table class="table">
							<thead>
								<tr class="headings">
									<th>Total Subscribers</th>
									<th>Total Revenue</th>
                                    <th>Producer Royality Amount</th>
                                    <th>IRW Royality</th>
								</tr>
							</thead>
							<tbody>
								<tr class="odd pointer">
									<td><?php echo $totalSubscribers['subscribers']; ?></td>
                                    <td>$<?php echo $totalRevenue['totalRevenue'] > 0 ? number_format($totalRevenue['totalRevenue'],2) : 0  ?></td>
									<td>$<?php echo $totalRevenue['producer_amount'] > 0 ? number_format($totalRevenue['producer_amount'],2) : 0  ?></td>
									<td>$<?php echo $totalRevenue['irw_amount'] > 0 ? number_format($totalRevenue['irw_amount'],2) : 0  ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			
			<div class="col-md-12">
				<div id="container2"></div>
			</div>
		</div>
        <div class="wrapper-md" ng-controller="FormDemoCtrl">
        <div class="row">
            
            <div class="col-md-12">
                <div id="container3"></div>
            </div>
        </div>
        </div>
        <div class="wrapper-md" ng-controller="FormDemoCtrl">
        <div class="row">
            <div class="panel-heading font-bold pull-right">
                <form method="get">
                    <?php if (count($contentOfProducer) > 0) { ?>
                    <select class="form-control" id="content-select" name="content_id">
                        <?php foreach($contentOfProducer as $key => $value) { ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                    <button type="submit" class="btn btn-sm">Submit</button>
                </form>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-12">
                <div id="container4"></div>
            </div>
        </div>
        </div>
	</div>
</div>
<div class="bg-light lter b-b wrapper-md">
    <h1  class="m-n font-thin h3"><?php echo $page_heading;?></h1>
     <div style="float:right;margin-top: -22px;">
        <select class="form-control" id="chnnel_name">
        
            <?php foreach($channels_info as $channel){
                    if($channel_id ==$channel['id']){
                    ?>
                        <option selected value="<?php echo $channel['id']; ?>"> <?php echo $channel['channel_name']; ?> </option>
                    <?php } 
                    else{ ?>
                        <option value="<?php echo $channel['id']; ?>"> <?php echo $channel['channel_name']; ?> </option>
                    <?php }?>   
            <?php }?>
        </select>
     </div>
    
</div>
<div class="wrapper-md">
    <?php if(isset($channel_banner['banner']) && $channel_banner['banner'] != ''){ ?>
        <div><img src="<?php echo base_url()."uploads/profile_pic/".$channel_banner['banner']?>" style="width:100%" /></div>
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
                            <th>City</th>
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
<div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
        <div style="float:right;margin-top: -22px;">
        <select class="form-control" id="chnnel_name">
        
            <?php foreach ($channels_info as $channel) {
                    if ($channel_id ==$channel['id']) {
                    ?>  
                        <option value="0">Select A channel</option>
                        <option selected value="<?php echo $channel['id']; ?>"> <?php echo $channel['channel_name']; ?> </option>
                    <?php } 
                    else{ ?>
                        <option value="0">Select A channel</option>
                        <option value="<?php echo $channel['id']; ?>"> <?php echo $channel['channel_name']; ?> </option>
                    <?php }?>   
            <?php }?>
        </select>
     </div>
    </div>
    <div class="wrapper-md">
        <div class="panel panel-default">
            <div class="col-md-12">
            <div class="table-responsive">
                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                    <thead>
                        <tr class="headings">
                            <th>Title</th>
                            <th>Off Site</th>
                            <th>In Site</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($analytics_totalPlays) > 0) { ?>
                            <?php foreach($analytics_totalPlays as $key => $row) { ?>
                            <tr class="odd pointer">
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['inSite']; ?></td>
                                <td><?php echo $row['offSite']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4">No records Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#chnnel_name').on('change',function(){
            window.location = '<?php echo base_url().'admin/analytics/listAnalytics/';?>'+ $('#chnnel_name').val();
        });
    </script>
<script type="text/javascript">
    $(function () {
        $('#chnnel_name').on('change',function(){
            window.location = '<?php echo base_url().'admin/analytics/';?>'+ $('#chnnel_name').val();
        });
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
<script type="text/javascript">
	
	
	var chart = Highcharts.chart('container2', {

    chart: {
        type: 'column'
    },

    title: {
        text: 'Analytics For Last Week'
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
        data: [<?php echo implode(',', $weekAnalytics['weekPodcastsClick']); ?>]
    }, 
    {
        name: 'Videos',
        data: [<?php echo implode(',', $weekAnalytics['weekVideosClick']); ?>]
    }, 
    {
        name: 'Editoral',
        data: [<?php echo implode(',', $weekAnalytics['weekArticlesClick']); ?>]
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

    var chart = Highcharts.chart('container3', {

    chart: {
        type: 'column'
    },

    title: {
        text: 'Analytics By Months'
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
        categories: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
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
        data: [<?php echo implode(',', $monthAnalytics['monthPodcastsClick']); ?>]
    }, 
    {
        name: 'Videos',
        data: [<?php echo implode(',', $monthAnalytics['monthVideosClick']); ?>]
    }, 
    {
        name: 'Editoral',
        data: [<?php echo implode(',', $monthAnalytics['monthArticlesClick']); ?>]
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

    <?php 
        if (count($contentOfProducer) > 0) { 
    ?>
    var chart = Highcharts.chart('container4', {

    chart: {
        type: 'column'
    },

    title: {
        text: 'Analytics By Episode'
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
        categories: ["<?php echo implode('", "', $byEpisode['episodeDates']); ?>"],
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
        name: 'Episodes',
        data: [<?php echo implode(',', $byEpisode['episodeCount']); ?>]
    }, 
    ],

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

<?php } ?>
</script>
<script type="text/javascript">
 $('#content-select').select2();
</script>