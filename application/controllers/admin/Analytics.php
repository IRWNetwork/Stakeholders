<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Common_model');
		$this->load->library("pagination");
		$this->load->model('Analytics_model');
		$this->load->model('Users_model');
		$this->load->model('Content_model');
		$this->load->helper('csv');
		$this->load->library('ion_auth');
    }


	public function index($user_id=0) {
		$data = array();
		$channel_name = $this->Users_model->getChannelNameById($user_id);
		$content_id = 0;
	 	if(!empty($this->input->get('id'))){
			$content_id = $this->input->get('id');
		}
		
		if(count($channel_name)>0){
			$data['page_title']     = $channel_name['channel_name'].' Analytics';
			$data['page_heading']   = $channel_name['channel_name'].' Analytics';
		}else{
			$data['page_title']     = 'Analytics';
			$data['page_heading']   = 'Analytics';
		}
		$data['channel_id']	 = $user_id;
		$data['channel_banner'] = $this->Users_model->getUserbannerById($user_id);
		$data['data_analytics_totalPlays'] = $this->Analytics_model->getTotalByDay($user_id, $content_id); 
		$data['analytics_topPlays']   		= $this->Analytics_model->getTopByDay($user_id, $content_id);
		//print_r($data['analytics_topPlays']); die('fdffd');
		$data['analytics_topCountries']	= $this->Analytics_model->getTopCountries($user_id, $content_id);
		$date['maxDate'] 			 	   = $this->Analytics_model->getMaxDateForCountries($user_id, $content_id);
		$date['minDate'] 			 	   = $this->Analytics_model->getMinDateForCountries($user_id, $content_id);  
		$data['analytics_topCities'] 	   = $this->Analytics_model->getTopCities($user_id, $content_id);
		$data['totalPostcast']	   		 = $this->Content_model->getTotalEpisodeById($user_id);
		$data['totalListens']			  = $this->Analytics_model->getTotalListens($user_id, $content_id);
		$data['pagesTotal']		  		= $this->Analytics_model->getUrlReport($user_id, $content_id); 
		$data['total_plays']		 	   = 0;
		$data['channels_info']			 = $this->Users_model->getChannelsUserInfo();
		//print_r($data['channels_info']); die();
		//print_r($date);die();
		foreach( $data['data_analytics_totalPlays'] as $field=> $value){
			$value['date'] = date('Y-m-d',strtotime($value['date'].' -1 months '));
			$data['data_analytics_totalPlays'][$field]['date'] =  str_replace("-",",",$value['date']);
			$data['total_plays'] += $value['count'];
		} 
		
		//print_r($data); die();
		$parser['content'] = $this->load->view('admin/stats/graphs',$data,TRUE);
	    $this->parser->parse('admin/template', $parser);
		//$parser['content'] = $this->load->view('stats/stats',$data,TRUE);
	    //$this->parser->parse('template', $parser);	
	}
}

?>