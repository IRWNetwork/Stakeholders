<?php
	$zoneid=$_REQUEST['zoneid'];
	if($zoneid>0){
		$js_path="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/jsServer.php";
		$click_path="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/ck.php";
		$img_path="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/ad.php";
		$output='
<!-- ******************  The code below is generated by Ads Application    ****************** 
* don\'t forget to replace RANDOM_NUMBERR_HERE with the code that generates a random number
-->
<script language="javascript"><!--//<![CDATA[
	var r=Math.floor((Math.random()*999999999));
	var params="?zoneid='.$zoneid.'&amp;referer="+escape(document.referrer)+"&amp;location="+escape(document.location)+"&amp;cb="+r;
	
	document.write("<script type=\'text/javascript\' src=\''.$js_path.'"+params+"\'>");
	document.write("<\/script>");
//]]>--></script>
<!-- ************** Ads code end *****************************  -->
';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zone Code</title>
</head>
<body style="background-color:#FFF;">
<form>
<textarea rows="15" style="font-family:tahoma; font-size:12px; width:620px" name="ta"><?php echo $output; ?></textarea>
<div align="center">
<input type="button" value="Close" onclick="window.opener=null;window.close();">
<input type="button" value="Select All" onclick="this.form.ta.focus();this.form.ta.select()">
</div>
</form>
<br>
</body>
</html>
<?php } ?>