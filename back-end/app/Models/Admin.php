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
    				->select('id','email','gad_id','first_name','last_name','status','created_at','updated_at')
    				->orderBy($filter['orderBy'], $filter['sort']);
        $data = addConditionsToQuery($filter['conditions'],$data);        
        $data = $data->paginate($filter['limit']);
        $data->appends($req->all())->links();
    	return $data;
    }

    public function get_permission_user($gad_id)
    {
    	$data = DB::table('admin_group_permission')
    				->select('gad_id','per_id','canRead','canWrite','canUpdate','canDelete','isAdmin')
                    ->join('permission' , 'admin_group_permission.per_id' , '=' , 'permission.id')
    				->join('admin_group' , 'admin_group.id' , '=' , 'admin_group_permission.gad_id')
                    ->where('admin_group.id' , $gad_id)
                    ->first();
    	return $data;
    }
    public function getByEmail($email)
    {
        $data = DB::table($this->table)
                    ->select('id','email','first_name','last_name','status','created_at','updated_at')
                    ->where("email",$email)
                    ->first();
        return $data;
    }

}