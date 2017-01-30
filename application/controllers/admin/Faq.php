<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Faq_model');
		$this->load->model('Common_model');
		$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
    }
    
	public function index() {
		
		$data['page_title'] 	= 'FAQ';
		$data['page_heading'] 	= 'FAQ';
		
		$data['pages']	   = $this->Faq_model->getAll();
		
        $parser['content']	   = $this->load->view('admin/faq/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function add() {
		
		$data['page_title']       = 'Add FAQ';
		$data['page_heading']     = 'Add FAQ';
		
		if($this->input->post()) {
			$rules = array(
			    array(
                	'field'   => 'question',
                 	'label'   => 'Question',
                 	'rules'   => 'trim|required'
              	),
              	array(
                     'field'   => 'answer',
                     'label'   => 'Answer',
                     'rules'   => 'trim|required'
                )
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$array = array(
							"question"  	 	=> $this->input->post('question'),
							"answer"  	 		=> $this->input->post('answer')
						 );
				
				$user_record			=	$this->Faq_model->save($array);
				if($user_record) {
					redirect('admin/faq?msg=Added Successfully');
				}else {
					$data['error']	    = 'Some Error try later';
					$data['questionDetail'] = $_REQUEST;
				}
				
			}else{
				$data['questionDetail'] = $_REQUEST;
			}
		}else {
			$data['questionDetail'] = array();
		}
		
        $parser['content']	   = $this->load->view('admin/faq/add',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function edit() {

		$pageRow                 = $this->Faq_model->getRow($this->input->get('id'));

		if($pageRow) {
			$data['questionDetail']  = $pageRow;
		}else {
			redirect(base_url()."admin/faq?msg=Invalid Page");
		}
		$data['page_title']       = 'Edit FAQ';
		$data['page_heading']     = 'Edit FAQ';

		if($this->input->post()) {
			$rules = array(
			    array(
                	'field'   => 'question',
                 	'label'   => 'Question',
                 	'rules'   => 'trim|required'
              	),
              	array(
                     'field'   => 'answer',
                     'label'   => 'Answer',
                     'rules'   => 'trim|required'
                )
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$array = array(
							"question"  	 	=> $this->input->post('question'),
							"answer"  	 		=> $this->input->post('answer')
						 );
				$user_record	=	$this->Faq_model->update($array,$this->input->post('id'));
				if($user_record) {
					redirect('admin/faq?msg=Updated Successfully');
				}else {
					$data['error']	    = 'Some Error try later';
					$data['questionDetail'] = $_REQUEST;
				}
				
			}else{
				$data['questionDetail'] = $_REQUEST;
			}
		}

        $parser['content']	   = $this->load->view('admin/faq/edit',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function delete($id) {
		$data['user'] = $this->Faq_model->delete($id);
		redirect('admin/faq?msg=Deleted Successfully');
	}
}
