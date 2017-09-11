<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Emailtemplates_model');
		$this->load->library("pagination");
		$this->load->model('Events_model');
		//$this->load->library('gcloud/gcloud.php');
    }

    public function addContentPlayTime() {
		$id = $this->input->post('id');
		$listen_time = $this->input->post('listen_time');

		$listen_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $listen_time);
		sscanf($listen_time, "%d:%d:%d", $hours, $minutes, $seconds);
		$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
		
		$this->Content_model->updateListentime($id, $time_seconds);
	}
	
	public function home2(){
		$this->data['page_title'] 	= 'Home';
		$this->data['page_heading']  = 'Home';
		$search 			   = $this->input->get('search')?$this->input->get('search'):"";
        $arr['name']           = $search;
		$config 			   = array();
        $config["base_url"]    = base_url() . "products/search";
        $config["total_rows"]  = $this->Content_model->countTotalRows($arr);
		if($this->input->get('per_page')){
			$config["per_page"]= $this->input->get('per_page');
		}else{
        	$config["per_page"]= 20;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string']   = true;
        $this->pagination->initialize($config);
        $page 		        = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->data['contents']	= $this->Content_model->getAllData($arr,$page,$config["per_page"]);
		$this->data['contents1']	= $this->Content_model->getAudio($arr,$page,$config["per_page"]);
		$this->data['featured']	= $this->Content_model->getFeaturedData($arr);
		
		$this->data["links"]   = $this->pagination->create_links();

        $parser['content']		=  $this->load->view('main2',$this->data,TRUE);
        $this->parser->parse('template2', $parser);
	}
	    
	public function audio()
	{
		$this->data['page_title'] 	= 'Home';
		$this->data['page_heading'] 	= 'Home';
		
		
		$search 			   = $this->input->get('search')?$this->input->get('search'):"";
        $arr['name']           = $search;
		$arr['type']		   = "Audio";
		$config 			   = array();
		$config["base_url"]    = base_url() . "home/audio";
        $config["total_rows"]  = $this->Content_model->countTotalRows($arr);
		if($this->input->get('per_page')){
			$config["per_page"]= $this->input->get('per_page');
		}else{
        	$config["per_page"]= 20;
		}
        $config["uri_segment"] = 3;
		$config['reuse_query_string']   = true;

        $this->pagination->initialize($config);
        $page 		           = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$audio1= $this->Content_model->getAudio($arr,$page,$config["per_page"]);
		$audio= json_encode($audio1);
		echo $audio;
		/*
		echo "[
  			{ src: 'http://localhost/U2_One.ogg', type: 'audio/ogg', artist: 'test artist', title: 'title' }]"; 
			//$this->output->set_content_type('application/json')->set_output(json_encode($audio));
		*/	
	}


	public function wrestle_circus() {
		$this->data['page_title'] 	  = 'IRW Live Room';
		$this->data['page_heading'] 	= 'IRW Live Room';

		$this->data['featuredcontent']	= $this->Content_model->getFeaturedData(array());
		$parser['content'] = $this->load->view('wrestle_circus',$this->data,TRUE);
        $this->parser->parse('template', $parser);
	}
	public function index()
	{
		$this->load->model('Preferences_model');
		$this->data['page_title'] 	  = 'Home';
		$this->data['page_heading'] 	= 'Home';
		$search 			   = $this->input->get('search')?$this->input->get('search'):"";
        $arr['name']           = $search;
		$config 			   = array();
        $config["base_url"]    = base_url() . "products/search";
        $this->data['popup_check']  = $this->Preferences_model->popup_check('show_popup');
        $config["total_rows"]  = $this->Content_model->countTotalRows($arr);


		if($this->input->get('per_page')){
			$config["per_page"]= $this->input->get('per_page');
		}else{
        	$config["per_page"]= 20;
		}


        $config["uri_segment"] = 3;
		$config['reuse_query_string']   = true;
        $this->pagination->initialize($config);
        $page 		                = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->data['contents']	  = $this->Content_model->getAllData($arr,$page,$config["per_page"]);
		$this->data['contents1']	 = $this->Content_model->getAudio($arr,$page,$config["per_page"]);
		//echo "<pre>"; print_r($this->data['contents1']);exit;
		$this->data['featured']	  = $this->Content_model->getFeaturedData($arr);
		$this->data['facebook_link'] =  $this->Preferences_model->getValue('facebook_link');
		$this->data['twitter_link']  =  $this->Preferences_model->getValue('twitter_link');
		$this->data['instagram_link']=  $this->Preferences_model->getValue('instagram_link'); 
		$this->data["links"]         = $this->pagination->create_links();
		$this->data['bannerDetail']  = $this->Content_model->getBannerRowByField("page","new");
		if (isset($_POST['flag']) || isset($_GET['flag'])) {
			echo $this->load->view('main',$this->data,TRUE);
		}
		else {
			$parser['content'] = $this->load->view('main',$this->data,TRUE);
        	$this->parser->parse('template', $parser);
		}
	}

	public function refund_policy() {
		$this->data['page_title'] 	  = 'Refund Policy';
		$this->data['page_heading'] = 'Refund Policy';

		$this->data['featuredcontent']	= $this->Content_model->getFeaturedData(array());

        if (isset($_POST['flag'])) {
			echo $this->load->view('refund_policy',$this->data,TRUE);
		}else {
			$parser['content'] = $this->load->view('refund_policy',$this->data,TRUE);
	        $this->parser->parse('template', $parser);
		}
	}

	public function contact_irw() {
		$this->data['page_title'] 	  = 'Contact IRW';
		$this->data['page_heading'] = 'Contact IRW';

		$this->data['featuredcontent']	= $this->Content_model->getFeaturedData(array());

        if (isset($_POST['flag'])) {
			echo $this->load->view('contact_irw',$this->data,TRUE);
		}else {
			$parser['content'] = $this->load->view('contact_irw',$this->data,TRUE);
	        $this->parser->parse('template', $parser);
		}
	}
	
	public function playvideo(){
		$id = $this->input->get('id');
		$video_row = $this->Content_model->getRow($id);
		$this->data['dataRow']			= $video_row;
		$this->data['page_title'] 		= $video_row['title'];
		$this->data['page_heading'] 	= $video_row['title'];
		$this->data['meta_keywords']	= $video_row['meta_keywords'];
		$this->data['meta_description']	= $video_row['meta_description'];
		$this->data['featuredcontent']	= $this->Content_model->getFeaturedData(array());
		
		if (isset($_POST['flag'])) {
			echo $this->load->view('playvideo_ajax',$this->data,TRUE);
		}else {
			$parser['content'] = $this->load->view('playvideo',$this->data,TRUE);
	        $this->parser->parse('template', $parser);
		}
	}
	
	
	public function playaudio(){
	
		$id = $this->input->get('id');
		$video_row = $this->Content_model->getRow($id);

		$this->data['dataRow']			 = $video_row;
		$this->data['page_title'] 		  = $video_row['title'];
		$this->data['page_heading'] 		= $video_row['title'];
		$this->data['featuredcontent']	 = $this->Content_model->getFeaturedData(array());
		$parser['content']			=  $this->load->view('playaudio',$this->data,TRUE);
        $this->parser->parse('template', $parser);
	}
	
	public function showArticle(){
		$id = $this->input->get('id');
		$article_row = $this->Content_model->getRow($id);
		$this->data['dataRow']			= $article_row;
		$this->data['page_title'] 		= $article_row['title'];
		$this->data['page_heading'] 	= $article_row['title'];
		$this->data['meta_keywords']	= $article_row['meta_keywords'];
		$this->data['meta_description']	= $article_row['meta_description'];
		$this->data['featuredcontent']	= $this->Content_model->getFeaturedData(array());
		if (isset($_POST['flag'])) {
			echo $this->load->view('article-detail-ajax',$this->data,TRUE);
		}else {
			$parser['content'] =  $this->load->view('article-detail',$this->data,TRUE);
	        $this->parser->parse('template', $parser);
		}
	}
	
	public function add_remove_to_favorite(){
		$id 		= $this->input->post('id');
		if ($this->ion_auth->logged_in()) {
			$user_id 	= $this->ion_auth->user()->row()->id;
			$array = array("user_id"=>$user_id,"song_id"=>$id);
			if($this->Content_model->checkFavoriteSong($id,$user_id)){	
				$this->Content_model->saveToFavorite($array);
				echo json_encode(array("msg"=>'Add to favorite successfully'));
			}else{
				$this->Content_model->removeFromFavorite($id,$user_id);
				echo json_encode(array("msg"=>"Remove from favorite successfully"));
			}
		}else{
			echo json_encode(array("msg"=>"Please login to add to Favorite"));
		}
	}
	
	public function add_playlist(){
		if ($this->ion_auth->logged_in()) {
			$user_id 		= $this->ion_auth->user()->row()->id;
			$title 			= $this->input->post('title');
			$description 	= $this->input->post('description');
			$array = array("user_id"=>$user_id,"title"=>$title,"description"=>$description);
			$this->Content_model->saveToPlaylist($array);
			echo json_encode(array("msg"=>'Playlist added successfully'));			
		}else{
			echo json_encode(array("msg"=>"Please login to create playlist"));
		}
	}
	
	function add_song_to_playlist(){
		if ($this->ion_auth->logged_in()) {
			$user_id 		= $this->ion_auth->user()->row()->id;
			$playlistid		= $this->input->post('playlistid');
			$song_id 		= $this->input->post('songid');
			$array = array("user_id"=>$user_id,"playlist_id"=>$playlistid,"song_id"=>$song_id);
			if($this->Content_model->checkSongInPlaylist($song_id,$user_id,$playlistid)){	
				$this->Content_model->saveSongToPlaylist($array);
				echo json_encode(array("msg"=>'Song added to playlist successfully'));
			}else{
				echo json_encode(array("msg"=>'Song already added in playlist'));
			}
		}else{
			echo json_encode(array("msg"=>"Please login to add song in playlist"));
		}
	}
	
	public function showpopup(){
		$id = $this->input->post('id');
		$row = $this->Content_model->getRow($id);
		$this->data['dataRow']			= $row;
		$this->load->view('share_popup',$this->data);
	}

	public function map()
	{
		$this->data['page_title'] 	= 'Map';
		$this->data['page_heading'] 	= 'Map';
		
		$events	   		= $this->Events_model->getAllEvents();
		$new_array = array();
		foreach($events as $event){

			$event['date'] = date("m/d/Y",strtotime($event['start_date']));
			$event['time'] = date("h:i a",strtotime($event['start_date']));
			$new_array[] = $event;

		}
		$this->data['events'] 			= json_encode($new_array);
		$this->data['categories']	   	= $this->Events_model->getAllCategories();

		
		if (isset($_POST['flag'])) {
			echo $this->load->view('map/map-view',$this->data,TRUE);
		}else {
			$parser['content']	=  $this->load->view('map/map-view',$this->data,TRUE);
	        $this->parser->parse('template', $parser);
		}
	}
	
	public function get_events_by_categories(){
		$events 	= $this->input->post('events');
		$producers 	= $this->input->post('producers');
		$events = $this->Events_model->getAllEventsByCategories($events,$producers);
		$new_array = array();
		foreach($events as $event){

			$event['date'] = date("m/d/Y",strtotime($event['start_date']));
			$event['time'] = date("h:i a",strtotime($event['start_date']));
			$new_array[] = $event;

		}
		echo json_encode($new_array);
	}
	
	public function mainpopup()
	{
		$this->load->model('Preferences_model');
		$this->session->set_userdata(array('websiteloaded'=>'yes'));
		$this->data['page_title'] 	 = 'Popup';
		$this->data['page_heading']   = 'Popup';
		$this->data['popup_content']  = base64_decode($this->Preferences_model->getValuePopup('popup_content'));
		$this->data['popup_check']  = $this->Preferences_model->popup_check('show_popup');
		$this->load->view('popup',$this->data);
	}

	function pagePopup() {
		$this->load->model('Preferences_model');
		$this->session->set_userdata(array('websiteloaded'=>'yes'));
		$this->data['page_title'] 	 = 'Popup';
		$this->data['page_heading']   = 'Popup';
		echo $this->data['popup_content']  = base64_decode($this->Preferences_model->getValuePopupAllPages($_GET['page']));exit;
		$this->data['popup_check']  = $this->Preferences_model->popup_check('show_popup');
		$this->load->view('popup',$this->data);
	}
	
	public function showchart(){
		$data['page_title'] 	= 'Chart';
		$data['page_heading'] 	= 'Chart';
		$data['charts']			= $this->Users_model->getAllDataFromCharts();
		$html = "";
		$ids  = array();
		
		$ids[] = 'main0';
		$html.='
			main0 = {
				text: {
					name: "Main",
				},
				HTMLid: "main0",
				width:"10px"
			},';
		$parent_id = "main0";
		$i = 0;
		foreach($data['charts'] as $row){
			$i++;
			$ids[] = 'ceo'.$row->id;
			$ids[] = 'child'.$row->id;
			if($i==1){
				$html.='
				ceo'.$row->id.' = {
					parent:'.$parent_id.',
					text: {
						name: "'.$row->from_entity.'",
						title: "Send Amount:'.$row->amount.'",
					},
					HTMLid: "ceo'.$row->id.'"
				},';
				$html.='child'.$row->id.' = {
						parent: ceo'.$row->id.',
						text:{
							name: "'.$row->to_entity.'",
							title: "Receive Amount:'.$row->amount.'",
						},
						stackChildren: true,
						HTMLid: "child'.$row->id.'"
					},';
				$parent_id = "main0";
			}else{
				$parent_id = "main0";
				$html.='ceo'.$row->id.' = {
						parent:'.$parent_id.',
						text:{
							name: "'.$row->from_entity.'",
							title: "Receive Amount:'.$row->amount.'",
						},
						stackChildren: true,
						HTMLid: "child'.$row->id.'"
					},';
				$html.='child'.$row->id.' = {
						parent: ceo'.$row->id.',
						text:{
							name: "'.$row->to_entity.'",
							title: "Receive Amount:'.$row->amount.'",
						},
						stackChildren: true,
						HTMLid: "child'.$row->id.'"
					},';
				$parent_id = 'ceo'.$row->id;
			}
		}
		$html = trim($html,',');
		$data['charts_data'] = $html;
		$data['ids'] = implode(',',$ids);
		$parser['content']		= $this->load->view('chart',$data);
	}
	
	public function rss_feeds(){
		/***** Rss Feed ******/
		if($this->input->get('id')){
			$link = $this->Common_model->getFeedLinkByID($this->input->get('id'));
			$rss_array = array();
			$this->load->library('rssparser');
			$rss_data = $this->rssparser->set_feed_url($link)->set_cache_life(30)->getFeed(10);
			//print_r($rss_data); die;
			foreach($rss_data as $row){
				$html = $row['description'];
				preg_match('@src="([^"]+)"@',$html,$match);
				$src 			= array_pop($match);
				$row['image'] 	= $src;
				$rss_array[] 	= $row;
			}
			//print_r($rss_array); die;
			$html = "<div class='m-b-sm text-md'>".ucwords(str_replace('_', " ", $this->input->get('name')))."</div>";
			$html .= "<ul class='list-group no-bg no-borders pull-in'>\n";
                    $i=0;foreach($rss_array as $row){
						if($row['image']!=''){
							$html .= "<li class='list-group-item'>\n";
								$html .= "<a herf='".$row['link']."' class='pull-left thumb-sm m-r' style='width:60px' target='_blank'><img src='".$row['image']."' style='width:300px; !important'></a>\n";							
								$html .="<div class='clear'>";
								$html .="<div><a href='".$row['link']."' target='_blank'>".substr($row['title'],0,50)."</a></div>";
								$html .="</div>";
							$html .= "</li>";
						}else{
							$html .= "<li class='list-group-item'>\n";
								$html .="<div class='clear'>";
								$html .="<div><a href='".$row['link']."' target='_blank'>".substr($row['title'],0,50)."</a></div>";
								$html .="</div>";
							$html .= "</li>";

						}
                     }
           $html .="</ul>";
		   echo $html;  
		}
	}
}