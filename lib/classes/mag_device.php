<?php

class mag_device extends BaseClass {

    public $mag_id;
    public $customer_id;
    public $bright;
    public $contrast;
    public $saturation;
    public $aspect;
    public $video_out;
    public $volume;
    public $playback_buffer_bytes;
    public $playback_buffer_size;
    public $audio_out;
    public $mac;
    public $ip;
    public $ls;
    public $ver;
    public $lang;
    public $locale;
    public $city_id;
    public $hd;
    public $main_notify;
    public $fav_itv_on;
    public $now_playing_start;
    public $now_playing_type;
    public $now_playing_content;
    public $time_last_play_tv;
    public $time_last_play_video;
    public $hd_content;
    public $image_version;
    public $last_change_status;
    public $last_start;
    public $last_active;
    public $keep_alive;
    public $playback_limit;
    public $screensaver_delay;
    public $stb_type;
    public $sn;
    public $last_watchdog;
    public $created;
    public $country;
    public $plasma_saving;
    public $ts_enabled;
    public $ts_enable_icon;
    public $ts_path;
    public $ts_max_length;
    public $ts_buffer_use;
    public $ts_action_on_exit;
    public $ts_delay;
    public $video_clock;
    public $rtsp_type;
    public $rtsp_flags;
    public $stb_lang;
    public $display_menu_after_loading;
    public $record_max_length;
    public $plasma_saving_timeout;
    public $now_playing_link_id;
    public $now_playing_streamer_id;
    public $device_id;
    public $device_id2;
    public $hw_version;
    public $parent_password;
    public $spdif_mode;
    public $show_after_loading;
    public $play_in_preview_by_ok;
    public $hdmi_event_reaction;
    public $mag_player;
    public $play_in_preview_only_by_ok;
    public $fav_channels;
    public $tv_archive_continued;
    public $tv_channel_default_aspect;
    public $last_itv_id;
    public $units;
    public $token;
    public $lock_device;
    public $watchdog_timeout;

    public $_MAG_DATA;
    public $queryString;

    public $mag_line;

    public function __construct($mac_address, $database, $queryString) {
        $this->database = $database;

        if(!empty($mac_address)){
            $this->mac = $mac_address;
            $this->define_device();
            $this->define_line();
        } else {
            //What are we doing?
        }

        $this->queryString = $queryString;
        $this->_MAG_DATA = $this->define_mag_data();
    }

    public function define_device(){
        $sql = "SELECT * FROM mag_devices WHERE ";
        if(!empty($this->mac_id)){
            $sql .= "mac_id = '" . $this->mac_id . "'";
        }

        if(!empty($this->mac)){
            $sql = "mac = '" . $this->mac . "'";
        }

        $query = $this->database->query($sql);
        $results = $query->fetch(PDO::FETCH_ASSOC);

        if(is_array($results)){
            $columns = array_keys($results);
            foreach($columns as $column){
                if(in_array($column, $this->table_columns)){
                    $this->table_columns[$column] = $results[$column];
                    $this->$column = $results[$column];
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function define_line(){
        $sql = "SELECT * FROM customers WHERE customer_id = " . $this->table_columns["customer_id"];
        $query = $this->database->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $this->mag_line = $result;

    }

    public function require_stb($require_action){
        switch($require_action){
            case "handshake":
                $data = $this->_MAG_DATA;
                $data["js"]
            case "get_profile":
                $slipstream = array_merge($this->_MAG_DATA["get_profile"], $this->table_columns); // This is going to be a problem.
                $slipstream["status"] = 1;
                $slipstream["update_url"] = null;
                $slipstream["test_download_url"] = null;
                $slipstream["default_timezone"] = 'Europe/London';
                $slipstream["default_locale"] = 'en_GB.utf8';
                $slipstream["allowed_stb_types"] = array("mag245","mag255","mag256","mag250","MAG254","mag260","mag264","mag265","mag270","mag275","mag274","mag322","aurahd","MAG250","MAG200","formuler","mag360");
                $slipstream["expires"] = null;
                $slipstream["storages"] = array();

                return $slipstream;
            case "get_localization":
                return array("js" => $this->_MAG_DATA["get_localization"]);
            case "log":
                return array("js" => 1);
            case "get_modules":
                return array(
                    "js" => array(
                        "all_modules" => $this->_MAG_DATA["all_modules"],
                        "switchable_modules" => $this->_MAG_DATA["switchable_modules"],
                        "disabled_modules" => $this->_MAG_DATA["disabled_modules"],
                        "restricted_modules" => $this->_MAG_DATA["restricted_modules"],
                        "template" => $this->_MAG_DATA["template"]
                    )
                );
            case "get_preload_images":
                if($this->queryString["gmode"] == "720") {
                    return array("js" => $this->_MAG_DATA["gmode_720"]);
                } elseif($this->queryString["gmode"] == "480"){
                    return array("js" => $this->_MAG_DATA["gmode_480"]);
                } else {
                    return array("js" => $this->_MAG_DATA["gmode_default"]);
                }
            case "get_settings_profile":
                $this->_MAG_DATA["settings_array"]["js"]["parent_password"] = $this->table_columns["parent_password"];
                $this->_MAG_DATA["settings_array"]["js"]["update_url"] = null;
                $this->_MAG_DATA["settings_array"]["js"]["test_download_url"] = null;
                $this->_MAG_DATA["settings_array"]["js"]["playback_buffer_size"] = $this->table_columns["playback_buffer_size"];
                $this->_MAG_DATA["settings_array"]["js"]["screensaver_delay"] = $this->table_columns["screensaver_delay"];
                $this->_MAG_DATA["settings_array"]["js"]["plasma_saving"] = $this->table_columns["plasma_saving"];
                $this->_MAG_DATA["settings_array"]["js"]["spdif_mode"] = $this->table_columns["spdif_mode"];
                $this->_MAG_DATA["settings_array"]["js"]["ts_enabled"] = $this->table_columns["ts_enabled"];
                $this->_MAG_DATA["settings_array"]["js"]["ts_enable_icon"] = $this->table_columns["ts_enable_icon"];
                $this->_MAG_DATA["settings_array"]["js"]["ts_path"] = $this->table_columns["ts_path"];
                $this->_MAG_DATA["settings_array"]["js"]["ts_max_length"] = $this->table_columns["ts_max_length"];
                $this->_MAG_DATA["settings_array"]["js"]["ts_buffer_use"] = $this->table_columns["ts_buffer_use"];
                $this->_MAG_DATA["settings_array"]["js"]["ts_action_on_exit"] = $this->table_columns["ts_action_on_exit"];
                $this->_MAG_DATA["settings_array"]["js"]["ts_delay"] = $this->table_columns["ts_delay"];
                $this->_MAG_DATA["settings_array"]["js"]["hdmi_event_reaction"] = $this->table_columns["hdmi_event_reaction"];
                $this->_MAG_DATA["settings_array"]["js"]["pri_audio_lang"] = $this->_MAG_DATA["get_profile"]["pri_audio_lang"];
                $this->_MAG_DATA["settings_array"]["js"]["show_after_loading"] = $this->table_columns["show_after_loading"];
                $this->_MAG_DATA["settings_array"]["js"]["sec_audio_lang"] = $this->_MAG_DATA["get_profile"]["sec_audio_lang"];
                $this->_MAG_DATA["settings_array"]["js"]["pri_subtitle_lang"] = $this->_MAG_DATA["get_profile"]["pri_subtitle_lang"];
                $this->_MAG_DATA["settings_array"]["js"]["sec_subtitle_lang"] = $this->_MAG_DATA["get_profile"]["sec_subtitle_lang"];

                return $this->_MAG_DATA["settings_array"];
            case "get_locales":
                $output = array();

                foreach ($this->_MAG_DATA["get_locales"] as $country => $code) {
                    $selected = ($this->table_columns["locale"] == $code ? 1 : 0);
                    $output[] = array("label" => $country, "value" => $code, "selected" => $selected);
                }

                return array("js" => $output);
            case "get_countries":
                return array("js" => true);
            case "get_timezones":
                return array("js" => true);
            case "get_cities":
                return array("js" => true);
            case "get_tv_aspects":
                return $this->aspect;
            case "set_volume":
                if(!empty($this->queryString["vol"])){
                    $update = "UPDATE mag_devices SET volume = " . $this->queryString["vol"] . " WHERE mag_id = " . $this->mag_id;
                    $query = $this->database->exec($update);
                }
                return array("js" => true);
            case "set_aspect":
                if(array_key_exists("ch_id",$this->queryString)){
                    $ch_id = $this->queryString["ch_id"];
                    $req_aspect = $this->queryString["aspect"];
                    $current_aspect = $this->aspect;

                    if(empty($this->aspect)){
                        $update = "UPDATE mage_devices SET aspect = '" . json_encode(array("js" => $this->queryString["aspect"])) . "' WHERE mag_id = ". $this->mag_id;
                        $execute = $this->database->exec($update);
                    } else {
                        $update_key = array("js" => array($ch_id => $req_aspect));
                        $update_key_json = json_encode($update_key);
                        $update = "UPDATE mag_devices SET aspect = '" . $update_key_json . "' WHERE mag_id = ". $this->mag_id;
                    }
                }
                return array("js" => true);
            case "set_stream_error":
                return array("js" => true);
            case "set_screensaver_delay":
                if(array_key_exists("screensaver_delay", $this->queryString)){
                    $delay = intval($this->queryString["screensaver_delay"]);
                    $update = "UPDATE mag_devices SET screensaver_delay = ". $delay ." WHERE mag_id = ". $this->mag_id;
                    $query = $this->database->exec($update);
                }
                return array("js" => true);
            case "set_playback_buffer":
                if (!empty($_SERVER["HTTP_COOKIE"])) {
                    $playback_buffer_bytes = intval($this->queryString["playback_buffer_bytes"]);
                    $playback_buffer_size = intval($this->queryString["playback_buffer_size"]);
                    $mag_update = $this->database->exec("UPDATE mag_devices SET	playback_buffer_bytes = $playback_buffer_bytes, playback_buffer_size = $this->playback_buffer_size WHERE mag_id = ". $this->mag_id);

                    return (array("js" => true));
                } else {
                    exit("Identification failed");
                }
            case "set_plasma_saving":
                if(array_key_exists("plasma_saving", $this->queryString)){
                    $plasma_saving = intval($this->queryString["plasma_saving"]);
                    $update = $this->database->exec("UPDATE mag_devices SET plasma_saving = $plasma_saving WHERE mag_id = $this->mag_id");
                }
                return array("js" => true);
            case "set_parent_password":
                if (isset($this->queryString["parent_password"]) && isset($this->queryString["pass"]) && isset($this->queryString["repeat_pass"]) && ($this->queryString["pass"] == $this->queryString["repeat_pass"])) {
                    $set_mag = $this->database->query('SELECT parent_password FROM mag_devices WHERE mag_id = '. $this->mag_id);
                    if(count($set_mag) > 0){
                        $pass = $this->queryString["pass"];
                        $repeat_pass = $this->queryString["repeat_pass"];

                        $mag_update = $this->database->query('UPDATE mag_devices SET parent_password = $pass WHERE mag_id = $this->mag_id');

                        return array("js" => true);
                    }

                } else {
                    exit("Identification failed");
                }
            case "set_locale":
                return array("js" => true);
            case "set_hdmi_reaction":
                if(array_key_exists("data", $this->queryString)){
                    $hdmi = $this->queryString["data"];
                    $update = $this->database->exec("UPDATE mag_devices SET hdmi_event_reaction = $hdmi WHERE mag_id = $this->mag_id");
                    return array("js" => true);
                }

                exit("Identification failed");
        }
    }

    public function require_itv($require_action){
        switch ($require_action) {
            case "set_fav":
                if(array_key_exists("fav_ch", $this->queryString)){
                    $fav_channels = array_filter(array_map("intval", explode(",", $this->queryString["fav_ch"])));
                    $this->table_columns["fav_channels"]["live"] = $fav_channels;
                    $this->fav_channels["live"] = $fav_channels;
                    $update = $this->database->exec("UPDATE mag_devices SET fav_channels = '" . json_encode($this->fav_channels) ."' WHERE mag_id = " . $this->mag_id);
                }

                return array("js" => true);
            case "get_fav_ids":
                return array("js" => $this->fav_channels["live"]);
            case "get_all_channels":
                return $this->getStreams(NULL, true);
            case "get_ordered_list":
                $fav = (!empty($this->queryString["fav"]) ? 1 : NULL);
                $sortby = (!empty($this->queryString["sortby"]) ? $this->queryString["sortby"] : NULL);
                $genre = (empty($this->queryString["genre"]) || !is_numeric($this->queryString["genre"]) ? NULL : intval($this->queryString["genre"]));

                return $this->getStreams($genre, false, $fav, $sortby);
            case "get_all_fav_channels":
                $genre = (empty($this->queryString["genre"]) || !is_numeric($this->queryString["genre"]) ? NULL : intval($this->queryString["genre"]));
                return $this->getStreams($genre, true, 1);
            case "get_epg_info":
                return $this->getEpgdata(0);
            case "set_fav_status":
                return array("js" => array());
            case "get_short_epg":
                $ch_id = (empty($this->queryString["ch_id"]) || !is_numeric($this->queryString["ch_id"]) ? NULL : intval($this->queryString["ch_id"]));
                return $this->getEpgdata(1, $ch_id);
            case "set_played":
                return array("js" => true);
            case "set_last_id":
                return array("js" => true);
            case "get_genres":
                $output = array();
                $output["js"][] = array("id" => "*","title" => "All","alias" => "All");

                $set_stream = $this->database->query('SELECT stream_category_id FROM cms_streams');
                $stream_categories = array();
                foreach($set_stream as $get_streams){
                    array_push($stream_categories, $get_streams['stream_category_id']);
                }

                foreach(array_unique($stream_categories) as $stream_category_id){
                    $set_stream_category_array = array($stream_category_id);
                    $set_stream_category = $this->database->query('SELECT * FROM cms_stream_category WHERE stream_category_id = ?', $set_stream_category_array);
                    $output["js"][] = array(
                        "id" => $set_stream_category[0]["stream_category_id"],
                        "title" => $set_stream_category[0]["stream_category_name"],
                        "alias" => $set_stream_category[0]["stream_category_name"]
                    );
                }
                return $output;
        }
    }

    public function require_remote_pvr($require_action){
        return array("js" => array());
    }

    public function require_media_favorites($require_action){
        return array("js" => array());
    }

    public function require_tvreminders($require_action){
        return array("js" => array());
    }

    /* THIS STILL NEEDS FUNCTIONALITY */
    public function require_vod($require_action){
        switch ($require_action) {
            case "set_fav": break;
            case "del_fav": break;
            case "get_categories": break;
            case "get_genres_by_category_alias": break;
            case "get_years": break;
            case "get_ordered_list": break;
            case "create_link": break;
            case "log": break;
            case "get_abc": break;
        }
    }

    /* THIS STILL NEEDS FUNCTIONALITY */
    public function require_series($require_action){
        switch ($require_action) {
            case "set_fav": break;
            case "del_fav": break;
            case "get_categories": break;
            case "get_genres_by_category_alias": break;
            case "get_years": break;
            case "get_ordered_list": break;
            case "create_link": break;
            case "log": break;
            case "get_abc": break;
        }
    }

    public function require_downloads($require_action){
        return array("js" => "\"\"");
    }

    public function require_weatherco($require_action){
        return array("js" => true);
    }

    public function require_course($require_action){
        return array("js" => true);
    }

    public function require_account_info($require_action){
        switch ($require_action) {
            case "get_terms_info": return array("js" => true);
            case "get_payment_info": return array("js" => true);
            case "get_main_info": return array("js" => true);
            case "get_demo_video_parts": return array("js" => true);
            case "get_agreement_info": return array("js" => true);
        }
    }

    public function require_radio($require_action){
        switch ($require_action) {
            case "get_ordered_list": break;
            case "get_all_fav_radio": break;
            case "set_fav": return array("js" => true); break;
            case "get_fav_ids": break;
        }
    }

    public function require_tvarchive($require_action){
        return array("js" => true);
    }

    //EPG Functionality is not currently setup yet. Hold off on this for completion.
    public function require_epg($require_action){
        switch ($require_action) {
            case "get_week": break;
            case "get_simple_data_table": break;
            case "get_data_table": break;
        }
    }

    //Don't really see the need to this function as we're not logging events at the moment.
    public function require_watchdog($require_action){
        switch ($require_action) {
            case "get_events": break;
            case "confirm_event": break;
        }
    }

    //This function gets the stream from the user.
    public function getstreamfromuser($category_id, $line_id){
        $streams = array("streams" => array());
        $set_line = $this->database->query('SELECT bouquet, user, pass FROM customers WHERE id = ' . $line_id);

        $line_bouquets = json_decode($set_line[0]['id'], true);
        foreach($line_bouquets as $bouquet_id){
            $set_bouquet = $this->database->query('SELECT streams FROM bouquets WHERE id = '. $bouquet_id);

            $bouquet_streams_decode = json_decode($set_bouquet[0]['streams'], true);
            foreach($bouquet_streams_decode as $key => $value){
                $bouquets_stream_array[] = $value;
            }
        }

        foreach ($bouquets_stream_array as $stream_id ){

            if ($category_id != NULL) {
                $statement = ' AND stream_category_id = '.$category_id;
            } else {
                $statement = '';
            }

            $set_stream = $this->database->query('SELECT * FROM streams WHERE id = ' . $stream_id . $statement);

            $streams["streams"][$set_stream[0]["id"]] = $set_stream[0];
        }

        return $streams;
    }

    //This function gets the streams for the user.
    public function getStreams($category_id = NULL, $all = false, $fav = NULL, $orderby = NULL) {
        global $dev;
        global $player;
        global $db;

        $page = (isset($this->queryString["p"]) ? intval($this->queryString["p"]) : 0);
        $page_items = 14;
        $default_page = false;
        $streams = $this->getstreamfromuser($category_id, $this->customer_id);
        $counter = count($streams["streams"]) - 1;
        $ch_idx = 0;

        if ($page == 0) {
            $default_page = true;
            $page = ceil($ch_idx / $page_items);

            if ($page == 0) {
                $page = 1;
            }
        }

        if (!$all) {
            $streams = array_slice($streams["streams"], ($page - 1) * $page_items, $page_items);
        } else {
            $streams = $streams["streams"];
        }

        $epgInfo = '';
        $i = 1;

        $set_line = $this->getLineData();
        $set_server = $this->getServerData();

        if($set_server['public_hostname'] == ''){
            $server = $set_server['wan_ip_address'];
        } else {
            $server = $set_server['public_hostname'];
        }

        foreach(array_filter($streams) as $key => $stream){
            if (!is_null($fav) && ($fav == 1)) {
                if (!in_array($stream["id"], $this->fav_channels["live"])) {
                    continue;
                }
            }

            if(strpos($stream["id"], ".ts")){
                $stream_ts = $stream["id"];
            } else {
                $stream_ts = $stream["id"] . ".ts";
            }

            $stream_url = 'http://' . $server . ':' . $set_server['http_stream_port'] . '/live/' . $set_line['user'] . '/' . $set_line['pass'] . '/' . $stream_ts;

            $data = array(
                "id" => $stream['id'],
                "name" => $stream["stream_name"],
                "number" => (string)(($page - 1) * $page_items) + $i++,
                "censored" => "0",
                "cmd" => "ffmpeg" . $stream_url,
                "cost" => "0",
                "count" => "0",
                "status" => "1",
                "tv_genre_id" => $stream["stream_category_id"],
                "base_ch" => "1",
                "hd" => "0",
                "xmltv_id" => !empty($stream["id"]) ? $stream["id"] : "",
                "service_id" => "",
                "bonus_ch" => "0",
                "volume_correction" => "0",
                "use_http_tmp_link" => "0",
                "mc_cmd" => 1,
                "enable_tv_archive" => 0,
                "wowza_tmp_link" => "0",
                "wowza_dvr" => "0",
                "monitoring_status" => "1",
                "enable_monitoring" => "0",
                "enable_wowza_load_balancing" => "0",
                "cmd_1" => "",
                "cmd_2" => "",
                "cmd_3" => "",
                "logo" => 'http://'.$server.':'.$set_server['server_broadcast_port'].'/_tvlogo/'.$stream['stream_logo'],
                "correct_time" => "0",
                "allow_pvr" => "",
                "allow_local_pvr" => "",
                "modified" => "",
                "allow_local_timeshift" => "1",
                "nginx_secure_link" => "0",
                "tv_archive_duration" => 0,
                "lock" => 0,
                "fav" => in_array($stream['id'], $this->fav_channels["live"]) ? 1 : 0,
                "archive" => 0,
                "genres_str" => "",
                "cur_playing" => "[No channel info]",
                "epg" => "",
                "open" => 1,
                "cmds" => array(
                    array(
                        "id" => $stream['id'],
                        "ch_id" => $stream['id'],
                        "priority" => "0",
                        "url" => "ffmpeg" . $stream_url,
                        "status" => "1",
                        "use_http_tmp_link" => "0",
                        "wowza_tmp_link" => "0",
                        "user_agent_filter" => "",
                        "use_load_balancing" => "0",
                        "changed" => "",
                        "enable_monitoring" => "0",
                        "enable_balancer_monitoring" => "0",
                        "nginx_secure_link" => "0",
                        "flussonic_tmp_link" => "0"
                    )
                ) ,
                "use_load_balancing" => 0,
                "pvr" => 0
            );
        }

        if ($default_page) {
            $cur_page = $page;
            $selected_item = $ch_idx - (($page - 1) * $page_items);
        } else {
            $cur_page = 0;
            $selected_item = 0;
        }

        return array(
            "js" => array(
                "total_items" => $counter,
                "max_page_items" => $page_items,
                "selected_item" => $all ? 0 : $selected_item,
                "cur_page" => $all ? 0 : $cur_page,
                "data" => $data
            )
        );
    }

    //This function gets the movie for the user.
    public function getMovie($category_id = NULL, $fav = NULL, $orderby = NULL) {
        global $dev;
        global $player;
        global $_LANG;
        global $db;

        $page = (isset($this->queryString["p"]) ? intval($this->queryString["p"]) : 0);
        $page_items = 14;
        $default_page = false;
        $data = array();
        $ch_idx = 0;
        $epgInfo = '';

        $set_line = $this->getLineData();
        $set_server = $this->getServerData();

        $bouquets_movies_array = array();
        $line_bouquets = json_decode($set_line['bouquet'], true);
        foreach($line_bouquets as $bouquet_id){
            $set_bouquet = $this->database->query('SELECT bouquet_movies FROM bouquets WHERE id = ' . $bouquet_id);

            $bouquet_movies_decode = json_decode($set_bouquet[0]['bouquet_movies'], true);
            foreach($bouquet_movies_decode as $key => $value){
                $bouquets_movies_array[] = $value;
            }
        }

        $counter = count($bouquets_movies_array);

        if ($page == 0) {
            $default_page = true;
            $page = ceil($ch_idx / $page_items);

            if ($page == 0) {
                $page = 1;
            }
        }

        $movies = array_slice($bouquets_movies_array, ($page - 1) * $page_items, $page_items);
        if ($category_id != NULL) {
            $statement = ' AND movie_category_id = '.$category_id;
        } else {
            $statement = '';
        }

        foreach ($movies as $movie_id) {
            $set_movie_array = array($movie_id);
            $set_movie = $this->database->query('SELECT * FROM vod WHERE id = '. $movie_id . $statement);

            if (!is_null($fav) && ($fav == 1)) {
                if (!in_array($movie_id, $this->fav_channels["live"])) {
                    continue;
                }
            }

            $this_mm = date("m");
            $this_dd = date("d");
            $this_yy = date("Y");

            if (mktime(0, 0, 0, $this_mm, $this_dd, $this_yy) < $set_movie[0]["movie_create_date"]) {
                $added_key = "today";
                $added_val = $_LANG["today"];
            }
            else if (mktime(0, 0, 0, $this_mm, $this_dd - 1, $this_yy) < $set_movie[0]["movie_create_date"]) {
                $added_key = "yesterday";
                $added_val = $_LANG["yesterday"];
            }
            else if (mktime(0, 0, 0, $this_mm, $this_dd - 7, $this_yy) < $set_movie[0]["movie_create_date"]) {
                $added_key = "week_and_more";
                $added_val = $_LANG["last_week"];
            }
            else {
                $added_key = "week_and_more";
                $added_val = date("F", $set_movie[0]["movie_create_date"]) . " " . date("Y", $set_movie[0]["movie_create_date"]);
            }

            if(isset($set_movie[0]["movie_duration"])){
                $movie_duration_explode = explode(' ', $set_movie[0]['movie_duration']);
            }

            $duration = (isset($set_movie[0]["movie_duration"]) ? trim($movie_duration_explode[0]) : 60);
            $data_to_post = array(
                "username" => $set_line['user'],
                "password" => $set_line['pass'],
                "server_dns_name" => $set_server['wan_ip_address'],
                "server_broadcast_port" => $set_server['http_stream_port'],
                "movie_display_name" => $set_movie[0]["movie_name"],
                "movie_id" => $movie_id,
                "direct_source_url" => $set_movie[0]['movie_remote_source'],
                "category_id" => $set_movie[0]["movie_category_id"],
                "sub_category_id" => "",
                "movie_container" => $set_movie[0]["movie_extension"]
            );

            $data = array(
                "id" => $movie_id,
                "age" => "",
                "cmd" => base64_encode(json_encode($data_to_post)) ,
                "genres_str" => $set_movie[0]['movie_genre'],
                "for_rent" => 0,
                "lock" => 0,
                "sd" => 0,
                "hd" => 1,
                "screenshots" => 1,
                "comments" => "",
                "low_quality" => 0,
                "country" => "",
                "rating_mpaa" => "",
                $added_key => $added_val,
                "high_quality" => 0,
                "last_played" => "",
                "rating_last_update" => "",
                "rating_count_imdb" => "",
                "rating_imdb" => "",
                "rating_count_kinopoisk" => "",
                "kinopoisk_id" => "",
                "rating_kinopoisk" => "",
                "for_sd_stb" => 0,
                "last_rate_update" => NULL,
                "rate" => NULL,
                "vote_video_good" => 0,
                "vote_video_bad" => 0,
                "vote_sound_bad" => 0,
                "vote_sound_good" => 0,
                "count_first_0_5" => 0,
                "accessed" => 1,
                "status" => 1,
                "disable_for_hd_devices" => 0,
                "count" => 0,
                "added" => date("Y-m-d H:i:s", $set_movie[0]['movie_create_date']) ,
                "owner" => "",
                "actors" => $set_movie[0]['movie_cast'],
                "director" => $set_movie[0]['movie_director'],
                "year" => $set_movie[0]['movie_release'],
                "cat_genre_id_4" => 0,
                "cat_genre_id_3" => 0,
                "cat_genre_id_2" => 0,
                "cat_genre_id_1" => 0,
                "genre_id_4" => 0,
                "genre_id_3" => 0,
                "genre_id_2" => 0,
                "genre_id_1" => $set_movie[0]['movie_genre'],
                "category_id" => $set_movie[0]["movie_category_id"],
                "name" => $set_movie[0]["movie_name"],
                "o_name" => $set_movie[0]["movie_name"],
                "old_name" => "",
                "fname" => "",
                "description" => base64_decode($set_movie[0]["movie_short_description"]),
                "pic" => 0,
                "screenshot_uri" => $set_movie[0]['movie_pic'],
                "cost" => 0,
                "time" => $duration,
                "file" => "",
                "path" => "",
                "fav" => in_array($movie_id, $this->fav_channels["movie"]) ? 1 : 0,
                "protocol" => "http",
                "rtsp_url" => "",
                "censored" => 0,
                "series" => array() ,
                "volume_correction" => 0
            );
        }

        if ($default_page) {
            $cur_page = $page;
            $selected_item = $ch_idx - (($page - 1) * $page_items);
        } else {
            $cur_page = 0;
            $selected_item = 0;
        }

        return array(
            "js" => array(
                "total_items" => $counter,
                "max_page_items" => $page_items,
                "selected_item" => $selected_item,
                "cur_page" => $cur_page,
                "data" => $data
            )
        );
    }

    /* REWRITE THIS */
    //This function gets the Serie for the user.
    public function getSerie($category_id = NULL, $serie_id = NULL, $season_id = NULL, $episode_id = NULL, $fav = NULL, $orderby = NULL) {

        global $dev;
        global $player;
        global $_LANG;
        global $db;

        $page = (isset($_REQUEST["p"]) ? intval($_REQUEST["p"]) : 0);
        $page_items = 14;
        $default_page = false;
        $data = array();
        $ch_idx = 0;

        if($serie_id != NULL){

            $set_line = $this->getLineData();
            $set_server = $this->getServerData();

            $set_season_array = array($serie_id);
            $set_season = $db->query('SELECT cms_serie_episodes.*, cms_series.*, Count(cms_serie_episodes.serie_episode_number) AS episodes FROM cms_serie_episodes INNER JOIN cms_series ON cms_serie_episodes.serie_id = cms_series.serie_id WHERE cms_serie_episodes.serie_id = ? GROUP BY cms_serie_episodes.serie_episode_season', $set_season_array);

            $counter = count($set_season);
            foreach($set_season as $get_season){

                $set_episode_array = array($get_season['serie_episode_season']);
                $set_episode = $db->query('SELECT * FROM cms_serie_episodes WHERE serie_episode_season = ?', $set_episode_array);
                $episode_array = array();
                foreach($set_episode as $get_episode){
                    $episode_array = array($get_episode['serie_episode_number']);
                }

                $data_to_post = array(
                    "type" => 'series',
                    "series_id" => $get_season['serie_id'],
                    "season_num" => $get_season['serie_episode_season'],
                    "serie_extension" => $get_season['serie_episode_extension'],
                    "username" => $set_line[0]['line_user'],
                    "password" => $set_line[0]['line_pass'],
                    "server_dns_name" => $set_server[0]['server_dns_name'],
                    "server_broadcast_port" => $set_server[0]['server_broadcast_port'],
                );

                $datas[] = array(
                    "id" => $serie_id.':'.$get_season['serie_episode_season'],
                    "owner" => "",
                    "name" => 'Season '.$get_season['serie_episode_season'],
                    "old_name" => "",
                    "o_name" => 'Season '.$get_season['serie_episode_season'],
                    "fname" => "",
                    "description" => base64_decode($get_season['serie_episode_short_description']),
                    "pic" => "",
                    "cost" => 0,
                    "time" => "",
                    "file" => "",
                    "path" => "",
                    "protocol" => "",
                    "rtsp_url" => "",
                    "censored" => 0,
                    "series" => $episode_array,
                    "volume_correction" => 0,
                    "category_id" => $get_season['serie_category_id'],
                    "genre_id" => 0,
                    "genre_id_1" => 0,
                    "genre_id_2" => 0,
                    "genre_id_3" => 0,
                    "hd" => 1,
                    "genre_id_4" => 0,
                    "cat_genre_id_1" => $get_season['serie_category_id'],
                    "cat_genre_id_2" => 0,
                    "cat_genre_id_3" => 0,
                    "cat_genre_id_4" => 0,
                    "director" => $get_season['serie_director'],
                    "actors"=> "",
                    "year" => $get_season['serie_episode_release_date'],
                    "accessed" => 1,
                    "status" => 1,
                    "disable_for_hd_devices" => 0,
                    "added"=> "",
                    "count"=> 0,
                    "count_first_0_5" => 0,
                    "count_second_0_5" => 0,
                    "vote_sound_good" => 0,
                    "vote_sound_bad" => 0,
                    "vote_video_good" => 0,
                    "vote_video_bad" => 0,
                    "rate" => "",
                    "last_rate_update" => "",
                    "last_played" => "",
                    "for_sd_stb" => 0,
                    "rating_imdb" => "",
                    "rating_count_imdb" => "",
                    "rating_last_update" => "0000-00-00 00:00:00",
                    "age" => "",
                    "high_quality" => 0,
                    "rating_kinopoisk" => "",
                    "comments" => "",
                    "low_quality" => 0,
                    "is_series" => 1,
                    "year_end" => 0,
                    "autocomplete_provider "=> "imdb",
                    "screenshots"=> "",
                    "is_movie" => 1,
                    "lock" => 0,
                    "fav" => 0,
                    "for_rent" => 0,
                    "screenshot_uri" => $get_season['serie_pic'],
                    "genres_str" => $get_season['serie_genre'],
                    "cmd" => base64_encode(json_encode($data_to_post)),
                    "week_and_more" => "",
                    "has_files" => 0
                );
            }

        } else {

            $set_line_array = array(1);
            $set_line = $db->query('SELECT line_bouquet_id, line_user, line_pass FROM cms_lines WHERE line_id = ?', $set_line_array);

            $set_server_array = array(1);
            $set_server = $db->query('SELECT server_ip, server_dns_name, server_broadcast_port FROM cms_server WHERE server_main = ?', $set_server_array);

            $bouquets_movies_array = array();
            $line_bouquets = json_decode($set_line[0]['line_bouquet_id'], true);
            foreach($line_bouquets as $bouquet_id){
                $set_bouquet_array = array($bouquet_id);
                $set_bouquet = $db->query('SELECT bouquet_series FROM cms_bouquets WHERE bouquet_id = ?', $set_bouquet_array);

                $bouquet_series_decode = json_decode($set_bouquet[0]['bouquet_series'], true);
                foreach($bouquet_series_decode as $key => $value){
                    $bouquets_series_array[] = $value;
                }
            }

            $counter = count($bouquets_series_array);

            if ($page == 0) {
                $default_page = true;
                $page = ceil($ch_idx / $page_items);

                if ($page == 0) {
                    $page = 1;
                }
            }

            $series = array_slice($bouquets_series_array, ($page - 1) * $page_items, $page_items);
            if ($category_id != NULL) {
                $statement = ' AND serie_category_id = '.$category_id;
            } else {
                $statement = '';
            }

            foreach ($series as $serie_id) {

                $set_serie_array = array($serie_id);
                $set_serie = $db->query('SELECT * FROM cms_series WHERE serie_id = ? ' . $statement, $set_serie_array);

                if (!is_null($fav) && ($fav == 1)) {
                    if (!in_array($serie_id, $dev["fav_channels"]["series"])) {
                        continue;
                    }
                }

                $datas = array(
                    "id" => $serie_id,
                    "owner" => '',
                    "name" => $set_serie[0]["serie_name"],
                    "old_name" => '',
                    "o_name" => $set_serie[0]['serie_original_name'],
                    "fname" => '',
                    "description" => base64_decode($set_serie[0]['serie_short_description']),
                    "pic" => '',
                    "cost" => 0,
                    "time" => 'N\/a',
                    "file" => '',
                    "path" => '',
                    "protocol" => '',
                    "rtsp_url" => '',
                    "censored" => 0,
                    "series" => array(),
                    "volume_correction" => 0,
                    "category_id" => $set_serie[0]['serie_category_id'],
                    "genre_id_1" => 0,
                    "genre_id_2" => 0,
                    "genre_id_3" => 0,
                    "genre_id_4" => 0,
                    "cat_genre_id_1" => 0,
                    "cat_genre_id_2" => 0,
                    "cat_genre_id_3" => 0,
                    "cat_genre_id_4" => 0,
                    "hd" => 1,
                    "director" => $set_serie[0]['serie_director'],
                    "actors" => '',
                    "year" => $set_serie[0]['serie_release_date'],
                    "accessed" => 1,
                    "status" => 1,
                    "disable_for_hd_devices" => 0,
                    "added" => '',
                    "count" => 0,
                    "count_first_0_5" => 0,
                    "count_second_0_5" => 0,
                    "vote_sound_good" => 0,
                    "vote_sound_bad" => 0,
                    "vote_video_good" => 0,
                    "vote_video_bad" => 0,
                    "rate" => '',
                    "last_rate_update" => '',
                    "last_played" => '',
                    "for_sd_stb" => 0,
                    "rating_imdb" => '',
                    "rating_count_imdb" => '',
                    "rating_last_update" => "0000-00-00 00:00:00",
                    "age" => '',
                    "high_quality" => 0,
                    "rating_kinopoisk" => 0,
                    "comments" => '',
                    "low_quality" => 0,
                    "is_series" => 1,
                    "year_end" => 0,
                    "autocomplete_provider" => "imdb",
                    "screenshots" => "",
                    "is_movie" => 1,
                    "lock" => 0,
                    "fav" => 0,
                    "for_rent" => 0,
                    "screenshot_uri" => $set_serie[0]['serie_pic'],
                    "genres_str" => $set_serie[0]['serie_genre'],
                    "cmd" => '',
                    "week_and_more" => '',
                    "has_files" => 1
                );
            }
        }

        if ($default_page) {
            $cur_page = $page;
            $selected_item = $ch_idx - (($page - 1) * $page_items);
        } else {
            $cur_page = 0;
            $selected_item = 0;
        }

        return array(
            "js" => array(
                "total_items" => $counter,
                "max_page_items" => $page_items,
                "selected_item" => $selected_item,
                "cur_page" => $cur_page,
                "data" => $data
            )
        );
    }

    /* REWRITE THIS */
    //This function gets the PPG Data for the user.
    public function getEpgdata($short = 0, $stream_id = NULL) {
        global $dev;
        global $player;
        global $db;

        if ($short == 0) {
            $set_line_array = array($dev["total_info"]["line_id"]);
            $set_line = $db->query('SELECT line_bouquet_id, line_user, line_pass FROM cms_lines WHERE line_id = ?', $set_line_array);

            $set_server_array = array(1);
            $set_server = $db->query('SELECT server_ip, server_dns_name, server_broadcast_port FROM cms_server WHERE server_main = ?', $set_server_array);

            $line_bouquets = json_decode($set_line[0]['line_bouquet_id'], true);
            foreach($line_bouquets as $bouquet_id){
                $set_bouquet_array = array($bouquet_id);
                $set_bouquet = $db->query('SELECT bouquet_streams FROM cms_bouquets WHERE bouquet_id = ?', $set_bouquet_array);

                $bouquet_streams_decode = json_decode($set_bouquet[0]['bouquet_streams'], true);
                foreach($bouquet_streams_decode as $key => $value){
                    $bouquets_stream_array[] = $value;
                }
            }

            $epg = array("js" => array());
            foreach($bouquets_stream_array as $stream_id){
                $set_epg_array = array($stream_id);
                $set_epg_data = $db->query('SELECT cms_epg_data.*, cms_epg_sys.epg_stream_id FROM cms_epg_data LEFT JOIN cms_epg_sys ON (cms_epg_data.epg_data_stream_id = cms_epg_sys.epg_stream_name) WHERE cms_epg_data.epg_data_end >= NOW() AND cms_epg_sys.epg_stream_id = ? ORDER BY cms_epg_data.epg_data_start ASC LIMIT 10', $set_epg_array);

                for ($i = 0; $i < count($set_epg_data); $i++) {

                    $start_time = strtotime($set_epg_data[$i]["epg_data_start"]);
                    $end_time = strtotime($set_epg_data[$i]["epg_data_end"]);

                    $epg["js"]["data"][$stream_id][$i]["id"] = $set_epg_data[$i]["epg_id"];
                    $epg["js"]["data"][$stream_id][$i]["ch_id"] = $set_epg_data[$i]['epg_stream_id'];
                    $epg["js"]["data"][$stream_id][$i]["time"] = date("Y-m-d H:i:s", $start_time);
                    $epg["js"]["data"][$stream_id][$i]["time_to"] = date("Y-m-d H:i:s", $end_time);
                    $epg["js"]["data"][$stream_id][$i]["duration"] = $end_time - $start_time;
                    $epg["js"]["data"][$stream_id][$i]["name"] = base64_decode($set_epg_data[$i]["epg_data_title"]);
                    $epg["js"]["data"][$stream_id][$i]["descr"] = base64_decode($set_epg_data[$i]["epg_data_description"]);
                    $epg["js"]["data"][$stream_id][$i]["real_id"] = $set_epg_data[$i]['epg_stream_id'] . "_" . $set_epg_data[$i]["epg_data_start"];
                    $epg["js"]["data"][$stream_id][$i]["category"] = "";
                    $epg["js"]["data"][$stream_id][$i]["director"] = "";
                    $epg["js"]["data"][$stream_id][$i]["actor"] = "";
                    $epg["js"]["data"][$stream_id][$i]["start_timestamp"] = $start_time;
                    $epg["js"]["data"][$stream_id][$i]["stop_timestamp"] = $end_time;
                    $epg["js"]["data"][$stream_id][$i]["t_time"] = date("h:i", $start_time);
                    $epg["js"]["data"][$stream_id][$i]["t_time_to"] = date("h:i", $end_time);
                    $epg["js"]["data"][$stream_id][$i]["display_duration"] = $end_time - $start_time;
                    $epg["js"]["data"][$stream_id][$i]["larr"] = 0;
                    $epg["js"]["data"][$stream_id][$i]["rarr"] = 0;
                    $epg["js"]["data"][$stream_id][$i]["mark_rec"] = 0;
                    $epg["js"]["data"][$stream_id][$i]["mark_memo"] = 0;
                    $epg["js"]["data"][$stream_id][$i]["mark_archive"] = 0;
                    $epg["js"]["data"][$stream_id][$i]["on_date"] = date("l d.m.Y", $start_time);

                }
            }

            return json_encode($epg);

        } else {

            $epg = array("js" => array());

            $set_epg_array = array($stream_id);
            $set_epg_data = $db->query('SELECT cms_epg_data.* FROM cms_epg_data LEFT JOIN cms_epg_sys ON (cms_epg_data.epg_data_stream_id = cms_epg_sys.epg_stream_name) WHERE cms_epg_data.epg_data_end >= NOW() AND cms_epg_sys.epg_stream_id = ? ORDER BY cms_epg_data.epg_data_start ASC LIMIT 10', $set_epg_array);

            for($i = 0; $i < count($set_epg_data); $i++){

                $start_time = strtotime($set_epg_data[$i]["epg_data_start"]);
                $end_time = strtotime($set_epg_data[$i]["epg_data_end"]);

                $epg["js"][$i]["id"] = $set_epg_data[$i]["epg_id"];
                $epg["js"][$i]["ch_id"] = $stream_id;
                $epg["js"][$i]["time"] = $set_epg_data[$i]["epg_data_start"];
                $epg["js"][$i]["time_to"] = $set_epg_data[$i]["epg_data_end"];
                $epg["js"][$i]["duration"] = $set_epg_data[$i]["epg_data_end"] - $set_epg_data[$i]["epg_data_start"];
                $epg["js"][$i]["name"] = base64_decode($set_epg_data[$i]["epg_data_title"]);
                $epg["js"][$i]["descr"] = base64_decode($set_epg_data[$i]["epg_data_description"]);
                $epg["js"][$i]["real_id"] = $stream_id . "_" . $set_epg_data[$i]["epg_data_start"];
                $epg["js"][$i]["category"] = "";
                $epg["js"][$i]["director"] = "";
                $epg["js"][$i]["actor"] = "";
                $epg["js"][$i]["start_timestamp"] = $set_epg_data[$i]["epg_data_start"];
                $epg["js"][$i]["stop_timestamp"] = $set_epg_data[$i]["epg_data_end"];
                $epg["js"][$i]["t_time"] = date('H:i', $start_time);
                $epg["js"][$i]["t_time_to"] = date('H:i', $end_time);
                $epg["js"][$i]["mark_memo"] = 0;
                $epg["js"][$i]["mark_archive"] = 0;
            }

            return json_encode($epg);
        }
    }

    public function getServerData(){
        $server_sql = "SELECT * FROM headed_servers WHERE user_id = " . $this->customer_id . " ORDER BY id LIMIT 1"; //Work around to get the master server.
        $server_query = $this->database->query($server_sql);
        $server_results = $server_query->fetch(PDO::FETCH_ASSOC);
        if(!empty($server_results) && is_array($server_results)){
            return $server_results;
        } else {
            return false;
        }
    }

    public function getLineData(){
        $line_sql = "SELECT * FROM customers WHERE id = " . $this->customer_id . " LIMIT 1";
        $line_query = $this->database->query($line_sql);
        $line_results = $line_query->fetch(PDO::FETCH_ASSOC);
        if(!empty($line_results) && is_array($line_results)){
            return $line_results;
        } else {
            return false;
        }
    }

    //Define the Data.
    public function define_mag_data(){
        $_MAG_DATA["get_localization"] = array();
        $_MAG_DATA["get_localization"]["weather_comfort"] = "Comfort";
        $_MAG_DATA["get_localization"]["weather_pressure"] = "Pressure";
        $_MAG_DATA["get_localization"]["weather_mmhg"] = "mm Hg";
        $_MAG_DATA["get_localization"]["weather_wind"] = "Wind";
        $_MAG_DATA["get_localization"]["weather_speed"] = "m/s";
        $_MAG_DATA["get_localization"]["weather_humidity"] = "Humidity";
        $_MAG_DATA["get_localization"]["current_weather_unavailable"] = "Current weather unavailable";
        $_MAG_DATA["get_localization"]["current_weather_not_configured"] = "The weather is not configured";
        $_MAG_DATA["get_localization"]["karaoke_view"] = "VIEW";
        $_MAG_DATA["get_localization"]["karaoke_sort"] = "SORT";
        $_MAG_DATA["get_localization"]["karaoke_search"] = "SEARCH";
        $_MAG_DATA["get_localization"]["karaoke_sampling"] = "PICKING";
        $_MAG_DATA["get_localization"]["karaoke_by_letter"] = "BY LETTER";
        $_MAG_DATA["get_localization"]["karaoke_by_performer"] = "BY NAME";
        $_MAG_DATA["get_localization"]["karaoke_by_title"] = "BY TITLE";
        $_MAG_DATA["get_localization"]["karaoke_title"] = "KARAOKE";
        $_MAG_DATA["get_localization"]["layer_page"] = "PAGE";
        $_MAG_DATA["get_localization"]["layer_from"] = "OF";
        $_MAG_DATA["get_localization"]["layer_found"] = "FOUND";
        $_MAG_DATA["get_localization"]["layer_records"] = "RECORDINGS";
        $_MAG_DATA["get_localization"]["layer_loading"] = "LOADING...";
        $_MAG_DATA["get_localization"]["Loading..."] = "Loading...";
        $_MAG_DATA["get_localization"]["mbrowser_title"] = "Media Browser";
        $_MAG_DATA["get_localization"]["mbrowser_connected"] = "connected";
        $_MAG_DATA["get_localization"]["mbrowser_disconnected"] = "disconnected";
        $_MAG_DATA["get_localization"]["mbrowser_not_found"] = "not found";
        $_MAG_DATA["get_localization"]["usb_drive"] = "USB drive";
        $_MAG_DATA["get_localization"]["player_limit_notice"] = "The number of connections is limited. <br> Try again later";
        $_MAG_DATA["get_localization"]["player_file_missing"] = "File missing";
        $_MAG_DATA["get_localization"]["player_server_error"] = "Server error";
        $_MAG_DATA["get_localization"]["player_access_denied"] = "Access denied";
        $_MAG_DATA["get_localization"]["player_server_unavailable"] = "Server unavailable";
        $_MAG_DATA["get_localization"]["player_series"] = "part";
        $_MAG_DATA["get_localization"]["player_track"] = "Track";
        $_MAG_DATA["get_localization"]["player_off"] = "Off";
        $_MAG_DATA["get_localization"]["player_subtitle"] = "Subtitles";
        $_MAG_DATA["get_localization"]["player_claim"] = "Complain";
        $_MAG_DATA["get_localization"]["player_on_sound"] = "on sound";
        $_MAG_DATA["get_localization"]["player_on_video"] = "on video";
        $_MAG_DATA["get_localization"]["player_audio"] = "Audio";
        $_MAG_DATA["get_localization"]["player_ty"] = "Thank you, your opinion will be taken into account";
        $_MAG_DATA["get_localization"]["series_by_one_play"] = "one series";
        $_MAG_DATA["get_localization"]["series_continuously_play"] = "continuously";
        $_MAG_DATA["get_localization"]["aspect_fit"] = "fit on";
        $_MAG_DATA["get_localization"]["aspect_big"] = "zoom";
        $_MAG_DATA["get_localization"]["aspect_opt"] = "optimal";
        $_MAG_DATA["get_localization"]["aspect_exp"] = "stretch";
        $_MAG_DATA["get_localization"]["aspect_cmb"] = "combined";
        $_MAG_DATA["get_localization"]["radio_title"] = "RADIO";
        $_MAG_DATA["get_localization"]["radio_sort"] = "SORT";
        $_MAG_DATA["get_localization"]["radio_favorite"] = "FAVORITE";
        $_MAG_DATA["get_localization"]["radio_search"] = "SEARCH";
        $_MAG_DATA["get_localization"]["radio_by_number"] = "by number";
        $_MAG_DATA["get_localization"]["radio_by_title"] = "by title";
        $_MAG_DATA["get_localization"]["radio_only_favorite"] = "only favorite";
        $_MAG_DATA["get_localization"]["radio_fav_add"] = "add";
        $_MAG_DATA["get_localization"]["radio_fav_del"] = "del";
        $_MAG_DATA["get_localization"]["radio_search_box"] = "SEARCH";
        $_MAG_DATA["get_localization"]["tv_view"] = "VIEW";
        $_MAG_DATA["get_localization"]["tv_sort"] = "SORT";
        $_MAG_DATA["get_localization"]["favorite"] = "FAVORITE";
        $_MAG_DATA["get_localization"]["tv_favorite"] = "FAVORITE";
        $_MAG_DATA["get_localization"]["tv_move"] = "MOVE";
        $_MAG_DATA["get_localization"]["tv_by_number"] = "by number";
        $_MAG_DATA["get_localization"]["tv_by_title"] = "by title";
        $_MAG_DATA["get_localization"]["tv_only_favorite"] = "only favorite";
        $_MAG_DATA["get_localization"]["tv_only_hd"] = "HD only";
        $_MAG_DATA["get_localization"]["tv_list"] = "list";
        $_MAG_DATA["get_localization"]["tv_list_w_info"] = "list + info";
        $_MAG_DATA["get_localization"]["tv_title"] = "TV";
        $_MAG_DATA["get_localization"]["vclub_info"] = "information about the movie";
        $_MAG_DATA["get_localization"]["vclub_year"] = "Year";
        $_MAG_DATA["get_localization"]["vclub_country"] = "Country";
        $_MAG_DATA["get_localization"]["vclub_genre"] = "Genre";
        $_MAG_DATA["get_localization"]["vclub_length"] = "Length";
        $_MAG_DATA["get_localization"]["vclub_minutes"] = "min";
        $_MAG_DATA["get_localization"]["vclub_director"] = "Director";
        $_MAG_DATA["get_localization"]["vclub_cast"] = "Cast";
        $_MAG_DATA["get_localization"]["vclub_rating"] = "Rating";
        $_MAG_DATA["get_localization"]["vclub_age"] = "Age";
        $_MAG_DATA["get_localization"]["vclub_rating_mpaa"] = "Rating MPAA";
        $_MAG_DATA["get_localization"]["vclub_view"] = "VIEW";
        $_MAG_DATA["get_localization"]["vclub_sort"] = "SORT";
        $_MAG_DATA["get_localization"]["vclub_search"] = "SEARCH";
        $_MAG_DATA["get_localization"]["vclub_fav"] = "FAVORITE";
        $_MAG_DATA["get_localization"]["vclub_other"] = "OTHER";
        $_MAG_DATA["get_localization"]["vclub_find"] = "FIND";
        $_MAG_DATA["get_localization"]["vclub_by_letter"] = "BY LETTER";
        $_MAG_DATA["get_localization"]["vclub_by_genre"] = "BY GENRE";
        $_MAG_DATA["get_localization"]["vclub_by_year"] = "BY YEAR";
        $_MAG_DATA["get_localization"]["vclub_by_rating"] = "BY RATING";
        $_MAG_DATA["get_localization"]["vclub_search_box"] = "search";
        $_MAG_DATA["get_localization"]["vclub_query_box"] = "picking";
        $_MAG_DATA["get_localization"]["vclub_by_title"] = "by title";
        $_MAG_DATA["get_localization"]["vclub_by_addtime"] = "by addtime";
        $_MAG_DATA["get_localization"]["vclub_top"] = "rating";
        $_MAG_DATA["get_localization"]["vclub_only_hd"] = "HD only";
        $_MAG_DATA["get_localization"]["vclub_only_favorite"] = "favorite only";
        $_MAG_DATA["get_localization"]["vclub_only_purchased"] = "purchased";
        $_MAG_DATA["get_localization"]["vclub_not_ended"] = "not ended";
        $_MAG_DATA["get_localization"]["vclub_list"] = "list";
        $_MAG_DATA["get_localization"]["vclub_list_w_info"] = "list + info";
        $_MAG_DATA["get_localization"]["vclub_title"] = "VIDEOCLUB";
        $_MAG_DATA["get_localization"]["vclub_purchased"] = "Purchased";
        $_MAG_DATA["get_localization"]["vclub_rent_expires_in"] = "rent expires in";
        $_MAG_DATA["get_localization"]["cut_off_msg"] = "Your STB is blocked.<br/> Call the provider.";
        $_MAG_DATA["get_localization"]["month_arr"] = array("JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER");
        $_MAG_DATA["get_localization"]["week_arr"] = array("SUNDAY", "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY");
        $_MAG_DATA["get_localization"]["year"] = "";
        $_MAG_DATA["get_localization"]["records_title"] = "RECORDINGS";
        $_MAG_DATA["get_localization"]["ears_back"] = "<br>B<br>A<br>C<br>K<br>";
        $_MAG_DATA["get_localization"]["ears_about_movie"] = "<br>A<br>B<br>O<br>U<br>T<br> <br>M<br>O<br>V<br>I<br>E<br>";
        $_MAG_DATA["get_localization"]["ears_tv_guide"] = "<br>T<br>V<br> <br>G<br>U<br>I<br>D<br>E<br>";
        $_MAG_DATA["get_localization"]["ears_about_package"] = "<br>P<br>A<br>C<br>K<br>A<br>G<br>E<br> <br>I<br>N<br>F<br>O<br>";
        $_MAG_DATA["get_localization"]["settings_title"] = "SETTINGS";
        $_MAG_DATA["get_localization"]["parent_settings_cancel"] = "CANCEL";
        $_MAG_DATA["get_localization"]["parent_settings_save"] = "SAVE";
        $_MAG_DATA["get_localization"]["parent_settings_old_pass"] = "Current password";
        $_MAG_DATA["get_localization"]["parent_settings_title"] = "PARENTAL SETTINGS";
        $_MAG_DATA["get_localization"]["parent_settings_title_short"] = "PARENTAL";
        $_MAG_DATA["get_localization"]["parent_settings_new_pass"] = "New password";
        $_MAG_DATA["get_localization"]["parent_settings_repeat_new_pass"] = "Repeat new password";
        $_MAG_DATA["get_localization"]["settings_saved"] = "Settings saved";
        $_MAG_DATA["get_localization"]["settings_saved_reboot"] = "Settings saved.<br>The STB will be rebooted. Press OK.";
        $_MAG_DATA["get_localization"]["settings_check_error"] = "Error filling fields";
        $_MAG_DATA["get_localization"]["settings_saving_error"] = "Saving error";
        $_MAG_DATA["get_localization"]["localization_settings_title"] = "LOCALIZATION";
        $_MAG_DATA["get_localization"]["localization_label"] = "Language of the interface";
        $_MAG_DATA["get_localization"]["country_label"] = "Country";
        $_MAG_DATA["get_localization"]["city_label"] = "City";
        $_MAG_DATA["get_localization"]["localization_page_button_info"] = "Use PAGE-/+ buttons to move through several menu items";
        $_MAG_DATA["get_localization"]["settings_software_update"] = "SOFTWARE UPDATE";
        $_MAG_DATA["get_localization"]["update_settings_cancel"] = "CANCEL";
        $_MAG_DATA["get_localization"]["update_settings_start_update"] = "START UPDATE";
        $_MAG_DATA["get_localization"]["update_from_http"] = "From HTTP";
        $_MAG_DATA["get_localization"]["update_from_usb"] = "From USB";
        $_MAG_DATA["get_localization"]["update_source"] = "Source";
        $_MAG_DATA["get_localization"]["update_method_select"] = "Method select";
        $_MAG_DATA["get_localization"]["empty"] = "EMPTY";
        $_MAG_DATA["get_localization"]["course_title"] = "Exchange rate on";
        $_MAG_DATA["get_localization"]["course_title_nbu"] = "NBU exchange rate on";
        $_MAG_DATA["get_localization"]["course_title_cbr"] = "CBR exchange rate on";
        $_MAG_DATA["get_localization"]["dayweather_title"] = "WEATHER";
        $_MAG_DATA["get_localization"]["dayweather_pressure"] = "pres.:";
        $_MAG_DATA["get_localization"]["dayweather_mmhg"] = "mm Hg";
        $_MAG_DATA["get_localization"]["dayweather_wind"] = "wind:";
        $_MAG_DATA["get_localization"]["dayweather_speed"] = "m/s";
        $_MAG_DATA["get_localization"]["infoportal_title"] = "INFOPORTAL";
        $_MAG_DATA["get_localization"]["cityinfo_title"] = "CITY INFO";
        $_MAG_DATA["get_localization"]["cityinfo_main"] = "emergency";
        $_MAG_DATA["get_localization"]["cityinfo_help"] = "help";
        $_MAG_DATA["get_localization"]["cityinfo_other"] = "other";
        $_MAG_DATA["get_localization"]["cityinfo_sort"] = "VIEW";
        $_MAG_DATA["get_localization"]["horoscope_title"] = "HOROSCOPE";
        $_MAG_DATA["get_localization"]["anecdote_title"] = "JOKES";
        $_MAG_DATA["get_localization"]["anecdote_goto"] = "GOTO";
        $_MAG_DATA["get_localization"]["anecdote_like"] = "LIKE";
        $_MAG_DATA["get_localization"]["anecdote_bookmark"] = "BOOKMARK";
        $_MAG_DATA["get_localization"]["anecdote_to_bookmark"] = "TO BOOKMARK";
        $_MAG_DATA["get_localization"]["anecdote_pagebar_title"] = "JOKE";
        $_MAG_DATA["get_localization"]["mastermind_title"] = "MASTERMIND";
        $_MAG_DATA["get_localization"]["mastermind_rules"] = "RULES";
        $_MAG_DATA["get_localization"]["mastermind_rating"] = "RATING";
        $_MAG_DATA["get_localization"]["mastermind_bull"] = "B";
        $_MAG_DATA["get_localization"]["mastermind_cow"] = "C";
        $_MAG_DATA["get_localization"]["mastermind_rules_text"] = "Your task is to guess the number of unduplicated four digits, the first of them - not zero. Every your guess will be compared with the number put forth a STB. If you guessed a digit, but it is not in place, then it is a COW (C). If you guessed, and a number, and its location, this BULL (B).";
        $_MAG_DATA["get_localization"]["mastermind_move_cursor"] = "Moving the cursor";
        $_MAG_DATA["get_localization"]["mastermind_cell_numbers"] = "Enter numbers into cells";
        $_MAG_DATA["get_localization"]["mastermind_step_confirmation"] = "Confirmation of the step";
        $_MAG_DATA["get_localization"]["mastermind_page"] = "Page";
        $_MAG_DATA["get_localization"]["mastermind_history_moves"] = "Moving through the pages of history moves";
        $_MAG_DATA["get_localization"]["msg_service_off"] = "Service is disabled";
        $_MAG_DATA["get_localization"]["msg_channel_not_available"] = "Channel is not available";
        $_MAG_DATA["get_localization"]["epg_title"] = "TV Guide";
        $_MAG_DATA["get_localization"]["epg_record"] = "RECORD";
        $_MAG_DATA["get_localization"]["epg_remind"] = "REMIND";
        $_MAG_DATA["get_localization"]["epg_memo"] = "Memo";
        $_MAG_DATA["get_localization"]["epg_goto_ch"] = "Goto channel";
        $_MAG_DATA["get_localization"]["epg_close_msg"] = "Close";
        $_MAG_DATA["get_localization"]["epg_on_ch"] = "on channel";
        $_MAG_DATA["get_localization"]["epg_now_begins"] = "now begins";
        $_MAG_DATA["get_localization"]["epg_on_time"] = "in";
        $_MAG_DATA["get_localization"]["epg_started"] = "started";
        $_MAG_DATA["get_localization"]["epg_more"] = "MORE";
        $_MAG_DATA["get_localization"]["epg_category"] = "Category";
        $_MAG_DATA["get_localization"]["epg_director"] = "Director";
        $_MAG_DATA["get_localization"]["epg_actors"] = "Actors";
        $_MAG_DATA["get_localization"]["epg_desc"] = "Description";
        $_MAG_DATA["get_localization"]["search_box_languages"] = array("en");
        $_MAG_DATA["get_localization"]["date_format"] = "{0}, {2} {1}, {3}";
        $_MAG_DATA["get_localization"]["time_format"] = "{2}:{1} {3}";
        $_MAG_DATA["get_localization"]["timezone_label"] = "Timezone";
        $_MAG_DATA["get_localization"]["ntp_server"] = "NTP Server";
        $_MAG_DATA["get_localization"]["remote_pvr_del"] = "DELETE";
        $_MAG_DATA["get_localization"]["remote_pvr_stop"] = "STOP";
        $_MAG_DATA["get_localization"]["remote_pvr_del_confirm"] = "Do you really want to delete this record?";
        $_MAG_DATA["get_localization"]["remote_pvr_stop_confirm"] = "Do you really want to stop this record?";
        $_MAG_DATA["get_localization"]["alert_confirm"] = "Confirm";
        $_MAG_DATA["get_localization"]["alert_cancel"] = "Cancel";
        $_MAG_DATA["get_localization"]["recorder_server_error"] = "Server error. Try again later.";
        $_MAG_DATA["get_localization"]["record_duration"] = "RECORDING DURATION, h";
        $_MAG_DATA["get_localization"]["rest_length_title"] = "FREE on the server, h";
        $_MAG_DATA["get_localization"]["channel_recording_restricted"] = "Recording this channel is forbidden";
        $_MAG_DATA["get_localization"]["playback_settings_buffer_size"] = "Buffer size";
        $_MAG_DATA["get_localization"]["playback_settings_time"] = "Time, sec";
        $_MAG_DATA["get_localization"]["playback_settings_title"] = "PLAYBACK";
        $_MAG_DATA["get_localization"]["cancel_btn"] = "CANCEL";
        $_MAG_DATA["get_localization"]["settings_cancel"] = "CANCEL";
        $_MAG_DATA["get_localization"]["playback_settings_cancel"] = "CANCEL";
        $_MAG_DATA["get_localization"]["exit_btn"] = "EXIT";
        $_MAG_DATA["get_localization"]["yes_btn"] = "YES";
        $_MAG_DATA["get_localization"]["close_btn"] = "CLOSE";
        $_MAG_DATA["get_localization"]["ok_btn"] = "OK";
        $_MAG_DATA["get_localization"]["pay_btn"] = "PAY";
        $_MAG_DATA["get_localization"]["play_btn"] = "PLAY";
        $_MAG_DATA["get_localization"]["start_btn"] = "START";
        $_MAG_DATA["get_localization"]["add_btn"] = "ADD";
        $_MAG_DATA["get_localization"]["settings_save"] = "SAVE";
        $_MAG_DATA["get_localization"]["playback_settings_save"] = "SAVE";
        $_MAG_DATA["get_localization"]["audio_out"] = "Audio out";
        $_MAG_DATA["get_localization"]["audio_out_analog"] = "Analog only";
        $_MAG_DATA["get_localization"]["audio_out_analog_spdif"] = "Analog and S/PDIF 2-channel PCM";
        $_MAG_DATA["get_localization"]["audio_out_spdif"] = "S/PDIF raw or 2-channel PCM";
        $_MAG_DATA["get_localization"]["game"] = "GAME";
        $_MAG_DATA["get_localization"]["downloads_title"] = "DOWNLOADS";
        $_MAG_DATA["get_localization"]["not_found_mounted_devices"] = "Not found mounted devices";
        $_MAG_DATA["get_localization"]["downloads_add_download"] = "Add download";
        $_MAG_DATA["get_localization"]["downloads_device"] = "Device";
        $_MAG_DATA["get_localization"]["downloads_file_name"] = "File name";
        $_MAG_DATA["get_localization"]["downloads_ok"] = "Ok";
        $_MAG_DATA["get_localization"]["downloads_cancel"] = "Cancel";
        $_MAG_DATA["get_localization"]["downloads_create"] = "CREATE";
        $_MAG_DATA["get_localization"]["downloads_move_up"] = "MOVE UP";
        $_MAG_DATA["get_localization"]["downloads_move_down"] = "MOVE DOWN";
        $_MAG_DATA["get_localization"]["downloads_delete"] = "DELETE";
        $_MAG_DATA["get_localization"]["downloads_record"] = "RECORDING";
        $_MAG_DATA["get_localization"]["downloads_download"] = "DOWNLOAD";
        $_MAG_DATA["get_localization"]["downloads_record_and_file"] = "RECORDING AND FILE";
        $_MAG_DATA["get_localization"]["playback_limit_title"] = "Duration of continuous playback";
        $_MAG_DATA["get_localization"]["playback_limit_off"] = "Without limit";
        $_MAG_DATA["get_localization"]["playback_hours"] = "hours";
        $_MAG_DATA["get_localization"]["playback_limit_reached"] = "Reached limit the duration of continuous playback. To continue playback, press the OK or EXIT.";
        $_MAG_DATA["get_localization"]["common_settings_title"] = "GENERAL";
        $_MAG_DATA["get_localization"]["screensaver_delay_title"] = "Screensaver interval";
        $_MAG_DATA["get_localization"]["screensaver_off"] = "Disabled";
        $_MAG_DATA["get_localization"]["screensaver_minutes"] = "min";
        $_MAG_DATA["get_localization"]["demo_video_title"] = "DEMO VIDEO";
        $_MAG_DATA["get_localization"]["account_info_title"] = "ACCOUNT";
        $_MAG_DATA["get_localization"]["coming_soon"] = "Coming soon";
        $_MAG_DATA["get_localization"]["account_info"] = "INFORMATION";
        $_MAG_DATA["get_localization"]["account_payment"] = "PAYMENT";
        $_MAG_DATA["get_localization"]["account_pay"] = "PAY";
        $_MAG_DATA["get_localization"]["account_agreement"] = "AGREEMENT";
        $_MAG_DATA["get_localization"]["account_terms"] = "TERMS OF USE";
        $_MAG_DATA["get_localization"]["demo_video"] = "Video instruction";
        $_MAG_DATA["get_localization"]["tv_quality"] = "QUALITY";
        $_MAG_DATA["get_localization"]["tv_quality_low"] = "low";
        $_MAG_DATA["get_localization"]["tv_quality_medium"] = "medium";
        $_MAG_DATA["get_localization"]["tv_quality_high"] = "high";
        $_MAG_DATA["get_localization"]["tv_fav_add"] = "add";
        $_MAG_DATA["get_localization"]["tv_fav_del"] = "del";
        $_MAG_DATA["get_localization"]["internet"] = "internet";
        $_MAG_DATA["get_localization"]["network_status_title"] = "NETWORK STATUS";
        $_MAG_DATA["get_localization"]["network_status_refresh"] = "REFRESH";
        $_MAG_DATA["get_localization"]["test_speed"] = "Speed test";
        $_MAG_DATA["get_localization"]["speedtest_testing"] = "testing...";
        $_MAG_DATA["get_localization"]["speedtest_error"] = "error";
        $_MAG_DATA["get_localization"]["speedtest_waiting"] = "waiting...";
        $_MAG_DATA["get_localization"]["lan_up"] = "UP";
        $_MAG_DATA["get_localization"]["lan_down"] = "DOWN";
        $_MAG_DATA["get_localization"]["download_stopped"] = "stopped";
        $_MAG_DATA["get_localization"]["download_waiting_queue"] = "waiting queue";
        $_MAG_DATA["get_localization"]["download_running"] = "running";
        $_MAG_DATA["get_localization"]["download_completed"] = "completed";
        $_MAG_DATA["get_localization"]["download_temporary_error"] = "temporary error";
        $_MAG_DATA["get_localization"]["download_permanent_error"] = "permanent error";
        $_MAG_DATA["get_localization"]["auth_title"] = "Authentication";
        $_MAG_DATA["get_localization"]["auth_login"] = "Login";
        $_MAG_DATA["get_localization"]["auth_password"] = "Password";
        $_MAG_DATA["get_localization"]["auth_error"] = "Error";
        $_MAG_DATA["get_localization"]["play_or_download"] = "Play this url or start download?";
        $_MAG_DATA["get_localization"]["player_play"] = "Play";
        $_MAG_DATA["get_localization"]["player_download"] = "Download";
        $_MAG_DATA["get_localization"]["play_all"] = "Play all";
        $_MAG_DATA["get_localization"]["on"] = "on";
        $_MAG_DATA["get_localization"]["off"] = "off";
        $_MAG_DATA["get_localization"]["smb_auth"] = "Network authentication";
        $_MAG_DATA["get_localization"]["smb_username"] = "Login";
        $_MAG_DATA["get_localization"]["smb_password"] = "Password";
        $_MAG_DATA["get_localization"]["exit_title"] = "Do you really want to exit?";
        $_MAG_DATA["get_localization"]["identical_download_exist"] = "There is an active downloads from this server";
        $_MAG_DATA["get_localization"]["alert_form_title"] = "Alert";
        $_MAG_DATA["get_localization"]["confirm_form_title"] = "Confirm";
        $_MAG_DATA["get_localization"]["notice_form_title"] = "Notice";
        $_MAG_DATA["get_localization"]["select_form_title"] = "Select";
        $_MAG_DATA["get_localization"]["media_favorites"] = "Favorites";
        $_MAG_DATA["get_localization"]["stb_type_not_supported"] = "Your STB is not supported";
        $_MAG_DATA["get_localization"]["Phone"] = "Phone";
        $_MAG_DATA["get_localization"]["Tariff plan"] = "Tariff plan";
        $_MAG_DATA["get_localization"]["User"] = "User";
        $_MAG_DATA["get_localization"]["SERVICES MANAGEMENT"] = "SERVICES MANAGEMENT";
        $_MAG_DATA["get_localization"]["SUBSCRIBE"] = "SUBSCRIBE";
        $_MAG_DATA["get_localization"]["UNSUBSCRIBE"] = "UNSUBSCRIBE";
        $_MAG_DATA["get_localization"]["package_info_title"] = "PACKAGE INFO";
        $_MAG_DATA["get_localization"]["package_type"] = "Type";
        $_MAG_DATA["get_localization"]["package_content"] = "Content";
        $_MAG_DATA["get_localization"]["package_description"] = "Description";
        $_MAG_DATA["get_localization"]["confirm_service_subscribe_text"] = "Are you really want to subscribe to this service?";
        $_MAG_DATA["get_localization"]["confirm_service_unsubscribe_text"] = "Are you really want to unsubscribe from this service?";
        $_MAG_DATA["get_localization"]["confirm_service_price_text"] = "The service costs {0}";
        $_MAG_DATA["get_localization"]["service_subscribe_success"] = "You have successfully subscribed to the service.";
        $_MAG_DATA["get_localization"]["service_unsubscribe_success"] = "You have successfully unsubscribed from the service.";
        $_MAG_DATA["get_localization"]["service_subscribe_success_reboot"] = "You have successfully subscribed to the service.  STB will be rebooted.";
        $_MAG_DATA["get_localization"]["service_unsubscribe_success_reboot"] = "You have successfully unsubscribed from the service. STB will be rebooted.";
        $_MAG_DATA["get_localization"]["service_subscribe_fail"] = "An error in the management of subscriptions.";
        $_MAG_DATA["get_localization"]["service_subscribe_server_error"] = "Server error. Try again later.";
        $_MAG_DATA["get_localization"]["package_price_measurement"] = "UAH";
        $_MAG_DATA["get_localization"]["rent_movie_text"] = "Do you really want to rent this movie?";
        $_MAG_DATA["get_localization"]["rent_movie_price_text"] = "The movie costs {0}";
        $_MAG_DATA["get_localization"]["rent_duration_text"] = "Rent duration: {0}h";
        $_MAG_DATA["get_localization"]["Account number"] = "Account number";
        $_MAG_DATA["get_localization"]["End date"] = "End date";
        $_MAG_DATA["get_localization"]["3D mode"] = "3D mode";
        $_MAG_DATA["get_localization"]["mode {0}"] = "mode {0}";
        $_MAG_DATA["get_localization"]["no epg"] = "no epg";
        $_MAG_DATA["get_localization"]["wrong epg"] = "wrong epg";
        $_MAG_DATA["get_localization"]["iso_title"] = "Title";
        $_MAG_DATA["get_localization"]["error_channel_nothing_to_play"] = "Channel not available";
        $_MAG_DATA["get_localization"]["error_channel_limit"] = "Channel temporary unavailable";
        $_MAG_DATA["get_localization"]["error_channel_not_available_for_zone"] = "Channel not available for this region";
        $_MAG_DATA["get_localization"]["error_channel_link_fault"] = "Channel not available. Server error.";
        $_MAG_DATA["get_localization"]["error_channel_access_denied"] = "Access denied";
        $_MAG_DATA["get_localization"]["blocking_account_info"] = "Account info";
        $_MAG_DATA["get_localization"]["blocking_account_payment"] = "Payment";
        $_MAG_DATA["get_localization"]["blocking_account_reboot"] = "Reload portal";
        $_MAG_DATA["get_localization"]["archive_continue_playing_text"] = "Continue playing?";
        $_MAG_DATA["get_localization"]["archive_yes"] = "YES";
        $_MAG_DATA["get_localization"]["archive_no"] = "NO";
        $_MAG_DATA["get_localization"]["time_shift_exit_confirm_text"] = "Do you want to quit the Time Shift mode?";
        $_MAG_DATA["get_localization"]["mbrowser_sort_by_name"] = "by name";
        $_MAG_DATA["get_localization"]["mbrowser_sort_by_date"] = "by date";
        $_MAG_DATA["get_localization"]["Connection problem"] = "Connection problem";
        $_MAG_DATA["get_localization"]["Authentication problem"] = "Authentication problem";
        $_MAG_DATA["get_localization"]["Account balance"] = "Account balance";
        $_MAG_DATA["get_localization"]["remote_pvr_confirm_text"] = "Start recording on the server?";
        $_MAG_DATA["get_localization"]["remote_deferred_pvr_confirm_text"] = "Do you really want to schedule a recording on the server?";
        $_MAG_DATA["get_localization"]["pvr_target_select_text"] = "Select where to save the record";
        $_MAG_DATA["get_localization"]["usb_target_btn"] = "USB Storage";
        $_MAG_DATA["get_localization"]["server_target_btn"] = "Server";
        $_MAG_DATA["get_localization"]["save_path"] = "Path";
        $_MAG_DATA["get_localization"]["file_name"] = "Filename";
        $_MAG_DATA["get_localization"]["usb_device"] = "USB Device";
        $_MAG_DATA["get_localization"]["rec_stop_msg"] = "Stopped recording â€” {0} on channel {1}";
        $_MAG_DATA["get_localization"]["rec_file_missing"] = "The recorded file is missing";
        $_MAG_DATA["get_localization"]["rec_not_ended"] = "Recording is not finished yet";
        $_MAG_DATA["get_localization"]["rec_channel_has_scheduled_recording"] = "The channel already has a scheduled recording";
        $_MAG_DATA["get_localization"]["pvr_error_wrong_param"] = "PVR Error: Wrong parameter";
        $_MAG_DATA["get_localization"]["pvr_error_memory"] = "PVR Error: Not enough memory to complete the operation";
        $_MAG_DATA["get_localization"]["pvr_error_duration"] = "PVR Error: Incorrect recording range";
        $_MAG_DATA["get_localization"]["pvr_error_not_found"] = "PVR Error: Task not found";
        $_MAG_DATA["get_localization"]["pvr_error_wrong_filename"] = "PVR Error: Wrong filename";
        $_MAG_DATA["get_localization"]["pvr_error_record_exist"] = "PVR Error: Record file already exists";
        $_MAG_DATA["get_localization"]["pvr_error_url_open_error"] = "PVR Error: Error opening channel URL";
        $_MAG_DATA["get_localization"]["pvr_error_file_open_error"] = "PVR Error: Error opening file";
        $_MAG_DATA["get_localization"]["pvr_error_rec_limit"] = "PVR Error: Exceeded the maximum number simultaneous recordings";
        $_MAG_DATA["get_localization"]["pvr_error_end_of_stream"] = "PVR Error: End of stream";
        $_MAG_DATA["get_localization"]["pvr_error_file_write_error"] = "PVR Error: Error writing to file";
        $_MAG_DATA["get_localization"]["pvr_start_time"] = "Start time";
        $_MAG_DATA["get_localization"]["pvr_end_time"] = "End time";
        $_MAG_DATA["get_localization"]["pvr_duration"] = "Duration";
        $_MAG_DATA["get_localization"]["rec_options_form_title"] = "Recording";
        $_MAG_DATA["get_localization"]["local_pvr_interrupted"] = "Recording on USB device interrupted";
        $_MAG_DATA["get_localization"]["parent_password_error"] = "Wrong";
        $_MAG_DATA["get_localization"]["parent_password_title"] = "Parent control";
        $_MAG_DATA["get_localization"]["password_label"] = "Password";
        $_MAG_DATA["get_localization"]["encoding_label"] = "Encoding";
        $_MAG_DATA["get_localization"]["network_folder"] = "Network folder";
        $_MAG_DATA["get_localization"]["server_ip"] = "IP address";
        $_MAG_DATA["get_localization"]["server_path"] = "Path";
        $_MAG_DATA["get_localization"]["local_folder"] = "Local folder";
        $_MAG_DATA["get_localization"]["server_type"] = "Type";
        $_MAG_DATA["get_localization"]["server_login"] = "Login";
        $_MAG_DATA["get_localization"]["server_password"] = "Password";
        $_MAG_DATA["get_localization"]["add_folder"] = "ADD";
        $_MAG_DATA["get_localization"]["server_ip_placeholder"] = "Server address";
        $_MAG_DATA["get_localization"]["server_path_placeholder"] = "Path to the folder";
        $_MAG_DATA["get_localization"]["local_folder_placeholder"] = "Folder name in favorites";
        $_MAG_DATA["get_localization"]["error"] = "error";
        $_MAG_DATA["get_localization"]["mount_failed"] = "Mount failed";
        $_MAG_DATA["get_localization"]["ad_skip"] = "SKIP";
        $_MAG_DATA["get_localization"]["commercial"] = "COMMERCIAL";
        $_MAG_DATA["get_localization"]["videoClockTitle"] = "Clock";
        $_MAG_DATA["get_localization"]["videoClock_off"] = "Hidden";
        $_MAG_DATA["get_localization"]["videoClock_upRight"] = "Top Right";
        $_MAG_DATA["get_localization"]["videoClock_upLeft"] = "Top Left";
        $_MAG_DATA["get_localization"]["videoClock_downRight"] = "Bottom Right";
        $_MAG_DATA["get_localization"]["videoClock_downLeft"] = "Bottom Left";
        $_MAG_DATA["get_localization"]["settings_unavailable"] = "Settings section is currently unavailable";
        $_MAG_DATA["get_localization"]["no_dvb_channels_title"] = "No channels available";
        $_MAG_DATA["get_localization"]["go_to_dvb_settings"] = "You can configure DVB channels in the settings menu";
        $_MAG_DATA["get_localization"]["apps_title"] = "Applications";
        $_MAG_DATA["get_localization"]["coming_soon_video"] = "Video will be available soon";
        $_MAG_DATA["get_profile"]["name"] = "";
        $_MAG_DATA["get_profile"]["sname"] = "";
        $_MAG_DATA["get_profile"]["pass"] = "";
        $_MAG_DATA["get_profile"]["additional_services_on"] = "";
        $_MAG_DATA["get_profile"]["operator_id"] = "0";
        $_MAG_DATA["get_profile"]["storage_name"] = "";
        $_MAG_DATA["get_profile"]["phone"] = "";
        $_MAG_DATA["get_profile"]["tv_quality"] = "high";
        $_MAG_DATA["get_profile"]["fname"] = "nets";
        $_MAG_DATA["get_profile"]["login"] = "";
        $_MAG_DATA["get_profile"]["password"] = "";
        $_MAG_DATA["get_profile"]["num_banks"] = "0";
        $_MAG_DATA["get_profile"]["tariff_plan_id"] = "1";
        $_MAG_DATA["get_profile"]["comment"] = "";
        $_MAG_DATA["get_profile"]["now_playing_link_id"] = "0";
        $_MAG_DATA["get_profile"]["now_playing_streamer_id"] = "0";
        $_MAG_DATA["get_profile"]["just_started"] = "1";
        $_MAG_DATA["get_profile"]["verified"] = "0";
        $_MAG_DATA["get_profile"]["pri_audio_lang"] = "";
        $_MAG_DATA["get_profile"]["sec_audio_lang"] = "";
        $_MAG_DATA["get_profile"]["pri_subtitle_lang"] = "";
        $_MAG_DATA["get_profile"]["sec_subtitle_lang"] = "";
        $_MAG_DATA["get_profile"]["hw_version"] = "undefined";
        $_MAG_DATA["get_profile"]["storages"] = "";
        $_MAG_DATA["get_profile"]["last_itv_id"] = "1";
        $_MAG_DATA["get_profile"]["updated"] = "";
        $_MAG_DATA["get_profile"]["web_proxy_host"] = "";
        $_MAG_DATA["get_profile"]["web_proxy_port"] = "";
        $_MAG_DATA["get_profile"]["web_proxy_user"] = "";
        $_MAG_DATA["get_profile"]["web_proxy_pass"] = "";
        $_MAG_DATA["get_profile"]["web_proxy_exclude_list"] = "";
        $_MAG_DATA["get_profile"]["demo_video_url"] = "";
        $_MAG_DATA["get_profile"]["tv_quality_filter"] = "";
        $_MAG_DATA["get_profile"]["use_embedded_settings"] = "";
        $_MAG_DATA["get_profile"]["is_moderator"] = "";
        $_MAG_DATA["get_profile"]["timeslot_ratio"] = "0.94530244530245";
        $_MAG_DATA["get_profile"]["timeslot"] = "113.43629343629";
        $_MAG_DATA["get_profile"]["kinopoisk_rating"] = "1";
        $_MAG_DATA["get_profile"]["enable_tariff_plans"] = "1";
        $_MAG_DATA["get_profile"]["enable_buffering_indication"] = "1";
        $_MAG_DATA["get_profile"]["allowed_stb_types_for_local_recording"] = array("mag245", "mag250", "mag255", "mag270", "mag275", "aurahd");
        $_MAG_DATA["get_profile"]["strict_stb_type_check"] = "";
        $_MAG_DATA["get_profile"]["cas_params"] = "";
        $_MAG_DATA["get_profile"]["enable_hdmi_events_handler"] = "1";
        $_MAG_DATA["get_profile"]["cas_additional_params"] = "";
        $_MAG_DATA["get_profile"]["cas_ini_file"] = "";
        $_MAG_DATA["get_profile"]["logarithm_volume_control"] = "1";
        $_MAG_DATA["get_profile"]["allow_subscription_from_stb"] = "1";
        $_MAG_DATA["get_profile"]["deny_720p_gmode_720_on_mag200"] = "1";
        $_MAG_DATA["get_profile"]["enable_arrow_keys_setpos"] = "1";
        $_MAG_DATA["get_profile"]["show_purchased_filter"] = "";
        $_MAG_DATA["get_profile"]["enable_connection_problem_indication"] = "1";
        $_MAG_DATA["get_profile"]["invert_channel_switch_direction"] = "";
        $_MAG_DATA["get_profile"]["enable_stream_error_logging"] = "";
        $_MAG_DATA["get_profile"]["always_enabled_subtitles"] = "";
        $_MAG_DATA["get_profile"]["enable_service_button"] = "";
        $_MAG_DATA["get_profile"]["show_tv_channel_logo"] = "1";
        $_MAG_DATA["get_profile"]["tv_archive_continued"] = "";
        $_MAG_DATA["get_profile"]["show_tv_only_hd_filter_option"] = "";
        $_MAG_DATA["get_profile"]["tv_playback_retry_limit"] = "3";
        $_MAG_DATA["get_profile"]["fading_tv_retry_timeout"] = "1";
        $_MAG_DATA["get_profile"]["epg_update_time_range"] = "3108";
        $_MAG_DATA["get_profile"]["store_auth_data_on_stb"] = "";
        $_MAG_DATA["get_profile"]["account_page_by_password"] = "";
        $_MAG_DATA["get_profile"]["tester"] = "";
        $_MAG_DATA["get_profile"]["show_channel_logo_in_preview"] = "";
        $_MAG_DATA["get_profile"]["enable_stream_losses_logging"] = "";
        $_MAG_DATA["get_profile"]["external_payment_page_url"] = "";
        $_MAG_DATA["get_profile"]["max_local_recordings"] = "10";
        $_MAG_DATA["gmode_720"][0] = "template/default/i_720/horoscope_menu_button_1_1_b.png";
        $_MAG_DATA["gmode_720"][1] = "template/default/i_720/footer_menu_act.png";
        $_MAG_DATA["gmode_720"][2] = "template/default/i_720/tv_table.png";
        $_MAG_DATA["gmode_720"][3] = "template/default/i_720/dots.png";
        $_MAG_DATA["gmode_720"][4] = "template/default/i_720/mb_table05.png";
        $_MAG_DATA["gmode_720"][5] = "template/default/i_720/1.png";
        $_MAG_DATA["gmode_720"][6] = "template/default/i_720/0.png";
        $_MAG_DATA["gmode_720"][7] = "template/default/i_720/mb_table07.png";
        $_MAG_DATA["gmode_720"][8] = "template/default/i_720/horoscope_menu_button_1_5_a.png";
        $_MAG_DATA["gmode_720"][9] = "template/default/i_720/mm_ico_youtube.png";
        $_MAG_DATA["gmode_720"][10] = "template/default/i_720/25alfa_20.png";
        $_MAG_DATA["gmode_720"][11] = "template/default/i_720/6.png";
        $_MAG_DATA["gmode_720"][12] = "template/default/i_720/osd_bg.png";
        $_MAG_DATA["gmode_720"][13] = "template/default/i_720/_6_lightning.png";
        $_MAG_DATA["gmode_720"][14] = "template/default/i_720/ico_issue.png";
        $_MAG_DATA["gmode_720"][15] = "template/default/i_720/osd_btn.png";
        $_MAG_DATA["gmode_720"][16] = "template/default/i_720/horoscope_menu_button_1_1_a.png";
        $_MAG_DATA["gmode_720"][17] = "template/default/i_720/mm_ico_info.png";
        $_MAG_DATA["gmode_720"][18] = "template/default/i_720/horoscope_menu_button_1_7_b.png";
        $_MAG_DATA["gmode_720"][19] = "template/default/i_720/horoscope_menu_button_1_10_b.png";
        $_MAG_DATA["gmode_720"][20] = "template/default/i_720/mm_vert_cell.png";
        $_MAG_DATA["gmode_720"][21] = "template/default/i_720/mb_scroll.png";
        $_MAG_DATA["gmode_720"][22] = "template/default/i_720/mb_table06.png";
        $_MAG_DATA["gmode_720"][23] = "template/default/i_720/skip.png";
        $_MAG_DATA["gmode_720"][24] = "template/default/i_720/mb_pass_input.png";
        $_MAG_DATA["gmode_720"][25] = "template/default/i_720/mm_ico_account.png";
        $_MAG_DATA["gmode_720"][26] = "template/default/i_720/mm_ico_tv.png";
        $_MAG_DATA["gmode_720"][27] = "template/default/i_720/mb_table_act04.png";
        $_MAG_DATA["gmode_720"][28] = "template/default/i_720/horoscope_menu_button_1_10_a.png";
        $_MAG_DATA["gmode_720"][29] = "template/default/i_720/mb_table04.png";
        $_MAG_DATA["gmode_720"][30] = "template/default/i_720/_3_pasmurno.png";
        $_MAG_DATA["gmode_720"][31] = "template/default/i_720/deg.png";
        $_MAG_DATA["gmode_720"][32] = "template/default/i_720/horoscope_menu_button_1_2_a.png";
        $_MAG_DATA["gmode_720"][33] = "template/default/i_720/v_menu_1b.png";
        $_MAG_DATA["gmode_720"][34] = "template/default/i_720/epg_red_mark.png";
        $_MAG_DATA["gmode_720"][35] = "template/default/i_720/mb_prev_bg.png";
        $_MAG_DATA["gmode_720"][36] = "template/default/i_720/aspect_bg.png";
        $_MAG_DATA["gmode_720"][37] = "template/default/i_720/modal_bg.png";
        $_MAG_DATA["gmode_720"][38] = "template/default/i_720/osd_line_pos.png";
        $_MAG_DATA["gmode_720"][39] = "template/default/i_720/black85.png";
        $_MAG_DATA["gmode_720"][40] = "template/default/i_720/input.png";
        $_MAG_DATA["gmode_720"][41] = "template/default/i_720/input_episode_bg.png";
        $_MAG_DATA["gmode_720"][42] = "template/default/i_720/mb_table_act05.png";
        $_MAG_DATA["gmode_720"][43] = "template/default/i_720/_0_moon.png";
        $_MAG_DATA["gmode_720"][44] = "template/default/i_720/_0_sun.png";
        $_MAG_DATA["gmode_720"][45] = "template/default/i_720/ico_alert.png";
        $_MAG_DATA["gmode_720"][46] = "template/default/i_720/ears.png";
        $_MAG_DATA["gmode_720"][47] = "template/default/i_720/5.png";
        $_MAG_DATA["gmode_720"][48] = "template/default/i_720/1x1.gif";
        $_MAG_DATA["gmode_720"][49] = "template/default/i_720/footer_sidepanel_arr.png";
        $_MAG_DATA["gmode_720"][50] = "template/default/i_720/horoscope_menu_button_1_9_b.png";
        $_MAG_DATA["gmode_720"][51] = "template/default/i_720/mm_ico_internet.png";
        $_MAG_DATA["gmode_720"][52] = "template/default/i_720/mm_hor_left.png";
        $_MAG_DATA["gmode_720"][53] = "template/default/i_720/v_menu_5.png";
        $_MAG_DATA["gmode_720"][54] = "template/default/i_720/ears_arrow_l.png";
        $_MAG_DATA["gmode_720"][55] = "template/default/i_720/footer_sidepanel_line.png";
        $_MAG_DATA["gmode_720"][56] = "template/default/i_720/horoscope_menu_button_1_8_a.png";
        $_MAG_DATA["gmode_720"][57] = "template/default/i_720/_2_cloudy.png";
        $_MAG_DATA["gmode_720"][58] = "template/default/i_720/input_episode.png";
        $_MAG_DATA["gmode_720"][59] = "template/default/i_720/ico_error26.png";
        $_MAG_DATA["gmode_720"][60] = "template/default/i_720/osd_rec.png";
        $_MAG_DATA["gmode_720"][61] = "template/default/i_720/footer_sidepanel_l.png";
        $_MAG_DATA["gmode_720"][62] = "template/default/i_720/mb_quality.png";
        $_MAG_DATA["gmode_720"][63] = "template/default/i_720/footer_search.png";
        $_MAG_DATA["gmode_720"][64] = "template/default/i_720/tv_table_arrows.png";
        $_MAG_DATA["gmode_720"][65] = "template/default/i_720/ears_arrow_r.png";
        $_MAG_DATA["gmode_720"][66] = "template/default/i_720/footer_bg.png";
        $_MAG_DATA["gmode_720"][67] = "template/default/i_720/volume_off.png";
        $_MAG_DATA["gmode_720"][68] = "template/default/i_720/_255_NA.png";
        $_MAG_DATA["gmode_720"][69] = "template/default/i_720/7.png";
        $_MAG_DATA["gmode_720"][70] = "template/default/i_720/mb_icon_rec.png";
        $_MAG_DATA["gmode_720"][71] = "template/default/i_720/mb_icon_scrambled.png";
        $_MAG_DATA["gmode_720"][72] = "template/default/i_720/arr_right.png";
        $_MAG_DATA["gmode_720"][73] = "template/default/i_720/footer_sidepanel_act.png";
        $_MAG_DATA["gmode_720"][74] = "template/default/i_720/mb_table01.png";
        $_MAG_DATA["gmode_720"][75] = "template/default/i_720/tv_table_separator.png";
        $_MAG_DATA["gmode_720"][76] = "template/default/i_720/mm_ico_android.png";
        $_MAG_DATA["gmode_720"][77] = "template/default/i_720/mm_ico_ivi.png";
        $_MAG_DATA["gmode_720"][78] = "template/default/i_720/mm_hor_bg1.png";
        $_MAG_DATA["gmode_720"][79] = "template/default/i_720/mm_ico_usb.png";
        $_MAG_DATA["gmode_720"][80] = "template/default/i_720/mm_ico_pomogator.png";
        $_MAG_DATA["gmode_720"][81] = "template/default/i_720/mm_ico_zoomby.png";
        $_MAG_DATA["gmode_720"][82] = "template/default/i_720/horoscope_menu_button_1_3_b.png";
        $_MAG_DATA["gmode_720"][83] = "template/default/i_720/_1_sun_cl.png";
        $_MAG_DATA["gmode_720"][84] = "template/default/i_720/mm_ico_tvzavr.png";
        $_MAG_DATA["gmode_720"][85] = "template/default/i_720/2.png";
        $_MAG_DATA["gmode_720"][86] = "template/default/i_720/epg_orange_mark.png";
        $_MAG_DATA["gmode_720"][87] = "template/default/i_720/volume_bg.png";
        $_MAG_DATA["gmode_720"][88] = "template/default/i_720/horoscope_menu_button_1_9_a.png";
        $_MAG_DATA["gmode_720"][89] = "template/default/i_720/v_menu_3.png";
        $_MAG_DATA["gmode_720"][90] = "template/default/i_720/horoscope_menu_button_1_6_b.png";
        $_MAG_DATA["gmode_720"][91] = "template/default/i_720/input_act.png";
        $_MAG_DATA["gmode_720"][92] = "template/default/i_720/_7_hail.png";
        $_MAG_DATA["gmode_720"][93] = "template/default/i_720/mm_ico_setting.png";
        $_MAG_DATA["gmode_720"][94] = "template/default/i_720/tv_table_focus.png";
        $_MAG_DATA["gmode_720"][95] = "template/default/i_720/mb_context_bg.png";
        $_MAG_DATA["gmode_720"][96] = "template/default/i_720/mb_filminfo_trans.png";
        $_MAG_DATA["gmode_720"][97] = "template/default/i_720/horoscope_menu_button_1_12_b.png";
        $_MAG_DATA["gmode_720"][98] = "template/default/i_720/mb_table_act02.png";
        $_MAG_DATA["gmode_720"][99] = "template/default/i_720/mm_hor_right.png";
        $_MAG_DATA["gmode_720"][100] = "template/default/i_720/epg_green_mark.png";
        $_MAG_DATA["gmode_720"][101] = "template/default/i_720/v_menu_2b.png";
        $_MAG_DATA["gmode_720"][102] = "template/default/i_720/_1_moon_cl.png";
        $_MAG_DATA["gmode_720"][103] = "template/default/i_720/horoscope_menu_button_1_11_a.png";
        $_MAG_DATA["gmode_720"][104] = "template/default/i_720/footer_sidepanel.png";
        $_MAG_DATA["gmode_720"][105] = "template/default/i_720/v_menu_1a.png";
        $_MAG_DATA["gmode_720"][106] = "template/default/i_720/hr_filminfo.png";
        $_MAG_DATA["gmode_720"][107] = "template/default/i_720/horoscope_menu_button_1_5_b.png";
        $_MAG_DATA["gmode_720"][108] = "template/default/i_720/horoscope_menu_button_1_2_b.png";
        $_MAG_DATA["gmode_720"][109] = "template/default/i_720/mm_hor_bg3.png";
        $_MAG_DATA["gmode_720"][110] = "template/default/i_720/horoscope_menu_button_1_6_a.png";
        $_MAG_DATA["gmode_720"][111] = "template/default/i_720/mm_ico_ex.png";
        $_MAG_DATA["gmode_720"][112] = "template/default/i_720/item_bg.png";
        $_MAG_DATA["gmode_720"][113] = "template/default/i_720/footer_bg2.png";
        $_MAG_DATA["gmode_720"][114] = "template/default/i_720/horoscope_menu_button_1_3_a.png";
        $_MAG_DATA["gmode_720"][115] = "template/default/i_720/low_q.png";
        $_MAG_DATA["gmode_720"][116] = "template/default/i_720/8.png";
        $_MAG_DATA["gmode_720"][117] = "template/default/i_720/4.png";
        $_MAG_DATA["gmode_720"][118] = "template/default/i_720/horoscope_menu_button_1_4_b.png";
        $_MAG_DATA["gmode_720"][119] = "template/default/i_720/mm_ico_apps.png";
        $_MAG_DATA["gmode_720"][120] = "template/default/i_720/mm_ico_megogo.png";
        $_MAG_DATA["gmode_720"][121] = "template/default/i_720/footer_btn.png";
        $_MAG_DATA["gmode_720"][122] = "template/default/i_720/mb_scroll_bg.png";
        $_MAG_DATA["gmode_720"][123] = "template/default/i_720/bg.png";
        $_MAG_DATA["gmode_720"][124] = "template/default/i_720/btn2.png";
        $_MAG_DATA["gmode_720"][125] = "template/default/i_720/mb_context_borders.png";
        $_MAG_DATA["gmode_720"][126] = "template/default/i_720/horoscope_menu_button_1_11_b.png";
        $_MAG_DATA["gmode_720"][127] = "template/default/i_720/_10_heavy_snow.png";
        $_MAG_DATA["gmode_720"][128] = "template/default/i_720/mb_icons.png";
        $_MAG_DATA["gmode_720"][129] = "template/default/i_720/3.png";
        $_MAG_DATA["gmode_720"][130] = "template/default/i_720/_5_rain.png";
        $_MAG_DATA["gmode_720"][131] = "template/default/i_720/mb_table_act06.png";
        $_MAG_DATA["gmode_720"][132] = "template/default/i_720/mm_ico_dm.png";
        $_MAG_DATA["gmode_720"][133] = "template/default/i_720/volume_bar.png";
        $_MAG_DATA["gmode_720"][134] = "template/default/i_720/footer_sidepanel_r.png";
        $_MAG_DATA["gmode_720"][135] = "template/default/i_720/ico_confirm.png";
        $_MAG_DATA["gmode_720"][136] = "template/default/i_720/mb_table_act01.png";
        $_MAG_DATA["gmode_720"][137] = "template/default/i_720/footer_menu.png";
        $_MAG_DATA["gmode_720"][138] = "template/default/i_720/ico_info.png";
        $_MAG_DATA["gmode_720"][139] = "template/default/i_720/minus.png";
        $_MAG_DATA["gmode_720"][140] = "template/default/i_720/mm_ico_karaoke.png";
        $_MAG_DATA["gmode_720"][141] = "template/default/i_720/v_menu_2a.png";
        $_MAG_DATA["gmode_720"][142] = "template/default/i_720/_9_snow.png";
        $_MAG_DATA["gmode_720"][143] = "template/default/i_720/mb_table_act03.png";
        $_MAG_DATA["gmode_720"][144] = "template/default/i_720/mm_ico_video.png";
        $_MAG_DATA["gmode_720"][145] = "template/default/i_720/footer_search_act2.png";
        $_MAG_DATA["gmode_720"][146] = "template/default/i_720/input_channel.png";
        $_MAG_DATA["gmode_720"][147] = "template/default/i_720/horoscope_menu_button_1_4_a.png";
        $_MAG_DATA["gmode_720"][148] = "template/default/i_720/osd_time.png";
        $_MAG_DATA["gmode_720"][149] = "template/default/i_720/tv_prev_bg.png";
        $_MAG_DATA["gmode_720"][150] = "template/default/i_720/osd_line.png";
        $_MAG_DATA["gmode_720"][151] = "template/default/i_720/horoscope_menu_button_1_7_a.png";
        $_MAG_DATA["gmode_720"][152] = "template/default/i_720/9.png";
        $_MAG_DATA["gmode_720"][153] = "template/default/i_720/mb_table03.png";
        $_MAG_DATA["gmode_720"][154] = "template/default/i_720/pause_btn.png";
        $_MAG_DATA["gmode_720"][155] = "template/default/i_720/input_channel_bg.png";
        $_MAG_DATA["gmode_720"][156] = "template/default/i_720/mb_pass_bg.png";
        $_MAG_DATA["gmode_720"][157] = "template/default/i_720/mm_hor_bg2.png";
        $_MAG_DATA["gmode_720"][158] = "template/default/i_720/loading.png";
        $_MAG_DATA["gmode_720"][159] = "template/default/i_720/_4_short_rain.png";
        $_MAG_DATA["gmode_720"][160] = "template/default/i_720/v_menu_4.png";
        $_MAG_DATA["gmode_720"][161] = "template/default/i_720/arr_left.png";
        $_MAG_DATA["gmode_720"][162] = "template/default/i_720/horoscope_menu_button_1_8_b.png";
        $_MAG_DATA["gmode_720"][163] = "template/default/i_720/mb_table02.png";
        $_MAG_DATA["gmode_720"][164] = "template/default/i_720/bg2.png";
        $_MAG_DATA["gmode_720"][165] = "template/default/i_720/mm_ico_radio.png";
        $_MAG_DATA["gmode_720"][166] = "template/default/i_720/mm_ico_vidimax.png";
        $_MAG_DATA["gmode_720"][167] = "template/default/i_720/mb_player.png";
        $_MAG_DATA["gmode_720"][168] = "template/default/i_720/_8_rain_swon.png";
        $_MAG_DATA["gmode_720"][169] = "template/default/i_720/loading_bg.gif";
        $_MAG_DATA["gmode_720"][170] = "template/default/i_720/plus.png";
        $_MAG_DATA["gmode_720"][171] = "template/default/i_720/footer_search_act.png";
        $_MAG_DATA["gmode_720"][172] = "template/default/i_720/vol_1.png";
        $_MAG_DATA["gmode_720"][173] = "template/default/i_720/mm_ico_oll.png";
        $_MAG_DATA["gmode_720"][174] = "template/default/i_720/horoscope_menu_button_1_12_a.png";
        $_MAG_DATA["gmode_480"][0] = "template/default/i_480/horoscope_menu_button_1_1_b.png";
        $_MAG_DATA["gmode_480"][1] = "template/default/i_480/footer_menu_act.png";
        $_MAG_DATA["gmode_480"][2] = "template/default/i_480/tv_table.png";
        $_MAG_DATA["gmode_480"][3] = "template/default/i_480/dots.png";
        $_MAG_DATA["gmode_480"][4] = "template/default/i_480/ears2.png";
        $_MAG_DATA["gmode_480"][5] = "template/default/i_480/1.png";
        $_MAG_DATA["gmode_480"][6] = "template/default/i_480/0.png";
        $_MAG_DATA["gmode_480"][7] = "template/default/i_480/w_snow.png";
        $_MAG_DATA["gmode_480"][8] = "template/default/i_480/horoscope_menu_button_1_5_a.png";
        $_MAG_DATA["gmode_480"][9] = "template/default/i_480/mm_ico_youtube.png";
        $_MAG_DATA["gmode_480"][10] = "template/default/i_480/25alfa_20.png";
        $_MAG_DATA["gmode_480"][11] = "template/default/i_480/6.png";
        $_MAG_DATA["gmode_480"][12] = "template/default/i_480/osd_bg.png";
        $_MAG_DATA["gmode_480"][13] = "template/default/i_480/_6_lightning.png";
        $_MAG_DATA["gmode_480"][14] = "template/default/i_480/ico_issue.png";
        $_MAG_DATA["gmode_480"][15] = "template/default/i_480/osd_btn.png";
        $_MAG_DATA["gmode_480"][16] = "template/default/i_480/horoscope_menu_button_1_1_a.png";
        $_MAG_DATA["gmode_480"][17] = "template/default/i_480/mm_ico_info.png";
        $_MAG_DATA["gmode_480"][18] = "template/default/i_480/horoscope_menu_button_1_7_b.png";
        $_MAG_DATA["gmode_480"][19] = "template/default/i_480/horoscope_menu_button_1_10_b.png";
        $_MAG_DATA["gmode_480"][20] = "template/default/i_480/mm_vert_cell.png";
        $_MAG_DATA["gmode_480"][21] = "template/default/i_480/mb_scroll.png";
        $_MAG_DATA["gmode_480"][22] = "template/default/i_480/skip.png";
        $_MAG_DATA["gmode_480"][23] = "template/default/i_480/mb_pass_input.png";
        $_MAG_DATA["gmode_480"][24] = "template/default/i_480/mm_ico_account.png";
        $_MAG_DATA["gmode_480"][25] = "template/default/i_480/mm_ico_tv.png";
        $_MAG_DATA["gmode_480"][26] = "template/default/i_480/horoscope_menu_button_1_10_a.png";
        $_MAG_DATA["gmode_480"][27] = "template/default/i_480/w_thunderstorm.png";
        $_MAG_DATA["gmode_480"][28] = "template/default/i_480/w_moon.png";
        $_MAG_DATA["gmode_480"][29] = "template/default/i_480/_3_pasmurno.png";
        $_MAG_DATA["gmode_480"][30] = "template/default/i_480/deg.png";
        $_MAG_DATA["gmode_480"][31] = "template/default/i_480/horoscope_menu_button_1_2_a.png";
        $_MAG_DATA["gmode_480"][32] = "template/default/i_480/v_menu_1b.png";
        $_MAG_DATA["gmode_480"][33] = "template/default/i_480/epg_red_mark.png";
        $_MAG_DATA["gmode_480"][34] = "template/default/i_480/weather.png";
        $_MAG_DATA["gmode_480"][35] = "template/default/i_480/mb_prev_bg.png";
        $_MAG_DATA["gmode_480"][36] = "template/default/i_480/aspect_bg.png";
        $_MAG_DATA["gmode_480"][37] = "template/default/i_480/modal_bg.png";
        $_MAG_DATA["gmode_480"][38] = "template/default/i_480/osd_line_pos.png";
        $_MAG_DATA["gmode_480"][39] = "template/default/i_480/mm_vert_border.png";
        $_MAG_DATA["gmode_480"][40] = "template/default/i_480/black85.png";
        $_MAG_DATA["gmode_480"][41] = "template/default/i_480/input.png";
        $_MAG_DATA["gmode_480"][42] = "template/default/i_480/input_episode_bg.png";
        $_MAG_DATA["gmode_480"][43] = "template/default/i_480/w_cloud_big.png";
        $_MAG_DATA["gmode_480"][44] = "template/default/i_480/_0_moon.png";
        $_MAG_DATA["gmode_480"][45] = "template/default/i_480/_0_sun.png";
        $_MAG_DATA["gmode_480"][46] = "template/default/i_480/ico_alert.png";
        $_MAG_DATA["gmode_480"][47] = "template/default/i_480/ears.png";
        $_MAG_DATA["gmode_480"][48] = "template/default/i_480/5.png";
        $_MAG_DATA["gmode_480"][49] = "template/default/i_480/1x1.gif";
        $_MAG_DATA["gmode_480"][50] = "template/default/i_480/footer_sidepanel_arr.png";
        $_MAG_DATA["gmode_480"][51] = "template/default/i_480/horoscope_menu_button_1_9_b.png";
        $_MAG_DATA["gmode_480"][52] = "template/default/i_480/menu_item_img_1.png";
        $_MAG_DATA["gmode_480"][53] = "template/default/i_480/w_empty.png";
        $_MAG_DATA["gmode_480"][54] = "template/default/i_480/mm_ico_internet.png";
        $_MAG_DATA["gmode_480"][55] = "template/default/i_480/mm_hor_left.png";
        $_MAG_DATA["gmode_480"][56] = "template/default/i_480/v_menu_5.png";
        $_MAG_DATA["gmode_480"][57] = "template/default/i_480/ears_arrow_l.png";
        $_MAG_DATA["gmode_480"][58] = "template/default/i_480/footer_sidepanel_line.png";
        $_MAG_DATA["gmode_480"][59] = "template/default/i_480/horoscope_menu_button_1_8_a.png";
        $_MAG_DATA["gmode_480"][60] = "template/default/i_480/_2_cloudy.png";
        $_MAG_DATA["gmode_480"][61] = "template/default/i_480/input_episode.png";
        $_MAG_DATA["gmode_480"][62] = "template/default/i_480/ico_error26.png";
        $_MAG_DATA["gmode_480"][63] = "template/default/i_480/mb_table.png";
        $_MAG_DATA["gmode_480"][64] = "template/default/i_480/osd_rec.png";
        $_MAG_DATA["gmode_480"][65] = "template/default/i_480/footer_sidepanel_l.png";
        $_MAG_DATA["gmode_480"][66] = "template/default/i_480/mb_quality.png";
        $_MAG_DATA["gmode_480"][67] = "template/default/i_480/footer_search.png";
        $_MAG_DATA["gmode_480"][68] = "template/default/i_480/tv_table_arrows.png";
        $_MAG_DATA["gmode_480"][69] = "template/default/i_480/ears_arrow_r.png";
        $_MAG_DATA["gmode_480"][70] = "template/default/i_480/footer_bg.png";
        $_MAG_DATA["gmode_480"][71] = "template/default/i_480/w_cloud_black.png";
        $_MAG_DATA["gmode_480"][72] = "template/default/i_480/volume_off.png";
        $_MAG_DATA["gmode_480"][73] = "template/default/i_480/_255_NA.png";
        $_MAG_DATA["gmode_480"][74] = "template/default/i_480/7.png";
        $_MAG_DATA["gmode_480"][75] = "template/default/i_480/mb_icon_rec.png";
        $_MAG_DATA["gmode_480"][76] = "template/default/i_480/mb_icon_scrambled.png";
        $_MAG_DATA["gmode_480"][77] = "template/default/i_480/arr_right.png";
        $_MAG_DATA["gmode_480"][78] = "template/default/i_480/footer_sidepanel_act.png";
        $_MAG_DATA["gmode_480"][79] = "template/default/i_480/w_rain_strong.png";
        $_MAG_DATA["gmode_480"][80] = "template/default/i_480/tv_table_separator.png";
        $_MAG_DATA["gmode_480"][81] = "template/default/i_480/mm_ico_ivi.png";
        $_MAG_DATA["gmode_480"][82] = "template/default/i_480/mm_hor_bg1.png";
        $_MAG_DATA["gmode_480"][83] = "template/default/i_480/mm_ico_usb.png";
        $_MAG_DATA["gmode_480"][84] = "template/default/i_480/vol_2.png";
        $_MAG_DATA["gmode_480"][85] = "template/default/i_480/mm_ico_pomogator.png";
        $_MAG_DATA["gmode_480"][86] = "template/default/i_480/mm_ico_zoomby.png";
        $_MAG_DATA["gmode_480"][87] = "template/default/i_480/horoscope_menu_button_1_3_b.png";
        $_MAG_DATA["gmode_480"][88] = "template/default/i_480/_1_sun_cl.png";
        $_MAG_DATA["gmode_480"][89] = "template/default/i_480/mm_ico_tvzavr.png";
        $_MAG_DATA["gmode_480"][90] = "template/default/i_480/2.png";
        $_MAG_DATA["gmode_480"][91] = "template/default/i_480/epg_orange_mark.png";
        $_MAG_DATA["gmode_480"][92] = "template/default/i_480/volume_bg.png";
        $_MAG_DATA["gmode_480"][93] = "template/default/i_480/horoscope_menu_button_1_9_a.png";
        $_MAG_DATA["gmode_480"][94] = "template/default/i_480/v_menu_3.png";
        $_MAG_DATA["gmode_480"][95] = "template/default/i_480/horoscope_menu_button_1_6_b.png";
        $_MAG_DATA["gmode_480"][96] = "template/default/i_480/input_act.png";
        $_MAG_DATA["gmode_480"][97] = "template/default/i_480/mb_context_btn.png";
        $_MAG_DATA["gmode_480"][98] = "template/default/i_480/_7_hail.png";
        $_MAG_DATA["gmode_480"][99] = "template/default/i_480/mm_ico_setting.png";
        $_MAG_DATA["gmode_480"][100] = "template/default/i_480/tv_table_focus.png";
        $_MAG_DATA["gmode_480"][101] = "template/default/i_480/mb_context_bg.png";
        $_MAG_DATA["gmode_480"][102] = "template/default/i_480/mb_filminfo_trans.png";
        $_MAG_DATA["gmode_480"][103] = "template/default/i_480/mb_icons2.png";
        $_MAG_DATA["gmode_480"][104] = "template/default/i_480/mm_menu_vert.png";
        $_MAG_DATA["gmode_480"][105] = "template/default/i_480/horoscope_menu_button_1_12_b.png";
        $_MAG_DATA["gmode_480"][106] = "template/default/i_480/mm_hor_right.png";
        $_MAG_DATA["gmode_480"][107] = "template/default/i_480/epg_green_mark.png";
        $_MAG_DATA["gmode_480"][108] = "template/default/i_480/w_rain.png";
        $_MAG_DATA["gmode_480"][109] = "template/default/i_480/v_menu_2b.png";
        $_MAG_DATA["gmode_480"][110] = "template/default/i_480/_1_moon_cl.png";
        $_MAG_DATA["gmode_480"][111] = "template/default/i_480/horoscope_menu_button_1_11_a.png";
        $_MAG_DATA["gmode_480"][112] = "template/default/i_480/footer_sidepanel.png";
        $_MAG_DATA["gmode_480"][113] = "template/default/i_480/v_menu_1a.png";
        $_MAG_DATA["gmode_480"][114] = "template/default/i_480/hr_filminfo.png";
        $_MAG_DATA["gmode_480"][115] = "template/default/i_480/horoscope_menu_button_1_5_b.png";
        $_MAG_DATA["gmode_480"][116] = "template/default/i_480/horoscope_menu_button_1_2_b.png";
        $_MAG_DATA["gmode_480"][117] = "template/default/i_480/mm_hor_bg3.png";
        $_MAG_DATA["gmode_480"][118] = "template/default/i_480/horoscope_menu_button_1_6_a.png";
        $_MAG_DATA["gmode_480"][119] = "template/default/i_480/mm_ico_ex.png";
        $_MAG_DATA["gmode_480"][120] = "template/default/i_480/item_bg.png";
        $_MAG_DATA["gmode_480"][121] = "template/default/i_480/footer_bg2.png";
        $_MAG_DATA["gmode_480"][122] = "template/default/i_480/horoscope_menu_button_1_3_a.png";
        $_MAG_DATA["gmode_480"][123] = "template/default/i_480/low_q.png";
        $_MAG_DATA["gmode_480"][124] = "template/default/i_480/8.png";
        $_MAG_DATA["gmode_480"][125] = "template/default/i_480/4.png";
        $_MAG_DATA["gmode_480"][126] = "template/default/i_480/horoscope_menu_button_1_4_b.png";
        $_MAG_DATA["gmode_480"][127] = "template/default/i_480/mm_menu_hor.png";
        $_MAG_DATA["gmode_480"][128] = "template/default/i_480/mm_ico_megogo.png";
        $_MAG_DATA["gmode_480"][129] = "template/default/i_480/footer_btn.png";
        $_MAG_DATA["gmode_480"][130] = "template/default/i_480/mb_scroll_bg.png";
        $_MAG_DATA["gmode_480"][131] = "template/default/i_480/bg.png";
        $_MAG_DATA["gmode_480"][132] = "template/default/i_480/w_snow_strong.png";
        $_MAG_DATA["gmode_480"][133] = "template/default/i_480/btn2.png";
        $_MAG_DATA["gmode_480"][134] = "template/default/i_480/mb_table_act.png";
        $_MAG_DATA["gmode_480"][135] = "template/default/i_480/prev_img.jpg";
        $_MAG_DATA["gmode_480"][136] = "template/default/i_480/mb_context_borders.png";
        $_MAG_DATA["gmode_480"][137] = "template/default/i_480/horoscope_menu_button_1_11_b.png";
        $_MAG_DATA["gmode_480"][138] = "template/default/i_480/w_sun.png";
        $_MAG_DATA["gmode_480"][139] = "template/default/i_480/_10_heavy_snow.png";
        $_MAG_DATA["gmode_480"][140] = "template/default/i_480/mb_icons.png";
        $_MAG_DATA["gmode_480"][141] = "template/default/i_480/3.png";
        $_MAG_DATA["gmode_480"][142] = "template/default/i_480/_5_rain.png";
        $_MAG_DATA["gmode_480"][143] = "template/default/i_480/mb_table_act06.png";
        $_MAG_DATA["gmode_480"][144] = "template/default/i_480/mm_ico_dm.png";
        $_MAG_DATA["gmode_480"][145] = "template/default/i_480/volume_bar.png";
        $_MAG_DATA["gmode_480"][146] = "template/default/i_480/footer_sidepanel_r.png";
        $_MAG_DATA["gmode_480"][147] = "template/default/i_480/ico_confirm.png";
        $_MAG_DATA["gmode_480"][148] = "template/default/i_480/footer_menu.png";
        $_MAG_DATA["gmode_480"][149] = "template/default/i_480/ico_info.png";
        $_MAG_DATA["gmode_480"][150] = "template/default/i_480/minus.png";
        $_MAG_DATA["gmode_480"][151] = "template/default/i_480/mm_ico_karaoke.png";
        $_MAG_DATA["gmode_480"][152] = "template/default/i_480/v_menu_2a.png";
        $_MAG_DATA["gmode_480"][153] = "template/default/i_480/_9_snow.png";
        $_MAG_DATA["gmode_480"][154] = "template/default/i_480/mm_ico_video.png";
        $_MAG_DATA["gmode_480"][155] = "template/default/i_480/footer_search_act2.png";
        $_MAG_DATA["gmode_480"][156] = "template/default/i_480/input_channel.png";
        $_MAG_DATA["gmode_480"][157] = "template/default/i_480/horoscope_menu_button_1_4_a.png";
        $_MAG_DATA["gmode_480"][158] = "template/default/i_480/w_cloud_small.png";
        $_MAG_DATA["gmode_480"][159] = "template/default/i_480/osd_time.png";
        $_MAG_DATA["gmode_480"][160] = "template/default/i_480/tv_prev_bg.png";
        $_MAG_DATA["gmode_480"][161] = "template/default/i_480/osd_line.png";
        $_MAG_DATA["gmode_480"][162] = "template/default/i_480/footer_search_act_.png";
        $_MAG_DATA["gmode_480"][163] = "template/default/i_480/horoscope_menu_button_1_7_a.png";
        $_MAG_DATA["gmode_480"][164] = "template/default/i_480/9.png";
        $_MAG_DATA["gmode_480"][165] = "template/default/i_480/pause_btn.png";
        $_MAG_DATA["gmode_480"][166] = "template/default/i_480/input_channel_bg.png";
        $_MAG_DATA["gmode_480"][167] = "template/default/i_480/mm_vert_trans.png";
        $_MAG_DATA["gmode_480"][168] = "template/default/i_480/mb_pass_bg.png";
        $_MAG_DATA["gmode_480"][169] = "template/default/i_480/mm_hor_bg2.png";
        $_MAG_DATA["gmode_480"][170] = "template/default/i_480/loading.png";
        $_MAG_DATA["gmode_480"][171] = "template/default/i_480/_4_short_rain.png";
        $_MAG_DATA["gmode_480"][172] = "template/default/i_480/v_menu_4.png";
        $_MAG_DATA["gmode_480"][173] = "template/default/i_480/arr_left.png";
        $_MAG_DATA["gmode_480"][174] = "template/default/i_480/horoscope_menu_button_1_8_b.png";
        $_MAG_DATA["gmode_480"][175] = "template/default/i_480/bg2.png";
        $_MAG_DATA["gmode_480"][176] = "template/default/i_480/mm_ico_radio.png";
        $_MAG_DATA["gmode_480"][177] = "template/default/i_480/mm_ico_vidimax.png";
        $_MAG_DATA["gmode_480"][178] = "template/default/i_480/mb_player.png";
        $_MAG_DATA["gmode_480"][179] = "template/default/i_480/_8_rain_swon.png";
        $_MAG_DATA["gmode_480"][180] = "template/default/i_480/loading_bg.gif";
        $_MAG_DATA["gmode_480"][181] = "template/default/i_480/plus.png";
        $_MAG_DATA["gmode_480"][182] = "template/default/i_480/footer_search_act.png";
        $_MAG_DATA["gmode_480"][183] = "template/default/i_480/vol_1.png";
        $_MAG_DATA["gmode_480"][184] = "template/default/i_480/mm_ico_oll.png";
        $_MAG_DATA["gmode_480"][185] = "template/default/i_480/horoscope_menu_button_1_12_a.png";
        $_MAG_DATA["gmode_default"][0] = "template/default/i/horoscope_menu_button_1_1_b.png";
        $_MAG_DATA["gmode_default"][1] = "template/default/i/footer_menu_act.png";
        $_MAG_DATA["gmode_default"][2] = "template/default/i/tv_table.png";
        $_MAG_DATA["gmode_default"][3] = "template/default/i/mb_table05.png";
        $_MAG_DATA["gmode_default"][4] = "template/default/i/mb_table07.png";
        $_MAG_DATA["gmode_default"][5] = "template/default/i/w_snow.png";
        $_MAG_DATA["gmode_default"][6] = "template/default/i/horoscope_menu_button_1_5_a.png";
        $_MAG_DATA["gmode_default"][7] = "template/default/i/mm_ico_youtube.png";
        $_MAG_DATA["gmode_default"][8] = "template/default/i/25alfa_20.png";
        $_MAG_DATA["gmode_default"][9] = "template/default/i/osd_bg.png";
        $_MAG_DATA["gmode_default"][10] = "template/default/i/_6_lightning.png";
        $_MAG_DATA["gmode_default"][11] = "template/default/i/horoscope_menu_button_1_1_a.png";
        $_MAG_DATA["gmode_default"][12] = "template/default/i/mm_ico_info.png";
        $_MAG_DATA["gmode_default"][13] = "template/default/i/horoscope_menu_button_1_7_b.png";
        $_MAG_DATA["gmode_default"][14] = "template/default/i/horoscope_menu_button_1_10_b.png";
        $_MAG_DATA["gmode_default"][15] = "template/default/i/mm_vert_cell.png";
        $_MAG_DATA["gmode_default"][16] = "template/default/i/mb_scroll.png";
        $_MAG_DATA["gmode_default"][17] = "template/default/i/mb_table06.png";
        $_MAG_DATA["gmode_default"][18] = "template/default/i/skip.png";
        $_MAG_DATA["gmode_default"][19] = "template/default/i/combobox_act.png";
        $_MAG_DATA["gmode_default"][20] = "template/default/i/mb_pass_input.png";
        $_MAG_DATA["gmode_default"][21] = "template/default/i/mm_ico_account.png";
        $_MAG_DATA["gmode_default"][22] = "template/default/i/mm_ico_tv.png";
        $_MAG_DATA["gmode_default"][23] = "template/default/i/mb_table_act04.png";
        $_MAG_DATA["gmode_default"][24] = "template/default/i/horoscope_menu_button_1_10_a.png";
        $_MAG_DATA["gmode_default"][25] = "template/default/i/w_thunderstorm.png";
        $_MAG_DATA["gmode_default"][26] = "template/default/i/mb_table04.png";
        $_MAG_DATA["gmode_default"][27] = "template/default/i/w_moon.png";
        $_MAG_DATA["gmode_default"][28] = "template/default/i/_3_pasmurno.png";
        $_MAG_DATA["gmode_default"][29] = "template/default/i/horoscope_menu_button_1_2_a.png";
        $_MAG_DATA["gmode_default"][30] = "template/default/i/v_menu_1b.png";
        $_MAG_DATA["gmode_default"][31] = "template/default/i/epg_red_mark.png";
        $_MAG_DATA["gmode_default"][32] = "template/default/i/weather.png";
        $_MAG_DATA["gmode_default"][33] = "template/default/i/mb_prev_bg.png";
        $_MAG_DATA["gmode_default"][34] = "template/default/i/aspect_bg.png";
        $_MAG_DATA["gmode_default"][35] = "template/default/i/modal_bg.png";
        $_MAG_DATA["gmode_default"][36] = "template/default/i/osd_line_pos.png";
        $_MAG_DATA["gmode_default"][37] = "template/default/i/mm_vert_border.png";
        $_MAG_DATA["gmode_default"][38] = "template/default/i/black85.png";
        $_MAG_DATA["gmode_default"][39] = "template/default/i/input.png";
        $_MAG_DATA["gmode_default"][40] = "template/default/i/input_episode_bg.png";
        $_MAG_DATA["gmode_default"][41] = "template/default/i/w_cloud_big.png";
        $_MAG_DATA["gmode_default"][42] = "template/default/i/mb_table_act05.png";
        $_MAG_DATA["gmode_default"][43] = "template/default/i/_0_moon.png";
        $_MAG_DATA["gmode_default"][44] = "template/default/i/_0_sun.png";
        $_MAG_DATA["gmode_default"][45] = "template/default/i/ico_alert.png";
        $_MAG_DATA["gmode_default"][46] = "template/default/i/ears.png";
        $_MAG_DATA["gmode_default"][47] = "template/default/i/footer_sidepanel_arr.png";
        $_MAG_DATA["gmode_default"][48] = "template/default/i/horoscope_menu_button_1_9_b.png";
        $_MAG_DATA["gmode_default"][49] = "template/default/i/w_empty.png";
        $_MAG_DATA["gmode_default"][50] = "template/default/i/mm_ico_internet.png";
        $_MAG_DATA["gmode_default"][51] = "template/default/i/mm_hor_left.png";
        $_MAG_DATA["gmode_default"][52] = "template/default/i/v_menu_5.png";
        $_MAG_DATA["gmode_default"][53] = "template/default/i/ears_arrow_l.png";
        $_MAG_DATA["gmode_default"][54] = "template/default/i/footer_sidepanel_line.png";
        $_MAG_DATA["gmode_default"][55] = "template/default/i/horoscope_menu_button_1_8_a.png";
        $_MAG_DATA["gmode_default"][56] = "template/default/i/_2_cloudy.png";
        $_MAG_DATA["gmode_default"][57] = "template/default/i/ico_error26.png";
        $_MAG_DATA["gmode_default"][58] = "template/default/i/osd_rec.png";
        $_MAG_DATA["gmode_default"][59] = "template/default/i/footer_sidepanel_l.png";
        $_MAG_DATA["gmode_default"][60] = "template/default/i/mb_quality.png";
        $_MAG_DATA["gmode_default"][61] = "template/default/i/footer_search.png";
        $_MAG_DATA["gmode_default"][62] = "template/default/i/tv_table_arrows.png";
        $_MAG_DATA["gmode_default"][63] = "template/default/i/ears_arrow_r.png";
        $_MAG_DATA["gmode_default"][64] = "template/default/i/footer_bg.png";
        $_MAG_DATA["gmode_default"][65] = "template/default/i/combobox.png";
        $_MAG_DATA["gmode_default"][66] = "template/default/i/w_cloud_black.png";
        $_MAG_DATA["gmode_default"][67] = "template/default/i/volume_off.png";
        $_MAG_DATA["gmode_default"][68] = "template/default/i/_255_NA.png";
        $_MAG_DATA["gmode_default"][69] = "template/default/i/mb_icon_rec.png";
        $_MAG_DATA["gmode_default"][70] = "template/default/i/mb_icon_scrambled.png";
        $_MAG_DATA["gmode_default"][71] = "template/default/i/arr_right.png";
        $_MAG_DATA["gmode_default"][72] = "template/default/i/footer_sidepanel_act.png";
        $_MAG_DATA["gmode_default"][73] = "template/default/i/mb_table01.png";
        $_MAG_DATA["gmode_default"][74] = "template/default/i/w_rain_strong.png";
        $_MAG_DATA["gmode_default"][75] = "template/default/i/tv_table_separator.png";
        $_MAG_DATA["gmode_default"][76] = "template/default/i/mm_ico_ivi.png";
        $_MAG_DATA["gmode_default"][77] = "template/default/i/mm_hor_bg1.png";
        $_MAG_DATA["gmode_default"][78] = "template/default/i/mm_ico_usb.png";
        $_MAG_DATA["gmode_default"][79] = "template/default/i/mm_ico_pomogator.png";
        $_MAG_DATA["gmode_default"][80] = "template/default/i/mm_ico_zoomby.png";
        $_MAG_DATA["gmode_default"][81] = "template/default/i/horoscope_menu_button_1_3_b.png";
        $_MAG_DATA["gmode_default"][82] = "template/default/i/_1_sun_cl.png";
        $_MAG_DATA["gmode_default"][83] = "template/default/i/mm_ico_tvzavr.png";
        $_MAG_DATA["gmode_default"][84] = "template/default/i/epg_orange_mark.png";
        $_MAG_DATA["gmode_default"][85] = "template/default/i/volume_bg.png";
        $_MAG_DATA["gmode_default"][86] = "template/default/i/horoscope_menu_button_1_9_a.png";
        $_MAG_DATA["gmode_default"][87] = "template/default/i/v_menu_3.png";
        $_MAG_DATA["gmode_default"][88] = "template/default/i/horoscope_menu_button_1_6_b.png";
        $_MAG_DATA["gmode_default"][89] = "template/default/i/input_act.png";
        $_MAG_DATA["gmode_default"][90] = "template/default/i/_7_hail.png";
        $_MAG_DATA["gmode_default"][91] = "template/default/i/mm_ico_setting.png";
        $_MAG_DATA["gmode_default"][92] = "template/default/i/tv_table_focus.png";
        $_MAG_DATA["gmode_default"][93] = "template/default/i/mb_context_bg.png";
        $_MAG_DATA["gmode_default"][94] = "template/default/i/mb_filminfo_trans.png";
        $_MAG_DATA["gmode_default"][95] = "template/default/i/mm_menu_vert.png";
        $_MAG_DATA["gmode_default"][96] = "template/default/i/horoscope_menu_button_1_12_b.png";
        $_MAG_DATA["gmode_default"][97] = "template/default/i/mb_table_act02.png";
        $_MAG_DATA["gmode_default"][98] = "template/default/i/mm_hor_right.png";
        $_MAG_DATA["gmode_default"][99] = "template/default/i/epg_green_mark.png";
        $_MAG_DATA["gmode_default"][100] = "template/default/i/w_rain.png";
        $_MAG_DATA["gmode_default"][101] = "template/default/i/v_menu_2b.png";
        $_MAG_DATA["gmode_default"][102] = "template/default/i/_1_moon_cl.png";
        $_MAG_DATA["gmode_default"][103] = "template/default/i/horoscope_menu_button_1_11_a.png";
        $_MAG_DATA["gmode_default"][104] = "template/default/i/footer_sidepanel.png";
        $_MAG_DATA["gmode_default"][105] = "template/default/i/v_menu_1a.png";
        $_MAG_DATA["gmode_default"][106] = "template/default/i/hr_filminfo.png";
        $_MAG_DATA["gmode_default"][107] = "template/default/i/horoscope_menu_button_1_5_b.png";
        $_MAG_DATA["gmode_default"][108] = "template/default/i/horoscope_menu_button_1_2_b.png";
        $_MAG_DATA["gmode_default"][109] = "template/default/i/mm_hor_bg3.png";
        $_MAG_DATA["gmode_default"][110] = "template/default/i/horoscope_menu_button_1_6_a.png";
        $_MAG_DATA["gmode_default"][111] = "template/default/i/mm_ico_ex.png";
        $_MAG_DATA["gmode_default"][112] = "template/default/i/item_bg.png";
        $_MAG_DATA["gmode_default"][113] = "template/default/i/footer_bg2.png";
        $_MAG_DATA["gmode_default"][114] = "template/default/i/horoscope_menu_button_1_3_a.png";
        $_MAG_DATA["gmode_default"][115] = "template/default/i/low_q.png";
        $_MAG_DATA["gmode_default"][116] = "template/default/i/horoscope_menu_button_1_4_b.png";
        $_MAG_DATA["gmode_default"][117] = "template/default/i/mm_menu_hor.png";
        $_MAG_DATA["gmode_default"][118] = "template/default/i/mm_ico_megogo.png";
        $_MAG_DATA["gmode_default"][119] = "template/default/i/footer_btn.png";
        $_MAG_DATA["gmode_default"][120] = "template/default/i/mb_scroll_bg.png";
        $_MAG_DATA["gmode_default"][121] = "template/default/i/bg.png";
        $_MAG_DATA["gmode_default"][122] = "template/default/i/w_snow_strong.png";
        $_MAG_DATA["gmode_default"][123] = "template/default/i/btn2.png";
        $_MAG_DATA["gmode_default"][124] = "template/default/i/mb_context_borders.png";
        $_MAG_DATA["gmode_default"][125] = "template/default/i/horoscope_menu_button_1_11_b.png";
        $_MAG_DATA["gmode_default"][126] = "template/default/i/w_sun.png";
        $_MAG_DATA["gmode_default"][127] = "template/default/i/_10_heavy_snow.png";
        $_MAG_DATA["gmode_default"][128] = "template/default/i/mb_icons.png";
        $_MAG_DATA["gmode_default"][129] = "template/default/i/_5_rain.png";
        $_MAG_DATA["gmode_default"][130] = "template/default/i/mb_table_act06.png";
        $_MAG_DATA["gmode_default"][131] = "template/default/i/mm_ico_dm.png";
        $_MAG_DATA["gmode_default"][132] = "template/default/i/volume_bar.png";
        $_MAG_DATA["gmode_default"][133] = "template/default/i/footer_sidepanel_r.png";
        $_MAG_DATA["gmode_default"][134] = "template/default/i/ico_confirm.png";
        $_MAG_DATA["gmode_default"][135] = "template/default/i/mb_table_act01.png";
        $_MAG_DATA["gmode_default"][136] = "template/default/i/footer_menu.png";
        $_MAG_DATA["gmode_default"][137] = "template/default/i/ico_info.png";
        $_MAG_DATA["gmode_default"][138] = "template/default/i/mm_ico_karaoke.png";
        $_MAG_DATA["gmode_default"][139] = "template/default/i/v_menu_2a.png";
        $_MAG_DATA["gmode_default"][140] = "template/default/i/_9_snow.png";
        $_MAG_DATA["gmode_default"][141] = "template/default/i/mb_table_act03.png";
        $_MAG_DATA["gmode_default"][142] = "template/default/i/mm_ico_video.png";
        $_MAG_DATA["gmode_default"][143] = "template/default/i/footer_search_act2.png";
        $_MAG_DATA["gmode_default"][144] = "template/default/i/input_channel.png";
        $_MAG_DATA["gmode_default"][145] = "template/default/i/horoscope_menu_button_1_4_a.png";
        $_MAG_DATA["gmode_default"][146] = "template/default/i/w_cloud_small.png";
        $_MAG_DATA["gmode_default"][147] = "template/default/i/osd_time.png";
        $_MAG_DATA["gmode_default"][148] = "template/default/i/tv_prev_bg.png";
        $_MAG_DATA["gmode_default"][149] = "template/default/i/osd_line.png";
        $_MAG_DATA["gmode_default"][150] = "template/default/i/horoscope_menu_button_1_7_a.png";
        $_MAG_DATA["gmode_default"][151] = "template/default/i/mb_table03.png";
        $_MAG_DATA["gmode_default"][152] = "template/default/i/pause_btn.png";
        $_MAG_DATA["gmode_default"][153] = "template/default/i/input_channel_bg.png";
        $_MAG_DATA["gmode_default"][154] = "template/default/i/mm_vert_trans.png";
        $_MAG_DATA["gmode_default"][155] = "template/default/i/mb_pass_bg.png";
        $_MAG_DATA["gmode_default"][156] = "template/default/i/mm_hor_bg2.png";
        $_MAG_DATA["gmode_default"][157] = "template/default/i/loading.png";
        $_MAG_DATA["gmode_default"][158] = "template/default/i/_4_short_rain.png";
        $_MAG_DATA["gmode_default"][159] = "template/default/i/v_menu_4.png";
        $_MAG_DATA["gmode_default"][160] = "template/default/i/arr_left.png";
        $_MAG_DATA["gmode_default"][161] = "template/default/i/horoscope_menu_button_1_8_b.png";
        $_MAG_DATA["gmode_default"][162] = "template/default/i/mb_table02.png";
        $_MAG_DATA["gmode_default"][163] = "template/default/i/bg2.png";
        $_MAG_DATA["gmode_default"][164] = "template/default/i/mm_ico_radio.png";
        $_MAG_DATA["gmode_default"][165] = "template/default/i/mm_ico_vidimax.png";
        $_MAG_DATA["gmode_default"][166] = "template/default/i/mb_player.png";
        $_MAG_DATA["gmode_default"][167] = "template/default/i/_8_rain_swon.png";
        $_MAG_DATA["gmode_default"][168] = "template/default/i/loading_bg.gif";
        $_MAG_DATA["gmode_default"][169] = "template/default/i/footer_search_act.png";
        $_MAG_DATA["gmode_default"][170] = "template/default/i/mm_ico_oll.png";
        $_MAG_DATA["gmode_default"][171] = "template/default/i/horoscope_menu_button_1_12_a.png";
        $_MAG_DATA["settings_array"] = array(
            "js" => array(
                "modules" => array(
                    array("name" => "lock"),
                    array("name" => "lang"),
                    array("name" => "update"),
                    array(
                        "name" => "net_info",
                        "sub"  => array(
                            array("name" => "wired"),
                            array(
                                "name" => "pppoe",
                                "sub"  => array(
                                    array("name" => "dhcp"),
                                    array("name" => "dhcp_manual"),
                                    array("name" => "disable")
                                )
                            ),
                            array("name" => "wireless"),
                            array("name" => "speed")
                        )
                    ),
                    array("name" => "video"),
                    array("name" => "audio"),
                    array(
                        "name" => "net",
                        "sub"  => array(
                            array(
                                "name" => "ethernet",
                                "sub"  => array(
                                    array("name" => "dhcp"),
                                    array("name" => "dhcp_manual"),
                                    array("name" => "manual"),
                                    array("name" => "no_ip")
                                )
                            ),
                            array(
                                "name" => "pppoe",
                                "sub"  => array(
                                    array("name" => "dhcp"),
                                    array("name" => "dhcp_manual"),
                                    array("name" => "disable")
                                )
                            ),
                            array(
                                "name" => "wifi",
                                "sub"  => array(
                                    array("name" => "dhcp"),
                                    array("name" => "dhcp_manual"),
                                    array("name" => "manual")
                                )
                            )
                        )
                    ),
                    array("name" => "advanced"),
                    array("name" => "dev_info"),
                    array("name" => "reload"),
                    array("name" => "internal_portal"),
                    array("name" => "reboot")
                )
            )
        );
        $_MAG_DATA["get_locales"]["English"] = "en_GB.utf8";
        $_MAG_DATA["all_modules"] = array("media_browser", "tv", "apps", "dvb", "tv_archive", "time_shift", "time_shift_local", "epg.reminder", "epg.recorder", "epg", "epg.simple", "vclub", "youtube", "karaoke", "radio", "records", "remotepvr", "pvr_local", "settings.parent", "settings.localization", "settings.update", "settings.playback", "settings.common", "settings.network_status", "game.lines", "game.memory", "game.sudoku", "picasa", "settings", "weather.weatherco.day", "cityinfo", "internet");
        $_MAG_DATA["switchable_modules"] = array("karaoke", "weather.day", "cityinfo", "horoscope", "horoscope", "anecdote", "game.mastermind", "infoportal");
        $_MAG_DATA["disabled_modules"] = array("weather.weatherco.day", "picasa", "remotepvr", "settings.update", "settings.common", "pvr_local", "game.lines", "game.memory", "game.sudoku", "karaoke", "weather.day", "cityinfo", "horoscope", "anecdote", "game.mastermind", "infoportal");
        $_MAG_DATA["restricted_modules"] = array();
        $_MAG_DATA["template"] = "default";
        $_MAG_DATA["get_years"] = array(
            "js" => array(
                array("id" => "*", "title" => "*"),
                array("id" => "1937", "title" => "1937"),
                array("id" => "1940", "title" => "1940"),
                array("id" => "1941", "title" => "1941"),
                array("id" => "1951", "title" => "1951"),
                array("id" => "1953", "title" => "1953"),
                array("id" => "1955", "title" => "1955"),
                array("id" => "1961", "title" => "1961"),
                array("id" => "1964", "title" => "1964"),
                array("id" => "1970", "title" => "1970"),
                array("id" => "1983", "title" => "1983"),
                array("id" => "1986", "title" => "1986"),
                array("id" => "1990", "title" => "1990"),
                array("id" => "1992", "title" => "1992"),
                array("id" => "1994", "title" => "1994"),
                array("id" => "1994/1998/2004", "title" => "1994/1998/2004"),
                array("id" => "1995", "title" => "1995"),
                array("id" => "1995/1999/2010", "title" => "1995/1999/2010"),
                array("id" => "1996", "title" => "1996"),
                array("id" => "1998", "title" => "1998"),
                array("id" => "1999", "title" => "1999"),
                array("id" => "2000", "title" => "2000"),
                array("id" => "2001", "title" => "2001"),
                array("id" => "2002", "title" => "2002"),
                array("id" => "2003", "title" => "2003"),
                array("id" => "2004", "title" => "2004"),
                array("id" => "2005", "title" => "2005"),
                array("id" => "2006", "title" => "2006"),
                array("id" => "2007", "title" => "2007"),
                array("id" => "2008", "title" => "2008"),
                array("id" => "2009", "title" => "2009"),
                array("id" => "2010", "title" => "2010"),
                array("id" => "2011", "title" => "2011"),
                array("id" => "2012", "title" => "2012"),
                array("id" => "2013", "title" => "2013"),
                array("id" => "2013", "title" => "2013"),
                array("id" => "2014", "title" => "2014")
            )
        );
        $_MAG_DATA["get_abc"] = array(
            "js" => array(
                array("id" => "*", "title" => "*"),
                array("id" => "A", "title" => "A"),
                array("id" => "B", "title" => "B"),
                array("id" => "C", "title" => "C"),
                array("id" => "D", "title" => "D"),
                array("id" => "E", "title" => "E"),
                array("id" => "F", "title" => "F"),
                array("id" => "G", "title" => "G"),
                array("id" => "H", "title" => "H"),
                array("id" => "I", "title" => "I"),
                array("id" => "G", "title" => "G"),
                array("id" => "K", "title" => "K"),
                array("id" => "L", "title" => "L"),
                array("id" => "M", "title" => "M"),
                array("id" => "N", "title" => "N"),
                array("id" => "O", "title" => "O"),
                array("id" => "P", "title" => "P"),
                array("id" => "Q", "title" => "Q"),
                array("id" => "R", "title" => "R"),
                array("id" => "S", "title" => "S"),
                array("id" => "T", "title" => "T"),
                array("id" => "U", "title" => "U"),
                array("id" => "V", "title" => "V"),
                array("id" => "W", "title" => "W"),
                array("id" => "X", "title" => "X"),
                array("id" => "W", "title" => "W"),
                array("id" => "Z", "title" => "Z")
            )
        );
        return $_MAG_DATA;
    }

}
