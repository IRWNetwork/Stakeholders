<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Categories_model');
		$this->load->model('Common_model');
		$this->load->library("pagination");
		
		$this->load->helper('csv');

    }
    
	public function index() {
		$arr 		           = array();
        $arr['name']           = $this->input->get('name') ? $this->input->get('name') : '';
		$config 			   = array();
        $config["base_url"]    = base_url() . "admin/categories";
        $config["total_rows"]  = $this->Categories_model->countProductsTotal($arr);
		if($this->input->get('per_page')){
			$config["per_page"]    = $this->input->get('per_page');
		}else{
        	$config["per_page"]    = 10;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string']   = true;

        $this->pagination->initialize($config);

        $page 		           = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if($this->input->get('sort_by')){
			$arr['sort_by'] = $this->input->get('sort_by');
			$arr['order'] = $this->input->get('order');
		}
		$data['categories']    = $this->Categories_model->getAllProducts($arr,$page,$config["per_page"] );
		$data["links"]         = $this->pagination->create_links();
		$data['page_title']    = 'Categories';
		$data['page_heading']  = 'Categories';
		
		$data['msg'] = $this->input->get('msg') ? $this->input->get('msg') : '';

		
        $parser['content']	   = $this->load->view('admin/map/category_listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
		
	}
	
	public function add() {

		$data['page_title']   = 'Add Category';
		$data['page_heading'] = 'Add Category';
		
		if($this->input->post()) {
			$rules = array(
			    array(
                	'field'   => 'name',
                 	'label'   => 'Name',
                 	'rules'   => 'trim|required'
              	)
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$array = array(
							"parent_id"  	 			=> $this->input->post('parent_id'),
							"name"  	 				=> $this->input->post('name')
						 );
				$product_id			=	$this->Categories_model->save($array);
				if($product_id) {
					$arr = "";
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
					ciredirect(base_url().'admin/categories');
				}else {
					$this->session->set_flashdata(
							'error',
							"Some Error try later"
					);
					$data['productDetail'] = $_REQUEST;
				}
			}else{
				$data['productDetail'] = $_REQUEST;
			}
		}else {
			$data['productDetail'] = array();
		}
        $parser['content']	   = $this->load->view('admin/map/add_category',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function edit() {

		$data['page_title']   = 'Edit Category';
		$data['page_heading'] = 'Edit Category';
		
		if($this->input->post()) {
			$rules = array(
			    array(
                	'field'   => 'name',
                 	'label'   => 'Name',
                 	'rules'   => 'trim|required'
              	)
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$array = array(
							"parent_id"  	 			=> $this->input->post('parent_id'),
							"name"  	 				=> $this->input->post('name')
						 );
				$product_id			=	$this->Categories_model->update($array,$this->input->get('id'));
				if($product_id) {
					$arr = "";
					$this->session->set_flashdata(
							'success',
							"Updated Successfully"
					);
					ciredirect(base_url().'admin/categories');
				}else {
					
					$this->session->set_flashdata(
							'error',
							"Some Error try later"
					);
					$data['productDetail'] = $_REQUEST;
				}
			}else{
				$data['productDetail'] = $_REQUEST;
			}
		}else {
			$data['productDetail'] = array();
		}
		if($this->input->get('id')){
			$data['productDetail'] = $this->Categories_model->getRow($this->input->get('id'));
		}
        $parser['content']	   = $this->load->view('admin/map/edit_category',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function delete() {
		$id = $this->input->get('id');
		$data['user'] = $this->Categories_model->delete($id);
		$this->session->set_flashdata(
							'success',
							"Deleted Successfully"
					);
		ciredirect(base_url().'admin/categories?msg=Deleted Successfully');
	}
	
}
