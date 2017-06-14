<?php
class Authorize_model extends CI_Model
{
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->gallery_path = realpath(APPPATH . '../uploads');
    }

	public function save_profile($data){
		$this->db->insert('authorize_profile',$data);
		return $this->db->insert_id();
	}

	public function has_profile($user_id){
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('authorize_profile');
		if($query->num_rows() >0){
			$record = $query->result();
			return $record;
		}
		else {
			return false;
		}
	}


	public function delete_payment_profile($payment_profile_id){
		$this->db->where('id', $payment_profile_id);
		$this->db->delete();
	}


	public function save_payment_profile($data){
		$this->db->insert('authorize_payment_profile',$data);
		return $this->db->insert_id();
	}

	public function has_payment_profile($profile_id){
		$this->db->where('profile_id', $profile_id);
		$query = $this->db->get('authorize_payment_profile');

		if($query->num_rows() >0){
			$record = $query->result();
			return $record;
		}
		else {
			return false;
		}
	}




	public function payment_profile_by_id($id){
		$this->db->where('id', $id);
		$query = $this->db->get('authorize_payment_profile');

		if($query->num_rows() >0){
			$record = $query->result();
			return $record;
		}
		else {
			return false;
		}
	}



	public function payment_profile_by_card($card_number){
		$this->db->where('card_number', $card_number);
		$query = $this->db->get('authorize_payment_profile');

		if($query->num_rows() >0){
			$record = $query->result();
			return $record;
		}
		else {
			return false;
		}
	}





	public function is_card_exist($profile_id, $card_number){
		$this->db->where('profile_id', $profile_id);
		$this->db->where('card_number', $card_number);
		$query = $this->db->get('authorize_payment_profile');

		if($query->num_rows() >0){
			//$record = $query->result();
			return true;
		}
		else {
			return false;
		}
	}




	public function save_shipping_address($data){
		$this->db->insert('authorize_shipping_address',$data);
		return $this->db->insert_id();
	}

	public function has_shipping_address($profile_id){
		$this->db->where('profile_id', $profile_id);
		$query = $this->db->get('authorize_shipping_address');

		if($query->num_rows() >0){
			$record = $query->result();
			return $record;
		}
		else {
			return false;
		}
	}


}/// end class