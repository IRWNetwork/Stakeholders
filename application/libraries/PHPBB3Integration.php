<?php
define('ROOT_PATH', "forums/");	// map this dir to your own installation of phpbb
define('IN_PHPBB', true);
//if (!defined('IN_PHPBB') || !defined('ROOT_PATH')) exit();
$phpEx = "php";
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : ROOT_PATH . '/';
include($phpbb_root_path . 'common.' . $phpEx);

class Phpbb3Integration {
	var $table_prefix;
	var $connection;
	var $lang;
	var $default_timezone;
	var $user_dst;
	var $user_dateformat;
	var $user_colour;
	
	function Phpbb3Integration($table_prefix = 'phpbb_') {
		$user->session_begin();
$auth->acl($user->data);
$user->setup();
														// CONFIG
														// ======
		$this->lang					= "it";				// language, I've tried "it" and "en"
		$this->default_timezone		= "1.00";			// +1 hour
		$this->user_dst				= 1;				// use legal time
		$this->user_dateformat		= "|d/m/Y|, G:i";	// date format
		$this->user_colour			= "9E8DA7";			// user colour
		$this->table_prefix			= $table_prefix;
	}
	
	function connect($server,$dbuser,$dbpass,$dbname) {
		$this->connection = mysql_connect ( $server, $dbuser, $dbpass );
		if (!$this->connection) return false;
		if (!mysql_select_db ( $dbname, $this->connection )) return false;
		return true;
	}
	
	function addNewUser($username,$password,$email,$ip) {
		$sql = $this->createSqlToAddUserRow ( $username, $password, $email, $ip );
		mysql_query ( $sql, $this->connection );
		$id = mysql_insert_id ( $this->connection );
		$sql = $this->createSqlToAddUserGroupRow ( $id );
		mysql_query ( $sql, $this->connection );
	}
	
	function changeUserPassword($username,$password) {
		$sql = $this->createSqlToUpdateUserPassword ( $username, $password );
		mysql_query ( $sql, $this->connection );
	}
	
	function disableUser($username) {
		// first get phpbb internal id for username
		$sql = "select user_id from " . $this->table_prefix . "users where username = '$username'";
		$query = mysql_query ( $sql, $this->connection );
		if (! $query) return false;
		$id = mysql_result ( $query, 0 );
		// create ban row
		$banSql = "insert into " . $this->table_prefix . 'banlist (ban_userid,  ban_start,  ban_reason, ban_give_reason)';
		$banSql .= "values ('$id','" . time () . "', 'External Integration','Banned by External Integration')";
		mysql_query ( $banSql, $this->connection );
	}
	
	function enableUser($username) {
		// first get phpbb internal id for username
		$sql = "select user_id from " . $this->table_prefix . "users where username = '$username'";
		$query = mysql_query ( $sql, $this->connection );
		if (! $query) return false;
		$id = mysql_result ( $query, 0 );
		// delete ban row
		$deleteSql = "DELETE FROM " . $this->table_prefix . 'banlist where ban_userid = ' . $id;
		$query = mysql_query ( $deleteSql, $this->connection );
		return ($query != false);
	}
	

	// Helper Methods
	// ==============
	/**
	 * Generate salt for hash generation
	 */
	function _hash_gensalt_private($input,&$itoa64,$iteration_count_log2 = 6) {
		if ($iteration_count_log2 < 4 || $iteration_count_log2 > 31) $iteration_count_log2 = 8;
		$output = '$H$';
		$output .= $itoa64 [min ( $iteration_count_log2 + ((PHP_VERSION >= 5) ? 5 : 3), 30 )];
		$output .= $this->_hash_encode64 ( $input, 6, $itoa64 );
		return $output;
	}
	
	/**
	 * Encode hash
	 */
	function _hash_encode64($input,$count,&$itoa64) {
		$output = '';
		$i = 0;
		do {
			$value = ord ( $input [$i ++] );
			$output .= $itoa64 [$value & 0x3f];
			if ($i < $count) $value |= ord ( $input [$i] ) << 8;
			$output .= $itoa64 [($value >> 6) & 0x3f];
			if ($i ++ >= $count) break;
			if ($i < $count) $value |= ord ( $input [$i] ) << 16;
			$output .= $itoa64 [($value >> 12) & 0x3f];
			if ($i ++ >= $count) break;
			$output .= $itoa64 [($value >> 18) & 0x3f];
		} while ( $i < $count );
		return $output;
	}
	
	/**
	 * The crypt function/replacement
	 */
	function _hash_crypt_private($password,$setting,&$itoa64) {
		$output = '*';
		// Check for correct hash
		if (substr ( $setting, 0, 3 ) != '$H$') return $output;
		$count_log2 = strpos ( $itoa64, $setting [3] );
		if ($count_log2 < 7 || $count_log2 > 30) return $output;
		$count = 1 << $count_log2;
		$salt = substr ( $setting, 4, 8 );
		if (strlen ( $salt ) != 8) return $output;
		
		/**
		 * We're kind of forced to use MD5 here since it's the only
		 * cryptographic primitive available in all versions of PHP
		 * currently in use.  To implement our own low-level crypto
		 * in PHP would result in much worse performance and
		 * consequently in lower iteration counts and hashes that are
		 * quicker to crack (by non-PHP code).
		 */
		if (PHP_VERSION >= 5) {
			$hash = md5 ( $salt . $password, true );
			do {
				$hash = md5 ( $hash . $password, true );
			} while ( -- $count );
		} else {
			$hash = pack ( 'H*', md5 ( $salt . $password ) );
			do {
				$hash = pack ( 'H*', md5 ( $hash . $password ) );
			} while ( -- $count );
		}
		$output = substr ( $setting, 0, 12 );
		$output .= $this->_hash_encode64 ( $hash, 16, $itoa64 );
		return $output;
	}
	
	function unique_id($extra = 'c') {
		static $dss_seeded = false;
		global $config;
		$val = $config ['rand_seed'] . microtime ();
		$val = md5 ( $val );
		$config ['rand_seed'] = md5 ( $config ['rand_seed'] . $val . $extra );
		$dss_seeded = true;
		return substr ( $val, 4, 16 );
	}
	
	function phpbb_hash($password) {
		$itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$random_state = $this->unique_id ();
		$random = '';
		$count = 6;
		if (($fh = @fopen ( '/dev/urandom', 'rb' ))) {
			$random = fread ( $fh, $count );
			fclose ( $fh );
		}
		if (strlen ( $random ) < $count) {
			$random = '';
			for($i = 0; $i < $count; $i += 16) {
				$random_state = md5 ( $this->unique_id () . $random_state );
				$random .= pack ( 'H*', md5 ( $random_state ) );
			}
			$random = substr ( $random, 0, $count );
		}
		$hash = $this->_hash_crypt_private ( $password, $this->_hash_gensalt_private ( $random, $itoa64 ), $itoa64 );
		if (strlen ( $hash ) == 34) return $hash;
		return md5 ( $password );
	}
	
	function createSqlToAddUserRow($username,$password,$email,$ip) {
		$sql = "INSERT INTO `" . $this->table_prefix . "users` (";
		$sql .= "`user_id`, `user_type`, `group_id`, `user_permissions`, `user_perm_from`, `user_ip`, `user_regdate`, `username`, `username_clean`, `user_password`, `user_passchg`, `user_pass_convert`, `user_email`, `user_email_hash`, `user_birthday`, `user_lastvisit`, `user_lastmark`, `user_lastpost_time`, `user_lastpage`, `user_last_confirm_key`, `user_last_search`, `user_warnings`, `user_last_warning`, `user_login_attempts`, `user_inactive_reason`, `user_inactive_time`, `user_posts`, `user_lang`, `user_timezone`, `user_dst`, `user_dateformat`, `user_style`, `user_rank`, `user_colour`, `user_new_privmsg`, `user_unread_privmsg`, `user_last_privmsg`, `user_message_rules`, `user_full_folder`, `user_emailtime`, `user_topic_show_days`, `user_topic_sortby_type`, `user_topic_sortby_dir`, `user_post_show_days`, `user_post_sortby_type`, `user_post_sortby_dir`, `user_notify`, `user_notify_pm`, `user_notify_type`, `user_allow_pm`, `user_allow_viewonline`, `user_allow_viewemail`, `user_allow_massemail`, `user_options`, `user_avatar`, `user_avatar_type`, `user_avatar_width`, `user_avatar_height`, `user_sig`, `user_sig_bbcode_uid`, `user_sig_bbcode_bitfield`, `user_from`, `user_icq`, `user_aim`, `user_yim`, `user_msnm`, `user_jabber`, `user_website`, `user_occ`, `user_interests`, `user_actkey`, `user_newpasswd`, `user_form_salt`";
		$sql .= ")";
		$sql .= "VALUES (";
		$sql .= "NULL, '0', '2', '00000000006xv1ssxs\ni1cjyo000000\nqlc4pi000000\nzik0zi000000', '0', '" . $ip . "', '" . time () . "', '$username', '$username',";
		$sql .= "'" . $this->phpbb_hash ( $password ) . "', '" . time () . "', '0', '$email',";
		$sql .= " '0', '', '" . time () . "', '" . time () . "', '" . time () . "', '', '',";
		$sql .= "'0', '0', '0', '0', '0', '0', '0',";
		$sql .= "'{$this->lang}', '{$this->default_timezone}', '{$this->user_dst}', '{$this->user_dateformat}', '1', '0',";
		$sql .= "'{$this->user_colour}', '0', '0', '0', '0', '-3', '0', '0', 't', 'd', '0', 't', 'a', '0', '1', '0', '1', '1', '1',";
		$sql .= "'1', '895', '', '0', '0', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1a99da7f3160cc5c'";
		$sql .= ")";
		return $sql;
	}
	
	function createSqlToAddUserGroupRow($phpbb_user_id) {
		$sql = "INSERT INTO `" . $this->table_prefix . "user_group` (`group_id`, `user_id`, `group_leader`, `user_pending`) VALUES ('2', '$phpbb_user_id', '0', '0')";
		return $sql;
	}
	
	function createSqlToUpdateUserPassword($username,$newPassword) {
		$sql = "update `" . $this->table_prefix . "users` set user_password = '" . $this->phpbb_hash ( $newPassword ) . "' where username = '" . $username . "'";
		return $sql;
	}

}
?>