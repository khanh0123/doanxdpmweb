<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Tags; 

use DB;

class MenuController extends Controller
{
    // public function index(Request $request ) {
    // 	$data['info'] = Menu::all();
    // 	foreach ($data['info'] as $key => $value) {
    // 		$sub_menu = explode(",",$value->sub_menu);
    // 		$data_submenu = [];
    		
    // 		if(count($sub_menu) > 0){
    // 			for ($i = 0; $i < count($sub_menu); $i++) {
    // 				$dt = DB::table(get_table_name($sub_menu[$i]))
    // 						->where("id" ,'=', $sub_menu[$i])
    // 						->first();
    // 				if(!empty($dt)) $data_submenu[] = $dt;
    // 			}
    // 		}
    // 		$data['info'][$key]->sub_menu = $data_submenu;
    // 	}
    //     return $this->template_api($data);
    // }

    public function index(Request $request ) {
        $data['info'] = DB::table('menu')
            ->select("menu.*","tags.slug as tags_slug")
            ->join("Tags",  "Tags.id" , "=" , "tag_id");

            var_dump( $data);
            die();
        return $this->template_api($data);
    }
}
