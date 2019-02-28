<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Config;
use Validator;
class ConfigController extends MainAdminController
{
	protected $model;
	protected $view_folder = 'admin/config/';
    protected $rules = [
        'insert' => [
            'key'   => 'required',
            'value' => 'required'
        ],
        'update' => [
            'key'   => 'required',
            'value' => 'required'
        ]
    ];
    protected $columns_filter = [
        'key'        =>    'config.key',            
        'value'      =>    'config.value',            
        'created_at' =>    'config.created_at',
        'updated_at' =>    'config.updated_at',
    ];
    protected $columns_search = ['key'];
	

	public function __construct(Request $request) {
        $this->model = new Config;
        parent::__construct($request);
    }

    public function setItem($type , $req , &$item){

        $validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {
            return [
                'type'    => 'error',
                'msg' => 'Vui lòng kiểm tra lại các trường nhập'
            ];
        }
        $item->key   = $req->key;
        $item->value = $req->value;
        return [
            'type'    => 'success',
            'msg' => $type == 'insert' ? 'Thêm dữ liệu thành công' : 'Cập nhật thành công',
        ];
        
    }



    
}
