<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			ciredirect(site_url('/'), 'refresh');
		}
    }
    
	public function index($id=NULL)
	{
		$this->data['page_title'] = "Playlist";
		$this->data['page_heading'] = "Playlist";
		$user_id 	= $this->ion_auth->user()->row()->id;
		$checkPlaylistByUser = $this->Content_model->checkPlaylistByUser($user_id,$id);
		if($checkPlaylistByUser){
			$this->data['contents'] 	= $this->Content_model->getPlaylistSongs($user_id,$id);
			$this->data['playListRow'] 	= $this->Content_model->getPlaylistRow($user_id,$id);
			$this->data['featured']		= $this->Content_model->getFeaturedData(array());
		}else{
			$this->session->set_flashdata('error','Invalid Email or Password');
		}
		
        $parser['content']	=  $this->load->view('user/playlist',$this->data,TRUE);
        $this->parser->parse('template', $parser);
	}

	public function get_playlist_by_id_json() {
		$id = $_POST['id'];
		$user_id = $this->ion_auth->user()->row()->id;
		$this->data['contents'] = $this->Content_model->getPlaylistSongs($user_id,$id);
		$all_songs = array();

		foreach ($this->data['contents'] as $key => $song) {
			
			$all_songs[$key]['title'] = $song->title;
			$all_songs[$key]['id'] = $song->song_id;
			$all_songs[$key]['song'] = $song->file;
			$all_songs[$key]['picture'] = $song->picture;
		}
		$result = json_encode($all_songs);
		echo $result;

	}

	public function remove_song_from_playlist() {
		
		$playlist_id = $this->input->post('playlistId');
		$song_id = $this->input->post('songId');
		$user_id = $this->ion_auth->user()->row()->id;
		$result = $this->Content_model->remove_song($user_id, $song_id, $playlist_id);
		return $result;
	}
}