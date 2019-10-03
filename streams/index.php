<?php
session_start();

// includes
include('../inc/global_vars.php');
include('../inc/db.php');
include('../inc/functions.php');

// make sure server id is set
$server_id = get('server_id');
if(empty($server_id)) {
	echo '<pre>';
	print_r($_GET);
	die('missing server_id');
}

// make sure stream id is set
$stream_id = get('stream_id');
if(empty($stream_id)) {
	echo '<pre>';
	print_r($_GET);
	die('missing stream_id');
}

$query = $conn->query("SELECT * FROM `streams` WHERE `id` = '".$stream_id."' AND `server_id` = '".$server_id."' ");
$streams = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($streams)) {
	die("stream not found");
}

$slipstream_ip = '184.105.154.50';

if($_SERVER['REMOTE_ADDR'] != $slipstream_ip) {
	$query = $conn->query("SELECT * FROM `streams_acl_rules` WHERE `server_id` = '".$server_id."' AND `ip_address` = '".$_SERVER['REMOTE_ADDR']."' ");
	$acl_found = $query->rowCount();

	if($acl_found == 0) {
		header('HTTP/1.0 403 Forbidden');

		echo $_SERVER['REMOTE_ADDR'] . ' is not permitted to access this resource.';
		exit();
	}
}

foreach($streams as $stream) {

	// get headend data for stream
	$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$stream['server_id']."' ");
	$stream['headend'] = $query->fetchAll(PDO::FETCH_ASSOC);

	// build stream_url
	$stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/play/hls/'.$stream_id.'/index.php';
}

if(isset($_GET['dev']) && $_GET['dev'] == 'yes') {
	echo '<pre>';
	print_r($stream);

	echo '<hr>';

	echo $stream['stream_url'];
}else{
	header("Location: ".$stream['stream_url'], true, 301);
	exit();
}

exit;