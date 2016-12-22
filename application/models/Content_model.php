<?php

class Content_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'contents';
    }
	
	public function save($data){	
		$this->db->insert('contents',$data);
		return $this->db->insert_id();
	}
	
	public function update($data,$id){
		$this->db->where('id',$id);
		$this->db->update('contents',$data);
		return true;
	}
	
	public function getRow($id){
		$sSQL   =   $this->db->where("id",$id);
		$query  =   $this->db->get('contents');
		
		if($query->num_rows())
		{
			$row = $query->row_array();
			return $row;
		}
		return array();
	}
	
	public function getAllData($data,$start,$limit){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (title like '%".$data['name']."%' or description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		$this->db->where($where,NULL,false);
		$this->db->select('contents.*');
		$query = $this->db->get('contents');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getFeaturedData($data){
		$this->db->limit(3, 0);
		$this->db->order_by('id','desc');
		$where = "  1=1 and is_featured='yes'";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (title like '%".$data['name']."%' or description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		$this->db->where($where,NULL,false);
		$this->db->select('contents.*');
		$query = $this->db->get('contents');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getAudio($data,$start,$limit){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$where = "";	
		if(isset($data['name']) && $data['name']!=''){
			$this->db->like(array("title",$data['name'],"description",$data['name']));
		}
		if(isset($data['type']) && $data['type']!=''){
			$this->db->where("type",$data['type']);
		}
		
		$this->db->select('contents.*');
		$query = $this->db->get('contents');

		
		
		
		if($query->num_rows())
		{
			
		
		
		
		$r=array();
		foreach ($query->result_array() as $row)
{
	$title=$row["title"];
	
	$src=site_url().'/uploads/files/'.$row["file"];
	$r[]=array('src' => $src, 'type' =>'audio/mp3', 'artist'=>$title, 'title'=>$title);
    
}

		}
 return $r;
	}
	
	public function countTotalRows($data)
	{
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (title like '%".$data['name']."%' or description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		$this->db->where($where,NULL,false);
		$this->db->select('contents.*');
		$this->db->from('contents');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	

	public function delete($id){
		$this->deleteFiles($id);
		$this->db->where('id', $id);
		return $this->db->last_query();
	}
	
	public function deleteFiles($id){
		$this->db->where('id', $id);
		$this->db->select('*');
		$query = $this->db->get('contents');
		if($query->num_rows()){
			$rows =  $query->result();
			foreach($rows as $row){
				@unlink('uploads/files/'.$row->picture);
				@unlink('uploads/files/'.$row->file);
				$this->db->where('id', $row->id);
				$this->db->delete('contents');
			}	
		}
	}
}
?>