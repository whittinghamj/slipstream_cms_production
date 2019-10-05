<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('UTC');

session_start();

include("inc/db.php");
include("inc/global_vars.php");
include("inc/functions.php");

$a = $_GET['a'];

switch ($a)
{
	// test
	case "test":
		test();
		break;


	// headend functions
	case "ajax_headends":
		ajax_headends();
		break;

	case "ajax_headend":
		ajax_headend();
		break;

	case "headend_add":
		headend_add();
		break;

	case "headend_update":
		headend_update();
		break;

	case "server_delete":
		server_delete();
		break;


	// source functions
	case "ajax_sources_video":
		ajax_sources_video();
		break;

	case "ajax_sources_audio":
		ajax_sources_audio();
		break;
		
	case "ajax_source_video":
		ajax_source_video();
		break;

	case "ajax_source_audio":
		ajax_source_audio();
		break;

	case "source_update":
		source_update();
		break;

	case "source_stop":
		source_stop();
		break;

	case "source_start":
		source_start();
		break;

	case "source_scan":
		source_scan();
		break;


	// customer functions
	case "customer_add":
		customer_add();
		break;

	case "customer_update":
		customer_update();
		break;

	case "customer_delete":
		customer_delete();
		break;


	// reseller functions
	case "reseller_add":
		reseller_add();
		break;

	case "reseller_update":
		reseller_update();
		break;

	case "reseller_delete":
		reseller_delete();
		break;


	// stream functions
	case "streams_restart_all":
		streams_restart_all();
		break;

	case "streams_stop_all":
		streams_stop_all();
		break;

	case "streams_start_all":
		streams_start_all();
		break;

	case "ajax_streams_list":
		ajax_streams_list();
		break;

	case "ajax_streams_list_test":
		ajax_streams_list_test();
		break;

	case "ajax_stream":
		ajax_stream();
		break;

	case "stream_update":
		stream_update();
		break;

	case "stream_update_fingerprint":
		stream_update_fingerprint();
		break;

	case "stream_update_dehash":
		stream_update_dehash();
		break;

	case "stream_restart":
		stream_restart();
		break;

	case "stream_stop":
		stream_stop();
		break;

	case "stream_start":
		stream_start();
		break;

	case "stream_add":
		stream_add();
		break;

	case "stream_add_output":
		stream_add_output();
		break;

	case "stream_multi_options":
		stream_multi_options();
		break;

	case "cdn_stream_start":
		cdn_stream_start();
		break;

	case "cdn_stream_stop":
		cdn_stream_stop();
		break;

	case "stream_enable_format":
		stream_enable_format();
		break;

	case "stream_disable_format":
		stream_disable_format();
		break;

	case "export_m3u":
		export_m3u();
		break;

	case "import_streams":
		import_streams();
		break;

	case "inspect_m3u":
		inspect_m3u();
		break;

	case "inspect_m3u_encoded":
		inspect_m3u_encoded();
		break;

	case "inspect_remote_playlist":
		inspect_remote_playlist();
		break;

	case "stream_delete":
		stream_delete();
		break;

	case "bulk_update_sources":
		bulk_update_sources();
		break;


	// tv series functions
	case "tv_series_add":
		tv_series_add();
		break;

	case "tv_series_update":
		tv_series_update();
		break;

	case "tv_series_delete":
		tv_series_delete();
		break;

	case "tv_series_episode_add":
		tv_series_episode_add();
		break;

	case "tv_series_episode_delete":
		tv_series_episode_delete();
		break;

	case "tv_series_update_order":
		tv_series_update_order();
		break;

	case "tv_series_start":
		tv_series_start();
		break;

	case "tv_series_stop":
		tv_series_stop();
		break;


	// channels functions
	case "channel_add":
		channel_add();
		break;

	case "channel_update":
		channel_update();
		break;

	case "channel_delete":
		channel_delete();
		break;

	case "channel_episode_add":
		channel_episode_add();
		break;

	case "channel_episode_delete":
		channel_episode_delete();
		break;

	case "channel_episode_scan_folder":
		channel_episode_scan_folder();
		break;

	case "channel_update_order":
		channel_update_order();
		break;

	case "channel_episode_delete_all":
		channel_episode_delete_all();
		break;

	case "channel_start":
		channel_start();
		break;

	case "channel_stop":
		channel_stop();
		break;

	case "channels_stop_all":
		channels_stop_all();
		break;

	case "channels_start_all":
		channels_start_all();
		break;


	// vod functions
	case "vod_add":
		vod_add();
		break;

	case "vod_update":
		vod_update();
		break;

	case "vod_delete":
		vod_delete();
		break;


	// stream categories
	case "stream_category_add":
		stream_category_add();
		break;

	case "stream_category_update":
		stream_category_update();
		break;

	case "stream_category_delete":
		stream_category_delete();
		break;


	// stream bouquets
	case "bouquet_add":
		bouquet_add();
		break;

	case "bouquet_update":
		bouquet_update();
		break;

	case "bouquet_delete":
		bouquet_delete();
		break;

	case "bouquet_streams_update":
		bouquet_streams_update();
		break;

	case "bouquet_streams_order_update":
		bouquet_streams_order_update();
		break;


	// transcoding profiles
	case "transcoding_profile_add":
		transcoding_profile_add();
		break;

	case "transcoding_profile_update":
		transcoding_profile_update();
		break;

	case "transcoding_profile_delete":
		transcoding_profile_delete();
		break;

	case "restart_transcoding_profile_streams":
		restart_transcoding_profile_streams();
		break;

	// misc
	case "analyse_stream":
		analyse_stream();
		break;

	case "ajax_logs":
		ajax_logs();
		break;


	// jobs
	case "job_add":
		job_add();
		break;


	// acl_rules
	case "acl_rule_add":
		acl_rule_add();
		break;

	case "acl_rule_update":
		acl_rule_update();
		break;

	case "acl_rule_delete":
		acl_rule_delete();
		break;


	// dns_add
	case "dns_add":
		dns_add();
		break;

	// dns_update
	case "dns_update":
		dns_update();
		break;

	// dns_delete
	case "dns_delete":
		dns_delete();
		break;


	// remote playlists
	case "remote_playlist_add":
		remote_playlist_add();
		break;

	case "remote_playlist_update":
		remote_playlist_update();
		break;

	case "remote_playlist_delete":
		remote_playlist_delete();
		break;


	// roku devices
	case "roku_device_add":
		roku_device_add();
		break;

	case "roku_device_update":
		roku_device_update();
		break;

	case "roku_device_delete":
		roku_device_delete();
		break;


	// playlist_checker
	case "playlist_checker":
		playlist_checker();
		break;

	case "ajax_stream_checker":
		ajax_stream_checker();
		break;


	// xc_import
	case "xc_import":
		xc_import();
		break;

	// my_account_update
	case "my_account_update":
		my_account_update();
		break;

	// reset_account
	case "reset_account":
		reset_account();
		break;

	// get customer line
	case "ajax_customer_line":
		ajax_customer_line();
		break;

	// get customer lines
	case "ajax_customer_lines":
		ajax_customer_lines();
		break;

	// ajax_http_proxy
	case "ajax_http_proxy":
		ajax_http_proxy();
		break;
			

// default		
	default:
		home();
		break;
}

function home(){
	die('access denied to function name ' . $_GET['a']);
}

function test(){
	echo exec('whoami');
	echo "<hr>";
	echo '<h3>$_SESSION</h3>';
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';
	echo '<hr>';
	echo '<h3>$_POST</h3>';
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	echo '<hr>';
	echo '<h3>$_GET</h3>';
	echo '<pre>';
	print_r($_GET);
	echo '</pre>';
	echo '<hr>';

	$json = '"{\"cmd\":\"hts       1952 28.1  2.7 3573956 445384 ?      Ssl  Mar14 878:22 /usr/bin/tvheadend -f -u hts -g video\",\"pid\":\"1952\",\"uptime\":\"878:22\",\"playlist\":\"#EXTM3U\n#EXTINF:-1 tvg-id=\"c6b36ed00191cc357390175faa9c02ce\",BT Sport 1 HD\nhttp://localhost:9981/stream/channelid/1349432262?ticket=E7311857FB5AF3096B32C7969EC43FA1D5BE4DB8&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"075a033c0feb7e38f00ac80b5398732f\",BT Sport ESPN HD\nhttp://localhost:9981/stream/channelid/1006852615?ticket=2333D14D30F12F7BE3749F2ACB9173FB96FC8D1A&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"8c6980463aa059c8d1b2eb8d3779a15f\",Eurosport 5HD\nhttp://localhost:9981/stream/channelid/1182820748?ticket=16F55C2A94DAF6B11A666E134B0AC4850422CBDC&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"96c64f32569c1016b0a345c150d96cdc\",Freesports HD\nhttp://localhost:9981/stream/channelid/844088982?ticket=B505BEAE6456C56AAB32DA0EDB24F9C74EDFE7AE&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"dd801366afb7860974c87df65568089a\",GOLD HD\nhttp://localhost:9981/stream/channelid/1712554205?ticket=702BD4F98C4E194CD63071FE6AE6C215321C312F&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"c60ccc45c80074df2201e541b3f9f672\",Liverpool FC TV\nhttp://localhost:9981/stream/channelid/1171000518?ticket=B70A5B91C67EFA7C0B13B0CF155B1B6B9DCE1A1D&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"3de40017906acfcc92055f30bbbadf63\",National GeographicHD\nhttp://localhost:9981/stream/channelid/385934397?ticket=79FDE7970DFBB44BCC5C40F00F8D29A48E063FBF&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"8a7082bf75c3899f43bf58bb10d27c96\",NHK World-Japan\nhttp://localhost:9981/stream/channelid/1065513098?ticket=E6731CBB28A727CDB05A7FE0DAC3FC1162AE0F16&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"25915bf3fc4575f4d066bb684b2d9939\",Old Channel 4HD\nhttp://localhost:9981/stream/channelid/1935380773?ticket=B53AF43FD2B9E4EDD361C98EBA6495E4AE0DBAFA&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"56735d2153c8c491b8f1c8fcada1b8cd\",Premier 1 HD\nhttp://localhost:9981/stream/channelid/559772502?ticket=E60F7E7F4E1EF6F720DE948513EDF9ED742BB314&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"e0bc8bcb250dc0106d07460a5758e314\",Sky 5* Movies HD\nhttp://localhost:9981/stream/channelid/1267449056?ticket=2233E71895378FC7F27BFB9008F8443FF67826F0&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"544a5694b9d27353cbeb00bd7ed2c0eb\",Sky Aliens HD\nhttp://localhost:9981/stream/channelid/341199444?ticket=6AEA7309F0596E2874D31C0E209FE074334A7C0C&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"cf3a9bacb0d2a94ab0ae5daf688f5b1d\",Sky Disney HD\nhttp://localhost:9981/stream/channelid/748370639?ticket=FC6B4EEFDAA713DA5AC241FC4CA321D696FBFAEB&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"665cd49dd0cd0fbe2f047630e12f4f22\",Sky One HD\nhttp://localhost:9981/stream/channelid/500456550?ticket=ED70D5526470C5D6E110860E6C93B88A31E6FF66&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"9d21d2b830da02b4c6f8becd36788478\",Sky Premiere HD\nhttp://localhost:9981/stream/channelid/953295261?ticket=435C144696B09DBA64481086DD47A6762A895FDC&profile=webtv-h264-aac-matroska\n#EXTINF:-1 tvg-id=\"dab63f70df9ef5c69ff172af785c080c\",vm0 - 682.75 - dvb-c/682.75MHz/{PMT:37}\nhttp://localhost:9981/stream/channelid/1883223770?ticket=6B9327EA5E6258642EFB3E9181974897F7AB847B&profile=webtv-h264-aac-matroska\n\",\"streams\":[{\"name\":\"BT Sport 1 HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1349432262\"},{\"name\":\"BT Sport ESPN HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1006852615\"},{\"name\":\"Eurosport 5HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1182820748\"},{\"name\":\"Freesports HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/844088982\"},{\"name\":\"GOLD HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1712554205\"},{\"name\":\"Liverpool FC TV\",\"stream_url\":\"http://localhost:9981/stream/channelid/1171000518\"},{\"name\":\"National GeographicHD\",\"stream_url\":\"http://localhost:9981/stream/channelid/385934397\"},{\"name\":\"NHK World-Japan\",\"stream_url\":\"http://localhost:9981/stream/channelid/1065513098\"},{\"name\":\"Old Channel 4HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1935380773\"},{\"name\":\"Premier 1 HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/559772502\"},{\"name\":\"Sky 5* Movies HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/1267449056\"},{\"name\":\"Sky Aliens HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/341199444\"},{\"name\":\"Sky Disney HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/748370639\"},{\"name\":\"Sky One HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/500456550\"},{\"name\":\"Sky Premiere HD\",\"stream_url\":\"http://localhost:9981/stream/channelid/953295261\"},{\"name\":\"vm0 - 682.75 - dvb-c/682.75MHz/{PMT:37}\",\"stream_url\":\"http://localhost:9981/stream/channelid/1883223770\"}]}"';

	$data = json_decode($json, true);
	$data = json_decode($data, true);

	echo '<pre>';
	print_r($data);
}

function server_delete(){
	global $conn;

	$server_id = get('server_id');

	// check if server is owned by this user
	$query = $conn->query("SELECT `id` FROM `headend_servers` WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	if($query !== FALSE) {
		// this user owns this server

		// define tables to delete from
		$tables = array('capture_devices','capture_devices_audio','cdn_streams_servers','headend_server_logs','jobs','streams_acl_rules','streams_connection_logs');

		// loop through working tables
		foreach ($tables as $table) {
			$query = $conn->query("DELETE FROM `".$table."` WHERE `server_id` = '".$server_id."' ");
		}

		// delete primary record
		$query = $conn->query("DELETE FROM `headend_servers` WHERE `id` = '".$server_id."' ");

		// log and wrap up
		// log_add("Server Deleted:");
    	status_message('success',"Server has been deleted from SlipStream. Please remember to delete the files from the server in /root/slipstream");
    	// return user to previous page
    	go($_SERVER['HTTP_REFERER']);
	}else{
		// this user DOES NOT own this server
		// log_add("Server Delete Fail: You dont own this server.");
    	status_message('danger',"It appears you do not own this server. This security breach has been reported.");
    	go($_SERVER['HTTP_REFERER']);
	}
}

function ajax_headends(){
	global $conn;

	header("Content-Type:application/json; charset=utf-8");

	$query = $conn->query("SELECT * FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	if($query !== FALSE) {
		$headends = $query->fetchAll(PDO::FETCH_ASSOC);

		$count = 0;

		foreach($headends as $headend) {
			$output[$count] = $headend;
			
			// convert seconds to human readable format
			$output[$count]['uptime'] = uptime($headend['uptime']);

			// convert bandwidth to mbit
			$output[$count]['bandwidth_down'] 		= number_format($headend['bandwidth_down'] / 125, 0);
			$output[$count]['bandwidth_up'] 		= number_format($headend['bandwidth_up'] / 125, 0);

			// get source details
			$query = $conn->query("SELECT * FROM `capture_devices` WHERE `server_id` = '".$headend['id']."' ORDER BY `name` ASC");
			if($query !== FALSE) {
				$output[$count]['sources'] = $query->fetchAll(PDO::FETCH_ASSOC);
				$output[$count]['total_sources'] = count($output[$count]['sources']);
			}else{
				$output[$count]['total_sources'] = 0;
			}

			$count++;
		}

		$json = json_encode($output);

		echo $json;
	}
}

function ajax_headend(){
	global $conn;

	header("Content-Type:application/json; charset=utf-8");

	$server_id = get('server_id');

	$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$server_id."' ");
	if($query !== FALSE) {
		$headends = $query->fetchAll(PDO::FETCH_ASSOC);

		$count = 0;

		foreach($headends as $headend) {
			$output[$count] = $headend;
			
			// convert seconds to human readable format
			$output[$count]['uptime'] = uptime($headend['uptime']);

			// get source details
			$query = $conn->query("SELECT * FROM `capture_devices` WHERE `server_id` = '".$headend['id']."' ORDER BY `video_device` ASC");
			if($query !== FALSE) {
				$output[$count]['sources'] = $query->fetchAll(PDO::FETCH_ASSOC);
				$output[$count]['total_sources'] = count($output[$count]['sources']);
			}else{
				$output[$count]['total_sources'] = 0;
			}

			$output[$count]['nginx_stats'] = json_decode($headend['nginx_stats'], true);

			$output[$count]['astra_config_file'] = json_decode($headend['astra_config_file'], true);

			$output[$count]['gpu_stats'] = json_decode($headend['gpu_stats'], true);

			if(file_exists($output[$count]['mumudvb_config_file'])){
				$output[$count]['mumudvb_config_file'] = json_decode(file_get_contents($output[$count]['mumudvb_config_file']), true);
			}

			if(file_exists($output[$count]['tvheadend_config_file'])){
				$output[$count]['tvheadend_config_file'] = json_decode(file_get_contents($output[$count]['tvheadend_config_file']), true);
			}

			$count++;
		}

		$json = json_encode($output);

		echo $json;
	}
}

function headend_add(){
	global $conn;

	header("Content-Type:application/json; charset=utf-8");

	$uuid 					= md5(time());

	$name 					= addslashes($_GET['name']);
	$name 					= trim($name);

	// $ip_address 			= addslashes($_GET['ip_address']);
	// $ssh_port			= addslashes($_POST['ssh_port']);
	// $ssh_password 		= addslashes($_POST['ssh_password']);

	$insert = $conn->exec("INSERT INTO `headend_servers` 
        (`user_id`,`uuid`,`name`)
        VALUE
        ('".$_SESSION['account']['id']."', '".$uuid."','".$name."')");
    
    $server_id = $conn->lastInsertId();

    if(!$insert) {
        // echo "\nPDO::errorInfo():\n";
        // print_r($conn->errorInfo());

        $data[0]['status'] 			= 'error';
    	$data[0]['error'] 			= $conn->errorInfo();
    }else{
    	// file_get_contents($site['url']."actions.php?a=job_add&server_id=".$server_id."&job=install");
    	// log_add("[".$name."] has been added.");
    	status_message('success',"[".$name."] has been added and will be installed shortly.");
    	// go($_SERVER['HTTP_REFERER']);

    	$data[0]['status'] 			= 'added';
    	$data[0]['server_id'] 		= $server_id;
    	$data[0]['server_uuid'] 	= $uuid;
    }

    json_output($data);
}

function headend_update()
{
	global $conn;

	$server_id 			= $_POST['server_id'];
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);
	// $ssh_port			= addslashes($_POST['ssh_port']);
	// $ssh_password 		= addslashes($_POST['ssh_password']);
	$http_stream_port	= addslashes($_POST['http_stream_port']);
	$http_stream_port 	= trim($http_stream_port);

	$public_hostname	= addslashes($_POST['public_hostname']);
	$public_hostname	= trim($public_hostname);

	$update = $conn->exec("UPDATE `headend_servers` SET `name` = '".$name."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	// $update = $conn->exec("UPDATE `headend_servers` SET `ssh_port` = '".$ssh_port."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	// $update = $conn->exec("UPDATE `headend_servers` SET `ssh_password` = '".$ssh_password."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `headend_servers` SET `http_stream_port` = '".$http_stream_port."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `headend_servers` SET `public_hostname` = '".$public_hostname."' WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// echo '<pre>';
	// print_r($_POST);
	// echo '</pre>';

    // log_add("[".$name."] has been updated.");
    status_message('success',$name." has been updated.");
    go($_SERVER['HTTP_REFERER']);
}

function ajax_sources_audio()
{
	global $conn;

	$server_id = $_GET['server_id'];

	header("Content-Type:application/json; charset=utf-8");

	$query = $conn->query("SELECT * FROM `capture_devices_audio` WHERE `server_id` = '".$server_id."' ");
	if($query !== FALSE) {
		$sources = $query->fetchAll(PDO::FETCH_ASSOC);

		json_output($sources);
	}
}

function ajax_source_video()
{
	global $conn;

	$source_id = $_GET['source_id'];

	header("Content-Type:application/json; charset=utf-8");

	$query = $conn->query("SELECT * FROM `capture_devices` WHERE `id` = '".$source_id."' ");
	if($query !== FALSE) {
		$sources = $query->fetchAll(PDO::FETCH_ASSOC);

		json_output($sources);
	}
}

function ajax_streams_list()
{
	global $conn;

	$user_id = $_SESSION['account']['id'];

	header("Content-Type:application/json; charset=utf-8");

	function find_outputs($array, $key, $value){
	    $results = array();

	    if (is_array($array)) {
	        if (isset($array[$key]) && $array[$key] == $value) {
	            $results[] = $array;
	        }

	        foreach ($array as $subarray) {
	            $results = array_merge($results, find_outputs($subarray, $key, $value));
	        }
	    }

	    return $results;
	}

	// get headend info
	$query = $conn->query("SELECT `id`,`name`,`wan_ip_address`,`status` FROM `headend_servers` WHERE `user_id` = '".$user_id."' ");
	$headends = $query->fetchAll(PDO::FETCH_ASSOC);

	// get stream categories
	$query = $conn->query("SELECT `id`,`name` FROM `stream_categories` WHERE `user_id` = '".$user_id."' ");
	$categories = $query->fetchAll(PDO::FETCH_ASSOC);

	// handle source_domain filter

	if(empty($_GET['source_domain'])){
		$source_domain_filter = '';
	}else{
		$source_domain_filter = "AND `source` LIKE '%".$_GET['source_domain']."%' ";
	}

	// get streams for this user
	if(empty($_GET['server_id']) || $_GET['server_id'] == 0){
		$query = $conn->query("SELECT `id`,`status`,`enable`,`server_id`,`source`,`logo`,`name`,`stream_uptime`,`category_id`,`probe_bitrate`,`probe_video_codec`,`probe_audio_codec`,`probe_aspect_ratio`,`fps`,`speed`,`source_type` FROM `streams` WHERE `user_id` = '".$user_id."' AND `stream_type` = 'input' " . $source_domain_filter);
		$streams_in = $query->fetchAll(PDO::FETCH_ASSOC);

		$query = $conn->query("SELECT `id`,`status`,`enable`,`server_id`,`source_stream_id`,`source_server_id`,`name`,`stream_uptime`,`fps`,`speed`,`probe_bitrate`,`probe_video_codec`,`probe_audio_codec` FROM `streams` WHERE `user_id` = '".$user_id."' AND `stream_type` = 'output' " . $source_domain_filter);
		$streams_out = $query->fetchAll(PDO::FETCH_ASSOC);
	}else{
		$query = $conn->query("SELECT `id`,`status`,`enable`,`server_id`,`source`,`logo`,`name`,`stream_uptime`,`category_id`,`probe_bitrate`,`probe_video_codec`,`probe_audio_codec`,`probe_aspect_ratio`,`fps`,`speed`,`source_type` FROM `streams` WHERE `user_id` = '".$user_id."' AND `server_id` = '".$_GET['server_id']."' AND `stream_type` = 'input' " . $source_domain_filter);
		$streams_in = $query->fetchAll(PDO::FETCH_ASSOC);

		$query = $conn->query("SELECT `id`,`status`,`enable`,`server_id`,`source_stream_id`,`source_server_id`,`name`,`stream_uptime`,`fps`,`speed`,`probe_bitrate`,`probe_video_codec`,`probe_audio_codec` FROM `streams` WHERE `user_id` = '".$user_id."' AND `server_id` = '".$_GET['server_id']."' AND `stream_type` = 'output' " . $source_domain_filter);
		$streams_out = $query->fetchAll(PDO::FETCH_ASSOC);
	}

	if(get('dev') == 'yes'){
		$dev['query_1'] = $query;
	}

	if($query !== FALSE) {
		$count = 0;

		foreach($streams_in as $stream) {
			$output[$count] 					= $stream;

			$output[$count]['checkbox']			= '<center><input type="checkbox" class="chk" id="checkbox_'.$stream['id'].'" name="stream_ids[]" value="'.$stream['id'].'" onclick="multi_options();"></center>';

			if(empty($stream['logo'])){
				$output[$count]['logo'] 		= '';
			}else{
				// $output[$count]['logo'] 		= '<center><img src="'.$stream['logo'].'" height="25px" alt="'.stripslashes($stream['name']).'"></center>';
				$output[$count]['logo'] 		= '';
			}

			$output[$count]['name'] 			= stripslashes($stream['name']);

			// get headend data
			foreach($headends as $headend) {
				if($headend['id'] == $stream['server_id']) {
					$output[$count]['server_name']				= stripslashes($headend['name']);
				}
			}

			// convert seconds to human readable time
			if(empty($stream['stream_uptime'])) {
				$output[$count]['stream_uptime'] 			= '00:00';
			}else{
				$output[$count]['stream_uptime'] 			= $stream['stream_uptime'];
			}
			
			// count number of related outputs
			// $output[$count]['total_outputs'] 				= total_stream_outputs($stream['id']);

			// get online clients for this stream
			$time_shift = time() - 60;
			// $query = $conn->query("SELECT `id` FROM `streams_connection_logs` WHERE `stream_id` = '".$stream['id']."' AND `timestamp` > '".$time_shift."' ");
			// $stream['online_clients'] = $query->fetchAll(PDO::FETCH_ASSOC);
			// $output[$count]['total_online_clients'] = count($stream['online_clients']);
			// $output[$count]['total_online_clients'] 		= 999;

			// number of output streams
			// $output[$count]['total_output_streams'] 		= total_stream_outputs($stream['id']);

			$output[$count]['category_name'] = '';
			if(is_array($categories)) {
				foreach($categories as $category) {
					if($category['id'] == $stream['category_id']) {
						$output[$count]['category_name'] = $category['name'];
					}
				}
			}else{
				$output[$count]['category_name'] = '';
			}

			// $output[$count]['watermark_type']		= ucfirst($stream['watermark_type']);
			// $output[$count]['fingerprint']			= ucfirst($stream['fingerprint']);
			$output[$count]['watermark_type']		= '';
			$output[$count]['fingerprint']			= '';

			if($stream['source_type'] == 'direct'){
				$output[$count]['source_type']	= '<center><i class="fas fa-tv" title="Direct Source"><span class="hidden">Direct</span></i></center>';
			}elseif($stream['source_type'] == 'restream'){
				$output[$count]['source_type']	= '<center><i class="fas fa-sitemap" title="Restream Source"><span class="hidden">Restream</span></i></center>';
			}elseif($stream['source_type'] == 'cdn'){
				$output[$count]['source_type']	= '<center><i class="fas fa-server" title="CDN Source"><span class="hidden">CDN</span></i></center>';
			}

			// set some visual array items
			if($stream['status'] == 'online') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-green full-width">Online</small>';
		    }elseif($headend['status'] == 'offline' && $stream['status'] == 'offline') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-red full-width">Offline</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'offline') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-orange full-width">Starting</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }elseif($stream['enable'] == 'no' && $stream['status'] == 'offline') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-red full-width">Stopped</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }elseif($stream['status'] == 'analysing') {
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-orange full-width">Analysing</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }else{
		    	$output[$count]['visual_stream_status'] = '<small class="label bg-blue full-width">UNKNOWN</small>';
		    	$output[$count]['fps']					= '';
		    	$output[$count]['stream_uptime']		= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['speed']				= '';
		    	$output[$count]['probe_bitrate']		= '';
		    	$output[$count]['probe_video_codec']	= '';
		    	$output[$count]['probe_audio_codec']	= '';
		    	$output[$count]['probe_aspect_ratio']	= '';
		    }

		    $output[$count]['visual_source_stream_start'] 	= '';
		    $output[$count]['visual_source_stream_stop']	= '';
		    $output[$count]['visual_source_stream_restart']	= '';

		    if($stream['enable'] == 'no'){
				$output[$count]['visual_source_stream_start']	= '<a title="Start Stream" class="btn btn-success btn-xs btn-flat" href="actions.php?a=stream_start&stream_id='.$stream['id'].'">Start</i></a>';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'offline'){
		    	$output[$count]['visual_source_stream_stop'] 	= '<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" onclick="return confirm(\'Please allow up to 60 seconds for stream to stop.\')" href="actions.php?a=stream_stop&stream_id='.$stream['id'].'">Stop</a>';
		    	$output[$count]['visual_source_stream_restart'] = '<a title="Restart Stream" class="btn btn-warning btn-xs btn-flat" href="actions.php?a=stream_restart&stream_id='.$stream['id'].'">Restart</i></a>';
		    }elseif($stream['enable'] == 'yes' && $stream['status'] == 'online'){
		    	$output[$count]['visual_source_stream_stop'] 	= '<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" onclick="return confirm(\'Please allow up to 60 seconds for stream to stop.\')" href="actions.php?a=stream_stop&stream_id='.$stream['id'].'">Stop</a>';
		    	$output[$count]['visual_source_stream_restart'] = '<a title="Restart Stream" class="btn btn-warning btn-xs btn-flat" href="actions.php?a=stream_restart&stream_id='.$stream['id'].'">Restart</i></a>';
		    }

		    if($headend['status'] == 'offline'){
		    	// $output[$count]['visual_source_stream_start'] 	= '';
		    	$output[$count]['visual_source_stream_stop']	= '';
		    	$output[$count]['visual_source_stream_restart']	= '';
		    }

		    $output[$count]['visual_source_stream_edit'] ='<a title="Edit Stream" class="btn btn-info btn-xs btn-flat" href="dashboard.php?c=stream&stream_id='.$stream['id'].'">Edit</a>';
		    $output[$count]['visual_source_stream_delete'] ='<a title="Delete Stream" class="btn btn-danger btn-xs btn-flat" href="actions.php?a=stream_delete&stream_id='.$stream['id'].'" onclick="return confirm(\'Are you sure?\')">Delete</a>';

		    // convert bits to megabit for bitrate
		    if($stream['status'] == 'online'){
		    	if(is_numeric($stream['probe_bitrate'])){
		    		$output[$count]['bitrate'] 			= number_format(($stream['probe_bitrate'] / 1e+6), 2).' Mbit';
		    	}else{
		    		$output[$count]['bitrate'] 			= '0 Mbit';
		    	}
		    	$output[$count]['probe_video_codec'] 	= strtoupper($stream['probe_video_codec']);
		    	$output[$count]['probe_audio_codec'] 	= strtoupper($stream['probe_audio_codec']);
		    }else{
		    	$output[$count]['bitrate'] 				= '';
		    	$output[$count]['probe_video_codec'] 	= '';
		    	$output[$count]['probe_audio_codec'] 	= '';
		    }

			$output[$count]['output_streams'] = '';
			$output_stream['output_streams'] = '';

			// echo "Found " . array_search("#0000cc", $data);

			$output_streams = find_outputs($streams_out, 'source_stream_id', $stream['id']);
			
			if(is_array($output_streams)){
				// number of output streams
				$output[$count]['total_output_streams'] 				= count($output_streams);
				$output[$count]['total_outputs']						= $output[$count]['total_output_streams'];

				foreach($output_streams as $output_stream){
					$output[$count]['output_streams'] .= '<tr>';

					// get headend data
					foreach($headends as $headend) {
						if($headend['id'] == $output_stream['server_id']) {
							$output_stream['server_name']				= stripslashes($headend['name']);
						}
					}

					if(empty($output_stream['server_name'])){
						$output_stream['server_name'] = 'Main Server';
					}

					$output_stream['visual_output_stream_status'] = '';

					if($output_stream['status'] == 'online'){
						$output_stream['visual_output_stream_status'] 	= '<small class="label bg-green full-width">Online</small>';
					}elseif($headend['status'] == 'offline' && $output_stream['status'] == 'offline') {
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-red full-width">Offline</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }elseif($output_stream['enable'] == 'yes' && $output_stream['status'] == 'offline') {
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-orange full-width">Restarting</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }elseif($output_stream['enable'] == 'no' && $output_stream['status'] == 'offline') {
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-red full-width">Stopped</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }elseif($output_stream['status'] == 'analysing') {
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-orange full-width">Analysing</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }else{
				    	$output_stream['visual_output_stream_status'] 	= '<small class="label bg-blue full-width">UNKNOWN</small>';
				    	$output_stream['fps']							= '';
				    	$output_stream['stream_uptime']					= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['speed']							= '';
				    	$output_stream['probe_bitrate']					= '';
				    	$output_stream['probe_video_codec']				= '';
				    	$output_stream['probe_audio_codec']				= '';
				    	$output_stream['probe_aspect_ratio']			= '';
				    }

				    $output_stream['visual_output_stream_start'] 	= '';
				    $output_stream['visual_output_stream_stop']		= '';
				    $output_stream['visual_output_stream_restart']	= '';

				    if($output_stream['enable'] == 'no'){
						$output_stream['visual_output_stream_start']	= '<a title="Start Stream" class="btn btn-success btn-xs btn-flat" href="actions.php?a=stream_start&stream_id='.$output_stream['id'].'">Start</i></a>';
				    }

				    if($output_stream['enable'] == 'yes' && $output_stream['status'] == 'offline'){
				    	$output_stream['visual_output_stream_stop'] 	= '<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" onclick="return confirm(\'Please allow up to 60 seconds for stream to stop.\')" href="actions.php?a=stream_stop&stream_id='.$output_stream['id'].'">Stop</a>';
				    	$output_stream['visual_output_stream_restart'] = '<a title="Restart Stream" class="btn btn-warning btn-xs btn-flat" href="actions.php?a=stream_restart&stream_id='.$output_stream['id'].'">Restart</i></a>';
				    }

				    if($output_stream['enable'] == 'yes' && $output_stream['status'] == 'online'){
				    	$output_stream['visual_output_stream_stop'] 	= '<a title="Stop Stream" class="btn btn-danger btn-xs btn-flat" onclick="return confirm(\'Please allow up to 60 seconds for stream to stop.\')" href="actions.php?a=stream_stop&stream_id='.$output_stream['id'].'">Stop</a>';
				    	$output_stream['visual_output_stream_restart'] = '<a title="Restart Stream" class="btn btn-warning btn-xs btn-flat" href="actions.php?a=stream_restart&stream_id='.$output_stream['id'].'">Restart</i></a>';
				    }

				    if($headend['status'] == 'offline'){
				    	// $output_stream['visual_output_stream_start'] 	= '';
				    	$output_stream['visual_output_stream_stop']		= '';
				    	$output_stream['visual_output_stream_restart']	= '';
				    }

				    $output_stream['visual_output_stream_edit'] ='<a title="Edit Stream" class="btn btn-info btn-xs btn-flat" href="dashboard.php?c=stream&stream_id='.$output_stream['id'].'">Edit</a>';
				    $output_stream['visual_output_stream_delete'] ='<a title="Delete Stream" class="btn btn-danger btn-xs btn-flat" href="actions.php?a=stream_delete&stream_id='.$output_stream['id'].'" onclick="return confirm(\'Are you sure?\')">Delete</a>';

				    $output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Status:</strong></td>';
					$output[$count]['output_streams'] .= '<td width="1px">'.$output_stream['visual_output_stream_status'].'</td>';

					$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Name:</strong></td>';
					$output[$count]['output_streams'] .= '<td>'.stripslashes($output_stream['name']).'</td>';

					$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Server:</strong></td>';
					$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;">'.stripslashes($output_stream['server_name']).'</td>';

					if($output_stream['status'] == 'online'){
						// get online clients for this stream
						$time_shift = time() - 60;
						$query = $conn->query("SELECT `id` FROM `streams_connection_logs` WHERE `stream_id` = '".$output_stream['id']."' AND `timestamp` > '".$time_shift."' ");
						$output_stream['online_clients'] = $query->fetchAll(PDO::FETCH_ASSOC);
						$output_stream['total_online_clients'] = count($output_stream['online_clients']);
						// $output_stream['total_online_clients'] = 0;


						$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>FPS:</strong></td>';
						$output[$count]['output_streams'] .= '<td width="1px">'.stripslashes($output_stream['fps']).'</td>';
						$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Speed:</strong></td>';
						$output[$count]['output_streams'] .= '<td width="1px">'.stripslashes($output_stream['speed']).'</td>';
						$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Bitrate:</strong></td>';
						if(is_numeric($output_stream['probe_bitrate'])) {
							$output[$count]['output_streams'] .= '<td>'.number_format(($output_stream['probe_bitrate'] / 1e+6), 2).' Mbit</td>';
						}else{
							$output[$count]['output_streams'] .= '<td>N/A</td>';
						}
						$output[$count]['output_streams'] .= '<td width="1px" style="white-space: nowrap;"><strong>Conn:</strong></td>';
						$output[$count]['output_streams'] .= '<td>'.$output_stream['total_online_clients'].'</td>';
					}else{
						$output[$count]['output_streams'] .= '<td></td>';
						$output[$count]['output_streams'] .= '<td></td>';
						$output[$count]['output_streams'] .= '<td></td>';
						$output[$count]['output_streams'] .= '<td></td>';
						$output[$count]['output_streams'] .= '<td></td>';
						$output[$count]['output_streams'] .= '<td></td>';
						$output[$count]['output_streams'] .= '<td></td>';
						$output[$count]['output_streams'] .= '<td></td>';
					}

					$output[$count]['output_streams'] .= '<td width="150px" class="text-right">'.$output_stream['visual_output_stream_start'].''.$output_stream['visual_output_stream_stop'].''.$output_stream['visual_output_stream_restart'].''.$output_stream['visual_output_stream_edit'].''.$output_stream['visual_output_stream_delete'].'</td>';

					$output[$count]['output_streams'] .= '</tr>';
				}
			}

			$count++;
		}

		// $json_out = json_encode(array_values($your_array_here));

		// $output = array_values($output);
		// $data['data'] = $output;

		if(isset($output)) {
			$data['data'] = array_values($output);
		}else{
			$data['data'] = array();
		}

		if(get('dev') == 'yes'){
			$data['dev'] = $dev;
		}

		json_output($data);
	}
}

function job_add()
{
	global $conn;


	$server_id 			= addslashes($_GET['server_id']);
	$headend 			= @file_get_contents($site['url']."actions.php?a=ajax_headend&server_id=".$server_id);
	$job 				= addslashes($_GET['job']);

	if($job == 'reboot') {
		$data['action'] = 'reboot';
		$data['command'] = '/sbin/reboot';
		// example: {"action":"kill_pid","command":"kill -9 12748"}
	}

	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$server_id."','".json_encode($data)."')");
    
    if(!$insert) {
        echo "\nPDO::errorInfo():\n";
        print_r($conn->errorInfo());
    }else{
    	if($job == 'reboot') {
    		// log_add("[".$headend['name']."] rebooting.");
			status_message('success',"[".$headend['name']."] will be rebooted shortly.");
		}

    	go($_SERVER['HTTP_REFERER']);
    }
}

function ajax_logs()
{
	global $conn;

	header("Content-Type:application/json; charset=utf-8");

	$query = $conn->query("SELECT * FROM `logs` WHERE `user_id` = '".$_SESSION['account']['id']."' ORDER BY `id` DESC");
	if($query !== FALSE) {
	    $logs = $query->fetchAll(PDO::FETCH_ASSOC);
	    $count = 0;
		foreach($logs as $log) {
			$output[$count]['added'] = date("M, jS Y H:i:s", $log['added']);
			$output[$count]['message'] = stripslashes($log['message']);
			$count++;
		}
	} else {
	   $output = '';
	}

	$json = json_encode($output);

	echo $json;
}

function source_update()
{
	global $conn;

	$source_id 						= $_POST['source_id'];

	$data['source_id']				= $_POST['source_id'];
	$data['name'] 					= addslashes($_POST['name']);
	$data['enable']					= addslashes($_POST['enable']);
	$data['video_codec'] 			= addslashes($_POST['video_codec']);
	$data['framerate_in'] 			= addslashes($_POST['framerate_in']);
	$data['framerate_out'] 			= addslashes($_POST['framerate_out']);
	$data['screen_resolution'] 		= addslashes($_POST['screen_resolution']);
	$data['audio_device'] 			= addslashes($_POST['audio_device']);
	$data['audio_codec'] 			= addslashes($_POST['audio_codec']);
	$data['audio_bitrate'] 			= addslashes($_POST['audio_bitrate']);
	$data['audio_sample_rate'] 		= addslashes($_POST['audio_sample_rate']);
	$data['bitrate'] 				= addslashes($_POST['bitrate']);
	$data['output_type'] 			= addslashes($_POST['output_type']);
	$data['rtmp_server'] 			= addslashes($_POST['rtmp_server']);
	$data['watermark_type'] 		= addslashes($_POST['watermark_type']);
	$data['watermark_image'] 		= addslashes($_POST['watermark_image']);
	$data['rtmp_server'] 			= addslashes($_POST['rtmp_server']);
	$data['rtmp_server'] 			= addslashes($_POST['rtmp_server']);

	foreach($data as $key => $value) {
		// echo $key . " -> " . $value . '<br>';
		$update = $conn->exec("UPDATE `capture_devices` SET `".$key."` = '".$value."' WHERE `id` = '".$source_id."' ");
	}
	
    // log_add("[".$_POST['video_device']."] has been updated.");
    status_message('success',"[".$_POST['video_device']."] has been updated.");
    go($_SERVER['HTTP_REFERER']);
}

function source_stop()
{
	global $conn;

	$source_id = get('source_id');

	$update = $conn->exec("UPDATE `capture_devices` SET `enable` = 'no' WHERE `id` = '".$source_id."' ");
	
    // log_add("Streaming has been stopped.");
}

function source_start()
{
	global $conn;

	$source_id = get('source_id');

	$update = $conn->exec("UPDATE `capture_devices` SET `enable` = 'yes' WHERE `id` = '".$source_id."' ");
	
    // log_add("Streaming has been started.");
}

function source_scan()
{
	global $conn;

	$source_id = $_GET['source_id'];

	$query = $conn->query("SELECT * FROM `capture_devices` WHERE `id` = '".$source_id."' ");
	$source = $query->fetchAll(PDO::FETCH_ASSOC);

	// confirm this is a dvb card
	if($source[0]['type'] == 'dvb_card') {
		// $query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$source[0]['server_id']."' ");
		// $headend = $query->fetchAll(PDO::FETCH_ASSOC);

		$adapter_name_short = str_replace('adapter', '', $source[0]['video_device']);

		$job['action'] = 'source_scan';
		if($source[0]['dvb_type'] == 'dvbt') {
			$job['command'] = 'w_scan -X -a'.$adapter_name_short.' -c GB > /root/slipstream/node/config/channel_scan/'.$source[0]['video_device'].'.conf';
		}
		$job['source'] = $source[0]['video_device'];

		$job = json_encode($job);

		$insert = $conn->exec("INSERT INTO `jobs` 
	        (`server_id`,`job`)
	        VALUE
	        ('".$source[0]['server_id']."','".$job."')");

		// log_add("Channel scan has been started.");
	}else{
		// log_add("ERROR: This device is not a valid DVB card.");
	}
}

function ajax_stream()
{
	global $conn;

	header("Content-Type:application/json; charset=utf-8");

	$stream_id = get('stream_id');

	$query = $conn->query("SELECT * FROM `streams` WHERE `id` = '".$stream_id."' ");
	if($query !== FALSE) {
		$streams = $query->fetchAll(PDO::FETCH_ASSOC);

		$count = 0;

		foreach($streams as $stream) {
			$output[$count] = $stream;
			
			// $output[$count]['output_options'] = json_decode($stream['output_options'], true);

			$count++;
		}

		$json = json_encode($output);

		echo $json;
	}
}

function stream_update()
{
	global $conn;

	$stream_id 						= addslashes($_POST['stream_id']);

	$data['enable']					= addslashes($_POST['enable']);

	$data['name'] 					= addslashes($_POST['name']);
	$data['name']					= trim($data['name']);
	
	$data['server_id']				= addslashes($_POST['server_id']);

	$data['user_agent'] 			= addslashes($_POST['user_agent']);
	$data['user_agent']				= trim($data['user_agent']);

	$data['ffmpeg_re']				= addslashes($_POST['ffmpeg_re']);
	
	if($_POST['stream_type'] == 'input') {
		$data['source']						= addslashes($_POST['source']);
		$data['source']						= trim($data['source']);

		$data['category_id']				= addslashes($_POST['category_id']);

		$data['source_type']				= addslashes($_POST['source_type']);

		$data['logo']						= addslashes($_POST['logo']);
		$data['logo']						= trim($data['logo']);
		$data['logo']						= str_replace(' ', '', $data['logo']);

		$data['server_id']					= addslashes($_POST['server_id']);

		$update = $conn->exec("UPDATE `streams` SET `server_id` = '".$data['server_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `source_server_id` = '".$data['server_id']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `source` = '".$data['source']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `source_type` = '".$data['source_type']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `source_type` = '".$data['source_type']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		
		// update category for input and output streams.
		$update = $conn->exec("UPDATE `streams` SET `category_id` = '".$data['category_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `category_id` = '".$data['category_id']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `logo` = '".$data['logo']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `logo` = '".$data['logo']."' WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	}elseif($_POST['stream_type'] == 'output'){
		$data['server_id']				= addslashes($_POST['server_id']);
		$update = $conn->exec("UPDATE `streams` SET `server_id` = '".$data['server_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$data['source_stream_id']		= addslashes($_POST['source_stream_id']);

		$data['transcoding_profile_id']		= addslashes($_POST['transcoding_profile_id']);

		$update = $conn->exec("UPDATE `streams` SET `transcoding_profile_id` = '".$data['transcoding_profile_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		// get source source for this stream id
		$query = $conn->query("SELECT `id`,`server_id` FROM `streams` WHERE `user_id` = '".$_SESSION['account']['id']."' AND `id` = '".$data['source_stream_id']."' ");
		$source_stream = $query->fetch(PDO::FETCH_ASSOC);

		$data['cpu_gpu']				= addslashes($_POST['cpu_gpu']);
		
		$data['surfaces']				= addslashes($_POST['surfaces']);
		if(empty($data['surfaces'])){
			$data['surfaces'] = 12;
		}
		$data['gpu']					= addslashes($_POST['gpu']);

		if($data['cpu_gpu'] == 'cpu') {
			$data['video_codec'] 		= addslashes($_POST['cpu_video_codec']);
		}
		if($data['cpu_gpu'] == 'gpu') {
			$data['video_codec'] 		= addslashes($_POST['gpu_video_codec']);
		}
		$data['screen_resolution'] 		= addslashes($_POST['screen_resolution']);
		$data['framerate'] 				= preg_replace('/[^0-9]/', '', addslashes($_POST['framerate']));
		if(empty($data['framerate'])) {
			$data['framerate'] 			= '0';
		}
		$data['audio_codec'] 			= addslashes($_POST['audio_codec']);
		$data['audio_bitrate'] 			= preg_replace('/[^0-9]/', '', addslashes($_POST['audio_bitrate']));
		if(empty($data['audio_bitrate']) || $data['audio_bitrate'] == '0') {
			$data['audio_bitrate'] 		= '128';
		}
		$data['audio_sample_rate'] 		= preg_replace('/[^0-9]/', '', addslashes($_POST['audio_sample_rate']));
		if(empty($data['audio_sample_rate']) || $data['audio_sample_rate'] == '0') {
			$data['audio_sample_rate'] 	= '44100';
		}
		$data['bitrate'] 				= preg_replace('/[^0-9]/', '', addslashes($_POST['bitrate']));
		if(empty($data['bitrate']) || $data['bitrate'] == '0') {
			$data['bitrate'] 			= '2000';
		}

		$data['ac'] 					= addslashes($_POST['ac']);
		if(empty($data['ac']) || $data['ac'] == '0') {
			$data['ac'] = '2';
		}

		$data['preset'] 				= addslashes($_POST['preset']);
		$data['profile'] 				= addslashes($_POST['profile']);
		
		$update = $conn->exec("UPDATE `streams` SET `source_server_id` = '".$source_stream['server_id']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `streams` SET `cpu_gpu` = '".$data['cpu_gpu']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `surfaces` = '".$data['surfaces']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		if(!empty($data['gpu'])){
			$update = $conn->exec("UPDATE `streams` SET `gpu` = '".$data['gpu']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		$update = $conn->exec("UPDATE `streams` SET `video_codec` = '".$data['video_codec']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `screen_resolution` = '".$data['screen_resolution']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `framerate` = '".$data['framerate']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `audio_codec` = '".$data['audio_codec']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `audio_bitrate` = '".$data['audio_bitrate']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `audio_sample_rate` = '".$data['audio_sample_rate']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `bitrate` = '".$data['bitrate']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `ac` = '".$data['ac']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `preset` = '".$data['preset']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `streams` SET `profile` = '".$data['profile']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	$update = $conn->exec("UPDATE `streams` SET `enable` = '".$data['enable']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `name` = '".$data['name']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `user_agent` = '".$data['user_agent']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
	if($data['enable'] == 'yes') {
		$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'yes' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}
	$update = $conn->exec("UPDATE `streams` SET `ffmpeg_re` = '".$data['ffmpeg_re']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Stream changes have been saved.");
    status_message('success',"Stream changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_update_fingerprint()
{
	global $conn;

	$stream_id 						= addslashes($_POST['stream_id']);

	// fingerprint options
	$data['fingerprint']			= addslashes($_POST['fingerprint']);
	$data['fingerprint_type']		= addslashes($_POST['fingerprint_type']);
	$data['fingerprint_text']		= addslashes($_POST['fingerprint_text']);
	$data['fingerprint_fontsize']	= addslashes($_POST['fingerprint_fontsize']);
	$data['fingerprint_color']		= addslashes($_POST['fingerprint_color']);
	$data['fingerprint_location']	= addslashes($_POST['fingerprint_location']);

	$update = $conn->exec("UPDATE `streams` SET `fingerprint` = '".$data['fingerprint']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_type` = '".$data['fingerprint_type']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_text` = '".$data['fingerprint_text']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_color` = '".$data['fingerprint_color']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_fontsize` = '".$data['fingerprint_fontsize']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_location` = '".$data['fingerprint_location']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Stream changes have been saved.");
    status_message('success',"Stream changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_update_dehash()
{
	global $conn;

	$stream_id 						= addslashes($_POST['stream_id']);

	// fingerprint options
	$data['dehash']					= addslashes($_POST['dehash']);
	$data['fingerprint_type']		= addslashes($_POST['fingerprint_type']);
	$data['fingerprint_text']		= addslashes($_POST['fingerprint_text']);
	$data['fingerprint_fontsize']	= addslashes($_POST['fingerprint_fontsize']);
	$data['fingerprint_color']		= addslashes($_POST['fingerprint_color']);
	$data['fingerprint_location']	= addslashes($_POST['fingerprint_location']);

	$update = $conn->exec("UPDATE `streams` SET `fingerprint` = '".$data['fingerprint']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_type` = '".$data['fingerprint_type']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_text` = '".$data['fingerprint_text']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_color` = '".$data['fingerprint_color']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_fontsize` = '".$data['fingerprint_fontsize']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fingerprint_location` = '".$data['fingerprint_location']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Stream changes have been saved.");
    status_message('success',"Stream changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_restart()
{
	global $conn, $site;

	$stream_id = get('stream_id');

	$stream_raw 				= file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id);
	$stream 					= json_decode($stream_raw, true);

	$job['action'] = 'kill_pid';
	$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

	// add the job
	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$stream[0]['server_id']."','".json_encode($job)."')");

	$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Stream is restarting.");
	status_message('success',"Stream will restart shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_stop()
{
	global $conn;

	$stream_id = get('stream_id');

	$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'none'	 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'none' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Stream has been stopped.");
	status_message('success',"Stream has been stopped.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_start()
{
	global $conn;

	$stream_id = get('stream_id');

	// start source stream
	$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// start output stream
	$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Streaming has been started.");
    status_message('success',"Stream has been started.");
    go($_SERVER['HTTP_REFERER']);
}

function stream_add()
{
	global $conn;
	
	$rand 				= md5(rand(00000,99999).time());
	
	$source_method 		= $_POST['remote_playlist']	;

	if($source_method == 'manual'){
		$source 			= addslashes($_POST['add_stream_url']);
	}else{
		$source 			= addslashes($_POST['add_stream_url_list']);
	}

	$source 			= trim($source);
	$source 			= str_replace(' ', '', $source);
	
	if(empty($source)){
		status_message('danger',"You did not enter a stream source.");
    	go($_SERVER['HTTP_REFERER']);
	}

	$server_id			= addslashes($_POST['server']);
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$ffmpeg_re			= $_POST['ffmpeg_re'];

	// add input stream
	$insert = $conn->exec("INSERT INTO `streams` 
        (`user_id`,`server_id`,`stream_type`,`name`,`enable`,`source`,`cpu_gpu`,`job_status`,`ffmpeg_re`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        'input',
        '".$name."',
        'yes',
        '".$source."',
        'cpu',
        'analysing',
        '".$ffmpeg_re."'
    )");

    $stream_id = $conn->lastInsertId();

    // add output stream
    $insert = $conn->exec("INSERT INTO `streams` 
        (`user_id`,`enable`,`server_id`,`stream_type`,`name`,`source_server_id`,`source_stream_id`)
        VALUE
        ('".$_SESSION['account']['id']."',
        'yes',
        '".$server_id."',
        'output',
        '".$name."',
        '".$server_id."',
        '".$stream_id."'
    )");
    
	// log_add("Stream has been added.");
	status_message('success',"Stream has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function import_streams()
{
	global $conn;

	// handle file upload
	$target_dir = "m3u_uploads/";
	$target_file = $target_dir . $_SESSION['account']['id'].'-'.str_replace(' ', '_', basename($_FILES["m3u_file"]["name"]));
	$uploadOk = 1;
	$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	// check if file already exists
	/*
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	*/

	// check file size
	/*
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	*/

	// allow certain file formats
	if($file_type != "m3u" && $file_type != "m3u8" && $file_type != "txt") {
		status_message('danger',"Sorry, only .m3u and .m3u8 files are allowed.");
		go($_SERVER['HTTP_REFERER']);
	    $uploadOk = 0;
	}

	// check if $uploadOk is set to 0 by an error
	if($uploadOk == 0) {
	    status_message('danger',"Sorry, there was an error uploading your file.");
		go($_SERVER['HTTP_REFERER']);
	// if everything is ok, try to upload file
	}else{
	    if(move_uploaded_file($_FILES["m3u_file"]["tmp_name"], $target_file)) {
	        // echo "The file ". $_SESSION['account']['id'].'-'.basename( $_FILES["m3u_file"]["name"]). " has been uploaded.";
	    }else{
	    	status_message('danger',"Sorry, there was an error uploading your file.");
			go($_SERVER['HTTP_REFERER']);
	    }
	}

  	// read the uploaded m3u into an array
  	$streams_raw 		= @file_get_contents("http://".$global_settings['cms_access_url']."/actions.php?a=inspect_m3u&url=http://".$global_settings['cms_access_url']."/m3u_uploads/".$_SESSION['account']['id'].'-'.str_replace(' ', '_',basename( $_FILES["m3u_file"]["name"])));
  	$streams 			= json_decode($streams_raw, true);
	
	foreach($streams as $stream) {
		$rand 				= md5(rand(00000,99999).time());
		
		$name 				= addslashes($stream['title']);
		$name 				= str_replace(array(':',';'), '', $name);
		$name 				= trim($name);

		$source 			= addslashes($stream['url']);
		$source 			= trim($source);
		$source 			= str_replace(' ', '', $source);
		
		$server_id			= addslashes($_POST['server']);

		$ffmpeg_re			= $_POST['ffmpeg_re'];

		if(!isset($stream['tvlogo']) || empty($stream['tvlogo'])){
			$stream['tvlogo'] = '';
		}

		$insert = $conn->exec("INSERT INTO `streams` 
	        (`user_id`,`server_id`,`stream_type`,`name`,`enable`,`source`,`cpu_gpu`,`job_status`,`ffmpeg_re`,`logo`)
	        VALUE
	        ('".$_SESSION['account']['id']."',
	        '".$server_id."',
	        'input',
	        '".$name."',
	        'yes',
	        '".$source."',
	        'cpu',
	        'analysing',
	        '".$ffmpeg_re."',
	        '".$stream['tvlogo']."'
	    )");

	    $stream_id = $conn->lastInsertId();

	    // add output stream
	    $insert = $conn->exec("INSERT INTO `streams` 
	        (`user_id`,`enable`,`server_id`,`stream_type`,`name`,`source_server_id`,`source_stream_id`)
	        VALUE
	        ('".$_SESSION['account']['id']."',
	        'yes',
	        '".$server_id."',
	        'output',
	        '".$name."',
	        '".$server_id."',
	        '".$stream_id."'
	    )");
    }

    // remove upload file
    shell_exec("rm -rf " . $target_file);

	// log_add("Streams has been imported.");
	status_message('success',"All streams have been imported.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_add_output()
{
	global $conn;
	
	$rand 				= md5(rand(00000,99999).time());
	
	$source_id 			= addslashes($_POST['source_id']);
	
	$query = $conn->query("SELECT `server_id`,`category_id`,`logo`,`source_type` FROM `streams` WHERE `id` = '".$source_id."' ");
	$stream = $query->fetch(PDO::FETCH_ASSOC);

	$server_id 			= $stream['server_id'];	
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$insert = $conn->exec("INSERT INTO `streams` 
        (`user_id`,`server_id`,`stream_type`,`name`,`source_server_id`,`source_stream_id`,`logo`,`category_id`,`source_type`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        'output',
        '".$name."',
        '".$server_id."',
        '".$source_id."',
        '".$stream['logo']."',
        '".$stream['category_id']."',
        '".$stream['source_type']."'
    )");

    $stream_id = $conn->lastInsertId();
    
	// log_add("Stream has been added.");
	status_message('success',"Stream has been added.");
	go("dashboard.php?c=stream&stream_id=".$stream_id);
}

function stream_delete()
{
	global $conn;

	$stream_id = get('stream_id');

	// check if stream is owned by this user
	$query = $conn->query("SELECT `id` FROM `streams` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	if($query !== FALSE) {
		// this user owns this stream

		// delete outputs
		$query = $conn->query("DELETE FROM `streams` WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."'");

		// delete input
		$query = $conn->query("DELETE FROM `streams` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."'");

		// log and wrap up
		// log_add("Stream Deleted:");
    	status_message('success',"Stream has been deleted.");    	
	}else{
		// this user DOES NOT own this server
		// log_add("Stream Delete Fail: You dont own this stream.");
    	status_message('danger',"It appears you do not own this stream. This security breach has been reported.");
	}

	go($_SERVER['HTTP_REFERER']);
}

function inspect_m3u()
{
	header('Content-Type: application/json');

	$url = $_GET["url"];

	if(isset($url)) {
		$m3ufile = file_get_contents($url);
	}else{
	  	//$m3ufile = file_get_contents('http://pastebin.com/raw/t1mBJ2Yi');
	  	$m3ufile = file_get_contents('https://raw.githubusercontent.com/onigetoc/iptv-playlists/master/general/tv/us.m3u');
	}

	//$m3ufile = str_replace('tvg-', 'tvg_', $m3ufile);
	$m3ufile = str_replace('group-title', 'tvgroup', $m3ufile);
	$m3ufile = str_replace("tvg-", "tv", $m3ufile);

	//$re = '/#(EXTINF|EXTM3U):(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
	$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
	$attributes = '/([a-zA-Z0-9\-]+?)="([^"]*)"/';

	preg_match_all($re, $m3ufile, $matches);

	$i = 1;

	$items = array();

	 foreach($matches[0] as $list) {
	 	 
	   preg_match($re, $list, $matchList);

	   $mediaURL = preg_replace("/[\n\r]/","",$matchList[3]);
	   $mediaURL = preg_replace('/\s+/', '', $mediaURL);   

	   $newdata =  array (
	    'id' => $i++,
	    'title' => $matchList[2],
	    'url' => $mediaURL
	    );
	    
	    preg_match_all($attributes, $list, $matches, PREG_SET_ORDER);
	    
	    foreach ($matches as $match) {
	       $newdata[$match[1]] = $match[2];
	    }

		 $items[] = $newdata;    
	 }

	echo json_encode($items);
}

function inspect_m3u_encoded()
{
	header('Content-Type: application/json');

	$items = '';

	$url = base64_decode($_GET["url"]);

	if(isset($url)) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$m3ufile = curl_exec($ch);
		curl_close($ch);

		if($m3ufile) {
			//$m3ufile = str_replace('tvg-', 'tvg_', $m3ufile);
			$m3ufile = str_replace('group-title', 'tvgroup', $m3ufile);
			$m3ufile = str_replace("tvg-", "tv", $m3ufile);

			//$re = '/#(EXTINF|EXTM3U):(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
			$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
			$attributes = '/([a-zA-Z0-9\-]+?)="([^"]*)"/';

			preg_match_all($re, $m3ufile, $matches);

			$i = 1;

			$items = array();

			foreach($matches[0] as $list) {
			 	 
			   	preg_match($re, $list, $matchList);

			   	$mediaURL = preg_replace("/[\n\r]/","",$matchList[3]);
			   	$mediaURL = preg_replace('/\s+/', '', $mediaURL);   

			   	$newdata =  array (
			    	'id' => $i++,
					'title' => $matchList[2],
			    	'url' => $mediaURL
			    );
			    
			    preg_match_all($attributes, $list, $matches, PREG_SET_ORDER);
			    
			    foreach ($matches as $match) {
			    	$newdata[$match[1]] = $match[2];
			    }

				$items[] = $newdata;    
			}
		}else{
			$items['status'] = 'invalid file or 404';
		}
	}else{
		$items['status'] = 'url is missing'; 
	}

	json_output($items);
}

function inspect_remote_playlist()
{
	global $conn;

	header('Content-Type: application/json');

	$items = '';

	$playlist_id = $_GET["id"];

	$query = $conn->query("SELECT * FROM `remote_playlists` WHERE `id` = '".$playlist_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	if($query !== FALSE) {
		$playlist = $query->fetch(PDO::FETCH_ASSOC);
	}

	if(isset($playlist['url'])) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$playlist['url']);
		$m3ufile = curl_exec($ch);
		curl_close($ch);

		if($m3ufile) {
			//$m3ufile = str_replace('tvg-', 'tvg_', $m3ufile);
			$m3ufile = str_replace('group-title', 'tvgroup', $m3ufile);
			$m3ufile = str_replace("tvg-", "tv", $m3ufile);

			//$re = '/#(EXTINF|EXTM3U):(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
			$re = '/#EXTINF:(.+?)[,]\s?(.+?)[\r\n]+?((?:https?|rtmp):\/\/(?:\S*?\.\S*?)(?:[\s)\[\]{};"\'<]|\.\s|$))/';
			$attributes = '/([a-zA-Z0-9\-]+?)="([^"]*)"/';

			preg_match_all($re, $m3ufile, $matches);

			$i = 1;

			$items = array();

			foreach($matches[0] as $list) {
			 	 
			   	preg_match($re, $list, $matchList);

			   	$mediaURL = preg_replace("/[\n\r]/","",$matchList[3]);
			   	$mediaURL = preg_replace('/\s+/', '', $mediaURL);   

			   	$newdata =  array (
			    	'id' => $i++,
					'title' => $matchList[2],
			    	'url' => $mediaURL
			    );
			    
			    preg_match_all($attributes, $list, $matches, PREG_SET_ORDER);
			    
			    foreach ($matches as $match) {
			    	$newdata[$match[1]] = $match[2];
			    }

				$items[] = $newdata;    
			}
		}else{
			$items['status'] = 'invalid file or 404';
		}
	}else{
		$items['status'] = 'url is missing'; 
	}

	json_output($items);
}

function analyse_stream()
{
	header("Content-Type:application/json; charset=utf-8");

	$url = trim($_GET['url']);
	$url = str_replace(' ', '', $url);

	if(empty($url)) {
		$data[0]['status'] 						= 'missing url';
	}else{
		$data[0]['url']							= $url;
		$data[0]['url_bits']					= parse_url($url);

		// add host > ip to firewall
		$data[0]['url_bits']['ip_address'] 		= gethostbyname($data[0]['url_bits']['host']);
		$data[0]['firewall_cmd']				= "sudo csf -a " . $data[0]['url_bits']['ip_address'];
		// $firewall 							= exec("/usr/bin/sudo -u root -s /usr/sbin/csf -a " . $data['url_bits']['ip_address']);
		// $data[0]['firewall_reply']			= $firewall;

		// test the stream
		$data[0]['results'] 					= shell_exec("/etc/ffmpeg/ffprobe -v quiet -print_format json -show_format -show_streams '".$url."'");
		$data[0]['results'] 					= json_decode($data[0]['results'], true);

		if(isset($data[0]['results']['streams'])) {
			$data[0]['status'] = 'online';

			// lets grab a screenshot
			$random_img = md5($url);
			$data[0]['screenshot_path'] = "/home2/slipstream/public_html/hub/screenshots/".$random_img.".png";
			$data[0]['screenshot_url'] = "http://".$global_settings['cms_access_url']."/screenshots/".$random_img.".png";
			$screenshot = shell_exec("/etc/ffmpeg/ffmpeg -y -i '".$url."' -f image2 -vframes 1 /home2/slipstream/public_html/hub/screenshots/".$random_img.".png");
			
			$count = 1;
			foreach($data[0]['results']['streams'] as $stream) {
				if($stream['codec_type'] == 'video') {
					$data[0]['stream_data'][0] = $stream;
				}
			}

			foreach($data[0]['results']['streams'] as $stream) {
				if($stream['codec_type'] == 'audio') {
					$data[0]['stream_data'][$count] = $stream;
					$count++;
				}
			}
		}elseif(!isset($data[0]['results']['streams'])){
			$data[0]['status'] = 'offline';
		}else{
			$data[0]['status'] = 'unknown';
		}
	}

	json_output($data);
}

function cdn_stream_start()
{
	global $conn;

	$server_id = get('server_id');
	$stream_id = get('stream_id');

	$uuid = md5($server_id.$stream_id);

	// add to db
	$insert = $conn->exec("INSERT INTO `cdn_streams_servers` 
        (`id`,`user_id`,`server_id`,`stream_id`)
        VALUE
        (
        '".$uuid."',
        '".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$stream_id."'
    )");

    // log_add("Stream has been added.");
    status_message('success',"Stream has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function cdn_stream_stop()
{
	global $conn;

	$stream_id = get('stream_id');
	$server_id = get('server_id');

	// get the pid to kill
	$query = $conn->query("SELECT * FROM `cdn_streams_servers` WHERE `stream_id` = '".$stream_id."' AND `server_id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$stream = $query->fetchAll(PDO::FETCH_ASSOC);

	// set the stream to die by pid
	// example: // example: {"action":"kill_pid","command":"kill -9 12748"}
	$job['action'] = 'kill_pid';
	$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

	// add the job
	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$server_id."','".json_encode($job)."')");

	$update = $conn->exec("DELETE FROM `cdn_streams_servers` WHERE `stream_id` = '".$stream_id."' AND `server_id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Streaming has been stopped.");
    status_message('success',"Stream has been stopped.");
	go($_SERVER['HTTP_REFERER']);
}

function acl_rule_add()
{
	global $conn;

	$server_id 		= post( 'server_id' );
	$ip_address 	= post( 'ip_address' );
	$comment 		= addslashes( post( 'comment' ) );

	// add to db
	$insert = $conn->exec("INSERT INTO `streams_acl_rules` 
        (`user_id`,`server_id`,`ip_address`,`comment`)
        VALUE
        (
        '".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$ip_address."',
        '".$comment."'
    )");

    // log_add( "Firewall rule has been added." );
    status_message( 'success' , "Firewall rule has been added." );
	go( $_SERVER['HTTP_REFERER'] );
}

function acl_rule_delete()
{
	global $conn;

	$rule_id = get('rule_id');

	$update = $conn->exec("DELETE FROM `streams_acl_rules` WHERE `id` = '".$rule_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Firewall rule has been deleted.");
    status_message('success',"Firewall rule has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_enable_format()
{
	global $conn, $site;

	$stream_id 			= get('stream_id');
	$stream_format 		= get('stream_format');

	$stream_raw 		= file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id);
	$stream 			= json_decode($stream_raw, true);

	// echo 'stream format: '.$stream_format.' <br>';
	// echo 'existing stream format: '.$stream[0]['output_options'][$stream_format]['enable'].' <br>';

	$stream[0]['output_options'][$stream_format]['enable'] = 'yes';
	// echo 'new stream format: '.$stream[0]['output_options'][$stream_format]['enable'].' <br>';

	$stream[0]['output_options'] = json_encode($stream[0]['output_options']);
	// echo '<pre>';
	// print_r($stream);

	$update = $conn->exec("UPDATE `streams` SET `output_options` = '".$stream[0]['output_options']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// add job to kill current stream and let new settings take effect
	/*
	$job['action'] = 'kill_pid';
	$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

	// add the job
	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$stream[0]['server_id']."','".json_encode($job)."')");
	*/
	
	// log_add("Stream format updated.");
    status_message('success',"Changes have been saved.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_disable_format()
{
	global $conn, $site;

	$stream_id 			= get('stream_id');
	$stream_format 		= get('stream_format');

	$stream_raw 		= file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id);
	$stream 			= json_decode($stream_raw, true);

	// echo 'stream format: '.$stream_format.' <br>';
	// echo 'existing stream format: '.$stream[0]['output_options'][$stream_format]['enable'].' <br>';

	$stream[0]['output_options'][$stream_format]['enable'] = 'no';
	$stream[0]['output_options'][$stream_format]['status'] = 'offline';
	// echo 'new stream format: '.$stream[0]['output_options'][$stream_format]['enable'].' <br>';

	$stream[0]['output_options'] = json_encode($stream[0]['output_options']);
	// echo '<pre>';
	// print_r($stream);

	$update = $conn->exec("UPDATE `streams` SET `output_options` = '".$stream[0]['output_options']."' WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// add job to kill current stream and let new settings take effect
	/*
	$job['action'] = 'kill_pid';
	$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

	// add the job
	$insert = $conn->exec("INSERT INTO `jobs` 
        (`server_id`,`job`)
        VALUE
        ('".$stream[0]['server_id']."','".json_encode($job)."')");

	*/

	// log_add("Stream format updated.");
    status_message('success',"Changes have been saved.");
	go($_SERVER['HTTP_REFERER']);
}

function streams_restart_all()
{
	global $conn;

	$data['action'] = 'streams_restart_all';
	$data['command'] = '';

	$headends = get_all_servers_ids();

	foreach($headends as $headend) {
		if($headend['status'] == 'online') {
			$insert = $conn->exec("INSERT INTO `jobs` 
	        (`server_id`,`job`)
	        VALUE
	        ('".$headend['id']."','".json_encode($data)."')");
		}
	}

	$update = $conn->exec("UPDATE `streams` SET `job_status` = 'restarting' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");
    
    // log_add("Restarting all streams.");
	status_message('success',"All streams will be restarted shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function streams_stop_all()
{
	global $conn;

	$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `fps` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `speed` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' WHERE `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Restarting all streams.");
	status_message('success',"All streams will stop shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function streams_start_all()
{
	global $conn;

	// set enable = 'yes' for all streams
	$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
    
    // set job_status = 'analysing' for all streams
    $update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' WHERE `user_id` = '".$_SESSION['account']['id']."' AND `enable` = 'yes' ");

    // log_add("Restarting all streams.");
	status_message('success',"All streams will start shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function export_m3u()
{
	global $conn;

	//Generate text file on the fly
	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=playlist.m3u");

	$new_line = "\n";

	// demo m3u format
	// #EXTM3U
	// #EXTINF:-1,CHANNEL NAME
	// http://link.to.stream

	print "#EXTM3U".$new_line;

	// build $streams
	$query = $conn->query("SELECT * FROM `streams` WHERE `stream_type` = 'output' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `name` ASC");
	$streams = $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($streams as $stream) {
		// get stream data for each headend
		// $query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$stream['server_id']."' ");
		// $stream['headend'] = $query->fetchAll(PDO::FETCH_ASSOC);

		print "#EXTINF:-1,".strtoupper($stream['stream_type'])." SOURCE - ".stripslashes($stream['name']).$new_line;
		print "http://".$global_settings['cms_access_url']."/streams/".$stream['server_id']."/".$stream['id'].$new_line;
	}
}

function my_account_update()
{
	global $conn;

	$firstname 				= addslashes($_POST['firstname']);
	$lastname 				= addslashes($_POST['lastname']);
	$email 					= addslashes($_POST['email']);
	$password 				= addslashes($_POST['password']);
	$password2 				= addslashes($_POST['password2']);

	$update = $conn->exec("UPDATE `users` SET `first_name` = '".$firstname."' WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `last_name` = '".$lastname."' WHERE `id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `users` SET `email` = '".$email."' WHERE `id` = '".$_SESSION['account']['id']."' ");

	status_message('success', "Your changes have been saved.");

	if(!empty($password) && !empty($password2)){
		if($password == $password2){
			$update = $conn->exec("UPDATE `users` SET `password` = '".$password."' WHERE `id` = '".$_SESSION['account']['id']."' ");
		}else{
			status_message('danger', "Passwords do not match, please try again.");
		}
	}

    go($_SERVER['HTTP_REFERER']);
}

function customer_add()
{
	global $conn;
		
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);

	$email 				= addslashes($_POST['email']);
	$email 				= trim($email);

	$username			= addslashes($_POST['username']);
	$username 			= trim($username);

	$password 			= addslashes($_POST['password']);
	$password 			= trim($password);

	$max_connections 	= addslashes($_POST['max_connections']);
	$max_connections 	= trim($max_connections);

	$expire_date 		= addslashes($_POST['expire_date']);

	$notes 				= addslashes($_POST['notes']);
	$notes 				= trim($notes);

	$live_content 		= 'on';
	$channel_content 	= 'on';
	$vod_content 		= 'on';

	$bouquets 			= $_POST['bouquets'];
	if(!empty($bouquets)){
		$bouquets 			= implode(",", $bouquets);
	}

	// check if username is already in use
	$query = $conn->query("SELECT `id` FROM `customers` WHERE `username` = '".$username."' ");
	$existing_customer = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($existing_customer['id'])){
		status_message('danger',"Username '".$username."' is not available.");
	}else{
		// $expire_bits 		= explode('-', $expire_date);
		// $expire_date		= $expire_bits[2].'/'.$expire_bits[0].'/'.$expire_bits[1];
		
		$insert = $conn->exec("INSERT INTO `customers` 
	        (`user_id`,`updated`,`first_name`,`last_name`,`email`,`username`,`password`,`max_connections`,`expire_date`,`notes`,`live_content`,`channel_content`,`vod_content`,`bouquet`)
	        VALUE
	        ('".$_SESSION['account']['id']."',
	        '".time()."',
	        '".$first_name."',
	        '".$last_name."',
	        '".$email."',
	        '".$username."',
	        '".$password."',
	        '".$max_connections."',
	        '".$expire_date."',
	        '".$notes."',
	        '".$live_content."',
	        '".$channel_content."',
	        '".$vod_content."',
	        '".$bouquets."'
	    )");

	    $customer_id = $conn->lastInsertId();
		status_message('success',"Customer account has been added.");
	}
	go($_SERVER['HTTP_REFERER']);
}

function customer_update()
{
	global $conn;
	
	$customer_id 		= addslashes($_POST['customer_id']);
	$status 			= addslashes($_POST['status']);
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);

	$email 				= addslashes($_POST['email']);
	$email 				= trim($email);

	$username			= addslashes($_POST['username']);
	$username 			= trim($username);

	$password 			= addslashes($_POST['password']);
	$password 			= trim($password);

	$max_connections 	= addslashes($_POST['max_connections']);
	$max_connections 	= trim($max_connections);

	$expire_date 		= addslashes($_POST['expire_date']);
	$notes 				= addslashes($_POST['notes']);
	$notes 				= trim($notes);

	$live_content 		= 'on';
	$channel_content 	= 'on';
	$vod_content 		= 'on';

	// check if username is already in use
	$query = $conn->query("SELECT `id` FROM `customers` WHERE `username` = '".$username."' ");
	$existing_customer = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($existing_customer['id'])){
		status_message('danger',"Username '".$username."' is not available.");
	}else{
		// $expire_bits 		= explode('-', $expire_date);
		// $expire_date		= $expire_bits[1].'/'.$expire_bits[2].'/'.$expire_bits[0];
		
		$update = $conn->exec("UPDATE `customers` SET `status` = '".$status."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `first_name` = '".$first_name."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `last_name` = '".$last_name."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `email` = '".$email."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `username` = '".$username."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `password` = '".$password."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `expire_date` = '".$expire_date."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `max_connections` = '".$max_connections."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `notes` = '".$notes."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		$update = $conn->exec("UPDATE `customers` SET `live_content` = '".$live_content."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `channel_content` = '".$channel_content."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		$update = $conn->exec("UPDATE `customers` SET `vod_content` = '".$vod_content."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

		status_message('success',"Customer account has been updated.");
	}
	go($_SERVER['HTTP_REFERER']);
}

function customer_delete()
{
	global $conn;

	$customer_id = get('customer_id');

	$update = $conn->exec("DELETE FROM `customers` WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Customer account has been deleted.");
    status_message('success',"Customer account has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function transcoding_profile_add()
{
	global $conn;

	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$data 				= '{"user_agent":"","ffmpeg_re":"no","cpu_gpu":"copy","video_codec":"libx264","cpu_video_codec":"libx264","gpu":"0","gpu_video_codec":"h264_nvenc","surfaces":"10","framerate":"0","preset":"0","profile":"baseline","screen_resolution":"copy","bitrate":"5120","audio_codec":"copy","audio_bitrate":"128","audio_sample_rate":"44100","ac":"2","fingerprint":"disable","fingerprint_type":"static_text","fingerprint_text":"","fingerprint_fontsize":"","fingerprint_color":"white","fingerprint_location":"top_left"}';

	$insert = $conn->exec("INSERT INTO `transcoding_profiles` 
        (`user_id`,`name`,`data`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."',
        '".$data."'
    )");

    $profile_id = $conn->lastInsertId();
    
	status_message('success',"Transcoding Profile has been created.");
	go('dashboard.php?c=transcoding_profile&profile_id='.$profile_id);
}

function transcoding_profile_update()
{
	global $conn;

	$profile_id 		= $_POST['profile_id'];
	$name 				= $_POST['name'];
	$name 				= addslashes($name);
	$name 				= trim($name);

	$data 				= $_POST['data'];

	if($data['cpu_gpu'] == 'cpu') {
		$data['video_codec'] 		= $data['cpu_video_codec'];
	}
	if($data['cpu_gpu'] == 'gpu') {
		$data['video_codec'] 		= $data['gpu_video_codec'];
	}
	if($data['framerate'] == '') {
		$data['framerate'] 			= $data['0'];
	}
	$data 			= json_encode($data);

	debug($_POST);
	// die();

	$update = $conn->exec("UPDATE `transcoding_profiles` SET `name` = '".$name."'	WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `transcoding_profiles` SET `data` = '".$data."'	WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Transcoding Profile has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function transcoding_profile_delete()
{
	global $conn;

	$profile_id = get('profile_id');

	$update = $conn->exec("UPDATE `streams` SET `transcoding_profile_id` = '0'	WHERE `transcoding_profile_id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("DELETE FROM `transcoding_profiles` WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Customer account has been deleted.");
    status_message('success',"Transcoding Profile has been deleted. Please restart streams that were using this profile for changes to take effect");
	go($_SERVER['HTTP_REFERER']);
}

function restart_transcoding_profile_streams()
{
	global $conn, $site;

	$profile_id 		= $_GET['profile_id'];

	// get the stream data
	$query 				= $conn->query("SELECT * FROM `transcoding_profiles` WHERE `id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$profile 			= $query->fetch(PDO::FETCH_ASSOC);
	$profile_data		= json_decode($profile['data'], true);

	$query 				= $conn->query("SELECT `id` FROM `streams` WHERE `transcoding_profile_id` = '".$profile_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$stream_ids 		= $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($stream_ids as $stream_id)
		{
			// get stream data
			// debug($stream_id);
			//die();
			$stream_raw 				= file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id['id']);
			$stream 					= json_decode($stream_raw, true);

			// build the kill command
			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

			// add the job to kill the stream ready for restart
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$stream[0]['server_id']."','".json_encode($job)."')");

			// update settings for this stream
			$update = $conn->exec("UPDATE `streams` SET `user_agent` = '".$profile_data['user_agent']."' 								WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `ffmpeg_re` = '".$profile_data['ffmpeg_re']."' 									WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `cpu_gpu` = '".$profile_data['cpu_gpu']."' 										WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `video_codec` = '".$profile_data['video_codec']."' 								WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `gpu` = '".$profile_data['gpu']."' 												WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `surfaces` = '".$profile_data['surfaces']."' 									WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `framerate` = '".$profile_data['framerate']."' 									WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `preset` = '".$profile_data['preset']."' 										WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `profile` = '".$profile_data['profile']."' 										WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `screen_resolution` = '".$profile_data['screen_resolution']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `bitrate` = '".$profile_data['bitrate']."' 										WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `audio_codec` = '".$profile_data['audio_codec']."' 								WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `audio_bitrate` = '".$profile_data['audio_bitrate']."' 							WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `audio_sample_rate` = '".$profile_data['audio_sample_rate']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `ac` = '".$profile_data['ac']."' 												WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint` = '".$profile_data['fingerprint']."' 								WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_type` = '".$profile_data['fingerprint_type']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_text` = '".$profile_data['fingerprint_text']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_fontsize` = '".$profile_data['fingerprint_fontsize']."' 			WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_color` = '".$profile_data['fingerprint_color']."' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fingerprint_location` = '".$profile_data['fingerprint_location']."' 			WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			// set some stream settings to default values
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id['id']."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			/*
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			*/
		}

	status_message('success',"Streams will restart shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_category_add()
{
	global $conn;
	
	$name 				= addslashes($_POST['name']);

	$insert = $conn->exec("INSERT INTO `stream_categories` 
        (`user_id`,`name`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."'
    )");

    $stream_id = $conn->lastInsertId();
    
	// log_add("Stream Category has been added.");
	status_message('success',"Stream Category has been added.");
	go("dashboard.php?c=stream_categories");
}

function stream_category_delete()
{
	global $conn;

	$category_id = get('category_id');

	// remove the category_id from streams
	$query = $conn->query("UPDATE `streams` SET `category_id` = '0' WHERE `category_id` = '".$category_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// delete primary record
	$query = $conn->query("DELETE FROM `stream_categories` WHERE `id` = '".$category_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// log and wrap up
	// log_add("Stream Category Deleted:");
	status_message('success',"Stream Category has been deleted.");
	// return user to previous page
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_add()
{
	global $conn;
	
	$server_id			= addslashes($_POST['server_id']);
	if(empty($_POST['server_id']) || $_POST['server_id'] == 0){

		status_message('danger',"You must select a server.");
		go($_SERVER['HTTP_REFERER']);
	}
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	// try the open movie db for meta data
	$url = 'http://www.omdbapi.com/?apikey=63298a10&t='.urlencode($name);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$metadata = curl_exec($curl);
	curl_close($curl);

	$metadata = json_decode($metadata, true);

	if($metadata['Response'] == False){
		$year 			= '';
		$cover_photo	= '';
		$description	= '';
		$genre 			= '';
		$runtime 		= '';
		$language 		= '';
	}elseif($metadata['Response'] == True){
		$year 			= addslashes($metadata['Year']);
		$cover_photo	= addslashes($metadata['Poster']);
		$description	= addslashes($metadata['Plot']);
		$genre 			= addslashes($metadata['Genre']);
		$runtime 		= addslashes($metadata['Runtime']);
		$language 		= addslashes($metadata['Language']);
	}

	// add input stream
	$insert = $conn->exec("INSERT INTO `tv_series` 
        (`user_id`,`server_id`,`name`,`cover_photo`,`description`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$name."',
        '".$cover_photo."',
        '".$description."'
    )");

    $series_id = $conn->lastInsertId();
    
	// log_add("TV Series has been added.");
	status_message('success',"TV Series has been added.");
	go('dashboard.php?c=tv_series_edit&id='.$series_id);
}

function tv_series_update()
{
	global $conn;

	$series_id 						= addslashes($_POST['series_id']);

	// $data['server_id'] 				= addslashes($_POST['server_id']);

	$data['name'] 					= addslashes($_POST['name']);
	$data['name']					= trim($data['name']);

	$data['description'] 			= addslashes($_POST['description']);
	$data['description']			= trim($data['description']);

	$data['cover_photo'] 			= addslashes($_POST['cover_photo']);
	$data['cover_photo']			= trim($data['cover_photo']);
	
	$update = $conn->exec("UPDATE `tv_series` SET `name` = '".$data['name']."' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `tv_series` SET `description` = '".$data['description']."' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `tv_series` SET `cover_photo` = '".$data['cover_photo']."' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series changes have been saved.");
    status_message('success',"TV Series changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function tv_series_delete()
{
	global $conn;

	$series_id = get('series_id');

	$delete = $conn->exec("DELETE FROM `tv_series_files` WHERE `tv_series_id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$delete = $conn->exec("DELETE FROM `tv_series` WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series has been deleted.");
    status_message('success',"TV Series has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_episode_add()
{
	global $conn;
	
	$server_id			= addslashes($_POST['server_id']);

	$series_id			= addslashes($_POST['series_id']);
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$file_location 		= addslashes($_POST['file_location']);
	$file_location 		= trim($file_location);

	// get next number in the order
	$query = $conn->query("SELECT `order` FROM `tv_series_files` WHERE `tv_series_id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `order` DESC LIMIT 1");
	$bits = $query->fetch(PDO::FETCH_ASSOC);
	$next_order = ($bits['order'] + 1);
		
	// add input stream
	$insert = $conn->exec("INSERT INTO `tv_series_files` 
        (`user_id`,`server_id`,`tv_series_id`,`name`,`file_location`,`order`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$series_id."',
        '".$name."',
        '".$file_location."',
        '".$next_order."'
    )");

    $series_id = $conn->lastInsertId();
    
	// log_add("Episode has been added.");
	status_message('success',"Episode has been added.");
    go($_SERVER['HTTP_REFERER']);
}

function tv_series_update_order()
{
	global $conn;

	foreach($_POST['order'] as $key => $value) {
		$update = $conn->exec("UPDATE `tv_series_files` SET `order` = '".addslashes($value)."' WHERE `id` = '".$key."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	foreach($_POST['name'] as $key => $value) {
		$update = $conn->exec("UPDATE `tv_series_files` SET `name` = '".addslashes($value)."' WHERE `id` = '".$key."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	// log_add("TV Series has been updated.");
    status_message('success',"TV Series has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_start()
{
	global $conn;

	$series_id = get('series_id');

	$delete = $conn->exec("UPDATE `tv_series_files` SET `enable` = 'yes' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series will start streaming shortly.");
    status_message('success',"TV Series will start streaming shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function tv_series_stop()
{
	global $conn;

	$series_id = get('series_id');

	$delete = $conn->exec("UPDATE `tv_series_files` SET `enable` = 'no' WHERE `id` = '".$series_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("TV Series will stop streaming shortly.");
    status_message('success',"TV Series will stop streaming shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function vod_add()
{
	global $conn;
	
	$server_id			= addslashes($_POST['server_id']);
	if(empty($_POST['server_id']) || $_POST['server_id'] == 0){

		status_message('danger',"You must select a server.");
		go($_SERVER['HTTP_REFERER']);
	}
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	// try the open movie db for meta data
	$url = 'http://www.omdbapi.com/?apikey=63298a10&t='.urlencode($name);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$metadata = curl_exec($curl);
	curl_close($curl);

	$metadata = json_decode($metadata, true);

	if($metadata['Response'] == False){
		$year 			= '';
		$cover_photo	= '';
		$description	= '';
		$genre 			= '';
		$runtime 		= '';
		$language 		= '';
	}elseif($metadata['Response'] == True){
		$year 			= addslashes($metadata['Year']);
		$cover_photo	= addslashes($metadata['Poster']);
		$description	= addslashes($metadata['Plot']);
		$genre 			= addslashes($metadata['Genre']);
		$runtime 		= addslashes($metadata['Runtime']);
		$language 		= addslashes($metadata['Language']);
	}

	// add input stream
	$insert = $conn->exec("INSERT INTO `vod` 
        (`user_id`,`server_id`,`name`,`year`,`cover_photo`,`description`,`genre`,`runtime`,`language`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$name."',
        '".$year."',
        '".$cover_photo."',
        '".$description."',
        '".$genre."',
        '".$runtime."',
        '".$language."'
    )");

    $vod_id = $conn->lastInsertId();
    
	// log_add("Video on Demand has been added.");
	status_message('success',"Video on Demand has been added.");
	go('dashboard.php?c=vod_edit&id='.$vod_id);
}

function vod_update()
{
	global $conn;

	$vod_id 						= addslashes($_POST['vod_id']);

	$data['name'] 					= addslashes($_POST['name']);
	$data['name']					= trim($data['name']);

	$data['description'] 			= addslashes($_POST['description']);
	$data['description']			= trim($data['description']);

	$data['cover_photo'] 			= addslashes($_POST['cover_photo']);
	$data['cover_photo']			= trim($data['cover_photo']);

	$data['year'] 					= addslashes($_POST['year']);
	$data['year']					= trim($data['year']);

	$data['genre'] 					= addslashes($_POST['genre']);
	$data['genre']					= trim($data['genre']);

	$data['runtime'] 				= addslashes($_POST['runtime']);
	$data['runtime']				= trim($data['runtime']);

	$data['language'] 				= addslashes($_POST['language']);
	$data['language']				= trim($data['language']);

	$data['file_location'] 			= addslashes($_POST['file_location']);
	$data['file_location']			= trim($data['file_location']);
	
	$update = $conn->exec("UPDATE `vod` SET `name` = '".$data['name']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `description` = '".$data['description']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `cover_photo` = '".$data['cover_photo']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `year` = '".$data['year']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `genre` = '".$data['genre']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `runtime` = '".$data['runtime']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `language` = '".$data['language']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `vod` SET `file_location` = '".$data['file_location']."' WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

    // log_add("Video on Demand changes have been saved.");
    status_message('success',"Video on Demand changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function vod_delete()
{
	global $conn;

	$vod_id = get('vod_id');

	$delete = $conn->exec("DELETE FROM `vod` WHERE `id` = '".$vod_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Video on Demand has been deleted.");
    status_message('success',"Video on Demand has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_add()
{
	global $conn;
	
	$server_id			= addslashes($_POST['server_id']);
	if(empty($_POST['server_id']) || $_POST['server_id'] == 0){

		status_message('danger',"You must select a server.");
		go($_SERVER['HTTP_REFERER']);
	}
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	// try the open movie db for meta data
	$url = 'http://www.omdbapi.com/?apikey=63298a10&t='.urlencode($name);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$metadata = curl_exec($curl);
	curl_close($curl);

	$metadata = json_decode($metadata, true);

	if($metadata['Response'] == False){
		$year 			= '';
		$cover_photo	= '';
		$description	= '';
		$genre 			= '';
		$runtime 		= '';
		$language 		= '';
	}elseif($metadata['Response'] == True){
		$year 			= addslashes($metadata['Year']);
		$cover_photo	= addslashes($metadata['Poster']);
		$description	= addslashes($metadata['Plot']);
		$genre 			= addslashes($metadata['Genre']);
		$runtime 		= addslashes($metadata['Runtime']);
		$language 		= addslashes($metadata['Language']);
	}

	// add 
	$insert = $conn->exec("INSERT INTO `channels` 
        (`user_id`,`server_id`,`name`,`cover_photo`,`description`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$name."',
        '".$cover_photo."',
        '".$description."'
    )");

    $channel_id = $conn->lastInsertId();
    
	// log_add("TV Series has been added.");
	status_message('success',"Channel has been added.");
	go('dashboard.php?c=channel_edit&id='.$channel_id);
}

function channel_update()
{
	global $conn;

	$id 							= addslashes($_POST['id']);

	// $data['server_id'] 			= addslashes($_POST['server_id']);

	$data['name'] 					= addslashes($_POST['name']);
	$data['name']					= trim($data['name']);

	$data['description'] 			= addslashes($_POST['description']);
	$data['description']			= trim($data['description']);

	$data['cover_photo'] 			= addslashes($_POST['cover_photo']);
	$data['cover_photo']			= trim($data['cover_photo']);
	
	$update = $conn->exec("UPDATE `channels` SET `name` = '".$data['name']."' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `description` = '".$data['description']."' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `cover_photo` = '".$data['cover_photo']."' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel changes have been saved.");
    status_message('success',"Channel changes have been saved.");
    go($_SERVER['HTTP_REFERER']);
}

function channel_delete()
{
	global $conn;

	$id = get('id');

	$delete = $conn->exec("DELETE FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$delete = $conn->exec("DELETE FROM `channels` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel has been deleted.");
    status_message('success',"Channel has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_episode_add()
{
	global $conn;

	$server_id			= addslashes($_POST['server_id']);

	$id					= addslashes($_POST['id']);
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$file_location 		= addslashes($_POST['file_location']);
	$file_location 		= trim($file_location);

	// get next number in the order
	$query = $conn->query("SELECT `order` FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `order` DESC LIMIT 1");
	$bits = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($bits['order'])) {
		$next_order = ($bits['order'] + 1);
	}else{
		$next_order = 0;
	}
		
	// add input stream
	$insert = $conn->exec("INSERT IGNORE INTO `channels_files` 
        (`user_id`,`server_id`,`channel_id`,`name`,`file_location`,`order`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$id."',
        '".$name."',
        '".$file_location."',
        '".$next_order."'
    )");
    
	// log_add("Episode has been added.");
	status_message('success',"Episode has been added.");
    go($_SERVER['HTTP_REFERER']);
}

function channel_episode_delete()
{
	global $conn;

	$id = get('id');

	$delete = $conn->exec("DELETE FROM `channels_files` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel Episode has been deleted.");
    status_message('success',"Channel Episode has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_episode_delete_all()
{
	global $conn;

	$id = get('id');

	$delete = $conn->exec("DELETE FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    status_message('success',"All Channel Episodes have been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_episode_scan_folder()
{
	global $conn;

	$server_id			= addslashes($_POST['server_id']);

	$id					= addslashes($_POST['id']);
	
	$folder_path 		= $_POST['folder_path'];
	$folder_path 		= trim($folder_path);

	// sanity checks
	$folder_path 		= str_replace(array('"',"'",'\\','!','@','#','$','%','^','&','*','(',')','=','+',';',':','|','[',']','{','}','`','~',' '), '', $folder_path);

	// more sanity checks
	if(strpos($folder_path, '/etc/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /etc/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}
	if(strpos($folder_path, '/root/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /root/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}
	if(strpos($folder_path, '/tmp/') !== false) {
	    status_message('danger',"Security Alert: Dont try to scan the /tmp/ folder");
    	go($_SERVER['HTTP_REFERER']);
	}

	// lets scan the folder
	$sql = "
        SELECT `id`,`wan_ip_address`,`http_stream_port` 
        FROM `headend_servers` 
        WHERE `id` = '".$server_id."' 
        AND `user_id` = '".$_SESSION['account']['id']."' 
    ";
    $query      = $conn->query($sql);
    $headend    = $query->fetch(PDO::FETCH_ASSOC);

    $folder_scan = file_get_contents('http://'.$headend['wan_ip_address'].':'.$headend['http_stream_port'].'/scan_folder_files.php?passcode=1372&folder_path='.$folder_path);

    $folder_scan = json_decode($folder_scan, true);

    if(isset($folder_scan[0])) {
    	foreach($folder_scan as $key => $value){

    		$name 				= $key;
			$file_location 		= addslashes($value);

			// get next number in the order
			$query = $conn->query("SELECT `order` FROM `channels_files` WHERE `channel_id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ORDER BY `order` DESC LIMIT 1");
			$bits = $query->fetch(PDO::FETCH_ASSOC);
			if(isset($bits['order'])) {
				$next_order = ($bits['order'] + 1);
			}else{
				$next_order = 0;
			}
				
			// add input stream
			$insert = $conn->exec("INSERT IGNORE INTO `channels_files` 
		        (`user_id`,`server_id`,`channel_id`,`name`,`file_location`,`order`)
		        VALUE
		        ('".$_SESSION['account']['id']."',
		        '".$server_id."',
		        '".$id."',
		        '".$name."',
		        '".$file_location."',
		        '".$next_order."'
		    )");
		}

		// log_add("Folder scan complete and media files added.");
		status_message('success',"Folder scan complete and media files added.");
	}else{
		// log_add("Folder scan complete but no media files were found.");
		status_message('warning',"Folder scan complete but no media files were found.");
	}
	
    go($_SERVER['HTTP_REFERER']);
}

function channel_update_order()
{
	global $conn;

	foreach($_POST['order'] as $key => $value) {
		$update = $conn->exec("UPDATE `channels_files` SET `order` = '".addslashes($value)."' WHERE `id` = '".$key."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	foreach($_POST['name'] as $key => $value) {
		$update = $conn->exec("UPDATE `channels_files` SET `name` = '".addslashes($value)."' WHERE `id` = '".$key."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	foreach($_POST['file_location'] as $key => $value) {
		$update = $conn->exec("UPDATE `channels_files` SET `file_location` = '".addslashes($value)."' WHERE `id` = '".$key."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	}

	// log_add("Channel has been updated.");
    status_message('success',"Channel has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_start()
{
	global $conn;

	$id = get('id');

	$update = $conn->exec("UPDATE `channels` SET `enable` = 'yes' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	$update = $conn->exec("UPDATE `channels` SET `status` = 'starting' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel will start streaming shortly.");
    status_message('success',"Channel will start streaming shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function channel_stop()
{
	global $conn;

	$id = get('id');

	$update = $conn->exec("UPDATE `channels` SET `enable` = 'no' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `status` = 'offline' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("Channel will stop streaming shortly.");
    status_message('success',"Channel will stop streaming shortly.");
	go($_SERVER['HTTP_REFERER']);
}

function dns_add()
{
	global $conn;
		
	$server_id 			= addslashes($_POST['server_id']);
	$query 				= $conn->query("SELECT `wan_ip_address` FROM `headend_servers` WHERE `id` = '".$server_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$server 			= $query->fetch(PDO::FETCH_ASSOC);

	$hostname 			= addslashes($_POST['hostname']);
	$hostname 			= trim($hostname);
	$hostname 			= str_replace(array('.', ' ', '_'), '-', $hostname);

	$domain 			= addslashes($_POST['domain']);

	// check if hostname already in use
	$query = $conn->query("SELECT `id` FROM `addon_dns` WHERE `hostname` = '".$hostname."' AND `domain` = '".$domain."' ");
	$existing_record = $query->fetch(PDO::FETCH_ASSOC);
	if(isset($existing_record['id'])){
		status_message('danger',"DNS Host is already taken.");
		go($_SERVER['HTTP_REFERER']);
		die();
	}

	$cloudflare 		= cf_add_host($hostname, $domain, $server['wan_ip_address']);
	
	debug($_POST);
	debug($cloudflare);
	$insert = $conn->exec("INSERT INTO `addon_dns` 
        (`user_id`,`server_id`,`hostname`,`domain`,`cf_domain_id`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$hostname."',
        '".$domain."',
        '".$cloudflare['domain_id']."'
    )");

    $record_id = $conn->lastInsertId();

	// log_add("DNS Host has been added.");
	status_message('success',"DNS Host has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function dns_update()
{
	global $conn;
	
	$customer_id 		= addslashes($_POST['customer_id']);
	$status 			= addslashes($_POST['status']);
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);
	$email 				= addslashes($_POST['email']);
	$username			= addslashes($_POST['username']);
	$password 			= addslashes($_POST['password']);
	$max_connections 	= addslashes($_POST['max_connections']);
	$notes 				= addslashes($_POST['notes']);
	
	$update = $conn->exec("UPDATE `customers` SET `status` = '".$status."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `first_name` = '".$first_name."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `last_name` = '".$last_name."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `email` = '".$email."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `username` = '".$username."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `password` = '".$password."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `max_connections` = '".$max_connections."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `notes` = '".$notes."' WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// log_add("Customer has been updated.");
	status_message('success',"Customer account has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function dns_delete()
{
	global $conn;

	$id = get('id');

	$update = $conn->exec("DELETE FROM `addon_dns` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    // log_add("DNS record has been deleted.");
    status_message('success',"DNS record has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function stream_multi_options()
{
	global $conn, $site;

	$action = post('multi_options_action');

	$stream_ids = $_POST['stream_ids'];

	if($action == 'start'){
		foreach($stream_ids as $stream_id)
		{
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams will start shortly.");
	}
	if($action == 'stop'){
		foreach($stream_ids as $stream_id)
		{
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'none'	 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'no' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'none' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams will stop shortly.");
	}
	if($action == 'restart'){
		foreach($stream_ids as $stream_id)
		{
			$stream_raw 				= file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id);
			$stream 					= json_decode($stream_raw, true);

			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

			// add the job
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$stream[0]['server_id']."','".json_encode($job)."')");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 		WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams will restart shortly.");
	}
	if($action == 'delete'){
		foreach($stream_ids as $stream_id)
		{
			$stream_raw 				= file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id);
			$stream 					= json_decode($stream_raw, true);

			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

			// add the job
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$stream[0]['server_id']."','".json_encode($job)."')");

			$update = $conn->exec("DELETE FROM `streams` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("DELETE FROM `streams` WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams have been deleted.");
	}
	if($action == 'change_server'){

		$server_id = post('server');

		foreach($stream_ids as $stream_id)
		{
			$stream_raw 				= file_get_contents($site['url']."actions.php?a=ajax_stream&stream_id=".$stream_id);
			$stream 					= json_decode($stream_raw, true);

			$job['action'] = 'kill_pid';
			$job['command'] = 'kill -9 '.$stream[0]['running_pid'];

			// add the job
			$insert = $conn->exec("INSERT INTO `jobs` 
		        (`server_id`,`job`)
		        VALUE
		        ('".$stream[0]['server_id']."','".json_encode($job)."')");

			$update = $conn->exec("UPDATE `streams` SET `server_id` = '".$server_id."' 		WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 					WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 							WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 						WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 				WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 			WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

			$update = $conn->exec("UPDATE `streams` SET `server_id` = '".$server_id."' 			WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `source_server_id` = '".$server_id."' 	WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `enable` = 'yes' 						WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `status` = 'offline' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `fps` = '' 								WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `speed` = '' 							WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `stream_uptime` = '' 					WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `pending_changes` = 'no' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
			$update = $conn->exec("UPDATE `streams` SET `job_status` = 'analysing' 				WHERE `source_stream_id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
		}

		status_message('success',"Selected streams will migrate shortly.");
	}

	go($_SERVER['HTTP_REFERER']);
}

function channels_stop_all()
{
	global $conn;

	$update = $conn->exec("UPDATE `channels` SET `enable` = 'no' 		WHERE `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `channels` SET `uptime` = ''			WHERE `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"All channels will stop shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function channels_start_all()
{
	global $conn;

	// set enable = 'yes' for all streams
	$update = $conn->exec("UPDATE `channels` SET `enable` = 'yes' WHERE `user_id` = '".$_SESSION['account']['id']."' ");
    
    // $update = $conn->exec("UPDATE `channels` SET `status` = 'starting' WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"All channels will start shortly.");
    go($_SERVER['HTTP_REFERER']);
}

function bulk_update_sources()
{
	global $conn;

	$old_source_url = get('old_source_url');
	$new_source_url = get('new_source_url');

	$update = $conn->exec("UPDATE `streams` SET `source` = REPLACE(`source`, '".$old_source_url."', '".$new_source_url."') WHERE `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Source URLs have been updated.");
    go($_SERVER['HTTP_REFERER']);
}

function remote_playlist_add()
{
	global $conn;

	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$url 				= addslashes($_POST['url']);
	$url 				= trim($url);

	$insert = $conn->exec("INSERT INTO `remote_playlists` 
        (`user_id`,`name`,`url`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."',
        '".$url."'
    )");

    $record_id = $conn->lastInsertId();

	status_message('success',"Remote Playlist has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function remote_playlist_update()
{
	global $conn;
	
	$customer_id 		= addslashes($_POST['customer_id']);
	$status 			= addslashes($_POST['status']);
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);
	$email 				= addslashes($_POST['email']);
	$username			= addslashes($_POST['username']);
	$password 			= addslashes($_POST['password']);
	$max_connections 	= addslashes($_POST['max_connections']);
	$notes 				= addslashes($_POST['notes']);
	
	$update = $conn->exec("UPDATE `customers` SET `status` = '".$status."' 							WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `first_name` = '".$first_name."'					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `last_name` = '".$last_name."' 					WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `email` = '".$email."' 							WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `username` = '".$username."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `password` = '".$password."' 						WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `max_connections` = '".$max_connections."' 		WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `customers` SET `notes` = '".$notes."' 							WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// log_add("Customer has been updated.");
	status_message('success',"Customer account has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function remote_playlist_delete()
{
	global $conn;

	$id = get('id');

	$update = $conn->exec("DELETE FROM `remote_playlists` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    status_message('success',"Remote Playlist has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function roku_device_add()
{
	global $conn;

	$server_id 			= addslashes($_POST['server']);

	$device_brand 		= addslashes($_POST['device_brand']);

	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);

	$ip_address 		= addslashes($_POST['ip_address']);
	$ip_address 		= trim($ip_address);

	$time 				= time();

	$insert = $conn->exec("INSERT INTO `roku_devices` 
        (`updated`,`user_id`,`server_id`,`device_brand`,`name`,`ip_address`,`status`)
        VALUE
        ('".$time."',
        '".$_SESSION['account']['id']."',
        '".$server_id."',
        '".$device_brand."',
        '".$name."',
        '".$ip_address."',
        'pending_adoption'
    )");

    $record_id = $conn->lastInsertId();

	status_message('success',"Roku Device has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function roku_device_update()
{
	global $conn;
	
	$device_id 			= addslashes($_POST['device_id']);
	$server_id 			= addslashes($_POST['server_id']);
	$device_brand 		= addslashes($_POST['device_brand']);
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);
	$ip_address 		= addslashes($_POST['ip_address']);
	$channel			= addslashes($_POST['channel']);

	
	$update = $conn->exec("UPDATE `roku_devices` SET `server_id` = '".$server_id."' 			WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `device_brand` = '".$device_id."' 			WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `name` = '".$name."' 						WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `ip_address` = '".$ip_address."' 			WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `roku_devices` SET `channel` = '".$channel."' 				WHERE `id` = '".$device_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Roku Device has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function roku_device_delete()
{
	global $conn;

	$id = get('id');

	$update = $conn->exec("DELETE FROM `roku_devices` WHERE `id` = '".$id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    status_message('success',"Roku Device has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function playlist_checker()
{
	global $conn;

	$url 				= addslashes($_POST['playlist_url']);
	$url 				= trim($url);

	$url 				= base64_encode($url);

	status_message('success',"Playlist will be checked in real-time.");
	go("dashboard.php?c=playlist_checker_results&url=".$url);
}

function ajax_stream_checker()
{
	global $conn;

	header("Content-Type:application/json; charset=utf-8");

	$url 						= addslashes($_GET['url']);
	$url 						= trim($url);

	$data['encoded_url'] 		= $url;

	$url 						= base64_decode($url);

	$data['url'] 				= $url;

	$probe_command				= 'timeout 15 ffprobe -v quiet -print_format json -show_format -show_streams "'.$url.'" ';

	$data['probe_command'] 		= $probe_command;

	$stream_info 				= shell_exec($probe_command);

	$stream_info 				= json_decode($stream_info, true);

	if(is_array($stream_info['streams'])){
		$data['status'] = 'online';
	}else{
		$data['status'] = 'offline';
	}

	json_output($data);
}

function reseller_add()
{
	global $conn;
		
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);
	$email 				= addslashes($_POST['email']);
	$username 			= addslashes($_POST['username']);
	$password 			= addslashes($_POST['password']);
	$credits 			= addslashes($_POST['credits']);
	$notes 				= addslashes($_POST['notes']);

	// $expire_bits 		= explode('-', $expire_date);
	// $expire_date		= $expire_bits[2].'/'.$expire_bits[0].'/'.$expire_bits[1];
	
	$insert = $conn->exec("INSERT INTO `resellers` 
        (`user_id`,`first_name`,`last_name`,`email`,`username`,`password`,`credits`,`notes`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$first_name."',
        '".$last_name."',
        '".$email."',
        '".$username."',
        '".$password."',
        '".$credits."',
        '".$notes."'
    )");

    $reseller_id = $conn->lastInsertId();

	status_message('success',"Reseller account has been added.");
	go($_SERVER['HTTP_REFERER']);
}

function reseller_update()
{
	global $conn;
	
	$reseller_id 		= addslashes($_POST['reseller_id']);
	$status 			= addslashes($_POST['status']);
	$first_name 		= addslashes($_POST['first_name']);
	$last_name 			= addslashes($_POST['last_name']);
	$email 				= addslashes($_POST['email']);
	$username 			= addslashes($_POST['username']);
	$password 			= addslashes($_POST['password']);
	$credits 			= addslashes($_POST['credits']);
	$notes 				= addslashes($_POST['notes']);

	// $expire_bits 		= explode('-', $expire_date);
	// $expire_date		= $expire_bits[1].'/'.$expire_bits[2].'/'.$expire_bits[0];
	
	$update = $conn->exec("UPDATE `resellers` SET `status` = '".$status."' 				WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `first_name` = '".$first_name."' 		WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `last_name` = '".$last_name."' 		WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `email` = '".$email."' 				WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `username` = '".$username."' 			WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `password` = '".$password."' 			WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `credits` = '".$credits."' 			WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$update = $conn->exec("UPDATE `resellers` SET `notes` = '".$notes."' 				WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Reseller account has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function reseller_delete()
{
	global $conn;

	$reseller_id = get('reseller_id');

	$update = $conn->exec("DELETE FROM `resellers` WHERE `id` = '".$reseller_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	
    status_message('success',"Reseller account has been deleted.");
	go($_SERVER['HTTP_REFERER']);
}

function xc_import(){
	global $whmcs, $site, $conn;

	$user_id 					= $_SESSION['account']['id'];

	$fileName = $_FILES["file1"]["name"]; // The file name
	
	$fileName = str_replace('"', '', $fileName);
	$fileName = str_replace("'", '', $fileName);
	$fileName = str_replace(' ', '_', $fileName);
	$fileName = str_replace(array('!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '+', ';', ':', '\\', '|', '~', '`', ',', '<', '>', '/', '?', '§', '±',), '', $fileName);
	// $fileName = $fileName . '.' . $fileExt;
	
	$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
	$fileType = $_FILES["file1"]["type"]; // The type of file it is
	$fileSize = $_FILES["file1"]["size"]; // File size in bytes
	$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
	if (!$fileTmpLoc) { // if file not chosen
		echo "Please select a file to upload.";
	}
	
	// check if folder exists for customer, if not create it and continue
	if (!file_exists('xc_uploads/'.$user_id) && !is_dir('xc_uploads/'.$user_id)) {
		mkdir('xc_uploads/'.$user_id);
	} 
	
	// handle the uploaded file
	if(move_uploaded_file($fileTmpLoc, "xc_uploads/".$user_id."/".$fileName)){

		// save import job for later
		$insert = $conn->exec("INSERT INTO `xc_import_jobs` 
	        (`user_id`,`status`,`filename`)
	        VALUE
	        ('".$_SESSION['account']['id']."',
	        'pending',
	        '".$fileName."'
	    )");

		// check for compressed files
		if($fileType == 'zip'){

		}

		// report
		echo "<font color='#18B117'><b>Import job has been added. Import will process shortly.</b></font>";
	}else{
		echo "ERROR: Oops, something went very wrong. Please try again or contact support for more help.";
		exit();
	}	
}

function reset_account()
{
	global $conn;

	$user_id			= $_SESSION['account']['id'];
	$type 				= $_GET['type'];
	if(empty($type)){
		status_message('danger',"Missing var, please contact support.");
	}else{
		if($type == 'account' || $type == 'streams'){
			$purge = $conn->exec("DELETE FROM `streams` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'customers'){
			$purge = $conn->exec("DELETE FROM `customers` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'packages'){
			$purge = $conn->exec("DELETE FROM `packages` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'bouquets'){
			$purge = $conn->exec("DELETE FROM `bouquets` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'resellers'){
			$purge = $conn->exec("DELETE FROM `resellers` WHERE `user_id` = '".$user_id."' ");
		}

		if($type == 'account' || $type == 'mag_devices'){
			$purge = $conn->exec("DELETE FROM `mag_devices` WHERE `user_id` = '".$user_id."' ");
		}

		status_message('success',"Reset complete. Please reboot all your servers.");
	}
	go($_SERVER['HTTP_REFERER']);
}

function bouquet_add()
{
	global $conn;
	
	$name 				= addslashes($_POST['name']);

	$insert = $conn->exec("INSERT INTO `bouquets` 
        (`user_id`,`name`)
        VALUE
        ('".$_SESSION['account']['id']."',
        '".$name."'
    )");

    $bouquet_id = $conn->lastInsertId();
    
	// log_add("Stream Category has been added.");
	status_message('success',"Stream Bouquet has been added.");
	go("dashboard.php?c=stream_bouquet&bouquet_id=".$bouquet_id);
}

function bouquet_update()
{
	global $conn;
	
	$bouquet_id 		= addslashes($_POST['bouquet_id']);
	
	$name 				= addslashes($_POST['name']);
	$name 				= trim($name);
		
	$update = $conn->exec("UPDATE `bouquets` SET `name` = '".$name."' 				WHERE `id` = '".$bouquet_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Stream Bouquet has been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function bouquet_streams_update()
{
	global $conn;

	$bouquet_id 		= addslashes($_POST['bouquet_id']);
	
	if(isset($_POST['to'])){
		$streams 		= $_POST['to'];
		$streams 		= array_filter($streams);
		$streams 		= implode(",", $streams);
	}else{
		$streams 		= '';
	}

	// debug($_REQUEST);
	// die();
		
	$update = $conn->exec("UPDATE `bouquets` SET `streams` = '".$streams."' 				WHERE `id` = '".$bouquet_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	status_message('success',"Stream Bouquet streams have been updated.");
	go($_SERVER['HTTP_REFERER']);
}

function bouquet_streams_order_update()
{
	global $conn;
	
	$bouquet_id 		= addslashes($_GET['bouquet_id']);

	$position 			= $_POST['position'];

	$position			= implode(",", $position);

	// debug($_REQUEST);
	// die();
		
	$update = $conn->exec("UPDATE `bouquets` SET `streams` = '".$position."' 				WHERE `id` = '".$bouquet_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// echo $position;
}

function bouquet_delete()
{
	global $conn;

	$bouquet_id = get('bouquet_id');

	// remove the bouquet_id from customers

	// delete primary record
	$query = $conn->query("DELETE FROM `bouquets` WHERE `id` = '".$bouquet_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");

	// log and wrap up
	// log_add("Stream Category Deleted:");
	status_message('success',"Stream Bouquet has been deleted.");
	// return user to previous page
	go($_SERVER['HTTP_REFERER']);
}

function ajax_customer_line()
{
	global $conn;

	$customer_id = get('customer_id');

	$query = $conn->query("SELECT `username`,`password` FROM `customers` WHERE `id` = '".$customer_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	$customer = $query->fetch(PDO::FETCH_ASSOC);

	$content = '';

	if(!empty($customer['username'])){
		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="simple_m3u">M3U</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/simple_m3u">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';

		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="advanced_m3u">M3U with Options</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/advanced_m3u">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';

		$content .= '<div class="row">';
		$content .= '<div class="col-lg-12">';
		$content .= '<div class="form-group">';
		$content .= '<label class="col-md-3 control-label" for="enigma">Enigma 2.0 Autscript - HLS</label>';
		$content .= '<div class="col-md-9">';
		$content .= '<input type="text" class="form-control" value="wget -O /etc/enigma2/iptv.sh \'http://'.$global_settings['cms_access_url'].'/customers/'.$customer['username'].'/'.$customer['password'].'/enigma\' && chmod 777 /etc/enigma2/iptv.sh && /etc/enigma2/iptv.sh">';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
		$content .= '</div>';
	}else{
		$content .= 'Customer not found.';
	}

	echo $content;
}

function ajax_customer_lines()
{
	global $conn, $global_settings;

	$user_id = $_SESSION['account']['id'];

	header("Content-Type:application/json; charset=utf-8");

	function find_outputs($array, $key, $value){
	    $results = array();

	    if (is_array($array)) {
	        if (isset($array[$key]) && $array[$key] == $value) {
	            $results[] = $array;
	        }

	        foreach ($array as $subarray) {
	            $results = array_merge($results, find_outputs($subarray, $key, $value));
	        }
	    }

	    return $results;
	}

	// get customers
	$query = $conn->query("SELECT `id`,`status`,`username`,`password`,`first_name`,`last_name`,`notes`,`email`,`expire_date`,`max_connections`,`reseller_id` FROM `customers` WHERE `user_id` = '".$user_id."' ");
	$customers = $query->fetchAll(PDO::FETCH_ASSOC);

	// get resellers
	$query = $conn->query("SELECT `id`,`email`,`username`,`first_name`,`last_name` FROM `resellers` WHERE `user_id` = '".$user_id."' ");
	$resellers = $query->fetchAll(PDO::FETCH_ASSOC);

	if($query !== FALSE) {
		$count = 0;

		foreach($customers as $customer) {
			$output[$count] 								= $customer;
			$output[$count]['checkbox']						= '<center><input type="checkbox" class="chk" id="checkbox_'.$customer['id'].'" name="customer_ids[]" value="'.$customer['id'].'" onclick="multi_options();"></center>';
			
			if($customer['status'] == 'enabled') {
				$output[$count]['status'] 					= '<span class="label label-success full-width" style="width: 100%;">Enabled</span>';
			}elseif($customer['status'] == 'disabled') {
				$output[$count]['status']					= '<span class="label label-danger full-width" style="width: 100%;">Disabled</span>';
			}elseif($customer['status'] == 'expired') {
				$output[$count]['status'] 					= '<span class="label label-danger full-width" style="width: 100%;">Expired</span>';
			}else{
				$output[$count]['status'] 					= '<span class="label label-warning full-width" style="width: 100%;">'.ucfirst($customer['status']).'</span>';
			}


			$output[$count]['username'] 					= stripslashes($customer['username']);
			$output[$count]['expire_date'] 					= $customer['expire_date'];
			$output[$count]['connections'] 					= $customer['max_connections'];

			// get reseller info
			$output[$count]['owner'] 						= 'Main Account';
			foreach($resellers as $reseller) {
				if($reseller['id'] == $customer['reseller_id']) {
					if(!empty($reseller['first_name'])){
						$output[$count]['owner']				= stripslashes($reseller['first_name']).' '.stripslashes($reseller['last_name']);
					}elseif(!empty($reseller['email'])){
						$output[$count]['owner']				= stripslashes($reseller['email']);
					}else{
						$output[$count]['owner']				= stripslashes($reseller['username']);
					}
				}
			}

			$output[$count]['actions'] 						= '<a title="View / Edit" class="btn btn-info btn-flat btn-xs" href="dashboard.php?c=customer&customer_id='.$customer['id'].'"><i class="fa fa-gears"></i></a><a title="Delete" class="btn btn-danger btn-flat btn-xs" onclick="return confirm(\'Are you sure?\')" href="actions.php?a=customer_delete&customer_id='.$customer['id'].'"><i class="fa fa-times"></i></a>';

			$output[$count]['source_m3u'] 					= 'http://'.$global_settings['cms_access_url_raw'].':'.$global_settings['cms_port'].'/customers/'.$customer['username'].'/'.$customer['password'].'/simple_m3u';
			$output[$count]['source_m3u8'] 					= 'http://'.$global_settings['cms_access_url'].':'.$global_settings['cms_port'].'/customers/'.$customer['username'].'/'.$customer['password'].'/advanced_m3u';
			$output[$count]['source_enigma_autoscript'] 	= "wget -O /etc/enigma2/iptv.sh 'http://".$global_settings['cms_access_url'].":".$global_settings['cms_port']."/customers/".$customer['username']."/".$customer['password']."/enigma' && chmod 777 /etc/enigma2/iptv.sh && /etc/enigma2/iptv.sh";

			$count++;
		}

		// $json_out = json_encode(array_values($your_array_here));

		// $output = array_values($output);
		// $data['data'] = $output;

		if(isset($output)) {
			$data['data'] = array_values($output);
		}else{
			$data['data'] = array();
		}

		if(get('dev') == 'yes'){
			$data['dev'] = $dev;
		}

		json_output($data);
	}
}

function ajax_http_proxy(){
	$data 			= '';
	$ip_address 	= $_GET['ip_address'];
	$port 			= $_GET['port'];
	$metric 		= $_GET['metric'];

	$url = 'http://'.$ip_address.':'.$port.'/server_stats.php?metric='.$metric;
	$data = @file_get_contents($url);

	echo $data;
}