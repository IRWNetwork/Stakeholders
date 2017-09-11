<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model("Users_model");
		$this->load->model("Common_model");
		$this->load->model("Emailtemplates_model");
		$this->load->library('ion_auth');
		$this->load->model('Authorize_model');
    }
	
	function renewPackage($type="prod"){
		//mail("atifrehman34@gmail.com","subject","testing");
		initialize_Stripe();
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
		// Retrieve the request's body and parse it as JSON
		$payload = @file_get_contents("php://input");
		$this->db->insert("data_logs",array("data"=>json_encode($payload)));
		$sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
		$event = null;
		
		if($type=='live'){
			$endpoint_secret = "whsec_mM8PbO967xTvkR90oUazHYuU58802gPO";
		}else{
			$endpoint_secret = "whsec_nuxv9aCToTIYijfPv1mG2binazdFCOrN";//"whsec_p2xIOqQjpFFzTkkQ5S2ySzVlUKd5BONZ";//"whsec_nuxv9aCToTIYijfPv1mG2binazdFCOrN";
		}
		
		try {
			
			$event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
		  	if (isset($event) && $event->type == "invoice.payment_failed") {
				$subscription_id = $event->data->object['lines']['subscriptions'][0]['id'];
				$channel_row = $this->Users_model->getChannelSubscriptionDetailBySubscriptionID($subscription_id);
				
				$this->Users_model->updateSubscriptionDetail(array("status"=>"inactive"),$channel_row->id);
					
			}else if(isset($event) && $event->type == "invoice.payment_succeeded"){
				$subscription_id = $event->data->object['lines']['subscriptions'][0]['id'];
				$channel_row = $this->Users_model->getChannelSubscriptionDetailBySubscriptionID($subscription_id);
				if($channel_row){
					$array_payment_log = array(
						"user_id"     					=> $channel_row->user_id,
						"channel_id"     				=> $channel_row->channel_id,
						"plan_id"     					=> $channel_row->plan_id,
						"type"     						=> "single",
						"date_of_charge"    			=> date("Y-m-d"),
						"merchant_responce" 			=> json_encode($event),
						'producer_royality_percentage'  => $channel_row->producer_royality_percentage,
						'producer_royality_amount'  	=> $channel_row->producer_royality_amount,
						'irw_percentage'    			=> $channel_row->irw_percentage,
						'irw_amount'    				=> $channel_row->irw_amount,
						'amount'						=> $channel_row->amount,
						'subscription_id'				=> $subscription_id
					);
					$this->Users_model->insertpaymentLogs($array_payment_log);
				}
			}
		} catch(\UnexpectedValueException $e) {
		  	// Invalid payload
			print_r($e);
		  	http_response_code(400); // PHP 5.4 or greater
		  	exit();
		} catch(\Stripe\Error\SignatureVerification $e) {
		  	print_r($e);
		  	// Invalid signature
		  	http_response_code(400); // PHP 5.4 or greater
		  	exit();
		}
		http_response_code(200); // PHP 5.4 or greater
	}
}
