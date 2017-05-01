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
	
	function getTotalByDay($user_id=0, $content_id = 0){
		if($user_id==0){
			$user_id = $this->ion_auth->user()->row()->id;
		}
		if($content_id != 0){
			if($this->ion_auth->get_users_groups()->row()->id == 1){
				$where = "where  type_id= '".$content_id."'";
			}
			else{
				$where = "where author_id = '".$user_id."' AND type_id= '".$content_id."'";
			}
		}
		else{
			$where = "where author_id = '".$user_id."'";
		}
		$query = $this->db->query('SELECT COUNT(*) AS count, date FROM '.$this->tablename.' '.$where.'  GROUP BY date ORDER BY date');

		 //echo $this->db->last_query();		
		// die();
		 if($query->num_rows())
				{
					return $query->result_array();
				}
		return array();
	}
	
	
	function getTopByDay($user_id=0, $content_id = 0){
		if($user_id==0){
			$user_id = $this->ion_auth->user()->row()->id;
		}
		if($content_id != 0){
			if($this->ion_auth->get_users_groups()->row()->id == 1){
				$where = "where  type_id= '".$content_id."'";
			}
			else{
				$where = "where author_id = '".$user_id."' AND type_id= '".$content_id."'";
			}
		}
		else{
			$where = "where author_id = '".$user_id."'";
		}
		
		$query = $this->db->query('SELECT COUNT(*) AS count, date, episode FROM '.$this->tablename.' '.$where.' GROUP BY  episode, date ORDER BY date');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					$data =  $query->result_array();
					
					foreach( $data as $field=> $value){
						
						$value['date'] = date('Y-m-d',strtotime($value['date'].' -1 months '));
						$data[$field]['date'] =  str_replace("-",",",$value['date']);
					}
					foreach( $data as $value){
						$dataReturn[$value['episode']]['date'][$value['date']] = $value['count'];	
					}
					return $dataReturn;
				}
		return array();
	}
	
	function getTopCountries($user_id=0, $content_id = 0){
		
		if($user_id==0){
			$user_id = $this->ion_auth->user()->row()->id;
		}
		if($content_id != 0){
			if($this->ion_auth->get_users_groups()->row()->id == 1){
				$where = "where  type_id= '".$content_id."'";
			}
			else{
				$where = "where author_id = '".$user_id."' AND type_id= '".$content_id."'";
			}
		}
		else{
			$where = "where author_id = '".$user_id."'";
		}
		
		$query = $this->db->query('SELECT COUNT(*) AS count, country FROM '.$this->tablename.' '.$where.' GROUP BY  country ORDER BY count');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					return $query->result_array();
				}
		return array();
	}
	function getMaxDateForCountries($user_id=0, $content_id = 0){
		if($user_id==0){
			$user_id = $this->ion_auth->user()->row()->id;
		}
		if($content_id != 0){
			if($this->ion_auth->get_users_groups()->row()->id == 1){
				$where = "where  type_id= '".$content_id."'";
			}
			else{
				$where = "where author_id = '".$user_id."' AND type_id= '".$content_id."'";
			}
		}
		else{
			$where = "where author_id = '".$user_id."'";
		}
		
		$query = $this->db->query('SELECT max(id) AS end, date FROM '.$this->tablename.' where author_id = '.$this->ion_auth->user()->row()->id.' limit 1');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					$row = $query->result_array();
					return $row[0];
				}
		return array();
	}
	
	function getMinDateForCountries($user_id=0, $content_id = 0){
		if($user_id==0){
			$user_id = $this->ion_auth->user()->row()->id;
		}
		if($content_id != 0){
			if($this->ion_auth->get_users_groups()->row()->id == 1){
				$where = "where  type_id= '".$content_id."'";
			}
			else{
				$where = "where author_id = '".$user_id."' AND type_id= '".$content_id."'";
			}
		}
		else{
			$where = "where author_id = '".$user_id."'";
		}
		
		$query = $this->db->query('SELECT min(id) AS start, date FROM '.$this->tablename.' '.$where.' limit 1');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					$row = $query->result_array();
					return $row[0];
				}
		return array();
	}
	
	
	
	function getTopCities($user_id=0, $content_id = 0){
		if($user_id==0){
			$user_id = $this->ion_auth->user()->row()->id;
		}
		if($content_id != 0){
			if($this->ion_auth->get_users_groups()->row()->id == 1){
				$where = "where  type_id= '".$content_id."'";
			}
			else{
				$where = "where author_id = '".$user_id."' AND type_id= '".$content_id."'";
			}
		}
		else{
			$where = "where author_id = '".$user_id."'";
		}
		$query = $this->db->query('SELECT COUNT(*) AS count, city FROM '.$this->tablename.' '.$where.' GROUP BY  country ORDER BY count');

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					return $query->result_array();
				}
		return array();
	}
	
	
	function getTotalListens($user_id=0, $content_id = 0){
		if($user_id==0){
			$user_id = $this->ion_auth->user()->row()->id;
		}
		if($content_id != 0){
			if($this->ion_auth->get_users_groups()->row()->id == 1){
				$where = "where  type_id= '".$content_id."'";
			}
			else{
				$where = "where author_id = '".$user_id."' AND type_id= '".$content_id."'";
			}
		}
		else{
			$where = "where author_id = '".$user_id."'";
		}
		$query = $this->db->query('SELECT COUNT(*) AS total FROM '.$this->tablename.' '.$where );

		 //echo $this->db->last_query();		
		 //die();
		 if($query->num_rows())
				{
					$row = $query->result_array();
					return $row[0];
				}
		return array();
	}
	
	function getUrlReport($user_id=0, $content_id = 0){
		if($user_id==0){
			$user_id = $this->ion_auth->user()->row()->id;
		}
		
		if($content_id != 0){
			if($this->ion_auth->get_users_groups()->row()->id == 1){
				$where = "where  type_id= '".$content_id."'";
			}
			else{
				$where = "where author_id = '".$user_id."' AND type_id= '".$content_id."'";
			}
		}
		else{
			$where = "where author_id = '".$user_id."'";
		}
		$query = $this->db->query('SELECT COUNT(*) AS total, referral_path FROM '.$this->tablename.' '.$where.' GROUP BY  referral_path');

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