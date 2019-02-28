<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Country;
use App\Models\Max_id;
use Validator;
class CountryController extends MainAdminController
{
	protected $model;
	protected $view_folder = 'admin/country/';
	protected $rules = [
        'insert' => [
            'name' => 'required',
        ],
        'update' => [
            'name' => 'required',
        ]
    ];
    protected $columns_filter = [
        'name'       =>    'country.name',            
        'slug'       =>    'country.slug',            
        'created_at' =>    'country.created_at',
        'updated_at' =>    'country.updated_at',
    ];

	public function __construct(Request $request) {
        $this->model = new Country;
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
        
        $item->country_code = $req->country_code;
        $item->name = ucwords($req->name);
        $item->slug = create_slug($req->slug ? $req->slug : $req->name);
        if($type == 'insert'){

            $result = Max_id::where(['table_name' => 'country'])->first();
            if(empty($result)){
                Max_id::insert(['table_name' => 'country','max_id' => 'cou000']);
                $max_id = 'cou0000';
            } else {                
                $max_id = $result->max_id;
            }

            // var_dump($max_id);die;
            // $item->id = generate_id($this->model->getTable());
            $id_auto = auto_increment_string_id($max_id,6);
            $item->id =  $id_auto;
            Max_id::where(['table_name' => 'country'])->update(['max_id' => $id_auto]);
            
        }
        return [
            'type' => 'success'
        ];
        
    }
}
