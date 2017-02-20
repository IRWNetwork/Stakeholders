<?php 
class Advertisers extends CI_Controller {
	function __construct()
    {
        parent::__construct();
		$this->load->model('Advertiser_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
    }

    public function index() {
    	$data['page_title'] 	 = 'Advertisers';
		$data['page_heading']   = 'Advertisers';

		$data['advertisers'] = $this->Advertiser_model->getAll();
		
        $parser['content']	   = $this->load->view('admin/advertisers/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }

    public function add_advertisers() {

    	$data['page_title'] 	 = 'Add Advertisers';
		$data['page_heading']   = 'Add Advertisers';

    	if ($this->input->post()) {
    		
    		$rules = array(
              	array(
                     'field'   => 'fullname',
                     'label'   => 'Email',
                     'rules'   => 'required'
                ),
               	array(
                     'field'   => 'email',
                     'label'   => 'email',
                     'rules'   => 'trim|required|valid_email'
                ),
                array(
                     'field'   => 'weburl',
                     'label'   => 'weburl',
                     'rules'   => 'valid_url'
                ),
                array(
                     'field'   => 'phoneno',
                     'label'   => 'phoneno',
                     'rules'   => 'is_natural'
                )
            );

			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run()) {
				
				$_POST['locked'] = 'no';
				$result = $this->Advertiser_model->addAdvertiser($this->input->post());

				if ($result) {
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
					redirect(base_url().'admin/advertisers');
				}
				else {
					$this->session->set_flashdata(
							'error',
							"Some Error"
					);
				}
			}
    	}

    	$parser['content'] = $this->load->view('admin/advertisers/add_advertisers',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }

    public function edit_advertiser($id) {
    	$data['page_title'] 	 = 'Edit Advertisers';
		$data['page_heading']   = 'Edit Advertisers';
    	if ($this->input->post()) {
    		$rules = array(
              	array(
                     'field'   => 'fullname',
                     'label'   => 'Email',
                     'rules'   => 'required'
                ),
               	array(
                     'field'   => 'email',
                     'label'   => 'email',
                     'rules'   => 'trim|required|valid_email'
                ),
                array(
                     'field'   => 'weburl',
                     'label'   => 'weburl',
                     'rules'   => 'valid_url'
                ),
                array(
                     'field'   => 'phoneno',
                     'label'   => 'phoneno',
                     'rules'   => 'is_natural'
                )
            );

			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run()) {
				
				$_POST['locked'] = 'no';
				$result = $this->Advertiser_model->updateAdvertiser($id, $this->input->post());
				$this->session->set_flashdata(
						'success',
						"Updated Successfully"
				);
				redirect(base_url().'admin/advertisers');
			}				
    	}
    	
    	$data['advertiser'] = $this->Advertiser_model->getRow($id);
    	
    	$parser['content'] = $this->load->view('admin/advertisers/add_advertisers',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }

    public function delete_advertiser($id) {
    	
    	$this->Advertiser_model->deleteAdvertiser($id);
		$this->session->set_flashdata(
				'success',
				"Deleted Successfully"
		);
		redirect(base_url().'admin/advertisers');
    }
}    

?>