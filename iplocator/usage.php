<?php

error_reporting(-1);
require_once 'Ipinfo.php';
// Create a new instance

$ipInfo = new Ipinfo ('c8f692ebd284dc4305b5f499a3ef8db53f44ac746ece02d9a2060189f1c0186d' , 'json');



$userIP  = $ipInfo->getIPAddress();
$browser = $ipInfo->getUserAgent();
$url = $ipInfo->getURL();
$info = $ipInfo->getCity($userIP);
$infoArr = json_decode($info);
//print_r($infoArr);
foreach($infoArr AS $key => $value){
	echo  $key . ": ". $value."<br>";
}
echo "Browser: ".$browser."<br>";
echo "URL: ".$url."<br>";