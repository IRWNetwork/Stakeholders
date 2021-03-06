<?php

class Users_model extends CI_Model
{
	var $tablename = '';
  	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->tablename = 'users';
    }
	
	public function getAllDataFromCharts(){
		$this->db->limit(50,0);
		$query = $this->db->get('excel_fields');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	function addStripePackage($data,$user_id){
		$this->db->insert('stripe_plans',$data);
		$id = $this->db->insert_id();
		
		$query = "update stripe_plans set status='disable' where id<>$id and user_id=$user_id";
		$this->db->query($query);
		return $id;
	}
	
	function getActivePackageStripePlan($id){
		$this->db->where("user_id",$id);
		$this->db->where("status",'active');
		$query = $this->db->get('stripe_plans');
		if($query->num_rows()){
			$row = $query->row();
			return $row->stripe_plan_id;
		}
		return false;
	}
	
	function checkUserHaveIRWPackage($id,$cid){
		$query = "select * from channel_subscription where (user_id='".$id."' and channel_id='".$cid."') or (user_id='".$id."' and type='both') and status='active'";
		$query = $this->db->query($query);
		if($query->num_rows()>0)
		{
			return false;
		}
		return true;
	}
	
	function getCustomerIDByChannelID($id,$cid){
		$this->db->where("user_id",$id);
		$this->db->where("channel_id",$cid);
		$query = $this->db->get('customer_stripe_accounts');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			$row = $query->row();
			return $row->stripe_customer_id;
		}
		return "";
	}
	
	function addCustomerIDByChannelID($data){
		$this->db->insert('customer_stripe_accounts',$data);
		return $this->db->insert_id();
	}
	
	public function checkProducerPlanExist($id){
		$this->db->where("user_id",$id);
		$query = $this->db->get('stripe_plans');
		//echo $this->db->last_query();
		if($query->num_rows()>0)
		{
			return false;
		}
		return true;
	}
	
	public function getAllSubscribeUsersByChannelID($id){
		$this->db->where("channel_id",$id);
		$query = $this->db->get('channel_subscription');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	}
	
	function updatePackageOfUser($data,$id){
		$this->db->where('id', $id);
		$this->db->update('channel_subscription', $data);
	}
	
	public function getUserAnalytics() {
		
      	$registeredUsers = "select count(*) as registeredUsers from users_groups where group_id = 2";
		$registeredUsers = $this->db->query($registeredUsers);
		$registeredUsers = $registeredUsers->row_array();
      	$registeredUsers = $registeredUsers['registeredUsers'];

      	$registeredProducers = "select count(*) as registeredProducers from users_groups where group_id = 3";
		$registeredProducers = $this->db->query($registeredProducers);
      	$registeredProducers = $registeredProducers->row_array();
      	$registeredProducers = $registeredProducers['registeredProducers'];

      	$totalRevenue = "select SUM(irw_amount) as irwRevenue, SUM(producer_royality_amount) as producerRoyaltyRevenue from payment_logs";
		$totalRevenue = $this->db->query($totalRevenue);
      	$totalRevenue = $totalRevenue->row_array();
      	$allData = array(
      		'registeredUsers' => $registeredUsers,
      		'registeredProducers' => $registeredProducers,
      		'totalRevenue' => $totalRevenue,
      	);
      	
      	return $allData;
	}
	public function getAnalyticsOfWeek () {
		$weekPodcasts = "SELECT date, count
        from
        (
            select date, count(*) AS count
            from analytics
            where date BETWEEN date_add(curdate(), interval -6 day) AND curdate() AND type='Podcasts'
            group by date
            union all
            select curdate(), 0
            union all
            select date_add(curdate(), interval -1 day), 0
            union all
            select date_add(curdate(), interval -2 day), 0
            union all
            select date_add(curdate(), interval -3 day), 0
            union all
            select date_add(curdate(), interval -4 day), 0
            union all
            select date_add(curdate(), interval -5 day), 0
            union all
            select date_add(curdate(), interval -6 day), 0
        ) x
        group by date
        order by date";
		$weekPodcasts = $this->db->query($weekPodcasts);
		$weekPodcasts = $weekPodcasts->result();
		$podcastArray = array();
		
		foreach($weekPodcasts as $key => $value) {
			$podcastArray[$key] = $value->count;
		}
		

		$weekVideos = "SELECT date, count
        from
        (
            select date, count(*) AS count
            from analytics
            where date BETWEEN date_add(curdate(), interval -6 day) AND curdate() AND type='Video'
            group by date
            union all
            select curdate(), 0
            union all
            select date_add(curdate(), interval -1 day), 0
            union all
            select date_add(curdate(), interval -2 day), 0
            union all
            select date_add(curdate(), interval -3 day), 0
            union all
            select date_add(curdate(), interval -4 day), 0
            union all
            select date_add(curdate(), interval -5 day), 0
            union all
            select date_add(curdate(), interval -6 day), 0
        ) x
        group by date
        order by date";
		$weekVideos = $this->db->query($weekVideos);
		$weekVideos = $weekVideos->result();
		
		$videoArray = array();
		
		foreach($weekVideos as $key => $value) {
			$videoArray[$key] = $value->count;
		}
		
		$weekArticles = "SELECT date, count
        from
        (
            select date, count(*) AS count
            from analytics
            where date BETWEEN date_add(curdate(), interval -6 day) AND curdate() AND type='Article'
            group by date
            union all
            select curdate(), 0
            union all
            select date_add(curdate(), interval -1 day), 0
            union all
            select date_add(curdate(), interval -2 day), 0
            union all
            select date_add(curdate(), interval -3 day), 0
            union all
            select date_add(curdate(), interval -4 day), 0
            union all
            select date_add(curdate(), interval -5 day), 0
            union all
            select date_add(curdate(), interval -6 day), 0
        ) x
        group by date
        order by date";
		$weekArticles = $this->db->query($weekArticles);
		$weekArticles = $weekArticles->result();
		
		$articlesArray = array();
		
		foreach($weekArticles as $key => $value) {
			$articlesArray[$key] = $value->count;
		}
		//echo "<pre>"; print_r($articlesArray);exit;
		//$podcastArray = asort($podcastArray);
		$allAnalytics = array(
			'weekPodcasts'	=> array_reverse($podcastArray),
			'weekVideos'	=> array_reverse($videoArray),
			'weekArticles'	=> array_reverse($articlesArray),
		);
		return $allAnalytics;
	}

	public function weekAnalytics() {
		$producerId = $this->ion_auth->get_user_id();

		$weekPodcastsClick = "SELECT date, count
									from
									(
									  select date, count(*) AS count
									  from analytics
									  where date BETWEEN date_add(curdate(), interval -6 day) AND curdate() AND type='Podcasts' AND author_id='$producerId'
									  group by date
									  union all
									  select curdate(), 0
									  union all
									  select date_add(curdate(), interval -1 day), 0
									  union all
									  select date_add(curdate(), interval -2 day), 0
									  union all
									  select date_add(curdate(), interval -3 day), 0
									  union all
									  select date_add(curdate(), interval -4 day), 0
									  union all
									  select date_add(curdate(), interval -5 day), 0
									  union all
									  select date_add(curdate(), interval -6 day), 0
									) x
									group by date
									order by date";
		$weekPodcastsClick = $this->db->query($weekPodcastsClick);
		$weekPodcastsClick = $weekPodcastsClick->result();
		//echo $this->db->last_query();exit;
		$podcastArrayClick = array();
		foreach($weekPodcastsClick as $key => $value) {
			$podcastArrayClick[$key] = $value->count;
		}
		//echo "<pre>"; print_r($podcastArrayClick);exit;


		$weekVideos = "SELECT date, count
						from
						(
						  select date, count(*) AS count
						  from analytics
						  where date BETWEEN date_add(curdate(), interval -6 day) AND curdate() AND type='Video' AND author_id='$producerId'
						  group by date
						  union all
						  select curdate(), 0
						  union all
						  select date_add(curdate(), interval -1 day), 0
						  union all
						  select date_add(curdate(), interval -2 day), 0
						  union all
						  select date_add(curdate(), interval -3 day), 0
						  union all
						  select date_add(curdate(), interval -4 day), 0
						  union all
						  select date_add(curdate(), interval -5 day), 0
						  union all
						  select date_add(curdate(), interval -6 day), 0
						) x
						group by date
						order by date";
		$weekVideos = $this->db->query($weekVideos);
		$weekVideos = $weekVideos->result();
		//echo "<pre>"; print_r($weekVideos);exit;
		$videoArrayClick = array();
		foreach($weekVideos as $key => $value) {
			$videoArrayClick[$key] = $value->count;
		}
		
		$weekArticles = "SELECT date, count
						from
						(
						  select date, count(*) AS count
						  from analytics
						  where date BETWEEN date_add(curdate(), interval -6 day) AND curdate() AND type='Article' AND author_id='$producerId'
						  group by date
						  union all
						  select curdate(), 0
						  union all
						  select date_add(curdate(), interval -1 day), 0
						  union all
						  select date_add(curdate(), interval -2 day), 0
						  union all
						  select date_add(curdate(), interval -3 day), 0
						  union all
						  select date_add(curdate(), interval -4 day), 0
						  union all
						  select date_add(curdate(), interval -5 day), 0
						  union all
						  select date_add(curdate(), interval -6 day), 0
						) x
						group by date
						order by date";
		$weekArticles = $this->db->query($weekArticles);
		$weekArticles = $weekArticles->result();
		
		$articlesArrayClick = array();
		foreach($weekArticles as $key => $value) {
			$articlesArrayClick[$key] = $value->count;
		}
		
		$allAnalyticsClicks = array(
			'weekPodcastsClick'	=> array_reverse($podcastArrayClick),
			'weekVideosClick'	=> array_reverse($videoArrayClick),
			'weekArticlesClick'	=> array_reverse($articlesArrayClick),
		);
		//echo "<pre>"; print_r($allAnalyticsClicks);exit;
		return $allAnalyticsClicks;
	}

	public function monthAnalytics() {
		$producerId = $this->ion_auth->get_user_id();

		$monthPodcastsClick = "SELECT  Months.m AS date, COUNT(analytics.date) AS count FROM 
		(
		    SELECT 1 as m 
		    UNION SELECT 2 as m 
		    UNION SELECT 3 as m 
		    UNION SELECT 4 as m 
		    UNION SELECT 5 as m 
		    UNION SELECT 6 as m 
		    UNION SELECT 7 as m 
		    UNION SELECT 8 as m 
		    UNION SELECT 9 as m 
		    UNION SELECT 10 as m 
		    UNION SELECT 11 as m 
		    UNION SELECT 12 as m
		) as Months
		LEFT JOIN analytics  on Months.m = MONTH(analytics.date)  AND analytics.author_id='$producerId' AND analytics.type='Podcasts'
		GROUP BY
		    Months.m";
		$monthPodcastsClick = $this->db->query($monthPodcastsClick);
		$monthPodcastsClick = $monthPodcastsClick->result();
		//echo $this->db->last_query();exit;
		//echo "<pre>"; print_r($monthPodcastsClick);exit;
		$podcastArrayMonth = array();
		foreach($monthPodcastsClick as $key => $value) {
			$podcastArrayMonth[$key] = $value->count;
		}


		$monthvideosClick = "SELECT  Months.m AS date, COUNT(analytics.date) AS count FROM 
		(
		    SELECT 1 as m 
		    UNION SELECT 2 as m 
		    UNION SELECT 3 as m 
		    UNION SELECT 4 as m 
		    UNION SELECT 5 as m 
		    UNION SELECT 6 as m 
		    UNION SELECT 7 as m 
		    UNION SELECT 8 as m 
		    UNION SELECT 9 as m 
		    UNION SELECT 10 as m 
		    UNION SELECT 11 as m 
		    UNION SELECT 12 as m
		) as Months
		LEFT JOIN analytics  on Months.m = MONTH(analytics.date)  AND analytics.author_id='$producerId' AND analytics.type='Video'
		GROUP BY
		    Months.m";
		$monthvideosClick = $this->db->query($monthvideosClick);
		$monthvideosClick = $monthvideosClick->result();
		//echo $this->db->last_query();exit;
		//echo "<pre>"; print_r($monthPodcastsClick);exit;
		$videoArrayMonth = array();
		foreach($monthvideosClick as $key => $value) {
			$videoArrayMonth[$key] = $value->count;
		}


		$monthArticlesClick = "SELECT  Months.m AS date, COUNT(analytics.date) AS count FROM 
		(
		    SELECT 1 as m 
		    UNION SELECT 2 as m 
		    UNION SELECT 3 as m 
		    UNION SELECT 4 as m 
		    UNION SELECT 5 as m 
		    UNION SELECT 6 as m 
		    UNION SELECT 7 as m 
		    UNION SELECT 8 as m 
		    UNION SELECT 9 as m 
		    UNION SELECT 10 as m 
		    UNION SELECT 11 as m 
		    UNION SELECT 12 as m
		) as Months
		LEFT JOIN analytics  on Months.m = MONTH(analytics.date)  AND analytics.author_id='$producerId' AND analytics.type='Article'
		GROUP BY
		    Months.m";
		$monthArticlesClick = $this->db->query($monthArticlesClick);
		$monthArticlesClick = $monthArticlesClick->result();
		//echo $this->db->last_query();exit;
		//echo "<pre>"; print_r($monthArticlesClick);exit;
		$articleArrayMonth = array();
		foreach($monthArticlesClick as $key => $value) {
			$articleArrayMonth[$key] = $value->count;
		}

		$allAnalyticsMonth = array(
			'monthPodcastsClick' => $podcastArrayMonth,
			'monthVideosClick'	=> $videoArrayMonth,
			'monthArticlesClick' => $articleArrayMonth,
		);
		//echo "<pre>"; print_r($allAnalyticsClicks);exit;
		return $allAnalyticsMonth;
	}

	public function totalSubscribers() {
		$producerId = $this->ion_auth->get_user_id();
		$allSubscribers = "SELECT count(*) AS subscribers from channel_subscription WHERE channel_subscription.channel_id = ". $producerId;
		$allSubscribers = $this->db->query($allSubscribers);
		$allSubscribers = $allSubscribers->row_array();
		//echo "<pre>"; print_r($allSubscribers);exit;
		return $allSubscribers;
	}

	public function getContentOfProducer() {
		$producerId = $this->ion_auth->get_user_id();

		$allContent = "Select * from contents WHERE user_id = ". $producerId;
		$allContent = $this->db->query($allContent);
		$allContent = $allContent->result();
		//echo "<pre>"; print_r($allContent);exit;
		return $allContent;
	}


	public function byEpisode($id) {
		$byEpisode = "SELECT count(*) as COUNT, date from analytics where type_id='$id' GROUP BY date ORDER BY date";
		$byEpisode = $this->db->query($byEpisode);
		$byEpisode = $byEpisode->result();
		$allAnalyticsDate = array();
		foreach($byEpisode as $key => $value) {
			$allAnalyticsDate[$key]= $value->date;
		}
		$allAnalyticsCount = array();
		foreach($byEpisode as $key => $value) {
			$allAnalyticsCount[$key] = $value->COUNT;
		}

		$allAnalyticsEpisode = array(
			'episodeDates' => $allAnalyticsDate,
			'episodeCount'	=> $allAnalyticsCount,
		);
		//echo "<pre>"; print_r($allAnalyticsEpisode);exit;
		return $allAnalyticsEpisode;
	}

	public function totalRevenue() {
		$producerId = $this->ion_auth->get_user_id();

		$totalRevenue = "SELECT SUM(amount) as totalRevenue, sum(irw_amount) as irw_amount, sum(producer_royality_amount) as producer_amount from channel_subscription WHERE channel_id=". $producerId;
		$totalRevenue = $this->db->query($totalRevenue);
		$totalRevenue = $totalRevenue->row_array();
		//echo "<pre>"; print_r($totalRevenue);exit;
		return $totalRevenue;	
	}

	public function getAnalyticsOfWeekClicked() {
		$weekPodcastsClick = "SELECT COUNT(*) AS count, date from analytics WHERE date > DATE(NOW()) - INTERVAL 7 DAY AND type='Podcasts' group BY date ORDER BY date DESC";
		$weekPodcastsClick = $this->db->query($weekPodcastsClick);
		$weekPodcastsClick = $weekPodcastsClick->result();
		$podcastArrayClick = array();
		
		for ($pi = 6; $pi >= 0; $pi--) {
			if (isset($weekPodcastsClick[$pi])) {
				
				if ($weekPodcastsClick[$pi]->date == date('Y-m-d', strtotime('-'.$pi.' days'))) {
					$podcastArrayClick[$pi] = $weekPodcastsClick[$pi]->count;
				}
				else {
					$podcastArrayClick[$pi] = 0;
				}
			}
			else {
				$podcastArrayClick[$pi] = 0;
			}
		}
		//echo "<pre>"; print_r($podcastArrayClick);exit;

		$weekVideos = "SELECT COUNT(*) AS count, date from analytics WHERE date > DATE(NOW()) - INTERVAL 7 DAY AND type='Video' group BY date ORDER BY date DESC";
		$weekVideos = $this->db->query($weekVideos);
		$weekVideos = $weekVideos->result();
		
		$videoArrayClick = array();
		for ($pi = 6; $pi >= 0; $pi--) {
			if (isset($weekVideos[$pi])) {
				
				if (date('Y-m-d', strtotime($weekVideos[$pi]->date)) == date('Y-m-d', strtotime('-'.$pi.' days'))) {
					$videoArrayClick[$pi] = $weekVideos[$pi]->count;
				}
				else {
					$videoArrayClick[$pi] = 0;
				}
			}
			else {
				$videoArrayClick[$pi] = 0;
			}
		}

		$weekArticles = "SELECT COUNT(*) AS count, date from analytics WHERE date > DATE(NOW()) - INTERVAL 7 DAY AND type='Article' group BY date ORDER BY date DESC";
		$weekArticles = $this->db->query($weekArticles);
		$weekArticles = $weekArticles->result();
		
		$articlesArrayClick = array();
		for ($pi = 6; $pi >= 0; $pi--) {
			if (isset($weekArticles[$pi])) {
				
				if (date('Y-m-d', strtotime($weekArticles[$pi]->date)) == date('Y-m-d', strtotime('-'.$pi.' days'))) {
					$articlesArrayClick[$pi] = $weekArticles[$pi]->count;
				}
				else {
					$articlesArrayClick[$pi] = 0;
				}
			}
			else {
				$articlesArrayClick[$pi] = 0;
			}
		}

		$allAnalyticsClicks = array(
			'weekPodcastsClick'	=> ($podcastArrayClick),
			'weekVideosClick'	=> array_reverse($videoArrayClick),
			'weekArticlesClick'	=> array_reverse($articlesArrayClick),
		);
		//echo "<pre>"; print_r($allAnalyticsClicks);exit;
		return $allAnalyticsClicks;
	}

	public function get_user_detail_by_email($email){
		return $this->db->from($this->tablename)->where(array('email' => $email))->get()->row_array();
	}
	
	public function save($data){
		
		$this->db->insert('users',$data);
		return $this->db->insert_id();
	}

    public function getAllUsersFroDropDown(){
		$query = $this->db->get('users');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}

	public function getNextUserID(){
		$query  = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$this->db->database."' AND TABLE_NAME = 'users'";
		$result = $this->db->query($query);
		$row    = $result->result();
		return $row[0]->AUTO_INCREMENT;
	}
	
	public function getUserName($id){
		$query  = "SELECT * from users where id= '$id'";
		$result = $this->db->query($query);
		$row    = $result->row();
		return $row->first_name." ".$row->last_name;
	}

	public function getAllAdmins() {
		$query = $this->db->query('SELECT users.* FROM users JOIN users_groups ON users.id = users_groups.user_id WHERE users_groups.group_id=1');
		return $query->result();
		//echo $this->db->last_query();exit;
		return $admins;
	}
	

	public function soft_delete($id) {
		$data = array(
           'is_deleted' => 1,
        );
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}


	public function hard_delete($id) {
		$data = array(
			'id' => $id,
		);
		$this->db->where('id', $id);
		$this->db->delete('users', $data);
		return true;
	}


	public function getLatestUsersForDashboard(){
		$this->db->limit(5, 0);
		$this->db->order_by('id','desc');

		$this->db->select('users.*');
		$query = $this->db->get('users');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();	
	}

	public function countUserTotal($data){
		if(isset($data['name']) && $data['name']!=''){
			$this->db->like('users.firstname', $data['name']);
			$this->db->or_like('users.lastname', $data['name']);
			$this->db->or_like('users.email', $data['name']);
		}
		if(isset($data['portalUsers']) && $data['portalUsers']!=''){
			$this->db->where('users.portal_user', $data['portalUsers']);
		}
		
		$this->db->select('users.*');
		$this->db->from('users');
		$query  =   $this->db->get();
		return $query->num_rows();
	}

	public function getRow($id){
		$query = $this->db->query('SELECT users.*, users_groups.group_id from users join users_groups on users.id = users_groups.user_id where users.id = '.$id);
		$row = $query->result();

		if(count($row) > 0)
		{
			return $row[0];
		}
		return array();
	}
	
	public function getUserByField($field,$id){
		$sSQL   =   $this->db->where($field,$id);
		$query  =   $this->db->get('users');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}
	public function getUserIdForMessage($id){
		//$where = "email=".$id." OR phone=".$id;
		$this->db->where("email",$id);
		$this->db->or_where("phone",$id);
		$query  =   $this->db->get('users');
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}
	public function checkPhoneNumberNotUserid($field,$id,$user_id){
		$this->db->where("id <>",$user_id);
		$sSQL   =   $this->db->where($field,$id);
		$query  =   $this->db->get('users');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}
	
	public function getRowByEmail($email){
		$this->db->where("email",$email);
		$query  =   $this->db->get('users');
		
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return false;
	}

	
	public function update($data,$id){
		//echo "<pre>"; print_r($data);exit;
		$this->db->where('id',$id);
		$this->db->update('users',$data);
		//echo $this->db->last_query();exit;
		return true;
	}
	
	public function insertTextMessage($data){
		$this->db->insert('message_text',$data);
		//echo $this->db->last_query();
		return true;
	}
	
	public function getTextByField($field,$id){
		$sSQL   =   $this->db->where($field,$id);
		$query  =   $this->db->get('message_text');
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row;
		}
		return array();
	}
	
	public function authenticate($username,$password){
		$this->db->where('email', $username);
		$this->db->where('password', $password);
		$query = $this->db->get('users');
		if( $query->num_rows() > 0){
			$record	=	$query->result();
			return $record[0];
		}
		else{
			return FALSE;
		}
	}
	//=== authenticate old password ============ start//
	public function authenticatePasswordById($id,$password){
		$this->db->where('id', $username);
		$this->db->where('password', $password);
		$query = $this->db->get('users');
		if( $query->num_rows() > 0){
			$record	=	$query->result();
			return $record[0];
		}
		else{
			return FALSE;
		}
	}
	//=== authenticate old password ============ start//
	
	public function block_users($id){
		$this->db->where('id', $id);
		$data['activated'] = 0;
		$this->db->update('users',$data);
	}
	
	public function approved_users($id){
		$this->db->where('id', $id);
		$data['activated'] = 1;
		$this->db->update('users',$data);
	}

	public function checkEmail($email,$id = null) {
		if($id) {
			$this->db->where('id !=', $id);	
		}
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		if( $query->num_rows() > 0) {
			$record	=	$query->result();
			return true;
		}else {
			return false;
		}
	}

	public function checkEmailOnRegistration($email,$id = null) {
		if($id) {
			$this->db->where('id !=', $id);	
		}
		$this->db->where('status<>','inactive');
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		if( $query->num_rows() > 0) {
			$record	=	$query->result();
			return true;
		}else {
			return false;
		}
	}
	
	public function checkUsernameOnRegistration($username,$id = null){
		if($id){
			$this->db->where('id !=', $id);	
		}
		$this->db->where('status<>', 'inactive');
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		if( $query->num_rows() > 0) {
			$record	=	$query->result();
			return true;
		}else {
			return false;
		}
	}

	public function is_login(){
		if(!$this->session->userdata('user_id')) {
			ciredirect(base_url().'user/login');
		}
		/*if($this->session->userdata('type')=='super_admin' && $this->uri->segment('1')!='admin'){
			ciredirect(base_url().'admin');
		}*/
		if($this->session->userdata('type')!='super_admin' && $this->uri->segment('1')=='admin'){
			ciredirect(base_url().'user');
		}
		
	}
	
	public function loginByCookieToken($token){
		$sSQL   =   $this->db->where("cookie_token",$token);
		$query  =   $this->db->get('users');
		
		if($query->num_rows())
		{
			$row = $query->result();
			$row = $row[0];
			
			$login_data['user_id']		=	$user_record->id;
			$login_data['email']		=	$user_record->email;
			$login_data['full_name']	=	$user_record->firstname." ".$user_record->lastname;
			$login_data['type']			=	$user_record->type;

			$this->session->set_userdata($login_data);
			$this->Users_model->update($update_user_data,$user_record->id);
			ciredirect(base_url()."user/dashboard");
		}
	}
	
	public function checkCookieForLogin(){
		$cookie = $this->input->cookie('cookie_token');
		if($cookie!=''){
			$this->loginByCookieToken($cookie);
		}
	}
	
	
	/**** Payments queries *******/
	public function addPayment($data){
		$this->db->insert('payments_history',$data);
		return $this->db->insert_id();
	}

	public function getNextRechargeDate($recurring_type){
		$next_recharge_date = date("Y-m-d",strtotime("+".$recurring_type));
		return $next_recharge_date;
	}

	public function countPaymentsByUserID($id){
		$this->db->where('user_id',$id);
		$this->db->from('payments_history');
		$query  =   $this->db->get();
		return $query->num_rows();
	}

	public function countRecuringPayments(){
		$date = date("Y-m-d",time()+(86400*3));
		$this->db->where("DATE_FORMAT(next_recharge_date,'%Y-%m-%d') <=",$date);
		$this->db->where("DATE_FORMAT(next_recharge_date,'%Y-%m-%d') <>","0000-00-00");
		$this->db->from('users');
		$query  =   $this->db->get();
		return $query->num_rows();
	}

	public function countPayments(){
		$this->db->from('payments_history');
		$query  =   $this->db->get();
		return $query->num_rows();
	}

	public function getAllOrdersByUserID($id){
		$this->db->where("user_id",$id);
		$this->db->order_by('id','desc');
		$query = $this->db->get('orders');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();		
	}
	
	public function getOrderDetail($id){
		$sSQL   =   $this->db->where("id",$id);
		$query  =   $this->db->get('orders');
		
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row[0];
		}
		return array();
	}
	
	public function getOrderDetails($id){
		$sSQL   =   $this->db->where("order_id",$id);
		$query  =   $this->db->get('order_detail');
		
		if($query->num_rows())
		{
			$row = $query->result_array();
			return $row;
		}
		return array();
	}
	public function updateReceiverId($email, $phone, $user_id){
		$this->db->where('receiver_id', $email);
		$this->db->or_where('receiver_id', $phone);
		$update_data['receiver_id'] = $user_id;
		$query = $this->db->update('message_text',$update_data);
		//echo $this->db->last_query();
		//die();
	}
	// some functions for web services ==================
	public function getUserIdByToken($token){
		$this->db->select('users.id');
		$this->db->where('token',$token);
		$query = $this->db->get('users');
		if($query->num_rows()>0){
			$row = $query->result();
			return $row[0];
		}
		return false;
	} 
	public function removeUserToken($token){
		$data['token'] = "";
		$this->db->where('token',$token);
		$this->db->update('users',$data);
		$result = $this->db->affected_rows();
		return $result;		
	}
	
	public function saveUserCurrentCredits($data){
		$this->db->insert('user_current_credits',$data);
		return $this->db->insert_id();	
	}
	
	public function saveUserCredits($data){
		$this->db->insert('user_credits',$data);
		return $this->db->insert_id();
	}
	
	public function saveUserCreditLogs($data){
		$this->db->insert('user_credits_logs',$data);
		return $this->db->insert_id();
	}
	
	public function getCurrentUserCreditsRows($user_id){
		$this->db->where("user_id",$user_id);
		$query = $this->db->get('user_current_credits');
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getMethodTypesById($userId,$message_type){
		$this->db->where('user_id',$userId);
		$this->db->where($message_type.' >',0);
		$this->db->where('expiry_date >=', date("Y-m-d"));
		$query = $this->db->get('user_current_credits');
		$row = $query->result_array();
		if($query->num_rows() == 1 ){
			return $row[0]['id'];
		}
		else if($query->num_rows()>1){
			return $row;
		}
		return false;
	}
	public function chargeMessageCreditById($userId,$type){
		$this->db->where('user_id',$userId);
		$this->db->where($type.'>',0);
		$this->db->where('expiry_date >=', date("Y-m-d"));
		$this->db->order_by('id','asc');
		$query = $this->db->get('user_current_credits');
		$row = $query->row_array();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			$id			 = $row['id'];
			$data[$type] = $row[$type]-1;
			
			$this->db->where('id',$id);
			$this->db->where('user_id',$userId);
			$this->db->update('user_current_credits', $data);
			
			if($this->db->affected_rows()){
				$array['user_id'] 			= $row['user_id'];
				$array['use_type'] 			= 'used';
				$array['package_type']  	= $row['type'];
				$array['text'] 				= 1;
				$array['document'] 			= 0;
				$array['video'] 			= 0;
				$array['audio'] 			= 0;
				$array['created_date'] 		= date("Y-m-d");
				$this->db->insert('user_credits_logs',$array);
			}
			return $this->db->affected_rows();
		}
		return 0;
		
	}

	function checkUserPackage($userId){
		$this->db->where('user_id',$userId);
		$this->db->where('expiry_date >',date('Y-m-d'));
		$query = $this->db->get('user_current_credits');
		$row = $query->result_array();
		$this->db->last_query();
		if($query->num_rows() >0){
			return true;
		}
		return false;
	}
	
	function updateUserPrepaidCurrentCredits($data,$userID){
		$this->db->where('user_id',$userId);
		$this->db->where('type','prepaid');
		$query = $this->db->get('user_current_credits');
		$row = $query->result_array();
		if($query->num_rows() >0){
			$id = $row[0]['id'];
			$this->db->where('id',$id);
			$this->db->update('users',$data);
		}else{
			$this->db->insert('user_current_credits',$data);
			return $this->db->insert_id();
		}
	}
	
	function updateUserPrepaidPackage($data,$userID){
		$this->db->where('user_id',$userId);
		$this->db->where('type','prepaid');
		$query = $this->db->get('user_credits');
		$row = $query->result_array();
		if($query->num_rows() >0){
			$id = $row[0]['id'];
			$this->db->where('id',$id);
			$this->db->update('users',$data);
		}else{
			$this->db->insert('user_credits',$data);
			return $this->db->insert_id();
		}
	}
	public function getMethodDetailById($userId){
		$this->db->where('user_id',$userId);
		$query = $this->db->get('user_current_credits');
		$row = $query->result_array();
		if($query->num_rows()>0 ){
			return $row;
		}
		return false;
	}
	
	public function getCreditLogsById($userId){
		$this->db->where('user_id',$userId);
		$query = $this->db->get('user_credits_logs');
		$row = $query->result_array();
		if($query->num_rows()>0 ){
			return $row;
		}
		return false;
	}

	
	function checkUserCurrentSubscriptionPackage($userId){
		$this->db->where('user_id',$userId);
		$this->db->where('expiry_date >=',date('Y-m-d'));
		$this->db->where('type <>','prepaid');
		$query = $this->db->get('user_current_credits');
		$row = $query->result_array();
		$this->db->last_query();
		if($query->num_rows() >0){
			return $row[0]['type'];
		}
		return false;
	}
	
	function updateCurrentCreditsInExistingPackage($data){
		$text 				= $data['text'];
		$documents 			= $data['document'];
		$video 				= $data['video'];
		$audio 				= $data['audio'];
		
		$text_amount 		= $data['text_amount'];
		$documents_amount 	= $data['document_amount'];
		$video_amount 		= $data['video_amount'];
		$audio_amount 		= $data['audio_amount'];
		
		$text_credit_amount		= $data['text_amount']/$text;
		$document_credit_amount = $data['document_amount']/$documents;
		$video_credit_amount 	= $data['video_amount']/$video;
		$audio_credit_amount 	= $data['audio_amount']/$audio;
		
		$text_credits_detail = $data['text_credits_detail'];
		$doucment_credits_detail = $data['document_credits_detail'];
		$audio_credits_detail = $data['audio_credits_detail'];
		$video_credits_detail = $data['video_credits_detail'];
		
		$type 			= $data['type'];
		$expiry_date 	= $data['expiry_date'];
		$user_id 		= $data['user_id'];
		$query 			= "update user_current_credits set text=text+$text, document=document+$documents, audio=audio+$audio,video=video+$video,
							text_credits_detail=concat(text_credits_detail,'|',$text_credits_detail),text_amount_detail=concat(text_amount_detail,'|',$text_credit_amount),
							document_credits_detail=concat(document_credits_detail,'|',$doucment_credits_detail),document_amount_detail=concat(document_amount_detail,'|',$document_credit_amount), 
							audio_credits_detail=concat(audio_credits_detail,'|',$audio_credits_detail),audio_amount_detail=concat(audio_amount_detail,'|',$audio_credit_amount),
							video_credits_detail=concat(video_credits_detail,'|',$video_credits_detail),video_amount_detail=concat(video_amount_detail,'|',$video_credit_amount) 
							where type='$type' and user_id=$user_id";
		return $this->db->query($query);
		
	}
	
	function updateCurrentCreditsWithNewPackage($data){
		$text 				= $data['text'];
		$documents 			= $data['document'];
		$video 				= $data['video'];
		$audio 				= $data['audio'];
		
		$text_amount 		= $data['text_amount'];
		$documents_amount 	= $data['document_amount'];
		$video_amount 		= $data['video_amount'];
		$audio_amount 		= $data['audio_amount'];
		
		$text_credit_amount		= $data['text_amount']/$text;
		$document_credit_amount = $data['document_amount']/$documents;
		$video_credit_amount 	= $data['video_amount']/$video;
		$audio_credit_amount 	= $data['audio_amount']/$audio;
		
		$text_credits_detail = $data['text_credits_detail'];
		$doucment_credits_detail = $data['document_credits_detail'];
		$audio_credits_detail = $data['audio_credits_detail'];
		$video_credits_detail = $data['video_credits_detail'];
		
		$type 			= $data['type'];
		$oldtype 			= $data['oldtype'];
		$expiry_date 	= $data['expiry_date'];
		$user_id 		= $data['user_id'];
		$query 			= "update user_current_credits set text=$text, document=$documents, audio=$audio,video=$video,expiry_date='$expiry_date',
							text_credits_detail='$text_credits_detail',text_amount_detail='$text_credit_amount',
							document_credits_detail='$doucment_credits_detail',document_amount_detail='$document_credit_amount', 
							audio_credits_detail='$audio_credits_detail',audio_amount_detail='$audio_credit_amount',
							video_credits_detail='$video_credits_detail',video_amount_detail='$video_credit_amount',
							type = '$type' 
							where type='$oldtype' and user_id=$user_id";
		//echo $query;
		return $this->db->query($query);
	}
	
	function updateCreditsInExistingPackage($data){
		$text 				= $data['text'];
		$documents 			= $data['document'];
		$video 				= $data['video'];
		$audio 				= $data['audio'];
		$type 				= $data['type'];
		$next_recharge_date = $data['next_recharge_date'];
		$amount 			= $data['amount'];
		$user_id 			= $data['user_id'];
		$query 				= "update user_credits set text=$text, document=$documents, audio=$audio,video=$video,next_recharge_date='$next_recharge_date',amount='$amount' where type='$type' and user_id=$user_id";
		return $this->db->query($query);
	}
	
	function updateCreditsWithNewPackage($data){
		$text 				= $data['text'];
		$documents 			= $data['document'];
		$video 				= $data['video'];
		$audio 				= $data['audio'];
		$type 				= $data['type'];
		$oldtype 			= $data['oldtype'];
		$next_recharge_date = $data['next_recharge_date'];
		$amount 			= $data['amount'];
		$user_id 			= $data['user_id'];
		$query 				= "update user_credits set text=$text, document=$documents, audio=$audio,video=$video,next_recharge_date='$next_recharge_date',amount='$amount',type='$type' where type='$oldtype' and user_id=$user_id";
		return $this->db->query($query);
	}
	
	function getRemaningAmountofUserByType($user_id,$package_type){
		$date 	= date("Y-m-d");
		$query 	= "select * from user_current_credits where type = '$package_type' and user_id = $user_id and expiry_date >='$date'";
		$query  = $this->db->query($query);
		$row 	= $query->result();
		if($row){
			$row	= $row[0];
			
			$array = array('text',"document","audio","video");
			
			
			$remaning_points_amount = 0;
			$grand_total = 0;	
			foreach($array as $val){
				$total_points = 0;
				$remaning_points_amount = 0;
				$variable_detail = $val."_credits_detail";
				$variable_amount = $val."_amount_detail";
				
				$text_message_array = explode('|',$row->$variable_detail);
				$text_amount_array = explode('|',$row->$variable_amount);
				
				$sum_total_credits = array_sum($text_message_array);
				$used_points = $row->$val;
				$remaning_total_points = $sum_total_credits - $used_points;
	
				$remaning_points = 0;
				$i = 0;
				$remaning_points_check = false;
				foreach($text_message_array as $points){
					$total_points+=$points;
					if($remaning_points_check){
						$remaning_points_amount+=$points*$text_amount_array[$i];
					}
					if($total_points>$remaning_total_points && $remaning_points_check==false){
	
						$remaning_points_amount+= ($total_points-$remaning_total_points)*$text_amount_array[$i];
						$remaning_points_check = true;
					}				
					$i++;
				}
				$grand_total+=$remaning_points_amount;
			}
			return $grand_total;
		}else{
			return 0;
		}
	}
	public function getCurrentPackageType($user_id){
		$this->db->where('user_id',$user_id);
		$this->db->where('type <>','prepaid');
		$query = $this->db->get('user_current_credits');
		if($query->num_rows())
		{
			$row = $query->result();
			return $row[0]->type;
		}
		return "";
	}
	//=== function for useers logs list =====
	public function getAllCreditsLogs($start, $limit){
		$this->db->limit($limit, $start);
		$query = $this->db->get('user_credits_logs');
		$row = $query->result_array();
		
		
		if( $query->num_rows()){
			foreach($row as  $key => $logs){
				
				$this->db->select('firstname,lastname');
				$this->db->where('id', $row[$key]['user_id']);
				if( $query->num_rows()){
					$query1 = $this->db->get('users');
					$name = $query1->result_array();
					$row[$key]['user_id'] = $name[0]['firstname']." ".$name[0]['lastname'];
					
				}
				else{
					$row[$key]['user_id'] = 'User Delected';
				}
			}
			return $row;
		}
		return array();
	}
	public function countTotalCreditsLogs(){
		$query = $this->db->get('user_credits_logs');
		return $query->num_rows();
	}
	
	public function getPaymentHistoryByUserId($userId){
		$this->db->order_by('id','desc');
		$this->db->where('user_id', $userId);
		$query = $this->db->get('user_payment_logs');
		if($query->num_rows()){
			 return $query->result_array();
		}
		return false;
	}
	public function getRemainingCreditById($userId, $type){
		$this->db->where("user_id",$userId);
		$this->db->select('sum('.$type.') as total');
		$query = $this->db->get('user_current_credits');
		if($query->num_rows()){
			$row = $query->result_array();
			return $row[0];
		}
		return 0;
	}

	
	// by me 
	public function getUserIdByGroupId(){
		$query  = "SELECT user_id FROM users_groups WHERE group_id = 3";
		$result = $this->db->query($query);
		$rows = $result->result_array();
		foreach( $rows as $values){
			$new[] = $values['user_id'];
		}
		//print_r($new); die();
		return $new;
	}
    public function getChanelUsers() {
        /*$chanel_users  = $this->db->query("select users_groups.user_id,
            users.id, users.channel_subscription_price, users.channel_name, users.picture,
            contents.user_id, contents.type, count(contents.id) as TOTAL from users_groups 
            left join users on (users_groups.user_id = users.id)
            left join contents on (users_groups.user_id = contents.user_id)
            where users_groups.group_id = '3' and users.is_deleted != '1' 
            group by contents.user_id , contents.type order by users.sorting desc
        ");*/
        $chanel_users = $this->db->query("SELECT users.id, users.channel_subscription_price,users.stripe_user_id, users.channel_name, users.picture,users_groups.user_id,contents.user_id, contents.type, count(contents.id) as TOTAL FROM `users`
left join users_groups on (users.id=users_groups.user_id)
left join contents on (users.id = contents.user_id)
where users_groups.group_id = '3' and users.is_deleted!='1' and is_approved=1
group by users.channel_name order by users.sorting desc");
        if($chanel_users->num_rows()>0){
            return $chanel_users->result_array();
        }
        return array();
    }
	
	public function getUserDetailByIds($ids) {
		$this->db->select('id, channel_subscription_price, channel_name, picture');
		$this->db->where_in('id',$ids);
		$this->db->order_by("sorting", "desc");
		$this->db->where('is_deleted !=', 1);
		$query = $this->db->get('users');
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows()>0) {
			$row = $query->result_array();
			return $row;	
		}
		return array();
	}
	

	public function getUserDetailcountById($id) {
		$this->db->select('id,channel_subscription_price, channel_name, description, picture, sales_pitch, banner, video,video_type');
		$this->db->where('id',$id);
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		//die();
		return $query->num_rows();
	}
	
	
	public function getUserDetailById($id){
		$this->db->select('id,channel_subscription_price, channel_name, description, picture, sales_pitch, banner, video,video_type');
		$this->db->where('id',$id);
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row[0];	
		}
		return array();
	}


	public function getUserDetails($id){
		$this->db->select('users.*');
		$this->db->select('users_groups.group_id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id');
		$this->db->where('users.id',$id);
		$query = $this->db->get('users');
		// echo $this->db->last_query();
		// die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row[0];	
		}
		return array();
	}

	public function brainTreeByChannelId($id){
		$this->db->select('braintree_merchant_info.*');
		$this->db->where('braintree_merchant_info.producer_id',$id);
		$query = $this->db->get('braintree_merchant_info');
		// echo $this->db->last_query();
		// die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row[0];	
		}
		return array();
	}
	
	public function getProducerMerchantId($id){
		$this->db->select('braintree_merchant_info.*');
		$this->db->where('braintree_merchant_info.producer_id',$id);
		$query = $this->db->get('braintree_merchant_info');
		// echo $this->db->last_query();
		// die();
		if($query->num_rows()>0){
			$row = $query->row();
			return $row->merchant_account_number;	
		}
		return ''; //by default
	}
	
	public function getStripeProducerAccountID($id){
		$this->db->where('id',$id);
		$query = $this->db->get('users');
		// echo $this->db->last_query();
		// die();
		if($query->num_rows()>0){
			$row = $query->row();
			return $row->stripe_user_id;	
		}
		return ''; //by default
	}
	
	public function checkStripPlanForProducerWithAmount($amount,$user_id){
		$this->db->where('user_id',$user_id);
		$this->db->where('amount',$amount);
		$query = $this->db->get('stripe_plans');
		if($query->num_rows()>0){
			return false;
		}
		return true;
	}

    
	public function getAllUsersByType($user_type) {
		$this->db->select('users.*');
		$this->db->select('users_groups.group_id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id');
		$this->db->where('users_groups.group_id', $user_type);
		$query = $this->db->get('users');
		//echo $this->db->last_query();die;
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}

	public function getAllUsers($data,$start,$limit, $key=''){
		//echo $limit;exit;
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		if(isset($key['name']) && $key['name'] != ''){
			$this->db->like('users.brand_name', $key['name']);
			$this->db->or_like('users.channel_name', $key['name']);
			$this->db->or_like('users.email', $key['name']);
		}
		if (isset($key['name']) && $key['name']!=''){
			$this->db->like('users.brand_name', $key['name']);
			$this->db->or_like('users.channel_name', $key['name']);
			$this->db->or_like('users.email', $key['name']);
		}


		$this->db->select('users.*');
		$this->db->select('users_groups.group_id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id');
		if (isset($key['type']) && $key['type']!='') {
			$this->db->where('users_groups.group_id', $key['type']);
		}
		if($key['type']==3){
			$this->db->where('users.is_approved', 1);
		}
		$query = $this->db->get('users');
		//echo $this->db->last_query();die;
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}

	public function getAllChannels($data){
		$this->db->order_by('id','desc');
		if(isset($data['name']) && $data['name'] != ''){
			$this->db->like('users.brand_name', $data['name']);
			$this->db->or_like('users.channel_name', $data['name']);
			$this->db->or_like('users.email', $data['name']);
		}
		$this->db->select('users.*');
		$this->db->select('users_groups.group_id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id');
		// if (isset($key['type']) && $key['type']!='') {
		// 	$this->db->where('users_groups.group_id', $key['type']);
		// }
		// //$this->db->where('users.is_approved', 1);
		$query = $this->db->get('users');
		//echo $this->db->last_query();die;
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getCountNonApprovedProducers($data) {
		$this->db->select('users_groups.group_id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id');
		$this->db->where('users_groups.group_id', $data['type']);
		$this->db->from('users');
		$this->db->where('users.is_approved', 0);
		$query  =  $this->db->get();
		return $query->num_rows();
	}

	public function getAllNonApprovedProducers($data,$start,$limit, $key=''){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$this->db->select('users.*');
		$this->db->select('users_groups.group_id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id');
		$this->db->where('users_groups.group_id', $key['type']);
		$this->db->where('users.is_approved', 0);
		$query = $this->db->get('users');
		//echo $this->db->last_query();die;
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function countTotalRows($data)
	{
		$where = "  1=1 ";	
		if (isset($data['name']) && $data['name'] != '') {
			$this->db->like('users.brand_name', $data['name']);
			$this->db->or_like('users.channel_name', $data['name']);
			$this->db->or_like('users.email', $data['name']);
		}

		$this->db->where($where,NULL,false);
		$this->db->select('users.*');
		if (isset($data['type']) && $data['type'] != '') {
			$this->db->select('users_groups.group_id');
			$this->db->join('users_groups', 'users_groups.user_id = users.id');
			$this->db->where('users_groups.group_id', $data['type']);
		}
		if (isset($data['type']) && $data['type'] == '3') {
			$this->db->where('users.is_approved', 1);
		}
		
		$this->db->from('users');
		$query  =  $this->db->get();
		//echo $this->db->last_query();die;
		return $query->num_rows();
	}

	
	public function email_check($email, $id )
	{
		$where=" email= '".$email."' and id !=".$id;
		$this->db->where($where,NULL,false);
		$this->db->select('users.*');
		$this->db->from('users');
		$query  =  $this->db->get();
		if( $query->num_rows()){
		 return true;
		}
		return false;
	}
	
	
	public function getChannelSubscribeInfoByChannelId($id){
		$this->db->select('channel_subscription_price, channel_name,picture,irw_percentage, producer_royalty');
		$this->db->where('id',$id);
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row[0];	
		}
		return array();
	}
	public function insertChannelSubscriptionDetail($data){
		$this->db->insert('channel_subscription',$data);
		//echo $this->db->last_query();
		return true;
	}
	public function checkAlreadyBuy($id){
		$this->db->select('*');
		$this->db->where('channel_id',$id);
		$this->db->where('status','active');
		$this->db->where('user_id',$this->ion_auth->get_user_id());
		//$this->db->where('next_recharge_date >=',date('Y-m-d'));
		$query = $this->db->get('channel_subscription');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			
			return true;	
		}
		return false;
	}
	
	public function countTotalChannelRowsByUserId($user_id,$data)
	{
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (channel_name like '%".$data['name']."%')";
		}
		$where.=" and user_id='". $user_id."'";
		$where.=" and status !='inactive'";
		$this->db->where($where,NULL,false);
		$this->db->select('channel_subscription.*, users.channel_name');
		$this->db->from('users');
		$this->db->join('channel_subscription','users.id = channel_subscription.channel_id','INNER');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	
	public function getAllChannelByUserId($user_id,$data,$start,$limit){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (channel_name like '%".$data['name']."%')";
		}
		$where.=" and user_id='". $user_id."'";
		$where.=" and status !='inactive'";
		$this->db->where($where,NULL,false);
		$this->db->select('channel_subscription.*, users.channel_name');
		$this->db->from('users');
		$this->db->join('channel_subscription','users.id = channel_subscription.channel_id','INNER');
		$query  =   $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}

	public function  getBraintreeAccountId($producer_id) {
		$query  = "SELECT *  FROM `braintree_merchant_info` WHERE `producer_id` = ".$producer_id;
		$result = $this->db->query($query);
		$row    = $result->row();
		$braintree_merchant = $row->merchant_account_number;
		return $braintree_merchant;
		//echo "<pre>"; print_r($row);die();
	}
	
	public function insertpaymentLogs($data){
		$this->db->insert('payment_logs',$data);
		//echo $this->db->last_query();
		return true;
	}
	
	public function countTotalPaymentLogsRowsByUserId($user_id,$data)
	{
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (channel_name like '%".$data['name']."%')";
		}
		$where.=" and user_id='". $user_id."'";
		$this->db->where($where,NULL,false);
		$this->db->select('payment_logs.*, users.channel_name');
		$this->db->from('users');
		$this->db->join('payment_logs','users.id = payment_logs.channel_id','right outer');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	
	public function countTotalPaymentLogsRowsByChannelId($user_id,$data)
	{
		$where = "  1=1 ";	
		$where.=" and channel_id='". $user_id."'";
		$this->db->where($where,NULL,false);
		$this->db->from('payment_logs');
		$query  =   $this->db->get();
		return $query->num_rows();
	}
	
	public function getAllPaymentHistoryByUserId($user_id,$data,$start,$limit){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$where = "  1=1 ";	
		if(isset($data['name']) && $data['name']!=''){
			$where.=" and (channel_name like '%".$data['name']."%')";
		}
		$where.=" and user_id='". $user_id."'";
		$this->db->where($where,NULL,false);
		$this->db->select('payment_logs.*, users.channel_name');
		$this->db->from('users');
		$this->db->join('payment_logs','users.id = payment_logs.channel_id','right outer');
		$query  =   $this->db->get();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	public function getAllPaymentHistoryByChannelId($user_id,$data,$start,$limit){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$where = "  1=1 ";	
		$where.=" and channel_id='". $user_id."'";
		$this->db->where($where,NULL,false);
		$this->db->from('payment_logs');
		$query  =   $this->db->get();
		if($query->num_rows())
		{
			return $query->result();
		}
		return array();
	}
	
	function getSubscriptionRow($id){
		$this->db->where("id",$id);
		$this->db->where('user_id',$this->ion_auth->get_user_id());
		$query = $this->db->get('channel_subscription');
		if($query->num_rows()>0){
			return $query->row();	
		}
		return array();
	}
	
	public function unsubcribeChannelById($id,$data){
		$data['status'] = 'inactive';
		$this->db->where('id',$id);
		$this->db->where('user_id',$this->ion_auth->get_user_id());
		$this->db->update('channel_subscription',$data);
		return true;
	}
	public function getUserbanner(){
		$this->db->select('banner');
		$this->db->where('id',$this->ion_auth->get_user_id());
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row[0];	
		}
		return array();
	}
	
	public function getUserbannerById($id){
		$this->db->select(' banner');
		$this->db->where('id',$id);
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row[0];	
		}
		return array();
	}
	
	public function getChannelsUserInfo(){
		$this->db->select('id, channel_name, banner');
		$this->db->where('channel_name <>','');
		$query = $this->db->get('users');
		// echo $this->db->last_query();
		// die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row;	
		}
		return array();
	}
	
	public function getChannelNameById($id){
		$this->db->select('channel_name');
		$this->db->where('id',$id);
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()>0){
			$row = $query->result_array();
			return $row[0];	
		}
		return array();
	}
	// function for payment cron jobs //////
	public function getNextUserIDForCurrentLogs(){
		$query  = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$this->db->database."' AND TABLE_NAME = 'payment_logs'";
		$result = $this->db->query($query);
		$row    = $result->result();
		return $row[0]->AUTO_INCREMENT;
	}
	
	public function getCurrentRenewPakcages($user_id=''){
		$d = date("Y-m-d");
		// $this->db->where("next_recharge_date",$d);
		// $query = $this->db->get('channel_subscription');

		$this->db->select('channel_subscription.*');
		$this->db->select('users.braintree_payment_token');
		$this->db->join('users', 'channel_subscription.user_id = users.id');
		$this->db->where("channel_subscription.next_recharge_date",$d);
		$query = $this->db->get('channel_subscription');
		// echo $this->db->last_query();
		// die();

		if($query->num_rows()){
			$row = $query->result();
			return $row;
		}
		return array();
	}
	
	public function updateChannelSubscription($data,$id){
		$this->db->where('id',$id);
		$this->db->update('channel_subscription',$data);
		return true;
	}
	
	function getChannelSubscriptionDetailBySubscriptionID($sid){
		$this->db->where("subscription_id",$sid);
		$query = $this->db->get('channel_subscription');

		if($query->num_rows()){
			$row = $query->row();
			return $row;
		}
		return array();
	}
	
	function updateSubscriptionDetail($data,$id){
		$this->db->where('id', $id);
		$this->db->update('channel_subscription', $data);
	}

}//end class
?>