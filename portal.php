<?php

$path_to_base = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
$path_to_lib = $path_to_base . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR;
$path_to_class = $path_to_lib . "classes" . DIRECTORY_SEPARATOR;

if(file_exists($path_to_class . "BaseClass.php")){
    require_once($path_to_class . "BaseClass.php");
} else {
    die("Missing required Elements.");
}

if(file_exists($path_to_class . "mag_device.php")){
    require_once($path_to_class . "mag_device.php");
} else {
    die("Missing required Device element.");
}

$path_to_inc = $path_to_base . "inc" . DIRECTORY_SEPARATOR;
if(file_exists($path_to_inc . "db.php")){
    require_once($path_to_inc . "db.php");
} else {
    die("Missing required DB element");
}

if(file_exists($path_to_inc . "functions.php")){
    require_once($path_to_inc . "functions.php");
} else {
    die("Missing my required functions");
}

if(file_exists($path_to_inc . "global_vars.php")){
    require_once($path_to_inc . "global_vars.php");
} else {
    die("Missing my required globals");
}

@header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma: no-cache");
@header("Content-type: text/javascript");

$data                       = array();
$data['timestamp']          = time();
$data['req_ip']             = (!empty($_SERVER["REMOTE_ADDR"])                  ? $_SERVER["REMOTE_ADDR"] : NULL);
$data['req_type']           = (!empty($_REQUEST["type"])                        ? $_REQUEST["type"] : NULL);
$data['type']               = $_GET['type'];
$data['req_action']			= $_GET['action'];
$data['action']				= $_GET['action'];
$data['token']				= $_GET['token'];
$data['JsHttpRequest']		= $_GET['JsHttpRequest'];
$data['sn']                 = (!empty($_REQUEST["sn"])                          ? $_REQUEST["sn"] : NULL);
$data['stb_type']           = (!empty($_REQUEST["stb_type"])                    ? $_REQUEST["stb_type"] : NULL);
$data['ver']                = (!empty($_REQUEST["ver"])                         ? $_REQUEST["ver"] : NULL);
$data['user_agent']         = (!empty($_SERVER["HTTP_X_USER_AGENT"])            ? $_SERVER["HTTP_X_USER_AGENT"] : NULL);
$data['image_version']      = (!empty($_REQUEST["image_version"])               ? $_REQUEST["image_version"] : NULL);
$data['device_id']          = (!empty($_REQUEST["device_id"])                   ? $_REQUEST["device_id"] : NULL);
$data['device_id2']         = (!empty($_REQUEST["device_id2"])                  ? $_REQUEST["device_id2"] : NULL);
$data['hw_version']         = (!empty($_REQUEST["hw_version"])                  ? $_REQUEST["hw_version"] : NULL);
$data['gmode']              = (!empty($_REQUEST["gmode"])                       ? intval($_REQUEST["gmode"]) : NULL);
$data['continue']           = false;
$data['debug']              = true;
$data['mac']                = $_COOKIE['mac'];
$data['stb_lang']           = $_COOKIE['stb_lang'];
$data['timezone']           = $_COOKIE['timezone'];

$mag = new mag_device($data["mac"], $conn, $data);

$mag_require = "require_" . $data["req_type"];
$mag_json = $mag->$mag_require($data["req_action"]);

die($mag_json);

?>
