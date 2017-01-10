<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/braintree-php/lib/Braintree.php";
class User extends MY_Controller
{
	var $clientToken;
	function __construct() {

        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Emailtemplates_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		//$this->load->library('Phpbb_bridge');
    }
	public function index() {
		ciredirect(site_url('user/login'), 'refresh');
	}
	
	public function phpbb_login(){
		define('IN_PHPBB', true);
		global $request;
		global $phpbb_container;
		global $phpbb_root_path, $phpEx, $user, $auth, $cache, $db, $config, $template, $table_prefix;
		global $request;
		global $phpbb_dispatcher;
		global $symfony_request;
		global $phpbb_filesystem;
		$phpbb_root_path = '../irw/forums/'; //the path to your phpbb relative to this script
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		include("forums/common.php"); ////the path to your phpbb relative to this script
		// Start session management
		$user->session_begin();
		$auth->acl($user->data);
		$user->setup();
		
		$username = 'admin';
		$password = 'atif$$786';
		if(isset($username) && isset($password))
		{
			$result=$auth->login($username, $password, true);
		  	if ($result['status'] == LOGIN_SUCCESS) {
				//echo "You're logged in";
		  	} else {
				//echo $user->lang[$result['error_msg']];
		  	}
		}
	}
    
	public function login() {
		
		
		
		if ($this->ion_auth->logged_in()) {
			ciredirect(site_url('/'), 'refresh');
		}
		
		$this->data['page_title'] 	= 'User Login';
		$this->data['page_heading'] 	= 'User Login';
		
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
					
					
					//$this->phpbb_login($identity,$password);

					$user = $this->ion_auth->user()->row();
					//$this->Phpbb->user_login($identity,$password);
					$this->session->set_userdata(
							'email',
							$user->username
					);
					$this->session->set_userdata(
							'id',
							$user->id
					);
					$this->session->set_userdata(
							'uname',
							$user->first_name." ".$user->last_name
					);
					$this->session->set_userdata(
							'username',
							$user->first_name."_".$user->last_name
					);
						$this->session->set_userdata(
							'profile_pic',
							$user->picture);
					ciredirect(site_url('/'), 'refresh');
				} else {
					$this->session->set_flashdata(
						'error',
						'Invalid Email or Password'
					);
				}
			}
		}

		$this->load->view('user/login',$this->data);
	}
	
	function register(){
		if ($this->ion_auth->logged_in()) {
			ciredirect(site_url('/'), 'refresh');
		}
		
		$this->data['page_title'] 	= 'User Registeration';
		$this->data['page_heading'] = 'User Registeration';
		
		if($this->input->post()) {
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
                     'field'   => 'terms',
                     'label'   => 'Terms',
                     'rules'   => 'trim|required'
                )
            );

			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run()) {

				$password 	= $this->input->post('password');
				$email 		= $this->input->post('email');
				$username 	= $this->input->post('email');
				$additional_data = array(
										'first_name' 	=> $this->input->post('firstname'),
										'last_name' 	=> $this->input->post('lastname'),
									);
				if (!$this->ion_auth->email_check($email))
				{
					$group_name = array(2);
					$this->ion_auth->register($username, $password, $email, $additional_data, $group_name);
					
					//$this->Phpbb->user_add($identity,$identity,$password);
					
					
					$this->session->set_flashdata(
						'success',
						'Register Successfully'
					);
					ciredirect("home/");
					
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

		
		$this->load->view('user/register',$this->data);
	}
	
	
	function logout() {   //Basic Ion_Auth Logout function

		$this->ion_auth->logout();

		ciredirect('/');
		
	}
	
	public function forgotpassword() {
		
		if ($this->ion_auth->logged_in()) {
			ciredirect(site_url('/'), 'refresh');
		}
		
		$this->data['page_title'] 	= 'Forgot Password';
		$this->data['page_heading'] 	= 'Forgot Password';
		
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
					$this->data['full_name'] = $firstName . ' ' . $lastName;
					$this->data['email'] = $emailAddress;
					$this->data['url'] = site_url('user/reset_password').'/'.$ucode;
						
					$result = $this->Emailtemplates_model->sendMail('forgot_password',$this->data);
					$this->session->set_flashdata(
						'success',
						'A password reset email has been sent to you'
					);
					ciredirect(base_url().'user/forgotpassword', 'refresh');
				} else {
					$this->session->set_flashdata(
							'error',
							'Email not found'
					);
					
					ciredirect(base_url().'user/forgotpassword', 'refresh');
				}				
			}
		}

		$this->load->view('user/forgot-password',$this->data);
	}

	public function reset_password($code) {
		
		if ($this->ion_auth->logged_in()) {
			ciredirect(site_url('/'), 'refresh');
		}
		
		$this->data['page_title'] 	= 'Reset Password';
		$this->data['page_heading'] 	= 'Reset Password';
		
		$this->data['title'] = "Leaders Portal";
		$this->data['code'] = $code;
		$user = $this->ion_auth->forgotten_password_check($code);
		if ($user)
		{
			$this->data['user_id'] = $user->id;
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
							ciredirect(site_url(''), 'refresh');
						}
						else
						{
							$this->session->set_flashdata('error', $this->ion_auth->errors());
							ciredirect(site_url('user/reset_password') . '/'.$code, 'refresh');
						}
					}
				}
		  	}
		} else {
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			ciredirect(site_url('users'), 'refresh');
		}
		$this->load->view('user/resetpassword',$this->data);
	}
	
	public function changepassword() {
		if (!$this->ion_auth->logged_in()) {
			ciredirect(site_url(''), 'refresh');
		}
		$this->data['page_title'] 	= 'Change Password';
		$this->data['page_heading'] 	= 'Change Password';
		
		$this->data['title'] = "Leaders Portal";
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
					ciredirect(site_url('user/changepassword'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					ciredirect(site_url('user/changepassword') . '/'.$code, 'refresh');
				}
			}			
		}
		
		$parser['content'] = $this->load->view('user/changepassword',$this->data,true);
        $this->parser->parse('template', $parser);
	}
	
	public function profile() {
		if (!$this->ion_auth->logged_in()) {
			ciredirect(site_url(''), 'refresh');
		}
		$this->data['page_title'] 	= 'Profile';
		$this->data['page_heading'] 	= 'Profile';
		
print_r($this->session->all_userdata());
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
				
				if(isset($_FILES['picture']) and $_FILES['picture']['name']!=''){
					
					$file_name = time().$_FILES['picture']['name'];
					$data['picture'] = $file_name;
					$this->session->set_userdata('profile_pic',$file_name);
					$returnValue = $this->Common_model->uploadImageByFieldName('picture',$file_name, 'uploads/profile_pic/');
					if($returnValue != true) {
						$this->session->set_flashdata('error', 'Some error picture not upload');	
					}else{
						$name = "uploads/profile_pic/".$file_name;
						$destination = "uploads/profile_pic/thumb_200_".$file_name;
						$this->Common_model->generateThumb($name,array("200",""),$destination);
						
						@unlink("uploads/profile_pic/".$this->input->post('old_pic'));
						@unlink("uploads/profile_pic/thumb_200_".$this->input->post('old_pic'));
					}
				}
								
				$change = $this->ion_auth->update($user_id, $data);
				$this->session->set_flashdata('success', 'Updated successfully');
				ciredirect(site_url('user/profile'), 'refresh');
			}
		}
		$this->data['user'] = $this->ion_auth->user()->row();
		$parser['content'] = $this->load->view('user/profile',$this->data,true);
        $this->parser->parse('template', $parser);
	}
	
	public function upgradepackage() {
		if (!$this->ion_auth->logged_in()) {
			ciredirect(site_url(''), 'refresh');
		}
		$this->data['page_title'] 	= 'Upgrade Package';
		$this->data['page_heading'] 	= 'Upgrade Package';
		$this->init_braintree();

		if($this->input->post()) {
			
				
				$user_id = $this->ion_auth->user()->row()->id;
				// finally change the password
				
				$result = Braintree_Transaction::sale(array(
						"amount" 				=> 45,
						"paymentMethodNonce" 	=> $_REQUEST['payment_method_nonce'],
						"options" 				=> array(
														"submitForSettlement" => true,
														"storeInVaultOnSuccess"=>true
													)
					));
				
				$merchant_responce = json_encode($result);
				if ($result->success) {
					
					
					$braintree_token = "";
					$txn = $result->transaction;
					if ($txn->paymentInstrumentType == 'credit_card') {
						$braintree_token = $txn->creditCardDetails->token;
					}else if ($txn->paymentInstrumentType == 'paypal_account') {
						$braintree_token = $txn->paypalDetails->token;
					}
					$next_recharge_date = getNextRechargeDate('month');
					$data_update 		= array(
												"braintree_payment_token" 	=> $braintree_token,
												"next_recharge_date" 		=> $next_recharge_date,
												"is_premium"				=> "yes"
											);
					
					$this->ion_auth->update($user_id,$data_update);
					$this->session->set_flashdata('success', "Package updated successfully");
					ciredirect(base_url()."user/upgradepackage");
				}else{
					$this->session->set_flashdata('error', $result->message);
					ciredirect(base_url()."user/upgradepackage");
				}
			
		}
		$this->data['clientToken']= $this->clientToken;
		$this->data['user'] 		= $this->ion_auth->user()->row();
		$parser['content'] 	= $this->load->view('user/upgradepackage',$this->data,true);
        $this->parser->parse('template', $parser);
	}
	
	private function init_braintree(){
		$this->clientToken =  init_Braintree();
	}
	
	function favorite(){
		
		if (!$this->ion_auth->logged_in()) {
			ciredirect(site_url('/'), 'refresh');
		}
		
		$user_id 	= $this->ion_auth->user()->row()->id;
		$this->data['page_title'] 		= 'Favorite';
		$this->data['page_heading'] 	= 'Favorite';
		$search 			   = $this->input->get('search')?$this->input->get('search'):"";
        $arr['name']           = $search;
		$config 			   = array();
        $config["base_url"]    = base_url() . "products/search";
        $config["total_rows"]  = $this->Content_model->countFavoriteSongs($user_id,$arr);
		if($this->input->get('per_page')){
			$config["per_page"]= $this->input->get('per_page');
		}else{
        	$config["per_page"]= 20;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string']   = true;
        $this->pagination->initialize($config);
        $page 		= ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$this->data['contents']	= $this->Content_model->getAllFavoriteSongs($user_id,$arr,$page,$config["per_page"]);
		
		$this->data["links"]   = $this->pagination->create_links();
		
		echo $this->load->view('user/favorite',$this->data,true);
		//$parser['content'] 	= $this->load->view('user/favorite',$this->data,true);
        //$this->parser->parse('template', $parser);
	}

}
