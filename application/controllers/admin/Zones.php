<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zones extends CI_Controller {
	function __construct()
    {
        parent::__construct();
		$this->load->model('Zone_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
    }
	public function index() {
		$data['page_title'] 	 = 'Zones';
		$data['page_heading']   = 'Zones';
		$data['zones'] = $this->Zone_model->getAll();
		//echo "<pre>"; print_r($data['zones']);exit;
		
        $parser['content']	   = $this->load->view('admin/zones/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function add_zones() {
		$data['page_title'] 	 = 'Add Zone';
		$data['page_heading']   = 'Add Zone';
		
		if ($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'name',
                     'rules'   => 'required'
                ),
               	array(
                     'field'   => 'width',
                     'rules'   => 'required'
                )
            );

			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run()) {
				$result = $this->Zone_model->addZone($this->input->post());
				if ($result) {
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
					redirect(base_url()."content");
				}
				else {
					$data['contentRow'] = $this->input->post();
				}
				redirect(site_url('admin/zones'), 'refresh');
			}
		}
        $parser['content'] = $this->load->view('admin/zones/add_zone',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

}
?>