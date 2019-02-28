<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    protected $table = 'permission';

    public function get_page($filter = [] , $req)
    {
        $data = DB::table($this->table)
                    // ->select('id','key','value','created_at','updated_at')
                    ->orderBy($filter['orderBy'], $filter['sort']);
        $data = addConditionsToQuery($filter['conditions'],$data);
        $data = $data->paginate($filter['limit']);
        $data->appends($req->all())->links();
        return $data;
    }
    public function getall($sort = 'asc'){
        $data = DB::table($this->table)
                    // ->select('id','key','value','created_at','updated_at')
                    ->orderBy('id', $sort)
                    ->get();
        return $data;

    }

}
