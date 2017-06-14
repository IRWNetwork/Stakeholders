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
	
	function getAllContentsPictures(){
		$this->db->where('picture<>','');
		$query = $this->db->get('contents');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	function getAllContents(){
		$this->db->where('file<>','');
		$query = $this->db->get('contents');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
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
	public function getContentByUserId($id,$filter){
		if($filter!=''){
			$this->db->where('type',$filter);
		}
		$this->db->where('show_date <=',date('Y-m-d'));
		$sSQL   =   $this->db->where("user_id",$id);
		$query  =   $this->db->get('contents');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows())
		{
			$row = $query->result();
			return $row;
		}
		return array();
	}
	
	public function getContentByUserIdLimit($id,$start,$limit) {
		$this->db->limit($limit, $start);
		$this->db->where('show_date <=',date('Y-m-d'));
		$sSQL   =   $this->db->where("user_id",$id);
		$query  =   $this->db->get('contents');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows())
		{
			$row = $query->result();
			return $row;
		}
		return array();
	}
	
	public function getAllData($data,$start,$limit,$key=''){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (contents.title like '%".$data['name']."%' or contents.description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		if(isset($key) && $key!=''){
			$where.=" and (contents.title like '%".$key."%' or contents.description like '%".$key."%' or contents.type like'%".$key."%' )";
		}
		//echo $where;exit;
		$this->db->where('show_date <=',date('Y-m-d'));
		$this->db->where($where);
		//$this->db->where('contents.is_featured !=', 'yes');
		$this->db->select('contents.*, users.channel_name');
		$this->db->from('users');
        $this->db->join('contents', 'users.id = contents.user_id','INNER');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function countTotalRowsForAdmin($data)
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
		//echo $this->db->last_query();exit;
		return $query->num_rows();
	}
	
	public function getAllDataForAdmin($data,$start,$limit,$key=''){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (contents.title like '%".$data['name']."%' or contents.description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		if(isset($key) && $key!=''){
			$where.=" and (contents.title like '%".$key."%' or contents.description like '%".$key."%' or contents.type like'%".$key."%' )";
		}
		//echo $where;exit;
		$this->db->where($where);
		//$this->db->where('contents.is_featured !=', 'yes');
		$this->db->select('contents.*, users.channel_name');
		$this->db->from('users');
        $this->db->join('contents', 'users.id = contents.user_id','INNER');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getAllDataByUserId($user_id,$data,$start,$limit, $key=''){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (title like '%".$data['name']."%' or description like '%".$data['name']."%')";
		}
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (title like '%".$data['name']."%' or description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		if(isset($key) && $key!=''){
			$where.=" and (contents.title like '%".$key."%' or contents.description like '%".$key."%' or contents.type like'%".$key."%' )";
		}
		$where.=" and user_id='". $user_id."'";
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
			$where.=" and (contents.title like '%".$data['name']."%' or contents.description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		$this->db->where('show_date <=',date('Y-m-d'));
		$this->db->where($where,NULL,false);
		$this->db->select('contents.*, users.channel_name');
		$this->db->from('users');
		$this->db->join('contents','users.id = contents.user_id','INNER');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
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
		$this->db->where('show_date <=',date('Y-m-d'));
		$this->db->select('contents.*, users.channel_name');
		$this->db->from('users');
		$this->db->join('contents','users.id = contents.user_id','INNER');
		$query = $this->db->get();
		$r=array();
		if($query->num_rows())
		{
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
		$this->db->where('show_date <=',date('Y-m-d'));
		$this->db->where($where,NULL,false);
		$this->db->select('contents.*');
		$this->db->from('contents');
		$query  =   $this->db->get();
		//echo $this->db->last_query();exit;
		return $query->num_rows();
	}
	
	public function countTotalRowsByUserId($user_id,$data)
	{
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (title like '%".$data['name']."%' or description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		$where.=" and user_id='". $user_id."'";
		$this->db->where('show_date <=',date('Y-m-d'));
		$this->db->where($where,NULL,false);
		$this->db->select('contents.*');
		$this->db->from('contents');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	
	public function countTotalRowsByUserIdForAccountListing($user_id,$data)
	{
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (title like '%".$data['name']."%' or description like '%".$data['name']."%')";
		}
		if(isset($data['type']) && $data['type']!=''){
			$where.=" and type='". $data['type']."'";
		}
		$where.=" and user_id='". $user_id."'";
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
	
	public function deleteBanner($id){
		$this->deleteBannerFiles($id);
		$this->db->where('id', $id);
	}
	
	public function googleCloudDelete($id) {
		$this->load->library('Gcloud');
		$file_name = $this->gcloud->deleteData($source,$file_name);
		// $this->db->where('id', $id);
		// $this->db->select('*');
		// $query = $this->db->get('contents');
		// $data = $query->row_array();
		// echo "<pre>"; print_r($data);exit;
	}
	public function deleteFiles($id){
		$this->db->where('id', $id);
		$this->db->select('*');
		$query = $this->db->get('contents');
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
				$this->db->delete('contents');
			}	
		}
	}
	
	public function deleteBannerFiles($id){
		$this->db->where('id', $id);
		$this->db->select('*');
		$query = $this->db->get('pages_banners_details');
		if($query->num_rows()){
			$rows =  $query->result();
			//echo "<pre>"; print_r($rows);exit;
			foreach($rows as $row){
				@unlink('uploads/banner_images/'.$row->banner_image);
				@unlink('uploads/banner_images/thumb_400_'.$row->banner_image);
				@unlink('uploads/banner_images/thumb_153_'.$row->banner_image);

				$this->db->where('id', $row->id);
				$this->db->delete('pages_banners_details');
			}	
		}
	}
	
	public function getTotalEpisode(){
	    $user_id = $this->ion_auth->user()->row()->id;
		$query   = $this->db->query('SELECT COUNT(*) As total from contents where user_id = "'.$user_id.'" ');
		//echo $this->db->last_query();		
		//die();
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0]; 
		}
		return array();

	}

	public function getTotalEpisodeById($user_id){
		
		$query   = $this->db->query('SELECT COUNT(*) As total from contents where user_id = "'.$user_id.'" ');
		//echo $this->db->last_query();		
		//die();
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0]; 
		}
		return array();

	}
	
	public function countUserContentByIds($ids){
		$this->db->select('user_id, type, count(*) as TOTAL ');
		$this->db->from('contents'); 
		$this->db->where_in('user_id',$ids);
		//$this->db->where('contents.type',$type);
		$this->db->group_by('user_id,type');
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row;	
		}
		return array();
	}
	
	// pages banner add or change functionality 
	 public function countBannersTotalRows($data)
	{
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (page like '%".$data['name']."%' or banner_link like '%".$data['name']."%')";
		}
		$this->db->where($where,NULL,false);
		$this->db->select('pages_banners_details.*');
		$this->db->from('pages_banners_details');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	
	public function getAllBannersData($data,$start,$limit){
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
		$this->db->select('pages_banners_details.*');
		$query = $this->db->get('pages_banners_details');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	public function getBannerRowByField($field, $value){
		$sSQL   =   $this->db->where($field,$value);
		$query  =   $this->db->get('pages_banners_details');
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row;
		}
		return array();
	}
	
	public function getBannerRowByID($id){
		$sSQL   =   $this->db->where('id',$id);
		$query  =   $this->db->get('pages_banners_details');
		if($query->num_rows())
		{
			$row = $query->row_array();
			return $row;
		}
		return array();
	}
	public function saveBanner($data){	
		$this->db->insert('pages_banners_details',$data);
		return $this->db->insert_id();
	}
	
	public function updateBanner($data,$id){
		$this->db->where('id',$id);
		$this->db->update('pages_banners_details',$data);
		return true;
	}
	
	public function getRssRows(){
		$query  =   $this->db->get('news_feeds');
		if($query->num_rows())
		{
			$row = $query->result();
			return $row;
		}
		return array();
	}
	
	
	function checkUserContent($id){
		$user_id = $this->ion_auth->user()->row()->id;
		$this->db->where('id',$id);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('contents');
		
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
}
?>