<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Podcasts extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Emailtemplates_model');
		$this->load->model('Content_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
    }
    
	public function index()
	{
		$data['page_title'] 	= 'Podcasts';
		$data['page_heading'] 	= 'Podcasts';
		
		
		$search 			   = $this->input->get('search')?$this->input->get('search'):"";
        $arr['name']           = $search;
        $arr['type']           = 'Podcasts';
		$config 			   = array();
        $config["base_url"]    = base_url() . "products/search";
        $config["total_rows"]  = $this->Content_model->countTotalRows($arr);
		if($this->input->get('per_page')){
			$config["per_page"]= $this->input->get('per_page');
		}else{
        	$config["per_page"]= 20;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string']   = true;

        $this->pagination->initialize($config);
        $page 		           = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['contents']= $this->Content_model->getAllData($arr,$page,$config["per_page"]);
		$data["links"]   = $this->pagination->create_links();
		
		
        $parser['content']	=  $this->load->view('podcasts',$data,TRUE);
        $this->parser->parse('template', $parser);
	}
}