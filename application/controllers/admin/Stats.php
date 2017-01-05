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

	public function statistics() {

		$data = array();
		$data['page_title']   = 'Statistics';
		$data['page_heading'] = 'Statistics';
		$parser['content'] = $this->load->view('admin/stats/stats',$data,TRUE);
	    $this->parser->parse('admin/template', $parser);	
	}

	public function charts() {

		$data = array();
		$data['page_title']   = 'Graphs';
		$data['page_heading'] = 'Graphs';
		$parser['content'] = $this->load->view('admin/stats/graphs',$data,TRUE);
	    $this->parser->parse('admin/template', $parser);	
	}
}

?>