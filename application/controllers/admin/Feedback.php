<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Feedback extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Feedback_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		$this->load->model("Common_model");
		$this->gallery_path = realpath(APPPATH . '../uploads');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
    }
    
	public function index()
	{
		
		$data['page_title'] 	 	= 'Feedback';
		$data['page_heading']  		= 'Feedback';
		$arr['name']            	= $this->input->post('name') ? $this->input->post('name') : '';
		$config 			   	 	= array();
        $config["base_url"]     	= base_url() . "admin/feedback";
        $config["total_rows"]   	  = $this->Feedback_model->countTotalRows($arr);
        $config["per_page"]     	= 10;
        $config["uri_segment"]  	= 3;
		$config['reuse_query_string'] = TRUE;
		
        $this->pagination->initialize($config);
        $page 		           = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['feedbacks']	   = $this->Feedback_model->getAllData($page,$config["per_page"],$arr['name']);
		//echo "<pre>"; print_r($data['feedbacks']);exit;
		$data["links"]         = $this->pagination->create_links();
		if($this->input->get('msg')){
			$this->session->set_flashdata('success',$this->input->get('msg'));
		}
        $parser['content']	   = $this->load->view('admin/feedback/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function detail($id=0){
		$data['page_title'] 	 	= 'Feedback Detail';
		$data['page_heading']  		= 'Feedback Detail';
		if($id<=0){
			redirect(site_url('admin/feedback'), 'refresh');
		}
		$data['feedbackInfo']	   = $this->Feedback_model->getInfoById($id);
		
		if(count($data['feedbackInfo'])==0){
			redirect(site_url('admin/feedback'), 'refresh');
		}
		else{
			
			$data['feedbackInfo']["full_name"] = $data['feedbackInfo']['first_name']." ".$data['feedbackInfo']['last_name']; 
			$parser['content']	   = $this->load->view('admin/feedback/detail',$data,TRUE);
        	$this->parser->parse('admin/template', $parser);
		}
	}
	public function isRead($id=0){
		if($id<=0){

			redirect(site_url('admin/feedback'), 'refresh');
			
		}
		
		$data['page_title'] = 'Feedback';
		$data['page_heading'] = 'Feedback';
		$data['feedbackInfo'] = $this->Feedback_model->getInfoById($id);
		//echo "<pre>"; print_r($data['feedbackInfo']);exit;
		if($this->input->post()) {
			$this->Feedback_model->saveResponse($id, $this->input->post());
			$this->Feedback_model->updateIsRead($id);
			redirect(site_url('admin/feedback'), 'refresh');
				
		}

		$parser['content'] = $this->load->view('admin/feedback/feedback_single',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function responsed() {
		$data['page_title'] = 'Responsed';
		$data['page_heading'] = 'Responsed';
		$data['feedbacks'] = $this->Feedback_model->getResponsedFeedback();
		//echo "<pre>"; print_r($data['feedbacks']);exit;

		$parser['content'] = $this->load->view('admin/feedback/responsed',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
}
