<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){
		
		parent::__construct();

		$this->load->model('users_model');
		$this->load->model('user_groups_model');
		$this->load->model('Setup_model');
		$this->load->library('email');
		$this->load->helper(array('form', 'url', 'file'));
	}
}