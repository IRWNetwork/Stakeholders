<?php
class Common_model extends CI_Model
{
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('image_lib');
        $this->gallery_path = realpath(APPPATH . '../uploads');
    }
	
	function getUrl($row){
		if($this->ion_auth->logged_in()){
			$user_row = $this->ion_auth->user()->row();
			$url = "";
			
			
			if($this->ion_auth->get_users_groups($row->user_id)->row()->id == 3 && !($this->Users_model->checkAlreadyBuy($row->user_id))){
					
				$url = site_url('user/channelsubscription/'.$row->user_id);
			}
			else if($row->is_premium){
				if($user_row->is_premium=='yes'){
					if($row->type=='Video'){
						$url = site_url('home/playvideo/?id='.$row->id);
					}else if($row->type=='Text'){
						$url = site_url('home/showArticle/?id='.$row->id);
					}else{
						$url = "javascript:void(0)";
					}
				}else{
					$url = site_url('user/upgradepackage');
				}
			}else{
				if($row->type=='Video'){
					$url = site_url('home/playvideo/?id='.$row->id);
				}else if($row->type=='Text'){
					$url = site_url('home/showArticle/?id='.$row->id);
				}else{
					$url = "javascript:void(0)";
				}
			}
		}else{
			if($row->is_premium){
				$url = site_url('user/login/');
			}else{
				if($row->type=='Video'){
					$url = site_url('home/playvideo/?id='.$row->id);
				}else if($row->type=='Text'){
					$url = site_url('home/showArticle/?id='.$row->id);
				}else{
					$url = "javascript:void(0)";
				}
			}
		}
		return $url;
	}
	
	function getDate($date){
		
		$date = date('m/d/Y', strtotime($date));
	
		if($date == date('m/d/Y')) {
			$date = 'Today';
		} 
		else if($date == date('m/d/Y',time() - (24 * 60 * 60))) {
			$date = 'Yesterday';
		}
		return $date;
	}
	
	function generateThumb($imgPath, $dimentions,$destinationFile = '') {
		if($destinationFile != ''){
			$config['new_image']	= $destinationFile;
			$config['thumb_marker']	= '';
		}
		$config['image_library'] = 'gd2';
		$config['source_image']	= $imgPath;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		if($dimentions[0]!=''){
			$config['width'] = $dimentions[0];
		}
		if($dimentions[1]!=''){
			$config['height'] = $dimentions[1];
		}
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		
	}
	
	function generateThumbWithOutRation($imgPath, $dimentions,$destinationFile = '') {
		if($destinationFile != ''){
			$config['new_image']	= $destinationFile;
			$config['thumb_marker']	= '';
		}
		$config['image_library'] = 'gd2';
		$config['source_image']	= $imgPath;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = FALSE;
		if($dimentions[0]!=''){
			$config['width'] = $dimentions[0];
		}
		if($dimentions[1]!=''){
			$config['height'] = $dimentions[1];
		}
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		
	}
	
    function uploadFile2($file_name, $field, $path) {
		if($_FILES[$field]['error']!= 0) {
			return $this->upload->display_errors();
		 }
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '50000';
		$config['file_name'] = $file_name;
	    $this->load->library('upload', $config);
		if( !$this->upload->do_upload($field) ) {
			return $this->upload->display_errors();
		} else {
			$fileInfo = $this->upload->data();
			$filePath = $path.$file_name;
			$this->generateThumb($filePath, array(200,''),'thumb_200_'.$file_name);
			//$this->generateThumb($filePath, array(150, 150),'thumb_150_'.$file_name);
			//$this->generateThumb($filePath, array(100, 100),'thumb_100_'.$file_name);
			
			$selected_thumb = $path.'thumb_400_'.$file_name;
			list($width, $height) = getimagesize($selected_thumb);
			if($height>300){
				$selected_thumb = $path.'thumb_150_'.$file_name;	
			}
			
			//$this->generateThumb2($selected_thumb, 50,50,50,50, 'thumb_50_'.$file_name);
			//$this->session->set_userdata('picCroped', 'thumb_50_'.$file_name);
			//$this->generateThumb($filePath, array(50, 50),'thumb_50_'.$file_name);
			
		}
		return true;
	}
    function uploadImageAndResize($picname,$path,$new_width,$new_height){
    	
    	$config['upload_path']   = $path; //'uploads/data/';
		$config['allowed_types'] = 'jpeg|jpg|png|JPG|JPEG|PNG';
		$config['max_size'] 	 = '1000000';
		$config['file_name']     = $picname;  // 'sliderimage_' . time() 
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')){
			
			$image_details  = $this->upload->data();
			$picture_name 	= $image_details['file_name'];
			
			$filename = $picture_name;
		    $config = array(
			    'source_image'      => $image_details['full_path'], //path to the uploaded image
			    'new_image'         => 'uploads/data/', //path to
			    'maintain_ratio'    => true,
			    'width'             => $new_width,
			    'height'            => $new_height
		    );
		    $this->image_lib->initialize($config);
		    $error="";
    		if ( ! $this->image_lib->resize()){
    			$error = $this->image_lib->display_errors();
    			return false;
			}else{
				$this->image_lib->clear();
				return $picture_name;	
			}
		    // clear //
		}else{
			return false;
		}
    }
	
	function uploadImage($picname,$path){
    	
    	$config['upload_path']   = $path; //'uploads/data/';
		$config['allowed_types'] = 'jpeg|jpg|png|JPG|JPEG|PNG';
		$config['max_size'] 	 = '1000000';
		$config['file_name']     = $picname;  // 'sliderimage_' . time() 
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')){
			
			$image_details  = $this->upload->data();
			$picture_name 	= $image_details['file_name'];
					
			return $picture_name;
		}else{
			return false;
		}
    }
	
	function uploadImageByFieldName($field_name,$picname,$path){
    	
    	$config['upload_path']   = $path; //'uploads/data/';
		$config['allowed_types'] = 'jpeg|jpg|png|JPG|JPEG|PNG';
		$config['max_size'] 	 = '1000000';
		$config['file_name']     = $picname;  // 'sliderimage_' . time() 
		$this->load->library('upload', $config);
		if ($this->upload->do_upload($field_name)){
			
			$image_details  = $this->upload->data();
			$picture_name 	= $image_details['file_name'];
					
			return $picture_name;
		}else{
			return false;
		}
    }
	
	
    function uploadImageAndThumbNail($picname,$path,$new_width,$new_height){
    	$config['upload_path']   = $path; //'uploads/data/';
		$config['allowed_types'] = 'jpeg|jpg|png|JPG|JPEG|PNG';
		$config['max_size'] 	 = '1000000';
		$config['file_name']     = $picname;  // 'sliderimage_' . time()
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')){
			
			$image_details  = $this->upload->data();
			$picture_name 	= $image_details['file_name'];
			
			$filename = $picture_name;
		    $config = array(
			    'source_image'      => $image_details['full_path'], //path to the uploaded image
			    'new_image'         => 'uploads/data/thumb/', //path to
			    'maintain_ratio'    => true,
			    'width'             => $new_width,
			    'height'            => $new_height
		    );
		    $this->image_lib->initialize($config);
		    $error="";
    		if ( ! $this->image_lib->resize()){
    			$error = $this->image_lib->display_errors();
    			return false;
			}else{
				$this->image_lib->clear();
				return $picture_name;	
			}
		    // clear //
		}else{
			return false;
		}
    }
    public function upload_admin_file($name,$path,$field_name) {
    	$config['upload_path']   = $path; //'uploads/data/';
		$config['allowed_types'] = 'jpeg|jpg|png|JPG|JPEG|PNG';
		$config['max_size'] 	 = '1000000';
		$config['file_name']     = $name;  // 'sliderimage_' . time()
		
		$this->load->library('upload', $config);
		if ($this->upload->do_upload($field_name)){
			$image_details  = $this->upload->data();
			//echo "<pre>"; print_r($image_details);exit;
			$file_name 	= $image_details['file_name'];
			return $file_name;
		}else{
			return false;
		}
    }
    public function uploadFile($name,$path,$field_name){
    	$config['upload_path']   = $path; //'uploads/data/';
		$config['allowed_types'] = 'mkv|ogv|ogg|m4v|wmv|avi|mp3|flv|mp4|doc|docx|pdf|csv|ppt|pptx|jpeg|jpg|png|JPG|JPEG|PNG|rv|wav|mpeg|mpg|mov|avi|mp3|mp4|Svlc';
		$config['max_size'] 	 = '10000000';
		$config['file_name']     = $name;  // 'sliderimage_' . time()
		
		$this->load->library('upload', $config);
		if ($this->upload->do_upload($field_name)){
			$image_details  = $this->upload->data();
			//echo "<pre>"; print_r($image_details);exit;
			$image_sizes = array(
		        'listing' => array(150, 150),
		        'admin_listing' => array(100, 100),
		        'featured' => array(270, 270),
		        'detail_page' => array(400, 400),
		        'player_image' => array(43, 43),
		    );
			
		    /*$this->load->library('image_lib');
			foreach ($image_sizes as $key => $resize) {

			    $config = array(
			        'source_image' => $image_details['full_path'],
			        'new_image' => $this->gallery_path . "/".$key."/" . $image_details['raw_name'].$image_details['file_ext'],
			        'maintain_ration' => true,
			        'width' => $resize[0],
			        'height' => $resize[1]
			    );
			    //echo "<pre>"; print_r($config);exit;
			    $this->image_lib->initialize($config);
			    $this->image_lib->resize();
			    $this->image_lib->clear();
			    //exit;
			}*/
			$file_name 	= $image_details['file_name'];
			return $file_name;
		}else{
			return false;
		}
    }

	    public function convert_images() {
			//echo "hi";exit;
			$this->db->select('contents.picture');
			$query = $this->db->get('contents');
			//echo $this->db->last_query();exit;
			$results = $query->result_array();
			//echo "<pre>"; print_r($results);exit;
			$image_sizes = array(
	        'listing' => array(150, 150),
	        'admin_listing' => array(100, 100),
	        'featured' => array(270, 270),
	        'detail_page' => array(400, 400),
	        'player_image' => array(43, 43),
	    );
		foreach ($results as $key => $result) {
			$source_image = $result['picture'];
			$image_details = explode('.', $source_image);
			foreach ($image_sizes as $key => $resize) {

		    $config = array(
		        'source_image' => $this->gallery_path.'/files/'.$source_image,
		        'new_image' => $this->gallery_path . "/".$key."/" . $image_details[0].'.'.$image_details[1],
		        'maintain_ration' => true,
		        'width' => $resize[0],
		        'height' => $resize[1]
		    );
		    //echo $config['source_image'];exit;
		    //echo "<pre>"; print_r($config);exit;
		    $this->image_lib->initialize($config);
		    $this->image_lib->resize();
		    $this->image_lib->clear();
		    }
		}
				//echo "<pre>"; print_r();exit;
		}
	
	 public function uploadsenderFile($name,$path){
    	$config['upload_path']   = $path; //'uploads/data/';
		$config['allowed_types'] = 'mkv|ogv|ogg|m4v|wmv|avi|mp3|flv|mp4|doc|docx|pdf|csv|ppt|pptx|jpeg|jpg|png|JPG|JPEG|PNG|rv|wav|mpeg|mpg|mov|avi|mp3|mp4|Svlc|wav|mp3|doc|docx|pdf|ppt|pptx|txt|abw|acl';
		$this->db->select('value');
		$this->db->where('name','file_size_limit');
		$query= $this->db->get('preferences');
		$row = $query->result_array();
		
		$config['max_size'] 	 = (!empty($row[0]['value']))?$row[0]['value']*1000000:'1000000';
		$config['file_name']     = $name;  // 'sliderimage_' . time()
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')){
			$image_details  = $this->upload->data();
			$file_name 	= $image_details['file_name'];
			return $file_name;
		}else{
			return false;
		}
    }
	public function decryptIt( $q ) {
	    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
	    $qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
	    return( $qDecoded );
	}
	public function encryptIt( $q ) {
	    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
	    $qEncoded  = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
	    return( $qEncoded );
	}
	public function convertJqueryDateToSqlDate($date){
		$time_array = array(
						'00:00'=> 'AM 0:00',
						'00:10'=> 'AM 0:10',
						'00:20'=> 'AM 0:20',
						'00:30'=> 'AM 0:30',
						'00:40'=> 'AM 0:40',
						'00:50'=> 'AM 0:50',
						'01:00'=> 'AM 1:00',
						'01:10'=> 'AM 1:10',
						'01:20'=> 'AM 1:20',
						'01:30'=> 'AM 1:30',
						'01:40'=> 'AM 1:40',
						'01:50'=> 'AM 1:50',
						'02:00'=> 'AM 2:00',
						'02:10'=> 'AM 2:10',
						'02:20'=> 'AM 2:20',
						'02:30'=> 'AM 2:30',
						'02:40'=> 'AM 2:40',
						'02:50'=> 'AM 2:50',
						'03:00'=> 'AM 3:00',
						'03:10'=> 'AM 3:10',
						'03:20'=> 'AM 3:20',
						'03:30'=> 'AM 3:30',
						'03:40'=> 'AM 3:40',
						'03:50'=> 'AM 3:50',
						'04:00'=> 'AM 4:00',
						'04:10'=> 'AM 4:10',
						'04:20'=> 'AM 4:20',
						'04:30'=> 'AM 4:30',
						'04:40'=> 'AM 4:40',
						'04:50'=> 'AM 4:50',
						'05:00'=> 'AM 5:00',
						'05:10'=> 'AM 5:10',
						'05:20'=> 'AM 5:20',
						'05:30'=> 'AM 5:30',
						'05:40'=> 'AM 5:40',
						'05:50'=> 'AM 5:50',
						'06:00'=> 'AM 6:00',
						'06:10'=> 'AM 6:10',
						'06:20'=> 'AM 6:20',
						'06:30'=> 'AM 6:30',
						'06:40'=> 'AM 6:40',
						'06:50'=> 'AM 6:50',
						'07:00'=> 'AM 7:00',
						'07:10'=> 'AM 7:10',
						'07:20'=> 'AM 7:20',
						'07:30'=> 'AM 7:30',
						'07:40'=> 'AM 7:40',
						'07:50'=> 'AM 7:50',
						'08:00'=> 'AM 8:00',
						'08:10'=> 'AM 8:10',
						'08:20'=> 'AM 8:20',
						'08:30'=> 'AM 8:30',
						'08:40'=> 'AM 8:40',
						'08:50'=> 'AM 8:50',
						'09:00'=> 'AM 9:00',
						'09:10'=> 'AM 9:10',
						'09:20'=> 'AM 9:20',
						'09:30'=> 'AM 9:30',
						'09:40'=> 'AM 9:40',
						'09:50'=> 'AM 9:50',
						'10:00'=> 'AM 10:00',
						'10:10'=> 'AM 10:10',
						'10:20'=> 'AM 10:20',
						'10:30'=> 'AM 10:30',
						'10:40'=> 'AM 10:40',
						'10:50'=> 'AM 10:50',
						'11:00'=> 'AM 11:00',
						'11:10'=> 'AM 11:10',
						'11:20'=> 'AM 11:20',
						'11:30'=> 'AM 11:30',
						'11:40'=> 'AM 11:40',
						'11:50'=> 'AM 11:50',
						'12:00'=> 'PM 12:00',
						'12:10'=> 'PM 12:10',
						'12:20'=> 'PM 12:20',
						'12:30'=> 'PM 12:30',
						'12:40'=> 'PM 12:40',
						'12:50'=> 'PM 12:50',
						'13:00'=> 'PM 1:00',
						'13:10'=> 'PM 1:10',
						'13:20'=> 'PM 1:20',
						'13:30'=> 'PM 1:30',
						'13:40'=> 'PM 1:40',
						'13:50'=> 'PM 1:50',
						'14:00'=> 'PM 2:00',
						'14:10'=> 'PM 2:10',
						'14:20'=> 'PM 2:20',
						'14:30'=> 'PM 2:30',
						'14:40'=> 'PM 2:40',
						'14:50'=> 'PM 2:50',
						'15:00'=> 'PM 3:00',
						'15:10'=> 'PM 3:10',
						'15:20'=> 'PM 3:20',
						'15:30'=> 'PM 3:30',
						'15:40'=> 'PM 3:40',
						'15:50'=> 'PM 3:50',
						'16:00'=> 'PM 4:00',
						'16:10'=> 'PM 4:10',
						'16:20'=> 'PM 4:20',
						'16:30'=> 'PM 4:30',
						'16:40'=> 'PM 4:40',
						'16:50'=> 'PM 4:50',
						'17:00'=> 'PM 5:00',
						'17:10'=> 'PM 5:10',
						'17:20'=> 'PM 5:20',
						'17:30'=> 'PM 5:30',
						'17:40'=> 'PM 5:40',
						'17:50'=> 'PM 5:50',
						'18:00'=> 'PM 6:00',
						'18:10'=> 'PM 6:10',
						'18:20'=> 'PM 6:20',
						'18:30'=> 'PM 6:30',
						'18:40'=> 'PM 6:40',
						'18:50'=> 'PM 6:50',
						'19:00'=> 'PM 7:00',
						'19:10'=> 'PM 7:10',
						'19:20'=> 'PM 7:20',
						'19:30'=> 'PM 7:30',
						'19:40'=> 'PM 7:40',
						'19:50'=> 'PM 7:50',
						'20:00'=> 'PM 8:00',
						'20:10'=> 'PM 8:10',
						'20:20'=> 'PM 8:20',
						'20:30'=> 'PM 8:30',
						'20:40'=> 'PM 8:40',
						'20:50'=> 'PM 8:50',
						'21:00'=> 'PM 9:00',
						'21:10'=> 'PM 9:10',
						'21:20'=> 'PM 9:20',
						'21:30'=> 'PM 9:30',
						'21:40'=> 'PM 9:40',
						'21:50'=> 'PM 9:50',
						'22:00'=> 'PM 10:00',
						'22:10'=> 'PM 10:10',
						'22:20'=> 'PM 10:20',
						'22:30'=> 'PM 10:30',
						'22:40'=> 'PM 10:40',
						'22:50'=> 'PM 10:50',
						'23:00'=> 'PM 11:00',
						'23:10'=> 'PM 11:10',
						'23:20'=> 'PM 11:20',
						'23:30'=> 'PM 11:30',
						'23:40'=> 'PM 11:40',
						'23:50'=> 'PM 11:50',
					);
		$date_array = explode(" ",$date);
		$key = array_search($date_array[1]." ".$date_array[2],$time_array);
		return $date_array[0]." ".$key;
	}
	function getStatesArray(){
		$states=array(
			'AL'=>'Alabama',
			'AK'=>'Alaska',
			'AZ'=>'Arizona',
			'AR'=>'Arkansas',
			'CA'=>'California',
			'CO'=>'Colorado',
			'CT'=>'Connecticut',
			'DE'=>'Delaware',
			'DC'=>'District of Columbia',
			'FL'=>'Florida',
			'GA'=>'Georgia',
			'HI'=>'Hawaii',
			'ID'=>'Idaho',
			'IL'=>'Illinois',
			'IN'=>'Indiana',
			'IA'=>'Iowa',
			'KS'=>'Kansas',
			'KY'=>'Kentucky',
			'LA'=>'Louisiana',
			'ME'=>'Maine',
			'MD'=>'Maryland',
			'MA'=>'Massachusetts',
			'MI'=>'Michigan',
			'MN'=>'Minnesota',
			'MS'=>'Mississippi',
			'MO'=>'Missouri',
			'MT'=>'Montana',
			'NE'=>'Nebraska',
			'NV'=>'Nevada',
			'NH'=>'New Hampshire',
			'NJ'=>'New Jersey',
			'NM'=>'New Mexico',
			'NY'=>'New York',
			'NC'=>'North Carolina',
			'ND'=>'North Dakota',
			'OH'=>'Ohio',
			'OK'=>'Oklahoma',
			'OR'=>'Oregon',
			'PA'=>'Pennsylvania',
			'RI'=>'Rhode Island',
			'SC'=>'South Carolina',
			'SD'=>'South Dakota',
			'TN'=>'Tennessee',
			'TX'=>'Texas',
			'UT'=>'Utah',
			'VT'=>'Vermont',
			'VA'=>'Virginia',
			'WA'=>'Washington',
			'WV'=>'West Virginia',
			'WI'=>'Wisconsin',
			'WY'=>'Wyoming'
		);
		return $states;
	}
	
	function getCountriesArray(){
		
		return $countries;
	}
	
	public function checkAlreadyBuy($id){
		$this->db->select('*');
		$this->db->where('channel_id',$id);
		$this->db->where('status','active');
		$this->db->where('user_id',$this->ion_auth->get_user_id());
		$this->db->where('next_recharge_date >=',date('Y-m-d'));
		$query = $this->db->get('channel_subscription');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			
			return true;	
		}
		return false;
	}
	public function getFeedLinkByID($id){
		$query  = "SELECT link from news_feeds where id= '$id'";
		$result = $this->db->query($query);
		$row    = $result->result();
		return $row[0]->link;
	}
}
?>
