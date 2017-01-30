<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Events_model');
		$this->load->model('Common_model');
		$this->load->library("pagination");
		$this->load->helper('csv');
		$this->load->library('ion_auth');
    }
    
	public function index() {
		$arr 		           = array();
        $arr['name']           = $this->input->get('name') ? $this->input->get('name') : '';
		$config 			   = array();
        $config["base_url"]    = base_url() . "admin/events";
        $config["total_rows"]  = $this->Events_model->countTotal($arr);
		if($this->input->get('per_page')){
			$config["per_page"]= $this->input->get('per_page');
		}else{
        	$config["per_page"]= 10;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string']   = true;

        $this->pagination->initialize($config);

        $page 		           = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if($this->input->get('sort_by')){
			$arr['sort_by'] = $this->input->get('sort_by');
			$arr['order'] = $this->input->get('order');
		}
		$data['events']		   = $this->Events_model->getAllRows($arr,$page,$config["per_page"] );
		$data["links"]         = $this->pagination->create_links();
		$data['page_title']    = 'Events';
		$data['page_heading']  = 'Events';
		
		$data['msg'] = $this->input->get('msg') ? $this->input->get('msg') : '';
		
        $parser['content']	   = $this->load->view('admin/map/events_listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
		
	}
	
	public function add() {

		$data['page_title']   = 'Add Event';
		$data['page_heading'] = 'Add Event';
		
		if($this->input->post()) {
			$rules = array(
			    array(
                	'field'   => 'name',
                 	'label'   => 'Name',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'address',
                 	'label'   => 'Address',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'latitude',
                 	'label'   => 'Latitude',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'longitude',
                 	'label'   => 'Longitude',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'produced_by',
                 	'label'   => 'Produced By',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'link',
                 	'label'   => 'Link',
                 	'rules'   => 'trim|required'
              	)
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {

				$array = array(
							"category_id"  	 	=> $this->input->post('category_id'),
							"name"  	 		=> $this->input->post('name'),
							"start_date"  	 	=> changeDateTimeToSQLDateTime($this->input->post('start_date')),
							"end_date"  	 	=> changeDateTimeToSQLDateTime($this->input->post('end_date')),
							"address"  	 		=> $this->input->post('address'),
							"latitude"  	 	=> $this->input->post('latitude'),
							"longitude"  	 	=> $this->input->post('longitude'),
							"description"  	 	=> $this->input->post('description'),
							"type"  	 		=> $this->input->post('type'),
							"produced_by"  	 	=> $this->input->post('produced_by'),
							"link"  	 		=> $this->input->post('link')
						 );
				$product_id			=	$this->Events_model->save($array);
				if($product_id) {
					$arr = "";
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
					redirect(base_url().'admin/events');
				}else {
					$this->session->set_flashdata(
							'error',
							"Some Error try later"
					);
					$data['eventDetail'] = $_REQUEST;
				}
			}else{
				$data['eventDetail'] = $_REQUEST;
			}
		}else {
			$data['eventDetail'] = array();
		}
		$data['categories']	   = $this->Events_model->getAllCategories();
        $parser['content']	   = $this->load->view('admin/map/add_event',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function edit() {

		$data['page_title']   = 'Edit Event';
		$data['page_heading'] = 'Edit Event';
		
		if($this->input->post()) {
			$rules = array(
			    array(
                	'field'   => 'name',
                 	'label'   => 'Name',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'address',
                 	'label'   => 'Address',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'latitude',
                 	'label'   => 'Latitude',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'longitude',
                 	'label'   => 'Longitude',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'produced_by',
                 	'label'   => 'Produced By',
                 	'rules'   => 'trim|required'
              	),
				array(
                	'field'   => 'link',
                 	'label'   => 'Link',
                 	'rules'   => 'trim|required'
              	)
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$array = array(
							"category_id"  	 	=> $this->input->post('category_id'),
							"name"  	 		=> $this->input->post('name'),
							"start_date"  	 	=> changeDateTimeToSQLDateTime($this->input->post('start_date')),
							"end_date"  	 	=> changeDateTimeToSQLDateTime($this->input->post('end_date')),
							"address"  	 		=> $this->input->post('address'),
							"latitude"  	 	=> $this->input->post('latitude'),
							"longitude"  	 	=> $this->input->post('longitude'),
							"description"  	 	=> $this->input->post('description'),
							"type"  	 		=> $this->input->post('type'),
							"produced_by"  	 	=> $this->input->post('produced_by'),
							"link"  	 		=> $this->input->post('link')
						 );
				$product_id			=	$this->Events_model->update($array,$this->input->get('id'));
				if($product_id) {
					$arr = "";
					$this->session->set_flashdata(
							'success',
							"Updated Successfully"
					);
					redirect(base_url().'admin/events');
				}else {
					
					$this->session->set_flashdata(
							'error',
							"Some Error try later"
					);
					$data['eventDetail'] = $_REQUEST;
				}
			}else{
				$data['eventDetail'] = $_REQUEST;
			}
		}else {
			$data['eventDetail'] = array();
		}
		if($this->input->get('id')){
			$data['eventDetail'] = $this->Events_model->getRow($this->input->get('id'));
		}
		$data['categories']	   = $this->Events_model->getAllCategories();
        $parser['content']	   = $this->load->view('admin/map/edit_event',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function delete() {
		$id = $this->input->get('id');
		$data['user'] = $this->Events_model->delete($id);
		$this->session->set_flashdata(
							'success',
							"Deleted Successfully"
					);
		redirect(base_url().'admin/events');
	}	
}
