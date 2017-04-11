<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';

//use Google\Cloud\Storage\StorageClient;

class gcloud {

	public function __construct()
    {
        
    }

    public function uploadData($file) {
  //   	$storage = new StorageClient([
		//     'projectId' => 'irw-network'
		// ]);
  //   	$buckets = $storage->bucket('irw-network');
		// $buckets->upload(
		//     fopen($file, 'r')
		// );
		echo 'hello';
    }

}
// $storage = new StorageClient([
//     'projectId' => 'irw-network'
// ]);

// //$bucket = $storage->bucket('irw-network');

// $buckets = $storage->buckets();

// foreach ($buckets as $bucket) {
//     //echo $bucket->name() . PHP_EOL;
	
// 	$object = $bucket->object('download.jpg');
// 	$stream = $object->downloadAsStream();
// 	$data = $stream->getContents();
// 	header("Content-Disposition: attachment; filename=test.jpg");
// 	  //header("Content-Disposition: attachment; filename={$fileNameToDownload}");
// 	  header("Content-Type: text");
// 	  //header("Content-Type: image/jpg");
// 	  header("Content-Length: " . strlen($data));
// 	  echo $data;
	  
// 	die;
	
// }
// die('her123e');