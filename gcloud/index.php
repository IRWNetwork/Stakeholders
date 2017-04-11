<?php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

$storage = new StorageClient([
    'projectId' => 'irw-network'
]);

//$bucket = $storage->bucket('irw-network');


$options = [
    'predefinedAcl' => 'publicRead',
    'name' => 'aasdf.jpg'
];

$buckets = $storage->bucket('irw-network');
$asdfaf=  $buckets->upload(
    fopen('../uploads/listing/thumb_400_file_1482184710.png', 'r'),
    $options
);
$info = $asdfaf->info();
//print_r($info);
echo $info['mediaLink'];die;

//$acl = $asdfaf->acl();
print_r($acl->requestBuilder);echo 'aaaaaaaaaa';

echo 'aaaaaaaaaa';
echo($acl->selfLink);
die;

$buckets = $storage->buckets();

foreach ($buckets as $bucket) {
    //echo $bucket->name() . PHP_EOL;
	
	$object = $bucket->object('file_1489001074');
	$stream = $object->downloadAsStream();
	$data = $stream->getContents();
	header("Content-Disposition: attachment; filename=file_1489001074");
	  //header("Content-Disposition: attachment; filename={$fileNameToDownload}");
	  header("Content-Type: text");
	  //header("Content-Type: image/jpg");
	  header("Content-Length: " . strlen($data));
	  echo $data;
	  
	die;
	
}
die('her123e');
// require 'vendor/autoload.php';

// use Google\Cloud\Storage\StorageClient;

// $storage = new StorageClient([
//     'projectId' => 'irw-network'
// ]);





// $buckets = $storage->bucket('irw-network');
// $buckets->upload(
//     fopen('../uploads/listing/thumb_400_file_1482184710.png', 'r')
// );
// die;

// print_r($buckets);
// foreach ($buckets as $bucket) {
//     echo $bucket->name() . PHP_EOL;
	
	/*$object = $bucket->object('download.jpg');
	$stream = $object->downloadAsStream();
	$data = $stream->getContents();
	header("Content-Disposition: attachment; filename=test.jpg");
	  //header("Content-Disposition: attachment; filename={$fileNameToDownload}");
	  header("Content-Type: text");
	  //header("Content-Type: image/jpg");
	  header("Content-Length: " . strlen($data));
	  echo $data;
	  
	die;*/
	
// }
// die;

// $buckets = $storage->buckets();
// foreach ($buckets as $bucket) {
//     echo $bucket->name() . PHP_EOL;
// }
// die('her123e');