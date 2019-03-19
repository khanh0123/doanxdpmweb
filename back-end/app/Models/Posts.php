<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Posts extends Model
{
    protected $table = 'posts';

    public function get_page($filter = [] , $req)
    {
        //get list id movie 
        $data     = $this->getListId($filter , $req);
        $list_post_id = array_column($data->items(), "id");

        $result = DB::table($this->table)
            ->select([
                "posts.*",
                "posts_tags.post_id",
                "tags.name as tag_name",
                "tags.slug as tag_slug",

            ])
            ->leftJoin("posts_tags"    ,"posts_tags.post_id"   ,"=" , "posts.id")
            ->leftJoin("tags"          ,"tags.id"             ,"=" , "posts_tags.tag_id")
            ->orderBy($filter['orderBy'], $filter['sort'])
            ->whereIn('posts.id',$list_post_id);
        // $data = addConditionsToQuery($filter['conditions'],$data);
        $result = $result->get();
        return new \Illuminate\Pagination\LengthAwarePaginator($result,$data->total(),$data->perPage(),$data->currentPage(),['path' => $req->url(), 'query' => $req->all()]);
    }



    private function getListId($filter , $req){
        $result = DB::table($this->table)
        ->select('posts.id')
        ->leftJoin("Posts_Tags"    ,"Posts_Tags.post_id"   ,"=" , "posts.id")
        ->leftJoin("tags"          ,"tags.id"             ,"=" , "Posts_Tags.tag_id")
        ->groupBy('posts.id')
        ->orderBy($filter['orderBy'], $filter['sort']);
        
        $result = addConditionsToQuery($filter['conditions'],$result);
        $result = $result->paginate($filter['limit']);
        $result->appends($req->all())->links();
        return $result;
    }

}