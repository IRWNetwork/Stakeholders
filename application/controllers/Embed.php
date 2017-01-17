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
			if($this->input->post())
			$data['source']		= "";
			$data['type']		  = $content_row['type'];
			$data['type_id']	   = $content_row['id'];
			$data['episode']	   = $content_row['title'];
			$data['date']		  = date("Y-m-d");
			$this->Analytics_model->saveAnalytics($data);

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
	public function iframe(){
		$this->load->view('test',NULL);
	
	} 
	
	public function example2(){
		$this->load->view('test2',NULL);
	
	} 
}
?>