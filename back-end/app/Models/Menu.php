<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    protected $table = 'menu';

    public function get_page($filter = [] , $req)
    {
    	$data = DB::table($this->table)
    				->select('id','name','tag_id','created_at','updated_at')
                    //->join('tags','tag.id','=','menu.tag_id')
    				->orderBy($filter['orderBy'], $filter['sort']);
        $data = addConditionsToQuery($filter['conditions'],$data);
        $data = $data->paginate($filter['limit']);
        $data->appends($req->all())->links();
    	return $data;
    }

}