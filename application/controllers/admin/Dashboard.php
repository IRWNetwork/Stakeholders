<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard extends CI_Controller

{

	function __construct()

    {

        parent::__construct();

		$this->load->model('Users_model');

		$this->load->library('ion_auth');

    }
    

	public function index()

	{
		//echo $this->ion_auth->get_users_groups()->row()->id;
		///	die('adf');
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->in_group(1)) {
			$this->session->set_flashdata(
				'error',
				"Invalid User Group"
			);
			redirect(site_url('admin/'), 'refresh');
		}
		$data['page_title'] 	= 'Dashboard';
		$data['page_heading'] 	= 'Dashboard';
        $parser['content']		=	$this->load->view('admin/dashboard',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	

	public function logout()

	{

		$this->session->sess_destroy();

		$this->session->set_flashdata('success', 'Logout Successfully');

		redirect(base_url()."user");

	}

}