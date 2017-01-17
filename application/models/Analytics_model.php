<?php

class Analytics_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'analytics';
    }
	
	
	function saveAnalytics($data){
		$this->db->insert($this->tablename,$data);
		return $this->db->insert_id();
	}
	
	function getTotalByDay($type){
		
		$query = $this->db->query('SELECT COUNT(*) AS count, date FROM '.$this->tablename.' where type = "'.$type.'" GROUP BY date ORDER BY date');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					return $query->result_array();
				}
		return array();
	}
	
	function getTopByDay($type){
		
		$query = $this->db->query('SELECT COUNT(*) AS count, date, episode FROM '.$this->tablename.' where type = "'.$type.'" GROUP BY  episode, date ORDER BY date');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					$data =  $query->result_array();
					
					foreach( $data as $field=> $value){
						$data[$field]['date'] =  str_replace("-",",",$value['date']);
					}
					foreach( $data as $value){
						$dataReturn[$value['episode']]['date'][$value['date']] = $value['count'];	
					}
					return $dataReturn;
				}
		return array();
	}
	
	function getTopCountries($type){
		
		$query = $this->db->query('SELECT COUNT(*) AS count, country FROM '.$this->tablename.' where type = "'.$type.'" GROUP BY  country ORDER BY count');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					return $query->result_array();
				}
		return array();
	}
	function getMaxDateForCountries($type){
		$query = $this->db->query('SELECT max(id) AS end, date FROM '.$this->tablename.' where type = "'.$type.'" limit 1');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					$row = $query->result_array();
					return $row[0];
				}
		return array();
	}
	
	function getMinDateForCountries($type){
		$query = $this->db->query('SELECT min(id) AS start, date FROM '.$this->tablename.' where type = "'.$type.'" limit 1');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					$row = $query->result_array();
					return $row[0];
				}
		return array();
	}
	
	function getTopCities($type){
		
		$query = $this->db->query('SELECT COUNT(*) AS count, city FROM '.$this->tablename.' where type = "'.$type.'" GROUP BY  country ORDER BY count');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					return $query->result_array();
				}
		return array();
	}
	
	
	function getTotalListens($type){
		
		$query = $this->db->query('SELECT COUNT(*) AS total FROM '.$this->tablename.' where type = "'.$type.'" ');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					$row = $query->result_array();
					return $row[0];
				}
		return array();
	}
	
	function getUrlReport($type){
		
		$query = $this->db->query('SELECT COUNT(*) AS total, referral_path FROM '.$this->tablename.' where type = "'.$type.'" GROUP BY  referral_path');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					
					return $query->result_array();
				}
		return array();
	}
	
}
?>