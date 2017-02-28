<?php

class Advertiser_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'advertisers';
		$this->load->library('image_lib');
    }


    public function getAll() {
		$this->db->select('*');
		$query = $this->db->get('advertisers');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
    }

    public function addAdvertiser($data) {
    	$this->db->insert('advertisers',$data);
		return $this->db->insert_id();

    }

    public function getRow($id){
		$sSQL   =  $this->db->where("id",$id);
		$query  =  $this->db->get('advertisers');
		$this->db->last_query();	
		if ($query->num_rows()) {
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}

	public function updateAdvertiser($id, $data) {
		$this->db->where('id',$id);
 		return $this->db->update('advertisers', $data);
	}

	public function deleteAdvertiser($id) {
		$this->db->where('id', $id);
		$this->db->delete('advertisers');
	}

	public function getAdvertiserBanners($id) {
		$sql   =  $this->db->where("advertiserid",$id);
		$query  =  $this->db->get('banners');
		//$this->db->last_query();	
		if ($query->num_rows()) {
			$row = $query->result_array();
			return $row;
		}
		return array();
	}

	public function getAdvertisername($id) {
		$this->db->select('fullname');
		$query = $this->db->get('advertisers');
		$row = $query->row();
		return $row->fullname;
	}

	public function uploadBanner($name,$path,$field_name) {
		$config['upload_path']   = $path;
		$config['allowed_types'] = 'jpeg|jpg|png|JPG|JPEG|PNG';
		$config['max_size'] 	 = '1000000';
		$config['file_name']     = $name;
		
		$this->load->library('upload', $config);
		if ($this->upload->do_upload($field_name)){
			$image_details  = $this->upload->data();
			$file_name 	= $image_details['file_name'];
			return $file_name;
		}else{
			return false;
		}
    }

    public function saveBannerdata($data) {

		$this->db->insert('banners', $data);
		return true;
    }

    public function uploadVideo($name,$path,$field_name) {
    	//echo phpinfo();exit;
    	$config['upload_path']   = $path; //'uploads/data/';
		$config['allowed_types'] = 'mkv|m4v|wmv|avi|flv|mp4|JPG|JPEG|PNG|rv|wav|mpeg|mpg|mov|avi|mp3';
		$config['max_size'] 	 = '500000000';
		$config['file_name']     = $name;  // 'sliderimage_' . time()
		
		$this->load->library('upload', $config);
		$image_details  = $this->upload->data();
		//echo "<pre>"; print_r($image_details);exit;
		if (!$this->upload->do_upload($field_name)) {
			//echo "<pre>"; print_r($this->upload->display_errors());exit;
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('admin/advertisers/new_banner');
		}
		else {
			$file_name 	= $image_details['file_name'];
			return $file_name;
		}
    }
}
?>    