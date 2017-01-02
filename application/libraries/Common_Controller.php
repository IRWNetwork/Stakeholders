<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	var $data = array();
	function __construct() {

        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Categories_model');
		$this->load->model('Preferences_model');
		
		$this->data['headerCategories'] = $this->Categories_model->getParentCategories();
    }

	public function index(){
		$this->load->view('index',$this->data);
	}
}
