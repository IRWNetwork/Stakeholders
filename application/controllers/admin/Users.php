<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
	function __construct() {

        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Emailtemplates_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');

    }
    
	public function index() {
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
			redirect(site_url('admin/dashboard'), 'refresh');
		}
		
		$data['page_title'] 	= 'Admin Login';
		$data['page_heading'] 	= 'Admin Login';
		
		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'trim|required|valid_email'
                ),
               	array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   => 'trim|required'
                )
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {

				$identity = $this->input->post("email");
				$password = $this->input->post("password");
				
				if($this->ion_auth->login($identity,$password)) {
					$user = $this->ion_auth->user()->row();
					//echo '<pre>';print_r($user);exit;
					$this->session->set_userdata('user_name', $user->first_name." ".$user->last_name);
					$this->session->set_userdata('profile_picture', $user->picture);
					$this->session->set_flashdata(
							'uname',
							$user->first_name." ".$user->last_name
					);
					redirect(site_url('admin/dashboard'), 'refresh');
				} else {
					$this->session->set_flashdata(
						'error',
						'Invalid Email or Password'
					);
					redirect('admin/');
				}
			}
		}

		$this->load->view('admin/user/login',$data);
	}
	
	
	function logout() {   //Basic Ion_Auth Logout function

		$this->ion_auth->logout();

		redirect('admin/');
		
	}


	public function edit_admin($id) {
		$user_id = $id;
		$data['page_title'] 	  = 'Edit Admin';
		$data['page_heading'] 	= 'Edit Admin';
		$query =  $this->db->query('Select * from users where users.id = '.$user_id);
		$data['admin'] = $query->row_array();
		//echo "<pre>"; print_r($data['admin']);exit;
		$old_picture = $data['admin']['picture'];
		if ($this->input->post()) {
			//echo "<pre>"; print_r($this->input->post());exit;
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
            );

            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()) {
				$this->ion_auth->update($id, $this->input->post());

				if ($_FILES['picture']['tmp_name']) {
					if ($old_picture != '') {
					//echo 'heu';exit;
						$old_picture = 'uploads/files/'.$old_picture;
						unlink($old_picture);
					}
					
					$picture_name 	= 'file_' . time();
					$path       	= 'uploads/files/';
					$picture_name 	= $this->Common_model->upload_admin_file($picture_name,$path,'picture');
					$data = array(
		               'picture' => $picture_name
		            );

					$this->db->where('id', $user_id);
					$this->db->update('users', $data); 
				}
				$this->session->set_flashdata(
						'success',
						'Updated Successfully'
					);
				redirect("/admin/users/admins");
            }
		}

		$parser['content']	= $this->load->view('admin/user/add_admin',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
		
	}
	public function add_admin($flag=-1) {
		$data['page_title'] 	  = 'Add Admin';
		$data['page_heading'] 	= 'Add Admin';
		$this->data['flag']		 = $flag; 
		if ($this->input->post()) {
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
						 'field'   => 'confirmPassword',
						 'label'   => 'Confirm Password',
						 'rules'   => 'trim|required|matches[password]'
					),
            );

            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()) {

				$password 	= $this->input->post('password');
				$email 		= $this->input->post('email');
				$username 	= $this->input->post('email');
				$additional_data = array(
					'first_name'   => $this->input->post('firstname'),
					'last_name' 	=>  $this->input->post('lastname')
				);
				if (!$this->ion_auth->email_check($email))
				{
					$group_name = array($this->input->post('flag')+1);
					$last_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group_name,$flag);
					
					if ($_FILES['picture']['tmp_name']) {
						$picture_name 	= 'file_' . time();
						$path       	= 'uploads/files/';
						$picture_name 	= $this->Common_model->upload_admin_file($picture_name,$path,'picture');
						$data = array(
			               'picture' => $picture_name
			            );

						$this->db->where('id', $last_id);
						$this->db->update('users', $data); 
					}
					$this->session->set_flashdata(
						'success',
						'Register Successfully'
					);
					redirect("/");
					
				}else{
					$this->session->set_flashdata(
						'error',
						'Email Already Exist'
					);
				}
			}else{
				$this->session->set_flashdata(
						'error',
						'Please enter all details'
					);
			}
		}

		$parser['content']	= $this->load->view('admin/user/add_admin',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function admins() {
		$data['page_title'] 	 = 'Admins';
		$data['page_heading']   = 'Admins';
		$data['admins']	 = $this->Users_model->getAllAdmins();
		//echo "<pre>"; print_r($data['admins']);exit;
        $parser['content']	= $this->load->view('admin/user/admin_listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	public function forgotpassword() {
		
		if ($this->ion_auth->logged_in()) {
			redirect(site_url('admin/dashboard'), 'refresh');
		}
		
		$data['page_title'] 	= 'Forgot Password';
		$data['page_heading'] 	= 'Forgot Password';
		
		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'trim|required|valid_email'
                )
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				
				$emailAddress = $this->input->post("email");

				// get identity for that email
				$identity = $this->ion_auth->where('email', strtolower($emailAddress))->users()->row();
				
				if($identity) {
					//run the forgotten password method to email an activation code to the user
					$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
					
					// fetch user details
					$user_detail = $this->Users_model->get_user_detail_by_email($emailAddress);
					$firstName = $user_detail['first_name'];
					$lastName = $user_detail['last_name'];
				
					// Read unique code
					$ucode = $user_detail['forgotten_password_code'];
	
					
					// Send activation email to user
					$subject = 'Leaders Portal Password Reset';
					$data['full_name'] = $firstName . ' ' . $lastName;
					$data['email'] = $emailAddress;
					$data['url'] = site_url('users/reset_password').'/'.$ucode;
						
					$result = $this->Emailtemplates_model->sendMail('forgot_password',$data);
					$this->session->set_flashdata(
						'success',
						'A password reset email has been sent to you'
					);
					redirect(base_url().'admin/users/forgotpassword', 'refresh');
				} else {
					$this->session->set_flashdata(
							'error',
							'Email not found'
					);
					
					redirect(base_url().'admin/users/forgotpassword', 'refresh');
				}				
			}
		}

		$this->load->view('admin/user/forgot-password',$data);
	}

	public function reset_password($code) {
		
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
			redirect(site_url('admin/dashboard'), 'refresh');
		}
		
		$data['page_title'] 	= 'Reset Password';
		$data['page_heading'] 	= 'Reset Password';
		
		$data['title'] = "Leaders Portal";
		$data['code'] = $code;
		$user = $this->ion_auth->forgotten_password_check($code);
		if ($user)
		{
			$data['user_id'] = $user->id;
			if($_POST) 
			{

				$password = $this->input->post("password");
				$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[5]|max_length[15]|matches[repassword]');
				$this->form_validation->set_rules('repassword', 'Confirm Password', 'trim|required|min_length[5]|max_length[15]');
	
				if ($this->form_validation->run())
				{
					// do we have a valid request?
					if ($user->id != $this->input->post('user_id'))
					{
						//something fishy might be up
						$this->ion_auth->clear_forgotten_password_code($code);
						show_error($this->lang->line('error_csrf'));
					}
					else
					{
						// finally change the password
						$identity = $user->{$this->config->item('identity', 'ion_auth')};
					
						$change = $this->ion_auth->reset_password($identity, $password);
					
						if ($change)
						{
							//if the password was successfully changed
							$this->session->set_flashdata('success', $this->ion_auth->messages());
							//$this->logout();
							redirect(site_url('admin/'), 'refresh');
						}
						else
						{
							$this->session->set_flashdata('error', $this->ion_auth->errors());
							redirect(site_url('admin/users/reset_password') . '/'.$code, 'refresh');
						}
					}
				}
		  	}
		} else {
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect(site_url('users'), 'refresh');
		}
		$this->load->view('admin/user/resetpassword',$data);
	}
	
	public function changepassword() {
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
		$data['page_title'] 	= 'Change Password';
		$data['page_heading'] 	= 'Change Password';
		
		$data['title'] = "Leaders Portal";
		if($_POST) 
		{

			$password = $this->input->post("password");
			$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[5]|max_length[15]|matches[repassword]');
			$this->form_validation->set_rules('repassword', 'Confirm Password', 'trim|required|min_length[5]|max_length[15]');

			if ($this->form_validation->run())
			{
				
				$user = $this->ion_auth->user()->row();
				// finally change the password
				$identity = $user->{$this->config->item('identity', 'ion_auth')};
				
				$data = array(
							"password" => $this->input->post('password')
						);

				$id = $user->id;
				$change = $this->ion_auth->update($id, $data);
				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('success', "Password updated successfully");
					//$this->logout();
					redirect(site_url('admin/users/changepassword'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					redirect(site_url('admin/users/changepassword') . '/'.$code, 'refresh');
				}
			}			
		}
		
		$parser['content'] = $this->load->view('admin/user/changepassword',$data,true);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function profile() {
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
		$data['page_title'] 	= 'Profile';
		$data['page_heading'] 	= 'Profile';
		

		if($this->input->post()) {
			$rules = array(
              	array(
                     'field'   => 'first_name',
                     'label'   => 'First Name',
                     'rules'   => 'trim|required'
                ),
               	array(
                     'field'   => 'last_name',
                     'label'   => 'Last Name',
                     'rules'   => 'trim|required'
                )
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {
				
				$user_id = $this->ion_auth->user()->row()->id;
				// finally change the password
				if(isset($_FILES['picture']) and $_FILES['picture']['name']!=''){
                    $profile_pic = "profile_pic".time().str_replace(' ','_',$_FILES['picture']['name']);
                    $profile_pic = $this->Common_model->uploadImageByFieldName('picture',$profile_pic, 'uploads/profile_pic/');
                    if($profile_pic != true) {
                        $this->session->set_flashdata('error', 'Some error picture not upload');
                    }else{
                        $data['picture'] = $profile_pic;
                    }
                }
				$data = array(
							"first_name" 	=> $this->input->post('first_name'),
							"last_name" 	=> $this->input->post('last_name'),
							"phone" 		=> $this->input->post('phone'),
							"picture" 		=> $profile_pic
						);
				$change = $this->ion_auth->update($user_id, $data);

				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('success', "Updated successfully");
					$this->session->set_userdata('profile_picture', $profile_pic);
					//$this->logout();
					redirect(site_url('admin/users/profile'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					redirect(site_url('admin/users/profile') . '/'.$code, 'refresh');
				}
			}			
		}
		$data['user'] = $this->ion_auth->user()->row();
		$parser['content'] = $this->load->view('admin/user/profile',$data,true);
        $this->parser->parse('admin/template', $parser);
	}
	
	

}
