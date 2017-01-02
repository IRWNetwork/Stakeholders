<?php

class Faq_model extends CI_Model
{

  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function save($data)
	{
		$this->db->insert('faq',$data);
		return $this->db->insert_id();
	}
	
	public function getAll(){
		
		$query = $this->db->get('faq');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getRow($id){
		$sSQL   =   $this->db->where("id",$id);
		$query  =   $this->db->get('faq');
		$this->db->last_query();	
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}
	
	public function update($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('faq',$data);
		return true;
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('faq');
	}

	
}
?>
