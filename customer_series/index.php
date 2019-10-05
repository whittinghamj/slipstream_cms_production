<?php
session_start();

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

// make sure series id is set
$series_id = get('series_id');
$series_id = addslashes($series_id);
if(empty($series_id)) {
	echo '<pre>';
	print_r($_GET);
	die('missing series_id');
}

// check if series exists
$query = $conn->query("SELECT `id` FROM `tv_series_files` WHERE `id` = '".$series_id."' ");
$series = $query->fetch(PDO::FETCH_ASSOC);

if(empty($series)) {
	header('HTTP/1.0 404 Not Found');
	echo '<pre>';
	print_r($_GET);
	die("series not found");
}

// get headend data for stream
$query = $conn->query("SELECT `wan_ip_address`,`http_stream_port` FROM `headend_servers` WHERE `id` = '".$server_id."' ");
$headend = $query->fetch(PDO::FETCH_ASSOC);

if(empty($headend)) {
	header('HTTP/1.0 404 Not Found');
	echo '<pre>';
	print_r($_GET);
	die("headend not found");
}

// build stream_url
// $stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/live/'.$username.'/'.$password.'/'.$stream['id'].'/'.$stream['id'].'.m3u8';
$series['url'] = 'http://'.$headend['wan_ip_address'].':'.$headend['http_stream_port'].'/series/'.$username.'/'.$password.'/'.$series['id'].'/'.$series['id'].'.m3u8';

if(isset($_GET['dev']) && $_GET['dev'] == 'yes') {
	echo '<pre>';
	print_r($series);

	echo '<hr>';

	echo $series['url'];
}else{
	header("Location: ".$series['url'], true, 301);
	// echo $series['url'];
	exit();
}

exit;