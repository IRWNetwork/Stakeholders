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
		$content_id = 0;
	 	if(!empty($this->input->get('id'))){
			$content_id = $this->input->get('id');
			$result = $this->Content_model->checkUserContent($this->input->get('id'));
			if(count($result) == 0 ){
				$this->session->set_flashdata(
						'error',
						"Sorry! you have not permission to see analytics for this content."
				);
				redirect(base_url().'content');
			}
		}

		if(isset($_GET['date'])){
			$search_date = $_GET['date'];
		}else{
			$search_date = '';
		}

		$data = array();
		$data['page_title']     = 'Analytics';
		$data['page_heading']   = 'Analytics';
		$data['channel_banner'] = $this->Users_model->getUserbanner();
		$data['data_analytics_totalPlays'] = $this->Analytics_model->getTotalByDay(0, $content_id, $search_date);
		$data['analytics_topPlays']   		= $this->Analytics_model->getTopByDay(0, $content_id, $search_date);
		$data['analytics_topCountries']	= $this->Analytics_model->getTopCountries(0, $content_id, $search_date);
		$date['maxDate'] 		= $this->Analytics_model->getMaxDateForCountries(0, $content_id);
		$date['minDate'] 		= $this->Analytics_model->getMinDateForCountries(0, $content_id);  
		$data['analytics_topCities'] = $this->Analytics_model->getTopCities(0, $content_id, $search_date);
		$data['totalPostcast']	   = $this->Content_model->getTotalEpisode();
		$data['totalListens']		= $this->Analytics_model->getTotalListens(0, $content_id);
		$data['pagesTotal']		   = $this->Analytics_model->getUrlReport(0, $content_id); 
		$data['total_plays']		 = 0;
		//print_r($date);die();
	
		foreach( $data['data_analytics_totalPlays'] as $field=> $value){
			$value['date'] = date('Y-m-d',strtotime($value['date'].' -1 months '));
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