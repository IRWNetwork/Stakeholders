<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect(site_url('/'), 'refresh');
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
}