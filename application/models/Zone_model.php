<?php

class Zone_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'zones';
    }

    public function getAll() {
		$this->db->select('*');
		$query = $this->db->get('zones');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
    }

    public function addZone($data) {
    	echo "<pre>"; print_r($data);exit;
    }

}

?>