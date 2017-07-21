<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	class Emailtemplates_model extends CI_Model {
		var $_tableName = "email_templates";
		var $_options = "";
		function __construct() {
			parent::__construct();
		}
		/* save row... */
		function saveRow($data) {
			$this->db->insert($this->_tableName, $data);

			return $this->db->insert_id();
		}
		function saveNotificationEmail($data) {
			$this->db->where('id', '1');
			return $this->db->update('notifications_email', $data);
		}
		function saveRowCustom($data,$tableName) {
			$this->db->insert($tableName, $data);
			return $this->db->insert_id();
		}
		
		/* update row... */
		function updateRow($data, $id) {
			$this->db->where('id', $id);
			return $this->db->update($this->_tableName, $data);
		}
		
		/* delete row... */
		function deleteRow($id) {
			$this->db->where('id', $id);
			$this->db->delete($this->_tableName);
			return 1;
		}
		
		/* get all rows count... */
		function getAllRowsCount() {
			$this->db->select('id');
			$query = $this->db->get($this->_tableName);
			
			return $query->num_rows();
		}
		
		/* get all rows... */
		function getAllRows($limit = NULL, $offset = NULL) {
			$this->db->select('*');
			$this->db->from($this->_tableName);
			if ($limit) {
				$this->db->limit($limit, $offset);
			}
			$query = $this->db->get();
			$data = $query->result();
			
			return $data;
		}
		
		/* get single row... */
		function getSingleRow($id) {
			$this->db->where('id', $id);
			$query = $this->db->get($this->_tableName);
			$data = $query->row();
			
			return $data;
		}
		
		/* get single row with all details... */
		function getSingleRowDetails($id) {
			$this->db->where('id', $id);
			$query = $this->db->get($this->_tableName);
			$data = $query->result_array();
			return $data[0];
		}
		
		function getSingleRowDetailsByName($name){
			$this->db->where('name', $name);
			$query = $this->db->get($this->_tableName);
			$data = $query->row();
			
			return $data;
		}
		
		/* get all active rows... */
		function getAllActiveRows($limit=NULL, $orderBy='ordering') {
			$this->db->where("published", 1);
			$this->db->order_by($orderBy, 'ASC');
			$this->db->limit($limit, 0);
			$query = $this->db->get($this->_tableName);
			$data = $query->result();
			
			return $data;
		}

		function getNotificationEmail() {
			$this->db->limit(1);
			$this->db->where('id', '1');
			$query = $this->db->get('notifications_email');
			return $query->row();
		}

		
		function sendMail($template_name,$arr){
			
			$row         = $this->getSingleRowDetailsByName($template_name);
			$from_name   = $row->from_name;
			$from_email  = $row->from_email;
			$subject     = $row->subject;

			foreach($arr as $key=>$val){
				if(preg_match("/\[(".$key.")]/",$from_name,$m)){
				//if(!strpos($subject,'['.$key.']')===false){
					$from_name=str_replace('['.$key.']',$val,$from_name);
				}
			}
			foreach($arr as $key=>$val){
				if(preg_match("/\[(".$key.")]/",$from_email,$m)){
				//if(!strpos($subject,'['.$key.']')===false){
					$from_email=str_replace('['.$key.']',$val,$from_email);
				}
			}
			
			foreach($arr as $key=>$val){
				if(preg_match("/\[(".$key.")]/",$subject,$m)){
				//if(!strpos($subject,'['.$key.']')===false){
					$subject=str_replace('['.$key.']',$val,$subject);
				}
			}
			
			
			$message=$row->message;
			foreach($arr as $key=>$val){
				if(preg_match("/\[(".$key.")]/",$message,$m)){
					$message=str_replace('['.$key.']',$val,$message);
				}
			}
			
			//$header = 'MIME-Version: 1.0' . "\r\n";
			//$header.="Content-type: text/html; charset=iso-8859-1\r\n";
			//$header.='From: $from_name <$from_email>\r\n';
			
			// if($_SERVER['HTTP_HOST']=='localhost'){
			// 	$ok=true;
			// }else{		
			// echo 'else';exit;
				//mail($arr['email'],$subject,$message,$header);
			//}
			
			
			
			$this->load->library('email');

		//if($this->config->item('protocol')=="smtp" or true)
{			$config['protocol'] = 'smtp';
			$config['smtp_crypto'] = 'tls'; 
			$config['smtp_host'] = 'smtp.gmail.com';
			$config['smtp_user'] ='cs@irwnetwork.com';
			$config['smtp_pass'] = '$;cWTqbHCLf[q6J';
			$config['smtp_port'] = '587';
			$config['smtp_timeout'] = '60';
			$config['mailtype'] = "html";
			$config['starttls']  = FALSE;
			 $config['newline']  = "\r\n";
			$this->email->initialize($config);
		}
		$fromemail='cs@irwnetwork.com';//$from_email
		$this->email->to($arr['email']);//
		$this->email->from($fromemail, $from_name);
		$this->email->subject($subject);
		$this->email->message($message);
		if($this->email->send()){
			$data = array(
					"name" => $template_name ,
					"from_name" => $from_name ,
					"from_email" => $from_email,
					"email_to" => $arr['email'],
					"subject" => $subject ,
					"message" => stripslashes($message),
					"date" => date("Y-m-d H:i:s")
				);
				$this->saveRowCustom($data,'email_logs');
				return true;
		}
		else{
			return false;
		} 
			
			
			
			
			
			
			
			
			
			
		}
		
	}
?>