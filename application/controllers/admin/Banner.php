<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Content_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		$this->load->model("Common_model");
		$this->gallery_path = realpath(APPPATH . '../uploads');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
    }
    
	public function index()
	{
		
		$data['page_title'] 	 = 'Banner';
		$data['page_heading']   = 'Banner';
		$arr['name']            = $this->input->get('name') ? $this->input->get('name') : '';
		$arr['portalUsers']	 = $this->input->get('portalUsers') ? $this->input->get('portalUsers') : 'no';
		$config 			   	 = array();
        $config["base_url"]    	= base_url() . "admin/banner";
        $config["total_rows"]  	= $this->Content_model->countBannersTotalRows($arr);
        $config["per_page"]    	= 10;
        $config["uri_segment"] 	= 3;
		$config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $page 		           = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

		$data['banners']	   = $this->Content_model->getAllBannersData(array(),$page,$config["per_page"]);
		$data["links"]         = $this->pagination->create_links();
		
        $parser['content']	   = $this->load->view('admin/banners/banner_listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	public function convert_images() {
		$results = $this->Common_model->convert_images();
		//$this->load->library('image_lib');
		
	}
	public function addbanner()
	{
		$data['page_title'] 	  = 'Add Banner';
		$data['page_heading'] 	= 'Add Banner';
		
		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'banner_link',
                     'label'   => 'Banner Link',
                     'rules'   => 'trim|required|valid_url'
                ),
               	array(
                     'field'   => 'page',
                     'label'   => 'Type',
                     'rules'   => 'trim|required'
                )
            );
			

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				$picture_name	= "";
				
				if($_FILES['banner_picture']['tmp_name']){
					$picture_name 	= 'bannerImage_' . time().rand();
					$path       	= 'uploads/banner_images/';
					$picture_name 	= $this->Common_model->uploadFile($picture_name,$path,'banner_picture');
					$full_picture_path = $path.$picture_name;
					$this->Common_model->generateThumb($full_picture_path,array('400',400),"thumb_400_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array('153',153),"thumb_153_".$picture_name);
				}
				
				$data	= array(
								"banner_link" 	=> $this->input->post('banner_link'),
								"page" 	       => $this->input->post('page'),
								"target" 	     => $this->input->post('target'),
								"banner_image"   => $picture_name
							);
				
				$result = $this->Content_model->saveBanner($data);
				
				if($result){
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
					redirect(base_url()."admin/banner");
				}else{
					$data['bannerRow'] = $this->input->post();
				}
			}else{
				$data['bannerRow'] = $this->input->post();
			}
		}

		
        $parser['content']		= $this->load->view('admin/banners/add_banner',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function changebanner()
	{
		$data['page_title'] 	  = 'Edit Banner';
		$data['page_heading'] 	= 'Edit Banner';
		$id = $this->input->get('id');
		
		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'banner_link',
                     'label'   => 'Banner Link',
                     'rules'   => 'trim|required|valid_url'
                ),
               	array(
                     'field'   => 'page',
                     'label'   => 'Page',
                     'rules'   => 'trim|required'
                )
            );
			
			

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				//$picture_name	= "";
				
				
				if($_FILES['banner_picture']['tmp_name']){
					$picture_name 	= 'bannerImage_' .time().rand();
					$path       	= 'uploads/banner_images/';
					
					$bannerRow 	= $this->Content_model->getBannerRowByField("id",$this->input->get('id'));
					@unlink($path.$bannerRow['banner_image']);
					@unlink($path."thumb_400_".$bannerRow['banner_image']);
					@unlink($path."thumb_153_".$bannerRow['banner_image']);
					
					$picture_name 	= $this->Common_model->uploadFile($picture_name,$path,'banner_picture');
					$full_picture_path = $path.$picture_name;
					$this->Common_model->generateThumb($full_picture_path,array('400',400),"thumb_400_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array('153',153),"thumb_153_".$picture_name);
					$data	= array(
						"banner_link"    => $this->input->post('banner_link'),
						"page" 	       => $this->input->post('page'),
						"target" 	     => $this->input->post('target'),
						"banner_image"   => $picture_name
					);
				}
				else {
					$data	= array(
						"banner_link"    => $this->input->post('banner_link'),
						"page" 	       => $this->input->post('page'),
						"target" 	     => $this->input->post('target'),
					);
				}

				$result = $this->Content_model->updateBanner($data,$id);
				if($result){
					$this->session->set_flashdata(
							'success',
							"update Successfully."
					);
					redirect(base_url()."admin/banner");
				}else{
					$data['bannerRow'] = $this->input->post();
				}
			}else{
				$data['bannerRow'] = $this->input->post();
			}
		}

		$data['bannerRow'] 	= $this->Content_model->getBannerRowByID($this->input->get('id'));
        $parser['content']	= $this->load->view('admin/banners/add_banner',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	function delete(){
		$id 	= $this->input->get('id');
		$result = $this->Content_model->deleteBanner($id);
		$this->session->set_flashdata(
						'success',
						"Deleted Successfully"
				);
		redirect(base_url().'admin/banner');
	}
	
}