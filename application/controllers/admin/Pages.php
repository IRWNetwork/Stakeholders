<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Pages_model');
		$this->load->model('Common_model');
		$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			ciredirect(site_url('admin/'), 'refresh');
		}
    }
    
	public function index() {
		
		$data['page_title'] 	= 'Pages';
		$data['page_heading'] 	= 'Pages';

		$data['pages']	   = $this->Pages_model->getAllPages();

		
        $parser['content']	   = $this->load->view('admin/pages/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function add() {
		
		$data['page_title']       = 'Add Page';
		$data['page_heading']     = 'Add Page';
		
		if($this->input->post()) {
			$rules = array(
			    array(
                	'field'   => 'title',
                 	'label'   => 'Title',
                 	'rules'   => 'trim|required'
              	),
              	array(
                     'field'   => 'body',
                     'label'   => 'Detail',
                     'rules'   => 'trim|required'
                )
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$array = array(
							"title"  	 		=> $this->input->post('title'),
							"slug"  	 		=> $this->input->post('slug'),
							"type"  	 		=> $this->input->post('type'),
							"body" 		 		=> $this->input->post('body'),
							"seo_url"    		=> $this->seoUrl($this->input->post('slug')),
							"meta_title"    	=> $this->input->post('meta_title'),
							"meta_description"  => $this->input->post('meta_description'),
							"meta_keyword"    	=> $this->input->post('meta_keyword')
						 );
				
				$user_record			=	$this->Pages_model->save($array);
				if($user_record) {
					ciredirect('admin/pages?msg=Added Successfully');
				}else {
					$data['error']	    = 'Some Error try later';
					$data['pageDetail'] = $_REQUEST;
				}
				
			}else{
				$data['pageDetail'] = $_REQUEST;
			}
		}else {
			$data['pageDetail'] = array();
		}
		
        $parser['content']	   = $this->load->view('admin/pages/add',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function edit() {

		$pageRow                 = $this->Pages_model->getRow($this->input->get('id'));

		if($pageRow) {
			$data['pageDetail']  = $pageRow;
		}else {
			ciredirect(base_url()."admin/pages?msg=Invalid Page");
		}
		$data['page_title']       = 'Edit Page';
		$data['page_heading']     = 'Edit Page';

		if($this->input->post()) {
			$rules = array(
			    array(
                	'field'   => 'title',
                 	'label'   => 'Title',
                 	'rules'   => 'trim|required'
              	),
              	array(
                     'field'   => 'body',
                     'label'   => 'Detail',
                     'rules'   => 'trim|required'
                )
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$array = array(
							"title"  	 		=> $this->input->post('title'),
							"slug"  	 		=> $this->input->post('slug'),
							"type"  	 		=> $this->input->post('type'),
							"body" 		 		=> $this->input->post('body'),
							"seo_url"    		=> $this->seoUrl($this->input->post('slug')),
							"meta_title"    	=> $this->input->post('meta_title') ,
						    "meta_description"  => $this->input->post('meta_description') ,
						    "meta_keyword"    	=> $this->input->post('meta_keyword')
						
						
						 );
				$user_record	=	$this->Pages_model->update($array,$this->input->post('id'));
				if($user_record) {
					ciredirect('admin/pages?msg=Updated Successfully');
				}else {
					$data['error']	    = 'Some Error try later';
					$data['pageDetail'] = $_REQUEST;
				}
				
			}else{
				$data['pageDetail'] = $_REQUEST;
			}
		}

        $parser['content']	   = $this->load->view('admin/pages/edit',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	function seoUrl($string) {
	    $string = strtolower($string);
	    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
	    $string = preg_replace("/[\s-]+/","-", $string);
	    $string = preg_replace("/[\s_]/", "-", $string);
	    return $string;
	}

	public function delete($id) {
		$data['user'] = $this->Pages_model->delete($id);
		ciredirect('admin/pages?msg=Deleted Successfully');
	}
}
