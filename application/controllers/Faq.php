<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Faq extends Common_Controller {


	function __construct() {

        parent::__construct();
		$this->load->model('Faq_model');
		$this->load->library('ion_auth');
    }

	public function index(){

		$data['Allfaq'] = $this->Faq_model->getAll();
		
		
		$data['page_title']    	= 'FAQ';
		$data['page_heading']  	= 'FAQ';
		
		
		if (isset($_POST['flag'])) {
			echo $this->load->view('faq',$data,TRUE);
		}
		else {
			$parser['content']	=  $this->load->view('faq',$data,TRUE);
	        $this->parser->parse('template', $parser);
		}
        // $parser['content'] = $this->load->view('faq',$data,TRUE);
        // $this->parser->parse('template', $parser);
	}
	
}
