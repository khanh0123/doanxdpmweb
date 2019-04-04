<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Tags; 

use DB;

class MenuController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new Menu;
    }
    protected $model;
    protected $limit = 20;
    protected $columns_filter = [
        'title'      => 'menu.title',
        'is_hot'     => 'menu.is_hot',
        'is_new'     => 'menu.is_new',
        'slug'       => 'menu.slug',
        'tag_id'     => 'menu.tag_id',
        'tag_name'   => 'menu.tag_name',
        'tag_slug'   => 'menu.tag_slug',
        'created_at' => 'menu.created_at',
        'updated_at' => 'menu.updated_at',
       

        
    ];
    public function index(Request $request ) {
        $filter         = $this->getFilter($request);
        $menu   = $this->model->get_page($filter , $request);
        
        foreach ($menu as $key => $value) {
            $count_post = DB::table('posts_tags')->where('tag_id',$value->tag_id)->count();
            $menu[$key]->num_post = $count_post;
        }
        $data['info'] = $menu->getCollection();
        return $this->template_api($data);
    }
}
