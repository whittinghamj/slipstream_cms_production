<?php

$host			= 'localhost';
$db 			= 'slipstream_cms';
$username 		= 'slipstream';
$password 		= 'admin1372';

$dsn			= "mysql:host=$host;dbname=$db";

try{
	$conn = new PDO($dsn, $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
	echo $e->getMessage();
}