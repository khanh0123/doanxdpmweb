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
            'title'      => 'required',
            'content'   => 'required',
            'slug'   => 'required',            
            'short_des'   => 'required',            
            'long_des'   => 'required',            
            'tag_id'     => 'required|array',
            'image'     => 'required|image|mimes:jpeg,jpg,bmp,png|max:10000',
        ],
        'update' => [
            'title'      => 'required',
            'content'   => 'required',
            'slug'   => 'required',            
            'short_des'   => 'required',            
            'long_des'   => 'required',            
            'tag_id'     => 'required|array',
            'image'     => 'required|image|mimes:jpeg,jpg,bmp,png|max:10000',
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
                if(empty($req->listidimages_old) || count($req->listidimages_old) == 0){
                    $this->rules[$type]['image'] = "required|".$this->rules[$type]['image'];
                }else {
                    $this->rules[$type]['image'] = $this->rules[$type]['image']."|nullable";
                }
                break;
            case 'insert':
                if($this->model::where([
                        ['title',$req->title]
                    ])->first()){
                        return [
                            'type' => 'error',
                            'msg'  => 'Bản tin này đã tồn tại'
                        ];
                    }
                    break;
        }
    	
        
    	$validator = Validator::make($req->all(), $this->rules[$type]);
        // var_dump($req->all());
        // die();
        if ($validator->fails()) {
        	return [
        		'type' => 'error',
        		'msg' => $validator->errors()->has('images') ? 'Hãy chọn ít nhất 1 ảnh' : 'Vui lòng kiểm tra lại các trường nhập'
        	];
        }            
        $item->title        = $req->title;        
        $item->content      = $req->content;
        $item->slug         = $req->slug;           
        $item->short_des    = $req->input('short_des', '');
        $item->long_des     = $req->input('long_des', '');
        $item->ad_id        = $req->authUser->id;
        
        

        // $images = [
        //     'poster' => [],
        //     'thumbnail' => []
        // ];

        //upload images and generate thumbnail
        if( $req->file('image') ){
            $file = $req->file('image');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            
            $name = preg_replace("//", '-', $filename).'-'.time().'.'.$extension;
            $file->move('uploaded/',$name);
            $id = generate_id();
            $images = '/uploaded/'.$name;
            // Image::make(public_path().'\uploaded\\' . $name)->resize(600, 390)->save(public_path('\uploaded\thumbnail\\' . $name));
            // $images['thumbnail'] = [
            //     'id' => $id,
            //     'path' => '/uploaded/thumbnail/' . $name
            // ];
        }
        
        if($type == 'update'){
            $images_old = $req->input('listidimages_old' , []);
            if(in_array($item->images->poster->id, $images_old) && empty($images['poster'])){
                $images['poster'] = $item->images->poster;
                $images['thumbnail'] = $item->images->thumbnail;

            } else {
                
                if(!empty($item->images->poster->path)){
                    $path = preg_replace("/^(\/)(.*)/", "$2",$item->images->poster->path );
                    
                    File::delete(public_path( $path ));
                }
                if(!empty($item->images->thumbnail->path)){
                    $path = preg_replace("/^(\/)(.*)/", "$2",$item->images->thumbnail->path );
                    File::delete(public_path($path));
                }
            }   
        }

        if(empty($images)){
            return [
                'type' => 'error',
                'msg' => 'Hãy chọn ảnh poster'
            ];
        }
        // var_dump($images);
        // die();
		$item->images = json_encode($images);
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

                        if(Tags::find($tag_id)){
                            $arr_tag[] = [
                                'tag_id' => $tag_id,
                                'post_id' =>$item->id
                            ];
                        }
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

                        if(Tags::find($tag_id)){
                            $arr_tag[] = [
                                'tag_id' => $tag_id,
                            ];
                        }
                    }   

                    $data_post_tag = Posts_Tags::where(['post_id' => $item->id])->get();  
                    // var_dump($data_post_tag);
                    // die();                 

                    for ($i = 0; $i < count($data_post_tag); $i++) {
                        if(!in_array($data_post_tag[$i], $arr_tag)){
                            Posts_Tags::where(
                                ['tag_id' => $data_post_tag[$i]->tag_id]
                            )->delete();
                        } else {
                            array_push($arr_tag, $data_post_tag[$i]);
                        }
                    }

                //insert tags
                    if(!empty($arr_tag)){
                        Posts_Tags::insert($arr_tag);
                    }
                    $item->tags = $arr_tag;
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

        
        // var_dump($item->images) ;
        // die();
        
        
        $data['info'] = $item;
        $data['more'] = $this->getDataNeed();
        //echo "<pre>";
        //print_r($data);
        
        // echo json_encode($dataPost_Tag);
        // die();
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
    // public function switch(Request $request)
    // {
    //     $id = $request->id;
    //     $this->model = $this->model::findOrFail($id);
        
        
    //     $is_banner = $request->is_banner;
    //     if(is_numeric($request->is_hot)){
    //         $is_hot = (int)$request->is_hot;
    //         $this->model->is_hot = $is_hot;
    //     }
    //     if(is_numeric($request->is_new)){
    //         $is_new = (int)$request->is_new;
    //         $this->model->is_new = $is_new;
    //     }
    //     if(is_numeric($request->is_banner)){
    //         $is_banner = (int)$request->is_banner;
    //         $this->model->is_banner = $is_banner;
    //     }
        
    //     if($this->model->update()){
    //         return Response()->json(['success' => true,'data' => $this->model]);
    //     }
    //     return Response()->json(['error' => true]);


    // }
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
