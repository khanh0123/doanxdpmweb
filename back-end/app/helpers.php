<?php

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

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
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

