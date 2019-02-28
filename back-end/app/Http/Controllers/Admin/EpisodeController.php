<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// use App\Http\Controllers\Admin\MainAdminController;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use App\Models\Episode;
use App\Models\Episode_video;
use App\Models\Movie;
use App\Models\Video;
use Validator;
class EpisodeController extends MainAdminController
{
	protected $model;
	protected $view_folder = 'admin/episode/';

    protected $rules = [
        'insert' => [
            'title'      => 'required',
            'video_id'   => 'required|array',
            'video_id.*' => 'required|exists:video,id',
            'images'     => 'array',
            'images.*'   => 'image|mimes:jpeg,jpg,bmp,png|max:10000|nullable'
            
        ],
        'update' => [
            'title'            => 'required',           
            'video_id'         => 'required|array',
            'video_id.*'       => 'required|exists:video,id',    
            'images'           => 'array',
            'images.*'         => 'image|mimes:jpeg,jpg,bmp,png|max:10000|nullable',
            'listidimages_old' => 'array',
        ]
    ];
    protected $columns_filter = [
        'slug'       => 'episode.slug',
        'title'      => 'episode.title',
        'mov_id'     => 'episode.mov_id',
        'video_id'   => 'episode_video.video_id',
        'episode'    => 'episode.episode',
        'created_at' => 'episode.created_at',
        'created_at' => 'episode.updated_at',
        
        
    ];
    protected $columns_search = ['title'];

	public function __construct(Request $request) {
		$mov_id = $request->route('mov_id');
		$movie = Movie::find($mov_id);
		if(empty($movie)){
			abort(404);
		}
		$request->movie = $movie;
        $this->model = new Episode;
    }


    public function setItem($type , $req , &$item){

        $link_play = [];
        $images = [];

        $validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {                               
        	
            return [
                'type' => 'error',
                'msg' => 'Vui lòng kiểm tra lại các trường nhập'
            ];
        }

        switch ($type) {
            case 'insert':
                if((int)$req->episode !== (int)$item->episode){
                    if($this->model::where([
                        ['episode',$req->episode],
                        ['mov_id',$req->route('mov_id')]
                    ])->first()){
                        return [
                            'type' => 'error',
                            'msg'  => 'Tập phim này đã tồn tại'
                        ];
                    }
                }
                break;
            case 'update':
                //check the images old
                $images_old = $req->input('listidimages_old' , []);
                
                if(!empty($item->images)){
                    foreach ($item->images as $index => $img) {
                        if(in_array($img->id, $images_old) ){                    
                            array_push($images, $img);
                        } else {
                            File::delete(public_path().$img->path);
                        }
                    }
                }
                
                
            default:
                break;
        }


        // $images = array();
        //upload multiple images
		if($files = $req->file('images')){
			foreach($files as $file){
                $filename  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
				
				$name = preg_replace("/\ /", '-', $filename).'-'.time().'.'.$extension;
				$file->move('uploaded/',$name);
				$images[] = [
                    'id'   => generate_id(),
                    'path' => '/uploaded/' . $name
				];
			}
		}

        
        $item->images    = json_encode($images);
        $item->mov_id    = $req->movie->id;
        $item->title     = $req->title;
        $item->episode   = (int)$req->episode;
        $item->short_des = $req->input('short_des' , '');
        $item->long_des  = $req->input('long_des' , '');
        $item->slug      = create_slug($req->slug ? $req->slug : $req->title);

        return [
            'type' => 'success'
        ];
        
    }

    public function _index(Request $request , $mov_id ) {        
        $filter                        = $this->getFilter($request);
        $filter['conditions']['and'][] = ['episode.mov_id', '=' , $request->route('mov_id')];
        $data['info']                  = $this->model->getByMovie($filter,$request);
        $data['more']                  = $this->getDataNeed($request);
        $data['movie']                 = $request->movie;
        $data['filter']                = $request->all();

        $data['info'] = formatResult($data['info'],[
            'videos' => ['video_id','source_link','source_name','max_qualify','video_created_at','video_updated_at'] ,
        ],'get');

        return $this->template($this->view_folder."index",$data);
    }

    /*
     * Show view add new item.
     */

    public function store(Request $request)
    {
    	if($request->isMethod("post")){ //insert
            $item = $this->model;
            $result = $this->setItem('insert',$request, $item);
            if($result['type'] == 'success'){
                if($item->save()){
                    //add data genre and country
                    $arr_video = array();

                    //check exists genre
                    for ($i = 0; $i < count($request->video_id); $i++) {

                        $arr_video[] = [
                            'video_id' => $request->video_id[$i],
                            'epi_id'   => $item->id
                        ];
                    }
                    if(!empty($arr_video)){
                        Episode_video::insert($arr_video);
                    }

                    $result['msg'] = 'Thêm dữ liệu thành công';
                }
                
            }
        } else {
            $result = '';
        }
        $data['more']  = $this->getDataNeed($request);
        $data['movie'] = $request->movie;
        return $this->template($this->view_folder."add",$data,$result);
    }

    

    /*
     * Show detail item that belongs to passed id.
     */
    public function _detail(Request $request,$mov_id,$id)
    {
        

        $item = $this->model::find($id);
        if(empty($item)){
            return abort(404);
        }

        
        
        if($request->isMethod("post")){
            $item->images = json_decode($item->images);
            $result = $this->setItem('update',$request, $item);
            if($result['type'] == 'success'){
                if($item->update()){
                    //add data genre and country
                    $arr_video = array();

                    //check exists genre
                    for ($i = 0; $i < count($request->video_id); $i++) {

                        $arr_video[] = [
                            'video_id' => $request->video_id[$i],
                            'epi_id'   => $item->id
                        ];
                    }

                    //get 
                    Episode_video::where(['epi_id'=> $id])->delete();
                    if(!empty($arr_video)){
                        Episode_video::insert($arr_video);
                    }
                }
                $item->images = json_decode($item->images);
                $result['msg'] = 'Cập nhật dữ liệu thành công';         
            }
        } else {
            $result = '';
        }
        $filter                        = $this->getFilter($request);
        $filter['conditions'] = ['and' => [],'or' => []];
        $filter['conditions']['and'][] = ['episode.id', '=' , $id];
        $items = $this->model->getById($filter,$request);
        // echo "<pre>";
        // var_dump($filter);
        // echo "</pre>";
        // die();
        
        $items = formatResult($items,[
            'videos' => ['video_id','source_link','source_name','max_qualify','video_created_at','video_updated_at'] ,
        ]);
        $item = $items[0];
        $item->images = json_decode($item->images);
        
        $data['info']  = $item;
        $data['more']  = $this->getDataNeed($request);
        $data['movie'] = $request->movie;
        return $this->template($this->view_folder."detail",$data,$result);
    }

    /*
     * Delete item that belongs to passed id.
     */

    public function _delete(Request $request,$mov_id, $id) {
        $item = $this->model::find($id);
        if(empty($item)){
            return abort('404');
        }
        $item->delete();

        return Redirect::to("admin/movie/$mov_id/episode")
                ->withMessage(['type' => 'success','msg' => 'Xóa dữ liệu thành công']);
    }

    public function clone(Request $request , $mov_id)
    {

        $how_creating = $request->how_creating;
        
        if(in_array($how_creating, ['default','options'])){
            $from = (int)$request->from;
            //check exists episode
            if($episode = $this->model::where([
                ['episode',$from],
                ['mov_id',$request->route('mov_id')]
            ])->first()){               
                

                //get list episodes exists
                // $data_episodes = $this->model->get_all_episode_has_create($request->route('mov_id'));
                $episodes_created = $this->getDataNeed($request);

                $list_episodes = array();
                //clone all episode missing
                if($how_creating == 'default'){
                    for ($i = 1; $i <= $request->movie->epi_num; $i++) {
                        if(!in_array($i, $episodes_created)){
                            $new_episode = array(
                                'mov_id'    => $episode->mov_id,
                                'slug'      => str_replace($episode->episode, $i , $episode->slug),
                                'title'     => str_replace($episode->episode, $i , $episode->title),
                                'images'    => $episode->images,
                                'short_des' => $episode->short_des,
                                'long_des'  => $episode->long_des,
                                'episode'   => $i,
                            );
                            array_push($list_episodes, $new_episode);
                        }
                    }
                    
                } else { //clone episode by epi_num
                    $list_epi_needs = $request->needs ? $request->needs : [];
                    for ($i = 0; $i < count($list_epi_needs); $i++) {
                        if(!in_array($list_epi_needs[$i],$episodes_created) && $list_epi_needs[$i] > 0 && $list_epi_needs[$i] <= $request->movie->epi_num){
                            $new_episode = array(
                                'mov_id'    => $episode->mov_id,
                                'slug'      => str_replace($episode->episode, $list_epi_needs[$i] , $episode->slug),
                                'title'     => str_replace($episode->episode, $list_epi_needs[$i] , $episode->title),
                                'images'    => $episode->images,
                                'short_des' => $episode->short_des,
                                'long_des'  => $episode->long_des,
                                'episode'   => (int)$list_epi_needs[$i],
                            );
                            
                            array_push($list_episodes, $new_episode);
                        }
                    }
                }

                
                if(Episode::insert($list_episodes)){

                    $message = ['type' => 'success','msg' => 'Sao chép thành công'];

                } else {

                    $message = ['type' => 'error','msg' => 'Sao chép không thành công'];

                }

            } else {

                $message = ['type' => 'error','msg' => 'Tập phim không tồn tại'];

            }
        } else {

            $message = ['type' => 'error','msg' => 'Sao chép không thành công'];

        }

        return redirect()->back()
                ->withMessage($message);
    }

    protected function getDataNeed($request)
    {
    	$data_episodes = $this->model->get_all_episode_has_create($request->route('mov_id'));
    	$episodes_created = [];
    	foreach ($data_episodes as $value) {
    		$episodes_created[] = $value->episode;
    	}
    	return $episodes_created;
    }
}
