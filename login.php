<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);


// include('inc/class_session.inc.php');
// $session = new Session();
session_start();

// includes
include('inc/db.php');
include('inc/global_vars.php');
include('inc/functions.php');

// debug($_POST);

$ip 							= $_SERVER['REMOTE_ADDR'];
$user_agent     				= $_SERVER['HTTP_USER_AGENT'];

$now 							= time();

$username 						= post('username');
$password 						= post('password');

// debug($_POST);

// $email 							= addslashes($email);
// $password 						= addslashes($password);

$query = $conn->query("SELECT `id`,`type` FROM `users` WHERE `username` = '".$username."' AND `password` = '".$password."' ");
if($query !== FALSE) {
	$user = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($user)) {
		if($user['status'] == 'enabled'){
			$_SESSION['logged_in']					= true;
			$_SESSION['account']['id']				= $user['id'];
			$_SESSION['account']['type']			= $user['type'];		

			go("dashboard.php?c=home");
		}else{
			status_message('danger',"Account Status: ".$user['status']);
			go("index.php");
		}
	}else{
		status_message('danger',"User and / or password incorrect.");
		go("index.php");
	}
}else{
	status_message('danger',"Error, contact support.");
	go("index.php");
}

?>