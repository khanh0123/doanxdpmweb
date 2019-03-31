<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use View;
class IndexController extends BaseController
{
    public function index()
    {
    	return view('admin/index');
    }
}
