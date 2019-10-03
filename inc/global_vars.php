<?php

$config['version']				= '1.0.0';

// site vars
$site['url']					= 'https://slipstreamiptv.com/';
$site['title']					= 'SlipStreamIPTV';
$site['copyright']				= 'Written by GENEX NETWORKS LLC T/A '.$site['title'].'. <br>Registered in Colorado, USA: 20151830790.';

// logo name vars
$site['name_long']				= 'SlipStream<b>IPTV</b>';
$site['name_short']				= '<b>SS</b>';


$whmcs['url'] 					= "http://clients.deltacolo.com/includes/api.php"; # URL to WHMCS API file
$whmcs["username"] 				= "apiuser"; # Admin username goes here
$whmcs["password"] 				= md5("dje773jeidkdje773jeidk"); # Admin password goes here  
$whmcs['accesskey']				= 'admin1372';
// product details
$product_ids = array(
					62, // 1st server
					
					);

$cloudflare['api_key']              = '63591d7026060b416f905718785e3446bc087';
$cloudflare['email']                = 'aegrant@gmail.com';