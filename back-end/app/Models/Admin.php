<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    protected $table = 'admin';

    public function get_page($filter, $req)
    {
    	$data = DB::table($this->table)
    				->select('id','username','password','gad_id','status','created_at','updated_at')
    				->orderBy($filter['orderBy'], $filter['sort']);
        $data = addConditionsToQuery($filter['conditions'],$data);        
        $data = $data->paginate($filter['limit']);
        $data->appends($req->all())->links();
    	return $data;
    }

    public function get_user($gad_id)
    {
    	$data = DB::table($this->table)
    				->select('gad_id','username')
                    ->join('admin_group' , 'admin.gad_id' , '=' , 'admin_group.id')
                    ->where('admin_group.id' , $gad_id)
                    ->first();
    	return $data;
    }
    // public function getByEmail($email)
    // {
    //     $data = DB::table($this->table)
    //                 ->select('id','username','status','created_at','updated_at')
    //                 ->where("username",$email)
    //                 ->first();
    //     return $data;
    // }

}