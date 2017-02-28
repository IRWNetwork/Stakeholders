<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){
		
		parent::__construct();
		$this->load->model('Content_model');
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		$this->load->library('email');
		$this->load->library("Disqus");
		$this->load->helper(array('form', 'url', 'file'));
		
		if ($this->ion_auth->logged_in()) {
			$user_id 	= $this->ion_auth->user()->row()->id;
			$this->data['playlists'] 	= $this->Content_model->getPlaylist($user_id);
			$this->data['user_id'] 		= $user_id;
		}else{
			$this->data['playlists'] 	= array();
			$this->data['user_id'] 		= 0;
		}
		
		$this->data['rssRows'] = $this->Content_model->getRssRows();

		
		/***** Rss Feed from wrestlezone.com ******/
		$rss_array = array();
		$this->load->library('rssparser');
		$rss_data = $this->rssparser->set_feed_url('http://www.wrestlezone.com/feed')->set_cache_life(30)->getFeed(10);
		foreach($rss_data as $row){
			$html = $row['description'];
			preg_match('@src="([^"]+)"@',$html,$match);
			$src 			= array_pop($match);
			$row['image'] 	= $src;
			$rss_array[] 	= $row;
		}
		$this->data['rss_data'] = $rss_array;
	}
	
}