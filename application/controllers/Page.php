<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Page extends MY_Controller {


	function __construct() {

        parent::__construct();
		$this->load->model('Pages_model');
    }

	public function index(){
		$id = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		
		$row = $this->Pages_model->getRowBySeoUrl($id);
		$this->data['pagerow'] = $row;
		
		
		$this->data['page_title']    	= $row['title'];
		$this->data['page_heading']  	= $row['title'];
		
		
        $parser['content']				=  $this->load->view('page',$this->data,TRUE);
        $this->parser->parse('template', $parser);
	}
	
}