<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Posts;

class PostsController extends Controller
{
	protected $model;
	protected $limit = 20;
    protected $columns_filter = [
        'title'      => 'posts.title',
        'is_hot'     => 'posts.is_hot',
        'is_new'     => 'posts.is_new',
        'slug'       => 'posts.slug',
        'tag_id'     => 'tags.id',
        'tag_name'   => 'tags.name',
        'tag_slug'   => 'tags.slug',
        'created_at' => 'posts.created_at',
        'updated_at' => 'posts.updated_at',
       

        
    ];
    protected $columns_search = ['name'];
	

	public function __construct(Request $request) {
        $this->model = new Posts;
        // parent::__construct($request);
    }
    /*
     * Show view add new item.
     */

    public function index(Request $request )
    {
        $filter         = $this->getFilter($request);
        $data['info']   = $this->model->get_page($filter , $request);                        
        return $this->template_api($data);
    }


    /*
     * Show detail item that belongs to passed id.
     */
    public function detail(Request $request,$id)
    {
        $filter         = $this->getFilter($request);
        $filter['conditions']['and'][] = ['posts.id','=',$id];
        $data['info']   = $this->model->get_page($filter , $request);
        $data['info']   = formatResult($data['info'])[0];
        
                
        return $this->template_api($data);
    }
        


    

}
