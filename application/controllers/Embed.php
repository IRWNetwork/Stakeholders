<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Embed extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Emailtemplates_model');
		$this->load->library("pagination");
		$this->load->model('Events_model');
    }
	
	public function play($id){
		$id = intval($id);
		if($id>0){

			$content_row = $this->Content_model->getRow($id);
		}
		else{
			echo "404 Page Not Found";
			die();
		}
		//print_r($content_row);
		//die();
		$this->data['dataRow']		= $content_row;
		$this->data['page_heading']   = $content_row['title'];
		$parser['content']			=  $this->load->view('embed_code_view',$this->data);
	}
}