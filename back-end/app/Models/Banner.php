<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banner extends Model
{
    protected $table = 'json_table';

    public function get_page($filter = [], $req = '')
    {
    	$data = DB::table($this->table)
    				// ->select('id','key','value','created_at','updated_at')
    				// ->orderBy('id', $sort)
    				->where('key' , 'banner')
    				->first();
        
    	return ( !empty($data) && !empty($data->value) )? json_decode($data->value) : [];
    }
    public function getById($id)
    {
    	$data = $this->get_page();
    	foreach ($data as $value) {
    		if($value->mov_id === $id){
    			return $value;
    		}
    	}
    	return null;

    }

    public function _insert($dataBanner)
    {
    	$data = $this->get_page();
    	foreach ($data as $value) {
    		if($value->mov_id === $dataBanner->mov_id){
    			return false;
    		}
    	}
    	$data[] = $dataBanner;
    	return DB::table($this->table)->where('key' , 'banner')->update(['value' => json_encode($data)]);
    }

    public function _update($dataBanner)
    {
    	$data = $this->get_page();
    	foreach ($data as $key => $value) {
    		if($value->id === $dataBanner->id){
    			$data[$key] = $dataBanner;
    			break;
    		}
    	}
    	return DB::table($this->table)->where('key' , 'banner')->update(['value' => json_encode($data)]);
    }
    public function _delete($id)
    {
    	$data = $this->get_page();
    	foreach ($data as $key => $value) {
    		if($value->id === $dataBanner->id){
    			unset($data[$key]);
    			break;
    		}
    	}
    	$data = array_values($data);
    	return DB::table($this->table)->where('key' , 'banner')->update(['value' => json_encode($data)]);
    }
}
