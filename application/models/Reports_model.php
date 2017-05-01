<?php

class Reports_model extends CI_Model
{
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function getRegisterUsersReport( $date=0 ){
		if($date == 0){
			$date = date("Y-m");
		}
		$this->db->select("COUNT(*) AS total, DATE_FORMAT(from_unixtime(created_on),'%Y-%m-%d') AS niceDate");
		$this->db->group_by('niceDate'); 
		$this->db->order_by('created_on', 'Asc'); 
		$this->db->like( "DATE_FORMAT(from_unixtime(created_on),'%Y-%m')",$date);
		$query = $this->db->get('users');
		//echo $this->db->last_query(); die('ffgfg');
		
		if($query->num_rows())
		{
			return $query->result_array();
		}
		return array();
	}

}
?>