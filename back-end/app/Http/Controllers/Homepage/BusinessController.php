<?php

namespace App\Http\Controllers\Homepage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Posts_Tags; 
use DB;

class BusinessController extends Controller
{
    public function getIndex(){
    	$data_post=[];
    	$data_post_tag=Posts_Tags::where('tag_id',4)->limit(6)->get();
    	foreach ($data_post_tag as $value ) {
    		$data=Posts::where('id',$value->post_id)->get();
    		if (!empty($data)) $data_post[]= $data;
    	}
    	// echo "<pre>";
    	// var_dump($data_post);
    	// echo "</pre>";
    	//dd($data_post);
        return view('Homepage.Home',compact('Business','data_post'));
    }
}
