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
		//echo "<pre>"; print_r($_POST);exit;
		$data['page_title'] 	 = 'Users';
		$data['page_heading']   = 'Users';
		$arr['name']            = $this->input->get('name') ? $this->input->get('name') : '';
		$arr['type']            = $this->input->get('type') ? $this->input->get('type') : '';

		$query_string = $this->input->get('type') ? '?type='.$this->input->get('type') : '';
		
		if ($this->input->get('type') && $this->input->get('name')) {
			$query_string .= '&name'.$this->input->get('name');
		} else {
			if (!$this->input->get('type') && $this->input->get('name')) {
				$query_string .='?name'.$this->input->get('name');
			} else {
				$query_string .= '';
			}
			
		}


		$config 			   	 = array();
        $config["base_url"]     = base_url()."admin/channel".$query_string;
        $config["total_rows"]   = $this->Users_model->countTotalRows($arr);
        $config["per_page"]     = 10;
        $config["uri_segment"]  = 3;

        $this->pagination->initialize($config);

        $page 		         = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
		$data['channels']	 = $this->Users_model->getAllUsers(array(),$page,$config["per_page"], $arr);
		$data['type'] = $arr['type'];
		$data['search_name'] = $arr['name'];
		$data["links"]        = $this->pagination->create_links();
        $parser['content']	= $this->load->view('admin/channels/listing',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function viewDetails() {
		$data['page_title'] 	 = 'User Details';
		$data['page_heading']   = 'User Details';

		$userId = $this->input->get('id');
		$data['user'] = $this->Users_model->getUserDetails($userId);

		$producerMerchantInfo = array();
		if ($data['user']['group_id'] == 3) {
			$producerMerchantInfo = $this->Users_model->brainTreeByChannelId($userId);
		}

		$data['producerMerchantInfo'] = $producerMerchantInfo;

		$parser['content']	= $this->load->view('admin/channels/viewUserDetails',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
		
	}
	public function user_filter() {
		
		$data['page_title'] 	 = 'Users';
		$data['page_heading']   = 'Users';
		$arr['name']            = $this->input->post('name') ? $this->input->post('name') : '';
		$arr['type']            = $this->input->post('type') ? $this->input->post('type') : '';

		
		$config 			   	 = array();
        $config["base_url"]     = base_url()."admin/channel?type=".$arr['type']."&name=".$arr['name'];
        $config["total_rows"]   = $this->Users_model->countTotalRows($arr);
        $config["per_page"]     = 10;
        $config["uri_segment"]  = 3;

        $this->pagination->initialize($config);

        $page 		         = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['channels']	 = $this->Users_model->getAllUsers(array(),$page,$config["per_page"], $arr);
		$data['type'] = $arr['type'];
		$data['search_name'] = $arr['name'];
		$data["links"]        = $this->pagination->create_links();
		//echo "<pre>"; print_r($data['channels']);exit;

        echo $this->load->view('admin/channels/channels_listing_filter',$data,TRUE);
	}	

	public function convert_images() {
		$results = $this->Common_model->convert_images();
		//$this->load->library('image_lib');
		
	}

	public function applications() {
		$data['page_title'] 	 = 'Producers';
		$data['page_heading']   = 'Producers';

		$arr['type'] = 3;

		$config 			   	 = array();
        $config["base_url"]     = base_url()."admin/channel/applications";
        $config["total_rows"]   = $this->Users_model->getCountNonApprovedProducers($arr);
        $config["per_page"]     = 10;
        $config["uri_segment"]  = 3;
		$config['reuse_query_string'] = TRUE;

        $this->pagination->initialize($config);

        $page 		         = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['producers']	 = $this->Users_model->getAllNonApprovedProducers(array(),$page,$config["per_page"], $arr);
		$data["links"]        = $this->pagination->create_links();
        $parser['content']	= $this->load->view('admin/channels/applications',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	public function view_channel($id) {
		$data['page_title'] 	 = 'Producer';
		$data['page_heading']   = 'Producer';
		$data['usersRow'] 	= $this->Users_model->getRow($id);
		//echo "<pre>";print_r($data['usersRow']);die();
		$parser['content']	= $this->load->view('admin/channels/view_channel',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	public function makeProducerApproved() {

		$producerId = $this->input->post('userId');
		$this->db->where('id', $producerId);
		$this->db->update('users', array('is_approved'=>1));
		if ($this->db->affected_rows()) {
			echo 'true';
		}

	}

	public function addAdminComment() {
		$producerId = $this->input->post('userId');
		$comment = $this->input->post('comment');

		$this->db->where('id', $producerId);
		$this->db->update('users', array('admin_comment'=> $comment));
		
		if ($this->db->affected_rows()) {
			echo 'true';
		}
		else {
			return 'false';
		}
	}
	
	public function addchannel()
	{
		//echo "<pre>";print_r($this->input->post());exit;
		//die('afd');
		$data['page_title'] 	= 'Add Channel';
		$data['page_heading'] 	= 'Add Channel';
		
		if($this->input->post()) {
			if($this->input->post('type')=='3'){
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
						 'label'   => 'Brand Name',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'channel',
						 'label'   => 'Channel Name',
						 'rules'   => 'trim|required'
					)
					,
					array(
						 'field'   => 'channel_price',
						 'label'   => 'Channel Price in $',
						 'rules'   => 'trim|required'
					)
					,
					array(
						 'field'   => 'description',
						 'label'   => 'Channel Description',
						 'rules'   => 'trim|required'
					),/////new fields
					array(
						 'field'   => 'day_of_contact',
						 'label'   => 'Day Of Contact',
						 'rules'   => 'trim|required'
					),array(
						 'field'   => 'day_time_of_contact',
						 'label'   => 'Time Of Contact',
						 'rules'   => 'trim|required'
					),array(
						 'field'   => 'brand_twitter_followers',
						 'label'   => 'Brand Twitter Followers',
						 'rules'   => 'trim|required'
					),array(
						 'field'   => 'brand_facebook_likes',
						 'label'   => 'Brand Facebook Likes',
						 'rules'   => 'trim|required'
					),array(
						 'field'   => 'brand_instagram_followers',
						 'label'   => 'Brand Instagram Followers',
						 'rules'   => 'trim|required'
					),array(
						 'field'   => 'salespitch',
						 'label'   => 'Sales Pitch',
						 'rules'   => 'trim|required'
					),array(
						 'field'   => 'how_were_you_monitizing_content_before',
						 'label'   => 'How Were You Monitizing Content Before',
						 'rules'   => 'trim|required'
					),array(
						 'field'   => 'channel',
						 'label'   => 'Channel Name',
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
				if($this->input->post('type')=='3'){

					$additional_data = array(
						'first_name'   => $this->input->post('first_name'),
						'last_name' 	=>  $this->input->post('last_name'),
						'brand_name'   =>  $this->input->post('brand'),
						'channel_name' =>  $this->input->post('channel'),
						'description' =>  $this->input->post('description'),
						'producer_royalty' =>  $this->input->post('producer_royalty'),
						'irw_percentage' =>  $this->input->post('irw_percentage'),
						'channel_subscription_price' =>  floatval($this->input->post('channel_price'))
					);

					$additional_data['is_approved'] = 1;
					$additional_data['phone'] = $this->input->post('phone');
					$additional_data['brand_twitter_followers'] = $this->input->post('brand_twitter_followers');
					$additional_data['brand_facebook_likes'] = $this->input->post('brand_facebook_likes');
					$additional_data['brand_instagram_followers'] = $this->input->post('brand_instagram_followers');
					$additional_data['brand_name'] = $this->input->post('brand');
					$additional_data['channel_name'] = $this->input->post('channel');
					$additional_data['sales_pitch'] = $this->input->post('salespitch');
					$additional_data['day_of_contact'] = $this->input->post('day_of_contact');
					$additional_data['day_time_of_contact'] = $this->input->post('day_time_of_contact');
					$additional_data['description'] = $this->input->post('description');
					$additional_data['how_were_you_monitizing_content_before'] = $this->input->post('how_were_you_monitizing_content_before');
					$additional_data['routing_number'] = $this->input->post('routing_number');
					$additional_data['account_number'] = $this->input->post('account_number');

					//// Monetization Backgrounds ////
					if(isset($_FILES['monitization_background_on_brand']) and $_FILES['monitization_background_on_brand']['name']!=''){

						$file_name = time().$_FILES['monitization_background_on_brand']['name'];
						$additional_data['monitization_background'] = $file_name;
						$returnValue = $this->Common_model->uploadImageByFieldName('monitization_background_on_brand',$file_name, 'uploads/profile_pic/');
						if($returnValue != true) {
							$this->session->set_flashdata('error', 'Some error picture not upload');
						}else{
							$name = "uploads/profile_pic/".$file_name;
							$destination = "uploads/profile_pic/thumb_200_".$file_name;
							$this->Common_model->generateThumb($name,array("200",""),$destination);
						}
					}


					//// General Backgrounds ////
					if(isset($_FILES['general_background_on_brand']) and $_FILES['general_background_on_brand']['name']!=''){

						$file_name = time().$_FILES['general_background_on_brand']['name'];
						$additional_data['general_background'] = $file_name;
						$returnValue = $this->Common_model->uploadImageByFieldName('general_background_on_brand',$file_name, 'uploads/profile_pic/');
						if($returnValue != true) {
							$this->session->set_flashdata('error', 'Some error picture not upload');
						}else{
							$name = "uploads/profile_pic/".$file_name;
							$destination = "uploads/profile_pic/thumb_200_".$file_name;
							$this->Common_model->generateThumb($name,array("200",""),$destination);
						}
					}
				}
				else{
					$additional_data = array(
						'first_name'   => $this->input->post('first_name'),
						'last_name' 	=>  $this->input->post('last_name')
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

				if (!$this->ion_auth->email_check($this->input->post('email'))) {
					$password 	= $this->input->post('password');
					$email 	    = $this->input->post('email');
					$username 	= $this->input->post('email');
					$group_name = array($this->input->post('type'));
					$this->ion_auth->register($username, $password, $email, $additional_data, $group_name);

					//$this->Phpbb->user_add($identity,$identity,$password);


					$this->session->set_flashdata(
						'success',
						'Register Successfully'
					);
					redirect("admin/channel");
				}
				else{
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
			
        $parser['content']	= $this->load->view('admin/channels/add_channel',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	public function editcontent()
	{	
		//echo "<pre>"; print_r($_POST);exit;
		$data['page_title']    = 'Edit User';
		$data['page_heading']  = 'Edit User';
		
		if($this->input->post()) {
			if($this->input->post('type')=='3'){
				$rules = array(
					
					array(
						 'field'   => 'email',
						 'label'   => 'Email',
						 'rules'   => 'trim|required|valid_email'
					),

					array(
						 'field'   => 'type',
						 'label'   => 'Type',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'brand',
						 'label'   => 'Brand Name',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'channel',
						 'label'   => 'Channel Name',
						 'rules'   => 'trim|required'
					)
					,
					array(
						 'field'   => 'channel_price',
						 'label'   => 'Channel Price in $',
						 'rules'   => 'trim|required'
					)
					,
					array(
						 'field'   => 'description',
						 'label'   => 'Channel Description',
						 'rules'   => 'trim|required'
					),
					array(
						 'field'   => 'sorting',
						 'label'   => 'Sort Order',
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
				$userData = array(
								'first_name' => $this->input->post('first_name'),
								'last_name' => $this->input->post('last_name'),
								'email' => $this->input->post('email'),
								'username' => $this->input->post('email'),
							);	
				if($this->input->post('type')=='3'){
					$userData = array(
						'brand_name'   		=>  $this->input->post('brand'),
						'channel_name' 		=>  $this->input->post('channel'),
						'description'  		=>  $this->input->post('description'),
						'producer_royalty' 	=>  $this->input->post('producer_royalty'),
						'irw_percentage' 	=>  $this->input->post('irw_percentage'),
						"sorting"      		=>  (int)$this->input->post('sorting'),
						"is_deleted"   		=>  (int)$this->input->post('is_deleted'),
						"content_block"   	=>  (int)$this->input->post('content_block'),
						'channel_subscription_price' =>  floatval($this->input->post('channel_price'))
					);
				}
				
				if ($this->input->post('password') && $this->input->post('password') != '') {
					$userData['password'] =	$this->ion_auth_model->hash_password($this->input->post('password'));
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
				if (!$this->Users_model->email_check($this->input->post('email'),$this->input->get('id'))){
					if($this->input->post('password')){
						$this->ion_auth->reset_password($this->input->post('email'),$this->input->post('password'));
					}
					//$group_name = array($this->input->post('type')-1);
					if($this->input->post('type')=='3'){
						if($this->Users_model->checkStripPlanForProducerWithAmount($this->input->post('channel_subscription_price'),$this->input->get('id'))){
							$this->updatePackageOFProducer($this->input->post('channel_price'),$this->input->get('id'));
						}
					}
					
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
			}else{
				$this->session->set_flashdata(
					'error',
					'Please enter all details'
				);
			}
		}

		$data['usersRow'] 	= $this->Users_model->getRow($this->input->get('id'));
		//echo "<pre>";print_r($data['usersRow']);die();
        $parser['content']		= $this->load->view('admin/channels/edit_channel',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
	function updatePackageOFProducer($amount,$user_id){
		initialize_Stripe();
		$data['user_row'] = $this->Users_model->getRow($user_id);
		$user_id = $data['user_row']->id;
		$package_id = "";
		$merchant_id = $data['user_row']->stripe_user_id;
		$package_id = "monthly-".$amount."-".$user_id;
		if($this->Users_model->checkStripPlanForProducerWithAmount($amount,$user_id)){
			try {
				\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
				$plan = \Stripe\Plan::create(array(
							"name" 		=> $data['user_row']->channel_name,
							"id" 		=> $package_id,
							"interval" 	=> "month",
							"currency" 	=> "usd",
							"amount" 	=> $amount*100,
						), array("stripe_account" =>  $merchant_id));
				$plan_array['user_id'] = $user_id;
				$plan_array['stripe_plan_id'] = $package_id;
				$plan_array['type'] = 'single';
				$plan_array['amount'] = $amount;
				$plan_array['status'] = 'active';
				
				$change = $this->Users_model->addStripePackage($plan_array,$user_id);
				$users = $this->Users_model->getAllSubscribeUsersByChannelID($user_id);
				
				foreach($users as $row){
					try {
						\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
						$subscription = \Stripe\Subscription::retrieve($row->subscription_id, array("stripe_account" =>  $merchant_id));
						$itemID = $subscription->items->data[0]->id;
						$result = \Stripe\Subscription::update($row->subscription_id, array(
							"items" => array(
								array(
									"id" 	=> $itemID,
									"plan" 	=> $package_id,
								),
							),
							"prorate" => false,
						), array("stripe_account" =>  $merchant_id));
						$irw_amount 			  = number_format(($amount * $row->irw_percentage)/100,2);
						$producer_royality_amount = number_format(($amount * $row->producer_royality_percentage)/100,2);
						$update_user_package = array("plan_id"=>$package_id,"producer_royality_amount"=>$producer_royality_amount,"irw_amount"=>$irw_amount);
						$this->Users_model->updatePackageOfUser($update_user_package,$row->id);
					}catch (Exception $e) {
						$array = $e->getJsonBody();
						$this->session->set_flashdata('error', $array['error']['message']);
					}
				}
				$this->session->set_flashdata('success', 'Plan Created Successfully');
			}catch (Exception $e) {
				$array = $e->getJsonBody();
				$this->session->set_flashdata('error', $array['error']['message']);
			}
		}else{
			$users = $this->Users_model->getAllSubscribeUsersByChannelID($user_id);
			foreach($users as $row){
				try {
					\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
					$subscription = \Stripe\Subscription::retrieve($row->subscription_id, array("stripe_account" =>  $merchant_id));
					$itemID = $subscription->items->data[0]->id;
					$result = \Stripe\Subscription::update($row->subscription_id, array(
						"items" => array(
							array(
								"id" 	=> $itemID,
								"plan" 	=> $package_id,
							),
						),
						"prorate" => false,
					), array("stripe_account" =>  $merchant_id));
					$irw_amount 			  = number_format(($amount * $row->irw_percentage)/100,2);
					$producer_royality_amount = number_format(($amount * $row->producer_royality_percentage)/100,2);
					$update_user_package = array("plan_id"=>$package_id,"producer_royality_amount"=>$producer_royality_amount,"irw_amount"=>$irw_amount);
					$this->Users_model->updatePackageOfUser($update_user_package,$row->id);
				}catch (Exception $e) {
					$array = $e->getJsonBody();
					$this->session->set_flashdata('error', $array['error']['message']);
				}
			}
			$this->session->set_flashdata('success', 'User Subscription updated');
		}
	}

	public function deletecontent($id) {

		$result = $this->Users_model->hard_delete($id);
		if ($result) {
			$this->session->set_flashdata(
				'Success',
				'Record Deleted'
			);

			redirect("admin/channel");
		}
	}

	public function report() {
		$data['page_title'] 	= 'Report';
		$data['page_heading']  = 'Report';

		$arr['name'] = $this->input->post('name') ? $this->input->post('name') : '';
		$arr['date_to'] = $this->input->post('date_to') ? $this->input->post('date_to') : '';
		$arr['date_from'] = $this->input->post('date_from') ? $this->input->post('date_from') : '';

		if ($arr['name'] != '') {
			$producers = $this->Users_model->getAllChannels($arr);
			foreach ($producers as $key => $producer) {

				$sql = $this->db->query("SELECT * from payment_logs where payment_logs.channel_id = ".$producer->id);
				$all_records_of_channel = $sql->result();


				if (count($all_records_of_channel) > 0) {
					$report_array[$key]['channel_name'] = $producer->channel_name;
					$report_array[$key]['total_users_who_paid'] = count($all_records_of_channel);
					$sum = 0;
					foreach ($all_records_of_channel as $item) {
					    $sum += $item->amount;
					}
					$report_array[$key]['total_amount'] = $sum;
					$report_array[$key]['irw_amount'] = ($sum*20)/100;
					$report_array[$key]['producer_royalty'] = ($sum*80)/100;
					$report_array[$key]['date_of_charge'] = $item->date_of_charge;
				}
				$data['search_name'] = $arr['name'];
				$data['date_from'] = $arr['date_from'];
				$data['date_to'] = $arr['date_to'];
			}
		}
		elseif ($arr['date_from'] != '' && $arr['date_to'] != '') {
			$query = $this->db->query("SELECT users.*  from users JOIN users_groups on users.id = users_groups.user_id WHERE users_groups.group_id = 3");
			$producers = $query->result();
			//echo "<pre>"; print_r($producers);exit;
			$report_array = array();
			foreach ($producers as $key => $producer) {

				$sql = $this->db->query("SELECT * from payment_logs where `channel_id` = ".$producer->id." AND `date_of_charge` >= '".$arr['date_from']."' AND `date_of_charge` <= '".$arr['date_to']."'");
				$all_records_of_channel = $sql->result();
				//echo $this->db->last_query()."<br>";
				//echo "<pre>"; print_r($all_records_of_channel);
				if (count($all_records_of_channel) > 0) {
					$report_array[$key]['channel_name'] = $producer->channel_name;
					$report_array[$key]['total_users_who_paid'] = count($all_records_of_channel);
					$sum = 0;
					foreach ($all_records_of_channel as $item) {
					    $sum += $item->amount;
					}
					$report_array[$key]['total_amount'] = $sum;
					$report_array[$key]['irw_amount'] = ($sum*20)/100;
					$report_array[$key]['producer_royalty'] = ($sum*80)/100;
					$report_array[$key]['date_of_charge'] = $item->date_of_charge;
				}
				$data['search_name'] = '';
				$data['date_from'] = $arr['date_from'];
				$data['date_to'] = $arr['date_to'];
			}
		}
		else {
			$query = $this->db->query("SELECT users.*  from users JOIN users_groups on users.id = users_groups.user_id WHERE users_groups.group_id = 3");
			$producers = $query->result();
			$report_array = array();
			foreach ($producers as $key => $producer) {

				$sql = $this->db->query("SELECT * from payment_logs where payment_logs.channel_id = ".$producer->id);
				$all_records_of_channel = $sql->result();


				if (count($all_records_of_channel) > 0) {
					$report_array[$key]['channel_id'] = $producer->id;
					$report_array[$key]['channel_name'] = $producer->channel_name;
					$report_array[$key]['total_users_who_paid'] = count($all_records_of_channel);
					$sum = 0;
					foreach ($all_records_of_channel as $item) {
					    $sum += $item->amount;
					}
					$report_array[$key]['total_amount'] = $sum;
					$report_array[$key]['irw_amount'] = ($sum*20)/100;
					$report_array[$key]['producer_royalty'] = ($sum*80)/100;
					$report_array[$key]['date_of_charge'] = $item->date_of_charge;
				}
				$data['search_name'] = '';
				$data['date_from'] = $arr['date_from'];
				$data['date_to'] = $arr['date_to'];
			}

		}

		$sum_all = array('total_amount_sum','irw_amount_sum','producer_royalty_sum');
		//echo "<pre>"; print_r($sum_all);exit;
		foreach ($report_array as $report_item) {
		    $sum_all[0] += $report_item['total_amount'];
		    $sum_all[1] += $report_item['producer_royalty'];
		    $sum_all[2] += $report_item['irw_amount'];
		}
		$data['report_array'] = $report_array;
		$data['sum_of_all'] = $sum_all;
		$parser['content']	= $this->load->view('admin/channels/report',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}

	public function producer_detail_report($id) {

		$data['page_title'] 	= 'Report';
		$data['page_heading']  = 'Report';

		$producer_id = $id;

		$query = $this->db->query("SELECT * FROM payment_logs WHERE channel_id=".$producer_id);
		$channel_details = $query->result();
		
		$channel_details_array = array();

		foreach ($channel_details as $key => $channel_detail) {

			$query = $this->db->query("SELECT * FROM users WHERE id=".$channel_details[$key]->user_id);
			$single_channel = $query->row();
			$channel_details_array[$key]['username'] = $single_channel->username;
			$channel_details_array[$key]['email'] = $single_channel->email;
			$channel_details_array[$key]['amount'] = $channel_detail->amount;
			$channel_details_array[$key]['date_of_charge'] = $channel_detail->date_of_charge;
		}

		$sum_all = 0;

        foreach ($channel_details_array as $report_item) {
            $sum_all+= $report_item['amount'];
        }
        $data['sum_of_amount'] = $sum_all;
        
		$data['channel_details_array'] = $channel_details_array;
		$parser['content']	= $this->load->view('admin/channels/single_report',$data,TRUE);
        $this->parser->parse('admin/template', $parser);
	}
	
}