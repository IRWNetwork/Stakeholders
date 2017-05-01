<?php
class Feedback_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'feed_back';
    }
	
	public function save($data){	
		$this->db->insert($this->tablename,$data);
		return $this->db->insert_id();
	}
	public function countTotalRows($data)
	{
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (feed_back.subject like '%".$data['name']."%' or feed_back.message like '%".$data['name']."%' or users.first_name like '%".$data['name']."%'or users.last_name like '%".$data['name']."%')";
		}
		
		$this->db->where($where,NULL,false);
		$this->db->select('users.first_name, users.last_name, feed_back.subject, feed_back.message, feed_back.date');
		$this->db->from('users');
		$this->db->join('feed_back','users.id = feed_back.user_id','INNER');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	
	public function getAllData($start,$limit,$key=''){
		$this->db->limit($limit, $start);
		$this->db->order_by('users.id','desc');
		$where = "  1=1 ";	
		
		if(isset($key) && $key!=''){
			$where.=" and (feed_back.subject like '%".$key."%' or feed_back.message like '%".$key."%' or users.first_name like '%".$key."%'or users.last_name like '%".$key."%')";
		}
		$this->db->where($where,NULL,false);
		$this->db->select('users.first_name, users.last_name, feed_back.subject, feed_back.message, feed_back.date, feed_back.is_read, feed_back.id');
		$this->db->from('users');
        $this->db->join('feed_back','users.id = feed_back.user_id','INNER');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getInfoById($id){
		$this->db->where('feed_back.id',$id);
		$this->db->select('users.first_name, users.last_name, feed_back.subject, feed_back.message, feed_back.date, feed_back.is_read');
		$this->db->from('users');
        $this->db->join('feed_back','users.id = feed_back.user_id','INNER');
		$query = $this->db->get();
		//echo $this->db->last_query();
		
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}
	
	public function updateIsRead($id){
		$data = array(
           'is_read' => 1,
        );
		$this->db->where('id', $id);
		$this->db->update('feed_back', $data);
		return true;
	}

	
}
?>