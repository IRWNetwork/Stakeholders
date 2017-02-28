<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		$this->load->model("Common_model");
		$this->gallery_path = realpath(APPPATH . '../uploads');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(3)) {
			redirect(site_url('/'), 'refresh');
		}
    }
    
	public function index()
	{
		
		$data['page_title'] 	  = 'Subscription Channel';
		$data['page_heading'] 	= 'Subscription Channel';
		$arr['name']             = $this->input->get('name') ? $this->input->get('name') : '';
		$arr['portalUsers']	  = $this->input->get('portalUsers') ? $this->input->get('portalUsers') : 'no';
		$config 			   	  = array();
        $config["base_url"]      = base_url() . "subscribechannel";
        $config["total_rows"]  	= $this->Users_model->countTotalChannelRowsByUserId($this->ion_auth->user()->row()->id, $arr);
        $config["per_page"]      = 10;
        $config["uri_segment"]   = 2;
		$config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $page 					= ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$data['channels']	   = $this->Users_model->getAllChannelByUserId($this->ion_auth->user()->row()->id, array(),$page,$config["per_page"]);
		$data["links"]         = $this->pagination->create_links();
		print_r($data['channels']); die;
        $parser['content']	   = $this->load->view('user/channel_subscription_listing',$data,TRUE);
        $this->parser->parse('template', $parser);
	}
	
	
}