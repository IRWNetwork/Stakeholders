<?php

class Excel_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'excel_fields';
    }
	
		
	public function save($data){	
		$this->db->insert('excel_fields',$data);
		return $this->db->insert_id();
	}
	
}
?>