<?php
// session_start();

header("Access-Control-Allow-Origin: *");

// includes
include('../inc/global_vars.php');
include('../inc/db.php');
include('../inc/functions.php');

// make sure username is set
$username = get('username');
$username = addslashes($username);
if(empty($username)) {
	echo '<pre>';
	print_r($_GET);
	die('missing username');
}

// make sure password is set
$password = get('password');
$password = addslashes($password);
if(empty($password)) {
	echo '<pre>';
	print_r($_GET);
	die('missing password');
}

// check if username and password are valid
$query = $conn->query("SELECT * FROM `customers` WHERE `username` = '".$username."' AND `password` = '".$password."' ");
$customer = $query->fetch(PDO::FETCH_ASSOC);

if(empty($customer)) {
	header('HTTP/1.0 403 Forbidden');
	die("customer not found");
}

if($customer['status'] != 'enabled') {
	header('HTTP/1.0 403 Forbidden');
	die("account status: ".$customer['status']);
}

// count existing connections and check for max allowed
$connection_allowed = is_customer_connection_allowed($customer['id']); 
if($connection_allowed == 'no') {
	header('HTTP/1.0 403 Forbidden');
	die("connection limit reached");
}

// make sure server id is set
$server_id = get('server_id');
$server_id = addslashes($server_id);
if(empty($server_id)) {
	echo '<pre>';
	print_r($_GET);
	die('missing server_id');
}

// make sure stream id is set
$stream_id = get('stream_id');
$stream_id = addslashes($stream_id);
if(empty($stream_id)) {
	echo '<pre>';
	print_r($_GET);
	die('missing stream_id');
}

$stream_bits = explode('.', $stream_id);
if(is_array($stream_bits) && isset($stream_bits[1])) {
	$stream_id = $stream_bits[0];
	$stream_ext = $stream_bits[1];
}else{
	$stream_ext = 'm3u8';
}

// check if stream exists
$query = $conn->query("SELECT `id` FROM `streams` WHERE `id` = '".$stream_id."' AND `server_id` = '".$server_id."' ");
$stream = $query->fetch(PDO::FETCH_ASSOC);

if(empty($stream)) {
	header('HTTP/1.0 404 Not Found');
	echo '<pre>';
	print_r($_GET);
	die("stream not found");
}

// get headend data for stream
$query = $conn->query("SELECT `wan_ip_address`,`http_stream_port` FROM `headend_servers` WHERE `id` = '".$server_id."' ");
$stream['headend'] = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($stream['headend'])) {
	header('HTTP/1.0 404 Not Found');
	echo '<pre>';
	print_r($_GET);
	die("headend not found");
}

// build stream_url
// $stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/play/hls/'.$stream['id'].'/index.php?username='.$username.'&password='.$password;
$stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/live/'.$username.'/'.$password.'/'.$stream['id'].'/'.$stream['id'].'.'.$stream_ext;

if(isset($_GET['dev']) && $_GET['dev'] == 'yes') {
	echo '<pre>';
	print_r($_GET);
	print_r($stream);

	if(isset($stream_bits[1])){
		print_r($stream_bits);
	}
	echo '<hr>';

	echo $stream['stream_url'];
}else{
	header("Location: ".$stream['stream_url'], true, 301);
	exit();
}

exit;