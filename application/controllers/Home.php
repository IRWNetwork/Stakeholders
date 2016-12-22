<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller
{
	function __construct()
    {
        parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Common_model');
		$this->load->model('Emailtemplates_model');
		$this->load->model('Content_model');
		$this->load->library("pagination");
		$this->load->library('ion_auth');
		$this->load->model('Events_model');
    }
    
	public function audio()
	{
		$data['page_title'] 	= 'Home';
		$data['page_heading'] 	= 'Home';
		
		
		$search 			   = $this->input->get('search')?$this->input->get('search'):"";
        $arr['name']           = $search;
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

	public function index()
	{
		$data['page_title'] 	= 'Home';
		$data['page_heading'] 	= 'Home';
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
		$data['contents']	= $this->Content_model->getAllData($arr,$page,$config["per_page"]);
		$data['contents1']	= $this->Content_model->getAudio($arr,$page,$config["per_page"]);
		$data['featured']	= $this->Content_model->getFeaturedData($arr);
		
		
		//$data['audio']=$this->output->set_content_type('application/json')->set_output(json_encode($data['contents1']));
		$data["links"]   = $this->pagination->create_links();
        $parser['content']		=  $this->load->view('main',$data,TRUE);
        $this->parser->parse('template', $parser);
	}
	
	public function playvideo(){
	
		$id = $this->input->get('id');
		$video_row = $this->Content_model->getRow($id);

		$data['video_row']		= $video_row;
		$data['page_title'] 	= $video_row['title'];
		$data['page_heading'] 	= $video_row['title'];
		$data['featuredcontent']	= $this->Content_model->getFeaturedData(array());
		
		$parser['content']		=  $this->load->view('playvideo',$data,TRUE);
        $this->parser->parse('template', $parser);
	}
	
	public function showArticle(){
		
		$id = $this->input->get('id');
		$article_row = $this->Content_model->getRow($id);

		$data['article_row']	= $article_row;
		$data['page_title'] 	= $article_row['title'];
		$data['page_heading'] 	= $article_row['title'];
		$data['featuredcontent']	= $this->Content_model->getFeaturedData(array());
		
		$parser['content']		=  $this->load->view('article-detail',$data,TRUE);
        $this->parser->parse('template', $parser);
	}

	public function map()
	{
		$data['page_title'] 	= 'Map';
		$data['page_heading'] 	= 'Map';
		
		$events	   		= $this->Events_model->getAllEvents();
		$new_array = array();
		foreach($events as $event){

			$event['date'] = date("m/d/Y",strtotime($event['start_date']));
			$event['time'] = date("h:i a",strtotime($event['start_date']));
			$new_array[] = $event;

		}
		$data['events'] 		= json_encode($new_array);
		$data['categories']	   	= $this->Events_model->getAllCategories();
		$parser['content']		= $this->load->view('map/map-view',$data,TRUE);
        $this->parser->parse('template', $parser);
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
		$this->session->set_userdata(array('websiteloaded'=>'yes'));
		$data['page_title'] 	= 'Popup';
		$data['page_heading'] 	= 'Popup';
		$parser['content']		=  $this->load->view('popup',$data);		
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
}