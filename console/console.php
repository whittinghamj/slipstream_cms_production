<?php

include('/var/www/html/portal/inc/db.php');
include('/var/www/html/portal/inc/global_vars.php');
include('/var/www/html/portal/inc/functions.php');
include('/var/www/html/portal/inc/php_colors.php');

date_default_timezone_set('UTC');

$colors = new Colors();

$task = $argv[1];

if($task == 'cron') {
	
	// roku remote cron
	/*
	console_output("ROKU Remotes Addon");
	$roku_config_files = glob("/var/www/html/addons/roku/config.*.json");

	if(!is_array($roku_config_files)) {
		console_output(" - No ROKU device config files found.");
	}else{
		foreach($roku_config_files as $roku_config_file) {
			$roku 		= file_get_contents($roku_config_file);
			$roku 		= json_decode($roku, true);
			$active_app = exec('php -q addons/roku/roku.php '.$roku['ip_address'].' active_app');
			$active_app = json_decode($active_app, true);

			if(empty($active_app)) {
				console_output(" - ROKU device appears to be offline, skipping.");
			}else{
				console_output(" - Setting ROKU App / Channel.");
				// console_output(" - sudo php -q /var/www/html/addons/roku/roku.php ".$roku['ip_address']." ".$roku['app']." ".$roku['channel']);
				exec("sudo php -q /var/www/html/addons/roku/roku.php ".$roku['ip_address']." ".$roku['app']." ".$roku['channel']);
			}
		}
	}
	*/

	console_output("Finished.");
}
// PURGE BINARY LOGS TO 'mysql-bin.000061';
if($task == 'clean_db') {
	$query = $conn->query("PURGE BINARY LOGS TO 'mysql-bin.000061' ");
	console_output("Finished.");
}

if($task == 'node_checks') {
	console_output("Checking nodes for online / offline status.");
	$now = time();

	$query = $conn->query("SELECT `id`,`updated`,`name` FROM `headend_servers` WHERE `status` != 'installing' ");
	$headends = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($headends as $headend) {
		$time_diff = $now - $headend['updated'];
		if($time_diff > 70) {
			console_output("Headend '".stripslashes($headend['name'])."' appears offline.");
			$update = $conn->exec("UPDATE `headend_servers` SET `status` = 'offline' WHERE `id` = '".$headend['id']."' ");

			$update = $conn->exec("UPDATE `capture_devices` SET `status` = 'offline' WHERE `server_id` = '".$headend['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' WHERE `server_id` = '".$headend['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' WHERE `source_server_id` = '".$headend['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `server_id` = '".$headend['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `source_server_id` = '".$headend['id']."' ");
		}
	}
	console_output("Finished.");
}

if($task == 'source_checks') {
	console_output("Checking all sources for online / missing status.");
	$now = time();

	$query = $conn->query("SELECT * FROM `headend_servers` ");
	$headends = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($headends as $headend) {
		if($headend['status'] == 'online') {
			$query = $conn->query("SELECT * FROM `capture_devices` WHERE `status` != 'missing' AND `server_id` = '".$headend['id']."' ");
			$sources = $query->fetchAll(PDO::FETCH_ASSOC);
			foreach($sources as $source) {
				$time_diff = $now - $source['updated'];
				if($time_diff > 70) {
					console_output("Source '".stripslashes($source['name'])."' appears to be missing.");
					$update = $conn->exec("UPDATE `capture_devices` SET `status` = 'missing' WHERE `id` = '".$source['id']."' ");
				}
			}
		}
	}
	console_output("Finished.");
}

if($task == 'stream_checks') {

	console_output("Checking streams for online / offline status.");

	$runs = 1;
	
	$query = $conn->query("SELECT * FROM `streams` ORDER BY 'server_id' ASC");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);

    $count 				= count($streams);

    for ($i=0; $i<$runs; $i++) {
        for ($j=0; $j<$count; $j++) {
            $pipe[$j] = popen("php -q /home2/slipstream/public_html/hub/console/console.php stream_checks_process ".$streams[$j]['id'], 'w');
            // $pipe[$j] = popen("echo ".$streams[$j]['id'], 'w');
            // echo "php -q /home2/slipstream/public_html/hub/console/console.php stream_checks_process ".$streams[$j]['id'] ."\n";
        }

        // wait for them to finish
        for ($j=0; $j<$count; ++$j) {
            pclose($pipe[$j]);
        }

    }

	console_output("Finished.");
}

if($task == 'stream_checks_process') {
	$stream_id = $argv[2];

	$now = time();

	$query = $conn->query("SELECT * FROM `streams` WHERE `id` = '".$stream_id."' ");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($streams as $stream) {
		$stream['output_options'] = json_decode($stream['output_options'], true); 

		// get headend data for this stream
		$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$stream['server_id']."' ");
		$stream['headend'] = $query->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($stream['output_options'] as $key => $output_options) {
			// build stream_url
			$screen_resolution = explode('x', $output_options['screen_resolution']);

			if($stream['headend'][0]['output_type'] == 'rtmp') {
				$stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/hls/'.$stream['publish_name'].'/index.m3u8';
			}else{
				$stream['stream_url'] = 'http://'.$stream['headend'][0]['wan_ip_address'].':'.$stream['headend'][0]['http_stream_port'].'/play/hls/'.$stream['publish_name'].'_'.$screen_resolution[1].'/index.m3u8';
			}

			// make sure the IP is in the firewall for outgoing connections
			shell_exec("sudo csf -a " . $stream['headend'][0]['wan_ip_address']);

			// console_output("Testing URL: " . $stream['stream_url']);

			$stream['test_results'] = shell_exec("/etc/ffmpeg/ffprobe -v quiet -print_format json -show_format -show_streams ".$stream['stream_url']);
			
			$stream['test_results'] = json_decode($stream['test_results'], true);

			// update status
			if(isset($stream['test_results']['streams'])) {
				console_output("Stream: '".stripslashes($stream['name'] . ' ' . strtoupper($key))."' appears ".$colors->getColoredString("online.", "green", "black"));
				$output_options['status'] = 'online';
			}elseif(!isset($stream['test_results']['streams'])){
				console_output("Stream: '".stripslashes($stream['name'] . ' ' . strtoupper($key))."' appears ".$colors->getColoredString("offline.", "red", "black"));
				$output_options['status'] = 'offline';
			}else{
				console_output("Stream: '".stripslashes($stream['name'] . ' ' . strtoupper($key))."' status =  ".$colors->getColoredString("UNKNOWN.", "blue", "black"));
				$output_options['status'] = 'unknown';

				print_r($stream['test_results']);
			}

			$save_results[$key] = $output_options;
		}

		$update = $conn->exec("UPDATE `streams` SET `output_options` = '".json_encode($save_results)."' WHERE `id` = '".$stream['id']."' ");

	}
}

if($task == 'stream_sync') {
	console_output("Syncing category and logo from input to output streams.");
	$now = time();

	$query = $conn->query("SELECT * FROM `streams` ");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($streams as $stream) {
		// update category_id
		$update = $conn->exec("UPDATE `streams` SET `category_id` = '".$stream['category_id']."' WHERE `source_stream_id` = '".$stream['id']."' ");

		// update logo
		$update = $conn->exec("UPDATE `streams` SET `logo` = '".$stream['logo']."' WHERE `source_stream_id` = '".$stream['id']."' ");
	}
	console_output("Finished.");
}

if($task == 'customer_checks') {
	console_output("Checking customers for various things.");
	
	$now = time();

	$query = $conn->query("SELECT * FROM `customers` ");
	$customers = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($customers as $customer) {
		$expire_date = strtotime($customer['expire_date']);

		// make sure unlimited is enabled
		if($customer['expire_date'] == '1970-01-01'){
			$update = $conn->exec("UPDATE `customers` SET `status` = 'enabled' WHERE `id` = '".$customer['id']."' ");
		}elseif(time() > $expire_date) {
	        // customer account expired, update it
	        $update = $conn->exec("UPDATE `customers` SET `status` = 'expired' WHERE `id` = '".$customer['id']."' ");

	        console_output("Customer: ".$customer['username']." has expired, updating records.");
	    }else{
	    	$update = $conn->exec("UPDATE `customers` SET `status` = 'enabled' WHERE `id` = '".$customer['id']."' ");
	    }
	}
	console_output("Finished.");
}

if($task == 'xc_imports') {
	console_output("Xtream-Codes Import Manager.");
	$now = time();

	$query = $conn->query("SELECT * FROM `slipstream_cms`.`xc_import_jobs` WHERE `status` = 'pending' LIMIT 1");
	$import = $query->fetch(PDO::FETCH_ASSOC);

	if(!empty($import)){

		$user_id = $import['user_id'];
		
		console_output("Starting Import Job: ".$import['id']);
		console_output("User: ".$import['user_id']);
		console_output("Filename: /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']);
		
		$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'importing' WHERE `id` = '".$import['id']."' ");

		// sanity checks
		if(!file_exists("/var/www/html/portal/xc_uploads/".$user_id."/".$import['filename'])){
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Unable to find file.' WHERE `id` = '".$import['id']."' ");
			console_output("File does not exist or we cannot read it.");
			die();
		}

		// remove database and create it again
		$delete = $conn->exec("DROP DATABASE `slipstream_xc_staging`;");
		$delete = $conn->exec("CREATE DATABASE `slipstream_xc_staging`;");

		// import DB
		console_output("Importing Xtream-Codes SQL Dump file.");
		console_output("/usr/bin/mysql -u slipstream -padmin1372 -hlocalhost slipstream_xc_staging < /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename']."");
		exec("(/usr/bin/mysql -u slipstream -padmin1372 -hlocalhost slipstream_xc_staging < /var/www/html/portal/xc_uploads/".$user_id."/".$import['filename'].") 2>&1", $output, $result);

		// more sanity checks
		try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`streams` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a streams table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing streams table.");
			die();
	    }
	    try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`users` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a users table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing users table.");
			die();
	    }
	    try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`reg_users` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a reg_users table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing reg_users table.");
			die();
	    }
	    try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`bouquets` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a bouquets table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing bouquets table.");
			die();
	    }
	    try {
        	$result = $conn->query("SELECT * FROM `slipstream_xc_staging`.`mag_devices` LIMIT 1");
	    } catch (Exception $e) {
	        // We got an exception == table not found
	        $update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Your backup does not contain a mag_devices table. Try making a new backup and uploading it again. Do NOT trim anything but LOG files.' WHERE `id` = '".$import['id']."' ");
			console_output("missing mag_devices table.");
			die();
	    }

		// get first server id
		$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`headend_servers` WHERE `user_id` = '".$user_id."' LIMIT 1");
		$server = $query->fetch(PDO::FETCH_ASSOC);
		$server_id = $server['id'];
		if(empty($server_id)){
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'error' WHERE `id` = '".$import['id']."' ");
			$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `error_message` = 'Please add your first server first.' WHERE `id` = '".$import['id']."' ");
			console_output("Please add your first server first.");
			die();
		}

		// convert xc streams to ss streams
		$query = $conn->query("SELECT * FROM `slipstream_xc_staging`.`streams` WHERE `type` = '1' ");
		$xc_streams = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_streams))." streams");

		foreach($xc_streams as $xc_stream){
			$rand 				= md5(rand(00000,99999).time());

			$name 				= addslashes($xc_stream['stream_display_name']);
			$name 				= trim($name);

			$source 			= stripslashes($xc_stream['stream_source']);
			$source 			= str_replace(array("[", "]"), "", $source);
			$source 			= explode(",", $source);

			if(is_array($source)) {
				$source = $source[0];
			}else{
				$source = $source;
			}

			$source 			= str_replace('"', "", $source);
			$source 			= addslashes($source);

			$ffmpeg_re			= 'no';

			$logo 				= addslashes($xc_stream['stream_icon']);

		    // add input stream
			$insert = $conn->exec("INSERT INTO `slipstream_cms`.`streams` 
		        (`user_id`,`server_id`,`stream_type`,`name`,`enable`,`source`,`cpu_gpu`,`job_status`,`ffmpeg_re`,`logo`)
		        VALUE
		        ('".$user_id."',
		        '".$server_id."',
		        'input',
		        '".$name."',
		        'no',
		        '".$source."',
		        'cpu',
		        'analysing',
		        '".$ffmpeg_re."',
		        '".$logo."'
		    )");

		    $stream_id = $conn->lastInsertId();

		    // add output stream
		    $insert = $conn->exec("INSERT INTO `slipstream_cms`.`streams` 
		        (`user_id`,`enable`,`server_id`,`stream_type`,`name`,`source_server_id`,`source_stream_id`,`old_xc_id`,`logo`)
		        VALUE
		        ('".$user_id."',
		        'no',
		        '".$server_id."',
		        'output',
		        '".$name."',
		        '".$server_id."',
		        '".$stream_id."',
		        '".$xc_stream['id']."',
		        '".$logo."'
		    )");

			echo ".";
		}
		echo "\n";

		// convert xc packages to ss packages
		$query = $conn->query("SELECT * FROM `slipstream_xc_staging`.`packages` ");
		$xc_packages = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_packages))." packages");

		foreach($xc_packages as $xc_package){
			$xc_package['bouquets'] = str_replace(array("[","]"), "", $xc_package['bouquets']);

			$insert = $conn->exec("INSERT INTO `slipstream_cms`.`packages` 
		        (`user_id`,`name`,`is_trial`,`credits`,`trial_duration`,`official_duration`,`bouquets`,`old_xc_id`)
		        VALUE
		        ('".$user_id."',
		        '".addslashes($xc_package['package_name'])."',
		        '".addslashes($xc_package['is_trial'])."',
		        '".addslashes($xc_package['official_credits'])."',
		        '".addslashes($xc_package['trial_duration'])."',
		        '".addslashes($xc_package['official_duration'])."',
		        '".addslashes($xc_package['bouquets'])."',
		        '".addslashes($xc_package['id'])."'
		    )");

		    echo ".";
		}
		echo "\n";

		// convert xc bouquet to ss packages
		$query = $conn->query("SELECT * FROM `slipstream_xc_staging`.`bouquets` ");
		$xc_bouquets = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_bouquets))." bouquets");

		foreach($xc_bouquets as $xc_bouquet){
			$xc_bouquet['streams'] = str_replace(array("[","]",'"'), "", $xc_bouquet['bouquet_channels']);
			
			$old_streams = explode(",", $xc_bouquet['streams']);

			foreach($old_streams as $old_stream){
				$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`streams` WHERE `user_id` = '".$user_id."' AND `old_xc_id` = '".$old_stream."' ");
				$temp_stream = $query->fetch(PDO::FETCH_ASSOC);
				$new_streams[] = $temp_stream['id'];
			}

			$xc_bouquet['streams'] = implode(",", $new_streams);

			$insert = $conn->exec("INSERT IGNORE INTO `slipstream_cms`.`bouquets` 
		        (`user_id`,`name`,`streams`,`old_xc_id`)
		        VALUE
		        ('".$user_id."',
		        '".addslashes($xc_bouquet['bouquet_name'])."',
		        '".addslashes($xc_bouquet['streams'])."',
		        '".addslashes($xc_bouquet['id'])."'
		    )");

		    echo ".";
		}
		echo "\n";

		// convert xc users to ss customers
		$query = $conn->query("SELECT * FROM `slipstream_xc_staging`.`reg_users` ");
		$xc_reg_users = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_reg_users))." resellers");

		foreach($xc_reg_users as $xc_reg_user){
			if($xc_reg_user['status'] == 1){
				$xc_reg_user['status'] = 'enabled';
			}else{
				$xc_reg_user['status'] = 'disable';
			}

			$password = md5(time().rand(0,9));

			$insert = $conn->exec("INSERT INTO `slipstream_cms`.`resellers` 
		        (`status`,`updated`,`user_id`,`group_id`,`email`,`username`,`password`,`credits`)
		        VALUE
		        ('".addslashes($xc_reg_user['status'])."',
		        '".time()."',
		        '".$user_id."',
		        '4',
		        '".addslashes($xc_reg_user['email'])."',
		        '".addslashes($xc_reg_user['username'])."',
		        '".$password."',
		        '".addslashes($xc_reg_user['credits'])."'
		    )");

		    echo ".";
		}
		echo "\n";

		// convert xc users to ss customers
		$query = $conn->query("SELECT `id`,`exp_date`,`created_by`,`username`,`password`,`bouquet`,`max_connections`,`admin_notes`,`reseller_notes` FROM `slipstream_xc_staging`.`users` ");
		$xc_users = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_users))." customers");

		foreach($xc_users as $xc_user){
			$xc_user_exp_date = date("Y-m-d", $xc_user['exp_date']);

			if($xc_user['exp_date'] < time()) {
				$customer_status = 'expired';
			}else{
				$customer_status = 'enabled';
			}

			$old_owner = $xc_user['created_by'];

			$query = $conn->query("SELECT `username` FROM `slipstream_xc_staging`.`reg_users` WHERE `id` = '".$old_owner."' ");
			$xc_old_owner = $query->fetch(PDO::FETCH_ASSOC);
			$new_owner_username = $xc_old_owner['username'];

			$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`resellers` WHERE `user_id` = '".$user_id."' AND `username` = '".$new_owner_username."' ");
			$new_owner = $query->fetch(PDO::FETCH_ASSOC);
			$reseller_id = $new_owner['id'];

			$xc_user['bouquet'] = str_replace(array("[","]", '"'), "", $xc_user['bouquet']);

			$old_bouquets = explode(",", $xc_user['bouquet']);

			foreach($old_bouquets as $old_bouquet){
				$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`bouquets` WHERE `user_id` = '".$user_id."' AND `old_xc_id` = '".$old_bouquet."' ");
				$temp_bouquet = $query->fetch(PDO::FETCH_ASSOC);
				$new_bouquets[] = $temp_bouquet['id'];
			}

			$xc_user['bouquet'] = implode(",", $new_bouquets);

			$insert = $conn->exec("INSERT IGNORE INTO `slipstream_cms`.`customers` 
		        (`status`,`user_id`,`reseller_id`,`username`,`password`,`expire_date`,`live_content`,`bouquet`,`max_connections`,`notes`,`reseller_notes`,`old_xc_id`)
		        VALUE
		        ('".$customer_status."',
		        '".$user_id."',
		        '".$reseller_id."',
		        '".addslashes($xc_user['username'])."',
		        '".addslashes($xc_user['password'])."',
		        '".$xc_user_exp_date."',
		        'on',
		        '".$xc_user['bouquet']."',
		        '".$xc_user['max_connections']."',
		        '".addslashes($xc_user['admin_notes'])."',
		        '".addslashes($xc_user['reseller_notes'])."',
		       	'".$xc_user['id']."'
		    )");

		    unset($old_bouquets);
		    unset($new_bouquets);
		
		    echo ".";
		}
		echo "\n";

		// convert mag_devices to ss customers
		$query = $conn->query("SELECT `user_id`,`mag_id`,`mac`,`bright`,`aspect` FROM `slipstream_xc_staging`.`mag_devices` ");
		$xc_mags = $query->fetchAll(PDO::FETCH_ASSOC);

		console_output("Migrating: ".number_format(count($xc_mags))." mag_devices");

		foreach($xc_mags as $xc_mag){
			// old customer_id
			$old_customer_id = $xc_mag['user_id'];

			// get new customer_id
			$query = $conn->query("SELECT `id` FROM `slipstream_cms`.`customers` WHERE `user_id` = '".$user_id."' AND `old_xc_id` = '".$old_customer_id."' ");
			$customer = $query->fetch(PDO::FETCH_ASSOC);

			if(empty($customer)){
				$customer['id'] = 0;
			}

			$insert = $conn->exec("INSERT INTO `slipstream_cms`.`mag_devices` 
		        (`user_id`,`customer_id`,`mac`,`aspect`,`old_xc_id`)
		        VALUE
		        ('".$user_id."',
		        '".$customer['id']."',
		        '".addslashes($xc_mag['bright'])."',
		        '".addslashes($xc_mag['aspect'])."',
		        '".addslashes($xc_mag['mag_id'])."'
		    )");

		    echo ".";
		}
		echo "\n";

		// remove files

		$update = $conn->exec("UPDATE `slipstream_cms`.`xc_import_jobs` SET `status` = 'complete' WHERE `id` = '".$import['id']."' ");
	}

	console_output("Finished.");
}