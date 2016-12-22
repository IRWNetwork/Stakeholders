<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller
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
		$data['page_title'] 	= 'Forum';
		$data['page_heading'] 	= 'Forum';
		
		
        $parser['content']		=  $this->load->view('forums',$data,TRUE);
        $this->parser->parse('template', $parser);
	}
}