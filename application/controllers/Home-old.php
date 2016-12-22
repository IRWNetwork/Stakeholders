<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
    }
    
	public function index()
	{
		$data['page_title'] 	= 'Home';
		$data['page_heading'] 	= 'Home';
        $parser['content']		=	$this->load->view('admin/dashboard',$data,TRUE);
        $this->parser->parse('template', $parser);
	}
	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('success', 'Logout Successfully');
		redirect(base_url()."user");
	}
}