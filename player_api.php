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

$username       = get('username');
$password       = get('password');
$stream_id      = get('streamid');
$remote_ip      = $_SERVER['REMOTE_ADDR'];
$user_agent     = $_SERVER['HTTP_USER_AGENT'];
$query_string   = $_SERVER['QUERY_STRING'];

$sql = "SELECT cms_lines.*, mag_devices.*, COUNT(cms_stream_activity.stream_activity_id) AS connected_streams 
        FROM cms_lines 
        LEFT OUTER JOIN cms_stream_activity ON cms_lines.line_id = cms_stream_activity.stream_activity_line_id AND cms_stream_activity.stream_activity_kill = 0 
        LEFT JOIN mag_devices ON cms_lines.line_id = mag_devices.line_id 
        WHERE line_user = '$username' AND line_pass = '$password''";
$query = $conn->query($sql);
$customer = $query->fetch(PDO::FETCH_ASSOC);

$status = $customer["status"];

$parse_url = parse_url($_SERVER['HTTP_HOST'] . '' . $_SERVER['REQUEST_URI']);
header('Content-Type: application/json');

$output = array();
if(is_array($customer) && !empty($customer)){
    //Alright, Lets get the line status.

    //Okay, now, lets parse the URL.

    //Alright, lets get down to business and
    $action = get("action");
    if($action){
        $output = array();
        switch($action){
            case "get_live_categories": break;
            case "get_vod_categories": break;
            case "get_live_streams":
                $streams = array("streams" => array());
                $line_bouquets = json_decode($customer['bouquet'], true);

                foreach ($line_bouquets as $bouquet_id) {
                    $set_bouquet = $db->query('SELECT streams FROM bouquets WHERE id = ' . $bouquet_id);

                    if ($set_bouquet[0]['bouquet_streams'] != '') {
                        $bouquet_streams_decode = json_decode($set_bouquet[0]['streams'], true);

                        foreach ($bouquet_streams_decode as $key => $value) {
                            $bouquets_stream_array[] = $value;
                        }
                    }
                }

                if (isset($bouquets_stream_array)) {
                    foreach ($bouquets_stream_array as $stream_id) {

                        $cat_id = get("category_id");
                        if (isset($_REQUEST['category_id'])) {
                            $statement = ' AND category_id = ' . $_REQUEST['category_id'];
                        } else {
                            $statement = '';
                        }

                        $set_stream = $db->query('SELECT * FROM streams WHERE stream_id = $stream_id' . $statement);

                        if (0 < count($set_stream)) {
                            $streams['streams'][$set_stream[0]['stream_id']] = $set_stream[0];
                        }
                    }

                    $i = 1;
                    $k = 0;

                    foreach ($streams['streams'] as $stream_value) {
                        $output[$k] = array(
                            'num' => $i,
                            'name' => $stream_value['name'],
                            'stream_type' => 'live',
                            'stream_id' => $stream_value['id'],
                            'stream_icon' => $stream_value['logo'] ? 'http://' . $parse_url['host'] . ':' . $parse_url['port'] . '/_tvlogo/' . $stream_value['logo'] : '',
                            'epg_channel_id' => NULL,
                            'added' => NULL,
                            'category_id' => (string)$stream_value['category_id'],
                            'custom_sid' => '',
                            'tv_archive' => 0,
                            'direct_source' => '',
                            'tv_archive_duration' => 0
                        );
                        $i++;
                        $k++;
                    }
                }

                break;
            case "get_vod_streams": break;
            case "get_series":
                $series = array("series" => array());
                $line_bouquets = json_decode($customer['bouquet'], true);

                foreach ($line_bouquets as $bouquet_id) {
                    $set_bouquet_array = [$bouquet_id];
                    $set_bouquet = $db->query('SELECT bouquet_series FROM cms_bouquets WHERE bouquet_id = $bouquet_id');

                    if ($set_bouquet[0]['bouquet_series'] != '') {
                        $bouquet_series_decode = json_decode($set_bouquet[0]['bouquet_series'], true);

                        foreach ($bouquet_series_decode as $key => $value) {
                            $bouquets_series_array[] = $value;
                        }
                    }
                }

                if (isset($bouquets_series_array)) {
                    foreach ($bouquets_series_array as $serie_id) {
                        $set_serie_query = $conn->query('
                                    SELECT cms_series.*, 
                                    cms_serie_category.* 
                                    FROM cms_series 
                                    LEFT JOIN cms_serie_category ON cms_series.serie_category_id = cms_serie_category.serie_category_id 
                                    WHERE cms_series.serie_id = $serie_id');
                        $set_serie = $set_serie_query->fetch();

                        if (0 < count($set_serie)) {
                            $series['series'][$set_serie[0]['serie_id']] = $set_serie[0];
                        }
                    }

                    $i = 1;
                    $k = 0;

                    foreach ($series['series'] as $serie_value) {
                        $output[$k] = [
                            'num' => $i,
                            'name' => $serie_value['serie_name'],
                            'series_id' => $serie_value['serie_id'],
                            'cover' => $serie_value['serie_pic'],
                            'plot' => $serie_value['serie_short_description'] != '' ? base64_decode($serie_value['serie_short_description']) : '',
                            'cast' => '',
                            'director' => $serie_value['serie_director'],
                            'genre' => $serie_value['serie_genre'],
                            'releaseDate' => $serie_value['serie_release_date'],
                            'last_modified' => '',
                            'rating' => '',
                            'rating_5based' => '',
                            'backdrop_path' => [$serie_value['serie_pic']],
                            'youtube_trailer' => '',
                            'episode_run_time' => '',
                            'category_id' => (string)$serie_value['serie_category_id']
                        ];
                        $i++;
                        $k++;
                    }
                }
                break;
            case "get_series_info":
                $series_id = get("series_id");
                $series_info = array();
                $output['info'] = array();
                $output['episodes'] = array();
                $set_season = $db->query('
                                         SELECT count(cms_serie_episodes.episode_id) as episode_count, 
                                         cms_series.*, 
                                         cms_serie_episodes.* 
                                         FROM cms_serie_episodes 
                                         LEFT JOIN cms_series ON cms_series.serie_id = cms_serie_episodes.serie_id 
                                         WHERE cms_serie_episodes.serie_id = $series_id GROUP BY cms_serie_episodes.serie_episode_season');
                $set_serie_episode = $db->query('SELECT * FROM cms_serie_episodes WHERE serie_id = $series_id');
                $episode_array = array();

                foreach ($set_serie_episode as $get_serie_episode) {
                    $episode_array[] = [
                        'id'                  => $get_serie_episode['episode_id'],
                        'episode_num'         => $get_serie_episode['serie_episode_number'],
                        'title'               => '',
                        'container_extension' => $get_serie_episode['serie_episode_extension'],
                        'info'                => ['movie_image' => '', 'plot' => base64_decode($get_serie_episode['serie_episode_short_description']), 'releasedate' => $get_serie_episode['serie_episode_release_date'], 'rating' => '', 'name' => '', 'duration_secs' => '', 'duration' => '']
                    ];
                }

                foreach ($set_season as $season_key => $season_value) {
                    $output['seasons']['seasons'][] = ['air_date' => '', 'episode_count' => $season_value['episode_count'], 'id' => $season_value['episode_id'], 'name' => 'Season ' . ($season_key + 1), 'overview' => '', 'season_number' => $season_key + 1, 'cover' => $season_value['serie_pic'], 'cover_big' => $season_value['serie_pic']];
                    $output['seasons']['info'] = ['name' => $season_value['serie_name'], 'cover' => $season_value['serie_pic'], 'plot' => $season_value['serie_short_description'] != '' ? base64_decode($season_value['serie_short_description']) : '', 'cast' => '', 'director' => $season_value['serie_director'], 'genre' => $season_value['serie_genre'], 'releaseDate' => $season_value['serie_release_date'], 'last_modified' => '', 'reating' => '', 'rating_5based' => '', 'backdrop_path' => $season_value['serie_pic']];
                    $set_serie_episode_array = [$_REQUEST['series_id'], $season_key + 1];
                    $set_serie_episode = $db->query('SELECT * FROM cms_serie_episodes WHERE serie_id = ? AND serie_episode_season = ?', $set_serie_episode_array);
                    $episode_array = [];

                    foreach ($set_serie_episode as $get_serie_episode) {
                        $episode_array[] = [
                            'id'                  => $get_serie_episode['episode_id'],
                            'episode_num'         => $get_serie_episode['serie_episode_number'],
                            'title'               => $get_serie_episode['serie_episode_title'],
                            'container_extension' => $get_serie_episode['serie_episode_extension'],
                            'info'                => ['movie_image' => $season_value['serie_pic'], 'plot' => base64_decode($get_serie_episode['serie_episode_short_description']), 'releasedate' => $get_serie_episode['serie_episode_release_date'], 'rating' => $get_serie_episode['serie_episode_rating'], 'name' => $get_serie_episode['serie_episode_title'], 'duration_secs' => '', 'duration' => ''],
                            'custom_sid'          => '',
                            'added'               => '',
                            'season'              => $season_key + 1,
                            'direct_source'       => ''
                        ];
                    }

                    $output['seasons']['episodes'][$season_key + 1] = $episode_array;
                }
                break;
        }
    } else {
        //Authentication
        $output['user_info'] = array(
                'username'               => $customer['username'],
                'password'               => $customer['password'],
                'message'                => '',
                'auth'                   => 1,
                'status'                 => $status,
                'exp_date'               => $customer['expire_date'],
                'is_trial'               => '0',
                'active_cons'            => (string) $customer['current_connections'],
                'created_at'             => '',
                'max_connections'        => (string) $customer['max_connections'],
                'allowed_output_formats' => ['m3u8', 'ts']
            );
        $output['server_info'] = array(
                'url'             => $parse_url['host'] ? $parse_url['host'] : 'http://' . $_SERVER['HTTP_HOST'],
                'port'            => (string) $parse_url['port'] ? (string) $parse_url['port'] : '80',
                'https_port'      => '25463',
                'server_protocol' => 'http',
                'rtmp_port'       => '25462',
                'timezone'        => 'Europe/London',
                'timestamp_now'   => time(),
                'time_now'        => date('Y-m-d H:i:s')
        );
    }
} else {
    $output = array(0 => "Access Denied");
}

json_output( $output );