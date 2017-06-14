<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{


	const USE_PRODUCTION_SERVER  = 0;
	const USE_DEVELOPMENT_SERVER = 1;

	const EXCEPTION_CURL = 10;

	private $params  = array();
	private $items   = array();
	private $success = false;
	private $error   = true;

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


	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Content_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		$this->load->model("Common_model");
		$this->gallery_path = realpath(APPPATH . '../uploads');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(3)) {
			redirect(site_url('/'), 'refresh');
		}
    }


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
		print_r($xml);
		$this->resultCode       = (string) $xml->messages->resultCode;
		$this->code             = (string) $xml->messages->message->code;
		$this->text             = (string) $xml->messages->message->text;
		$this->validation       = (string) $xml->validationDirectResponse;
		$this->directResponse   = (string) $xml->directResponse;
		$this->profileId        = (int) $xml->customerProfileId;
		$this->addressId        = (int) $xml->customerAddressId;
		$this->paymentProfileId = (int) $xml->customerPaymentProfileId;
		$this->results          = explode(',', $this->directResponse);
		//print_r($this->results);

	}
	private function parseCuResults()
	{
		$response = str_replace('xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"', '', $this->response_use);
		$xml = new SimpleXMLElement($response);
		print_r($xml);
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


			$this->parseResults();


			if ($this->resultCode === 'Ok')
			{
				$this->success = true;
				$this->error   = false;
			}
			else
			{
				$this->success = false;
				$this->error   = true;
			}
			curl_close($this->ch);
			unset($this->ch);
		}
		else
		{
			curl_error($this->ch);
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
		$this->xml = '<?xml version="1.0" encoding="utf-8"?>
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
	public function saveAuthorize(){

		$url = 'https://test.authorize.net/gateway/transact.dll';
		$this->url_use = 'https://apitest.authorize.net/xml/v1/request.api';

		//$url = 'https://secure.networkmerchants.com/gateway/transact.dll';

		// oc_authorize_profile
		//$chk_profile = $this->db->query("select id from oc_authorize_profile");
		$this->setParameter('email', "asif@innovatorssoft.com");
		$this->setParameter('description', "no description");
		$this->setParameter('merchantCustomerId', uniqid());
		$this->login    = '6RG5b3yk9V';
		$this->transkey = '6VPpb7H5uGz7G92u';
		$this->createCustomerProfile();
		echo $this->profileId;



		//$profile_id     = 1811733206;
die('stop');
		//set parameters for create payment profile
		@$this->setParameter('customerProfileId', $profile_id);
		@$this->setParameter('billToFirstName', html_entity_decode('Yasir', ENT_QUOTES, 'UTF-8'));
		@$this->setParameter('billToLastName',  html_entity_decode('Shabbir', ENT_QUOTES, 'UTF-8'));
		@$this->setParameter('billToAddress',   html_entity_decode('New Civil Line', ENT_QUOTES, 'UTF-8'));
		//$this->setParameter('billToCompany', html_entity_decode($order_info['payment_company'], ENT_QUOTES, 'UTF-8'));
		@$this->setParameter('billToCity',      html_entity_decode('Faisalabad', ENT_QUOTES, 'UTF-8'));
		@$this->setParameter('billToState', html_entity_decode('Punjab', ENT_QUOTES, 'UTF-8'));
		@$this->setParameter('billToZip', html_entity_decode('38000', ENT_QUOTES, 'UTF-8'));
		@$this->setParameter('billToCountry', html_entity_decode('Pakistan', ENT_QUOTES, 'UTF-8'));
		@$this->setParameter('cardNumber', '4111111111111111');
		@$this->setParameter('expirationDate', '12-18');
		//$this->createCustomerPaymentProfile();

		$payment_profile_id = '1806251365';

		@$this->setParameter('cardCode', '4556199497445627');
		@$this->setParameter('customerPaymentProfileId', $payment_profile_id);
		@$this->setParameter('refId', $profile_id);
		@$this->setParameter('amount', 200);
		@$this->setParameter('cardCode', 200);
		@$this->setParameter('customerShippingAddressId', 112);


		/// create shipping address
		@$this->setParameter('shipToFirstName', 'Faisal');
		@$this->setParameter('shipToLastName', 'Shahzad');
		@$this->setParameter('shipToCompany', 'Business');
		@$this->setParameter('shipToAddress', 'New Civil Line');
		@$this->setParameter('shipToCity', 'Faisalabad');
		@$this->setParameter('shipToState', 'Punjab');
		@$this->setParameter('shipToZip', '38000');
		@$this->setParameter('shipToCountry', 'Pakistan');
		@$this->setParameter('shipToPhoneNumber', '09809809');
		@$this->setParameter('shipToFaxNumber', '0510980099');
		//$this->createCustomerShippingAddress();



		///create transaction
		@$this->setParameter('customerShippingAddressId', '1810464126');

		$this->createCustomerProfileTransaction();

	}


}// end class