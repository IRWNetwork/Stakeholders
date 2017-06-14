<?php
class Setting extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Preferences_model');
		$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}

    }
    
	public function edit_social() {
		$data['page_title']    = 'Social Setting';
		$data['page_heading']  = 'Social Setting';

		if($this->input->post()){
			$this->Preferences_model->update('facebook_link',$this->input->post('facebook_link'));
			$this->Preferences_model->update('twitter_link',$this->input->post('twitter_link'));
			$this->Preferences_model->update('instagram_link',$this->input->post('instagram_link'));
		}

		$data['facebook_link']  =  $this->Preferences_model->getValue('facebook_link');
		$data['twitter_link']   =  $this->Preferences_model->getValue('twitter_link');
		$data['instagram_link'] =  $this->Preferences_model->getValue('instagram_link');
		$parser['content']      = $this->load->view('admin/preferences',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function edit_popup(){
		$data['page_title']    = 'PopUp Setting';
		$data['page_heading']  = 'PopUp Setting';

		$data['success'] = $this->input->get('msg') ? $this->input->get('msg') : '';

		if($this->input->post()){
			$this->Preferences_model->update('popup_content',base64_encode($this->input->post('popup_content')));
		}

		$data['popup_content']  = base64_decode( $this->Preferences_model->getValue('popup_content'));
		$parser['content']      = $this->load->view('admin/edit_popup',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	
	} 
	public function edit_feedback_email_notice(){
		$data['page_title']    = 'Email Notice Setting';
		$data['page_heading']  = 'Email Notice Setting';
		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'email_notice',
                     'label'   => 'Notice Email',
                     'rules'   => 'trim|required|valid_email'
                )
            );
			$this->form_validation->set_rules($rules);
			}



		if($this->input->post()){
			$this->Preferences_model->update('feed_back_notice_email',$this->input->post('email_notice'));
		}

		$data['feed_back_notice_email']  = $this->Preferences_model->getValue('feed_back_notice_email');
		$parser['content']      = $this->load->view('admin/edit_feedback_email_notice',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	
	}


	public function payment_preferences() {
		$data['page_title']    = 'Preferences';
		$data['page_heading']  = 'Payment Settings';

		if($this->input->post()){
			if($this->input->post('payment_checkbox')){
				$payment_status = $this->input->post('payment_checkbox');
			}else{
				$payment_status = 'no';
			}
			$this->Preferences_model->update('payment', $payment_status);
			$this->session->set_flashdata('success', "Settings Updated Successfully.");
		}

		$data['payment_status']  =  $this->Preferences_model->getValue('payment');
		$parser['content']      = $this->load->view('admin/payment_preferences',$data,TRUE);
		$this->parser->parse('admin/template', $parser);
	}



}// end class
