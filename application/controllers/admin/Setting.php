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

	public function popupSettings() {
		$data['page_title']    = 'Popup Settings';
		$data['page_heading']  = 'Popup Settings';

		$data['popup_check']  = $this->Preferences_model->popup_check('show_popup');
		$data['all_popups']  = $this->Preferences_model->get_all_popups();
		//echo "<pre>"; print_r($data['all_popups']);exit;
		$parser['content']      = $this->load->view('admin/popup_settings.php',$data,TRUE);
		$this->parser->parse('admin/template', $parser);
	}

	public function editPopup($id) {
		$data['page_title']    = 'Edit Popup';
		$data['page_heading']  = 'Edit Popup';

		if ($this->input->post()) {
			$data = array(
				'title'	=> $this->input->post('title'),
				'page'	=> $this->input->post('page'),
				'value'	=> base64_encode($this->input->post('value')),
				'status'	=> 0
			);

			$this->Preferences_model->editPopup($id, $data);
			$this->session->set_flashdata(
							'success',
					"Updated Successfully"
			);
			redirect(base_url()."admin/setting/popupSettings");
		}	
		$data['popup_data'] = $this->Preferences_model->getPopupById($id);
		$parser['content'] = $this->load->view('admin/add_edit_popup',$data,TRUE);
		$this->parser->parse('admin/template', $parser);	
	}

	public function addPopup() {
		$data['page_title']    = 'Add Popup';
		$data['page_heading']  = 'Add Popup';

		if ($this->input->post()) {
			$data = array(
				'title'	=> $this->input->post('title'),
				'page'	=> $this->input->post('page'),
				'value'	=> base64_encode($this->input->post('value')),
				'status'	=> 0
			);
			$this->Preferences_model->addPopup($data);
			$this->session->set_flashdata(
							'success',
					"Added Successfully"
			);
			redirect(base_url()."admin/setting/popupSettings");
		}

		$parser['content']      = $this->load->view('admin/add_edit_popup',$data,TRUE);
		$this->parser->parse('admin/template', $parser);
	}

	public function selectPage() {
		$page = $this->input->post('page');
		$data['all_popups']  = $this->Preferences_model->get_all_popups_by_page($page);
		echo $this->load->view('admin/popup_settings_ajax',$data,TRUE);
	}

	public function updatePopupSettings() {
		$showPopup = $this->Preferences_model->showPopup($this->input->post('show_popup'));
		echo $showPopup;
	}

	public function selectPopup() {
		
		$selectPopup = $this->Preferences_model->selectPopup($this->input->post('id'), $this->input->post('page'));
		echo $selectPopup;
	}



}// end class
