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
        $result     = $this->getListId($filter , $req);
        $list_post_id = array_column($result->items(), "id");

        $data = DB::table($this->table)
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
        $data = $data->get();
        $arr_keys = $result->keys();
        for ($i = 0; $i < count($result); $i++) {
            $result->forget($result[$i]);     
        }
        for ($i = 0; $i < count($data); $i++) {
            $result->offsetSet($i,$data[$i]);     
        }
        
        // echo "<pre>";
        // var_dump($result);
        // echo "</pre>";
        // die();
        
        return $result;
    }



    public function search(Array $data,$field_get = [])
    {
        $data = DB::table($this->table)
                    ->select("posts.*")
                    //->join("category" , "category.id" , "=" , "movie.cat_id")
                    ->orderBy('posts.id', "desc")
                    ->where([$data])
                    ->first();              
        return $data;
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