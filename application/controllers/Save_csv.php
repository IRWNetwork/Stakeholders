<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Save_csv extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Content_model');
		$this->load->model('Emailtemplates_model');
		$this->load->model('Authorize_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		$this->load->helper('form') ;
	}

	public function index(){
	}

	public function save()
	{
		if(isset($_POST['import_csv'])){
			$this->Common_model->saveCSV();
		}

		$this->load->view('user/save_csv');
	}
	
}
