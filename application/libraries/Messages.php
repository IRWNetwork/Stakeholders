<?php
class Messages {
	
	private $CI;
	private $user_id;
	public function Messages()
	{
        $CI =& get_instance(); 
		$this->CI = $CI;
		$this->CI->load->model('Messages_model');
		$this->CI->load->library('session');
		$this->CI->load->helper('url');
		$this->user_id = $this->CI->session->userdata('user_id');
	}
	
	function getPendingMessagesCount($type,$data=0)
	{
		$arr = array();
		$response = array();
		$arr['type']='';
		$arr['user_id']='';
        $arr['search']         = '';
        $arr['message_type']   = 'inbox';
		
		if($data){
			$arr['type'] 	   = $data['type'];
			$arr['user_id']	   = $data['user_id'];	
		}
		else{
			$arr['type'] 	= $this->CI->session->userdata('type');
			$arr['user_id']	= $this->CI->session->userdata('user_id');
		}
		if($arr['type'] == "translator" ){
			if($type=='text'){
	        	$total_rows = $this->CI->Messages_model->countAllPendingTranslatorMessages($arr,$arr['user_id'],'message_text',0);
			}
			else if($type=='document'){
				$total_rows = $this->CI->Messages_model->countAllPendingTranslatorMessages($arr,$arr['user_id'],'message_documents',0);
			}
		}else{
	        if($type=='text'){
	        	$total_rows = $this->CI->Messages_model->countPendingMessagesForLeftMenu($arr,$arr['user_id'],'message_text');
			}
			else if($type=='document'){
				$total_rows = $this->CI->Messages_model->countPendingMessagesForLeftMenu($arr,$arr['user_id'],'message_documents');
			}
		}
		return $total_rows;
	}
}
?>