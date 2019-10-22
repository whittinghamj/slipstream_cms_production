<?php
header("strict-transport-security: max-age=600");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1");

// DEFINE VARIABLES
define('HOST', '51.254.31.166');
define('USER', 'xapicode');
define('PASSWORD', 'l5agnaidng==');
define('DATABASE', 'iptv_xapicode');
define('USERAGENT', 'SlipStream IPTV');
define('DOCROOT', '/var/www/html/c/');
define('SERVER', 1);

require_once '/var/www/html/portal/c/_system/class/class.proxychecker.php';
require_once '/var/www/html/portal/c/_system/function/function.main.php';

date_default_timezone_set('Europe/London');
ini_set('date.timezone', 'Europe/London');

// DEBUG OPTIONS
//error_reporting(0);
?>
