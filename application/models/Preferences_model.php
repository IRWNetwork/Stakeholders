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
	function getValuePopup($key){
 		$query  =   $this->db->query("SELECT * FROM popups where status=1");
		if ($query->num_rows()) {
			$row = $query->result_array();
			//echo "<pre>"; print_r($row);exit;
			return $row[0]['value'];
		}
		return '';
	}

	function getValuePopupAllPages($page){
		$query = $this->db->query("SELECT * FROM popups where page='".$page."' AND status=1");
		if ($query->num_rows()) {
			$row = $query->result_array();
			//echo "<pre>"; print_r($row);exit;
			return $row[0]['value'];
		}
		return '';
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

	function popup_check($key) {
		$query  =   $this->db->query("SELECT * FROM preferences where name='".$key."'");
		if ($query->num_rows()) {
			$row = $query->result_array();
			return $row[0]['value'];
		}
		return '';
	}


	function showPopup($value) {
		$data = array(
           'value' => $value,
        );

		$this->db->where('name', 'show_popup');
		$this->db->update('preferences', $data);
		return true;
	}

	function addPopup($data) {
		$this->db->insert('popups', $data);
		return true;
	}


	function get_all_popups() {
		$this->db->from('popups');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows())
		{
			return $query->result();
		}
	}

	function get_all_popups_by_page($page) {
		$this->db->from('popups');
		$this->db->where('page', $page);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows())
		{
			return $query->result();
		}
	}

	function getPopupById($id) {
		$this->db->from('popups');
		$this->db->where('id', $id);
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows())
		{
			return $query->row();
		}
	}

	function editPopup($id, $data) {
		$this->db->where('id',$id);
 		return $this->db->update('popups', $data); 
	}

	function selectPopup($id, $page) {
		$data = array(
           'status' => 1,
        );
		$this->db->query("UPDATE popups SET `status`='0' WHERE page = '".$page."'");
		//echo $this->db->last_query();exit;
		$this->db->where('id', $id);
		$this->db->update('popups', $data);
		return true;

	}
}

