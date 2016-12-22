<?php

class Categories_model extends CI_Model
{

	public $childCategory = array();
	public $tree_html	  = "";
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function getRowBySeoUrl($type,$url){

		$query  =   $this->db->get('categories');
		
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}
	
	public function save($data){
		$this->db->insert('categories',$data);
		return $this->db->insert_id();
	}
	
	public function update($data,$id){
		$this->db->where('id',$id);
		$this->db->update('categories',$data);
		return true;
	}
	
	public function getRow($id){
		$sSQL   =   $this->db->where("id",$id);
		$query  =   $this->db->get('categories');
		
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}
	
	public function getAllCategories(){
		$this->db->order_by('id','desc');
		$this->db->select('*');
		$query = $this->db->get('categories');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}

	
	public function getAllProducts($data,$start,$limit){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		if($data['name']!=''){
			$this->db->like('name', $data['name']);
		}
		$this->db->select('*');
		$query = $this->db->get('categories');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function countProductsTotal($data){
		if(isset($data['name']) && $data['name']!=''){
			$this->db->like('name', $data['name']);
		}
		$this->db->select('*');
		$this->db->from('categories');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	
	
	public function getAllProductsForUser($data,$start,$limit){
		$this->db->limit($limit, $start);
		$this->db->where('locked', 'no');
		if(isset($data['sort_by']) && $data['sort_by']!==''){
			$this->db->order_by($data['sort_by'],'asc');
		}else{
			$this->db->order_by('id','desc');
		}
		if($data['name']!=''){
			$this->db->like('tilte', $data['name']);
			$this->db->or_like('description', $data['name']);
			$this->db->or_like('detail', $data['name']);
			$this->db->or_like('price', $data['name']);
			$this->db->or_like('featured_price', $data['name']);
		}
		$this->db->where('protal', 'no');
		$this->db->select('*');
		$query = $this->db->get('categories');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	
	function getParentCategories(){
		$this->db->where('parent_id', '0');
		
		$this->db->select('*');
		$this->db->from('categories');
		$query  =   $this->db->get();
		return $query->result();
	}
	
	function getParentCategoriesForHome(){
		$this->db->limit(3,0);
		$this->db->where('parent_id', '0');
		
		$this->db->select('*');
		$this->db->from('categories');
		$query  =   $this->db->get();
		return $query->result();
	}
	
	function getCategoriesByParentID($id){
		$this->db->where('parent_id', $id);
		
		$this->db->select('*');
		$this->db->from('categories');
		$query  =   $this->db->get();
		return $query->result();
	}

	function get_options($parent_id=0,&$indent=''){
	
		$query  = "select * from categories where parent_id=$parent_id";
		$query  = $this->db->query($query);
		if($query->num_rows()<=0){
			return;
		}
		if($parent_id!=0) $indent=$this->get_spaces($indent,10);
		$rows = $query->result();
		foreach($rows as $row){
			$this->options_html.="<option value=\"{$row->id}\">{$indent}{$row->name}</option>\r\n";
			$this->get_options($row->id,$indent);
		}
		$indent=$this->get_spaces($indent,-10);
		return $this->options_html;
	}
	
	function getCategoryForCategoryPage($parent_id=0){
		$query = "select * from categories where parent_id=$parent_id";
		$query = $this->db->query($query);
		if($query->num_rows()<=0){ 
			return;
		}
		if($parent_id==0){
			$this->tree_html.="<ul>";
		}else{
			$this->tree_html.="<ul class='children'>";
		}
		$rows = $query->result();
		foreach($rows as $row){
			$title=$row->name;
			if($this->Common_model->get_language_name() == 'arabic'){
				//$this->tree_html.="<li><a href='{$row->arabic_url}' >{$row->name_arabic}</a>";
				$this->tree_html.="<li><a href='".base_url()."category/{$row->english_url}' >{$row->name_arabic}</a>";
			}else{
				$this->tree_html.="<li><a href='".base_url()."category/{$row->english_url}' >{$row->name}</a>";
			}
			$this->getCategoryForCategoryPage($row->id);
			$this->tree_html.="</li>";
		}
		$this->tree_html.="</ul>";
		return $this->tree_html;
		
	}
	
	function getChaildCategory($parent_id=0){
	
		$query  = "select * from categories where parent_id=$parent_id";
		$query  = $this->db->query($query);
		if($query->num_rows()<=0){
			return;
		}
		$rows = $query->result();
		foreach($rows as $row){
			$this->childCategory[] = $row->id;
			$this->getChaildCategory($row->id);
		}
		$return_array = $this->childCategory;
		$this->childCategory = array();
		return $return_array;
	}
	
	private function get_spaces($spaces='',$x=0){
		if($x>=0){
			for($i=1;$i<=$x;$i++)
				$spaces.='-';
		}
		else{
			$x=abs($x);
			$l=strlen($spaces);
			$spaces=substr($spaces,0,$l-$x);
		}
		return $spaces;
	}
	
	public function createUrl($type,$title,$id=NULL){
		$title = $this->Common_model->toAscii($type,$title);
		
		$total = $this->countUrl($type,$title,$id);
		if($total>0){
			$title = $title."-".$total;
		}
		return $title;
	}
	
	public function countUrl($type,$title,$id){
		if($id!=''){
			$this->db->where("id",$id);
		}
		$this->db->where($type."_url",$title);
		$this->db->select('*');
		$this->db->from('categories');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	
	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('categories');
		$this->db->last_query();
		return true;
	}
	
}
?>
