<?php

class Advertiser_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'advertisers';
    }


    public function getAll() {
		$this->db->select('*');
		$query = $this->db->get('advertisers');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
    }

    public function addAdvertiser($data) {
    	$this->db->insert('advertisers',$data);
		return $this->db->insert_id();

    }

    public function getRow($id){
		$sSQL   =  $this->db->where("id",$id);
		$query  =  $this->db->get('advertisers');
		$this->db->last_query();	
		if ($query->num_rows()) {
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}

	public function updateAdvertiser($id, $data) {
		$this->db->where('id',$id);
 		return $this->db->update('advertisers', $data);
	}

	public function deleteAdvertiser($id) {
		$this->db->where('id', $id);
		$this->db->delete('advertisers');
	}
}
?>    