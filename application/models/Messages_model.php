<?php
class Messages_model extends CI_Model
{
	
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function save($data){
		
		$this->db->insert('users',$data);
		return $this->db->insert_id();
	}

	public function countPendingMessages($data,$sender_id,$table_name){
		
		$this->db->where('type', 'translator');
		
		if($data['message_type'] == 'responded'){
			$this->db->where("translator_id <>",0);
			$this->db->where("is_responded",1);
		}else{
			$this->db->where("translator_id",0);
		}
		$this->db->where("sender_id",$sender_id);
		$this->db->where("is_sender_deleted",0); //not deleted
		$this->db->where("is_read",0); //not deleted
		
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( subject like '%".$data['search']."%' or message like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		$query  =   $this->db->get($table_name);
		//echo $this->db->last_query();
		return $query->num_rows();
	}
	
	public function countPendingMessagesForLeftMenu($data,$sender_id,$table_name){
		
		$query = "select * from ".$table_name." where (sender_id=$sender_id and is_responded=1 and type='translator' and sender_is_read=0) or (receiver_id=$sender_id and is_responded=1 and is_read=0 and type='message')";
		$query = $this->db->query($query);
		//echo $this->db->last_query();
		return $query->num_rows();
	}
	
	public function getAllPendingMessages($data,$sender_id,$start,$limit,$table_name){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$this->db->where('type', 'translator');
		
		if($data['message_type'] == 'responded'){
			$this->db->where("translator_id <>",0);
			$this->db->where("is_responded",1);
		}else{
			$this->db->where("is_responded",0);
		}
		$this->db->where("sender_id",$sender_id);
		$this->db->where("is_sender_deleted",0); //not deleted
		
		
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( subject like '%".$data['search']."%' or message like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		$query = $this->db->get($table_name);
		//echo $this->db->last_query();
		//die();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
  
	/**
	* 
	* @param type $message_type
	* @param sender_id $sender_id
	* @param table_name $table_name
	* @param urgent/normal $priority
	* @return int
	*/
	public function getLatestMessages($user_id,$table_name){
		
		$query = "select * from $table_name where (translator_id<>0 and sender_id=$user_id and receiver_id=$user_id and is_responded=1) or (translator_id<>0 and receiver_id=$user_id and sender_id<>$user_id and is_responded=1) order by id desc limit 0,3";
		$query = $this->db->query($query);
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getLatestMessagesForTranslator($table_name){
		
		$query = "select * from ".$table_name." where translator_id=0 order by id asc limit 0,3";
		$query = $this->db->query($query);
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function countAllPendingTranslatorMessages($data,$sender_id,$table_name,$priority=0){
		
		if($priority!=0){
			$this->db->where('priority',$priority);
		}
		if(isset($data['message_type']) && $data['message_type'] == 'responded'){
			$this->db->where("translator_id <>",0);
			$this->db->where("is_responded",0);
		}else{
			$this->db->where("translator_id",0);
		}
		
		$this->db->where("is_sender_deleted",0); //not deleted
		$query  =   $this->db->get($table_name);
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->num_rows();
		}
		return 0;
	}
	
	public function getAllPendingTranslatorMessages($data,$sender_id,$limit,$table_name,$priority){
		$this->db->limit($limit, 0);
		$this->db->where('priority',$priority);
		$this->db->order_by('sent_time','asc');
		$this->db->where("translator_id ",0);
		$this->db->where("is_sender_deleted",0); //not deleted
		$query = $this->db->get($table_name);
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	public function countInboxUnreadMessages($sender_id,$table_name){
		
		$this->db->where('type', 'message');
		$this->db->where("is_responded",1);

		$this->db->where("receiver_id",$sender_id);
		$this->db->where("is_receiver_deleted",0); //not deleted
		
		
		$query  =   $this->db->get($table_name);
		return $query->num_rows();
	}
	
	public function countInboxMessages($data,$sender_id,$table_name){
		
		$this->db->where('type', 'message');
		if($data['message_type'] == 'sent'){
			$this->db->where("sender_id",$sender_id);
			$this->db->where("is_sender_deleted",0); //not deleted
		}else{
			$this->db->where("receiver_id",$sender_id);
			$this->db->where("is_receiver_deleted",0); //not deleted
		}
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( subject like '%".$data['search']."%' or message like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		
		$query  =   $this->db->get($table_name);
		//echo $this->db->last_query();
		return $query->num_rows();
	}
	
	public function getAllInboxMessages($data,$sender_id,$start,$limit,$table_name){
		
		$this->db->limit($limit, $start);
		$this->db->order_by('sent_time','desc');
		$this->db->where('type', 'message');
		if($data['message_type'] == 'sent'){
			$this->db->where("sender_id",$sender_id);
			$this->db->where("is_sender_deleted",0); //not deleted
		}else{
			$this->db->where("is_responded",1);
			$this->db->where("receiver_id",$sender_id);
			$this->db->where("is_receiver_deleted",0); //not deleted
		}
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( subject like '%".$data['search']."%' or message like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		
		$query = $this->db->get($table_name);
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}

	public function insertTextMessage($data){
		$this->db->insert('message_text',$data);
		//echo $this->db->last_query();
		return true;
	}
	
	public function getTextByField($field,$id){
		$sSQL   =   $this->db->where($field,$id);
		$query  =   $this->db->get('message_text');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row;
		}
		return array();
	}
	
	public function getRowByIdAndTableName($id,$table_name){
		$sSQL   =   $this->db->where('id',$id);
		$query  =   $this->db->get($table_name);
		if($query->num_rows())
		{
			$row = $query->result();
			return $row[0];
		}
		return array();
	}
	
	
	public function deleteMessage($array,$user_id,$table_name){
		foreach($array as $id){
			$update_data = array();
			$message_row = $this->getRowByIdAndTableName($id,$table_name);
			if($message_row->sender_id == $user_id){
				$update_data['is_sender_deleted'] = 1;
			}
			else if($message_row->receiver_id == $user_id){
				$update_data['is_receiver_deleted'] = 1;
			}
			else if($message_row->translator_id == $user_id){
				$update_data['is_translator_deleted'] = 1;
			}
			
			$this->db->where('id',$id);
			$this->db->update($table_name,$update_data);
			//echo $this->db->last_query();
			//die();
		}
		return $this->db->affected_rows();
	}
	public function getMessageById($id){
		//$this->db->selete('message');
		$this->db->where('id', $id);
		$query = $this->db->get('message_text');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			$row = $query->result();
			return $row[0];
		}
		else{
			return array();
		}
	}
	
	public function assignJob($id,$priority_id){
		$this->db->order_by('sent_time','asc');
		//$this->db->where('type', 'translator');
		$this->db->where('priority',$priority_id);
		$this->db->limit('1');
		$this->db->where("translator_id",0);
		$this->db->where("is_sender_deleted",0); //not deleted
		$query = $this->db->get('message_text');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()){
			$row = $query->result();
			$this->db->where("translator_id",$id);
			$this->db->where("is_responded",0);
			$this->db->where("is_sender_deleted",0); //not deleted
			$query2 = $this->db->get('message_text');
			if($query2->num_rows()<1){
			$this->db->where('id',$row[0]->id);
			$arr['translator_id'] = $id;
			$status = $this->db->update('message_text',$arr);
				if($status){
					return $row[0];
				}
			
			}
		}
		return false;
	}
	
	public function currentJob($id){
		$this->db->where("translator_id",$id);
		$this->db->where("is_responded",0);
		$this->db->where("is_sender_deleted",0); //not deleted
		$query = $this->db->get('message_text');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()){
			$row = $query->result();
			return $row[0];
		}
		return array();
	}
	public function update($data,$id){

		$this->db->where('id',$id);
		$this->db->update('message_text',$data);
		return true;
	}
	public function insertResponse($data){
		return $this->db->insert('response_rating', $data);
	}
	
	public function getTranslatorId($data){
		$this->db->select('message_text.translator_id');
		$this->db->where('id', $data);
		$query = $this->db->get('message_text');
		if($query->num_rows()>0){
			$row = $query->result();
			return $row[0];
		}
		return array();
		
	}
	public function isRated($id){
		$this->db->where('message_id',$id);
		$this->db->where('type','text');
		$query = $this->db->get('response_rating');
		if($query->num_rows()>0){
			return true;
		}
		return false;
	}
	public function getRatingScore($messageId){
		$this->db->select('response_rating.score, response_rating.message');
		$this->db->where('message_id',$messageId);
		$this->db->where('type','text');
		$query = $this->db->get('response_rating');
		if($query->num_rows()>0){
			$row = $query->result();
			return $row[0];
		}
		return array();
	}
	public function getTraslatorRating($id, $IDs){
		$this->db->select('message_text.id');
		$this->db->where('translator_id',$id);
		$this->db->where('is_responded',1);
		$query = $this->db->get('message_text');
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			$row = $query->result_array();
			//print_r($row);
			//die();
			
			foreach($row as $key =>$id){
				$IDs[$key] = $id['id']; 
				}
				$this->db->select('response_rating.score');
				$this->db->where_in('message_id', $IDs); 
				$query2 = $this->db->get('response_rating');
				if($query2->num_rows()>0){
					$row2 = $query2->result_array();
					//print_r($row2);
					//die();
					$count = $query2->num_rows();
					//echo "count".$count;
					$sum=0;
					foreach($row2 as $score){
						$sum += $score['score']; 
						$avg = $sum/$count; 
						}
						
						return round($avg, 1); 
				}
			}
			else{
				return 0;
			}
		
	}
		
	public function countAllTranslatorRespondedMessages($data,$sender_id,$table_name,$priorty=NULL){
		$this->db->where("translator_id",$sender_id);
			$this->db->where("is_responded != ", 0);
		if($priorty!=NULL){
			$this->db->where("priority ", $priorty);
		}
		$this->db->where("is_translator_deleted",0); //not deleted
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( subject like '%".$data['search']."%' or message like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		$query  =   $this->db->get($table_name);
		//echo $this->db->last_query();
		return $query->num_rows();
   	}	
	public function getAllTranslatorRespondedMessages($data,$sender_id,$start,$limit,$table_name,$priorty){
		
		$this->db->limit($limit, $start);
		$this->db->where("translator_id",$sender_id);
		$this->db->where("priority ", $priorty);
		$this->db->where("is_responded != ", 0);
		$this->db->order_by('sent_time','desc');
		$this->db->where("is_translator_deleted",0); //not deleted
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( subject like '%".$data['search']."%' or message like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		
		$query = $this->db->get($table_name);
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	public function getTranslatorPendingMessages($table_name,$priorty=NULL){
		
		$this->db->limit(8, 0);
		
		if($priorty!=NULL){
			$this->db->where("priority ", $priorty);
		}
		$this->db->where("is_responded ",0);
		$this->db->order_by('sent_time','desc');
		$this->db->where("is_sender_deleted",0); //not deleted
		$this->db->where("is_receiver_deleted",0); //not deleted	
		if(isset($data['search']) && $data['search']!=''){
			$str = " ( subject like '%".$data['search']."%' or message like '%".$data['search']."%')";
			$this->db->where($str, NULL, FALSE);  
		}
		
		$query = $this->db->get($table_name);
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function downloadData($array,$user_id,$table_name){
		$this->db->select('file');
		$this->db->where_in('id',$array);
		$query = $this->db->get($table_name);
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row;	
		}
		return array();
	}
}
?>