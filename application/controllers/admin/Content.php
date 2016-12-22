<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Content_model');
		$this->load->library("pagination");
		$this->load->model("Common_model");
    }
    
	public function index()
	{
		
		$data['page_title'] 	= 'Content';
		$data['page_heading'] 	= 'Content';
		$arr['name']            = $this->input->get('name') ? $this->input->get('name') : '';
		$arr['portalUsers']	   	= $this->input->get('portalUsers') ? $this->input->get('portalUsers') : 'no';
		$config 			   	= array();
        $config["base_url"]    	= base_url() . "admin/content";
        $config["total_rows"]  	= $this->Content_model->countTotalRows($arr);
        $config["per_page"]    	= 10;
        $config["uri_segment"] 	= 3;
		$config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $page 		           = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['contents']	   = $this->Content_model->getAllData(array(),$page,$config["per_page"]);
		$data["links"]         = $this->pagination->create_links();
		
        $parser['content']	   = $this->load->view('admin/contents/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function addcontent()
	{
		$data['page_title'] 	= 'Add Content';
		$data['page_heading'] 	= 'Add Content';
		
		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'title',
                     'label'   => 'Title',
                     'rules'   => 'trim|required'
                ),
               	array(
                     'field'   => 'type',
                     'label'   => 'Type',
                     'rules'   => 'trim|required'
                ),
               	array(
                     'field'   => 'description',
                     'label'   => 'Description',
                     'rules'   => 'trim|required'
                ),
               	array(
                     'field'   => 'description',
                     'label'   => 'Description',
                     'rules'   => 'trim|required'
                )
            );
			
			if($this->input->post("type")=="Video"){
				$rules[] = array(
							 'field'   => 'video_type',
							 'label'   => 'Video Type',
							 'rules'   => 'trim|required'
							);
				if($this->input->post("video_type")=="embed_code"){
					$rules[] = array(
							 	'field'   => 'embed_code',
							 	'label'   => 'Embed Code',
							 	'rules'   => 'trim|required'
								);
				}
			}

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$file_name 		= "";
				$picture_name	= "";
				if($_FILES['file']['tmp_name']){
					$file_name 	= 'file_' . time();
					$path       = 'uploads/files/';
					$file_name 	= $this->Common_model->uploadFile($file_name,$path,'file');
				}
				
				if($_FILES['picture']['tmp_name']){
					$picture_name 	= 'file_' . time();
					$path       	= 'uploads/files/';
					$picture_name 	= $this->Common_model->uploadFile($picture_name,$path,'picture');
					$full_picture_path = $path.$picture_name;
					$this->Common_model->generateThumb($full_picture_path,array('400',400),"thumb_400_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array('153',153),"thumb_153_".$picture_name);
				}
				
				$is_premium  = ($this->input->post('is_premium')!='') ? $this->input->post('is_premium') : "";
				$is_featured = ($this->input->post('is_featured')!='') ? $this->input->post('is_featured') : "";

				$data	= array(
								"title" 		=> $this->input->post('title'),
								"description" 	=> $this->input->post('description'),
								"type"			=> $this->input->post('type'),
								"video_type"	=> $this->input->post('video_type'),
								"embed_code"	=> $this->input->post('embed_code'),
								"is_premium" 	=> $is_premium,
								"is_featured" 	=> $is_featured,
								"file" 			=> $file_name,
								"picture" 		=> $picture_name,
							);
				$result = $this->Content_model->save($data);
				if($result){
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
					redirect(base_url()."admin/content");
				}else{
					$data['contentRow'] = $this->input->post();
				}
			}else{
				$data['contentRow'] = $this->input->post();
			}
		}

		
        $parser['content']		= $this->load->view('admin/contents/add_content',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function editcontent()
	{
		$data['page_title'] 	= 'Edit Content';
		$data['page_heading'] 	= 'Edit Content';
		
		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'title',
                     'label'   => 'Title',
                     'rules'   => 'trim|required'
                ),
               	array(
                     'field'   => 'type',
                     'label'   => 'Type',
                     'rules'   => 'trim|required'
                ),
               	array(
                     'field'   => 'description',
                     'label'   => 'Description',
                     'rules'   => 'trim|required'
                )
            );
			
			if($this->input->post("type")=="Video"){
				$rules[] = array(
							 'field'   => 'video_type',
							 'label'   => 'Video Type',
							 'rules'   => 'trim|required'
							);
				if($this->input->post("video_type")=="embed_code"){
					$rules[] = array(
							 	'field'   => 'embed_code',
							 	'label'   => 'Embed Code',
							 	'rules'   => 'trim|required'
								);
				}
			}

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$file_name 		= "";
				$picture_name	= "";
				
				
				$is_premium = ($this->input->post('is_premium')!='') ? $this->input->post('is_premium') : "";
				$is_featured = ($this->input->post('is_featured')!='') ? $this->input->post('is_featured') : "";
				
				$id = $this->input->get('id');
				$data	= array(
								"title" 		=> $this->input->post('title'),
								"description" 	=> $this->input->post('description'),
								"type"			=> $this->input->post('type'),
								"video_type"	=> $this->input->post('video_type'),
								"embed_code"	=> $this->input->post('embed_code'),
								"is_premium" 	=> $is_premium,
								"is_featured" 	=> $is_featured,
							);
							
				if($_FILES['file']['tmp_name']!=''){
					$file_name 	= 'file_' . time();
					$path       = 'uploads/files/';
					$file_name 	= $this->Common_model->uploadFile($file_name,$path,'file');
					$data["file"] = $file_name;
				}
				
				if($_FILES['picture']['tmp_name']!=''){

					$picture_name 	= 'picture_' . time().rand();
					$path       	= 'uploads/files/';
					$picture_name 	= $this->Common_model->uploadFile($picture_name,$path,'picture');
					$full_picture_path = $path.$picture_name;

					$this->Common_model->generateThumb($full_picture_path,array('400',400),"thumb_400_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array('153',153),"thumb_153_".$picture_name);
					

					$data["picture"] = $picture_name;
				}
				$result = $this->Content_model->update($data,$id);
				if($result){
					$this->session->set_flashdata(
							'success',
							"Updated Successfully"
					);
					redirect(base_url()."admin/content");
				}
			}
		}

		$data['contentRow'] 	= $this->Content_model->getRow($this->input->get('id'));
		
        $parser['content']		= $this->load->view('admin/contents/edit_content',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	function delete(){
		$id = $this->input->get('id');
		$result =  $this->Content_model->delete($id);
		$this->session->set_flashdata(
						'success',
						"Deleted Successfully"
				);
		redirect(base_url().'admin/content');
	}
}