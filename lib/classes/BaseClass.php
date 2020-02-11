<?php

abstract class BaseClass {

    public $database;
    public $table_columns;

    public function get_var($var_to_get){
        if($this->$var_to_get){
            return $this->$var_to_get;
        }
        return false;
    }

    public function set_var($var_to_set, $value){
        if($this->$var_to_set){
            $this->$var_to_set = $value;
            return true;
        }
        return false;
    }

    public function advance_coder($encode_method, $encode_way, $encode_data){
        if($encode_method == "base64"){
            if($encode_method == "encode"){
                return base64_encode($encode_data);
            }

            if($encode_method == "decode"){
                return base64_decode($encode_data);
            }
        }

        if($encode_method == "json"){
            if($encode_method == "encode"){
                return json_encode($encode_data);
            }

            if($encode_method == "decode"){
                return json_decode($encode_data);
            }
        }
    }

    public function define_base(){
        $this->table_columns = array();

        $this->table_columns["mag_id"] = "";
        $this->table_columns["customer_id"] = "";
        $this->table_columns["bright"] = "";
        $this->table_columns["contrast"] = "";
        $this->table_columns["saturation"] = "";
        $this->table_columns["aspect"] = "";
        $this->table_columns["video_out"] = "";
        $this->table_columns["volume"] = "";
        $this->table_columns["playback_buffer_bytes"] = "";
        $this->table_columns["playback_buffer_size"] = "";
        $this->table_columns["audio_out"] = "";
        $this->table_columns["mac"] = "";
        $this->table_columns["ip"] = "";
        $this->table_columns["ls"] = "";
        $this->table_columns["ver"] = "";
        $this->table_columns["lang"] = "";
        $this->table_columns["locale"] = "";
        $this->table_columns["city_id"] = "";
        $this->table_columns["hd"] = "";
        $this->table_columns["main_notify"] = "";
        $this->table_columns["fav_itv_on"] = "";
        $this->table_columns["now_playing_start"] = "";
        $this->table_columns["now_playing_type"] = "";
        $this->table_columns["now_playing_content"] = "";
        $this->table_columns["time_last_play_tv"] = "";
        $this->table_columns["time_last_play_video"] = "";
        $this->table_columns["hd_content"] = "";
        $this->table_columns["image_version"] = "";
        $this->table_columns["last_change_status"] = "";
        $this->table_columns["last_start"] = "";
        $this->table_columns["last_active"] = "";
        $this->table_columns["keep_alive"] = "";
        $this->table_columns["playback_limit"] = "";
        $this->table_columns["screensaver_delay"] = "";
        $this->table_columns["stb_type"] = "";
        $this->table_columns["sn"] = "";
        $this->table_columns["last_watchdog"] = "";
        $this->table_columns["created"] = "";
        $this->table_columns["country"] = "";
        $this->table_columns["plasma_saving"] = "";
        $this->table_columns["ts_enabled"] = "";
        $this->table_columns["ts_enable_icon"] = "";
        $this->table_columns["ts_path"] = "";
        $this->table_columns["ts_max_length"] = "";
        $this->table_columns["ts_buffer_use"] = "";
        $this->table_columns["ts_action_on_exit"] = "";
        $this->table_columns["ts_delay"] = "";
        $this->table_columns["video_clock"] = "";
        $this->table_columns["rtsp_type"] = "";
        $this->table_columns["rtsp_flags"] = "";
        $this->table_columns["stb_lang"] = "";
        $this->table_columns["display_menu_after_loading"] = "";
        $this->table_columns["record_max_length"] = "";
        $this->table_columns["plasma_saving_timeout"] = "";
        $this->table_columns["now_playing_link_id"] = "";
        $this->table_columns["now_playing_streamer_id"] = "";
        $this->table_columns["device_id"] = "";
        $this->table_columns["device_id2"] = "";
        $this->table_columns["hw_version"] = "";
        $this->table_columns["parent_password"] = "";
        $this->table_columns["spdif_mode"] = "";
        $this->table_columns["show_after_loading"] = "";
        $this->table_columns["play_in_preview_by_ok"] = "";
        $this->table_columns["hdmi_event_reaction"] = "";
        $this->table_columns["mag_player"] = "";
        $this->table_columns["play_in_preview_only_by_ok"] = "";
        $this->table_columns["fav_channels"] = "";
        $this->table_columns["tv_archive_continued"] = "";
        $this->table_columns["tv_channel_default_aspect"] = "";
        $this->table_columns["last_itv_id"] = "";
        $this->table_columns["units"] = "";
        $this->table_columns["token"] = "";
        $this->table_columns["lock_device"] = "";
        $this->table_columns["watchdog_timeout"] = "";
    }

}