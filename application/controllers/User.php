<?php
defined('BASEPATH') OR exit('No direct script access allowed');
///require_once APPPATH."/third_party/braintree-php/lib/Braintree.php";
class User extends MY_Controller
{
    var $clientToken;
    function __construct() {

        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Common_model');
        $this->load->model('Content_model');
        $this->load->model('Emailtemplates_model');
        $this->load->model('Authorize_model');
        $this->load->library("pagination");
        $this->load->library('ion_auth');
        $this->load->model('Preferences_model');
        //$this->load->library('Phpbb_bridge');
    }
    public function index() {

        redirect(site_url('user/login'), 'refresh');
    }

    public function login() {
        if ($this->ion_auth->logged_in()) {
            redirect(site_url('/'), 'refresh');
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
                    $user_groups = $this->ion_auth->get_users_groups($user->id)->row();

                    $user_group_id = $user_groups->id;

                    if($this->ion_auth->in_group(3)){
                        if($user->is_approved==1){
                            $user_group_id = 3;
                        }
                    }


                    if($user_group_id==3 && $user->is_approved==0){
                        $this->session->set_flashdata(
                            'error',
                            'Your account is not approved yet.'
                        );
                        $this->ion_auth->logout();
                    }else{
                        //$this->Phpbb->user_login($identity,$password);
                        $this->session->set_userdata('userGroup', $user_group_id);
                        $this->session->set_userdata('is_approved', $user->is_approved);
                        $this->session->set_userdata('email',$user->username);
                        $this->session->set_userdata('content_block',$user->content_block);
                        $this->session->set_userdata('id',$user->id);
                        $this->session->set_userdata('uname',$user->first_name." ".$user->last_name);
                        $this->session->set_userdata('username',$user->first_name."_".$user->last_name);
                        $this->session->set_userdata('profile_pic',$user->picture);
                        $this->session->set_userdata('password',$password);
                        $_SESSION['customer_id'] =  $user->id;
                        //setcookie('customer_id', $user->id, time()+30*3600*24, '/');
                        if (isset($_SESSION['after_login'])) {
                            redirect(site_url('/'.$_SESSION['after_login']), 'refresh');
                        }
                        redirect(site_url('/'), 'refresh');
                    }
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


    function register($flag=-1){
        if ($this->ion_auth->logged_in()){
            if($flag==2 && $this->session->userdata('userGroup')==2){
                /// Don't Redirect
            }else{
                redirect(site_url('/'), 'refresh');
            }
        }


        $this->data['page_title']   = 'User Registeration';
        $this->data['page_heading'] = 'User Registeration';
        $this->data['flag']		 = $flag;
        //echo "<pre>";print_r( $this->input->post()); die();
        if($this->input->post()) {
            if($this->input->post('flag')==2){
                if($this->input->post('upgrade_to_producer')){
                    $rules = array(
                        array(
                            'field'   => 'terms',
                            'label'   => 'Terms',
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
                        ),
                        array(
                            'field'   => 'salespitch',
                            'label'   => 'Sales Pitch',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'day_of_contact',
                            'label'   => 'Day To Contact',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'day_time_of_contact',
                            'label'   => 'Time To Contact',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'brand_twitter_followers',
                            'label'   => 'Brand Twitter Followers',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'brand_facebook_likes',
                            'label'   => 'Brand Facebook Likes',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'brand_instagram_followers',
                            'label'   => 'Brand Instagram Followers',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'phone',
                            'label'   => 'Phone Number',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'brand',
                            'label'   => 'Brand Name',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'channel',
                            'label'   => 'channel Name',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'salespitch',
                            'label'   => 'Sales Pitch',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'channel_price',
                            'label'   => 'Channel Price',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'description',
                            'label'   => 'Description',
                            'rules'   => 'trim|required'
                        ),
                        array(
                            'field'   => 'how_were_you_monitizing_content_before',
                            'label'   => 'Monitizing Content Before',
                            'rules'   => 'trim|required'
                        )
                    );
                }
                else {
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
                        array(
                            'field'   => 'terms',
                            'label'   => 'Terms',
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
                        ),
                        array(
                            'field'   => 'salespitch',
                            'label'   => 'Sales Pitch',
                            'rules'   => 'trim|required'
                        )
                    );
                }
            }
            else if($this->input->post('flag') ==1 || $this->input->post('flag') == 3){
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
                    array(
                        'field'   => 'terms',
                        'label'   => 'Terms',
                        'rules'   => 'trim|required'
                    )

                );
            }
            else{
                $this->session->set_flashdata(
                    'error',
                    'Please Select Type'
                );
                redirect(site_url('/user/type'), 'refresh');
            }

            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run()) {

                if(!$this->input->post('upgrade_to_producer')){

                $password 	= $this->input->post('password');
                $email 		= $this->input->post('email');
                $username 	= $this->input->post('email');
                    $additional_data = array(
                        'first_name'   => $this->input->post('firstname'),
                        'last_name' 	=>  $this->input->post('lastname')
                    );
                }



                if($flag==2){
                        if(isset($_FILES['monitization_background_on_brand']) and $_FILES['monitization_background_on_brand']['name']!=''){
                            $monitization_background = "monitization_background_on_brand".time().str_replace(' ','_',$_FILES['monitization_background_on_brand']['name']);
                            $monitization_background = $this->Common_model->uploadImageByFieldName('monitization_background_on_brand',$monitization_background, 'uploads/profile_pic/');
                            if($monitization_background != true) {
                                $this->session->set_flashdata('error', 'Some error picture not upload');
                            }else{
                                $data['monitization_background_on_brand'] = $monitization_background;
                            }
                        }

                        if(isset($_FILES['general_background_on_brand']) and $_FILES['general_background_on_brand']['name']!=''){
                            $general_background = "general_background_on_brand".time().str_replace(' ','_',$_FILES['general_background_on_brand']['name']);
                            $general_background = $this->Common_model->uploadImageByFieldName('general_background_on_brand',$general_background, 'uploads/profile_pic/');
                            if($general_background != true) {
                                $this->session->set_flashdata('error', 'Some error picture not upload');
                            }else{
                                $data['general_background_on_brand'] = $general_background;
                            }
                        }

                        $additional_data['brand_name']   =  $this->input->post('brand');
                        $additional_data['channel_name'] =  $this->input->post('channel');
                        $additional_data['sales_pitch']  =  $this->input->post('salespitch');
                        $additional_data['phone']  =  $this->input->post('phone');
                        $additional_data['day_time_of_contact']  =  $this->input->post('day_time_of_contact');
                        $additional_data['day_of_contact']  =  $this->input->post('day_of_contact');
                        $additional_data['brand_twitter_followers']  =  $this->input->post('brand_twitter_followers');
                        $additional_data['brand_facebook_likes']  =  $this->input->post('brand_facebook_likes');
                        $additional_data['brand_instagram_followers']  =  $this->input->post('brand_instagram_followers');
                        $additional_data['how_were_you_monitizing_content_before']  =  $this->input->post('how_were_you_monitizing_content_before');
                        $additional_data['channel_subscription_price'] =  floatval($this->input->post('channel_price'));
                        $additional_data['description']  =  $this->input->post('description');
                        $additional_data['monitization_background'] = $monitization_background;
                        $additional_data['general_background'] = $general_background;
                        $additional_data['is_approved'] = 0;
                }



                if($this->session->userdata('userGroup') == 2){

                    if(isset($_FILES['monitization_background_on_brand']) and $_FILES['monitization_background_on_brand']['name']!=''){
                        $monitization_background = "monitization_background_on_brand".time().str_replace(' ','_',$_FILES['monitization_background_on_brand']['name']);
                        $monitization_background = $this->Common_model->uploadImageByFieldName('monitization_background_on_brand',$monitization_background, 'uploads/profile_pic/');
                        if($monitization_background != true) {
                            $this->session->set_flashdata('error', 'Some error picture not upload');
                        }else{
                            $data['monitization_background_on_brand'] = $monitization_background;
                        }
                    }

                    if(isset($_FILES['general_background_on_brand']) and $_FILES['general_background_on_brand']['name']!=''){
                        $general_background = "general_background_on_brand".time().str_replace(' ','_',$_FILES['general_background_on_brand']['name']);
                        $general_background = $this->Common_model->uploadImageByFieldName('general_background_on_brand',$general_background, 'uploads/profile_pic/');
                        if($general_background != true) {
                            $this->session->set_flashdata('error', 'Some error picture not upload');
                        }else{
                            $data['general_background_on_brand'] = $general_background;
                        }
                    }

                    $additional_data['brand_name']   =  $this->input->post('brand');
                    $additional_data['channel_name'] =  $this->input->post('channel');
                    $additional_data['sales_pitch']  =  $this->input->post('salespitch');
                    $additional_data['phone']  =  $this->input->post('phone');
                    $additional_data['day_time_of_contact']  =  $this->input->post('day_time_of_contact');
                    $additional_data['day_of_contact']  =  $this->input->post('day_of_contact');
                    $additional_data['brand_twitter_followers']  =  $this->input->post('brand_twitter_followers');
                    $additional_data['brand_facebook_likes']  =  $this->input->post('brand_facebook_likes');
                    $additional_data['brand_instagram_followers']  =  $this->input->post('brand_instagram_followers');
                    $additional_data['how_were_you_monitizing_content_before']  =  $this->input->post('how_were_you_monitizing_content_before');
                    $additional_data['channel_subscription_price'] =  floatval($this->input->post('channel_price'));
                    $additional_data['description']  =  $this->input->post('description');
                    $additional_data['monitization_background'] = $monitization_background;
                    $additional_data['general_background'] = $general_background;
                    $additional_data['is_approved'] = 0;
                    $user_id = $this->session->userdata('user_id');
                    $change = $this->ion_auth->update($user_id, $additional_data);
                    $this->ion_auth->add_to_group(3, $user_id);
                    $this->session->set_flashdata('success', 'Updated successfully');
                    redirect(site_url('user/profile'), 'refresh');
                }else {

                    if (!$this->ion_auth->email_check($email) && !$this->input->post('upgrade_to_producer'))
                    {
                        $group_name = array($this->input->post('flag')+1);
                        $last_id = $this->ion_auth->register($username, $password, $email, $additional_data, $group_name,$flag);

                        //$this->Phpbb->user_add($identity,$identity,$password);

                        //salted password for OC customers
                        $salt = substr(md5(uniqid(rand(), true)), 0, 9);
                        $oc_password = sha1($salt . sha1($salt . sha1($password)));
                        $first_name = $this->input->post('firstname');
                        $last_name = $this->input->post('lastname');

                        $this->register_oc($last_id, $first_name, $last_name, $email, $salt ,$oc_password);

                        if($flag==2){
                            $success_message = 'Your IRW Producer Application has been accepted. An IRW Representative will be following up with you soon Thank you for applying.';
                        }else{
                            $success_message = 'Register Successfully';
                        }

                        $this->session->set_flashdata(
                            'success',
                            $success_message
                        );
                        redirect("home/");

                    }else{

                        $this->session->set_flashdata(
                            'error',
                            'Email Already Exist'
                        );

                    }
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
	
    function register_oc($last_id, $first_name, $last_name,$email ,$salt , $oc_password) {
        $data = array(
            'customer_id' => $last_id,
            'firstname'	=> $first_name,
            'lastname'	=> $last_name,
            'email'	=> $email,
            'salt'	=> $salt,
            'password'	=>	$oc_password,
            'status'	=> 1,
            'approved'	=> 1,
            'date_added'	=> date('Y-m-d H:i:s')
        );
        $this->db->insert('oc_customer', $data);
    }
	
    public function type(){
        //die("afdf");
        //if ($this->ion_auth->logged_in()) {
        //		redirect(site_url('/'), 'refresh');
        //	}

        $this->data['page_title'] 	= 'User Type';
        $this->data['page_heading']  = 'User Type';

        $this->load->view('user/type',$this->data);
    }

    function logout() {   //Basic Ion_Auth Logout function

        $this->ion_auth->logout();
        setcookie('customer_id', '', 1, '/');
        redirect('/');

    }

    public function forgotpassword() {

        if ($this->ion_auth->logged_in()) {
            redirect(site_url('/'), 'refresh');
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
					redirect(base_url().'user/forgotpassword', 'refresh');
				} else {
					$this->session->set_flashdata(
							'error',
							'Email not found'
					);
					
					redirect(base_url().'user/forgotpassword', 'refresh');
				}				
			}
		}

		$this->load->view('user/forgot-password',$this->data);
	}

	public function reset_password($code) {
		
		if ($this->ion_auth->logged_in()) {
			redirect(site_url('/'), 'refresh');
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
				$this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[5]|matches[repassword]');
				$this->form_validation->set_rules('repassword', 'Confirm Password', 'trim|required|min_length[5]');
	
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
							redirect(site_url(''), 'refresh');
						}
						else
						{
							$this->session->set_flashdata('error', $this->ion_auth->errors());
							redirect(site_url('user/reset_password') . '/'.$code, 'refresh');
						}
					}
				}
		  	}
		} else {
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect(site_url('users'), 'refresh');
		}
		$this->load->view('user/resetpassword',$this->data);
	}
	
	public function changepassword() {
		if (!$this->ion_auth->logged_in()) {
			redirect(site_url(''), 'refresh');
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
					redirect(site_url('user/changepassword'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('error', $this->ion_auth->errors());
					redirect(site_url('user/changepassword') . '/'.$code, 'refresh');
				}
			}			
		}
		
		$parser['content'] = $this->load->view('user/changepassword',$this->data,true);

        $this->parser->parse('template', $parser);
    }
	
	function bankingInformation(){
		 if (!$this->ion_auth->logged_in()) {
            redirect(site_url(''), 'refresh');
        }
        $this->data['page_title'] 	= 'Merchant Preferecnes';
        $this->data['page_heading']	= 'Merchant Preferecnes';

        $producer_id = $this->ion_auth->get_user_id();
        if($this->input->post()) {
            $rules = array(
                array(
                    'field'   => 'firstname',
                    'label'   => 'First',
                    'rules'   => 'trim|required'
                ),
                array(
                    'field'   => 'lastname',
                    'label'   => 'Lastname',
                    'rules'   => 'trim|required'
                ),
                array(
                    'field'   => 'email',
                    'label'   => 'Email',
                    'rules'   => 'trim|required|valid_email'
                ),
                array(
                    'field'   => 'phone',
                    'label'   => 'Phone',
                    'rules'   => 'trim|required'
                ),
            );
            
            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run()) {
                
                $account = $this->input->post('account');
                $CI =& get_instance();
                $CI->load->helper('common_helper');
                initialize_Braintree();
                
                $sql = $this->db->query("select * from braintree_merchant_info where producer_id='$producer_id'");
                $braintree_merchant = $sql->row();
                //echo "<pre>"; print_r($braintree_merchant);exit;
                //echo $this->db->last_query();exit;
                if(count($braintree_merchant)>0) {
                    $record_id = $braintree_merchant->id;
                    if($braintree_merchant->merchant_account_number!=''){
                        $arr_merchant=array();
                        $arr_merchant['individual'] = array(
                            'firstName'    => $this->input->post('firstname'),
                            'lastName'    => $this->input->post('lastname'),
                            'email'    => $this->input->post('email'),
                            'dateOfBirth' => $this->input->post('birth_day'),
                            'phone'    => $this->input->post('phone'),
                            'ssn'    => $this->input->post('ssn'),
                            'address' => array(
                                'streetAddress' => $this->input->post('street_address'),
                                'locality' => $this->input->post('city'),
                                'region' => $this->input->post('state'),
                                'postalCode' => $this->input->post('zip'),
                            )
                        );  
                        if ($account=='business') {
                            $arr_merchant['business'] = array(
                                'legalName' => $this->input->post('legal_name'),
                                'dbaName' => $this->input->post('dba_name'),
                                'taxId' => $this->input->post('tax_id'),
                                'address' => array(
                                    'streetAddress' => $this->input->post('buss_street_address'),
                                    'locality' => $this->input->post('buss_street_address'),
                                    'region' => $this->input->post('buss_state'),
                                    'postalCode' => $this->input->post('buss_zip'),
                                )
                            );
                        }
                        $arr_merchant['funding'] = array(
                            //'descriptor' => $descriptor,
                            'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
                            'email' => $this->input->post('buss_email'),
                            'mobilePhone' => $this->input->post('buss_mobile'),
                            'accountNumber' =>  $this->input->post('buss_acc_num'),
                            'routingNumber' => $this->input->post('buss_routing_num')
                        );
                        $result = Braintree_MerchantAccount::update(
                            $braintree_merchant->merchant_account_number,
                            $arr_merchant
                        );
                        //echo "<pre>"; print_r($result);exit;
                        if($result->success){
                            $merchant_id = $result->merchantAccount->id;
                            $data = array (
                                'first_name'    => $this->input->post('firstname'),
                                'last_name'    => $this->input->post('lastname'),
                                'last_name'    => $this->input->post('lastname'),
                                'birth_day' => $this->input->post('birth_day'),
                                'email'    => $this->input->post('email'),
                                'phone'    => $this->input->post('phone'),
                                'ssn'    => $this->input->post('ssn'),
                                'street_address'    => $this->input->post('street_address'),
                                'city'    => $this->input->post('city'),
                                'state'    => $this->input->post('state'),
                                'zip'    => $this->input->post('zip'),
                                'country'    => $this->input->post('country'),
                                'payout_email'    => $this->input->post('payout_email'),
                                'mobile_phone'    => $this->input->post('mobile'),
                                'account_number'    => $this->input->post('account'),
                                'routing_number'    => $this->input->post('routing'),
                                'legal_name'    => $this->input->post('legal_name'),
                                'dba_name'    => $this->input->post('dba_name'),
                                'tax_id'    => $this->input->post('tax_id'),
                                'buss_street_address'    => $this->input->post('buss_street_address'),
                                'buss_state'    => $this->input->post('buss_state'),
                                'buss_zip'    => $this->input->post('buss_zip'),
                                'buss_country'    => $this->input->post('buss_country'),
                                'buss_email'    => $this->input->post('buss_email'),
                                'buss_mobile'    => $this->input->post('buss_mobile'),
                                'buss_acc_num'    => $this->input->post('buss_acc_num'),
                                'buss_routing_num'    => $this->input->post('buss_routing_num'),
                                'producer_id'    => $producer_id,
                                'merchant_account_number'    => $braintree_merchant->merchant_account_number,
                            );

                            $result = $this->Common_model->save_braintree_merchant_info_update($data, $record_id);
                            if ($result == true) {
                                redirect(site_url('/'), 'refresh');
                                 $this->session->set_flashdata('success', 'Record Updated');
                                redirect('/');
                            }

                        } else {
                            $m="";
                            foreach (($result->errors->deepAll()) as $error) {
                                $m.=$error->message . "<br/>";
                            }
                            $this->session->set_flashdata('error', $m);
                        }
                    }
                }
                else{
                    $arr_merchant['individual'] = array(
                        'firstName'    => $this->input->post('firstname'),
                        'lastName'    => $this->input->post('lastname'),
                        'email'    => $this->input->post('email'),
                        'dateOfBirth' => $this->input->post('birth_day'),
                        'phone'    => $this->input->post('phone'),
                        'ssn'    => $this->input->post('ssn'),
                        'address' => array(
                            'streetAddress' => $this->input->post('street_address'),
                            'locality' => $this->input->post('city'),
                            'region' => $this->input->post('state'),
                            'postalCode' => $this->input->post('zip'),
                        )
                    );  
                    if($account=='business'){
                        $arr_merchant['business'] = array(
                            'legalName' => $this->input->post('legal_name'),
                            'dbaName' => $this->input->post('dba_name'),
                            'taxId' => $this->input->post('tax_id'),
                            'address' => array(
                                'streetAddress' => $this->input->post('buss_street_address'),
                                'locality' => $this->input->post('buss_street_address'),
                                'region' => $this->input->post('buss_state'),
                                'postalCode' => $this->input->post('buss_zip'),
                            )
                        );
                    }
                    $arr_merchant['funding'] = array(
                        //'descriptor' => $descriptor,
                        'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
                        'email' => $this->input->post('buss_email'),
                        'mobilePhone' => $this->input->post('phone'),
                        'accountNumber' =>  $this->input->post('buss_acc_num'),
                        'routingNumber' => $this->input->post('buss_routing_num')
                    );
                    $arr_merchant['tosAccepted'] = true;
                    $arr_merchant['masterMerchantAccountId'] = "hdx4rw3t6wdyjb8y";
                    $result = Braintree_MerchantAccount::create(
                        $arr_merchant
                    );
                    //echo "<pre>"; print_r($result);exit;
                    //echo $result->merchantAccount->id;exit;
                    if($result->success){
                        $data = array (
                            'first_name'    => $this->input->post('firstname'),
                            'last_name'    => $this->input->post('lastname'),
                            'last_name'    => $this->input->post('lastname'),
                            'birth_day' => $this->input->post('birth_day'),
                            'email'    => $this->input->post('email'),
                            'phone'    => $this->input->post('phone'),
                            'ssn'    => $this->input->post('ssn'),
                            'street_address'    => $this->input->post('street_address'),
                            'city'    => $this->input->post('city'),
                            'state'    => $this->input->post('state'),
                            'zip'    => $this->input->post('zip'),
                            'country'    => $this->input->post('country'),
                            'payout_email'    => $this->input->post('payout_email'),
                            'mobile_phone'    => $this->input->post('mobile'),
                            'account_number'    => $this->input->post('account'),
                            'routing_number'    => $this->input->post('routing'),
                            'legal_name'    => $this->input->post('legal_name'),
                            'dba_name'    => $this->input->post('dba_name'),
                            'tax_id'    => $this->input->post('tax_id'),
                            'buss_street_address'    => $this->input->post('buss_street_address'),
                            'buss_state'    => $this->input->post('buss_state'),
                            'buss_zip'    => $this->input->post('buss_zip'),
                            'buss_country'    => $this->input->post('buss_country'),
                            'buss_email'    => $this->input->post('buss_email'),
                            'buss_mobile'    => $this->input->post('buss_mobile'),
                            'buss_acc_num'    => $this->input->post('buss_acc_num'),
                            'buss_routing_num'    => $this->input->post('buss_routing_num'),
                            'producer_id'    => $producer_id,
                            'merchant_account_number'    => $result->merchantAccount->id,
                        );

                        $result = $this->Common_model->save_braintree_merchant_info_save($data);
                        if ($result == true) {
                            $this->session->set_flashdata('success', 'Information recieved Succesfully');
                                redirect('/');
                        }
                    }else{
                         $m="";
                        foreach (($result->errors->deepAll()) as $error) {
                            $m.=$error->message . "<br/>";
                        }
                        $this->session->set_flashdata('error', $m);
                        redirect('/user/bankingInformation');
                    }
                    
                }
            }
        }
        $this->data['user'] = $this->ion_auth->user()->row();
        $parser['content'] = $this->load->view('user/merchant_preferences',$this->data,true);
        $this->parser->parse('template', $parser);
	}

    public function profile() {
        
        if (!$this->ion_auth->logged_in()) {
            redirect(site_url(''), 'refresh');
        }
        $this->data['page_title'] 	= 'Profile';
        $this->data['page_heading'] 	= 'Profile';

        //print_r($this->session->all_userdata());
        if($this->input->post()) {
            if($this->ion_auth->user()->row()->id==3){
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
                    ),
                    array(
                        'field'   => 'channel_subscription_price',
                        'label'   => 'Channel Subscription Price',
                        'rules'   => 'trim|required'
                    )
                );
            }
            else{
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

            }
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
                $file_name 		= $this->input->post("embed_code");

                if($_FILES['file']['tmp_name']){
                    $file_name 	= 'file_' . time();
                    $source   	= $_FILES['file'];
                    $file_name 	= $this->Common_model->uploadFileToGoogle($source,$file_name);
                }


                $user_id = $this->ion_auth->user()->row()->id;
                // finally change the password
                if($this->ion_auth->user()->row()->id==3){
                    $data = array(
                        "first_name" 				   	=> $this->input->post('first_name'),
                        "last_name" 					=> $this->input->post('last_name'),
                        "phone" 						=> $this->input->post('phone'),
                        "video_type"                    => $this->input->post("video_type"),
                        "video"                         => $file_name,
                        "channel_subscription_price"   	=> $this->input->post('channel_subscription_price')
                    );
                }
                else{
                    $data = array(
                        "first_name" 				    => $this->input->post('first_name'),
                        "last_name" 					=> $this->input->post('last_name'),
                        "phone" 						=> $this->input->post('phone'),
                        "video"                         => $file_name,
                        "video_type"                    => $this->input->post("video_type")
                        /*"video"						=>
                                (strpos($file_name,"&"))?
                                    substr(str_replace("watch?v=","embed/",$file_name),0,strpos($file_name,"&")-2):
                                        str_replace("watch?v=","embed/",$file_name)*/
                    );
                }

                $file_name ="";
                $banner1 ="";
                $banner ="";


                $data['brand_twitter_followers'] = $this->input->post('brand_twitter_followers');
                $data['brand_facebook_likes'] = $this->input->post('brand_facebook_likes');
                $data['brand_instagram_followers'] = $this->input->post('brand_instagram_followers');
                $data['brand_name'] = $this->input->post('brand');
                $data['channel_name'] = $this->input->post('channel');
                $data['sales_pitch'] = $this->input->post('salespitch');
                $data['day_of_contact'] = $this->input->post('day_of_contact');
                $data['day_time_of_contact'] = $this->input->post('day_time_of_contact');
                $data['channel_subscription_price'] = $this->input->post('channel_subscription_price');
                $data['description'] = $this->input->post('description');
                $data['how_were_you_monitizing_content_before'] = $this->input->post('how_were_you_monitizing_content_before');
                $data['routing_number'] = $this->input->post('routing_number');
                $data['account_number'] = $this->input->post('account_number');


                if(isset($_FILES['monitization_background_on_brand']) and $_FILES['monitization_background_on_brand']['name']!=''){

                    $monitization_background_on_brand = "monitization_background_on_brand".time().str_replace(' ','_',$_FILES['monitization_background_on_brand']['name']);
                    $returnValue = $this->Common_model->uploadImageByFieldName('monitization_background_on_brand',$monitization_background_on_brand, 'uploads/profile_pic/');
                    if($returnValue != true) {
                        $this->session->set_flashdata('error', 'Some error picture not upload');
                    }else{
                        $data['monitization_background'] = $returnValue;
                        $name = "uploads/profile_pic/".$returnValue;
                        $destination = "uploads/profile_pic/thumb_200_".$returnValue;
                        $this->Common_model->generateThumb($name,array("200",""),$destination);

                        @unlink("uploads/profile_pic/".$this->input->post('monitization_old_pic'));
                        @unlink("uploads/profile_pic/thumb_200_".$this->input->post('banner_old_pic'));
                    }
                }


                if(isset($_FILES['general_background_on_brand']) and $_FILES['general_background_on_brand']['name']!=''){

                    $general_background_on_brand = "general_background_on_brand".time().str_replace(' ','_',$_FILES['general_background_on_brand']['name']);
                    $returnValue = $this->Common_model->uploadImageByFieldName('general_background_on_brand',$general_background_on_brand, 'uploads/profile_pic/');
                    if($returnValue != true) {
                        $this->session->set_flashdata('error', 'Some error picture not upload');
                    }else{
                        $data['general_background'] = $returnValue;
                        $name = "uploads/profile_pic/".$returnValue;
                        $destination = "uploads/profile_pic/thumb_200_".$returnValue;
                        $this->Common_model->generateThumb($name,array("200",""),$destination);
                        @unlink("uploads/profile_pic/".$this->input->post('general_old_pic'));
                        @unlink("uploads/profile_pic/thumb_200_".$this->input->post('banner_old_pic'));
                    }
                }

                $this->session->set_userdata('uname',$this->input->post('first_name')." ".$this->input->post('last_name'));
                if(isset($_FILES['picture']) and $_FILES['picture']['name']!=''){

                    $file_name = time().str_replace(' ','_',$_FILES['picture']['name']);
                    $this->session->set_userdata('profile_pic',$file_name);
                    $returnValue = $this->Common_model->uploadImageByFieldName('picture',$file_name, 'uploads/profile_pic/');

                    if($returnValue != true) {
                        $this->session->set_flashdata('error', 'Some error picture not upload');
                    }else{
                        $data['picture'] = $returnValue;
                        $this->session->set_userdata('profile_pic',$returnValue);
                        $name = "uploads/profile_pic/".$returnValue;
                        $destination = "uploads/profile_pic/thumb_200_".$returnValue;
                        $this->Common_model->generateThumb($name,array("200",""),$destination);
                        @unlink("uploads/profile_pic/".$this->input->post('old_pic'));
                        @unlink("uploads/profile_pic/thumb_200_".$this->input->post('old_pic'));
                    }
                }


                if(isset($_FILES['banner']) and $_FILES['banner']['name']!=''){

                    $banner = "banner".time().str_replace(' ','_',$_FILES['banner']['name']);
                    $returnValue = $this->Common_model->uploadImageByFieldName('banner',$banner, 'uploads/profile_pic/');
                    if($returnValue != true) {
                        $this->session->set_flashdata('error', 'Some error picture not upload');
                    }else{
                        $data['banner'] = $returnValue;
                        $name = "uploads/profile_pic/".$returnValue;
                        $destination = "uploads/profile_pic/thumb_200_".$returnValue;
                        $this->Common_model->generateThumb($name,array("200",""),$destination);

                        @unlink("uploads/profile_pic/".$this->input->post('banner_old_pic'));
                        @unlink("uploads/profile_pic/thumb_200_".$this->input->post('banner_old_pic'));
                    }
                }


                $change = $this->ion_auth->update($user_id, $data);
                $this->session->set_flashdata('success', 'Updated successfully');
                redirect(site_url('user/profile'), 'refresh');
            }
        }
        $this->data['user'] = $this->ion_auth->user()->row();
        $parser['content'] = $this->load->view('user/profile',$this->data,true);
        $this->parser->parse('template', $parser);
    }

    public function channelmarketplace() {
        $this->data['page_title'] 	= 'Channel Marketplace';
        $this->data['page_heading'] = 'Channel Marketplace';
        //$this->data['user_ids']     = $this->Users_model->getUserIdByGroupId();
        $chanel_users = $this->Users_model->getChanelUsers();
        $this->data['ContentList']  = $chanel_users;
        $this->data['bannerDetail'] = $this->Content_model->getBannerRowByField("page","channel_marketplace");
        //echo "<pre>"; print_r($this->data['ContentList']);exit;
        /*echo '<pre>';
        print_r($this->Content_model->getBannerRowByField("page","channel_marketplace"));
        echo '<pre>';
        die();*/

        $this->data['payment_gateway'] = $this->Preferences_model->getValue('payment');


        if (isset($_POST['flag'])) {
            echo $this->load->view('user/channel_area',$this->data,true);
        }
        else {
            $parser['content']          = $this->load->view('user/channel_area',$this->data,true);
            $this->parser->parse('template', $parser);
        }
    }
    public function channeldescription($id=NULL){
        $this->data['page_title']    = "Channel Description";
        $this->data['page_heading']  = "Channel Description";
        $filter = $this->input->get('filter') ? $this->input->get('filter'):'';
        $this->data['channelDetail'] = $this->Users_model->getUserDetailById($id);
        $this->data['contents']      = $this->Content_model->getContentByUserId($id,$filter);
        $this->data['id'] = $id;
        $this->data['total_rows'] = count($this->data['contents']);
        $this->data['contents'] = array_slice($this->data['contents'], 0, 10);
        if (isset($_POST['flag'])) {
            echo $this->load->view('user/channel_description',$this->data,TRUE);
        }
        else {
            $parser['content']	       =  $this->load->view('user/channel_description',$this->data,TRUE);
            $this->parser->parse('template', $parser);
        }
    }

    public function channeldescription_ajax() {

        $id = $this->input->get('id');

        $config 			   = array();
        $config["base_url"]    = base_url() . "channeldescription";
        $config["total_rows"]  = $this->Users_model->getUserDetailcountById($id);


        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['reuse_query_string']   = true;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $this->data['contents'] = $this->Content_model->getContentByUserIdLimit($id,$page,$config["per_page"]);

        if (count($this->data['contents']) > 0) {
            echo $this->load->view('user/channeldescription_limit',$this->data,TRUE);
        }
    }

    public function filterchanneldescription($id=NULL){
        $this->data['page_title']    = "Channel Description";
        $this->data['page_heading']  = "Channel Description";
        $filter = $this->input->post('filter') ? $this->input->post('filter'):'';
        $this->data['channelDetail'] = $this->Users_model->getUserDetailById($id);

        $this->data['contents']      = $this->Content_model->getContentByUserId($id,$filter);

        echo $parser['content']	       =  $this->load->view('user/filter_channel_description',$this->data,TRUE);
        //$this->parser->parse('template', $parser);
    }

    public function upgradepackage() {
        if (!$this->ion_auth->logged_in()) {
            redirect(site_url(''), 'refresh');
        }
        $this->data['page_title'] 	= 'Upgrade Package';
        $this->data['page_heading'] 	= 'Upgrade Package';
        $this->data['bannerDetail']  = $this->Content_model->getBannerRowByField("page","upgradepackage");
        //$this->init_braintree();

        if($this->input->post()) {
            $user_id = $this->ion_auth->user()->row()->id;

            $credit_card 		= $this->input->post('credit-card-number');
            $cvv 				= $this->input->post('cvv');
            $epiration_month 	= $this->input->post('expiration_month');
            $epiration_year 	= $this->input->post('expiration_year');
            initialize_Braintree();

            $result = Braintree_Transaction::sale(array(
						"amount" => '1.99',
						"creditCard" => array(
							"number" => $credit_card,
							"cvv" 	=> $cvv,
							"expirationMonth" => $epiration_month,
							"expirationYear" => $epiration_year
						),
						"options" => array(
							"submitForSettlement" => true,
							"storeInVaultOnSuccess" => true
						)
					));

            if ($result->success) {

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
                $array_payment_log = array(
                    "user_id" 			 	=> $user_id,
                    "channel_id" 		  	=> 0,
                    "type" 					=> "subscription",
                    "amount"			  	=> 1.99,
                    "date_of_charge" 	  	=> date("Y-m-d"),
                    "merchant_responce"  	=> $merchant_responce,
                    "txn_id"              	=> $txn_id,
                    "status"			  	=> "Complete"
                );
                $this->ion_auth->update($user_id,$data_update);
                $this->Users_model->insertpaymentLogs($array_payment_log);

                $this->session->set_flashdata('success', "Package updated successfully, Now can buy any channel from channel Marketplace.");
                redirect(base_url()."user/upgradepackage");
            }else{
                $this->session->set_flashdata('error', 'An error occured '.$this->is_error_trans);
                redirect(base_url()."user/upgradepackage");
            }

        }
        $this->data['clientToken']= $this->clientToken;
        $this->data['user'] 		= $this->ion_auth->user()->row();

        $parser['content'] 	= $this->load->view('user/upgradepackage',$this->data,true);
        $this->parser->parse('template', $parser);
    }

    public function upgradepackage_ajax () {
        if (!$this->ion_auth->logged_in()) {
            redirect(site_url(''), 'refresh');
        }
        $this->data['page_title'] 	= 'Upgrade Package';
        $this->data['page_heading'] 	= 'Upgrade Package';
        $this->data['bannerDetail']  = $this->Content_model->getBannerRowByField("page","upgradepackage");
        //$this->init_braintree();

        if ($this->input->post()) {


            $user_id = $this->ion_auth->user()->row()->id;
 			
			$credit_card 		= $this->input->post('credit-card-number');
            $cvv 				= $this->input->post('cvv');
            $epiration_month 	= $this->input->post('expiration_month');
            $epiration_year 	= $this->input->post('expiration_year');
            initialize_Braintree();

            $result = Braintree_Transaction::sale(array(
						"amount" => '1.99',
						"creditCard" => array(
							"number" => $credit_card,
							"cvv" 	=> $cvv,
							"expirationMonth" => $epiration_month,
							"expirationYear" => $epiration_year
						),
						"options" => array(
							"submitForSettlement" => true,
							"storeInVaultOnSuccess" => true
						)
					));

            if ($result->success) {

                $txn = $result->transaction;
                if ($txn->paymentInstrumentType == 'credit_card') {
                    $braintree_token = $txn->creditCardDetails->token;
                }else if ($txn->paymentInstrumentType == 'paypal_account') {
                    $braintree_token = $txn->paypalDetails->token;
                }
				
                $next_recharge_date = getNextRechargeDate('month');
                $data_update 		= array(
                    "braintree_payment_token" 	=> '',
                    "next_recharge_date" 		=> $next_recharge_date,
                    "is_premium"				=> "yes"
                );
                $array_payment_log = array(
                    "user_id" 			  => $user_id,
                    "channel_id" 		  => 0,
                    "type" 				  => "subscription",
                    "amount"			  => 1.99,
                    "date_of_charge" 	  => date("Y-m-d"),
                    "merchant_responce"   => $merchant_responce,
                    "txn_id"              => $txn_id,
                    "status"			  => "Complete"
                );

                $this->ion_auth->update($user_id,$data_update);
                $this->Users_model->insertpaymentLogs($array_payment_log);

                $this->session->set_flashdata('success', "Package updated successfully, Now can buy any channel from channel Marketplace.");
                redirect(base_url()."user/upgradepackage");
            }else{
                $this->session->set_flashdata('error', $result->message);
                redirect(base_url()."user/upgradepackage");
            }

        }

        $this->data['clientToken']= $this->clientToken;
        $this->data['user'] = $this->ion_auth->user()->row();

        echo $this->load->view('user/upgradepackage',$this->data,true);

    }


    function channelsubscription($id=NULL) {
        if (!$this->ion_auth->logged_in()) {
            redirect(site_url(''), 'refresh');
        }
        $user_row = $this->ion_auth->user()->row();

        /*if($user_row->is_premium){
         if($user_row->is_premium!='yes'){
          redirect(base_url()."user/upgradepackage");
         }
        }
        else{
         redirect(base_url()."user/upgradepackage");
        }*/

        $this->data['page_title']    = 'Subscrible Channel';
        $this->data['page_heading']  = 'Subscrible Channel';
        //$this->init_braintree();
        $this->data['channelInfo']   = $this->Users_model->getChannelSubscribeInfoByChannelId($id);
        $this->data['bannerDetail']  = $this->Content_model->getBannerRowByField("page","channel_subscription");
        $this->data['alreadyBuy']    = $this->Users_model->checkAlreadyBuy($id);

        $subs_price                  = $this->data['channelInfo']['channel_subscription_price'];
        $this->data['officalInfo']   = $this->Users_model->getChannelSubscribeInfoByChannelId("42");
        $this->data['flag_div']      = false;
		
        if($id!='42'){
            if(isset($user_row->is_premium) && $user_row->is_premium!='yes'){
                $subs_price = $this->data['channelInfo']['channel_subscription_price']+$this->data['officalInfo']['channel_subscription_price'];
                $this->data['flag_div']  = true;
            }
        }
        if($id=="42"){
            if(isset($user_row->is_premium) && $user_row->is_premium!='yes'){
                $subs_price = $this->data['channelInfo']['channel_subscription_price'];
            }
        }
        $this->data['chanelPrice']   = $subs_price;
        $user_id = $this->ion_auth->get_user_id();


        if($this->input->post()) {
            
            $credit_card 		= $this->input->post('credit-card-number');
            $cvv 				= $this->input->post('cvv');
            $epiration_month 	= $this->input->post('expiration_month');
            $epiration_year 	= $this->input->post('expiration_year');
            initialize_Braintree();
			$result 			= "";
			
			if($id==42){
				$result = Braintree_Transaction::sale(array(
						"amount" => $subs_price,
						"creditCard" => array(
							"number" => $credit_card,
							"cvv" 	=> $cvv,
							"expirationMonth" => $epiration_month,
							"expirationYear" => $epiration_year
						),
						"options" => array(
							"submitForSettlement" => true,
							"storeInVaultOnSuccess" => true
						)
					));
			}
			else{
				$merchant_id = $this->Users_model->getProducerMerchantId($id);
				$merchant_id = 'janesladders_instant_3q7cmdy4';
				$irw_percentage = $this->data['channelInfo']['irw_percentage'];
				$irw_share = ($this->data['channelInfo']['channel_subscription_price']*$irw_percentage)/100;
				
				if(isset($user_row->is_premium) && $user_row->is_premium!='yes' ){
					$irw_share = number_format($irw_share + $this->data['officalInfo']['channel_subscription_price'],2);
					$result = Braintree_Transaction::sale(array(
						'merchantAccountId' => $merchant_id,
						"amount" => $subs_price,
						"creditCard" => array(
							"number" => $credit_card,
							"cvv" => $cvv,
							"expirationMonth" => $epiration_month,
							"expirationYear" => $epiration_year
						),
						'serviceFeeAmount' => $irw_share,
						"options" => array(
							"submitForSettlement" => true,
							"storeInVaultOnSuccess" => true
						)
					));
				}else{
					$result = Braintree_Transaction::sale(array(
						'merchantAccountId' => $merchant_id,
						"amount" => number_format($subs_price,2),
						"creditCard" => array(
							"number" => $credit_card,
							"cvv" => '123',
							"expirationMonth" => '12',
							"expirationYear" => '20'
						),
						'serviceFeeAmount' => number_format($irw_share,2),
						"options" => array(
							"submitForSettlement" => true,
							"storeInVaultOnSuccess" => true
						)
					));
				}
			}
            //echo "<pre>"; print_r($result);exit;

            if ($result->success) {

                if( date('d') == 31 || (date('m') == 1 && date('d') > 28)){
                    $date = strtotime('last day of next month');
                } else {
                    $date = strtotime('+1 months');
                }
                $next_recharge_date = date('Y-m-d', $date);
                
				if(isset($user_row->is_premium) && $user_row->is_premium!='yes' ){
                    //$next_recharge_date = getNextRechargeDate('month');

                    $data_update   = array(
                        "next_recharge_date"   	=> $next_recharge_date,
                        "is_premium"    		=> "yes"
                    );

                    $array_payment_log = array(
                        "user_id"     		=> $user_id,
                        "channel_id"     	=> "42",
                        "type"     			=> "channel",
                        "amount"     		=> $this->data['officalInfo']['channel_subscription_price'],
                        "date_of_charge"    => date("Y-m-d"),
                        "merchant_responce" => json_encode($result),
                        "status"     		=> "Complete"
                    );


                    $insert = array(
                        'user_id'             	=> $user_id,
                        'channel_id'          	=> '42',
                        'channel_name'        	=> $this->data['officalInfo']['channel_name'],
                        'amount'              	=> $this->data['officalInfo']['channel_subscription_price'],
                        'type'           		=> "monthly",
                        'next_recharge_date'  	=> $next_recharge_date,
                        'date'        			=> date('Y-m-d'),
                        'status'     			=> 'active'
                    );

                    $this->ion_auth->update($user_id,$data_update);
                    $this->Users_model->insertpaymentLogs($array_payment_log);
                    $this->Users_model->insertChannelSubscriptionDetail($insert);
                }

                if($id!="42"){

                    $array_payment_log = array(
                        "user_id"     		=> $user_id,
                        "channel_id"     	=> $id,
                        "type"     			=> "channel",
                        "amount"     		=> $this->data['channelInfo']['channel_subscription_price'],
                        "date_of_charge"    => date("Y-m-d"),
                        "merchant_responce" => json_encode($result),
                        "status"     		=> "Complete"
                    );

                    $insert = array(
                        'user_id'             => $user_id,
                        'channel_id'          => $id,
                        'channel_name'        => $this->data['channelInfo']['channel_name'],
                        'amount'              => $this->data['channelInfo']['channel_subscription_price'],
                        'type'           	  => "monthly",
                        'next_recharge_date'  => $next_recharge_date,
                        'date'        		  => date('Y-m-d'),
                        'status'     		  => 'active'
                    );

                    $this->Users_model->insertpaymentLogs($array_payment_log);
                    $this->Users_model->insertChannelSubscriptionDetail($insert);
                }

                $this->session->set_flashdata('success', "Channel is subscribed successfully!");
                redirect(base_url()."user/channelsubscription/".$id);

                /// end payment section
            }else{
                $this->session->set_flashdata('error', $result->message);
                redirect(base_url()."user/channelsubscription/".$id);
            }
        }
		
		$this->data['flag_div']      = false;
        if($id!='42'){
            if(isset($user_row->is_premium) && $user_row->is_premium!='yes'){
                $this->data['flag_div']  = true;
            }
        }

        $this->data['clientToken'] = $this->clientToken;
        $this->data['user']   = $this->ion_auth->user()->row();
        $parser['content'] = $this->load->view('user/channel_subscription',$this->data,true);
        $this->parser->parse('template', $parser);
    }


    public function channelsubscription1($id=NULL) {
        if (!$this->ion_auth->logged_in()) {
            redirect(site_url(''), 'refresh');
        }
        $user_row = $this->ion_auth->user()->row();

        if($user_row->is_premium){
            if($user_row->is_premium!='yes'){
                if (isset($_POST['flag'])) {
                    redirect(base_url()."user/upgradepackage_ajax");
                }
                redirect(base_url()."user/upgradepackage");
            }
        }
        else{
            redirect(base_url()."user/upgradepackage");
        }
        $this->data['page_title'] 	= 'Subscrible Channel';
        $this->data['page_heading']  = 'Subscrible Channel';
        //$this->init_braintree();
        $this->data['channelInfo']   = $this->Users_model->getChannelSubscribeInfoByChannelId($id);
        $this->data['bannerDetail']  = $this->Content_model->getBannerRowByField("page","channel_subscription");
        $this->data['alreadyBuy']  = $this->Users_model->checkAlreadyBuy($id);

        if ($this->input->post() && !isset($_POST['flag'])) {
            $user_id = $this->ion_auth->get_user_id();
            // finally change the password

            /*$result = Braintree_Transaction::sale(array(
                    "amount" 				=> $this->data['channelInfo']['channel_subscription_price'],
                    "paymentMethodNonce" 	=> $_REQUEST['payment_method_nonce'],
                    "options" 				=> array(
                    "submitForSettlement" => true,
                    "storeInVaultOnSuccess"=>true
                    )
                ));*/

            $merchant_responce = $this->response_use;
            if ($this->resultCode == 'Ok') {
                $braintree_token = "";
                /*$txn = $result->transaction;
                if ($txn->paymentInstrumentType == 'credit_card') {
                    $braintree_token = $txn->creditCardDetails->token;
                }else if ($txn->paymentInstrumentType == 'paypal_account') {
                    $braintree_token = $txn->paypalDetails->token;
                }*/

                if( date('d') == 31 || (date('m') == 1 && date('d') > 28)){
                    $date = strtotime('last day of next month');
                } else {
                    $date = strtotime('+1 months');
                }

                $next_recharge_date = date('Y-m-d', $date);
                $insert = array(
                    'user_id'            	=> $user_id,
                    'channel_id'         	=> $id,
                    'channel_name'       	=> $this->data['channelInfo']['channel_name'],
                    'amount'             	=> $this->data['channelInfo']['channel_subscription_price'],
                    'type'		       		=> "monthly",
                    'next_recharge_date' 	=> $next_recharge_date,
                    'date'			   		=> date('Y-m-d'),
                    'status'			 	=> 'active'
                );

                $array_payment_log = array(
                    "user_id" 			 => $user_id,
                    "channel_id" 		  => $id,
                    "type" 				=> "channel",
                    "amount"			  => $this->data['channelInfo']['channel_subscription_price'],
                    "date_of_charge" 	  => date("Y-m-d"),
                    "merchant_responce"   => $merchant_responce,
                    "status"			  => "Complete"
                );

                $this->Users_model->insertChannelSubscriptionDetail($insert);
                $this->Users_model->insertpaymentLogs($array_payment_log);
                $this->session->set_flashdata('success', "Channel subscribed to successfully!");
                redirect(base_url()."user/channelsubscription/".$id);
            }else{
                $this->session->set_flashdata('error', $result->message);
                redirect(base_url()."user/channelsubscription/".$id);
            }
        }
        $this->data['clientToken'] = $this->clientToken;
        $this->data['user'] 		= $this->ion_auth->user()->row();

        if (isset($_POST['flag'])) {
            echo $this->load->view('user/channel_subscription',$this->data,true);
        }
        else {
            $parser['content'] = $this->load->view('user/channel_subscription',$this->data,true);
            $this->parser->parse('template', $parser);
        }
    }

    private function init_braintree(){
        $this->clientToken =  init_Braintree();
    }

    function favorite(){

        if (!$this->ion_auth->logged_in()) {
            redirect(site_url('/'), 'refresh');
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

    public function subscribechannel()
    {
        $data['page_title'] 	  	= 'Subscription Channel';
        $data['page_heading'] 		= 'Subscription Channel';
        $arr['name']             	= $this->input->get('name') ? $this->input->get('name') : '';
        $config 			   	  	= array();
        $config["base_url"]      	= base_url() . "user/subscribechannel";
        $config["total_rows"]  		= $this->Users_model->countTotalChannelRowsByUserId($this->ion_auth->user()->row()->id, $arr);
        $config["per_page"]      	= 10;
        $config["uri_segment"]   	= 3;
        $config['reuse_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $page 						= ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['channels']	   		= $this->Users_model->getAllChannelByUserId($this->ion_auth->user()->row()->id, array(),$page,$config["per_page"]);
        $data["links"]         		= $this->pagination->create_links();
        $parser['content']	   		= $this->load->view('user/channel_subscription_listing',$data,TRUE);
        $this->parser->parse('template', $parser);
    }

    public function paymenthistory()
    {

        $data['page_title'] 	  	= 'Payment History';
        $data['page_heading'] 		= 'Payment History';
        $arr['name']             	= $this->input->get('name') ? $this->input->get('name') : '';
        $config 			   	  	= array();
        $config["base_url"]      	= base_url() . "user/paymenthistory";
        $config["total_rows"]  		= $this->Users_model->countTotalPaymentLogsRowsByUserId($this->ion_auth->user()->row()->id, $arr);
        $config["per_page"]     	= 10;
        $config["uri_segment"]   	= 3;
        $config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $page 						= ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['payment_logs']		= $this->Users_model->getAllPaymentHistoryByUserId($this->ion_auth->user()->row()->id, array(),$page,$config["per_page"]);
        $data["links"]           	= $this->pagination->create_links();
        $parser['content']	   		= $this->load->view('user/payment_history_listing',$data,TRUE);
        $this->parser->parse('template', $parser);
    }

    public function unsubscribechannel(){
        if(!empty($this->input->get('id'))){
            $this->Users_model->unsubcribeChannelById($this->input->get('id'),array());
            $this->session->set_flashdata('success', "Channnel Unsubscribe successfully");
            redirect(base_url()."user/subscribechannel");
        }
        else{
            redirect(base_url()."user/subscribechannel");
        }
    }
}
