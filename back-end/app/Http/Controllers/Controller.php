<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function template_api($data = []){    


        return Response()->json($data);
    }
    protected function template_err($msg = ''){    


        return Response()->json(['error' => true,'msg' => $msg]);
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

}
