<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class MainAdminController extends BaseController
{
    protected $limit = 20;
    protected $req;
	protected $status = 1;
    protected $columns_filter = [];
    protected $columns_search = [];

    public function __construct(Request $request , $variable = null) {
        // if (!isset($this->model)) {
        //     throw new Exception("ModelNotSet");
        // }
        // if (!isset($this->view_folder)) {
        //     throw new Exception("ViewFolderNotSet");
        // }
        $this->req = $request;
    }
    /*
     * Show list item.
     */
    public function index(Request $request ) {        
        
        $filter = $this->getFilter($request);
        $data['info']         = $this->model->get_page($filter , $request);
        $data['filter']       = $filter;
        return $this->template($this->view_folder."index",$data);
    }


    /*
     * Create new resource item.
     */

    public function store(Request $request) {
        if($request->isMethod('post')){ //insert
            $item = $this->model;
            $result = $this->setItem('insert',$request, $item);
            if($result['type'] == 'success'){
                $item->save();
                $result['msg'] = 'Thêm dữ liệu thành công';
                $data = [];
            } else {
                $data['info'] = $item;
            }
        } else { //show view add
            $result = '';
            $data = [];
        }

        //get more data
        if(method_exists($this,"getDataNeed")) $data['more'] = $this->getDataNeed();
        
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

        if($request->isMethod('post')){ //update
        
            $result = $this->setItem('update',$request, $item);
            if($result['type'] == 'success'){
                $item->save();
                $result['msg'] = 'Cập nhật dữ liệu thành công';         
            }
        } else { //show
            $result = "";
        }
        $data['info'] = $item;

        //get more data
        if(method_exists($this,"getDataNeed")) $data['more'] = $this->getDataNeed();

        //return view
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
        $item->delete();      

        return Redirect::route('Admin.'.getUriFromUrl($request->url()).'.index')
                ->withMessage(['type' => 'success','msg' => 'Xóa dữ liệu thành công']);
    }


    /*
     * check exists slug on 3 table.
     */
    protected function check_exist_slug($slug)
    {
        $data = DB::table('genre')->where(['slug' => $slug ])->get();
        if(count($data )> 0){
            return true;
        }
        $data = DB::table('category')->where(['slug' => $slug ])->get();
        if(count($data )> 0){
            return true;
        }
        $data = DB::table('country')->where(['slug' => $slug ])->get();
        if(count($data )> 0){
            return true;
        }
        return false;
    }

    

    /*
     * get filter (sort , orderby , limit )
     */
    protected function getFilter($request)
    {
        $filter['sort']       = $request->get("sort") == "asc" ? "asc" : "desc";
        $filter['orderBy']    = $this->getOrderBy($request);
        $limit                = (int)$request->get("limit");
        $filter['limit']      = ($limit < 1 || $limit > 100)? $this->limit : $limit;
        $filter['conditions'] = $this->getConditionByRequest($request,$this->columns_filter);
        return $filter;
    }

    /*
     * get orderBy from request(default orderBy id)
     */

    protected function getOrderBy($req) {
        $order_by = $req->input('orderBy');
        if(isset($this->columns_filter[$order_by]) && Schema::hasColumn($this->model->getTable(), $order_by)){
            return $this->columns_filter[$order_by];
        }
        // if(Schema::hasColumn($this->model->getTable(), 'id') && isset($this->columns_filter['id'])){
        //     return $this->columns_filter['id'];
        // }
        
        //default orderby first field in table
        $default = $this->model->getTable().".".DB::getSchemaBuilder()->getColumnListing($this->model->getTable())[0];
        return $default;
    }

    /*
     * get conditions to filter data from request.
     */
    protected function getConditionByRequest($req,$columns,$table = ''){
        $conditions = [
            'and' => [],
            'or' => []
        ];
        foreach ($columns as $key => $value) {
            if( $req->get($key) !== null ){
                if($key === "name"){                    
                    if(in_array($key, $this->columns_search)){
                        $conditions['or'][] = [$value, 'like' ,"%".$req->input($key)."%"];
                    }
                    continue;
                }

                if(!in_array($key, $this->columns_search)){
                    $conditions['and'][] = [$value, '=' ,$req->input($key)];
                } else {
                    $conditions['or'][] = [$value, 'like' ,"%".$req->input($key)."%"];
                }
                
            }
        }      
        return $conditions;
    }

    /*
     * return template view blade
     */
    protected function template($view , $data = [] , $message = '' ){    

        if(empty($message)){
            $message = session()->get( 'message' );
        }
        
        // if((strtolower($this->req->header('Return-Type')) == 'json' || strpos($this->req->route()->uri, "api/v1/") > -1)){
        //     return Response()->json($data);
        // }
        
        // if(method_exists($this,"getDataNeed")) $data['more'] = $this->getDataNeed();
        return view($view)->withData($data)->withMessage($message);
    }
    
}
