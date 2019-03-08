<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Tags;
use Validator;
class TagsController extends MainAdminController
{
	protected $model;
	protected $view_folder = 'admin/tags/';
	protected $rules = [
        'insert' => [
            'name' => 'required',
            //'slug' => 'requỉred|unique:tags,slug',
        ],
        'update' => [
            'name' => 'required',
            //'slug' => 'requỉred|unique:tags,slug',
        ]
    ];
    protected $columns_filter = [
        'name'       =>    'tags.name',            
        'slug'       =>    'tags.slug',            
        'created_at' =>    'tags.created_at',
        'updated_at' =>    'tags.updated_at',
    ];
    protected $columns_search = ['name'];

	public function __construct(Request $request) {
        $this->model = new Tags;
        parent::__construct($request);
    }


    public function setItem($type , $req , &$item){
        // var_dump($req->all());
        // die();
        $validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {
            return [
                'type' => 'error',
                'msg' => 'Vui lòng kiểm tra lại các trường nhập'
            ];
        }       
        switch ($type) {
            case 'insert':               
                // var_dump();
                // die();
                if($req->name !== $item->name){
                    if($this->model::where([
                        ['name',$req->name]
                    ])->first()){
                        return [
                            'type' => 'error',
                            'msg'  => 'Tags này đã tồn tại'
                        ];
                    }
                }        
                break;
            default:
                break;
        }


        $item->name = ucwords($req->name);
        $item->slug = create_slug($req->slug ? $req->slug : $req->name);
        return ['type' => 'success'];
        
    }
}
