<?php
class ContactBook_model extends CI_Model
{
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	//==== my code ================//
	public function insertContacts($data){
		$this->db->insert('contact_book',$data);
		//echo $this->db->last_query();
		return true;
	}
	
	public function unique_contact($field, $value, $id){
		$this->db->where('user_id',$id);
		$this->db->where($field,$value);
		
		/*if($field == 'email'){
			$this->db->where($field,$value);
		}
		else{
			$this->db->like($field,$value);
		}*/
		
		$this->db->from('contact_book');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function getAllContact($data,$user_id,$start,$limit,$table_name){
		$this->db->select("id,name,email,phone");
		$this->db->limit($limit, $start);
		$this->db->order_by('name','asc');
		$this->db->where("user_id",$user_id);
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( name like '%".$data['search']."%' or phone like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		
		$query = $this->db->get($table_name);
		//echo $this->db->last_query();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return array();
	}
	public function countContact($data,$user_id,$table_name){
		
		$this->db->where("user_id",$user_id);
		
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( name like '%".$data['search']."%' or phone like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		$query  =   $this->db->get($table_name);
		return $query->num_rows();
	}
	//=============end =================//	
	
	public function delete_text($id){
		$this->db->where('id', $id);
		$this->db->delete('message_text');
	}
	
	//====== get contact function start==============//
	public function getContactsByUserId($user_id){
		$this->db->where('user_id',$user_id);
		$query = $this->db->get("contact_book");
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row;
		}
		return array();
	}
	//====== get contact function end==============//

	public function deleteContact($array,$table_name){
		foreach($array as $id){
			$this->db->where('id',$id);
			$this->db->delete($table_name);
		}
		return true;
	}

}
?>