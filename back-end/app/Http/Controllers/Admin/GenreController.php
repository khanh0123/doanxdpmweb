<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Genre;
use App\Models\Max_id;
use Validator;
class GenreController extends MainAdminController
{
	protected $model;
	protected $view_folder = 'admin/genre/';
    protected $rules = [
        'insert' => [
            'name' => 'required',
        ],
        'update' => [
            'name' => 'required',
        ]
    ];
    protected $columns_filter = [
        'name'       =>    'genre.name',            
        'slug'       =>    'genre.slug',            
        'created_at' =>    'genre.created_at',
        'updated_at' =>    'genre.updated_at',
    ];
	

	public function __construct(Request $request) {
        $this->model = new Genre;
        parent::__construct($request);
    }


    public function setItem($type , $req , &$item){
    	
    	$validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {
        	return [
        		'type' => 'error',
        		'msg' => 'Vui lòng kiểm tra lại các trường nhập'
        	];
        }
        
        $item->name = ucwords($req->name);
        $item->slug = create_slug($req->slug ? $req->slug : $req->name);
        switch ($type) {
            case 'insert':
                
                if ($this->check_exist_slug($item->slug)) {
                    return [
                        'type' => 'error',
                        'msg' => 'slug is unique field'
                    ];
                }

                $result = Max_id::where(['table_name' => 'genre'])->first();
                if(empty($result)){
                    Max_id::insert(['table_name' => 'genre','max_id' => 'gen000']);
                    $max_id = 'gen000';
                } else {                
                    $max_id = $result->max_id;
                }

                $id_auto = auto_increment_string_id($max_id,6);
                $item->id =  $id_auto;
                Max_id::where(['table_name' => 'genre'])->update(['max_id' => $id_auto]);
                break;
            case 'update':
                if($item->slug !== create_slug($req->slug ? $req->slug : $req->name)){
                    if ($this->check_exist_slug($item->slug)) {
                        return [
                            'type' => 'error',
                            'msg' => 'slug is unique field'
                        ];
                    }
                    
                }
            break;
            
            default:
                // code...
                break;
        }

        return [
        	'type' => 'success'
        ];
    	
    }
}
