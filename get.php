<?php

$path_to_base_inc = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "inc";
if(is_dir($path_to_base_inc)){
    require_once($path_to_base_inc . DIRECTORY_SEPARATOR . "db.php");
    require_once($path_to_base_inc . DIRECTORY_SEPARATOR . "functions.php");
    require_once($path_to_base_inc . DIRECTORY_SEPARATOR . "global_vars.php");
}

$username = get("username");
$password = get("password");
$type     = get("type");
$output   = get("output");

//Verify username and password.
$sql = "SELECT `username`, `password`, `expire_date` FROM customers WHERE username = '" . $username ."' AND password = '" . $password . "'";
$query = $conn->query($sql);
$result = $query->fetch(PDO::FETCH_ASSOC);

if(is_array($result) && !empty($result)){
    //Check to make sure its an active account.
    $current_date = time();
    if($result["expire_date"] >= time()){
        //Build the fucking m3u.
        $customers_url_file = "http://hub.slipstreamiptv.com/customers/index.php";
        require_once($customers_url_file);

    } else {
        exit( json_encode( array("false")));
    }
} else {
    exit( json_encode( array("false")));
}