<?php
class Preferences extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Preferences_model');
		$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}

    }
    
	public function index() {
		//$data['pages']         = $this->Pages_model->getAllPages();
		$data['page_title']    = 'Preferences';
		$data['page_heading']  = 'Preferences';

		$data['success'] = $this->input->get('msg') ? $this->input->get('msg') : '';

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
	
}
