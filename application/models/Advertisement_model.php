<?php
class Advertisement_model extends CI_Model
{
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('image_lib');
        $this->gallery_path = realpath(APPPATH . '../uploads');
    }


    public function getAllData($data,$start,$limit,$key=''){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','asc');
		$where = "  1=1 ";	
		if(isset($data['add_name']) && $data['add_name']!=''){
			$where.=" and (adverstisements.add_name like '%".$data['add_name']."%')";
		}
		if(isset($key) && $key!=''){
			$where.=" and (adverstisements.add_name like '%".$key."%')";
		}
		
		$this->db->where($where);
		$this->db->select('adverstisements.*, users.username');
		$this->db->from('users');
        $this->db->join('adverstisements', 'users.id = adverstisements.user_id','INNER');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}

	public function save($data){	
		$this->db->insert('adverstisements',$data);
		return $this->db->insert_id();
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
		$this->db->where('show_date <=',date('Y-m-d'));
		$this->db->where($where,NULL,false);
		$this->db->select('contents.*');
		$this->db->from('contents');
		$query  =   $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->num_rows();
	}

	public function update($data,$id){
		$this->db->where('id',$id);
		$this->db->update('contents',$data);
		return true;
	}

	public function getRow($id){
		$sSQL   =   $this->db->where("id",$id);
		$query  =   $this->db->get('adverstisements');
		if($query->num_rows())
		{
			$row = $query->row_array();
			return $row;
		}
		return array();
	}

	public function delete($id){
		$this->deleteFiles($id);
		$this->db->where('id', $id);
		return $this->db->last_query();
	}

	public function deleteFiles($id){
		$this->db->where('id', $id);
		$this->db->select('*');
		$query = $this->db->get('adverstisements');
		if($query->num_rows()){
			$rows =  $query->result();
			//echo "<pre>"; print_r($rows);exit;
			foreach($rows as $row){
				if ($row->file_url != '') {

					$my_url_parts = explode('/', $row->file_url);
					$myFileName = $my_url_parts[9];
					$myFileName = explode('?', $myFileName);
					$myFileName = $myFileName[0];
					//echo $myFileName;exit;
					$this->load->library('Gcloud');
					$file_name = $this->gcloud->deleteFile($myFileName);

				}
				@unlink('uploads/listing/'.$row->picture);
				@unlink('uploads/listing/thumb_400_'.$row->picture);
				@unlink('uploads/listing/thumb_469_'.$row->picture);
				@unlink('uploads/listing/thumb_153_'.$row->picture);
				@unlink('uploads/listing/thumb_50_'.$row->picture);

				//Delete google cloud file here
				//@unlink('uploads/files/'.$row->file);
				$this->db->where('id', $row->id);
				$this->db->delete('adverstisements');
			}	
		}
	}
}    