<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
class Controller extends BaseController
{
    protected $req;
    public function __construct($request)
    {
        $this->req = $request;
    }

    protected function template_api($data = []){
        return Response()->json($data);
    }
    protected function template_fe($view = '',$data = []){    
		//get menu
        $data['menu'] = DB::table('menu')
        ->select('menu.*','tags.name as tag_name','tags.slug as tag_slug')
        ->join('tags','tags.id','=','menu.tag_id')
        ->get();
        foreach ($data['menu'] as $key => $value) {
            $count_post = DB::table('posts_tags')->where('tag_id',$value->tag_id)->count();
            $data['menu'][$key]->num_post = $count_post;
            
        }
        return Response()->view($view,$data);
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
        return $this->model->getTable().".".DB::getSchemaBuilder()->getColumnListing($this->model->getTable())[0];
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

}
