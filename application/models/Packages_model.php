<?php
class Packages_model extends CI_Model
{
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function save($data){
		
		$this->db->insert('packages',$data);
		return $this->db->insert_id();
	}
	
	public function getAllPackages(){
		
		if($this->input->get('packageType')){
			$this->db->where('type',$this->input->get('packageType'));
		}
		$this->db->order_by('message_type','asc');
		
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
	
	public function getPriceForPackageByCreditsSelectedAndType($package_type,$type,$number){
		
		$where = " where 1 and type='$package_type' and message_type='$type' and number_of_credit='$number'";
		
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