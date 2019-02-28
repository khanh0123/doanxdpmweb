<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Banner;
use App\Models\Movie;
use Validator;
class BannerController extends MainAdminController
{
	protected $model;
	protected $view_folder = 'admin/banner/';
	protected $rules = [
        'insert' => ['mov_id' => 'required|exists:movie,id',],
        'update' => ['mov_id' => 'required|exists:movie,id']
       	
    ];

	public function __construct(Request $request) {
        $this->model = new Banner;
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
                $item->created_at = time();
                $item->updated_at = $item->created_at;
                $item->mov_id     = $req->mov_id;
                $item->mov_name   = Movie::where('id',$item->mov_id)->first()->name;
                $item->id         = generate_id();
                break;
            case 'update':
                $item->updated_at = time();
                break;
            
            default:
                // code...
                break;
        }
        
        
        
        return [
            'type' => 'success'
        ];
        
    }


    /*
     * Create new resource item.
     */

    public function store(Request $request) {

        if($request->isMethod('post')){
            $item = $this->model;
            $result = $this->setItem('insert',$request, $item);
            if($result['type'] == 'success'){

                $this->model->_insert($item);
                $result['msg'] = 'Thêm banner thành công';
            }
        }
        return $this->template($this->view_folder."add");
    }

    /*
     * Show detail item that belongs to passed id.
     */
    public function detail(Request $request,$id)
    {
        return abort(404);
    }

    /*
     * Update item that belongs to passed id.
     */
    public function update(Request $request,$id)
    {
        return abort(404);
    }
    /*
     * Delete item that belongs to passed id.
     */

    public function delete(Request $request, $id) {
        $item = $this->model->getById($id);
        if(empty($item)){
            return abort('404');
        }
        $item->delete($id);

        return Redirect::route('Admin.'.getUriFromUrl($request->url()).'.index')
                ->withMessage(['type' => 'success','message' => 'Xóa dữ liệu thành công']);
    }
    
}
