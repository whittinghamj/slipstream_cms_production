<?php

$config['version']				= '1.0.0';

// site vars
$site['url']					= 'http://178.128.40.133:10810/portal/';
$site['title']					= 'SlipStream CMS';
$site['copyright']				= 'Written by DeltaColo.';

// logo name vars
$site['name_long']				= 'SlipStream<b>CMS</b>';
$site['name_short']				= '<b>SS</b>';

// get settings table contents

$query = $conn->query("SELECT `config_name`,`config_value` FROM `global_settings` ");
$global_settings_temp = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($global_settings_temp as $bits){
	$global_settings[$bits['config_name']] = $bits['config_value'];
}

if(empty($global_settings['cms_domain_name'])){
	$global_settings['cms_access_url'] = $global_settings['cms_ip'].":".$global_settings['cms_port'];
}else{
	$global_settings['cms_access_url'] = $global_settings['cms_domain_name'].":".$global_settings['cms_port'];
}