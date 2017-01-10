<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stats extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Common_model');
		$this->load->library("pagination");
		$this->load->helper('csv');
    }

	public function analytics() {

		$data = array();
		$data['page_title']   = 'Analytics';
		$data['page_heading'] = 'Analytics';
		$parser['content'] = $this->load->view('admin/stats/graphs',$data,TRUE);
	    $this->parser->parse('admin/template', $parser);
		//$parser['content'] = $this->load->view('admin/stats/stats',$data,TRUE);
	    //$this->parser->parse('admin/template', $parser);	
	}
}

?>