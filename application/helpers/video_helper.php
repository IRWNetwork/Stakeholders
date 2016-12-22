<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use OpenTok\OpenTok;
use OpenTok\Role;
use OpenTok\MediaMode;

// ------------------------------------------------------------------------
if ( ! function_exists('createVideoConference')){
	function createVideoConference($user_id,$minutes){      

		$CI =& get_instance();
		//load our new PHPExcel library
		$CI->load->library('Video_Conference');
		$CI->load->model('Emailtemplates_model');
		$CI->load->model('VideoConferences_model');
		
		$API_KEY 	= "45724852";
		$API_SECRET = "11933a4e19b8f3286fc936fdfd801d9dca44af19";

		$OpenTokSdk = new OpenTok($API_KEY, $API_SECRET);
		$session = $OpenTokSdk->createSession(array('mediaMode' => MediaMode::ROUTED));
		$sessionId = $session->getSessionId();


		// Generate a Token from just a sessionId (fetched from a database)
		$token = $OpenTokSdk->generateToken($sessionId);
		// Generate a Token by calling the method on the Session (returned from createSession)
		$token = $session->generateToken();
		
		// Set some options in a token
		$modetor_token   = $session->generateToken(array(
		    'role'       => Role::MODERATOR,
		));

		$array = array(
					"user_id"			=> $user_id,
					"minutes"			=> $minutes,
					"type" 	   			=> 'modeator',
					"date" 	   			=> date("Y-m-d H:i:s"),
					"session_id" 		=> $sessionId,
					"token" 	   		=> $modetor_token,
				 );
		$video_conference_id = $CI->VideoConferences_model->save($array);
		if($video_conference_id){
			
			
			$token = $session->generateToken();

			$array_db = array(
							"translator_token" 	=> $token,
						 );
			$video_conference_id = $CI->VideoConferences_model->update($array_db,$video_conference_id);
		}
	}
}

if ( ! function_exists('startArchive')){
	function startArchive($sessionId){
		$CI =& get_instance();
		//load our new PHPExcel library
		$CI->load->library('Video_Conference');
		
		$API_KEY 	= "45724852";
		$API_SECRET = "11933a4e19b8f3286fc936fdfd801d9dca44af19";

		$OpenTokSdk = new OpenTok($API_KEY, $API_SECRET);
		$archive = $OpenTokSdk->startArchive($sessionId);

		// Create an archive using custom options
		/*$archiveOptions = array(
		    'hasAudio' => true,                     // default: true
		    'hasVideo' => true,                     // default: true
		    'outputMode' => OutputMode::INDIVIDUAL  // default: OutputMode::COMPOSED   INDIVIDUAL
		);
		$archive = $OpenTokSdk->startArchive($sessionId, $archiveOptions);*/

		// Store this archiveId in the database for later use

		return $archive->id;
    	//echo json_encode($archive);
		//return $archiveId = $archive->id;
	}
}
if ( ! function_exists('stopArchive')){
	function stopArchive($archiveId){
		$CI =& get_instance();
		//load our new PHPExcel library
		$CI->load->library('Video_Conference');

		$API_KEY 	= "45724852";
		$API_SECRET = "11933a4e19b8f3286fc936fdfd801d9dca44af19";

		$OpenTokSdk = new OpenTok($API_KEY, $API_SECRET);
		// Stop an Archive from an archiveId (fetched from database)
		$OpenTokSdk->stopArchive($archiveId);
		// Stop an Archive from an Archive instance (returned from startArchive)
		//$OpenTokSdk->stop();
		return "1";

	}
}
if(!function_exists('getArchive')){
	function getArchive($archiveId){
		$CI =& get_instance();
		//load our new PHPExcel library
		$CI->load->library('Video_Conference');
		
		$API_KEY 	= "45724852";
		$API_SECRET = "11933a4e19b8f3286fc936fdfd801d9dca44af19";

		$OpenTokSdk = new OpenTok($API_KEY, $API_SECRET);
		$archive = $OpenTokSdk->getArchive($archiveId);
		return $archive;
	}
}
