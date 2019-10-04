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

}