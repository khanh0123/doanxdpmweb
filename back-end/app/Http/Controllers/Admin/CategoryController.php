<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Category;
use App\Models\Max_id;
use Validator;
class CategoryController extends MainAdminController
{
	protected $model;
	protected $view_folder = 'admin/category/';
	protected $rules = [
        'insert' => [
            'name' => 'required',
        ],
        'update' => [
            'name' => 'required',
        ]
    ];
    protected $columns_filter = [
        'name'       =>    'category.name',            
        'slug'       =>    'category.slug',            
        'created_at' =>    'category.created_at',
        'updated_at' =>    'category.updated_at',
    ];
    protected $columns_search = ['name'];

	public function __construct(Request $request) {
        $this->model = new Category;
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
        
        switch ($type) {
            case 'insert':
                $result = Max_id::where(['table_name' => 'category'])->first();
                if(empty($result)){
                    Max_id::insert(['table_name' => 'category','max_id' => 'cat000']);
                    $max_id = 'cat000';
                } else {                
                    $max_id = $result->max_id;
                }

                $id_auto = auto_increment_string_id($max_id,6);
                $item->id =  $id_auto;
                Max_id::where(['table_name' => 'category'])->update(['max_id' => $id_auto]);

                break;
            
            default:
                break;
        }


        $item->name = ucwords($req->name);
        $item->slug = create_slug($req->slug ? $req->slug : $req->name);
        return ['type' => 'success'];
        
    }
}
