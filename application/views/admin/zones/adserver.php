<?php
	$doc_root=$_SERVER['DOCUMENT_ROOT'];
	include_once($doc_root."/adManagement/includes/dbconnect.php");
	include_once($doc_root."/adManagement/includes/config.php");	
	include_once($doc_root."/adManagement/includes/functions.php");
	
	function getCode($zoneid){
		global $db_link;
		$result=mysql_query("select * from bookings where zoneid=$zoneid and status='active'",$db_link);
		$row=mysql_fetch_array($result);
		if($row){
			$banner_result=mysql_query("select * from banners where serial=".$row['bannerid']);
			$banner_row=mysql_fetch_array($banner_result);
			mysql_close($db_link);
			return '<img src="'.$doc_root."/adManagement/banners/".$banner_row['path'].'">';
		}
		else{
			mysql_close($db_link);			
			return '<div>&nbsp;</div>';
		}
	}

?>

