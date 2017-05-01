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
		$this->load->library('ion_auth');
		$this->load->model("Common_model");
		$this->gallery_path = realpath(APPPATH . '../uploads');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
    }
    
	public function index()
	{
		
		$data['page_title'] 	 	= 'Content';
		$data['page_heading']  		= 'Content';
		$arr['name']            	= $this->input->post('name') ? $this->input->post('name') : '';
		$arr['portalUsers']	 		= $this->input->get('portalUsers') ? $this->input->get('portalUsers') : 'no';
		$config 			   	 	= array();
        $config["base_url"]     	= base_url() . "admin/content";
        $config["total_rows"]   	= $this->Content_model->countTotalRows($arr);
        $config["per_page"]     	= 10;
        $config["uri_segment"]  	= 3;
		$config['reuse_query_string'] = TRUE;
		
        $this->pagination->initialize($config);
        $page 		           = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['contents']	   = $this->Content_model->getAllData(array(),$page,$config["per_page"],$arr['name']);
		//echo "<pre>"; print_r($data['contents']);exit;
		$data["links"]         = $this->pagination->create_links();
		if($this->input->get('msg')){
			$this->session->set_flashdata('success',$this->input->get('msg'));
		}
        $parser['content']	   = $this->load->view('admin/contents/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	public function convert_images() {
		$results = $this->Common_model->convert_images();
		//$this->load->library('image_lib');	
	}
	
	public function uploadToGoogle(){
		$contents = $this->Content_model->getAllContents();
		foreach($contents as $row){
			$file_name  = $row->file;
			$source 	= FCPATH."uploads/files/".$row->file;
			$google_url 	= $this->Common_model->directUploadFileToGoogle($source,$file_name);
			$data_update['file_url'] = $google_url;
			$this->Content_model->update($data_update,$row->id);
		}
	}
	
	/*public function addcontent()
	{
		$data['page_title'] 	= 'Add Content';
		$data['page_heading'] 	= 'Add Content';
		
		if($this->input->post()) {
			//echo "<pre>"; print_r($_POST);exit;
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
				// if ($_FILES['file']['tmp_name']) {
				// 	//echo "<pre>"; print_r($_FILES['file']);exit;
				// 	$ext = explode('.',$_FILES['file']['name']);
				// 	$ext = $ext[1];
				// 	$file_name 	= 'file_' . time().'.'.$ext;
				// 	$path       = 'uploads/files/';
				// 	$file_name 	= $this->Common_model->uploadFile($file_name,$path,'file');
				// }
				
				if($_FILES['file']['tmp_name']){
					$ext = explode('.',$_FILES['file']['name']);
					$ext = $ext[1];
					
					$file_name 	= 'file_' . time().'.'.$ext;
					$source   	= $_FILES['file'];
					$file_name 	= $this->Common_model->uploadFileToGoogle($source,$file_name);
					$data['file_url'] = $file_name;
				}
				if($_FILES['picture']['tmp_name']){
					$picture_name 	= 'picture_' . time();
					$path       	= 'uploads/listing/';
					$picture_name 	= $this->Common_model->uploadFile($picture_name,$path,'picture');
					$full_picture_path = $path.$picture_name;
					$this->Common_model->generateThumb($full_picture_path,array(400,400),"thumb_400_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array(469,469),"thumb_469_".$picture_name);
					$this->Common_model->generateThumb($full_picture_path,array(153,153),"thumb_153_".$picture_name);
				}
				
				$is_premium  = ($this->input->post('is_premium')!='') ? $this->input->post('is_premium') : "";
				$is_featured = ($this->input->post('is_featured')!='') ? $this->input->post('is_featured') : "";
				$data	= array(
								"title" 			=> $this->input->post('title'),
								"description" 		=> $this->input->post('description'),
								"type"				=> $this->input->post('type'),
								"video_type"		=> $this->input->post('video_type'),
								"embed_code"		=> $this->input->post('embed_code'),
								"meta_keywords"		=> $this->input->post('meta_keywords'),
								"meta_description"	=> $this->input->post('meta_description'),
								"show_date"			=> changeDateTimeToSQLDateTime($this->input->post('show_date')),
								"is_premium" 		=> $is_premium,
								"is_featured" 		=> $is_featured,
								"file_url" 			=> $file_name,
								"picture" 			=> $picture_name,
								"user_id"	  		=> $this->ion_auth->user()->row()->id
							);
				$result = $this->Content_model->save($data);
				if($result){
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
					redirect(base_url()."admin/content");
					return true;
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
	*/
    public function addcontent()
	{
		$data['page_title'] 	= 'Add Content';
		$data['page_heading'] 	= 'Add Content';
		
		if($this->input->post()) {
			//echo "<pre>"; print_r($_POST);exit;
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
				// if ($_FILES['file']['tmp_name']) {
				// 	//echo "<pre>"; print_r($_FILES['file']);exit;
				// 	$ext = explode('.',$_FILES['file']['name']);
				// 	$ext = $ext[1];
				// 	$file_name 	= 'file_' . time().'.'.$ext;
				// 	$path       = 'uploads/files/';
				// 	$file_name 	= $this->Common_model->uploadFile($file_name,$path,'file');
				// }
				
				if($_FILES['file']['tmp_name']){
					$ext = explode('.',$_FILES['file']['name']);
					$ext = $ext[1];
					
					$file_name 	= 'file_' . time().'.'.$ext;
					$source   	= $_FILES['file'];
					$file_name 	= $this->Common_model->uploadFileToGoogle($source,$file_name);
					$data['file_url'] = $file_name;
				}
				
				if($_FILES['picture']['tmp_name']){
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
				
				$is_premium  = ($this->input->post('is_premium')!='') ? $this->input->post('is_premium') : "";
				$is_featured = ($this->input->post('is_featured')!='') ? $this->input->post('is_featured') : "";
				$data	= array(
								"title" 			=> $this->input->post('title'),
								"description" 		=> $this->input->post('description'),
								"type"				=> $this->input->post('type'),
								"video_type"		=> $this->input->post('video_type'),
								"embed_code"		=> $this->input->post('embed_code'),
								"meta_keywords"		=> $this->input->post('meta_keywords'),
								"meta_description"	=> $this->input->post('meta_description'),
								"show_date"			=> changeDateTimeToSQLDateTime($this->input->post('show_date')),
								"is_premium" 		=> $is_premium,
								"is_featured" 		=> $is_featured,
								"file_url" 			=> $file_name,
								"picture" 			=> $picture_name,
								"user_id"	  		=> $this->ion_auth->user()->row()->id
							);
				$result = $this->Content_model->save($data);
				if($result){
					$this->session->set_flashdata(
							'success',
							"Added Successfully"
					);
                      
					//redirect(base_url()."admin/content");
					echo "true";
                    die();
				}else{

					$data['contentRow'] = $this->input->post();

                    //$data['contentRow'] = $this->input->post();
                    echo "connection error";
                    die();
				}
			}else{
                echo validation_errors();
				//$data['contentRow'] = $this->input->post();
                die();
                
			}
            die();
		}
       //die();
		
        $parser['content']		= $this->load->view('admin/contents/add_content',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }
	public function editcontent()
	{
		$data['page_title'] 	= 'Edit Content';
		$data['page_heading'] 	= 'Edit Content';
		
		$data['contentRow'] 	= $this->Content_model->getRow($this->input->get('id'));

		$oldFileUrl = $data['contentRow']['file_url'];

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
								"title" 			=> $this->input->post('title'),
								"description" 		=> $this->input->post('description'),
								"type"				=> $this->input->post('type'),
								"video_type"		=> $this->input->post('video_type'),
								"embed_code"		=> $this->input->post('embed_code'),
								"meta_keywords"		=> $this->input->post('meta_keywords'),
								"meta_description"	=> $this->input->post('meta_description'),
								//"show_date"			=> changeDateTimeToSQLDateTime($this->input->post('show_date')),
								"show_date"			=> '',
								"is_premium" 		=> $is_premium,
								"is_featured" 		=> $is_featured,
							);
							
				
				if ($_FILES['file']['tmp_name']) {

					//Deleting Old file from GCloud
					if ($oldFileUrl != '') {

						$my_url_parts = explode('/', $oldFileUrl);
						$myFileName = $my_url_parts[9];
						$myFileName = explode('?', $myFileName);
						$myFileName = $myFileName[0];
						//echo $myFileName;exit;
						$this->load->library('Gcloud');
						$file_name = $this->gcloud->deleteFile($myFileName);

					}
					//End of Deleting old file from Gcloud

					$file_name 	= 'file_' . time();
					$source   	= $_FILES['file'];
					$file_name 	= $this->Common_model->uploadFileToGoogle($source,$file_name);
					$data['file_url'] = $file_name;
				}
				
				if($_FILES['picture']['tmp_name']!=''){
					
					//Delete Old picuture
					$sSQL   =   $this->db->where("id",$id);
					$query  =   $this->db->get('contents');
					$row = $query->row_array();
					if ($row) {
						@unlink('uploads/listing/'.$row['picture']);
						@unlink('uploads/listing/thumb_400_'.$row['picture']);
						@unlink('uploads/listing/thumb_469_'.$row['picture']);
						@unlink('uploads/listing/thumb_153_'.$row['picture']);
						@unlink('uploads/listing/thumb_50_'.$row['picture']);
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
		
        $parser['content']		= $this->load->view('admin/contents/edit_content',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	function updatePicturesOfContent(){
		$contents = $this->Content_model->getAllContentsPictures();
		foreach($contents as $row){
			$picture_name 	= $row->picture;
			$path       	= 'uploads/listing/';
			$full_picture_path = $path.$picture_name;
			$this->Common_model->generateThumb($full_picture_path,array(50,50),"thumb_50_".$picture_name);
			$this->Common_model->updateContentImageWithBlackBackground($path."thumb_50_".$picture_name,$path."pic_50_50.jpg",50,50,$path."thumb_50_".$picture_name);
			$this->Common_model->updateContentImageWithBlackBackground($path."thumb_153_".$picture_name,$path."pic_153_153.jpg",153,153,$path."thumb_153_".$picture_name);
			$this->Common_model->updateContentImageWithBlackBackground($path."thumb_400_".$picture_name,$path."pic_400_400.jpg",400,400,$path."thumb_400_".$picture_name);
			$this->Common_model->updateContentImageWithBlackBackground($path."thumb_469_".$picture_name,$path."pic_469_469.jpg",469,469,$path."thumb_469_".$picture_name);
		}
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
	
	function unfeatured($id){
		$data = array("is_featured"=>'no');
		$this->Content_model->update($data,$id);
		redirect(base_url().'admin/content?msg=Content unfeatured successfully');
	}
	
	function getGoogleObjectDetail(){
		$this->load->library('Gcloud');
		$this->gcloud->deleteFile('https://www.googleapis.com/download/storage/v1/b/irw-network/o/BoW%20Ep%201.mp3?generation=1489073669500640&alt=media');
	}
	
	function featured($id){
		$data = array("is_featured"=>'yes');
		$this->Content_model->update($data,$id);
		redirect(base_url().'admin/content?msg=Content featured successfully');
	}
}
