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
    				->select('menu.id','menu.name','menu.tag_id','menu.created_at','menu.updated_at')
                    ->join('tags','tags.id','=','menu.tag_id')
    				->orderBy($filter['orderBy'], $filter['sort']);
        $data = addConditionsToQuery($filter['conditions'],$data);
        $data = $data->paginate($filter['limit']);
        $data->appends($req->all())->links();
    	return $data;
    }

}