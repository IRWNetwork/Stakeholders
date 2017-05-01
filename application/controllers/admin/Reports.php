<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Reports_model');
		$this->load->model('Common_model');
		$this->load->model('Emailtemplates_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');

    }
	
	
	public function user_statistics(){
		$date = ($this->input->get('date'))?$this->input->get('date'): 0;
		$data['page_title'] 	 = 'Register Users Statistics';
		$data['page_heading']   = 'Register Users Statistics';
		$result = $this->Reports_model->getRegisterUsersReport($date);
		$dates = array();
		$count = array();
		$data['selectValues'] = array();
		if(!empty($this->input->get('date'))){
			$data['selectValues'] =  explode("-", $this->input->get('date')); 
		}
		else{
			$data['selectValues'] =  explode("-", date("Y-m")); 
		}
		
		foreach( $result as $field => $value){
			$month = date("m",strtotime($value['niceDate']));
			$year  = date("Y",strtotime($value['niceDate']));
			$day   = date("d",strtotime($value['niceDate']));
			$date  = $year.",".($month-1).",".$day;
			$result[$field]['niceDate'] = $date;
			//date("Y-m-d", strtotime("+1 month", $time));
			//$result[$field]['niceDate'] =  str_replace("-",",",$value['niceDate']);
			
		} 
		//print_r($result); die("ghg");
		$data['userData'] = $result;
		$parser['content']	= $this->load->view('admin/reports',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	

}
