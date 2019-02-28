<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Menu;
use Validator;
use App\Models\Category; 
use App\Models\Genre; 
use App\Models\Country;
class MenuController extends MainAdminController
{
	protected $model;
	protected $limit = 20;
	protected $view_folder = 'admin/menu/';
    protected $rules = [
        'insert' => [
            'name'     => 'required',
            'slug'     => 'required',
            'sub_menu' => 'required'
        ],
        'update' => [
            'name'     => 'required',
            'slug'     => 'required',
            'sub_menu' => 'required'
            
        ],
    ];
    protected $columns_filter = [
        // 'id'         =>    'menu.id',            
        'name'       =>    'menu.name',            
        'slug'       =>    'menu.slug',        
        'created_at' =>    'menu.created_at',
        'updated_at' =>    'menu.updated_at',
    ];
    protected $columns_search = ['name'];
	

	public function __construct(Request $request) {
        $this->model = new Menu;
        parent::__construct($request);
    }

    /*
     * Show view add new item.
     */


    public function setItem($type , $req , &$item){

    	$validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {
        	return [
        		'type' => 'error',
        		'msg' => 'Vui lòng kiểm tra lại các trường nhập'
        	];
        }
        
        $item->name = $req->get("name");
        $item->slug = create_slug($req->slug ? $req->slug : $req->name);
        $item->sub_menu = implode(",", $req->sub_menu ? $req->sub_menu : []);

        
        return [
        	'type' => 'success',
        	'msg' => $type == 1 ? 'Thêm dữ liệu thành công' : 'Cập nhật thành công',
        ];

    }



    /*
     * Show detail item that belongs to passed id.
     */
    public function detail(Request $request,$id)
    {
        $data['info'] = $this->model::find($id);


        if(empty($data['info'])){
            return abort(404);
        }

        if($request->isMethod("post")){
            $result = $this->setItem('update',$request, $data['info']);
            if($result['type'] == 'success'){
                if($data['info']->save()){
                    $result['msg'] = 'Cập nhật dữ liệu thành công';
                } else {
                    $result['msg'] = 'Cập nhật dữ liệu thất bại';
                }
            }
        }
        $data['info']->sub_menu = explode(",", $data['info']->sub_menu);
        $data['more'] = $this->getDataNeed();

        return $this->template($this->view_folder."detail",$data);
    }

    /*
     * Update item that belongs to passed id.
     */

    protected function getDataNeed(){
        $data = array();

        $cat_model = new Category();
        $gen_model = new Genre();
        $cot_model = new Country();

        $data_cat = $cat_model->getall();
        $data_gen = $gen_model->getall();
        $data_cot = $cot_model->getall();

        if(count($data_cat) > 0) {
            foreach ($data_cat as $value) {
                array_push($data, $value);
            }
        }
        if(count($data_gen) > 0) {
            foreach ($data_gen as $value) {
                array_push($data, $value);
            }
        }
        if(count($data_cot) > 0) {
            foreach ($data_cot as $value) {
                array_push($data, $value);
            }
        }
        return $data;
    }

}
