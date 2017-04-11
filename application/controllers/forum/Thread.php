<?php

class Thread extends MY_Controller {
    public $data         = array();
    public $page_config  = array();
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('forum/Thread_model');
        $this->load->model('forum/User_model');
		$this->load->model('Content_model');
		$this->load->model('forum/Admin_model');
		$this->load->library("pagination");
        $this->User_model->check_role();
    }
    
    public function index($start = 0)
    {
        $this->page_config['base_url']    = site_url('forum/thread/index/');
        $this->page_config['uri_segment'] = 4;
        $this->page_config['total_rows']  = $this->db->count_all('cibb_threads');;
        $this->page_config['per_page']    = 10;
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
        
        $this->data['type']    = 'index';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['threads'] = $this->Thread_model->get_all($start, $this->page_config['per_page']);
        $this->data['page_title']   = "IRW Network :: Forum";
		$this->data['bannerDetail'] = $this->Content_model->getBannerRowByField("page","ruler_forums");
		$parser['content']		 =  $this->load->view('forum/thread/index',$this->data,true);
        $this->parser->parse('template', $parser);
    }
    
    public function create()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect(site_url('/user/login'), 'refresh');
        } /*else if ($this->session->userdata('thread_create') == 0) {
            redirect('forum/thread');
        }*/
        if ($this->input->post('btn-create')) {
            $this->Thread_model->create();
            if ($this->Thread_model->error_count != 0) {
                $this->data['error']    = $this->Thread_model->error;
		
            } else {
                $this->session->set_userdata('tmp_success_new', 1);
                redirect('forum/thread/talk/'.$this->Thread_model->fields['slug']);
            }
        }
        $this->data['categories'] = $this->Admin_model->category_get_all();
        $this->data['page_title']  = ' Thread Create '.CIBB_TITLE;
		$parser['content']		 =  $this->load->view('forum/thread/create',$this->data,true);
        $this->parser->parse('template', $parser);
    }
    
    public function set_pagination()
    {
        $this->page_config['first_link']         = '&lsaquo; First';
        $this->page_config['first_tag_open']     = '<li>';
        $this->page_config['first_tag_close']    = '</li>';
        $this->page_config['last_link']          = 'Last &raquo;';
        $this->page_config['last_tag_open']      = '<li>';
        $this->page_config['last_tag_close']     = '</li>';
        $this->page_config['next_link']          = 'Next &rsaquo;';
        $this->page_config['next_tag_open']      = '<li>';
        $this->page_config['next_tag_close']     = '</li>';
        $this->page_config['prev_link']          = '&lsaquo; Prev';
        $this->page_config['prev_tag_open']      = '<li>';
        $this->page_config['prev_tag_close']     = '</li>';
        $this->page_config['num_tag_open']       = '<li>';
        $this->page_config['num_tag_close']      = '</li>';
    }
    
    public function talk($slug, $start = 0)
    {
		$slug = urldecode($slug);
		
        if ($this->input->post('btn-post')) {
            if (!$this->ion_auth->user()->row()->id) {
                redirect('user/login');
            }/* else if ($this->session->userdata('thread_create') == 0) {
                redirect('forum/thread');
            }*/
            
            
            $this->Thread_model->reply();
            if ($this->Thread_model->error_count != 0) {
                $this->data['error']    = $this->Thread_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('forum/thread/talk/'.$slug.'/'.$start);
            }
        }
        
        $tmp_success_new = $this->session->userdata('tmp_success_new');
        if ($tmp_success_new != NULL) {
            // new thread created
            $this->session->unset_userdata('tmp_success_new');
            $this->data['tmp_success_new'] = 1;
        }
        
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new post on a thread created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $thread = $this->db->get_where(TBL_THREADS, array('slug' => $slug))->row();
		//echo $this->db->last_query(); die();
        //print_r($thread); die();
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('forum/thread/talk/'.$slug);
        $this->page_config['uri_segment'] = 4;
        $this->page_config['total_rows']  = $this->db->get_where(TBL_POSTS, array('thread_id' => $thread->id))->num_rows();
		//echo $this->db->last_query(); die();
        $this->page_config['per_page']    = 10;
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
        
        $posts  = $this->Thread_model->get_posts($thread->id, $start, $this->page_config['per_page']);
		//print_r($posts); die();
        //$this->Thread_model->get_posts_threaded($thread->id, $start, $this->page_config['per_page']);
        $this->load->model('Admin_model');
        $this->data['cat']    = $this->Admin_model->category_get_all_parent($thread->category_id, 0);
        
        $this->data['categories']    = $this->Admin_model->category_get_all();
		$this->data['page_title']    = $thread->title.' :: Thread ';
        $this->data['page']          = $this->pagination->create_links();
        $this->data['thread']        = $thread;
        $this->data['posts']         = $posts;
        $parser['content']		   =  $this->load->view('forum/thread/talk',$this->data,true);
        $this->parser->parse('template', $parser);
    }
    
    public function category($slug, $start = 0)
    {
        $category = $this->db->get_where(TBL_CATEGORIES, array('slug' => $slug))->row();
        $this->data['cat']    = $this->Admin_model->category_get_all_parent($category->id, 0);
        $this->data['thread'] = $category;
        
        $cat_id = array();
        $child_cat = $this->Admin_model->category_get_all($category->id);
        $cat_id[0] = $category->id;
        foreach ($child_cat as $cat) {
            $cat_id[] = $cat['id'];
        }
        
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('forum/thread/category/'.$slug);
        $this->page_config['uri_segment'] = 4;
        $this->page_config['total_rows']  = $this->Thread_model->get_total_by_category($cat_id);
        $this->page_config['per_page']    = 10;
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
        
        $this->data['page']    = $this->pagination->create_links();
       
        $this->data['threads'] = $this->Thread_model->get_by_category($start, $this->page_config['per_page'], $cat_id);
        
        $this->data['type']         = 'category';
        $this->data['page_title']   = 'Category :: '.$category->name;
       
		
		$parser['content']		 =  $this->load->view('forum/thread/index',$this->data,true);
        $this->parser->parse('template', $parser);
    }
}
