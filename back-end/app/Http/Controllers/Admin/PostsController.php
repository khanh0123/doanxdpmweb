<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Posts;
use App\Models\Tags;
use App\Models\Posts_Tags;
use Validator;
use Image;

class PostsController extends MainAdminController
{
	protected $model;
	protected $limit = 20;
	protected $view_folder = 'admin/posts/';

    protected $rules = [
        'insert' => [
            'title'     => 'required',
            'content'   => 'required',
            'slug'      => 'required',            
            'short_des' => '',            
            'long_des'  => '',            
            'tag_id'    => 'required|array|exists:tags,id',
            'image'     => 'required|image|mimes:jpeg,jpg,bmp,png|max:10000',
        ],
        'update' => [
            'title'     => 'required',
            'content'   => 'required',
            'slug'      => 'required',            
            'short_des' => '',            
            'long_des'  => '',            
            'tag_id'    => 'required|exists:tags,id',
            'image'     => 'image|mimes:jpeg,jpg,bmp,png',
        ]
    ];
    protected $columns_filter = [
        'name'         => 'movie.name',
        'runtime'      => 'movie.runtime',
        'epi_num'      => 'movie.epi_num',
        'is_hot'       => 'movie.is_hot',
        'is_new'       => 'movie.is_new',
        'release_date' => 'movie.release_date',
        'created_at'   => 'movie.created_at',
        'updated_at'   => 'movie.updated_at',
        'cat_id'       => 'movie.cat_id',
        'cat_slug'     => 'category.slug',
        'genre_id'     => 'genre.id',
        'cou_id'       => 'country.id',

        
    ];
    protected $columns_search = ['name'];
	

	public function __construct(Request $request) {
        $this->model = new Posts;
        parent::__construct($request);
    }
    /*
     * Show view add new item.
     */


    public function setItem($type , $req , &$item){

    	switch ($type) {
            case 'update':            
                if(empty($req->image_old)){
                    $this->rules[$type]['image'] = "required|".$this->rules[$type]['image'];

                }else {
                    $this->rules[$type]['image'] = $this->rules[$type]['image']."|nullable";
                }
                break;
            case 'insert':
                break;
        }
    	
        
    	$validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {
            
        	return [
        		'type' => 'error',
        		'msg' => $validator->errors()->first()
        	];
        }            
        $item->title        = $req->title;        
        $item->content      = $req->content;
        $item->slug         = $req->slug;           
        $item->short_des    = $req->input('short_des', '');
        $item->long_des     = $req->input('long_des', '');
        $item->ad_id        = $req->authUser->id;
        

        //upload images and generate thumbnail
        if( $req->file('image') ){
            $file = $req->file('image');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            
            $name = $filename.'-'.time().'.'.$extension;
            
            $file->move('uploaded/',$name);
            $images = url('/uploaded/'.$name);
            
        }
        
        if($type == 'update'){
            $images_old = $req->input('image_old');
            if($images_old && empty($images)){
                $images = $images_old;
            } 
        }

        if(empty($images)){
            return [
                'type' => 'error',
                'msg' => 'Hãy chọn ảnh hiển thị'
            ];
        }
		$item->images = $images;
        return [
        	'type' => 'success'
        ];

    }

    public function index(Request $request )
    {
        $filter         = $this->getFilter($request);
        $data['info']   = $this->model->get_page($filter , $request);

        // echo json_encode($data['info']);
        // die();
        $data['info']   = formatResult($data['info'],[
            'tags'         => ['tag_name','tag_slug'] ,
            ],'get');

        
        $data['filter'] = count($request->all()) > 0 ? $request->all() : $filter;        
        $data['more'] = $this->getDataNeed();
        return $this->template($this->view_folder."index",$data);
    }

    public function store(Request $request) {

        if($request->isMethod("post")){
            $item = $this->model;
            $result = $this->setItem('insert',$request, $item);
            if($result['type'] == 'success'){
                if($item->save()){


                //add data tags
                $arr_tag = array();                    

                //check exists tags
                for ($i = 0; $i < count($request->tag_id); $i++) {
                    $tag_id = $request->tag_id[$i];
                    $arr_tag[] = [
                        'tag_id'  => $tag_id,
                        'post_id' => $item->id
                    ];
                }         
                
                //insert tags
                if(!empty($arr_tag)){
                    Posts_Tags::insert($arr_tag);
                }
                    $result['msg'] = 'Thêm dữ liệu thành công';
                } else {
                    $result['msg'] = 'Thêm dữ liệu thất bại';
                }

            }

            $data['info'] = $item;
        } else {
            $result = '';
        }
        $data['more'] = $this->getDataNeed();
        return $this->template($this->view_folder."add",$data,$result);
    }

    /*
     * Show detail item that belongs to passed id.
     */
    public function detail(Request $request,$id)
    {
        $item = $this->model::find($id);


        if(empty($item)){
            return abort(404);
        }

        if($request->isMethod("post")){ //update
            // var_dump($item->images);
            // die();
            $result = $this->setItem('update',$request, $item);
            if($result['type'] == 'success'){
                if($item->save()){
                //add data tags
                    $arr_tag = array();

                //check exists tags
                    for ($i = 0; $i < count($request->tag_id); $i++) {
                        $tag_id = $request->tag_id[$i];
                        $arr_tag[] = [
                            'tag_id' => $tag_id,
                            'post_id' => $item->id,
                        ];
                    }   

                    Posts_Tags::where(['post_id' => $item->id])->delete();            

                    //insert tags
                    if(!empty($arr_tag)){
                        Posts_Tags::insert($arr_tag);
                    }
                    $result['msg'] = 'Cập nhật dữ liệu thành công';
                } else {
                    $result['msg'] = 'Cập nhật dữ liệu thất bại';
                }
            }


            if(!isset($item->tags)){
                $dataPost_Tag = Posts_Tags::where('post_id',$item->id)->select('post_id','tag_id')->get();                
                $item->tags = $dataPost_Tag->toArray();
            }
        } else {
            $dataPost_Tag = Posts_Tags::where('post_id',$item->id)->select('post_id','tag_id')->get();           
            $item->tags = $dataPost_Tag->toArray();
            $result = '';
        }

        
        
        $data['info'] = $item;
        $data['more'] = $this->getDataNeed();
        return $this->template($this->view_folder."detail",$data,$result);

    }


    public function search(Request $request)
    {
        $res = [];
        $post_title = $request->post_title;
        // $default_select = ['id','title','name'];
        if(empty($post_title)){
            $res['error'] = true;
            $res['msg'] = 'Tiêu đề không được để trống';
        } else {
            $data = $this->model->search(['posts.title','like',"%$post_title%"]);
            $res['success'] = true;
            $res['data'] = $data;
        }
        return Response()->json($res,200);
    }

    private function getDataNeed(){
        $data = array();
        $tag_model = new Tags();
        $tag_model = $tag_model->getall();
        if(count($tag_model) > 0) {
            foreach ($tag_model as $value){
                array_push($data, $value);
            }
        }
        return $data;
    }

}
