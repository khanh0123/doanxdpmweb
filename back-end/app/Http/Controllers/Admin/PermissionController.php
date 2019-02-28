<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Permission;


class PermissionController extends BaseController
{
	protected $model;
	protected $view_folder = 'admin/permission/';

    // public function index(Request $request)
    // {
    // 	$this->model = new Permission();
    // 	$limit = $request->input('limit', $this->limit);
    //     $sort = (int)$request->input('sort' , 0) == 1 ? 'desc' : 'asc';
    //     $result = $this->model->get($limit,$sort);
    //     $result = $result->appends($request->all());
    //     $message = session()->get( 'message' );
    //     return view($this->view_folder."index")
    //     		->withData($result)
    //             ->withMessage($message);
    // }
}
