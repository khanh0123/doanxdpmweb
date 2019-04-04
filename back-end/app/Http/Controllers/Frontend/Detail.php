<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Menu;
use App\Models\Posts_tags; 
use DB;

class Detail extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        
    }
    public function index(Request $request,$slug,$id){
        //get info post
    	$data['post_info'] = DB::table('posts')
    	->select('posts.*','tags.name as tag_name','tags.slug as tag_slug')
    	->join('posts_tags','posts_tags.post_id','=','posts.id')
    	->join('tags','tags.id','=','posts_tags.tag_id')
    	->where('posts.id',$id)
    	->first();
    	if(empty($data['post_info'])) {
    		abort(404);
    	}
        if($data['post_info']->slug !== $slug){
        	return Redirect()->route('Frontend.Detail.index' , ['id' => $id,'slug' => $data['post_info']->slug]);
        }
        

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

    	
        return $this->template_fe('frontend.detail',$data);
    }
}
