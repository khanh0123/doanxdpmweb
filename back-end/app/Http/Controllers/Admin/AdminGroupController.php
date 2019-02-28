<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Permission;
use App\Models\Admin_group;
use App\Models\Admin_group_permission;
use Validator;
class AdminGroupController extends MainAdminController
{
	protected $model;
	protected $view_folder = 'admin/group/';
	protected $rules = [
        'insert' => [
            'name'   => 'required',
            'per_id' => 'required|exists:permission,id'
        ],
        'update' => [
            'name'   => 'required',
            'per_id' => 'required|exists:permission,id'
        ]
	];
    protected $columns_filter = [
        'id'         =>    'admin_group.id',
        'name'       =>    'admin_group.name',            
        'created_at' =>    'admin_group.created_at',
        'updated_at' =>    'admin_group.updated_at',
    ];
    protected $columns_search = ['name'];


	public function __construct(Request $request) {
		$this->model = new Admin_group;
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


    	$item->name = $req->name;

    	return [
    		'type' => 'success'
    	];

    }

    /*
     * Create new resource item.
     */

    public function store(Request $request) {

        if($request->isMethod('post')){
            $data['info'] = $this->model;
            $result = $this->setItem('insert',$request, $data['info']);
            if($result['type'] == 'success'){

                if($data['info']->save()){
                    Admin_group_permission::where(['gad_id' => $data['info']->id])->delete();
                    $admin_gr_per = new Admin_group_permission();
                    $admin_gr_per->per_id = $request->per_id;
                    $admin_gr_per->gad_id = $data['info']->id;
                    $admin_gr_per->save();


                    $result['msg'] = 'Thêm dữ liệu thành công';
                } else {
                    $result['msg'] = 'Thêm dữ liệu thất bại';
                }

            }
        } else {
            $result = '';
        }
        

        $data['more'] = $this->getDataNeed();
        return $this->template($this->view_folder."add",$data,$result);
    }
    /*
     * Show detail item that belongs to passed id.
     */
    public function detail(Request $request,$id)
    {
        
    	$item = $this->model::find($id);
    	if(empty($item)){
    		return abort(404);
    	}

        if($request->isMethod('post')){
            $result = $this->setItem('update',$request, $item);
            if($result['type'] == 'success'){
                if($item->save()){
                    $admin_gr_per         = Admin_group_permission::where(array('gad_id' => $item->id))->delete();
                    $admin_gr_per         = new Admin_group_permission();
                    $admin_gr_per->per_id = (int)$request->per_id;
                    $admin_gr_per->gad_id = $item->id;
                    $admin_gr_per->save();


                    $result['msg'] = 'Cập nhật dữ liệu thành công';  
                } else {
                    $result['msg'] = 'Cập nhật dữ liệu thất bại';  
                }

            }

        } else {
            $result = '';
        }
        // $filter = $this->getFilter($request);
        $data['info'] = $item;
    	$data['more'] = $this->getDataNeed();
    	return $this->template($this->view_folder."detail",$data,$result);
    }

    

    /*
     * Delete item that belongs to passed id.
     */

    public function delete(Request $request, $id) {
        $item = $this->model::find($id);        
        if(empty($item)){
            return abort('404');
        }

        if($this->model->check_group_exists_admin($id)){
            return Redirect::route('Admin.'.getUriFromUrl($request->url()).'.index')
                ->withMessage(['type' => 'error','message' => 'Nhóm này đang chứa thành viên. Lệnh xóa không thể thực hiện']);
        }
        $admin_gr_per = new Admin_group_permission();
        $admin_gr_per->where('gad_id',$id)->delete();
        $item->delete();
        

        return Redirect::route('Admin.'.getUriFromUrl($request->url()).'.index')
                ->withMessage(['type' => 'success','message' => 'Xóa dữ liệu thành công']);
    }
    protected function getDataNeed(){
    	$ad_group_model = new Permission();
    	$data = $ad_group_model->getall();        
    	return $data;
    }
}
