<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Feedback_model');
		$this->load->model('Emailtemplates_model');
		$this->load->model('Preferences_model');
		$this->load->library('ion_auth');
    }
    
	public function index()
	{
		
		$data['page_title'] 	= 'Feedback';
		$data['page_heading']  = 'Feedback';
		
		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'subject',
                     'label'   => 'Subject',
                     'rules'   => 'trim|required'
                ),
               	array(
                     'field'   => 'message',
                     'label'   => 'Message',
                     'rules'   => 'trim|required'
                )
            );
			$this->form_validation->set_rules($rules);
			}


			if ($this->form_validation->run()) {
			
				$file_name 		= "";
				$picture_name	= "";
				
				$data	= array(
								"subject" 	 => $this->input->post('subject'),
								"message" 	 => $this->input->post('message'),
								"user_id"	 => $this->ion_auth->user()->row()->id,
								"date"		=> date("Y-m-d")
							);
				$result = $this->Feedback_model->save($data);
				if($result){
					$data	= array(
								"subject" 	 => $this->input->post('subject'),
								"message" 	 => $this->input->post('message'),
								"email"	   => $this->Preferences_model->getValue('feed_back_notice_email'),
								"full_name"   => $this->ion_auth->user()->row()->first_name." ".$this->ion_auth->user()->row()->last_name,
							);
					$result = $this->Emailtemplates_model->sendMail('feed_back_notice',$data);
					$this->session->set_flashdata(
							'success',
							"Thank you for your feedback"
					);
					redirect(base_url()."feedback");
				}else{
					$data['feedBackRow'] = $this->input->post();
				}
			}else{
				$data['feedBackRow'] = $this->input->post();
			}
		
		
        $parser['content']		= $this->load->view('add_feed_back',$data,TRUE);
        $this->parser->parse('template', $parser);
	}
	
}