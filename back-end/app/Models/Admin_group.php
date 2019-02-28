<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Admin_group extends Model
{
    protected $table = 'admin_group';
    
    public function get_page($filter = [], $req)
    {
        $data = DB::table($this->table)
            ->select('admin_group.id','admin_group.name as name','permission.name as per_name','gad_id','per_id')
            ->join('admin_group_permission' , 'admin_group_permission.gad_id' , '=' , 'admin_group.id')
            ->join('permission' , 'admin_group_permission.per_id' , '=' , 'permission.id')
            ->orderBy($filter['orderBy'], $filter['sort']);
        $data = addConditionsToQuery($filter['conditions'],$data);
        $data = $data->paginate($filter['limit']);
        $data->appends($req->all())->links();
        return $data;
    }

    public function getall($sort = 'desc'){
        $data = DB::table($this->table)
                    // ->select('id','key','value','created_at','updated_at')
                    ->orderBy('id', $sort)
                    ->get();
        return $data;

    }
    

    public function findById($filter = [] , $req)
    {
        $data = DB::table($this->table)
                    ->select('admin_group.id','admin_group.name as name','permission.name as per_name','gad_id','per_id')
                    ->join('admin_group_permission' , 'admin_group_permission.gad_id' , '=' , 'admin_group.id')
                    ->join('permission' , 'admin_group_permission.per_id' , '=' , 'permission.id')
                    ->orderBy($filter['orderBy'], $filter['sort'])
                    ->first();
        return $data;
    }

    public function check_group_exists_admin($id)
    {
        $data = DB::table('admin')
                    ->where('gad_id' , $id)
                    ->first();
        return $data;
    }
}
