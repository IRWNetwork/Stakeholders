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

    public function view_banners($id) {
        $data['page_title']      = 'Banners';
        $data['page_heading']   = 'Banners';
        $data['advertiser_id'] = $id;
        $data['banners'] = $this->Advertiser_model->getAdvertiserBanners($id);
        //echo "<pre>"; print_r($data['banners']);exit;
        $parser['content'] = $this->load->view('admin/advertisers/banner_listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }

    public function new_banner($advertiser_id) {
        $data['page_title']      = 'New Banner';
        $data['page_heading']   = 'New Banner';
        if ($this->input->post()) {
            //echo '<pre>'; print_r($this->input->post());exit;
            $file_name = "";
            if ($_FILES['video_file']) {
                //echo "<pre>"; print_r($_FILES['video_file']);exit;
                $video_file  = 'file_' . time();
                $path       = 'uploads/banners/videos';
                $video_file  = $this->Advertiser_model->uploadVideo($video_file,$path,'video_file');
                $_POST['video_file_name'] = $video_file;
                //echo $video_file;exit;
            }
            if ($_FILES['banner_file']['tmp_name']) {
                //echo '<pre>'; print_r($_FILES);exit;
                $banner_file_name   = 'file_' . time();
                $path = 'uploads/banners/';
                $banner_file_name  = $this->Advertiser_model->uploadBanner($banner_file_name,$path,'banner_file');
                $_POST['banner_file'] = $banner_file_name;
            }
            $result = $this->Advertiser_model->saveBannerdata($this->input->post());
            if ($result) {
                $this->session->set_flashdata(
                        'success',
                        "Banner Added Successfully"
                );
                redirect(base_url().'admin/advertisers');
            }
        }
        $data['advertiser_name'] = $this->Advertiser_model->getAdvertisername($advertiser_id);
        $data['advertiser_id'] = $advertiser_id;

        $parser['content'] = $this->load->view('admin/advertisers/new_banner',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
        //echo $advertiser_id;exit;
    }

}    

?>