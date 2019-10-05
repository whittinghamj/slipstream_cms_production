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

$query = $conn->query("SELECT * FROM `global_settings` ");
$global_settings = $query->fetchAll(PDO::FETCH_ASSOC);