<?php

class Videoconferences_model extends CI_Model
{

  	function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	
	public function save($data){
		$this->db->insert('video_conferences',$data);
		return $this->db->insert_id();
	}

	public function update($data,$id){
		$this->db->where('id',$id);
		$this->db->update('video_conferences',$data);
		return true;
	}
	
	public function updateStatusByTranslatorID($data,$id,$user_id){
		$this->db->where('id',$id);
		$this->db->update('video_conferences',$data);
		return true;
	}
	
	public function checkLiveStremainByTranslatorISNotAcceptedByOtherUser($id,$user_id){
		$where = "(translator_id=$user_id or translator_id=0) and status='pending' and id='$id'";
		$this->db->where($where,NULL,false);
		$query = $this->db->get('video_conferences');
		
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function checkLiveStremainByDeaf($id,$user_id){
		
		$this->db->where('user_id',$user_id);
		$this->db->where('id',$id);
		$query = $this->db->get('video_conferences');
		
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function checkLiveStremainByTranslator($id,$user_id){
		
		$this->db->where('translator_id',$user_id);
		$this->db->where('id',$id);
		$query = $this->db->get('video_conferences');
		
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

	public function getRow($id){
		$this->db->where("id",$id);
		$query  =   $this->db->get('video_conferences');
		
		if($query->num_rows()){
			$row = $query->result_array();
			return $row[0];
		}else{
			return array();
		}
	}

	public function getVideoConferencesByUserId($id){
		$this->db->where("user_id",$id);
		$query  =   $this->db->get('video_conferences');
		
		if($query->num_rows()){
			$rows = $query->result_array();
			return $rows;
		}else{
			return array();
		}
	}

	public function getModeratorIDOFVideoConferencesByEventID($id){
		$this->db->where("event_id",$id);
		$this->db->order_by('id','desc');
		$this->db->where("type",'modeator');
		$query  =   $this->db->get('video_conferences');
		
		if($query->num_rows()){
			$row = $query->result_array();
			return $row[0]['id'];
		}else{
			return 0;
		}
	}
	
	public function checkLiveVideoRequest(){
		$this->db->where("translator_id",0);
		$this->db->where('status','pending');
		$query  =   $this->db->get('video_conferences');
		
		if($query->num_rows()){
			return true;
		}else{
			return false;
		}
	}
	
	public function getPendingLiveRequests(){
		$this->db->where("translator_id",0);
		$this->db->where('status','pending');
		$this->db->order_by('id','asc');
		$query  =   $this->db->get('video_conferences');
		
		if($query->num_rows()){
			$rows = $query->result_array();
			return $rows;
		}else{
			return array();
		}
	}
	
	public function checkRequestStarted($user_id){
		$this->db->where("user_id",$user_id);
		$this->db->where("translator_id <>",0);
		$this->db->where('status','waiting');
		$this->db->order_by('id','asc');
		$query  =   $this->db->get('video_conferences');
		
		if($query->num_rows()){
			$rows = $query->row();
			return $rows->id;
		}else{
			return 0;
		}
	}
	
	public function updateStatusOfLiveStreamingNotStartedInFiveMintes(){
		
		$date = time()-(60*5); //subtract five mintes
		
		$this->db->where("tranlator_started_date <=",$date);
		$this->db->where("translator_id <>",0);
		$this->db->where("status",'waiting');
		$query  =   $this->db->get('video_conferences');
		$rows = $query->result();
		foreach($rows as $row){
			$array = array(
						"status" => "expired"
					);
			$this->db->where('id',$row->id);
			$this->db->update('video_conferences',$array);
		}
	}
}
?>