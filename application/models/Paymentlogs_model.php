<?php
class Paymentlogs_model extends CI_Model
{
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function save($data){
		
		$this->db->insert('user_payment_logs',$data);
		return $this->db->insert_id();
	}
	
	public function getAllPaymentsLogs(){
		
		$this->db->order_by('user_payment_logs','asc');
		
		$this->db->select('user_payment_logs.*');
		$query = $this->db->get('user_payment_logs');
		
		if($query->num_rows() >0){
			$record = $query->result();
			return $record;
		}
		else {
			return false;
		}	
	}
	
	public function responceErrros($error_code){
		$repsonse_errors = array(
								"2000"=>"Do Not Honor.", "2001"=>"Insufficient Funds. At the time of the transaction, the account did not have sufficient funds to cover the transaction amount.",
							 	"2002"=>"Limit Exceeded","2003"=>"Cardholder's Activity Limit Exceeded","2004"=>"Expired Card","2005"=>"Invalid Credit Card Number","2006"=>"Invalid Expiration Date","2007"=>"No Account","2008"=>"Card Account Length Error","2009"=>"No Such Issuer",
								"2010"=>"VCard Issuer Declined CVV.","2011"=>"Voice Authorization Required.","2012"=>"Processor Declined - Possible Lost Card","2013"=>"Processor Declined - Possible Stolen Card","2014"=>"rocessor Declined - Fraud Suspected",
								"2015"=>"Transaction Not Allowed.","2016"=>"Duplicate Transaction.","2017"=>"Cardholder Stopped Billing","2018"=>"Cardholder Stopped All Billing",
								"2019"=>"Invalid Transaction","2020"=>"Violation","2021"=>"Security Violation","2022"=>"Declined - Updated Cardholder Available",
								"2023"=>"Processor Does Not Support This Feature","2024"=>"Card Type Not Enabled","2025"=>"Set Up Error - Merchant","2026"=>"Invalid Merchant ID",
								"2027"=>"Set Up Error - Amount","2028"=>"Set Up Error - Hierarchy","2029"=>"Set Up Error - Card","2030"=>"Set Up Error - Terminal","2031"=>"Encryption Error",
								"2032"=>"Surcharge Not Permitted","2033"=>"Inconsistent Data","2034"=>"No Action Taken","2035"=>"Partial Approval For Amount","2036"=>"Authorization could not be found to reverse",
							 	"2037"=>"Already Reversed", "2038"=>"customer's bank is unwilling to accept the transaction. ","2039"=>"Invalid Authorization Code","2040"=>"Invalid Store",
								"2041"=>"Declined - Call For Approval","2042"=>"Invalid Client ID","2043"=>"Error - Do Not Retry, Call Issuer","2044"=>"Declined - Call Issuer","2045"=>"Invalid Merchant Number",
							 	"2046"=>"customer's bank is unwilling to accept the transaction.","2047"=>"card has been reported as lost or stolen by the cardholder.",
								"2048"=>"Invalid Amount","2049"=>"Invalid SKU Number","2050"=>"Invalid Credit Plan","2051"=>"Credit Card Number does not match method of payment",
								"2052"=>"Invalid Level Purchase","2052"=>"Invalid Level Purchase","2053"=>"Card reported as lost or stolen","2054"=>"Reversal amount does not match authorization amount",
								"2055"=>"Invalid Transaction Division Number","2056"=>"Transaction amount exceeds the transaction division limit","2057"=>"Issuer or Cardholder has put a restriction on the card",
								"2058"=>"Merchant not MasterCard SecureCode enabled.","2059"=>"Address Verification Failed. ","2060"=>"Address Verification and Card Security Code Failed",
								"2061"=>"Invalid Transaction Data","2062"=>"Invalid Tax Amount","2063"=>"PayPal Business Account preference resulted in the transaction failing. ","2064"=>"Invalid Currency Code",
								"2065"=>"Refund Time Limit Exceeded.","2066"=>"PayPal Business Account Restricted.","2067"=>"Authorization Expired.","2068"=>"PayPal Business Account Locked or Closed.",
								"2069"=>"PayPal Blocking Duplicate Order IDs","2070"=>"PayPal Buyer Revoked Future Payment Authorization","2071"=>"PayPal Payee Account Invalid Or Does Not Have a Confirmed Email",
								"2072"=>"PayPal Payee Email Incorrectly Formatted","2073"=>"PayPal Validation Error. ","2074"=>"Funding Instrument In The PayPal Account Was Declined By The Processor Or Bank, Or It Can't Be Used For This Payment.",
								"2075"=>"Payer Account Is Locked Or Closed","2076"=>"Payer Cannot Pay For This Transaction With PayPal. ","2077"=>"Transaction Refused Due To PayPal Risk Model",
								"2078"=>"Invalid Secure Payment Data","2079"=>"PayPal Merchant Account Configuration Error. ","2080"=>"Invalid user credentials","2081"=>"PayPal pending payments are not supported"
							);
		return $repsonse_errors[$error_code];
	}
	
	public function getAllPackagesByTypeForUserSide($package_type,$type){
		$this->db->where('type',$package_type);
		$this->db->where('message_type',$type);
		$this->db->where('visible','yes');
		$this->db->select('packages.*');
		$query = $this->db->get('packages');
		
		if($query->num_rows() >0){
			$record = $query->result();
			return $record;
		}
		else {
			return false;
		}	
	}
	
	public function getPriceForPackageByCreditsSelected($package_type,$text,$document,$video,$audio){
		
		$where = " where 1 and type='$package_type' and(";
		
		$where.= " (message_type='text' and number_of_credit='$text')";
		$where.= " or (message_type='documents' and number_of_credit='$document')";
		$where.= " or (message_type='video' and number_of_credit='$video')";
		$where.= " or (message_type='audio' and number_of_credit='$audio'))";
		
		$query = "select sum(amount) as amount from packages ".$where ;
		$query = $this->db->query($query);
		$row   = $query->result();
		return $row[0]->amount;
	}
	
	public function getPackageById($package_id){
		$this->db->select('packages.*');
		$this->db->where('id', $package_id);
		$query = $this->db->get('packages');
		
		if($query->num_rows() >0){
			$record = $query->result();
			return $record[0];
		}
		else {
			return false;
		}
	}
	
	public function update($data,$id){
		$this->db->where('id',$id);
		$this->db->update('packages',$data);
		return true;
	}
}
?>