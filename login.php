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

$email 							= post('email');
$password 						= post('password');

// debug($_POST);

// $email 							= addslashes($email);
// $password 						= addslashes($password);

// admin login via local system 
if($email == 'admin@streamwizz.com'){
	$query = $conn->query("SELECT * FROM `users` WHERE `email` = '".$email."' AND `password` = '".$password."' ");
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
}

// lets try whmcs
$postfields["username"] 		= $whmcs['username']; 
$postfields["password"] 		= $whmcs['password'];
$postfields["action"] 			= "validatelogin";
$postfields["email"] 			= $email;
$postfields["password2"] 		= $password;
$postfields["responsetype"] 	= 'json';
$postfields['accesskey']		= $whmcs['accesskey'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 300);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSLVERSION,3);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
$data = curl_exec($ch);
curl_close($ch);

$results = json_decode($data, true);

// debug($whmcs);

// debug($results);

if($results["result"]=="success"){
    // login confirmed
	
	$_SESSION['account']['id'] 		= $results['userid'];
	$_SESSION['account']['email'] 	= $email;
	$user_id 						= $results['userid'];

	// lets get client details
	$postfields["username"] 			= $whmcs['username'];
	$postfields["password"] 			= $whmcs['password'];
	$postfields["responsetype"] 		= "json";
	$postfields["action"] 				= "getclientsdetails";
	$postfields["clientid"] 			= $user_id;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSLVERSION,3);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$client_data = curl_exec($ch);
	curl_close($ch);

	$client_data = json_decode($client_data, true);

	// debug($client_data);

	// lets check their product status for late / non payment
	$postfields["username"] 			= $whmcs['username'];
	$postfields["password"] 			= $whmcs['password'];
	$postfields["responsetype"] 		= "json";
	$postfields["action"] 				= "getclientsproducts";
	$postfields["clientid"] 			= $user_id;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSLVERSION,3);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	$data = curl_exec($ch);
	curl_close($ch);

	$data = json_decode($data, true);

	// debug($data);

	foreach($data['products']['product'] as $product)
	{
		if (in_array($product['pid'], $product_ids)) {
		    // product match for this platform

		    if($product['status'] != 'Active'){
				// forward to billing area
				$whmcsurl 			= "https://clients.deltacolo.com/dologin.php";
				$autoauthkey 		= "admin1372";
				$email 				= $email;
				
				$timestamp 			= time(); 
				$goto 				= "clientarea.php";
				
				$hash 				= sha1($email.$timestamp.$autoauthkey);
				
				$url 				= $whmcsurl."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);
				go($url);
			}else{
				$query = $conn->query("SELECT * FROM `users` WHERE `id` = '".$user_id."' ");
				if($query !== FALSE) {
					$user = $query->fetch(PDO::FETCH_ASSOC);

					if(!$user){
						$dt2 = new DateTime("+1 month");
						$expires_in_one_month = $dt2->format("Y-m-d");

						$insert = $conn->exec("INSERT INTO `users` 
					        (`id`,`first_name`,`last_name`,`email`,`username`,`password`)
					        VALUE
					        ('".$client_data['userid']."',
					        '".addslashes($client_data['firstname'])."',
					        '".addslashes($client_data['lastname'])."',
					        '".$email."',
					        'user".rand(000000000,999999999)."',
					        '".$password."'
					    )");

					    $user['type'] = 'customer';

					    $customer_id = $conn->lastInsertId();
					}else{
						$update = $conn->exec("UPDATE `users` SET `first_name` = '".addslashes($client_data['firstname'])."' WHERE `id` = '".$client_data['userid']."' ");
						$update = $conn->exec("UPDATE `users` SET `last_name` = '".addslashes($client_data['lastname'])."' WHERE `id` = '".$client_data['userid']."' ");
					}

					$_SESSION['logged_in']					= true;
					$_SESSION['account']['id']				= $client_data['userid'];
					$_SESSION['account']['type']			= $user['type'];	

					status_message('success', 'Login successful');
					go($site['url'].'dashboard.php?c=home');
				}
			}
		}
	}
	
	// login rejected due to now having the right product
	status_message('danger', 'You do not have a valid license.');
	go($site['url'].'login_form.php');
} else {
	// check if its a reseller

	// check for reseller account
	/*
	$query = $conn->query("SELECT * FROM `resellers` WHERE `email` = '".$email."' AND `password` = '".$password."' ");
	if($query !== FALSE) {
		$user = $query->fetch(PDO::FETCH_ASSOC);
		if($user['status'] == 'enabled'){
			$_SESSION['logged_in']					= true;
			$_SESSION['account']['id']				= $user['id'];
			$_SESSION['account']['type']			= 'reseller';		
			go("dashboard.php");
		}
	}
	*/

	// login rejected
	status_message('danger', 'Incorrect Login details');
	go($site['url'].'index.php');
}


?>