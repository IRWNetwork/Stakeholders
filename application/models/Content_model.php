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
	
	function getPlaylist($user_id){

		$this->db->where('user_id',$user_id);
		$query = $this->db->get('playlists');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	function saveSongToPlaylist($data){
		$this->db->insert('playlists_songs',$data);
		return $this->db->insert_id();
	}
	
	function saveToPlaylist($data){
		$this->db->insert('playlists',$data);
		return $this->db->insert_id();
	}
	
	function checkIsFeatured($id){
		if ($this->ion_auth->logged_in()) {
			$user_id = $this->ion_auth->user()->row()->id;
			if(!$this->checkFavoriteSong($id,$user_id)){
				return 'fa fa-star text-green';
			}else{
				return 'fa fa-star-o text-white';
			}
		}else{
			return 'fa fa-star-o text-white';
		}
	}
	
	public function checkFavoriteSong($id,$user_id){
		$this->db->where("song_id",$id);
		$this->db->where("user_id",$user_id);
		$query  =   $this->db->get('favorite_songs');
		
		if($query->num_rows())
		{
			return false;
		}
		return true;
	}
	
	function countSongsInPlaylist($user_id,$playlist_id){
		$this->db->where("playlist_id",$playlist_id);
		$this->db->where("user_id",$user_id);
		$query  =   $this->db->get('playlists_songs');
		
		return $query->num_rows();
		
	}
	
	function checkPlaylistByUser($user_id,$playlist_id){
		$this->db->where("id",$playlist_id);
		$this->db->where("user_id",$user_id);
		$query  =   $this->db->get('playlists');
		
		return $query->num_rows();
		
	}
	
	public function getPlaylistSongs($user_id,$playlist_id){
				
		$query = "select * from playlists_songs, contents where 1 and playlists_songs.song_id=contents.id and playlists_songs.user_id=$user_id order by playlists_songs.id desc";
		$query = $this->db->query($query);
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
		
		
	}

	public function remove_song($user_id, $song_id, $playlist_id) {
		$query = "DELETE FROM playlists_songs WHERE playlists_songs.song_id = $song_id AND  playlists_songs.user_id = $user_id AND playlists_songs.playlist_id = $playlist_id";
		$query = $this->db->query($query);
		if (count($query > 0)) {
			echo "true";
		}
	}

	
	public function checkSongInPlaylist($song_id,$user_id,$playlist_id){
		$this->db->where("song_id",$song_id);
		$this->db->where("user_id",$user_id);
		$this->db->where("playlist_id",$playlist_id);
		$query  =   $this->db->get('playlists_songs');
		
		if($query->num_rows())
		{
			return false;
		}
		return true;
	}
	public function getPlaylistRow($user_id,$playlist_id){
		$where = "  where 1 ";	
		$query = "select * from playlists where user_id=$user_id and id=$playlist_id";
		$query = $this->db->query($query);
		if($query->num_rows())
		{
			return $query->row();
		}
		return array();
	}
	
	public function saveToFavorite($data){	
		$this->db->insert('favorite_songs',$data);
		return $this->db->insert_id();
	}
	
	public function getAllFavoriteSongs($user_id,$data,$start,$limit){
		$where = "  where 1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (contents.title like '%".$data['name']."%' or contents.description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and contents.type='". $data['type']."'";
		}
		$query = "select * from favorite_songs, contents $where and favorite_songs.song_id=contents.id and favorite_songs.user_id=$user_id order by favorite_songs.id desc limit $start,$limit";
		$query = $this->db->query($query);
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function countFavoriteSongs($user_id,$data){
		
		$where = "where 1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (contents.title like '%".$data['name']."%' or contents.description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and contents.type='". $data['type']."'";
		}
		$query = "select * from favorite_songs, contents $where and favorite_songs.song_id=contents.id and favorite_songs.user_id=$user_id ";
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function removeFromFavorite($id,$user_id){
		$this->db->where('song_id', $id);
		$this->db->where('user_id', $user_id);
		$this->db->delete('favorite_songs');
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
			foreach ($query->result_array() as $row){
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