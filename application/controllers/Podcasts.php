<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Podcasts extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
    }
    
	public function index()
	{

		$this->data['page_title'] 	= 'Podcasts';
		$this->data['page_heading'] 	= 'Podcasts';
		
		
		$search 			   = $this->input->get('search')?$this->input->get('search'):"";
        $arr['name']           = $search;
        $arr['type']           = 'Podcasts';
		$config 			   = array();
        $config["base_url"]    = base_url() . "podcasts/index";
        $config["total_rows"]  = $this->Content_model->countTotalRows($arr);
		if ($this->input->get('per_page')){
			$config["per_page"] = $this->input->get('per_page');
		}
		else {
        	$config["per_page"] = 20;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string'] = true;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$this->data['contents']= $this->Content_model->getAllData($arr,$page,$config["per_page"]);
		$this->data["links"]   = $this->pagination->create_links();
		$this->data['featured']	= $this->Content_model->getFeaturedData($arr);
		$this->data['total_rows'] = $config["total_rows"];
		$this->data['bannerDetail'] = $this->Content_model->getBannerRowByField("page","podcasts");
		if (isset($_POST['flag'])) {
			echo $this->load->view('podcasts',$this->data,TRUE);
		}
		else {
			$parser['content']	=  $this->load->view('podcasts',$this->data,TRUE);
	        $this->parser->parse('template', $parser);
		}
	}


	public function podcasts_ajax() {
		$search 			   = $this->input->get('search')?$this->input->get('search'):"";
        $arr['name']           = $search;
        $arr['type']           = 'Podcasts';
		$config 			   = array();
        $config["base_url"]    = base_url() . "podcasts/index";
        $config["total_rows"]  = $this->Content_model->countTotalRows($arr);
		if ($this->input->get('per_page')){
			$config["per_page"] = $this->input->get('per_page');
		}
		else {
        	$config["per_page"] = 20;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string'] = true;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$this->data['contents']= $this->Content_model->getAllData($arr,$page,$config["per_page"]);
		$this->data["links"]   = $this->pagination->create_links();
		$this->data['featured']	= $this->Content_model->getFeaturedData($arr);
		$this->data['total_rows'] = $config["total_rows"];
		if (count($this->data['contents']) > 0) {

			echo $this->load->view('podcasts_limit',$this->data,TRUE);
		}
	}
}