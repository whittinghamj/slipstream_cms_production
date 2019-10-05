<?php
// session_start();

header("Access-Control-Allow-Origin: *");

// includes
include('../inc/db.php');
include('../inc/global_vars.php');
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

// make sure channel id is set
$channel_id = get('channel_id');
$channel_id = addslashes($channel_id);
if(empty($channel_id)) {
	echo '<pre>';
	print_r($_GET);
	die('missing channel_id');
}

// check if channel exists
$query = $conn->query("SELECT `id` FROM `channels` WHERE `id` = '".$channel_id."' AND `server_id` = '".$server_id."' ");
$channel = $query->fetch(PDO::FETCH_ASSOC);

if(empty($channel)) {
	header('HTTP/1.0 404 Not Found');
	echo '<pre>';
	print_r($_GET);
	die("channel not found");
}

// get headend data for stream
$query = $conn->query("SELECT `wan_ip_address`,`http_stream_port` FROM `headend_servers` WHERE `id` = '".$server_id."' ");
$channel['headend'] = $query->fetchAll(PDO::FETCH_ASSOC);

if(empty($channel['headend'])) {
	header('HTTP/1.0 404 Not Found');
	echo '<pre>';
	print_r($_GET);
	die("headend not found");
}

// build stream_url
// $stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/play/hls/'.$stream['id'].'/index.php?username='.$username.'&password='.$password;
$channel['stream_url'] = 'http://'.$channel['headend'][0]['wan_ip_address'].':'.$channel['headend'][0]['http_stream_port'].'/channel/'.$username.'/'.$password.'/'.$channel['id'].'/'.$channel['id'].'.m3u8';

if(isset($_GET['dev']) && $_GET['dev'] == 'yes') {
	echo '<pre>';
	print_r($channel);

	echo '<hr>';

	echo $channel['stream_url'];
}else{
	header("Location: ".$channel['stream_url'], true, 301);
	exit();
}

exit;