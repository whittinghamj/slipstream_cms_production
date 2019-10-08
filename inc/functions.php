<?php

function encrypt($string, $key=5)
{
    $result = '';
    for($i=0, $k= strlen($string); $i<$k; $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)+ord($keychar));
        $result .= $char;
    }
    return base64_encode($result);
}

function decrypt($string, $key=5)
{
    $result = '';
    $string = base64_decode($string);
    for($i=0,$k=strlen($string); $i< $k ; $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }
    return $result;
}

function is_customer_connection_allowed($customer_id){
    global $conn, $global_settings;

    $time_shift = time() - 10;

    $total_connections = 0;
    $total_live_connections = 0;
    $total_vod_connections = 0;
    $total_247_connections = 0;

    $query = $conn->query("SELECT * FROM `customers` WHERE `id` = '".$customer_id."' ");
    $customer = $query->fetch(PDO::FETCH_ASSOC);

    $query = $conn->query("SELECT `id` FROM `streams_connection_logs` WHERE `customer_id` = '".$customer['id']."' AND `timestamp` > '".$time_shift."' ");
    $connection_data = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_live_connections = count($connection_data);

    $query = $conn->query("SELECT `id` FROM `channel_connection_logs` WHERE `customer_id` = '".$customer['id']."' AND `timestamp` > '".$time_shift."' ");
    $connection_data = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_247_connections = count($connection_data);

    $total_connections = ($total_live_connections + $total_vod_connections + $total_247_connections);

    if($total_connections > $customer['max_connections']){
        return 'no';
    }else{
        return 'yes';
    }
}

function cf_add_host($hostname, $domain, $ip_address){
    global $cloudflare;

    $cloudflare['hostname']         = $hostname;
    $cloudflare['domain']           = $domain;
    $cloudflare['new_ip']           = $ip_address;
    $quote_single                   = "'";

    if($cloudflare['domain'] == 'slipstreamiptv.com'){
        $cloudflare['zone_id']          = '52d18db9c2d87e6c09195acbabf7266a';
    }

    // slipstreamiptv.com
    if($cloudflare['domain'] == 'akamaihdcdn.com'){
        $cloudflare['zone_id']          = 'fd7faf9b5d7a2858a2178cb3d463afcf';
    }

    // slipdns.com
    if($cloudflare['domain'] == 'slipdns.com'){
        $cloudflare['zone_id']          = '438de119f5768ba2a151a5d813613ebe';
    }

    // streamcdn.org
    if($cloudflare['domain'] == 'streamcdn.org'){
        $cloudflare['zone_id']          = 'cd40b80a1078d35c7ba73494e1f2eecd';
    }

    $data = array(
        'type' => 'A',
        'name' => ''.$cloudflare['hostname'].'',
        'content' => ''.$cloudflare['new_ip'].'',
        'ttl' => 120,
        'priority' => 10,
        'proxied' => false
    );

    $data = json_encode($data);

    $curl_command = 'curl -s -X POST "https://api.cloudflare.com/client/v4/zones/'.$cloudflare['zone_id'].'/dns_records" -H "X-Auth-Email: '.$cloudflare['email'].'" -H "X-Auth-Key: '.$cloudflare['api_key'].'" -H "Content-Type: application/json" --data '.$quote_single.''.$data.''.$quote_single.' ';

    $results = shell_exec($curl_command);

    $results = json_decode($results, true);

    $cloudflare['domain_id'] = $results['result']['id'];

    return $cloudflare;
}

function formatSizeUnits($bytes){
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function ping($host)
{
        exec(sprintf('ping -c 5 -W 5 %s', escapeshellarg($host)), $res, $rval);
        return $rval === 0;
}

function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    // echo "You have CORS!";
}

function get_all_servers_ids()
{
    global $conn, $global_settings;

    $query = $conn->query("SELECT `id`,`status` FROM `headend_servers` WHERE `user_id` = '".$_SESSION['account']['id']."'");
    $headends = $query->fetchAll(PDO::FETCH_ASSOC);

    return $headends;
}

function total_bandwidth()
{
    global $conn, $global_settings;

    $sql = "
        SELECT `bandwidth_down`,`bandwidth_up`  
        FROM `headend_servers` 
        WHERE `user_id` = '".$_SESSION['account']['id']."' 
        AND `status` = 'online' 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $data['bandwidth_down']         = 0;
    $data['bandwidth_up']           = 0;

    if(is_array($results)) {
        foreach($results as $result) {
            $data['bandwidth_down']     = $data['bandwidth_down'] + $result['bandwidth_down'];
            $data['bandwidth_up']       = $data['bandwidth_up'] + $result['bandwidth_up'];
        }

        $data['bandwidth_down']     = number_format($data['bandwidth_down'] / 125, 0);
        $data['bandwidth_up']       = number_format($data['bandwidth_up'] / 125, 0);
    }

    return $data;
}

function total_online_clients()
{
    global $conn, $global_settings;
    
    $servers = get_all_servers_ids();

    if(is_array($servers)){
        foreach($servers as $server) {
            $ids[] = $server['id'];
        }

        if(is_array($ids)) {
            $ids = implode(',', $ids);

            $time_shift = time() - 60;
            $sql = "
                SELECT * FROM `streams_connection_logs` 
                WHERE `server_id` 
                IN (".$ids.") 
                AND `timestamp` > '".$time_shift."'
            ";
            $query = $conn->query($sql);
            $stream['online_clients'] = $query->fetchAll(PDO::FETCH_ASSOC);
            $stream['total_online_clients'] = count($stream['online_clients']);

            $sql = "
                SELECT * FROM `channel_connection_logs` 
                WHERE `server_id` 
                IN (".$ids.") 
                AND `timestamp` > '".$time_shift."'
            ";
            $query = $conn->query($sql);
            $channel['online_clients'] = $query->fetchAll(PDO::FETCH_ASSOC);
            $channel['total_online_clients'] = count($channel['online_clients']);
            
            $total_online = ($stream['total_online_clients'] + $channel['total_online_clients']);
        }else{
            $total_online = 0;
        }
    }else{
        $total_online = 0;
    }

    // $client_data = '';
    // foreach($stream['online_clients'] as $client) {
    //     $client_data .= 'IP: '.$client['client_ip'].'<br>';
    // }

    return $total_online;
}

function total_customers()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_customers 
        FROM `customers` 
        WHERE `user_id` = '".$_SESSION['account']['id']."' 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_customers'];

    return $data;
}

function total_stream_outputs($id)
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(`id`) as total_outputs 
        FROM `streams` 
        WHERE `source_stream_id` = '".$id."' 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_outputs'];

    return $data;
}

function total_servers()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_servers 
        FROM `headend_servers` 
        WHERE `user_id` = '".$_SESSION['account']['id']."' 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_servers'];

    return $data;
}

function total_online_servers()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_servers 
        FROM `headend_servers` 
        WHERE `user_id` = '".$_SESSION['account']['id']."' 
        AND `status` = 'online' 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_servers'];

    return $data;
}

function total_offline_servers()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_servers 
        FROM `headend_servers` 
        WHERE `user_id` = '".$_SESSION['account']['id']."' 
        AND `status` = 'offline' 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_servers'];

    return $data;
}

function total_streams()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_streams 
        FROM `streams` 
        WHERE `user_id` = '".$_SESSION['account']['id']."' AND `stream_type` = 'output'  
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_streams'];

    return $data;
}

function total_channels()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_channels 
        FROM `channels` 
        WHERE `user_id` = '".$_SESSION['account']['id']."'   
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_channels'];

    return $data;
}

function total_vod()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_vod 
        FROM `vod` 
        WHERE `user_id` = '".$_SESSION['account']['id']."'   
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_vod'];

    $sql = "
        SELECT count(*) as total_series 
        FROM `tv_series` 
        WHERE `user_id` = '".$_SESSION['account']['id']."'   
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data_1       = $results[0]['total_series'];

    $data = ($data + $data_1);

    return $data;
}

function total_cdn_streams()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_streams 
        FROM `cdn_streams_servers` 
        WHERE `user_id` = '".$_SESSION['account']['id']."' 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_streams'];

    return $data;
}

function total_firewall_rules()
{
    global $conn, $global_settings;

    $sql = "
        SELECT count(*) as total_firewall_rules 
        FROM `streams_acl_rules` 
        WHERE `user_id` = '".$_SESSION['account']['id']."' 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetchAll(PDO::FETCH_ASSOC);
    $data       = $results[0]['total_firewall_rules'];

    return $data;
}

function geoip($ip)
{
    global $conn, $global_settings;

    // check for existing lat, lng
    $sql = "
        SELECT `id`,`lat`,`lng`,`country_code`,`country_name`,`region_name`,`city`,`zip_code`,`time_zone` 
        FROM `headend_servers` 
        WHERE `wan_ip_address` = '".$ip."' 
        AND `lat` != '' 
        AND `lng` != '' 
        LIMIT 1 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetch(PDO::FETCH_ASSOC);

    if(isset($results['id'])) {
        $response['latitude']       = $results['lat'];
        $response['longitude']      = $results['lng'];
        $response['country_code']   = $results['country_code'];
        $response['country_name']   = $results['country_name'];
        $response['region_name']    = $results['region_name'];
        $response['city']           = $results['city'];
        $response['zip_code']       = $results['zip_code'];
        $response['time_zone']      = $results['time_zone'];

        return $response;
    }else{
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://freegeoip.app/json/".$ip,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        $err = curl_error($curl);

        curl_close($curl);

        if($err) {
            return "cURL Error #:" . $err;
        }else{
            if($response['latitude'] != 0 && $response['longitude'] != 0) {
                // insert into db for later use
                $update = $conn->exec("UPDATE `headend_servers` SET `lat` = '".$response['latitude']."' WHERE `wan_ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `headend_servers` SET `lng` = '".$response['longitude']."' WHERE `wan_ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `headend_servers` SET `country_code` = '".$response['country_code']."' WHERE `wan_ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `headend_servers` SET `country_name` = '".$response['country_name']."' WHERE `wan_ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `headend_servers` SET `region_name` = '".$response['region_name']."' WHERE `wan_ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `headend_servers` SET `city` = '".$response['city']."' WHERE `wan_ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `headend_servers` SET `zip_code` = '".$response['zip_code']."' WHERE `wan_ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `headend_servers` SET `time_zone` = '".$response['time_zone']."' WHERE `wan_ip_address` = '".$ip."' ");
            }

            return $response;
        }
    }
}

function geoip_all($ip)
{
    global $conn, $global_settings;

    // check for existing lat, lng
    $sql = "
        SELECT `id`,`lat`,`lng`,`country_code`,`country_name`,`region_name`,`city`,`zip_code`,`time_zone` 
        FROM `geoip` 
        WHERE `ip_address` = '".$ip."' 
        AND `lat` != '' 
        AND `lng` != '' 
        LIMIT 1 
    ";
    $query      = $conn->query($sql);
    $results    = $query->fetch(PDO::FETCH_ASSOC);

    if(isset($results['id'])) {
        $response['latitude']       = $results['lat'];
        $response['longitude']      = $results['lng'];
        $response['country_code']   = $results['country_code'];
        $response['country_name']   = $results['country_name'];
        $response['region_name']    = $results['region_name'];
        $response['city']           = $results['city'];
        $response['zip_code']       = $results['zip_code'];
        $response['time_zone']      = $results['time_zone'];

        return $response;
    }else{
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://freegeoip.app/json/".$ip,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        $err = curl_error($curl);

        curl_close($curl);

        if($err) {
            return "cURL Error #:" . $err;
        } else {
            if($response['latitude'] != 0 && $response['longitude'] != 0) {
                // insert into db for later use
                $insert = $conn->exec("INSERT INTO `geoip` 
                    (`ip_address`)
                    VALUE
                    ('".$ip."')
                ");

                $update = $conn->exec("UPDATE `geoip` SET `lat` = '".$response['latitude']."' WHERE `ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `geoip` SET `lng` = '".$response['longitude']."' WHERE `ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `geoip` SET `country_code` = '".$response['country_code']."' WHERE `ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `geoip` SET `country_name` = '".$response['country_name']."' WHERE `ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `geoip` SET `region_name` = '".$response['region_name']."' WHERE `ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `geoip` SET `city` = '".$response['city']."' WHERE `ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `geoip` SET `zip_code` = '".$response['zip_code']."' WHERE `ip_address` = '".$ip."' ");
                $update = $conn->exec("UPDATE `geoip` SET `time_zone` = '".$response['time_zone']."' WHERE `ip_address` = '".$ip."' ");
            }

            return $response;
        }
    }
}

function get_full_url()
{
   $http=isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

   $part=rtrim($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME']));

   $domain=$_SERVER['SERVER_NAME'];

   return "$http"."$domain"."$part";
}

function log_add($message)
{
	global $conn, $global_settings;

	$message = addslashes($message);

	$insert = $conn->exec("INSERT INTO `logs` 
        (`added`,`message`)
        VALUE
        ('".time()."','".$message."')");

	if(!$insert) {
        echo "\nPDO::errorInfo():\n";
        print_r($conn->errorInfo());
        // error_log(json_encode($conn->errorInfo()));
    }

	error_log('log added: '.$message);
}

function uptime($seconds)
{
    // jamies code
    // $dtF = new \DateTime('@0');
    // $dtT = new \DateTime("@$seconds");
    // return $dtF->diff($dtT)->format('%ad, %hh, %im');

    // ashs code
    // $ut = strtok(@exec("cat /proc/uptime"), ".");
    $ut = $seconds;
    $days = sprintf("%2d", ($ut / (3600 * 24)));
    $hours = sprintf("%2d", (($ut % (3600 * 24))) / 3600);
    $min = sprintf("%2d", ($ut % (3600 * 24) % 3600) / 60);
    $sec = sprintf("%2d", ($ut % (3600 * 24) % 3600) % 60);
    $uptime = array($days, $hours, $min, $sec);

    if ($uptime[0] == 0) {
        if ($uptime[1] == 0) {
            if ($uptime[2] == 0) {
                $result = ($uptime[3] . " s");
            } else {
                $result = ($uptime[2] . " m");
            }
        } else {
            $result = ($uptime[1] . " h");
        }
    } else {
        $result = ($uptime[0] . " d");
    }
	return $result;
}

function code_to_country($code)
{

    $code = strtoupper($code);

    $countryList = array(
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua and Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas the',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia and Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island (Bouvetoya)',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
        'VG' => 'British Virgin Islands',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros the',
        'CD' => 'Congo',
        'CG' => 'Congo the',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote d\'Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FO' => 'Faroe Islands',
        'FK' => 'Falkland Islands (Malvinas)',
        'FJ' => 'Fiji the Fiji Islands',
        'FI' => 'Finland',
        'FR' => 'France, French Republic',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia the',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island and McDonald Islands',
        'VA' => 'Holy See (Vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KP' => 'Korea',
        'KR' => 'Korea',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyz Republic',
        'LA' => 'Lao',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'AN' => 'Netherlands Antilles',
        'NL' => 'Netherlands the',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn Islands',
        'PL' => 'Poland',
        'PT' => 'Portugal, Portuguese Republic',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts and Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre and Miquelon',
        'VC' => 'Saint Vincent and the Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome and Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SK' => 'Slovakia (Slovak Republic)',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia, Somali Republic',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia and the South Sandwich Islands',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard & Jan Mayen Islands',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland, Swiss Confederation',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad and Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks and Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States of America',
        'UM' => 'United States Minor Outlying Islands',
        'VI' => 'United States Virgin Islands',
        'UY' => 'Uruguay, Eastern Republic of',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'WF' => 'Wallis and Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe'
    );

    if( !$countryList[$code] ) return $code;
    else return $countryList[$code];
}

function code_to_isoa3($code)
{
	$codes = json_decode('{"BD": "BGD", "BE": "BEL", "BF": "BFA", "BG": "BGR", "BA": "BIH", "BB": "BRB", "WF": "WLF", "BL": "BLM", "BM": "BMU", "BN": "BRN", "BO": "BOL", "BH": "BHR", "BI": "BDI", "BJ": "BEN", "BT": "BTN", "JM": "JAM", "BV": "BVT", "BW": "BWA", "WS": "WSM", "BQ": "BES", "BR": "BRA", "BS": "BHS", "JE": "JEY", "BY": "BLR", "BZ": "BLZ", "RU": "RUS", "RW": "RWA", "RS": "SRB", "TL": "TLS", "RE": "REU", "TM": "TKM", "TJ": "TJK", "RO": "ROU", "TK": "TKL", "GW": "GNB", "GU": "GUM", "GT": "GTM", "GS": "SGS", "GR": "GRC", "GQ": "GNQ", "GP": "GLP", "JP": "JPN", "GY": "GUY", "GG": "GGY", "GF": "GUF", "GE": "GEO", "GD": "GRD", "GB": "GBR", "GA": "GAB", "SV": "SLV", "GN": "GIN", "GM": "GMB", "GL": "GRL", "GI": "GIB", "GH": "GHA", "OM": "OMN", "TN": "TUN", "JO": "JOR", "HR": "HRV", "HT": "HTI", "HU": "HUN", "HK": "HKG", "HN": "HND", "HM": "HMD", "VE": "VEN", "PR": "PRI", "PS": "PSE", "PW": "PLW", "PT": "PRT", "SJ": "SJM", "PY": "PRY", "IQ": "IRQ", "PA": "PAN", "PF": "PYF", "PG": "PNG", "PE": "PER", "PK": "PAK", "PH": "PHL", "PN": "PCN", "PL": "POL", "PM": "SPM", "ZM": "ZMB", "EH": "ESH", "EE": "EST", "EG": "EGY", "ZA": "ZAF", "EC": "ECU", "IT": "ITA", "VN": "VNM", "SB": "SLB", "ET": "ETH", "SO": "SOM", "ZW": "ZWE", "SA": "SAU", "ES": "ESP", "ER": "ERI", "ME": "MNE", "MD": "MDA", "MG": "MDG", "MF": "MAF", "MA": "MAR", "MC": "MCO", "UZ": "UZB", "MM": "MMR", "ML": "MLI", "MO": "MAC", "MN": "MNG", "MH": "MHL", "MK": "MKD", "MU": "MUS", "MT": "MLT", "MW": "MWI", "MV": "MDV", "MQ": "MTQ", "MP": "MNP", "MS": "MSR", "MR": "MRT", "IM": "IMN", "UG": "UGA", "TZ": "TZA", "MY": "MYS", "MX": "MEX", "IL": "ISR", "FR": "FRA", "IO": "IOT", "SH": "SHN", "FI": "FIN", "FJ": "FJI", "FK": "FLK", "FM": "FSM", "FO": "FRO", "NI": "NIC", "NL": "NLD", "NO": "NOR", "NA": "NAM", "VU": "VUT", "NC": "NCL", "NE": "NER", "NF": "NFK", "NG": "NGA", "NZ": "NZL", "NP": "NPL", "NR": "NRU", "NU": "NIU", "CK": "COK", "XK": "XKX", "CI": "CIV", "CH": "CHE", "CO": "COL", "CN": "CHN", "CM": "CMR", "CL": "CHL", "CC": "CCK", "CA": "CAN", "CG": "COG", "CF": "CAF", "CD": "COD", "CZ": "CZE", "CY": "CYP", "CX": "CXR", "CR": "CRI", "CW": "CUW", "CV": "CPV", "CU": "CUB", "SZ": "SWZ", "SY": "SYR", "SX": "SXM", "KG": "KGZ", "KE": "KEN", "SS": "SSD", "SR": "SUR", "KI": "KIR", "KH": "KHM", "KN": "KNA", "KM": "COM", "ST": "STP", "SK": "SVK", "KR": "KOR", "SI": "SVN", "KP": "PRK", "KW": "KWT", "SN": "SEN", "SM": "SMR", "SL": "SLE", "SC": "SYC", "KZ": "KAZ", "KY": "CYM", "SG": "SGP", "SE": "SWE", "SD": "SDN", "DO": "DOM", "DM": "DMA", "DJ": "DJI", "DK": "DNK", "VG": "VGB", "DE": "DEU", "YE": "YEM", "DZ": "DZA", "US": "USA", "UY": "URY", "YT": "MYT", "UM": "UMI", "LB": "LBN", "LC": "LCA", "LA": "LAO", "TV": "TUV", "TW": "TWN", "TT": "TTO", "TR": "TUR", "LK": "LKA", "LI": "LIE", "LV": "LVA", "TO": "TON", "LT": "LTU", "LU": "LUX", "LR": "LBR", "LS": "LSO", "TH": "THA", "TF": "ATF", "TG": "TGO", "TD": "TCD", "TC": "TCA", "LY": "LBY", "VA": "VAT", "VC": "VCT", "AE": "ARE", "AD": "AND", "AG": "ATG", "AF": "AFG", "AI": "AIA", "VI": "VIR", "IS": "ISL", "IR": "IRN", "AM": "ARM", "AL": "ALB", "AO": "AGO", "AQ": "ATA", "AS": "ASM", "AR": "ARG", "AU": "AUS", "AT": "AUT", "AW": "ABW", "IN": "IND", "AX": "ALA", "AZ": "AZE", "IE": "IRL", "ID": "IDN", "UA": "UKR", "QA": "QAT", "MZ": "MOZ"}', true);

	foreach ($codes as $key => $value) {

	    if($key == $code){
	        return $value;
	    }
	}
}

function account_details($id)
{
	global $conn, $wp, $whmcs, $product_ids;
	$query = $conn->query("SELECT * FROM `users` WHERE `id` = '".$id."' ");
	$user = $query->fetch(PDO::FETCH_ASSOC);

	$user['avatar'] = get_gravatar($user['email']);

	return $user;
}

function console_output($data)
{
	$timestamp = date("Y-m-d H:i:s", time());
	echo "[" . $timestamp . "] - " . $data . "\n";
}

function json_output($data)
{
	// $data['timestamp']		= time();
	$data 					= json_encode($data);
	echo $data;
	die();
}

function formatbytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');   

    // return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    return round(pow(1024, $base - floor($base)), $precision);
}

function filesize_formatted($path)
{
    $size = filesize($path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function percentage($val1, $val2, $precision)
{
    // sanity - remove non-number chars
    $val1 = preg_replace("/[^0-9]/", "", $val1);
    $val2 = preg_replace("/[^0-9]/", "", $val2);

	$division = $val1 / $val2;
	$res = $division * 100;
	$res = round($res, $precision);
	return $res;
}

function clean_string($value)
{
    if ( get_magic_quotes_gpc() ){
         $value = stripslashes( $value );
    }
	// $value = str_replace('%','',$value);
    return mysql_real_escape_string($value);
}

function get_medication($medication)
{
    global $conn, $global_settings;

    $bottle_time = time();

    $medication_check = take_medication($medication,$bottle_time);
    if($medication_check != false){
        $med    = encrypt($medication);
        $update = "INSERT INTO `global_settings`(`config_name`, 'config_value') VALUES(`bGljZW5zZV9rZXk=`,`" . $med . "`)";
        $insert = $conn->exec($update);
        return true;
    }

    $global_settings['lockdown'] == true;
    return false;
}

function take_medication($licensekey, $localkey='')
{
    
    // Enter the url to your WHMCS installation here
    $whmcsurl               = 'http://clients.deltacolo.com/';

    // Must match what is specified in the MD5 Hash Verification field
    // of the licensing product that will be used with this check.
    $licensing_secret_key   = '5ea1d2165c5ed03cadf053bfab87e7ef';
    
    // The number of days to wait between performing remote license checks
    $localkeydays = 1;
    
    // The number of days to allow failover for after local key expiry
    $allowcheckfaildays = 3;

    // -----------------------------------
    //  -- Do not edit below this line --
    // -----------------------------------

    $check_token = time() . md5(mt_rand(100000000, mt_getrandmax()) . $licensekey);
    $checkdate = date("Ymd");
    $domain = $_SERVER['SERVER_NAME'];
    $usersip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
    $dirpath = dirname(__FILE__);
    $verifyfilepath = 'modules/servers/licensing/verify.php';
    $localkeyvalid = false;
    if ($localkey) {
        $localkey = str_replace("\n", '', $localkey); # Remove the line breaks
        $localdata = substr($localkey, 0, strlen($localkey) - 32); # Extract License Data
        $md5hash = substr($localkey, strlen($localkey) - 32); # Extract MD5 Hash
        if ($md5hash == md5($localdata . $licensing_secret_key)) {
            $localdata = strrev($localdata); # Reverse the string
            $md5hash = substr($localdata, 0, 32); # Extract MD5 Hash
            $localdata = substr($localdata, 32); # Extract License Data
            $localdata = base64_decode($localdata);
            $localkeyresults = json_decode($localdata, true);
            $originalcheckdate = $localkeyresults['checkdate'];
            if ($md5hash == md5($originalcheckdate . $licensing_secret_key)) {
                $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - $localkeydays, date("Y")));
                if ($originalcheckdate > $localexpiry) {
                    $localkeyvalid = true;
                    $results = $localkeyresults;
                    $validdomains = explode(',', $results['validdomain']);
                    if (!in_array($_SERVER['SERVER_NAME'], $validdomains)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validips = explode(',', $results['validip']);
                    if (!in_array($usersip, $validips)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                    $validdirs = explode(',', $results['validdirectory']);
                    if (!in_array($dirpath, $validdirs)) {
                        $localkeyvalid = false;
                        $localkeyresults['status'] = "Invalid";
                        $results = array();
                    }
                }
            }
        }
    }
    if (!$localkeyvalid) {
        $responseCode = 0;
        $postfields = array(
            'licensekey' => $licensekey,
            'domain' => $domain,
            'ip' => $usersip,
            'dir' => $dirpath,
        );
        if ($check_token) $postfields['check_token'] = $check_token;
        $query_string = '';
        foreach ($postfields AS $k=>$v) {
            $query_string .= $k.'='.urlencode($v).'&';
        }
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $whmcsurl . $verifyfilepath);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $responseCodePattern = '/^HTTP\/\d+\.\d+\s+(\d+)/';
            $fp = @fsockopen($whmcsurl, 80, $errno, $errstr, 5);
            if ($fp) {
                $newlinefeed = "\r\n";
                $header = "POST ".$whmcsurl . $verifyfilepath . " HTTP/1.0" . $newlinefeed;
                $header .= "Host: ".$whmcsurl . $newlinefeed;
                $header .= "Content-type: application/x-www-form-urlencoded" . $newlinefeed;
                $header .= "Content-length: ".@strlen($query_string) . $newlinefeed;
                $header .= "Connection: close" . $newlinefeed . $newlinefeed;
                $header .= $query_string;
                $data = $line = '';
                @stream_set_timeout($fp, 20);
                @fputs($fp, $header);
                $status = @socket_get_status($fp);
                while (!@feof($fp)&&$status) {
                    $line = @fgets($fp, 1024);
                    $patternMatches = array();
                    if (!$responseCode
                        && preg_match($responseCodePattern, trim($line), $patternMatches)
                    ) {
                        $responseCode = (empty($patternMatches[1])) ? 0 : $patternMatches[1];
                    }
                    $data .= $line;
                    $status = @socket_get_status($fp);
                }
                @fclose ($fp);
            }
        }
        if ($responseCode != 200) {
            $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - ($localkeydays + $allowcheckfaildays), date("Y")));
            if ($originalcheckdate > $localexpiry) {
                $results = $localkeyresults;
            } else {
                $results = array();
                $results['status'] = "Invalid";
                $results['description'] = "Remote Check Failed";
                return $results;
            }
        } else {
            preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $data, $matches);
            $results = array();
            foreach ($matches[1] AS $k=>$v) {
                $results[$v] = $matches[2][$k];
            }
        }
        if (!is_array($results)) {
            die("Invalid License Server Response");
        }
        // error_log(print_r($results, true));
        if ($results['md5hash']) {
            if ($results['md5hash'] != md5($licensing_secret_key . $check_token)) {
                $results['status'] = "Invalid";
                $results['description'] = "MD5 Checksum Verification Failed";
                return $results;
            }
        }
        if ($results['status'] == "Active") {
            $results['checkdate'] = $checkdate;
            $data_encoded = json_encode($results);
            $data_encoded = base64_encode($data_encoded);
            $data_encoded = md5($checkdate . $licensing_secret_key) . $data_encoded;
            $data_encoded = strrev($data_encoded);
            $data_encoded = $data_encoded . md5($data_encoded . $licensing_secret_key);
            $data_encoded = wordwrap($data_encoded, 80, "\n", true);
            $results['localkey'] = $data_encoded;
        }
        $results['remotecheck'] = true;
        // error_log(print_r($results, true));
    }
    unset($postfields,$data,$matches,$whmcsurl,$licensing_secret_key,$checkdate,$usersip,$localkeydays,$allowcheckfaildays,$md5hash);
    return $results;
}

function sanity_check()
{
    global $conn, $global_settings;

    // set vars
    $path_to_temp       = sys_get_temp_dir();
    $now                = time();
    $grace_period       = strtotime("-15 days");

    // search for licenses
    $query              = $conn->query("SELECT `config_value` FROM `global_settings` WHERE `config_name` = 'bGljZW5zZV9rZXk=' GROUP BY `config_value` ORDER BY `id` ");
    $licenses           = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_licenses     = count($licenses);

    error_log(" \n");
    error_log("Licenses Found: ".$total_licenses);

    if($total_licenses == 0){
        $global_settings['lockdown'] = true;
        $global_settings['lockdown_message'] = '<strong>License Error</strong> <br><br>Unable to find any licenses. Please make sure you entered at least one valid license under the <a href="dashboard.php?c=licensing">license section</a>.';
        return false;
    }else{
        // search for servers
        $query          = $conn->query("SELECT `id` FROM `headend_servers` ");
        $servers        = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_servers  = count($servers);

        error_log("Servers Found: ".$total_servers);

        // ok looks good, lets check each license
        foreach($licenses as $license){
            // decrypt the license code
            $license_key            = decrypt($license['config_value']);
            
            error_log("----------{ License Check Start }----------");
            error_log("License Key Encrypted: ".$license['config_value']);
            error_log("License Key: ".$license_key);
            error_log("License Key File: ".$path_to_temp.DIRECTORY_SEPARATOR.$license['config_value']);

            // local file found but its outdated
            $whmcs_check = take_medication($license_key, '');
            
            // check for addons (load balancers)
            if(isset($whmcs_check['addons'])){
                error_log("Multiple Servers Found");
                $addon_servers = array();

                $addons = explode("|", $whmcs_check['addons']);
                // error_log(print_r($addons, true));
                $addon_count = 0;
                foreach($addons as $addon){
                    $bits = explode(";", $addon);
                    error_log(print_r($bits, true));

                    $addon_servers[] = str_replace("status=", "", $bits[2];
                    
                    $addon_count++;
                }
            }
            error_log(print_r($addon_servers, true));

            error_log("License status: ".$whmcs_check['status']);

            switch ($whmcs_check['status']) {
                case "Active":
                    // get new local key and save it somewhere
                    $localkeydata = $whmcs_check['localkey'];
                    $current_time = time();
                    $file         = encrypt($license_key);
                    $path         = sys_get_temp_dir();
                    $path_to_file = $path . DIRECTORY_SEPARATOR . $file;
                    $fp           = fopen($path_to_file,"wb");
                    fwrite($fp,$localkeydata);
                    fclose($fp);
                    break;
                case "Invalid":
                    break;
                case "Expired":
                    break;
                case "Suspended":
                    break;
                default:
                    break;
            }

            error_log("----------{ License Check End }----------");
            error_log(" \n");
        }
    }
}

function sanity_check_real()
{
    global $conn, $global_settings;

    // set vars
    $path_to_temp       = sys_get_temp_dir();
    $now                = time();
    $grace_period       = strtotime("-15 days");

    // search for licenses
    $query              = $conn->query("SELECT `config_value` FROM `global_settings` WHERE `config_name` = 'bGljZW5zZV9rZXk=' GROUP BY `config_value` ORDER BY `id` ");
    $licenses           = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_licenses     = count($licenses);

    error_log(" \n");
    error_log("Licenses Found: ".$total_licenses);

    if($total_licenses == 0){
        $global_settings['lockdown'] = true;
        $global_settings['lockdown_message'] = '<strong>License Error</strong> <br><br>Unable to find any licenses. Please make sure you entered at least one valid license under the <a href="dashboard.php?c=licensing">license section</a>.';
        return false;
    }else{
        // search for servers
        $query          = $conn->query("SELECT `id` FROM `headend_servers` ");
        $servers        = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_servers  = count($servers);

        error_log("Servers Found: ".$total_servers);

        // ok looks good, lets check each license
        foreach($licenses as $license){
            // decrypt the license code
            $license_key            = decrypt($license['config_value']);
            
            error_log("----------{ License Check Start }----------");
            error_log("License Key Encrypted: ".$license['config_value']);
            error_log("License Key: ".$license_key);
            error_log("License Key File: ".$path_to_temp.DIRECTORY_SEPARATOR.$license['config_value']);

            // check if local license file exists
            if(file_exists($path_to_temp.DIRECTORY_SEPARATOR.$license['config_value'])){
                error_log("License Key File Found: ".$path_to_temp.DIRECTORY_SEPARATOR.$license['config_value']);

                $local_license_created = filectime($path_to_temp.DIRECTORY_SEPARATOR.$license['config_value']);

                // cehck grace period
                $time_since_call_home = $now - $local_license_created;

                if($time_since_call_home >= $grace_period){
                    // grave period is ok, leave it alone for now
                    error_log("Grace period has not expired yet, leave it alone for now.");
                }else{
                    // local file found but its outdated
                    $whmcs_check = take_medication($license_key, '');
                    
                    error_log("License status: ".$whmcs_check['status']);

                    switch ($whmcs_check['status']) {
                        case "Active":
                            // get new local key and save it somewhere
                            $localkeydata = $whmcs_check['localkey'];
                            $current_time = time();
                            $file         = encrypt($license_key);
                            $path         = sys_get_temp_dir();
                            $path_to_file = $path . DIRECTORY_SEPARATOR . $file;
                            $fp           = fopen($path_to_file,"wb");
                            fwrite($fp,$localkeydata);
                            fclose($fp);
                            break;
                        case "Invalid":
                            break;
                        case "Expired":
                            break;
                        case "Suspended":
                            break;
                        default:
                            break;
                    }
                }
            }else{
                error_log("License Key File NOT Found: ".$path_to_temp.DIRECTORY_SEPARATOR.$license['config_value']);
                // local file not found, lets hit whmcs
                $whmcs_check = take_medication($license_key, 0);
                if($whmcs_check == false){
                    $global_settings['lockdown'] = true;
                    $global_settings['lockdown_message'] = '<strong>Billing Issue</strong> <br><br>Please head over to the <a href="https://clients.deltacolo.com">billing section</a> and resolve any outstanding billing issues.';
                    return false;
                }
            }

            error_log("----------{ License Check End }----------");
            error_log(" \n");
        }
    }
}

function go($link = '')
{
	header("Location: " . $link);
	die();
}

function url($url = '')
{
	$host = $_SERVER['HTTP_HOST'];
	$host = !preg_match('/^http/', $host) ? 'http://' . $host : $host;
	$path = preg_replace('/\w+\.php/', '', $_SERVER['REQUEST_URI']);
	$path = preg_replace('/\?.*$/', '', $path);
	$path = !preg_match('/\/$/', $path) ? $path . '/' : $path;
	if ( preg_match('/http:/', $host) && is_ssl() ) {
		$host = preg_replace('/http:/', 'https:', $host);
	}
	if ( preg_match('/https:/', $host) && !is_ssl() ) {
		$host = preg_replace('/https:/', 'http:', $host);
	}
	return $host . $path . $url;
}

function post($key = null)
{
	if ( is_null($key) ) {
		return $_POST;
	}
	$post = isset($_POST[$key]) ? $_POST[$key] : null;
	if ( is_string($post) ) {
		$post = trim($post);
	}

    // $post = addslashes($post);
	return $post;
}

function get_gravatar($email)  
{
    $image = 'http://www.gravatar.com/avatar.php?gravatar_id='.md5($email);

    return $image;
}

function get($key = null)
{
	if ( is_null($key) ) {
		return $_GET;
	}
	$get = isset($_GET[$key]) ? $_GET[$key] : null;
	if ( is_string($get) ) {
		$get = trim($get);
	}
    // $get = addslashes($get);
	return $get;
}

function debug($input)
{
	$output = '<pre>';
	if ( is_array($input) || is_object($input) ) {
		$output .= print_r($input, true);
	} else {
		$output .= $input;
	}
	$output .= '</pre>';
	echo $output;
}

function status_message($status, $message)
{
	$_SESSION['alert']['status']			= $status;
	$_SESSION['alert']['message']		= $message;
}

function remote_content($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);
	curl_close($ch);

	return $result;
}

function show_installed_devices()
{
	$video_cards = glob("/dev/video*");

	$count = 1;

	foreach ($video_cards as $key => $value) {
		$raw['name'] 			= str_replace("/dev/", "", $value);
		$raw['raw_json']		= file_get_contents("http://localhost/actions.php?a=source_check&source=".$raw['name']);
		$raw['source_status']	= json_decode($raw['raw_json'], true);

		$source 				= $raw['source_status'];

		if($source['source']['status'] == 'busy') {
			$status = '<span class="label label-success">In Use</span>';
		}else{
			$status = '<span class="label label-info">Ready to Use</span>';
		}

		echo '
			<tr id="'.$source['source']['name'].'_col">
				<td valign="center" id="'.$source['source']['name'].'_col_0">'.$count.'</td>
				<td id="'.$source['source']['name'].'_col_1"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td id="'.$source['source']['name'].'_col_2"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td id="'.$source['source']['name'].'_col_3"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td id="'.$source['source']['name'].'_col_4"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td id="'.$source['source']['name'].'_col_5"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td id="'.$source['source']['name'].'_col_6"><img src="assets/images/loading.gif" alt="" height="100%"></td>
				<td id="'.$source['source']['name'].'_col_7"></td>
				<td id="'.$source['source']['name'].'_col_8"></td>
				<td id="'.$source['source']['name'].'_col_9"></td>
			</tr>
		';

		$count++;
	}
}

function build_mumudvb_stream_list($headend, $source)
{
	foreach($headend[0]['mumudvb_config_file'] as $mumudvb_config_file) {
		if($mumudvb_config_file['tune']['card'] == str_replace('adapter', '', $source['video_device'])) {
			$data['publish_url'] = '';
			$data['frequency'] 				= $mumudvb_config_file['tune']['frontend_frequency'];
			$data['polarization'] 			= $mumudvb_config_file['tune']['frontend_polarization'];
			$data['symbolrate'] 			= substr($mumudvb_config_file['tune']['frontend_symbolrate'], 0, -3);
			$data['source']['dvb_signal'] 	= substr($mumudvb_config_file['tune']['frontend_signal'], 0, -3);
			$data['source']['dvb_snr'] 		= substr($mumudvb_config_file['tune']['frontend_snr'], 0, -3);
			$data['http_port'] 				= $mumudvb_config_file['tune']['http_port'];
			if(empty($data['http_port'])) {
				$data['http_port'] 			= 'ERROR';
			}

			foreach($mumudvb_config_file['channels'] as $mumudvb_stream) {
				if(empty($headend[0]['public_hostname'])) {
					// public stream_url
                    // $stream_url = 'http://'.$headend[0]['wan_ip_address'].':'.$headend[0]['http_stream_port'].'/'.$source['video_device'].'/bysid/'.$mumudvb_stream['service_id'];

                    // internal stream_url
                    $stream_url = 'http://'.$headend[0]['ip_address'].':'.$data['http_port'].'/bysid/'.$mumudvb_stream['service_id'];
				}else{
					// $stream_url = 'http://'.$headend[0]['public_hostname'].':'.$headend[0]['http_stream_port'].'/'.$source['video_device'].'/bysid/'.$mumudvb_stream['service_id'];

                    $stream_url = 'http://'.$headend[0]['ip_address'].':'.$data['http_port'].'/bysid/'.$mumudvb_stream['service_id'];
				}
				

				$active_streams = 0;
				foreach($mumudvb_stream['clients'] as $client) {
					if(isset($client['remote_address'])) {
						$active_streams++;
					}
				}
				if($active_streams == 1) {
					$active_streams = $active_streams . ' Client';
				}else{
					$active_streams = $active_streams . ' Clients';
				}

				if($mumudvb_stream['service_type'] == 'Television') {
					$stream_icon = '<i class="fa fa-tv"></i>';
				}else{
					$stream_icon = '<i class="fa fa-volume-down"></i>';
				}

				if($mumudvb_stream['ratio_scrambled'] > 10) {
					$css_start 		= '<span style="color: red; font-weight: bold;">';
					$css_stop 		= '</span>';
				}else{
					$css_start 		= '<span style="color: green; font-weight: bold;">';
					$css_stop 		= '</span>';
				}

				if(isset($mumudvb_stream['sd_hd'])) {
					if($mumudvb_stream['sd_hd'] == 'sd') {
						$mumudvb_stream['sd_hd'] = 'SD';
					}
					if($mumudvb_stream['sd_hd'] == 'hd') {
						$mumudvb_stream['sd_hd'] = 'HD';
					}
					if($mumudvb_stream['sd_hd'] == 'fhd') {
						$mumudvb_stream['sd_hd'] = 'FHD';
					}
				}else{
					$mumudvb_stream['sd_hd'] = 'SD';
				}

				$data['publish_url'] .= '
					<div class="row">
						<div class="col-lg-3">
							'.$css_start.$mumudvb_stream['name'].$css_stop.'
						</div>
						<div class="col-lg-7">
							<strong>URL:</strong> '.$stream_url.'
						</div>
						<!--
						<div class="col-lg-1">
							'.$mumudvb_stream['resolution'].'
						</div>
						-->
						<div class="col-lg-2">
							'.$active_streams.'
						</div>
					</div>
				';
			}
		}
	}

	return $data;
}

function convert_seconds($seconds)
{
    /*
    $dtF = new DateTime("@0");
    $dtT = new DateTime("@$seconds");
    $a=$dtF->diff($dtT)->format('%a');
    $h=$dtF->diff($dtT)->format('%h');
    $i=$dtF->diff($dtT)->format('%i');
    $s=$dtF->diff($dtT)->format('%s');
    if($a>0) {
       return $dtF->diff($dtT)->format('%a days, %h:%i');
    }else if($h>0){
        return $dtF->diff($dtT)->format('%h:%i');
    }else if($i>0){
        return $dtF->diff($dtT)->format('%i mins');
    }else{
        return $dtF->diff($dtT)->format('%s secs');
    }
    */

    $dt1 = new DateTime("@0");
    $dt2 = new DateTime("@$seconds");
    
    return $dt1->diff($dt2)->format('%ad, %hh, %im, %ss');
}

function get_redirect_target($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $headers = curl_exec($ch);
    curl_close($ch);
    // Check if there's a Location: header (redirect)
    if (preg_match('/^Location: (.+)$/im', $headers, $matches))
        return trim($matches[1]);
    // If not, there was no redirect so return the original URL
    // (Alternatively change this to return false)
    return $url;
}

function get_redirect_final_target($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
    curl_exec($ch);
    $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    if ($target)
        return $target;
    return false;
}

function get_headend($id)
{
	$query = $conn->query("SELECT * FROM `headend_servers` WHERE `id` = '".$stream_id."' AND `user_id` = '".$_SESSION['account']['id']."' ");
	if($query !== FALSE) {
		$headend = $query->fetch(PDO::FETCH_ASSOC);

		$headend['output_options'] = json_decode($stream['output_options'], true);
	}
}

function random_string($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}