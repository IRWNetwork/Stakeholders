<?php
	include("config.php");
	
	$zoneid=intval($_REQUEST['zoneid']);
	$referer=$_REQUEST['referer'];
	$location=$_REQUEST['location'];
	
	if($zoneid>0){ // && $location!=''){
		$query="select * from bookings where zoneid=$zoneid and status='active' and impressions_booked > impressions_performed and clicks_booked > clicks_performed";
		$result=mysql_query($query);
		
		$bookings=array();
		while($row=mysql_fetch_array($result)){
			extract($row);
			if($weight<1) $weight=1;
			$bookings[]=array('bannerid'=>$bannerid,'weight'=>$weight,'width'=>$width,'height'=>$height);
		}
		$banners_found=count($bookings);

		$sum=0;
		foreach($bookings as $key=>$value){
			$sum+=intval($value['weight']);
		}
		$x=rand(1,$sum);
	
		$sum=0; $index=-1;
		reset($bookings);
		foreach($bookings as $key=>$value){
			$index++;
			$sum+=intval($value['weight']);
			if($x<=$sum){
				break;
			}
		}
		$query="select * from banners where serial=".intval($bookings[$index]['bannerid']);
		
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		if($row){
			
			$width=intval($row['width']);
			$height=intval($row['height']);
			
			$url=$row['url'];
			$clickid=$row['serial'];
			$click_url="http://".$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/scripts/ck.php?click=$clickid&zone=$zoneid";
			$target=$row['target'];
			if($_SERVER["HTTPS"]=="on"){
				$path="https://".$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/banners/".$row['path'];
			}else{
				$path="http://".$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/banners/".$row['path'];
			}
			$alt=$row['alt_text'];
			$adsense_code=$row['adsense_code'];
			
			if($row['type']=='image'){
				echo 'document.write(\'<div style="width:'.$width.'px;height='.$height.'px"><a href="'.$click_url.'" target="'.$target.'" title="'.$alt.'"><img src="'.$path.'" alt="'.$alt.'" border="0" title="'.$alt.'" /></a></div>\');';
			}
			else if($row['type']=='flash'){
				echo 'document.write(\'<div style="width:'.$width.'px;height='.$height.'px"><object width="'.$width.'px" height="'.$height.'px"><param name="movie" value="'.$path.'"><embed src="'.$path.'" width="'.$width.'px" height="'.$height.'px"></embed></object></div>\')';
			}
			else if($row['type']=='adsense'){
				
				$lines=explode("\n",$adsense_code);
				foreach($lines as $key=>$value){
					$value=str_replace("/","\\/",$value);
					$value=str_replace("\r","",$value);
					echo "document.writeln('".$value."');\r\n";
				}
			}
			mysql_query("update bookings set impressions_performed=impressions_performed+1 where bannerid=".$row['serial']." and zoneid=$zoneid and status='active' and impressions_booked > impressions_performed");
		}
	}
?>