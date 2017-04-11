<?php

class Admin extends CI_Controller {    
    public $data         = array();
    public $page_config  = array();
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('forum/Admin_model');
		$this->load->model('forum/User_model');
		$this->load->library('ion_auth');
		if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group(1)) {
			redirect(site_url('admin/'), 'refresh');
		}
     
    }
    
    // start category function
    public function category_create(){
		
		 $this->data['page_title']       = 'Add Thread Category';
		 $this->data['page_heading']     = 'Add Thread Category';
		
        if ($this->input->post('btn-create')) {
            $this->Admin_model->category_create();
            if ($this->Admin_model->error_count != 0) {
                $this->data['error']    = $this->Admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/forum/admin/category_create');
            }
        }
        
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new category created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $this->data['categories'] = $this->Admin_model->category_get_all();
		
		$parser['content']	   = $this->load->view('admin/forum/category_create',$this->data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }
    
    public function category_view(){
		$this->data['page_title']       = 'All Categories';
		$this->data['page_heading']     = 'All Categories';
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // role deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        
        $this->data['categories'] = $this->Admin_model->category_get_all();
		$parser['content']	   = $this->load->view('admin/forum/category_view',$this->data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }
    
    public function category_edit($category_id){
		$this->data['page_title']       = 'Edit Category';
		$this->data['page_heading']     = 'Edit Category';
        if ($this->input->post('btn-edit')) {
            $this->Admin_model->category_edit();
            if ($this->Admin_model->error_count != 0) {
                $this->data['error']    = $this->Admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/forum/admin/category_view/'.$category_id);
            }
        }
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new category created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        $this->data['category']   = $this->db->get_where(TBL_CATEGORIES, array('id' => $category_id))->row();
        $this->data['categories'] = $this->Admin_model->category_get_all();
		$parser['content']	   = $this->load->view('admin/forum/category_edit',$this->data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }
    
    public function category_delete($category_id)
    {
        $this->db->delete(TBL_CATEGORIES, array('id' => $category_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/forum/admin/category_view');
    }
    // end category function
    
	
    // start thread function
    public function thread_view($start = 0){
		
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/forum/admin/thread_view/');
        $this->page_config['uri_segment'] = 5;
        $this->page_config['total_rows']  = $this->db->count_all_results(TBL_THREADS);
        $this->page_config['per_page']    = 10;
        
        $this->pagination->initialize($this->page_config);
        
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // thread updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // thread deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        
        $this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
		
        $this->data['threads'] = $this->Admin_model->thread_get_all($start, $this->page_config['per_page']);
		$this->data['page_title']       = 'All Threads';
		$this->data['page_heading']     = 'All Threads';
		$parser['content']	   = $this->load->view('admin/forum/thread_view',$this->data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }
    
    public function thread_edit($thread_id){
		
        if ($this->input->post('btn-save'))
        {
            $this->Admin_model->thread_edit();
            if ($this->Admin_model->error_count != 0) {
                $this->data['error']    = $this->Admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/forum/admin/thread_view');
            }
        }
		
        $this->data['thread']  = $this->db->get_where(TBL_THREADS, array('id' => $thread_id))->row();
        $this->data['categories'] = $this->Admin_model->category_get_all();
		$this->data['page_title']       = 'Edit Thread';
		$this->data['page_heading']     = 'Edit Thread';
		$parser['content']	   = $this->load->view('admin/forum/thread_edit',$this->data,TRUE);
        $this->parser->parse('admin/template', $parser);
    }
    
    public function thread_delete($thread_id){
		
        // delete thread
        $this->db->delete(TBL_THREADS, array('id' => $thread_id));
        
        // delete all posts on this thread
        $this->db->delete(TBL_POSTS, array('thread_id' => $thread_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/forum/admin/thread_view');
    }
    // end thread function
}