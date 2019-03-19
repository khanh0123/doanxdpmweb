<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Menu;
use App\Models\Posts_Tags; 
use DB;

class Home extends Controller
{
    public function index(){

        //get menu
        $data['menu'] = DB::table('menu')
                    ->select('menu.*','tags.name as tag_name','tags.slug as tag_slug')
                    ->join('tags','tags.id','=','menu.tag_id')

                    ->get();

        foreach ($data['menu'] as $key => $value) {
            $count_post = Posts_Tags::where('tag_id',$value->tag_id)->count();
            $data['menu'][$key]->num_post = $count_post;
            
        }
        
        //get new posts
        $data['new_posts'] = DB::table('posts')
                    ->select('posts.*','tags.name as tag_name','tags.slug as tag_slug')
                    ->join('posts_tags','posts_tags.post_id','=','posts.id')
                    ->join('tags','tags.id','=','posts_tags.tag_id')
                    ->where('is_new',1)
                    ->where('is_hot',0)
                    ->orderBy('view' , 'desc')
                    ->limit(2)
                    ->get();

        //tin tuc an ninh mang
        $data['internet_security_posts'] = DB::table('posts')
                    ->select('posts.*','tags.name as tag_name','tags.slug as tag_slug')
                    ->join('posts_tags','posts_tags.post_id','=','posts.id')
                    ->join('tags','tags.id','=','posts_tags.tag_id')
                    ->where('tags.slug','an-ninh-mang')
                    ->orderBy('view' , 'desc')
                    ->limit(6)
                    ->get();

        //get hot posts
        $data['hot_posts'] = DB::table('posts')
                    ->select('posts.*','tags.name as tag_name','tags.slug as tag_slug')
                    ->join('posts_tags','posts_tags.post_id','=','posts.id')
                    ->join('tags','tags.id','=','posts_tags.tag_id')
                    ->where('is_hot',1)
                    ->orderBy('id' , 'desc')
                    ->limit(7)
                    ->get();
        //get most_read_posts
        $data['most_read_posts'] = DB::table('posts')
                    ->select('posts.*')
                    // ->join('posts_tags','posts_tags.post_id','=','posts.id')
                    // ->join('tags','tags.id','=','posts_tags.tag_id')
                    // ->where('is_hot',1)
                    ->orderBy('view' , 'desc')
                    ->limit(10)
                    ->get();

    	
        return view('home.index',$data);
    }
}
