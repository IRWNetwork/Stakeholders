<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stats extends CI_Controller
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


	public function analytics() {

		$data = array();
		$data['page_title']     = 'Analytics';
		$data['page_heading']   = 'Analytics';
		$data['channel_banner'] = $this->Users_model->getUserbanner();
		$data['data_analytics_totalPlays'] = $this->Analytics_model->getTotalByDay();
		$data['analytics_topPlays']   		= $this->Analytics_model->getTopByDay();
		$data['analytics_topCountries']	= $this->Analytics_model->getTopCountries();
		$date['maxDate'] 		= $this->Analytics_model->getMaxDateForCountries();
		$date['minDate'] 		= $this->Analytics_model->getMinDateForCountries();  
		$data['analytics_topCities'] = $this->Analytics_model->getTopCities();
		$data['totalPostcast']	   = $this->Content_model->getTotalEpisode();
		$data['totalListens']		= $this->Analytics_model->getTotalListens();
		$data['pagesTotal']		   = $this->Analytics_model->getUrlReport(); 
		$data['total_plays']		 = 0;
		//print_r($date);die();
	
		foreach( $data['data_analytics_totalPlays'] as $field=> $value){
			$data['data_analytics_totalPlays'][$field]['date'] =  str_replace("-",",",$value['date']);
			$data['total_plays'] += $value['count'];
		} 
		
		//print_r($data); die();
		$parser['content'] = $this->load->view('stats/graphs',$data,TRUE);
	    $this->parser->parse('template', $parser);
		//$parser['content'] = $this->load->view('stats/stats',$data,TRUE);
	    //$this->parser->parse('template', $parser);	
	}
}

?>