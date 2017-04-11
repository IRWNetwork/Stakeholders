<?php

class Preferences_model extends CI_Model
{


  	function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	
	function update($key,$value){
		$arr = array(
					'value' => $value
				);
		$this->db->where('name',$key);
 		return $this->db->update('preferences', $arr); 
	}
	function getValue($key){
 		$query  =   $this->db->query("SELECT * FROM preferences where name='".$key."'");
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0]['value'];
		}
		return '';
	}
}


?>
