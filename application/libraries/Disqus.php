<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Disqus {
	function __construct() {
		//parent::__construt();
	}
	function dsq_hmacsha1($data, $key) {
		$blocksize=64;
		$hashfunc='sha1';
		if (strlen($key)>$blocksize)
			$key=pack('H*', $hashfunc($key));
		$key=str_pad($key,$blocksize,chr(0x00));
		$ipad=str_repeat(chr(0x36),$blocksize);
		$opad=str_repeat(chr(0x5c),$blocksize);
		$hmac = pack(
					'H*',$hashfunc(
						($key^$opad).pack(
							'H*',$hashfunc(
								($key^$ipad).$data
							)
						)
					)
				);
		return bin2hex($hmac);
	}
	function configure_sso($login,$url, $id, $title, $userid, $email){
		if($login){
			define('DISQUS_SECRET_KEY', 'MnhockBRlbii7GXKpF4ICnbH2OvVnIK0tmczaDtS3uDLdYCJzJDvtZQObG4v5bDw');
			define('DISQUS_PUBLIC_KEY', 'WrKAgAxV54w7dE5QMONssqCySUSDUDTmCTFuwkYOX4OHmNaAP4ZiTSoYddneF8nj');
				$data = array(
						"id" 		=> $userid,
						"username" 	=> $email,
						"email" 	=> $email
					);
				$message = base64_encode(json_encode($data));
				$timestamp = time();
				$hmac = $this->dsq_hmacsha1($message . ' ' . $timestamp, DISQUS_SECRET_KEY);
				$html='<script type="text/javascript">  
				var disqus_config = function() {
					this.page.remote_auth_s3 = "'.$message." ".$hmac." ".$timestamp.'";
					this.page.api_key = "'.DISQUS_PUBLIC_KEY.'"; 
					this.page.url = "'.$url.'"; 
					this.page.identifier = "'.$id.'";
					this.page.id = "'.$id.'"; 
					this.page.title = "'.$title.'"; 
				};
				</script>';
				
				echo $html;
		}
		else{
		echo " ";
		}
	}
}
