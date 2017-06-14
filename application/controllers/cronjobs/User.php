<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/braintree-php/lib/Braintree.php";
class User extends MY_Controller
{

	//// authorize.net properties//////
	const USE_PRODUCTION_SERVER  = 0;
	const USE_DEVELOPMENT_SERVER = 1;
	const EXCEPTION_CURL = 10;
	private $params  = array();
	private $items   = array();
	private $success = false;
	private $error   = true;
	private $addressId;
	private $login;
	private $transkey;
	private $xml;
	private $json;
	private $ch;
	private $response_use;
	private $url_use;
	private $resultCode;
	private $code;
	private $text;
	private $profileId;
	private $validation;
	private $paymentProfileId;
	private $results;
	private $xml_rezponse;
	private $customerPaymentProfileId;
	private $error_code;
	private $errorText;
	private $description;

//// authorize.net properties//////




	function __construct()
    {
        parent::__construct();
		$this->load->model("Users_model");
		$this->load->model("Common_model");
		$this->load->model("Emailtemplates_model");
		$this->load->library('ion_auth');
		$this->load->model('Authorize_model');

    }

	public function index(){
		echo 'Hello World';
	}

	function renewPackages(){
		//echo __FUNCTION__;
		//die();

		/*Braintree_Configuration::environment("sandbox");
		Braintree_Configuration::merchantId("cnh6d5kt9f839mfh");
		Braintree_Configuration::publicKey("cggnwvrvz44nrmfh");
		Braintree_Configuration::privateKey("c0cc81d6242af896bfef79f19e004538");*/
		
		$packages = $this->Users_model->getCurrentRenewPakcages();

		/*print_r($packages);

		die();*/
		foreach($packages as $row){

			echo '<pre>';
			$amount 		= $row->amount;
			$userRow = $this->ion_auth->user($row->user_id)->row();

			/*echo '<br>';
			echo $userRow->first_name;
			echo '<br>';

			echo $userRow->last_name;
			echo '<br>';

			print_r($userRow);

			die();*/
			/*$braintreeToken = $userRow->braintree_payment_token;
			$invoice_id 	= $this->Users_model->getNextUserIDForCurrentLogs();
			$result = Braintree_Transaction::sale(array(
				'orderId' => $invoice_id,
				'amount' => $amount,
				'paymentMethodToken' => $braintreeToken
			));
			$merchant_responce = json_encode($result);*/


			$this->url_use = 'https://apitest.authorize.net/xml/v1/request.api';
			$user_id = $this->ion_auth->get_user_id();
			$this->login    = '6RG5b3yk9V';
			$this->transkey = '6VPpb7H5uGz7G92u';
			$has_profile = $this->Authorize_model->has_profile($user_id);
			$this->profileId =  $has_profile[0]->profile_id;
			$this->setParameter('customerProfileId', $this->profileId);
			$has_payment_profile = $this->Authorize_model->has_payment_profile($this->profileId);
			$this->setParameter('customerPaymentProfileId', $has_payment_profile[0]->payment_profile_id);
			$this->getCustomerPaymentProfile();
			$credit_card_number = $this->xml_rezponse->paymentProfile->payment->creditCard->cardNumber;
			$has_shipping_address = $this->Authorize_model->has_shipping_address($has_profile[0]->profile_id);

			@$this->setParameter('customerShippingAddressId', $has_shipping_address[0]->shipping_address_id);
			@$this->setParameter('cardCode', $credit_card_number);
			@$this->setParameter('customerPaymentProfileId', $has_payment_profile[0]->payment_profile_id);
			@$this->setParameter('refId', $this->paymentProfileId);
			//@$this->setParameter('cardCode', $cvv);
			@$this->setParameter('amount', $row->amount);
			///create transaction
			$this->ChargeCustomerProfile();



			$merchant_responce = $this->response_use;

			if ($this->resultCode == "Ok") {
				

				if( date('d') == 31 || (date('m') == 1 && date('d') > 28)){
					$date = strtotime('last day of next month');
				} else {
					$date = strtotime('+1 months');
				}
				
				$next_recharge_date = date('Y-m-d', $date);

				$txnId = $this->results['transId'];
				$array_payment_log = array(
						"user_id" 			 => $row->user_id,
						"channel_id" 		  => $row->channel_id,
						"type" 				=> "channel",
						"amount"			  => $row->amount,
						"date_of_charge" 	  => date("Y-m-d"),
						"merchant_responce"   => $merchant_responce,
					    "txn_id"              => $txnId,
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
						"full_name" 	=> $userRow->first_name." ".$userRow->last_name,
						"package_type" 	=> ucfirst($row->type),
						"amount" 		=> $amount,
						"charge_date" 	=> date("m/d/Y"),
						"email"     	=> $userRow->email
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
						"error_message" => $this->results->message,
						"charge_date" 	=> date("m/d/Y"),
						"email"     	=> $userRow->email
					);
				$result = $this->Emailtemplates_model->sendMail('update_package_error',$arr);
			}
		}
	}



















////// below i s code for authorize.net ////////
	public function __toString()
	{
		if (!$this->params)
		{
			return (string) $this;
		}
		$output  = '<table summary="Authnet Results" id="authnet">' . "\n";
		$output .= '<tr>' . "\n\t\t" . '<th colspan="2"><b>Outgoing Parameters</b></th>' . "\n" . '</tr>' . "\n";
		foreach ($this->params as $key => $value)
		{
			$output .= "\t" . '<tr>' . "\n\t\t" . '<td><b>' . $key . '</b></td>';
			$output .= '<td>' . $value . '</td>' . "\n" . '</tr>' . "\n";
		}

		$output .= '</table>' . "\n";
		if (!empty($this->xml))
		{
			$output .= 'XML: ';
			$output .= htmlentities($this->xml);
		}
		return $output;
	}
	private function parseResults()
	{
		$response = str_replace('xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"', '', $this->response_use);
		$xml = new SimpleXMLElement($response);
		$this->xml_rezponse = $xml;
		$this->resultCode       = (string) $xml->messages->resultCode;
		$this->code             = (string) $xml->messages->message->code;
		$this->text             = (string) $xml->messages->message->text;
		$this->validation       = (string) $xml->validationDirectResponse;
		$this->directResponse   = (string) $xml->directResponse;
		$this->profileId        = (int) $xml->customerProfileId;
		$this->addressId        = (int) $xml->customerAddressId;
		$this->paymentProfileId = (int) $xml->customerPaymentProfileId;
		$this->results          = explode(',', $this->directResponse);
		//$this->error_code       = (string) $xml->error->errorText;
	}
	private function parseCuResults()
	{
		$response = str_replace('xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"', '', $this->response_use);
		$xml = new SimpleXMLElement($response);
		$this->resultCode       = (string) $xml->messages->resultCode;
		$this->code             = (string) $xml->messages->message->code;
		$this->text             = (string) $xml->messages->message->text;
		$responseCode           = $xml->transactionResponse->responseCode;
		$authCode               = $xml->transactionResponse->authCode;
		$avsResultCode               = $xml->transactionResponse->avsResultCode;
		$transId               = $xml->transactionResponse->transId;
		$transHash               = $xml->transactionResponse->transHash;
		$accountNumber               = $xml->transactionResponse->accountNumber;
		$result_arr = array("responseCode"=>$responseCode,
			"authCode"=>$authCode,
			"avsResultCode"=>$avsResultCode,
			"transId"=>$transId,
			"transHash"=>$transHash,
			"accountNumber"=>$accountNumber);
		$this->results = $result_arr;

	}
	private function process($charge_cus=false)
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_URL, $this->url_use);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
		curl_setopt($this->ch, CURLOPT_HEADER, 0);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->xml);
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		$this->response_use = curl_exec($this->ch);
		if($this->response_use)
		{

			if($charge_cus){
				$this->parseCuResults();
			}else{
				$this->parseResults();
			}



			if ($this->resultCode === 'Ok')
			{
				$this->success = true;
				$this->error   = false;
			}
			else
			{
				$this->success = false;
				$this->error   = true;
				$this->error_code;
			}
			curl_close($this->ch);
			unset($this->ch);
		}
		else
		{
			var_dump(curl_getinfo($this->ch));
		}
	}
	public function createCustomerProfile($use_profiles = false, $type = 'credit')
	{
		$this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <createCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>';
		if (!empty($this->params['refId']))
		{
			$this->xml .= '
                          <refId>'. $this->params['refId'] .'</refId>';
		}
		$this->xml .= '
                          <profile>
                              <merchantCustomerId>'. $this->params['merchantCustomerId'].'</merchantCustomerId>
                              <description>'. $this->params['description'].'</description>
                              <email>'. $this->params['email'] .'</email>';

		if ($use_profiles == true)
		{
			$this->xml .= '
                              <paymentProfiles>
                                  <customerType>'. $this->params['customerType'].'</customerType>
                                  <billTo>
                                      <firstName>'. $this->params['billToFirstName'].'</firstName>
                                      <lastName>'. $this->params['billToLastName'].'</lastName>
                                      <company>'. $this->params['billToCompany'] .'</company>
                                      <address>'. $this->params['billToAddress'] .'</address>
                                      <city>'. $this->params['billToCity'] .'</city>
                                      <state>'. $this->params['billToState'] .'</state>
                                      <zip>'. $this->params['billToZip'] .'</zip>
                                      <country>'. $this->params['billToCountry'] .'</country>
                                      <phoneNumber>'. $this->params['billToPhoneNumber'].'</phoneNumber>
                                      <faxNumber>'. $this->params['billToFaxNumber'].'</faxNumber>
                                  </billTo>
                                  <payment>';
			if ($type === 'credit')
			{
				$this->xml .= '
                                      <creditCard>
                                          <cardNumber>'. $this->params['cardNumber'].'</cardNumber>
                                          <expirationDate>'.$this->params['expirationDate'].'</expirationDate>
                                      </creditCard>';
			}
			else if ($type === 'check')
			{
				$this->xml .= '
                                      <bankAccount>
                                          <accountType>'.$this->params['accountType'].'</accountType>
                                          <nameOnAccount>'.$this->params['nameOnAccount'].'</nameOnAccount>
                                          <echeckType>'. $this->params['echeckType'].'</echeckType>
                                          <bankName>'. $this->params['bankName'].'</bankName>
                                          <routingNumber>'.$this->params['routingNumber'].'</routingNumber>
                                          <accountNumber>'.$this->params['accountNumber'].'</accountNumber>
                                      </bankAccount>
                                      <driversLicense>
                                          <dlState>'. $this->params['dlState'].'</dlState>
                                          <dlNumber>'. $this->params['dlNumber'].'</dlNumber>
                                          <dlDateOfBirth>'.$this->params['dlDateOfBirth'].'</dlDateOfBirth>
                                      </driversLicense>';
			}
			$this->xml .= '
                                  </payment>
                              </paymentProfiles>
                              <shipToList>
                                  <firstName>'. $this->params['shipToFirstName'].'</firstName>
                                  <lastName>'. $this->params['shipToLastName'].'</lastName>
                                  <company>'. $this->params['shipToCompany'] .'</company>
                                  <address>'. $this->params['shipToAddress'] .'</address>
                                  <city>'. $this->params['shipToCity'] .'</city>
                                  <state>'. $this->params['shipToState'] .'</state>
                                  <zip>'. $this->params['shipToZip'] .'</zip>
                                  <country>'. $this->params['shipToCountry'] .'</country>
                                  <phoneNumber>'. $this->params['shipToPhoneNumber'].'</phoneNumber>
                                  <faxNumber>'. $this->params['shipToFaxNumber'].'</faxNumber>
                              </shipToList>';
		}
		$this->xml .= '
                          </profile>
                      </createCustomerProfileRequest>';
		$this->process();
	}
	public function getProfileID()
	{
		return $this->profileId;
	}
	public function setParameter($field = '', $value = null)
	{
		$field = (is_string($field)) ? trim($field) : $field;
		$value = (is_string($value)) ? trim($value) : $value;
		if (!is_string($field))
		{
			trigger_error(__METHOD__ . '() arg 1 must be a string: ' . gettype($field) . ' given.', E_USER_ERROR);
		}
		if (empty($field))
		{
			trigger_error(__METHOD__ . '() requires a parameter field to be named.', E_USER_ERROR);
		}
		if (!is_string($value) && !is_numeric($value) && !is_bool($value))
		{
			trigger_error(__METHOD__ . '() arg 2 (' . $field . ') must be a string, integer, or boolean value: ' . gettype($value) . ' given.', E_USER_ERROR);
		}
		if ($value === '' || is_null($value))
		{
			trigger_error(__METHOD__ . '() parameter "value" is empty or missing (parameter: ' . $field . ').', E_USER_NOTICE);
		}
		$this->params[$field] = $value;
	}
	public function createCustomerPaymentProfile($type = 'credit')
	{
		$this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <createCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <customerProfileId>'.$this->params['customerProfileId'].'</customerProfileId>
                          <paymentProfile>
                              <billTo>
                                  <firstName>'. @$this->params['billToFirstName'].'</firstName>
                                  <lastName>'. @$this->params['billToLastName'].'</lastName>
                                  <address>'. @$this->params['billToAddress'] .'</address>
                                  <city>'. @$this->params['billToCity'] .'</city>
                                  <state>'. @$this->params['billToState'] .'</state>
                                  <zip>'. @$this->params['billToZip'] .'</zip>
                                  <country>'. @$this->params['billToCountry'] .'</country>
                                  <phoneNumber>'. @$this->params['billToPhoneNumber'].'</phoneNumber>
                                  <faxNumber>'. @$this->params['billToFaxNumber'].'</faxNumber>
                              </billTo>
                              <payment>';
		if ($type === 'credit')
		{
			$this->xml .= '
                                  <creditCard>
                                      <cardNumber>'. $this->params['cardNumber'].'</cardNumber>
                                      <expirationDate>'.$this->params['expirationDate'].'</expirationDate>
                                  </creditCard>';
		}
		else if ($type === 'check')
		{
			$this->xml .= '
                                  <bankAccount>
                                      <accountType>'. $this->params['accountType'].'</accountType>
                                      <nameOnAccount>'.$this->params['nameOnAccount'].'</nameOnAccount>
                                      <echeckType>'. $this->params['echeckType'].'</echeckType>
                                      <bankName>'. $this->params['bankName'].'</bankName>
                                      <routingNumber>'.$this->params['routingNumber'].'</routingNumber>
                                      <accountNumber>'.$this->params['accountNumber'].'</accountNumber>
                                  </bankAccount>
                                  <driversLicense>
                                      <dlState>'. $this->params['dlState'] .'</dlState>
                                      <dlNumber>'. $this->params['dlNumber'].'</dlNumber>
                                      <dlDateOfBirth>'.$this->params['dlDateOfBirth'].'</dlDateOfBirth>
                                  </driversLicense>';
		}
		$this->xml .= '
                              </payment>
                          </paymentProfile>

                      </createCustomerPaymentProfileRequest>';
		$this->process();
	}
	public function getPaymentProfileId()
	{
		return $this->paymentProfileId;
	}
	public function createCustomerShippingAddress()
	{
		echo $this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <createCustomerShippingAddressRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. @$this->params['refId'] .'</refId>
                          <customerProfileId>'. $this->params['customerProfileId'].'</customerProfileId>
                          <address>
                              <firstName>'. $this->params['shipToFirstName'].'</firstName>
                              <lastName>'. $this->params['shipToLastName'].'</lastName>
                              <company>'. @$this->params['shipToCompany'] .'</company>
                              <address>'. $this->params['shipToAddress'] .'</address>
                              <city>'. $this->params['shipToCity'] .'</city>
                              <state>'. $this->params['shipToState'] .'</state>
                              <zip>'. $this->params['shipToZip'] .'</zip>
                              <country>'. $this->params['shipToCountry'] .'</country>
                              <phoneNumber>'. @$this->params['shipToPhoneNumber'].'</phoneNumber>
                              <faxNumber>'. @$this->params['shipToFaxNumber'].'</faxNumber>
                          </address>
                      </createCustomerShippingAddressRequest>';
		$this->process();
	}
	public function ChargeCustomerProfile(){
		$this->xml = '<createTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
       <merchantAuthentication>
        <name>' . $this->login . '</name>
        <transactionKey>' . $this->transkey . '</transactionKey>
      </merchantAuthentication>

  <transactionRequest>
    <transactionType>authCaptureTransaction</transactionType>
    <amount>'.$this->params['amount'].'</amount>
    <profile>
      <customerProfileId>'.$this->params['customerProfileId'].'</customerProfileId>
      <paymentProfile>
        <paymentProfileId>'.$this->params['customerPaymentProfileId'].'</paymentProfileId>
      </paymentProfile>
    </profile>
    <shipTo>
      <firstName>China</firstName>
      <lastName>Bayles</lastName>
      <company>Thyme for Tea</company>
      <address>12 Main Street</address>
      <city>Pecan Springs</city>
      <state>TX</state>
      <zip>44628</zip>
      <country>USA</country>
    </shipTo>
  </transactionRequest>
</createTransactionRequest>';
		$this->process(true);
	}
	public function getCustomerAddressId()
	{
		return $this->addressId;
	}

	private function getLineItems()
	{
		$tempXml = '';
		foreach ($this->items as $item)
		{
			foreach ($item as $key => $value)
			{
				$tempXml .= "\t" . '<' . $key . '>' . $value . '</' . $key . '>' . "\n";
			}
		}
		return $tempXml;
	}

	public function createCustomerProfileTransaction($type = 'profileTransAuthCapture')
	{
		$types = array('profileTransAuthCapture', 'profileTransCaptureOnly','profileTransAuthOnly');
		if (!in_array($type, $types))
		{
			trigger_error('createCustomerProfileTransaction() parameter must be"profileTransAuthCapture", "profileTransCaptureOnly", "profileTransAuthOnly", or empty', E_USER_ERROR);
		}

		$this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <createCustomerProfileTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <refId>'. @$this->params['refId'] .'</refId>
                          <transaction>
                              <' . $type . '>
                                  <amount>'. $this->params['amount'] .'</amount>';
		if (isset($this->params['taxAmount']))
		{
			$this->xml .= '
                                  <tax>
                                       <amount>'. $this->params['taxAmount'].'</amount>
                                       <name>'. $this->params['taxName'] .'</name>
                                       <description>'.$this->params['taxDescription'].'</description>
                                  </tax>';
		}
		if (isset($this->params['shipAmount']))
		{
			$this->xml .= '
                                  <shipping>
                                       <amount>'. $this->params['shipAmount'].'</amount>
                                       <name>'. $this->params['shipName'] .'</name>
                                       <description>'.$this->params['shipDescription'].'</description>
                                  </shipping>';
		}
		if (isset($this->params['dutyAmount']))
		{
			$this->xml .= '
                                  <duty>
                                       <amount>'. $this->params['dutyAmount'].'</amount>
                                       <name>'. $this->params['dutyName'] .'</name>
                                       <description>'.$this->params['dutyDescription'].'</description>
                                  </duty>';
		}
		$this->xml .= '

                                  <customerProfileId>'.$this->params['customerProfileId'].'</customerProfileId>
                                  <customerPaymentProfileId>'.$this->params['customerPaymentProfileId'].'</customerPaymentProfileId>
                                  <customerShippingAddressId>'.$this->params['customerShippingAddressId'].'</customerShippingAddressId>';
		if (isset($this->params['orderInvoiceNumber']))
		{
			$this->xml .= '
                                  <order>
                                       <invoiceNumber>'.$this->params['invoiceNumber'].'</orderInvoiceNumber>
                                       <description>'.$this->params['description'].'</orderDescription>
                                       <purchaseOrderNumber>'.$this->params['purchaseOrderNumber'].'</orderPurchaseOrderNumber>
                                  </order>';
		}
		$this->xml .= '
                                  <cardCode>'. $this->params['cardCode'].'</cardCode>';
		if (isset($this->params['orderInvoiceNumber']))
		{
			$this->xml .= '
                                  <approvalCode>'. $this->params['approvalCode'].'</approvalCode>';
		}
		$this->xml .= '
                              </' . $type . '>
                          </transaction>
                      </createCustomerProfileTransactionRequest>';
		$this->process();
	}
	public function getResponseSummary()
	{
		return 'Response code: ' . $this->getCode() . ' Message: ' . $this->getResponse();
	}
	public function getResponse()
	{
		return strip_tags($this->text);
	}

	public function getCode()
	{
		return $this->code;
	}
	public function getAuthCode()
	{
		return $this->results[4];
	}
	public function setLineItem($itemId, $name, $description, $quantity, $unitprice,$taxable = 'false')
	{
		$this->items[] = array('itemId' => $itemId, 'name' => $name, 'description' => $description, 'quantity' => $quantity, 'unitPrice' => $unitprice, 'taxable' => $taxable);
	}
	public function getCustomerProfile()
	{
		$this->xml = '<?xml version="1.0" encoding="utf-8"?>
                      <getCustomerProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                          <merchantAuthentication>
                              <name>' . $this->login . '</name>
                              <transactionKey>' . $this->transkey . '</transactionKey>
                          </merchantAuthentication>
                          <customerProfileId>'. $this->params['customerProfileId'].'</customerProfileId>

                      </getCustomerProfileRequest>';
		$this->process();
	}


	public function getCustomerPaymentProfile()
	{
		$this->xml = '<?xml version="1.0" encoding="utf-8"?>
						<getCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
						  <merchantAuthentication>
							<name>' . $this->login . '</name>
							<transactionKey>' . $this->transkey . '</transactionKey>
						  </merchantAuthentication>
						  <customerProfileId>'. $this->params['customerProfileId'].'</customerProfileId>
						  <customerPaymentProfileId>'.$this->params['customerPaymentProfileId'].'</customerPaymentProfileId>
						</getCustomerPaymentProfileRequest>';
		$this->process();
	}


	public function charge_customer(){

		$url = 'https://test.authorize.net/gateway/transact.dll';
		$this->url_use = 'https://apitest.authorize.net/xml/v1/request.api';

		//$url = 'https://secure.networkmerchants.com/gateway/transact.dll';

		// oc_authorize_profile
		//$chk_profile = $this->db->query("select id from oc_authorize_profile");


		if($this->input->post('choose_card') == 'previous'){
			$this->url_use = 'https://apitest.authorize.net/xml/v1/request.api';
			$user_id = $this->ion_auth->get_user_id();
			$this->login    = '6RG5b3yk9V';
			$this->transkey = '6VPpb7H5uGz7G92u';
			$has_profile = $this->Authorize_model->has_profile($user_id);
			$this->profileId =  $has_profile[0]->profile_id;
			$this->setParameter('customerProfileId', $this->profileId);
			$has_payment_profile = $this->Authorize_model->has_payment_profile($this->profileId);
			$this->setParameter('customerPaymentProfileId', $has_payment_profile[0]->payment_profile_id);
			$this->getCustomerPaymentProfile();
			$credit_card_number = $this->xml_rezponse->paymentProfile->payment->creditCard->cardNumber;
			$has_shipping_address = $this->Authorize_model->has_shipping_address($has_profile[0]->profile_id);

			@$this->setParameter('customerShippingAddressId', $has_shipping_address[0]->shipping_address_id);
			@$this->setParameter('cardCode', $credit_card_number);
			@$this->setParameter('customerPaymentProfileId', $has_payment_profile[0]->payment_profile_id);
			@$this->setParameter('refId', $this->paymentProfileId);
			//@$this->setParameter('cardCode', $cvv);
			@$this->setParameter('amount',$this->input->post('chargable_amount'));
			///create transaction
			$this->ChargeCustomerProfile();
		}else{
			$credit_card_number = $this->input->post('credit-card-number');
			$expiration = $this->input->post('expiration');
			$cvv = $this->input->post('cvv');
			$user_id = $this->session->userdata('user_id');
			$email = $this->session->userdata('identity');
			$user_info = $this->Users_model->get_user_detail_by_email($email);
			$has_profile = $this->Authorize_model->has_profile($user_id);
			$this->login    = '6RG5b3yk9V';
			$this->transkey = '6VPpb7H5uGz7G92u';
			if(!$has_profile){// check if profile already exists
				$this->setParameter('email', $email);
				$this->setParameter('description', "no desp");
				$this->setParameter('merchantCustomerId', uniqid());
				$this->createCustomerProfile();
				$this->Authorize_model->save_profile(array("user_id"=>$user_id, "profile_id"=>$this->profileId));
			}else{
				$this->profileId =  $has_profile[0]->profile_id;
				$this->setParameter('customerProfileId', $this->profileId);
			}

			$has_payment_profile = $this->Authorize_model->has_payment_profile($this->profileId);

			if(!$has_payment_profile){/// check if payment profile is created
				//set parameters for create payment profile
				@$this->setParameter('customerProfileId', $this->profileId);
				@$this->setParameter('billToFirstName', html_entity_decode($user_info->first_name, ENT_QUOTES, 'UTF-8'));
				@$this->setParameter('billToLastName',  html_entity_decode($user_info->last_name, ENT_QUOTES, 'UTF-8'));
				@$this->setParameter('billToAddress',   html_entity_decode($user_info->address, ENT_QUOTES, 'UTF-8'));
				//$this->setParameter('billToCompany', html_entity_decode($order_info['payment_company'], ENT_QUOTES, 'UTF-8'));
				@$this->setParameter('billToCity',      html_entity_decode($user_info->city, ENT_QUOTES, 'UTF-8'));
				@$this->setParameter('billToState', '');
				@$this->setParameter('billToZip', '');
				@$this->setParameter('billToCountry', '');
				@$this->setParameter('cardNumber', $credit_card_number);
				@$this->setParameter('expirationDate', $expiration);
				$this->createCustomerPaymentProfile();
				$this->Authorize_model->save_payment_profile(array("payment_profile_id"=>$this->paymentProfileId, "profile_id"=>$this->profileId));
			}else{
				$this->paymentProfileId =  $has_payment_profile[0]->payment_profile_id;
			}

			$has_shipping_address = $this->Authorize_model->has_shipping_address($this->profileId);

			if(!$has_shipping_address){// check if shipping address is creted
				/// create shipping address
				@$this->setParameter('shipToFirstName', 'F name');
				@$this->setParameter('shipToLastName', 'L Name');
				@$this->setParameter('shipToCompany', '');
				@$this->setParameter('shipToAddress', '');
				@$this->setParameter('shipToCity', '');
				@$this->setParameter('shipToState', '');
				@$this->setParameter('shipToZip', '');
				@$this->setParameter('shipToCountry', '');
				@$this->setParameter('shipToPhoneNumber', '');
				@$this->setParameter('shipToFaxNumber', '');
				$this->createCustomerShippingAddress();
				$this->Authorize_model->save_shipping_address(array("user_id"=>$user_id , "shipping_address_id"=>$this->getCustomerAddressId(), "profile_id"=>$this->params['customerProfileId']));
			}else{
				@$this->setParameter('customerShippingAddressId',$has_shipping_address[0]->shipping_address_id);
			}
			@$this->setParameter('customerShippingAddressId', $has_shipping_address[0]->shipping_address_id);
			@$this->setParameter('cardCode', $credit_card_number);
			@$this->setParameter('customerPaymentProfileId', $this->paymentProfileId);
			@$this->setParameter('refId', $this->paymentProfileId);
			@$this->setParameter('cardCode', $cvv);
			@$this->setParameter('amount', $this->input->post('chargable_amount'));
			///create transaction
			$this->createCustomerProfileTransaction();
		}
	}
////// code for authorize.net end ////////








}// end class
