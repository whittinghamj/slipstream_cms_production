<?php


abstract class base_mag_model {

    public $table;
    public $table_column_count;
    public $table_columns = array();
    public $active_exists;
    public $table_primary_key;
    public $table_column_data;

    public $database;


    public function prepare_model(){
        global $conn;
        $this->database = $conn;

        $sql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_NAME = '". $this->table ."'";
        $query = $this->database->query($sql);

        $query_columns = $query->fetch(PDO::FETCH_ASSOC);
        if(is_array($query_columns)){
            foreach($query_columns as $column){
                array_push($this->table_columns, $column["COLUMN_NAME"]);
                if($column["COLUMN_KEY"] == "PRI"){
                    $this->table_primary_key = $column["COLUMN_NAME"];
                }

                if($column["COLUMN_NAME"] == "active"){ $this->active_exists = true; }

                //Now lets set our Column data...So we can validate it when we before we run any kind of query.
                $this->table_column_data[$column["COLUMN_NAME"]] = array("Data Type" => $column["DATA_TYPE"],"Max Length" => $column["CHARACTER_MAXIMUM_LENGTH"],"Default" => $column["COLUMN_DEFAULT"]);
            }
        } else {
            return false;
        }

        $this->table_column_count = count($this->table_columns);
        return true;
    }

    public function get_variable($variable_to_get){
        if($this->$variable_to_get){
            return $this->$variable_to_get;
        }
        return false;
    }

    public function set_variable($variable_to_set, $variable_value){
        if($this->$variable_to_set){
            $this->$variable_to_set = $variable_value;
            return true;
        } else {
            return false;
        }
    }

    public function base64($method, $data){
        if($method == "encode"){
            return base64_encode($data);
        } else {
            return base64_decode($data);
        }
    }

}
