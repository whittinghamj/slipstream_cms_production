<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$post = $_POST;
// $post = file_get_contents("php://input");

$req = '';
foreach($post as $key => $value){
	$req .= $key.$value;
}

file_put_contents('/home2/slipstream/public_html/hub/logs/'.$_GET['stream_id'].'_progress.log', $req);
die();