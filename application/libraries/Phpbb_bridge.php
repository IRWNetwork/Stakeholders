<?php 
/**
* CodeIgniter phpBB Bridge
*/

class Phpbb_bridge
{

	public $CI;
	protected $_user;
	/**
	* Constructor.
	*/
	public function __construct()
	{
		if (!isset($this->CI)){
			$this->CI =& get_instance();
		}

		define('IN_PHPBB', true);
		global $request;
		global $phpbb_container;
		global $phpbb_root_path, $phpEx, $user, $auth, $cache, $db, $config, $template, $table_prefix;
		global $request;
		global $phpbb_dispatcher;
		global $symfony_request;
		global $phpbb_filesystem;
		$phpbb_root_path = '../irw/forums/'; //the path to your phpbb relative to this script
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		include("forums/common.php"); ////the path to your phpbb relative to this script
		// Start session management
		$user->session_begin();
		$auth->acl($user->data);
		$user->setup();

		// Save user data into $_user variable
		$this->_user = $user;
	}
	/**
	* @param $email
	* @param $username
	* @param $password
	* @return unknown_type</pre>
	*/
	public function user_add($email, $username, $password,$grp)
	{	
		$user_row = array(
			'username' => $username,
			'user_password' => phpbb_hash($password),
			'user_email' => $email,
			'group_id' => $grp, // by default, the REGISTERED user group is id 2
			'user_timezone' => (float) date('T'),
			'user_lang' => 'bg',
			'user_type' => USER_NORMAL,
			'user_ip' => $_SERVER['REMOTE_ADDR'],
			'user_regdate' => time(),
		);
	
		return user_add($user_row, false);	
	}
/**
* @param $username
* @param $password
* @return bool
*/
	public function user_edit($username, $password)
	{
		return user_edit($username, $password);
	}
	/*
	* Logins the user in forum
	*/
	public function user_login($username, $password)
	{
		$auth = new auth();
		return $auth->login($username, $password);
	}
	public function user_logout()
	{
		$this->_user->session_kill();
		$this->_user->session_begin();
		return;
	}
	/**
	* @param $user_id
	* @return unknown_type
	*/
	public function user_delete($user_id)
	{
		return user_delete('remove', $user_id, false);
	}
}
