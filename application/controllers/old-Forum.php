<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends MY_Controller
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
		$this->data['page_title'] 	= 'Forum';
		$this->data['page_heading'] 	= 'Forum';
		
		
		if (isset($_POST['flag'])) {
			echo $this->load->view('forums',$this->data,TRUE);
		}
		else {
			$parser['content']	=  $this->load->view('forums',$this->data,TRUE);
	        $this->parser->parse('template', $parser);
		}
        // $parser['content']		=  $this->load->view('forums',$this->data,TRUE);
        // $this->parser->parse('template', $parser);
	}
}