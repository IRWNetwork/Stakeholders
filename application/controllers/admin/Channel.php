<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends CI_Controller
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
		
		$data['page_title'] 	 = 'Channel';
		$data['page_heading']   = 'Channel';
		$arr['name']            = $this->input->get('name') ? $this->input->get('name') : '';
		//$arr['portalUsers']	 = $this->input->get('portalUsers') ? $this->input->get('portalUsers') : 'no';
		$config 			   	 = array();
        $config["base_url"]     = base_url()."admin/channel";
        $config["total_rows"]   = $this->Users_model->countTotalRows($arr);
        $config["per_page"]     = 10;
        $config["uri_segment"]  = 3;
		$config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $page 		         = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['channels']	 = $this->Users_model->getAllUsers(array(),$page,$config["per_page"]);
		//print_r($data['channels']); die();
		$data["links"]        = $this->pagination->create_links();
        $parser['content']	= $this->load->view('admin/channels/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	public function convert_images() {
		$results = $this->Common_model->convert_images();
		//$this->load->library('image_lib');
		
	}
	public function addchannel()
	{
		//print_r($this->input->post());
		//die('afd');
		$data['page_title'] 	  = 'Add Channel';
		$data['page_heading'] 	= 'Add Channel';
		
		if($this->input->post()) {
			if($this->input->post('type')=='4'){
				$rules = array(
					array(
						 'field'   => 'firstname',
						 'label'   => 'First Name',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'lastname',
						 'label'   => 'Last Name',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'email',
						 'label'   => 'Email',
						 'rules'   => 'trim|required|valid_email'
					),
					array(
						 'field'   => 'password',
						 'label'   => 'Password',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'type',
						 'label'   => 'User Type',
						 'rules'   => 'trim|required'
					),
					array(
							 'field'   => 'confirmPassword',
							 'label'   => 'Confirm Password',
							 'rules'   => 'trim|required|matches[password]'
						),
					array(
						 'field'   => 'brand',
						 'label'   => 'Brand',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'channel',
						 'label'   => 'Channel',
						 'rules'   => 'trim|required'
					)
					,
					array(
						 'field'   => 'channel_price',
						 'label'   => 'channel price',
						 'rules'   => 'trim|required'
					)
					,
					array(
						 'field'   => 'description',
						 'label'   => 'Description',
						 'rules'   => 'trim|required'
					)
					
				);
			}
			else{
				$rules = array(
					array(
						 'field'   => 'firstname',
						 'label'   => 'First Name',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'lastname',
						 'label'   => 'Last Name',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'type',
						 'label'   => 'User Type',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'email',
						 'label'   => 'Email',
						 'rules'   => 'trim|required|valid_email'
					),
					array(
						 'field'   => 'password',
						 'label'   => 'Password',
						 'rules'   => 'trim|required'
					),
					array(
							 'field'   => 'confirmPassword',
							 'label'   => 'Confirm Password',
							 'rules'   => 'trim|required|matches[password]'
						)
					
				);
			}
			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()){

				$password 	= $this->input->post('password');
				$email 	   = $this->input->post('email');
				$username 	= $this->input->post('email');
					if($this->input->post('type')=='4'){
						$additional_data = array(
							'brand_name'   =>  $this->input->post('brand'),
							'channel_name' =>  $this->input->post('channel'),
							'description' =>  $this->input->post('description'),
							'channel_subscription_price' =>  floatval($this->input->post('channel_price'))
						);
					}
					else{
						$additional_data = array(
							'first_name'   => $this->input->post('firstname'),
							'last_name' 	=>  $this->input->post('lastname')
						);
					}

				}
				else{
				$this->session->set_flashdata(
						'error',
						'Please enter all details'
					);
				}
				if(isset($_FILES['picture']) and $_FILES['picture']['name']!=''){
					
					$file_name = time().$_FILES['picture']['name'];
					$additional_data['picture'] = $file_name;
					$this->session->set_userdata('profile_pic',$file_name);
					$returnValue = $this->Common_model->uploadImageByFieldName('picture',$file_name, 'uploads/profile_pic/');
					if($returnValue != true) {
						$this->session->set_flashdata('error', 'Some error picture not upload');	
					}else{
						$name = "uploads/profile_pic/".$file_name;
						$destination = "uploads/profile_pic/thumb_200_".$file_name;
						$this->Common_model->generateThumb($name,array("200",""),$destination);
					}
				}
				if (!$this->ion_auth->email_check($email))
				{ 
					$group_name = array($this->input->post('type')-1);
					$this->ion_auth->register($username, $password, $email, $additional_data, $group_name);
					
					//$this->Phpbb->user_add($identity,$identity,$password);
					
					
					$this->session->set_flashdata(
						'success',
						'Register Successfully'
					);
					redirect("admin/channel");
					
				}else{
					$this->session->set_flashdata(
						'error',
						'Email Already Exist'
					);
				}
			}
			
        $parser['content']	= $this->load->view('admin/channels/add_channel',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function editcontent()
	{
		$data['page_title'] 	= 'Edit Channel';
		$data['page_heading']  = 'Edit Channel';
		if($this->input->post()) {
			if($this->input->post('type')=='4'){
				$rules = array(
					
					array(
						 'field'   => 'email',
						 'label'   => 'Email',
						 'rules'   => 'trim|required|valid_email'
					),
					
					array(
						 'field'   => 'type',
						 'label'   => 'User Type',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'brand',
						 'label'   => 'Brand',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'channel',
						 'label'   => 'Channel',
						 'rules'   => 'trim|required'
					)
					,
					array(
						 'field'   => 'channel_price',
						 'label'   => 'channel price',
						 'rules'   => 'trim|required'
					)
					,
					array(
						 'field'   => 'description',
						 'label'   => 'Description',
						 'rules'   => 'trim|required'
					)
					
				);
			}
			else{
				$rules = array(
					array(
						 'field'   => 'type',
						 'label'   => 'User Type',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'email',
						 'label'   => 'Email',
						 'rules'   => 'trim|required|valid_email'
					)
					
				);
			}
			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()){

					if($this->input->post('type')=='4'){
						$userData = array(
							'password'   => $this->input->post('password'),
							'email' 	=>  $this->input->post('email'),
							'username' 	=>  $this->input->post('email'),
							'brand_name'   =>  $this->input->post('brand'),
							'channel_name' =>  $this->input->post('channel'),
							'description' =>  $this->input->post('description'),
							'channel_subscription_price' =>  floatval($this->input->post('channel_price'))
						);
					}
					else{
						$userData = array(
							'password'   => $password,
							'email' 	=>  $email,
							'username' 	=>  $email,
						);
					}
					
					if(isset($_FILES['picture']) and $_FILES['picture']['name']!=''){
					
					$file_name = time().$_FILES['picture']['name'];
					$userData['picture'] = $file_name;
					$this->session->set_userdata('profile_pic',$file_name);
					$returnValue = $this->Common_model->uploadImageByFieldName('picture',$file_name, 'uploads/profile_pic/');
					if($returnValue != true) {
						$this->session->set_flashdata('error', 'Some error picture not upload');	
					}else{
						$name = "uploads/profile_pic/".$file_name;
						$destination = "uploads/profile_pic/thumb_200_".$file_name;
						$this->Common_model->generateThumb($name,array("200",""),$destination);
					}
				}
					if (!$this->Users_model->email_check($this->input->post('email'),$this->input->get('id')))
						{
					//$group_name = array($this->input->post('type')-1);
					$this->Users_model->update($userData, $this->input->get('id')); 
					//$this->Phpbb->user_add($identity,$identity,$password);
					
					
					$this->session->set_flashdata(
						'success',
						'Updated Successfully'
					);
					redirect("admin/channel");
					
				}else{
					$this->session->set_flashdata(
						'error',
						'Email Already Exist'
					);
				}

				}
				else{
				$this->session->set_flashdata(
						'error',
						'Please enter all details'
					);
				}
				
			}

		$data['usersRow'] 	= $this->Users_model->getRow($this->input->get('id'));
		//print_r($data['usersRow']);die();
        $parser['content']		= $this->load->view('admin/channels/edit_channel',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
}