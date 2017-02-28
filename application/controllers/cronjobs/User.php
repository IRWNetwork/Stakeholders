<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/braintree-php/lib/Braintree.php";
class User extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model("Users_model");
		$this->load->model("Common_model");
		$this->load->model("Emailtemplates_model");
		$this->load->library('ion_auth');

    }

	function renewPackages(){
		Braintree_Configuration::environment("sandbox");
		Braintree_Configuration::merchantId("cnh6d5kt9f839mfh");
		Braintree_Configuration::publicKey("cggnwvrvz44nrmfh");
		Braintree_Configuration::privateKey("c0cc81d6242af896bfef79f19e004538");
		
		$packages = $this->Users_model->getCurrentRenewPakcages();
		foreach($packages as $row){
			
			$amount 		= $row->amount;
			$user_row = $this->ion_auth->user($row->user_id)->row();
			$braintreeToken = $userRow->braintree_payment_token;
			$invoice_id 	= $this->Users_model->getNextUserIDForCurrentLogs();
			
			$result = Braintree_Transaction::sale(array(
				'orderId' => $invoice_id,
				'amount' => $amount,
				'paymentMethodToken' => $braintreeToken
			));
			$merchant_responce = json_encode($result);
			
			if ($result->success) {
				

				if( date('d') == 31 || (date('m') == 1 && date('d') > 28)){
					$date = strtotime('last day of next month');
				} else {
					$date = strtotime('+1 months');
				}
				
				$next_recharge_date = date('Y-m-d', $date);

				$txnId = $result->transaction->id;
				$array_payment_log = array(
						"user_id" 			 => $row->user_id,
						"channel_id" 		  => $row->channel_id,
						"type" 				=> "channel",
						"amount"			  => $row->amount,
						"date_of_charge" 	  => date("Y-m-d"),
						"merchant_responce"   => $merchant_responce,
						"status"			  => "Complete"
					);
				$this->Users_model->insertpaymentLogs($array_payment_log);
				$this->data['channelInfo']   = $this->Users_model->getChannelSubscribeInfoByChannelId($row->channel_id);
				
				$update = array(
								'user_id'             => $row->user_id,
								'channel_id'          => $row->channel_id,
								'channel_name'       	=> $this->data['channelInfo']['channel_name'],
								'amount'              => $row->amount,
								'type'		       	=> "monthly",
								'next_recharge_date'  => $next_recharge_date,
								'date'			   	=> date('Y-m-d'),
								'status'			  => 'active'
					);
				
				$this->Users_model->updateChannelSubscription($update,$row->id);
				
				$arr = 	array(
						"full_name" 	=> $userRow['firstname']." ".$userRow['lastname'],
						"package_type" 	=> ucfirst($row->type),
						"amount" 		=> $amount,
						"charge_date" 	=> date("m/d/Y"),
						"email"     	=> $userRow['email']
					);
				$result = $this->Emailtemplates_model->sendMail('update_channel',$arr);
			}else{
				$array_payment_log = array(
						"user_id" 			 => $row->user_id,
						"channel_id" 		  => $row->channel_id,
						"type" 				=> "channel",
						"amount"			  => $row->amount,
						"date_of_charge" 	  => date("Y-m-d"),
						"merchant_responce"   => $merchant_responce,
						"status"			  => "pending"
					);
				$this->Users_model->insertpaymentLogs($array_payment_log);
				$arr = 	array(
						"full_name" 	=> $userRow->first_name." ".$userRow->last_name,
						"error_message" => $result->message,
						"charge_date" 	=> date("m/d/Y"),
						"email"     	=> $userRow->email
					);
				$result = $this->Emailtemplates_model->sendMail('update_package_error',$arr);
			}
		}
	}
}
