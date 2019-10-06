<?php
// session_start();

// includes
include('../inc/db.php');
include('../inc/global_vars.php');
include('../inc/functions.php');

// make sure username is set
$username = get('username');
if(empty($username)) {
	echo '<pre>';
	print_r($_GET);
	die('missing username');
}

// make sure password is set
$password = get('password');
if(empty($password)) {
	echo '<pre>';
	print_r($_GET);
	die('missing password');
}

// make sure type is set
$type = get('type');
if(empty($type)) {
	echo '<pre>';
	print_r($_GET);
	die('missing type');
}

$query 					= $conn->query("SELECT * FROM `customers` WHERE `username` = '".$username."' AND `password` = '".$password."' ");
$customer 				= $query->fetch(PDO::FETCH_ASSOC);
$customer['bouquet']	= explode(",", $customer['bouquet']);

if(empty($customer)) {
	die("customer not found");
}

if($customer['status'] != 'enabled') {
	die("account ".$customer['status']);
}

if($type == 'flussonic') {
	//Generate text file on the fly
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=playlist.m3u");

	$new_line = "\n";

	// demo m3u format
	// #EXTM3U
	// #EXTINF:-1,CHANNEL NAME
	// http://link.to.stream

	print "#EXTM3U".$new_line;

	// build live tv list
	if($customer['live_content'] == 'on'){
		$query = $conn->query("SELECT `id`,`server_id`,`name`,`status` FROM `streams` WHERE `stream_type` = 'output' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$streams = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach($streams as $stream) {
			if($stream['status'] == 'online'){
				print '#EXTINF:-1,'.stripslashes($stream['name']).$new_line;
			}else{
				print '#EXTINF:-1,'.stripslashes($stream['name']).' ['.strtoupper($stream['status']).']'.$new_line;
			}

			$query = $conn->query("SELECT `id`,`wan_ip_address`,`public_hostname` FROM `headend_servers` WHERE `id` = '".$stream['server_id']."' ");
			$headend = $query->fetch(PDO::FETCH_ASSOC);

			// make the stream name fluss like
			$stream['name'] = str_replace(array(' ',':',';'), '', $stream['name']);

			// example: http://domain:port/streamname/mpegts?token=342354234
			// example: http://washingyou.ddns.net:8085/SptsF1NOSHARE/mono.m3u8?token=Delta687_a3d

			if(!empty($headend['public_hostname'])){
				$server_address = $headend['public_hostname'];
			}else{
				$server_address = $headend['wan_ip_address'];
			}

			print "http://".$server_address.":1735/".$stream['name']."/mpegts?token=".$customer['username'].$new_line;
		}
	}

	// build channel list
	/*
	if($customer['channel_content'] == 'on'){
		$query = $conn->query("SELECT * FROM `channels` WHERE `enable` = 'yes' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$channels = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach($channels as $channel) {
			print '#EXTINF:-1,'.stripslashes($channel['name']).$new_line;
			print "http://slipstreamiptv.com/customer_channels/".$customer['username']."/".$customer['password']."/".$channel['server_id']."/".$channel['id'].$new_line;
		}
	}
	*/

	// build series list
	/*
	if($customer['vod_content'] == 'on'){
		$query = $conn->query("SELECT * FROM `tv_series` WHERE `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$tv_series = $query->fetchAll(PDO::FETCH_ASSOC);

		$total_tv_series = count($tv_series);

		if($total_tv_series > 0){
			$tv_series_count = 0;
			foreach($tv_series as $series) {

				$query = $conn->query("SELECT * FROM `tv_series_files` WHERE `tv_series_id` = '".$series['id']."' ORDER BY `order` ");
				$series_files = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($series_files as $series_file) {
					print '#EXTINF:-1,'.stripslashes($series_file['name']).$new_line;
					print "http://slipstreamiptv.com/customer_series/".$customer['username']."/".$customer['password']."/".$series['server_id']."/".$series_file['id'].$new_line;
				}
			}
		}

		// build vod list
		$query = $conn->query("SELECT * FROM `vod` WHERE `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$vods = $query->fetchAll(PDO::FETCH_ASSOC);

		$total_vods = count($vods);

		if($total_vods > 0){
			foreach($vods as $vod) {

				if(empty($vod['cover_photo'])) {
					$logo = 'http://slipstreamiptv.com/img/iptv_stream_icon.png';
				}else{
					$logo = stripslashes($vod['cover_photo']);
				}

				print '#EXTINF:-1,'.stripslashes($vod['name']).$new_line;
				print "http://slipstreamiptv.com/customer_vod/".$customer['username']."/".$customer['password']."/".$vod['server_id']."/".$vod['id'].$new_line;
			}
		}
	}
	*/
}elseif($type == 'simple_m3u') {
	//Generate text file on the fly
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=playlist.m3u");

	$new_line = "\n";

	// demo m3u format
	// #EXTM3U
	// #EXTINF:-1,CHANNEL NAME
	// http://link.to.stream

	print "#EXTM3U".$new_line;

	// build live tv list
	if($customer['live_content'] == 'on'){
		$query = $conn->query("SELECT `id`,`server_id`,`name`,`status`,`source_type` FROM `streams` WHERE `stream_type` = 'output' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$streams = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach($streams as $stream) {
			if($stream['source_type'] == 'hidden'){
				$stream['source_type'] = '';
			}else{
				// $stream['source_type'] = ' ('.strtoupper($stream['source_type']).') ';
				$stream['source_type'] = '';
			}

			if($stream['status'] == 'online'){
				print '#EXTINF:-1,'.stripslashes($stream['name']).$stream['source_type'].''.$new_line;
			}else{
				print '#EXTINF:-1,'.stripslashes($stream['name']).$stream['source_type'].'['.strtoupper($stream['status']).']'.$new_line;
			}
			print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_streams/".$customer['username']."/".$customer['password']."/".$stream['server_id']."/".$stream['id'].$new_line;
		}
	}

	// build channel list
	if($customer['channel_content'] == 'on'){
		$query = $conn->query("SELECT * FROM `channels` WHERE `enable` = 'yes' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$channels = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach($channels as $channel) {
			print '#EXTINF:-1,'.stripslashes($channel['name']).$new_line;
			print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_channels/".$customer['username']."/".$customer['password']."/".$channel['server_id']."/".$channel['id'].$new_line;
		}
	}

	// build series list
	if($customer['vod_content'] == 'on'){
		$query = $conn->query("SELECT * FROM `tv_series` WHERE `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$tv_series = $query->fetchAll(PDO::FETCH_ASSOC);

		$total_tv_series = count($tv_series);

		if($total_tv_series > 0){
			$tv_series_count = 0;
			foreach($tv_series as $series) {

				$query = $conn->query("SELECT * FROM `tv_series_files` WHERE `tv_series_id` = '".$series['id']."' ORDER BY `order` ");
				$series_files = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($series_files as $series_file) {
					print '#EXTINF:-1,'.stripslashes($series_file['name']).$new_line;
					print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_series/".$customer['username']."/".$customer['password']."/".$series['server_id']."/".$series_file['id'].$new_line;
				}
			}
		}

		// build vod list
		$query = $conn->query("SELECT * FROM `vod` WHERE `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$vods = $query->fetchAll(PDO::FETCH_ASSOC);

		$total_vods = count($vods);

		if($total_vods > 0){
			foreach($vods as $vod) {

				if(empty($vod['cover_photo'])) {
					$logo = 'http://slipstreamiptv.com/img/iptv_stream_icon.png';
				}else{
					$logo = stripslashes($vod['cover_photo']);
				}

				print '#EXTINF:-1,'.stripslashes($vod['name']).$new_line;
				print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_vod/".$customer['username']."/".$customer['password']."/".$vod['server_id']."/".$vod['id'].$new_line;
			}
		}
	}
}elseif($type == 'advanced_m3u') {
	//Generate text file on the fly
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=playlist.m3u");

	$new_line = "\n";

	// demo m3u format
	// #EXTM3U
	// #EXTINF:-1,CHANNEL NAME
	// http://link.to.stream

	print "#EXTM3U".$new_line;

	// build live tv list
	if($customer['live_content'] == 'on'){
		$query = $conn->query("SELECT `id`,`server_id`,`name`,`status`,`category_id`,`source_type` FROM `streams` WHERE `stream_type` = 'output' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$streams = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach($streams as $stream) {
			if($stream['source_type'] == 'hidden'){
				$stream['source_type'] = '';
			}else{
				// $stream['source_type'] = ' ('.strtoupper($stream['source_type']).') ';
				$stream['source_type'] = '';
			}
			
			// $stream['name'] = str_replace(array('Direct ', 'Restream '), '', $stream['name']);

			// example with groups = #EXTINF:-1 tvg-ID="BBC1London.uk" tvg-name="UK: BBC One SD" tvg-logo="netbbcone.png" group-title="UK Entertainment",UK: BBC One SD
			if(empty($stream['category_id']) || $stream['category_id'] == 0){
				if($stream['status'] == 'online'){
					print '#EXTINF:-1,'.stripslashes($stream['name']).$stream['source_type'].''.$new_line;
				}else{
					print '#EXTINF:-1,'.stripslashes($stream['name']).$stream['source_type'].'['.strtoupper($stream['status']).']'.$new_line;
				}
			}else{
				// get the category details
				$query = $conn->query("SELECT `name` FROM `stream_categories` WHERE `id` = '".$stream['category_id']."' ");
				$stream_category = $query->fetch(PDO::FETCH_ASSOC);

				if(empty($stream['logo'])) {
					$logo = 'http://slipstreamiptv.com/img/iptv_stream_icon.png';
				}else{
					$logo = stripslashes($stream['logo']);
				}

				if($stream['status'] == 'online'){
					print '#EXTINF:-1 tvg-ID="'.stripslashes($stream['name']).'" tvg-name="'.stripslashes($stream['name']).'" tvg-logo="'.$logo.'" group-title="LIVE: '.$stream_category['name'].'",'.stripslashes($stream['name']).$stream['source_type'].''.$new_line;
				}else{
					print '#EXTINF:-1 tvg-ID="'.stripslashes($stream['name']).'" tvg-name="'.stripslashes($stream['name']).'" tvg-logo="'.$logo.'" group-title="LIVE: '.$stream_category['name'].'",'.stripslashes($stream['name']).$stream['source_type'].'['.strtoupper($stream['status']).']'.$new_line;
				}
			}
			print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_streams/".$customer['username']."/".$customer['password']."/".$stream['server_id']."/".$stream['id'].$new_line;
		}
	}

	// build channel list
	if($customer['channel_content'] == 'on'){
		$query = $conn->query("SELECT * FROM `channels` WHERE `enable` = 'yes' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$channels = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach($channels as $channel) {
			// print '#EXTINF:-1,'.stripslashes($channel['name']).$new_line;
			print '#EXTINF:-1 tvg-ID="" tvg-name="'.stripslashes($channel['name']).'" tvg-logo="'.$channel['cover_photo'].'" group-title="24/7 Channels",'.stripslashes($channel['name']).$new_line;
			print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_channels/".$customer['username']."/".$customer['password']."/".$channel['server_id']."/".$channel['id'].$new_line;
		}
	}

	// build series list
	if($customer['vod_content'] == 'on'){
		$query = $conn->query("SELECT * FROM `tv_series` WHERE `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$tv_series = $query->fetchAll(PDO::FETCH_ASSOC);

		$total_tv_series = count($tv_series);

		if($total_tv_series > 0){
			$tv_series_count = 0;
			foreach($tv_series as $series) {

				$query = $conn->query("SELECT * FROM `tv_series_files` WHERE `tv_series_id` = '".$series['id']."' ORDER BY `order` ");
				$series_files = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($series_files as $series_file) {

					print '#EXTINF:-1 tvg-ID="" tvg-name="'.stripslashes($series['name']).'" tvg-logo="'.$series['cover_photo'].'" group-title="SERIES: '.stripslashes($series['name']).'",'.stripslashes($series['name']).' > '.stripslashes($series_file['name']).$new_line;
					
					print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_series/".$customer['username']."/".$customer['password']."/".$series['server_id']."/".$series_file['id'].$new_line;
				}
			}
		}

		// build vod list
		$query = $conn->query("SELECT * FROM `vod` WHERE `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$vods = $query->fetchAll(PDO::FETCH_ASSOC);

		$total_vods = count($vods);

		if($total_vods > 0){
			foreach($vods as $vod) {

				if(empty($vod['cover_photo'])) {
					$logo = 'http://slipstreamiptv.com/img/iptv_stream_icon.png';
				}else{
					$logo = stripslashes($vod['cover_photo']);
				}

				print '#EXTINF:-1 tvg-ID="" tvg-name="'.stripslashes($vod['name']).'" tvg-logo="'.$logo.'" group-title="VOD",'.stripslashes($vod['name']).$new_line;
				print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_vod/".$customer['username']."/".$customer['password']."/".$vod['server_id']."/".$vod['id'].$new_line;
			}
		}
	}
}elseif($type == 'enigma') {
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=iptv.sh");

	$template = file_get_contents("http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/downloads/enigma_autoscript_template.txt");

	$template = str_replace('{$USERNAME}', $username, $template);
	$template = str_replace('{$PASSWORD}', $password, $template);

	print $template;
}elseif($type == 'dreambox') {
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=userbouquet.favourites.tv");

	$new_line = "\n";

	// demo m3u format
	// #EXTM3U
	// #EXTINF:-1,CHANNEL NAME
	// http://link.to.stream

	print "#NAME IPTV".$new_line;
	
	// example output
	// #SERVICE 1:0:1:0:0:0:0:0:0:0:http%3A//iptv-panel.hz.de.genexnetworks.net%3A10810/andyjamie/admin1372/214
	// #DESCRIPTION UK: BBC One SD

	// build list tv list
	$query = $conn->query("SELECT * FROM `streams` WHERE `stream_type` = 'output' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($streams as $stream) {
		print "#SERVICE 4097:0:1:0:0:0:0:0:0:0:http%3A//".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_streams/".$customer['username']."/".$customer['password']."/".$stream['server_id']."/".$stream['id'].'.ts'.$new_line;
		print "#DESCRIPTION ".stripslashes($stream['name']).$new_line;
	}
}elseif($type == 'dev') {
	//Generate text file on the fly
	//header("Content-type: text/plain");
	//header("Content-Disposition: attachment; filename=playlist.m3u");

	$new_line = "\n";

	// demo m3u format
	// #EXTM3U
	// #EXTINF:-1,CHANNEL NAME
	// http://link.to.stream

	debug($customer);

	// print "#EXTM3U".$new_line;

	// build live tv list
	foreach($customer['bouquet'] as $bouquet){
		// get streams for this bouquet
		$query 						= $conn->query("SELECT `streams` FROM `bouquets` WHERE `id` = '".$bouquet['id']."'");
		$temp_bouquet 				= $query->fetch(PDO::FETCH_ASSOC);
		$temp_bouquet['streams'] 	= explode(",", $temp_bouquet['streams']);

		// add each stream into a master bouquet
		foreach($temp_bouquet['streams'] as $stream){
			$master_bouquet[] = $stream['id'];
		}
	}

	debug($_GET);
	debug($master_bouquet);





	/*
	$query = $conn->query("SELECT `id`,`server_id`,`name`,`status`,`source_type` FROM `streams` WHERE `stream_type` = 'output' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($streams as $stream) {

		if($stream['source_type'] == 'hidden'){
			$stream['source_type'] = '';
		}else{
			// $stream['source_type'] = ' ('.strtoupper($stream['source_type']).') ';
			$stream['source_type'] = '';
		}

		if($stream['status'] == 'online'){
			print '#EXTINF:-1,'.stripslashes($stream['name']).$stream['source_type'].''.$new_line;
		}else{
			print '#EXTINF:-1,'.stripslashes($stream['name']).$stream['source_type'].'['.strtoupper($stream['status']).']'.$new_line;
		}
		print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_streams/".$customer['username']."/".$customer['password']."/".$stream['server_id']."/".$stream['id'].$new_line;
	}
	*/
	
	// build channel list
	/*
	if($customer['channel_content'] == 'on'){
		$query = $conn->query("SELECT * FROM `channels` WHERE `enable` = 'yes' AND `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$channels = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach($channels as $channel) {
			print '#EXTINF:-1,'.stripslashes($channel['name']).$new_line;
			print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_channels/".$customer['username']."/".$customer['password']."/".$channel['server_id']."/".$channel['id'].$new_line;
		}
	}

	// build series list
	if($customer['vod_content'] == 'on'){
		$query = $conn->query("SELECT * FROM `tv_series` WHERE `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$tv_series = $query->fetchAll(PDO::FETCH_ASSOC);

		$total_tv_series = count($tv_series);

		if($total_tv_series > 0){
			$tv_series_count = 0;
			foreach($tv_series as $series) {

				$query = $conn->query("SELECT * FROM `tv_series_files` WHERE `tv_series_id` = '".$series['id']."' ORDER BY `order` ");
				$series_files = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($series_files as $series_file) {
					print '#EXTINF:-1,'.stripslashes($series_file['name']).$new_line;
					print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_series/".$customer['username']."/".$customer['password']."/".$series['server_id']."/".$series_file['id'].$new_line;
				}
			}
		}

		// build vod list
		$query = $conn->query("SELECT * FROM `vod` WHERE `user_id` = '".$customer['user_id']."' ORDER BY `name` ASC");
		$vods = $query->fetchAll(PDO::FETCH_ASSOC);

		$total_vods = count($vods);

		if($total_vods > 0){
			foreach($vods as $vod) {

				if(empty($vod['cover_photo'])) {
					$logo = 'http://slipstreamiptv.com/img/iptv_stream_icon.png';
				}else{
					$logo = stripslashes($vod['cover_photo']);
				}

				print '#EXTINF:-1,'.stripslashes($vod['name']).$new_line;
				print "http://".$global_settings['cms_access_url_raw'].":".$global_settings['cms_port']."/customer_vod/".$customer['username']."/".$customer['password']."/".$vod['server_id']."/".$vod['id'].$new_line;
			}
		}
	}
	*/
}else{
	echo "unknown playlist type";
}

exit;