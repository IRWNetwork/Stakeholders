<?php
	include("config.php");
	
	$referer=trim($_SERVER['HTTP_REFERER']);
	$ip=$_SERVER['REMOTE_ADDR'];
	$time=time();
	$bannerid=intval($_REQUEST['click']);
	$zoneid=intval($_REQUEST['zone']);

	$result=mysql_query("select url from banners where serial=$bannerid");
	$row=mysql_fetch_array($result);
	$count_click=0;
	if($row){
		if($referer!='' && $zoneid>0){
			$check_result=mysql_query("select * from clicks where bannerid=$bannerid order by serial desc");
			$check_row=mysql_fetch_array($check_result);
			if($check_row){
				if($check_row['ip']==$ip){
					$time_elapsed=($time-$check_row['time'])/60; // in minutes
					if($time_elapsed>=60){
						$count_click=1;
					}
				}
				else{
					$count_click=1;
				}
			}
			else{
				$count_click=1;
			}
			if($count_click){
				mysql_query("update bookings set clicks_performed=clicks_performed+1 where bannerid=$bannerid and zoneid=$zoneid and clicks_booked > clicks_performed and status='active'");
				mysql_query("insert into clicks values('',$bannerid,$time,'$ip','$referer',$zoneid)");
			}
			header("location:".$row['url']);
			exit();
		}
		else{
echo '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="5;url='.$row['url'].'">
<title>Untitled Document</title>
</head>

<body style="background-color:#FFF;">
	<h1>Redirecting to the site, Please wait ...</h1>
</body>
</html>';
		}
	}
?>