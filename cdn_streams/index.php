<?php
session_start();

// includes
include('../inc/db.php');
include('../inc/global_vars.php');
include('../inc/functions.php');

// make sure server id is set
$server_id = get('server_id');
if(empty($server_id)) {
	echo '<pre>';
	print_r($_GET);
	die('missing server_id');
}

// make sure stream id is set
$link_id = get('link_id');
if(empty($link_id)) {
	echo '<pre>';
	print_r($_GET);
	die('missing link_id');
}

$query = $conn->query("SELECT * FROM `cdn_streams_servers` WHERE `id` = '".$link_id."' AND `server_id` = '".$server_id."' ");
$links = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($links)) {
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

foreach($links as $link) {
	// get actual stream data
	$query = $conn->query("SELECT * FROM `cdn_streams` WHERE `id` = '".$link['stream_id']."' ");
	$stream = $query->fetchAll(PDO::FETCH_ASSOC);

	// get headend data for stream
	$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$link['server_id']."' ");
	$headend = $query->fetchAll(PDO::FETCH_ASSOC);

	// build stream_url
	$stream_url = 'http://'.$headend[0]['wan_ip_address'].':'.$headend[0]['http_stream_port'].'/play/hls/'.$stream[0]['publish_name'].'/index.m3u8';
}

if(isset($_GET['dev']) && $_GET['dev'] == 'yes') {
	echo '<pre>';
	print_r($_GET);
	print_r($links);
	print_r($headend);
	print_r($stream);

	echo '<hr>';

	echo 'Stream URL: '.$stream_url;
}else{
	header("Location: ".$stream_url, true, 301);
	exit();
}

exit;