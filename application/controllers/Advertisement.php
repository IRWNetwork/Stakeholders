<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisement extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Content_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		$this->load->model("Advertisement_model");
		$this->load->model("Common_model");
		$this->gallery_path = realpath(APPPATH . '../uploads');
		if (!$this->ion_auth->logged_in()) {
			redirect(site_url('/'), 'refresh');
		}
    }


    public function index() {
    	$data['page_title'] 	= 'Advertisements';
		$data['page_heading'] 	= 'Advertisements';
		
		$search = $this->input->get('search')?$this->input->get('search'):"";
        $arr['add_name'] = $search;
		$config 			   = array();
        $config["base_url"]    = base_url() . "advertisement";
        $config["total_rows"]  = $this->Advertisement_model->countTotalRows($arr);
		if ($this->input->get('per_page')) {
			$config["per_page"]= $this->input->get('per_page');
		} else {
        	$config["per_page"]= 20;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['advertisements']	= $this->Advertisement_model->getAllData($arr,$page,$config["per_page"]);
		//echo "<pre>"; print_r($data);exit;

        $parser['content'] = $this->load->view('advertisement/listing',$data,TRUE);
        $this->parser->parse('template', $parser);
    }

	public function addAdvertisement() {
		$data['page_title'] 	= 'Add Advertisement';
		$data['page_heading'] 	= 'Add Advertisement';
		
		if ($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'add_name',
                     'label'   => 'Add Name',
                     'rules'   => 'trim|required'
                )
            );

            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run()) {

            	$file_name 		= "";
				$picture_name	= "";

            	if ($_FILES['file']['tmp_name']) {
					$file_name 	= 'file_' . time();
					$source   	= $_FILES['file'];
					$file_name 	= $this->Common_model->uploadFileToGoogle($source,$file_name);
				}

            	if ($_FILES['picture']['tmp_name']) {
					$picture_name 	= 'picture_' . time();
					$path       	= 'uploads/listing/';
					$picture_name 	= $this->Common_model->uploadFile($picture_name,$path,'picture');
					$full_picture_path = $path.$picture_name;
					$this->Common_model->generateThumb($full_picture_path,array(400,400),"thumb_400_".$picture_name);
					
					$this->Common_model->generateThumb($full_picture_path,array(469,469),"thumb_469_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array(153,153),"thumb_153_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array(50,50),"thumb_50_".$picture_name);
					$this->Common_model->updateContentImageWithBlackBackground($path."thumb_50_".$picture_name,$path."pic_50_50.jpg",50,50,$path."thumb_50_".$picture_name);
					$this->Common_model->updateContentImageWithBlackBackground($path."thumb_153_".$picture_name,$path."pic_153_153.jpg",153,153,$path."thumb_153_".$picture_name);
					$this->Common_model->updateContentImageWithBlackBackground($path."thumb_400_".$picture_name,$path."pic_400_400.jpg",400,400,$path."thumb_400_".$picture_name);
					$this->Common_model->updateContentImageWithBlackBackground($path."thumb_469_".$picture_name,$path."pic_469_469.jpg",469,469,$path."thumb_469_".$picture_name);
				}

				$data	= array(
					"add_name" 			=> $this->input->post('add_name'),
					"add_link" 			=> $this->input->post('add_link'),
					"video_file" 		=> $file_name,
					"picture" 	   		=> $picture_name,
					"user_id"	   		=> $this->ion_auth->user()->row()->id
				);
				$result = $this->Advertisement_model->save($data);
				if ($result) {
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
					redirect(base_url()."content");
				}else{
					$data['contentRow'] = $this->input->post();
				}
            }

            else{
				$data['contentRow'] = $this->input->post();
			}
		}
		
        $parser['content']		= $this->load->view('advertisement/add_advertisement',$data,TRUE);
        $this->parser->parse('template', $parser);
    }

    public function editAdvertisements($id) {
    	$data['page_title'] 	= 'Edit Adverstisement';
		$data['page_heading'] 	= 'Edit Adverstisement';
		
        
		if ($this->input->post()) {
			$rules = array(
	          	array(
	                 'field'   => 'add_name',
	                 'label'   => 'Add Name',
	                 'rules'   => 'trim|required'
	            )
	        );

	        $this->form_validation->set_rules($rules);
	        if ($this->form_validation->run()) {
				$file_name 		= "";
				$picture_name	= "";
				
				$data = array(
								"add_name" => $this->input->post('add_name'),
								"add_link" => $this->input->post('add_link'),
						);
				
				if($_FILES['file']['tmp_name']){
					$file_name 	= 'file_' . time();
					$source   	= $_FILES['file'];
					$file_name 	= $this->Common_model->uploadFileToGoogle($source,$file_name);
					$data['video_file'] = $file_name;
				}
				
				if($_FILES['picture']['tmp_name']!=''){

					//Delete Old picuture
					$sSQL   =   $this->db->where("id",$id);
					$query  =   $this->db->get('advertisements');
					$row = $query->row_array();
					if ($row) {
						unlink('uploads/listing/'.$row['picture']);
						unlink('uploads/listing/thumb_400_'.$row['picture']);
						unlink('uploads/listing/thumb_469_'.$row['picture']);
						unlink('uploads/listing/thumb_153_'.$row['picture']);
						unlink('uploads/listing/thumb_50_'.$row['picture']);
					}
					$picture_name 	= 'picture_' . time().rand();
					$path       	= 'uploads/listing/';
					$picture_name 	= $this->Common_model->uploadFile($picture_name,$path,'picture');
					$full_picture_path = $path.$picture_name;
					$this->Common_model->generateThumb($full_picture_path,array(400,400),"thumb_400_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array(469,469),"thumb_469_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array(153,153),"thumb_153_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array(50,50),"thumb_50_".$picture_name);
					$this->Common_model->updateContentImageWithBlackBackground($path."thumb_50_".$picture_name,$path."pic_50_50.jpg",50,50,$path."thumb_50_".$picture_name);
					$this->Common_model->updateContentImageWithBlackBackground($path."thumb_153_".$picture_name,$path."pic_153_153.jpg",153,153,$path."thumb_153_".$picture_name);
					$this->Common_model->updateContentImageWithBlackBackground($path."thumb_400_".$picture_name,$path."pic_400_400.jpg",400,400,$path."thumb_400_".$picture_name);
					$this->Common_model->updateContentImageWithBlackBackground($path."thumb_469_".$picture_name,$path."pic_469_469.jpg",469,469,$path."thumb_469_".$picture_name);
					

					$data["picture"] = $picture_name;
				}
				$result = $this->Advertisement_model->update($data,$id);
				if($result){
					$this->session->set_flashdata(
							'success',
							"Updated Successfully"
					);
					redirect(base_url()."content");
				}
			}

		}

		$data['advertisementRow'] 	= $this->Advertisement_model->getRow($id);
        $parser['content']		= $this->load->view('advertisement/edit_advertisement',$data,TRUE);
        $this->parser->parse('template', $parser);
    }

    function delete(){
		$id = $this->input->get('id');
		$result =  $this->Advertisement_model->delete($id);
		$this->session->set_flashdata(
						'success',
						"Deleted Successfully"
				);
		redirect(base_url().'advertisement');
	}

}    