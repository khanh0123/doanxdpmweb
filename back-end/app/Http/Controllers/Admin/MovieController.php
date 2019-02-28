<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Movie;
use App\Models\Category; 
use App\Models\Genre; 
use App\Models\Country;
use App\Models\Movie_genre;
use App\Models\Movie_country;
use Validator;
use Image;

class MovieController extends MainAdminController
{
	protected $model;
	protected $limit = 20;
	protected $view_folder = 'admin/movie/';

    protected $rules = [
        'insert' => [
            'name'      => 'required',
            'runtime'   => 'required',
            'epi_num'   => 'required',
            'cat_id'    => 'required|exists:category,id',
            'genre'     => 'required|array',
            'genre.*'   => 'required|exists:genre,id',
            'country'   => 'required|array',
            'country.*' => 'required|exists:country,id',
            'image'     => 'required|image|mimes:jpeg,jpg,bmp,png|max:10000',
        ],
        'update' => [
            'name'             => 'required',
            'runtime'          => 'required',
            'epi_num'          => 'required',
            'cat_id'           => 'required|exists:category,id',
            'genre'            => 'required|array',
            'genre.*'          => 'required|exists:genre,id',
            'country'          => 'required|array',
            'country.*'        => 'required|exists:country,id',
            'listidimages_old' => 'array',
            'image'            => 'image|mimes:jpeg,jpg,bmp,png|max:10000',
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
        $this->model = new Movie;
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
            case 'insert':
                $item->total_rate = 0;
                $item->avg_rate   = 0;
                break;
            
        }
    	
        
    	$validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {
        	return [
        		'type' => 'error',
        		'msg' => $validator->errors()->has('images') ? 'Hãy chọn ít nhất 1 ảnh' : 'Vui lòng kiểm tra lại các trường nhập'
        	];
        }
        $item->name         = $req->name;
        $item->slug         = $req->slug;        
        $item->is_hot       = (int)$req->input('is_hot', 0);
        $item->is_new       = (int)$req->input('is_new', 0);
        $item->runtime      = (int)$req->input('runtime', 0);
        $item->epi_num      = (int)$req->input('epi_num', 1);
        $item->short_des    = $req->input('short_des', '');
        $item->long_des     = $req->input('long_des', '');
        $item->release_date = strtotime($req->input('release_date',date("Y-m-d")));
        $item->ad_id        = $req->authUser->id;
        $item->cat_id       = $req->input('cat_id');
        
        

        $images = [
            'poster' => [],
            'thumbnail' => []
        ];

        //upload images and generate thumbnail
        if( $req->file('image') ){
            $file = $req->file('image');
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            
            $name = preg_replace("/\ /", '-', $filename).'-'.time().'.'.$extension;
            $file->move('uploaded/',$name);
            $id = generate_id();
            $images['poster'] = [
                'id' => $id,
                'path' => '/uploaded/' . $name
            ];
            Image::make(public_path().'/uploaded/' . $name)->resize(600, 390)->save(public_path('/uploaded/thumbnail/' . $name));
            $images['thumbnail'] = [
                'id' => $id,
                'path' => '/uploaded/thumbnail/' . $name
            ];
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

        if(empty($images['poster'])){
            return [
                'type' => 'error',
                'msg' => 'Hãy chọn ảnh poster'
            ];
        }
		$item->images = json_encode($images);
        return [
        	'type' => 'success'
        ];

    }

    public function index(Request $request )
    {
        $filter         = $this->getFilter($request);
        $data['info']   = $this->model->get_page($filter , $request);
        $data['info']   = formatResult($data['info'],[
            'genre'         => ['gen_id','gen_name','gen_slug'] ,
            'country'       => ['cou_id' , 'cou_name' , 'cou_slug']
            ],'get');

        foreach ($data['info'] as $key => $value) {
            $data['info'][$key]->images = json_decode($data['info'][$key]->images);
        }
        
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


                //add data genre and country
                    $arr_gen = array();
                    $arr_cot = array();

                //check exists genre
                    for ($i = 0; $i < count($request->genre); $i++) {
                        $gen_id = $request->genre[$i];

                        if(Genre::find($gen_id)){
                            $arr_gen[] = [
                                'gen_id' => $gen_id,
                                'mov_id' => $item->id
                            ];
                        }
                    }
                //check exists country
                    for ($i = 0; $i < count($request->country); $i++) {
                        $cou_id = $request->country[$i];

                        if(Country::find($cou_id)){
                            $arr_cot[] = [
                                'cou_id' => $cou_id,
                                'mov_id' => $item->id
                            ];
                        }
                    }               

                //insert genre
                    if(!empty($arr_gen)){
                        Movie_genre::insert($arr_gen);
                    }
                //insert country
                    if(!empty($arr_cot)){
                        Movie_country::insert($arr_cot);
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
            $item->images = json_decode($item->images);
            $result = $this->setItem('update',$request, $item);
            if($result['type'] == 'success'){
                if($item->save()){
                //add data genre and country
                    $arr_gen = array();
                    $arr_cot = array();

                //check exists genre
                    for ($i = 0; $i < count($request->genre); $i++) {
                        $gen_id = $request->genre[$i];

                        if(Genre::find($gen_id)){
                            $arr_gen[] = [
                                'gen_id' => $gen_id,
                                'mov_id' => $item->id
                            ];
                        }
                    }
                //check exists country
                    for ($i = 0; $i < count($request->country); $i++) {
                        $cou_id = $request->country[$i];

                        if(Country::find($cou_id)){
                            $arr_cot[] = [
                                'cou_id' => $cou_id,
                                'mov_id' => $item->id
                            ];
                        }
                    }         

                    $data_mov_gen = Movie_genre::where(['mov_id' => $item->id])->get();
                    $data_mov_cot = Movie_country::where(['mov_id' => $item->id])->get();

                    for ($i = 0; $i < count($data_mov_gen); $i++) {
                        if(!in_array($data_mov_gen[$i], $arr_gen)){
                            Movie_genre::where(
                                ['mov_id'=> $data_mov_gen[$i]->mov_id],
                                ['gen_id' => $data_mov_gen[$i]->gen_id]
                            )->delete();
                        } else {
                            array_push($arr_gen, $data_mov_gen[$i]);
                        }
                    }
                    for ($i = 0; $i < count($data_mov_cot); $i++) {
                        if(!in_array($data_mov_cot[$i], $arr_cot)){
                            Movie_country::where(['mov_id'=> $data_mov_cot[$i]->mov_id],['cou_id' => $data_mov_cot[$i]->cou_id])->delete();
                        } else {
                            array_push($arr_cot, $data_mov_cot[$i]);
                        }
                    }

                //insert genre
                    if(!empty($arr_gen)){
                        Movie_genre::insert($arr_gen);
                    }
                //insert country
                    if(!empty($arr_cot)){
                        Movie_country::insert($arr_cot);
                    }
                    $item->genre = $arr_gen;
                    $item->country = $arr_cot;
                    $result['msg'] = 'Cập nhật dữ liệu thành công';
                } else {
                    $result['msg'] = 'Cập nhật dữ liệu thất bại';
                }
            }


            if(!isset($item->genre) || !isset($item->country)){
                $dataMovGen = Movie_genre::where('mov_id',$item->id)->get();
                $dataMovCot = Movie_country::where('mov_id',$item->id)->get();
                $item->genre = $dataMovGen->toArray();
                $item->country = $dataMovCot->toArray();
            }
        } else {
            $dataMovGen = Movie_genre::where('mov_id',$item->id)->get();
            $dataMovCot = Movie_country::where('mov_id',$item->id)->get();
            $item->genre = $dataMovGen->toArray();
            $item->country = $dataMovCot->toArray();
            $result = '';
        }

        

        $item->images = json_decode($item->images);
        
        $data['info'] = $item;
        $data['more'] = $this->getDataNeed();
        
        
        return $this->template($this->view_folder."detail",$data,$result);

    }


    public function search(Request $request)
    {
        $res = [];
        $mov_name = $request->mov_name;
        // $default_select = ['id','title','name'];
        if(empty($mov_name)){
            $res['error'] = true;
            $res['msg'] = 'Tên phim không được để trống';
        } else {
            $data = $this->model->search(['movie.name','like',"%$mov_name%"]);
            $res['success'] = true;
            $res['data'] = $data;
        }
        return Response()->json($res,200);
    }
    public function switch(Request $request)
    {
        $id = $request->id;
        $this->model = $this->model::findOrFail($id);
        
        
        $is_banner = $request->is_banner;
        if(is_numeric($request->is_hot)){
            $is_hot = (int)$request->is_hot;
            $this->model->is_hot = $is_hot;
        }
        if(is_numeric($request->is_new)){
            $is_new = (int)$request->is_new;
            $this->model->is_new = $is_new;
        }
        if(is_numeric($request->is_banner)){
            $is_banner = (int)$request->is_banner;
            $this->model->is_banner = $is_banner;
        }
        
        if($this->model->update()){
            return Response()->json(['success' => true,'data' => $this->model]);
        }
        return Response()->json(['error' => true]);


    }
    private function getDataNeed(){
        $cat_model = new Category();
        $gen_model = new Genre();
        $cot_model = new Country();

        $data_cat = $cat_model->getall();
        $data_gen = $gen_model->getall();
        $data_cot = $cot_model->getall();
        return [
        	'category' => $data_cat,
        	'genre' => $data_gen,
        	'country' => $data_cot,
        ];
    }

}
