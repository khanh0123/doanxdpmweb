<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Menu;
use Validator;
use App\Models\Tags; 
class MenuController extends MainAdminController
{
	protected $model;
	protected $limit = 20;
	protected $view_folder = 'admin/menu/';
    protected $rules = [
        'insert' => [
            'name'     => 'required',
            'tag_id'     => 'required',
        ],
        'update' => [
            'name'     => 'required',
            'tag_id'   =>   'required',          
        ]
    ];
    protected $columns_filter = [
        // 'id'         =>    'menu.id',            
        'name'       =>    'menu.name',            
        'tag_id'       =>  'menu.tag_id',   
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
        // $data=$req->all();
        // var_dump($data);
        // die();
    	$validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {
        	return [
        		'type' => 'error',
        		'msg' => 'Vui lòng kiểm tra lại các trường nhập'
        	];
        }
        //var_dump($req->tag_id);
        // die();
        switch ($type) {
            case 'insert':               
                
                if($req->name !== $item->name){
                    if($this->model::where([
                        ['name',$req->name]
                    ])->first()){
                        return [
                            'type' => 'error',
                            'msg'  => 'Menu này đã tồn tại'
                        ];
                    }
                }        
                break;
            default:
                break;
        }
        
        $item->name = $req->name;
        $item->tag_id=$req->tag_id;

        
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
        //$data['info']->sub_menu = explode(",", $data['info']->sub_menu);
        $data['more'] = $this->getDataNeed();

        return $this->template($this->view_folder."detail",$data);
    }

    /*
     * Update item that belongs to passed id.
     */

    protected function getDataNeed(){
        $data = array();

        $tag_model = new Tags();

        $tag_model = $tag_model->getall();

        if(count($tag_model) > 0) {
            foreach ($tag_model as $value){
                array_push($data, $value);
            }
        }
        
        return $data;
    }

}
