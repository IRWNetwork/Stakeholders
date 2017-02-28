<?php

class Zone_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'zones';
    }

    public function getAll() {
		$this->db->select('*');
		$query = $this->db->get('zones');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
    }

    public function getAllbookings($id) {
        $this->db->select('bookings.*');
        $this->db->select('banners.*');
        $this->db->from('bookings');
        $this->db->join('banners', 'banners.id = bookings.bannerid');
        $this->db->where("zoneid",$id);

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if($query->num_rows())
        {
            return $query->result();
        }
        return array();

    }

    public function getAdvertisers() {
        $this->db->select('*');
        $query = $this->db->get('advertisers');
        if($query->num_rows())
        {
            return $query->result();
        }
        return array();
    }

    public function getAdvertiserbanner($id) {
        $sql   =  $this->db->where("advertiserid",$id);
        $query  =  $this->db->get('banners');
        //$this->db->last_query();  
        if ($query->num_rows()) {
            $row = $query->result_array();
            return $row;
        }
        return array();
    }

    public function saveBooking($data) {

        $this->db->where('bannerid',$data['bannerid']);
        $query = $this->db->get('bookings');
        if ($query->num_rows() > 0){
            $this->session->set_flashdata(
                    'error',
                    "Already Added"
            );
            redirect(base_url()."admin/zones/linked_banners/".$_POST['zoneid']);
        }
        else {
            $this->db->insert('bookings',$data);
            return $this->db->insert_id();
        }
    }

    public function unlinkBanner($id) {
        $this->db->delete('bookings', array('bannerid' => $id)); 
    }

    public function addZone($data) {
    	echo "<pre>"; print_r($data);exit;
    }

    public function jsServercode ($zoneid) {
        $zoneid = intval($_REQUEST['zoneid']);
        $referer = $_REQUEST['referer'];
        $location = $_REQUEST['location'];
        
        if ( $zoneid > 0 ) { // && $location!=''){
            $query = "select * from bookings where zoneid=$zoneid and status='active' and impressions_booked > impressions_performed and clicks_booked > clicks_performed";
            $query = $this->db->query($query);
            $result = $query->result_array();
            
            $bookings=array();
            foreach ($result as  $row) {
                extract($row);
                if($weight<1) $weight=1;
                $bookings[]=array('bannerid'=>$bannerid,'weight'=>$weight,'width'=>$width,'height'=>$height);
            }
            $banners_found = count($bookings);

            $sum = 0;
            foreach ($bookings as $key => $value) {
                $sum+= intval($value['weight']);
            }
            $x=rand(1,$sum);
        
            $sum = 0; 
            $index = -1;
            reset($bookings);
            foreach ($bookings as $key=>$value) {
                $index++;
                $sum+= intval($value['weight']);
                if($x <= $sum){
                    break;
                }
            }
            $query= "select * from banners where serial=".intval($bookings[$index]['bannerid']);
            $query = $this->db->query($query);
            $row = $query->row();

            if ($row) {
                
                $width = intval($row['width']);
                $height = intval($row['height']);
                
                $url = $row['url'];
                $clickid = $row['serial'];
                $click_url = $this->ckScript($clickid, $zoneid);

                $target = $row['target'];
                if ($_SERVER["HTTPS"] == "on") {
                    $path = "https://".$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/banners/".$row['path'];
                }else{
                    $path = "http://".$_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']))."/banners/".$row['path'];
                }
                $alt = $row['alt_text'];
                $adsense_code = $row['adsense_code'];
                
                if ($row['type'] == 'image'){
                    echo 'document.write(\'<div style="width:'.$width.'px;height='.$height.'px"><a href="'.$click_url.'" target="'.$target.'" title="'.$alt.'"><img src="'.$path.'" alt="'.$alt.'" border="0" title="'.$alt.'" /></a></div>\');';
                }
                else if ($row['type'] == 'flash') {
                    echo 'document.write(\'<div style="width:'.$width.'px;height='.$height.'px"><object width="'.$width.'px" height="'.$height.'px"><param name="movie" value="'.$path.'"><embed src="'.$path.'" width="'.$width.'px" height="'.$height.'px"></embed></object></div>\')';
                }
                else if ($row['type'] == 'adsense') {
                    
                    $lines = explode("\n",$adsense_code);
                    foreach ($lines as $key=>$value) {
                        $value = str_replace("/","\\/",$value);
                        $value = str_replace("\r","",$value);
                        echo "document.writeln('".$value."');\r\n";
                    }
                }
                mysql_query("update bookings set impressions_performed=impressions_performed+1 where bannerid=".$row['serial']." and zoneid=$zoneid and status='active' and impressions_booked > impressions_performed");
            }
        }
    }

    public function ckScript($clickid, $zoneid) {
        $referer = trim($_SERVER['HTTP_REFERER']);
        $ip = $_SERVER['REMOTE_ADDR'];
        $time = time();
        $bannerid = intval($clickid);
        $zoneid = intval($zoneid);
        
        $query = $this->db->query("select url from banners where serial = $bannerid");
        $row = $query->row_array();

        $count_click = 0;
        if ($row) {
            if($referer !='' && $zoneid>0){
                $check_result = $this->db->query("select * from clicks where bannerid=$bannerid order by serial desc");
                $check_row = $check_result->result();
                if ($check_row) {
                    if ($check_row['ip'] == $ip) {
                        $time_elapsed = ($time-$check_row['time'])/60; // in minutes
                        if ($time_elapsed >= 60) {
                            $count_click = 1;
                        }
                    }
                    else {
                        $count_click = 1;
                    }
                }
                else {
                    $count_click = 1;
                }
                if ($count_click) {
                    $this->db->query("update bookings set clicks_performed=clicks_performed+1 where bannerid=$bannerid and zoneid=$zoneid and clicks_booked > clicks_performed and status='active'");
                    $this->db->query("insert into clicks values('',$bannerid,$time,'$ip','$referer',$zoneid)");
                }
                header("location:".$row['url']);
                exit();
            }
            else {
                echo '
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <meta http-equiv="refresh" content="5;url='.$row['url'].'">
                <title>Untitled Document</title>
                </head>

                <body style="background-color:#FFF;">
                    <h1>Redirecting to the site, Please wait ...</h1>
                </body>
                </html>';
            }
        }
    }

}

?>