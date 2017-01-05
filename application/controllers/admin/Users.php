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
			ciredirect(site_url('admin/dashboard'), 'refresh');
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
					$this->session->set_flashdata(
							'uname',
							$user->first_name." ".$user->last_name
					);
					ciredirect(site_url('admin/dashboard'), 'refresh');
				} else {
					$this->session->set_flashdata(
						'error',
						'Invalid Email or Password'
					);
					ciredirect('admin/');
				}
			}
		}

		$this->load->view('admin/user/login',$data);
	}
	
	
	function logout() {   //Basic Ion_Auth Logout function

		$this->ion_auth->logout();

		ciredirect('admin/');
		
	}
	
	public function forgotpassword() {
		
		if ($this->ion_auth->logged_in()) {
			ciredirect(site_url('admin/dashboard'), 'refresh');
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
					ciredirect(base_url().'admin/users/forgotpassword', 'refresh');
				} else {
					$this->session->set_flashdata(
							'error',
							'Email not found'
					);
					
					ciredirect(base_url().'admin/users/forgotpassword', 'refresh');
				}				
			}
		}

		$this->load->view('admin/user/forgot-password',$data);
	}

	public function reset_password($code) {
		
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
			ciredirect(site_url('admin/dashboard'), 'refresh');
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
							ciredirect(site_url('admin/'), 'refresh');
						}
						else
						{
							$this->session->set_flashdata('error', $this->ion_auth->errors());
							ciredirect(site_url('admin/users/reset_password') . '/'.$code, 'refresh');
						}
					}
				}
		  	}
		} else {
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			ciredirect(site_url('users'), 'refresh');
		}
		$this->load->view('admin/user/resetpassword',$data);
	}
	
	public function changepassword() {
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			ciredirect(site_url('admin/'), 'refresh');
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
					ciredirect(site_url('admin/users/changepassword'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					ciredirect(site_url('admin/users/changepassword') . '/'.$code, 'refresh');
				}
			}			
		}
		
		$parser['content'] = $this->load->view('admin/user/changepassword',$data,true);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function profile() {
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			ciredirect(site_url('admin/'), 'refresh');
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
				
				$data = array(
							"first_name" 	=> $this->input->post('first_name'),
							"last_name" 	=> $this->input->post('last_name'),
							"phone" 		=> $this->input->post('phone')
						);
			
				$change = $this->ion_auth->update($user_id, $data);

				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('success', "Updated successfully");
					//$this->logout();
					ciredirect(site_url('admin/users/profile'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					ciredirect(site_url('admin/users/profile') . '/'.$code, 'refresh');
				}
			}			
		}
		$data['user'] = $this->ion_auth->user()->row();
		$parser['content'] = $this->load->view('admin/user/profile',$data,true);
        $this->parser->parse('admin/template', $parser);
	}

}
