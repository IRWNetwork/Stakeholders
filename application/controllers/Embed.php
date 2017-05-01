<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Embed extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Emailtemplates_model');
		$this->load->library("pagination");
		$this->load->library("Ipinfo");
		$this->load->model('Events_model');
		$this->load->model('Analytics_model');
    }

	
	public function play2($id){
		$id = intval($id);
		if($id>0){
			$content_row = $this->Content_model->getRow($id);
			$userIP  = $this->ipinfo->getIPAddress();
			$browser = $this->ipinfo->getUserAgent();
			$url = $this->ipinfo->getURL();
			$info = $this->ipinfo->getCity($userIP);
			$infoArr = json_decode($info);
			
			$data = array();
			$data['ip'] 			= $infoArr->ipAddress;
			$data['country']   	   = $infoArr->countryName; 
			$data['region_name']   = $infoArr->regionName;
			$data['city']   		  = $infoArr->cityName;
			$data['broswer']	   = $browser;
			$data['referral_path'] = $url;
			$data['postal_code']   = $infoArr->countryCode;
			if($this->input->post())
			$data['source']		= "";
			$data['type']		  = $content_row['type'];
			$data['type_id']	   = $content_row['id'];
			$data['episode']	   = $content_row['title'];
			$data['date']		  = date("Y-m-d");
			$this->Analytics_model->saveAnalytics($data);
			//print_r($data);
			//die();
		}
		
		else{
			echo "404 Page Not Found";
			die();
		}
		//print_r($content_row);
		//die();
		$this->data['dataRow']		= $content_row;
		$this->data['page_heading']   = $content_row['title'];
		$parser['content']			=  $this->load->view('embed_code_view',$this->data);
		
	
	}
	
	public function justwave_ajax() {
		$arr = array(
				"status" => "ok",
				"waveurl" => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAArwAAABaAQMAAABg9he2AAAABlBMVEXAwMAyMsh0946rAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADl0lEQVRYhe3YT2jTUBwH8JdQZm2VBecQPNjWKZtMVJiHOaFmU/CghzKFCQ5SetGDoOJF8E9T2UGGUBzuKN1B8SCCnhRkTet68aIOJzgrtgNFqaOpf2pX2+bne0mcnbaStnmK2O/hlSZ9n6YhfX9+CDXTTDO0w/yfcCXkxzFrfSj/Z2FRP2b5B2CnylWExUZh0RyY0WC1u41ZCvONwAECc+wvsEWDRWsjsKUMZs2FV9nI7dbgiT0EbmkYFsUAgcVFOElgV8s21slbONHaWx88cBnDqzEccWrwegKPIJdjG7t5oFaY0T5mVeEIgQdtEa8Ku3pQMsaPODHs0+DTxmD1LINbkUcXEWIHpjG83TO4NpL0oD4Mf7Jg+JLL5biN4XZOtJ/lDcETLHJyLtHCYng0gGy+6ei77zDj1uHdlzbpsOea/XxN8AoCBwNWm+8ZhsMq/KRfhTcQeAeBt+werwXmu7iOyH72At+BYXv62RSBD6yNJjME3vhp83zsVDDvCt32ufdKhmHrdZa/d7A7cqxtzNsRjD5qTWen3j0Me56uw/A+dz/qzJ2VZ84E83MYDh+BQ1/sfkPw8lstfHF4Z+zY0Ji3OxR93CpjeFbKxIX3rzOHw3MbOnMlecYfKpQSd1Lh48bhlbeW9cPwrtj80AvvTRUuTc3PStl44v0bHQaY8UsElpXj8FzpBmPwZCuGpVhxKO4FaS6B4bfpvJQrQOFt8bDy4dpWDL8CqQCQ0+D7EDECOyYdJ3HH+WIi7gOYS+ySQS6DsyqMUyCNItcAA4YTkC4mIAWQB7+M+xcgR6iiANmsH8pggJcgGYUhi7sQ+CvpThyloFEl/PNLOvw9ihHYwqgw7g8yvmplKaHCFfI7eAXicMtieLUOV0y1E5kqsA2tQxyD2kZHBNTuqKb+JhVgnjQCcju5drQmdVWImQJziD9BBl7hitR5cLzLkZKEz3XBCzoYILMufu2djiy4jjJW/124MXw3JQD4c+dCdcBFHb6PmLGdD9BEHyhfe4rkLwSyoj72/jrUMlj6iN8oPQt1MtVhs7zFKLRgLRl6V0ztHlN7Kqg9x9T+edTHCpqjmx5K4/FizJ9ByuKgMedpMK1Zmta6gtpKiNrajdpqk9r6mNqKnuYehNKuST1LY5+nhsbO9OeYu5cuC7XdP8V6Bc0KC5WaELUqFjJcd6stFeBqlcLGYC3/HmxC/XgpYjJs9Mv+U7iZZv5qvgGqkgLeGvWEvwAAAABJRU5ErkJggg=="
				);
		echo json_encode($arr);
	}

	public function play($id){
		$id = intval($id);
		if($id>0){
			$content_row = $this->Content_model->getRow($id);
			$userIP  = $this->ipinfo->getIPAddress();
			$browser = $this->ipinfo->getUserAgent();
			$url = $this->ipinfo->getURL();
			$info = $this->ipinfo->getCity($userIP);
			$infoArr = json_decode($info);
			$data = array();
			$data['ip'] 			= $infoArr->ipAddress;
			$data['country']   	   = $infoArr->countryName; 
			$data['region_name']   = $infoArr->regionName;
			$data['city']   		  = $infoArr->cityName;
			$data['broswer']	   = $browser;
			$data['referral_path'] = $url;
			$data['postal_code']   = $infoArr->countryCode;
			$data['source']		= "";
			$data['type']		  = $content_row['type'];
			$data['type_id']	   = $content_row['id'];
			$data['episode']	   = $content_row['title'];
			$data['author_id']	 = $content_row['user_id'];
			$data['date']		  = date("Y-m-d");
			$this->Analytics_model->saveAnalytics($data);

		}
		else{
			echo "404 Page Not Found";
			die();
		}
		//echo "<pre>"; print_r($content_row);die();
		$this->data['dataRow']		= $content_row;
		$this->data['page_heading']   = $content_row['title'];
		$parser['content']			=  $this->load->view('embed_code_view',$this->data);
	}
	public function iframe(){
		$this->load->view('test',NULL);
	
	} 
	
	public function example2(){
		$this->load->view('test2',NULL);
	
	} 
}
?>