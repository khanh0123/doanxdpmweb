<?php

if (!function_exists('apiCurl')) {

    /**
     * Global helpers api curl
     *
     * @param string $full_url
     * @param string $method
     * @param array $params
     * @param string $type
     *
     * @return mixed
     */
    function apiCurl($url, $method = "GET", $params = array(), $type = 'array' , $type_ip = 'v4')
    {
        $full_url = $url;
        $data_string = '';
        
        
        if (!empty($params) && $type === 'json') {
            if ($method == "GET") {
                $data_string = '';

                foreach ($params as $fieldey => $item) {
                    $data_string .= '&' . $fieldey . '=' . $item;
                }
                $data_string = substr($data_string, 1);
                $full_url = $full_url . "?" . $data_string;
            } else {
                $data_string = json_encode($params);
            }
        } else {
            $data_string = http_build_query($params);
            $data_string = substr($data_string, 0);
            
        }     

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_ENCODING,  '');
        // curl_setopt($ch, CURLOPT_USERAGENT, get_server_var('HTTP_USER_AGENT'));
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.69 Safari/537.36");

        if($type_ip == 'v4'){
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        } else {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }

        if (!empty($params) && ($method == "POST" || $method == "PUT" || $method == "DELETE")) {
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        }
        if ($type === 'array') {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'X-Requested-With: XMLHttpRequest',
                    // 'X-Forwarded-For: ' . getRealUserIp(),
                )
            );
        }
        
        //execute post
        $result = curl_exec($ch);              
       
        
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($errno = curl_errno($ch)) {
            $dataResult['http_code'] = 500;
            $dataResult['message'] = $errno;
            return array('http_code' => 500, 'message' => '');
        }
        
        if ($httpcode !== 200) {            
            
            $result = json_decode($result, true);
            $dataResult['http_code'] = $httpcode;
            $dataResult['message'] = !empty($result['message']) ? $result['message'] : '';
            return $dataResult;
        }
        
        //close connection
        curl_close($ch);
        return is_array($result) ? json_decode($result) : $result;
    }

}

if (!function_exists('get_server_var')) {

    function get_server_var($fieldey)
    {
        return !empty($_SERVER[$fieldey]) ? $_SERVER[$fieldey] : null;
    }

}

if (!function_exists('getRealUserIp')) {

    /**
     * Global helpers get user ip address
     *
     * @return string
     */
    function getRealUserIp()
    {
        switch (true) {
            case (!empty($_SERVER['HTTP_X_REAL_IP'])) :
                return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])) :
                return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) :
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default :
                return $_SERVER['REMOTE_ADDR'];
        }
    }

}

if (!function_exists('getUriFromUrl')) {

    /**
     * Global helpers get uri after admin/
     * example : admin/config/... => config
     * @return string if matched else @return false
     */
    function getUriFromUrl($url)
    {
        $reg = '/\/(admin)\/([a-zA-Z]+)(\S+)?/';
        $matches = array();
        $check = preg_match($reg,$url,$matches);
        if($check){
            return $matches[2];
        }
        return false;
        
    }

}

if (!function_exists('base_url')) {
    /**
     * Global helpers get full_url with uri
     * 
     * @return string
     */
    function base_url($uri = ''){
        return url($uri);        
    }
}

if (!function_exists('customDate')) {
    /**
     * Global helpers format output of timestamp
     * 
     * @return Datetime
     */
    function customDate($time = '' , $format = 'normal'){

        switch ($format) {
            case 'normal':
                $format = "d/m/y";
                break;
            case 'daytime':
                $format = "d/m/y - h:i";
                break;
            default:
                $format = "d/m/y";
                break;
        }
        if(is_numeric($time))
            return Date($format , $time);
        else if(is_string($time)){
            return Date($format , strtotime($time));
        }
        return Date($format,time());
    }
}

if (!function_exists('create_slug')) {
    /**
     * Global helpers create slug from string
     * 
     * @return string
     */
    function create_slug($str,$replace = "-") {        

        // if($replace)){
        //     $replace = "-";
        // }
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', $replace, $str);
        $str = trim($str,$replace);
        return $str;
    }
}


if (!function_exists('time_in_ms')) {
    /**
     * Global helpers get timestamp in milisecond
     * 
     * @return double
     */
    function time_in_ms(){
        return round(microtime(true) * 1000);
    }
}

if (!function_exists('get_table_name')) {
    /**
     * Global helpers get table name from id
     * 
     * @return string
     */
    function get_table_name($id){
        
        $reg = "/^([a-zA-Z]+)([0-9]+)/";
        $array_table = ['genre','country','category'];
        $matches = [];
        $check = preg_match($reg, $id , $matches);
        if($check){
            foreach ($array_table as $item) {
                if(substr($item, 0, 3) == $matches[1]){
                    return $item;
                }
            }
        }
        return null;
        
    }
}


if (!function_exists('encode_password')) {
    /**
     * Global helpers auto create id
     * 
     * @return string
     */
    function encode_password($password){
        return hash("sha256", md5($password));
    }
}

if (!function_exists('generate_id')) {
    /**
     * Global helpers auto create id
     * 
     * @return string
     */
    function generate_id($table_name = ''){
        $id = substr($table_name, 0, 3).time().uniqid();
        return $id;
        
    }
}
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
if (!function_exists('auto_increment_string_id')) {
    /**
     * Global helpers create id auto increment from string
     * 
     * @return string
     */
    function auto_increment_string_id($string = '',$max_size = 3){
        $reg_find = '/(^[a-zA-Z]+)([0]+)?([0-9]+)/';
        $reg_replace = '/([0-9]+)/';
        $matches = array();
        $check = preg_match($reg_find,$string,$matches);
        if($check){
            $num = (int)$matches[3];
            $num++;
            $num = (string)$num;
            
            while (strlen($num) < $max_size) {
                $num = '0' . $num;
            }
            $new_id = preg_replace($reg_replace, $num , $string);            
            return $new_id;
        }
        return false;
    }
}

if (!function_exists('getIdFromLinkFb')) {
    /**
     * Global helpers create id auto increment from string
     * 
     * @return string
     */
    function getIdFromLinkFb($link = ''){
        $reg_find = '/(?:https?:\/\/)?(?:www.|web.|m.)?facebook.com\/(?:video.php\?v=\d+|photo.php\?v=\d+|\?v=\d+)|\S+\/videos\/((\S+)\/(\d+)|(\d+))\/?/';
        $matches = array();
        $check = preg_match($reg_find,$link,$matches);
        
        if($check){            
            $id = (count($matches) > 3) ? $matches[count($matches)-1] : $matches[1];
            return $id;
        }
        return false;
    }
}

if (!function_exists('addConditionsToQuery')) {
    function addConditionsToQuery($conditions , $result){
        if( count($conditions['and']) > 0 ){
            $result = $result->where($conditions['and']);
        }
        if( count($conditions['or']) > 0 ){

            $result = $result->where(function($query) use($conditions) {

                for ($i = 0; $i < count($conditions['or']); $i++) {
                    $i == 0 ? $query->where([$conditions['or'][0]]) : $query->orWhere([$conditions['or'][$i]]);
                }
            });
        }
        return $result;
    }
}

if (!function_exists('formatResult')) {
    function formatResult($results , $rules = [] , $type = ''){  
        

        if(count($results) > 0 && $results[0]->id !== null ){
            
            $new_data = [];
            $arr_index = [];
            for ($i = 0; $i < count($results); $i++) {
                $item = $results[$i];

                        //save the key with id 
                if(!isset($arr_index[$item->id])){
                    $arr_index[$item->id] = count($new_data);
                    $new_data[] = $results[$i];
                }
                foreach ($item as $field => $v) {

                    foreach ($rules as $new_name => $f) {
                        if( is_array($f) && in_array($field, $f) ){

                            if(!is_array($new_data[$arr_index[$item->id]]->$field)){
                                $new_data[$arr_index[$item->id]]->$field = [];
                            }

                                //check if value not empty and not exists in array before adding 
                                 // 
                            if($v !== null ){
                                $new_data[$arr_index[$item->id]]->$field[] = $v;
                            }
                            break;

                        }
                        else if($f == $field) {

                            if(!is_array($new_data[$arr_index[$item->id]]->$field)){
                                $new_data[$arr_index[$item->id]]->$field = [];
                            }

                                //check if value not empty and not exists in array before adding 
                                 // 
                            if($v !== null && !in_array($v, $new_data[$arr_index[$item->id]]->$field) ){
                                $new_data[$arr_index[$item->id]]->$field[] = $v;
                            }
                            break;
                        }
                    }

                }

            } //end for


            //remove all item of $result 
            $arr_keys = $results->keys();
            for ($i = 0; $i < count($arr_keys); $i++) {
                $results->forget($arr_keys[$i]);     
            }



            foreach ($new_data as $key => $value) {
                
                foreach ($rules as $new_name => $f) {
                    $dt = [];
                    if(!isset($new_data[$key]->$new_name) || is_array($new_data[$key]->$new_name) ){
                        $new_data[$key]->$new_name = [];
                    }
                    for ($i = 0; $i < count($f); $i++) {
                        $ff = $f[$i];
                        
                        
                        foreach ($value->$ff as $kk => $vv) {
                            
                            $dt[$kk][$f[$i]] = $vv;
                            
                            
                        }
                        
                    }
                   
                    $new_data[$key]->$new_name = $dt;
                }

                foreach ($rules as $new_name => $f) {
                    for ($i = 0; $i < count($f); $i++) {
                        $ff = $f[$i];
                        unset($new_data[$key]->$ff);
                    }
                }

                //set item to result
                $results->offsetSet($key,$new_data[$key]);     
                
                
            }

            if($type == 'get'){
                return $results;
            }

            

            return $new_data;
        }
        return $results;
    }
}

