<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function changeDateTimeToSQLDateTime($date){
	$arr = explode(" ",$date);
	$date = $arr[0];
	$time = $arr[1];
	
	$date = explode('-',$date);
	
	$new_date = $date[2]."-".$date[0]."-".$date[1];
	
	return $new_date." ".$time;
}

function changeDateToSQLDate($date){
	$date = explode('-',$date);

	$new_date = $date[2]."-".$date[0]."-".$date[1];

	return $new_date;
}

function getContentUrl($row){
	if ($this->ion_auth->logged_in()) {
		if($row->is_premium=='yes'){
			$url = base_url()."user/login";
		}else{
			$url = "";
		}
	}else{
		$url="";
	}
	return $url;
}

function getNextRechargeDate($type){
	$add_months = "";
	if($type == 'monthly'){
		$add_months = "1 Month";
	}else if($type == 'yearly'){
		$add_months = "12 Month";
	}else if($type == 'quarterly'){
		$add_months = "3 Month";
	}
	$next_recharge_date = date("Y-m-d",strtotime("+".$add_months));
	return $next_recharge_date;
}

function getPrepaidNextRechargeDate($add_month){
	$next_recharge_date = date("Y-m-d",strtotime("+".$add_month));
	return $next_recharge_date;
}

function init_Braintree(){
	require_once APPPATH."/third_party/braintree-php/lib/Braintree.php";
	Braintree_Configuration::environment("sandbox");
	Braintree_Configuration::merchantId("cnh6d5kt9f839mfh");
	Braintree_Configuration::publicKey("cggnwvrvz44nrmfh");
	Braintree_Configuration::privateKey("c0cc81d6242af896bfef79f19e004538");
	return Braintree_ClientToken::generate();
}

function initialize_Braintree(){
	require_once APPPATH."/third_party/braintree-php/lib/Braintree.php";
	Braintree_Configuration::environment("sandbox");
	Braintree_Configuration::merchantId("cnh6d5kt9f839mfh");
	Braintree_Configuration::publicKey("cggnwvrvz44nrmfh");
	Braintree_Configuration::privateKey("c0cc81d6242af896bfef79f19e004538");
}

function get_random_auth_code()
{
	return substr(md5(rand(0, 1000000)), 0, 50);
}

function get_month_name($month)
{
	return date("F", mktime(0, 0, 0, $month, 10));	
}

function convertToHoursMins($time, $format = '%d:%d') {
	settype($time, 'integer');
	if ($time < 1) {
		return;
	}
	$hours = floor($time / 60);
	$minutes = ($time % 60);
	return sprintf($format, $hours, $minutes);
}

function getPagingNextLink($currentPage,$totalRecords,$perPage,$pageByNumber=false){
	
	if($totalRecords==0){
		return "";
	}
	
	$page = "";
	$totalPages = ceil($totalRecords/$perPage);
	if($pageByNumber){
		if($currentPage==''){
			$page = 2;
		}else if($currentPage<($totalPages)){
			$page = $currentPage+1;
		}else{
			$page = "";
		}
		return $page;
	}

	if($currentPage!='' && ($currentPage/$perPage)<($totalPages-1)){
		$page = $currentPage+1*$perPage;
	}else if(($currentPage/$perPage)==($totalPages-1)){
		$page = "";
	}else{
		$page = $perPage;
	}
	return $page;
	
}

function getPreviousLink($currentPage,$totalRecords,$perPage,$pageByNumber=false){
	
	if($totalRecords==0){
		return "";
	}
	
	$page = "";
	$totalPages = ceil($totalRecords/$perPage);
	if($pageByNumber){
		if($currentPage==''){
			$page = "";
		}else if($currentPage<=($totalPages)){
			$page = $currentPage-1;
		}
		return $page;
	}
	
	if($currentPage==""){
		$page = "";
	}else if($currentPage!=''){
		$page = ($currentPage/$perPage-1)*$perPage;
	}else if(($currentPage/$perPage)==($totalPages-1)){
		$page = ceil(($totalPages/$perPage)-1);
	}
	return $page;
	
}

?>