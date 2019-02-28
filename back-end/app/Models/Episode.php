<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Episode extends Model
{
   	protected $table = 'episode';

    // public function get($limit = 20 , $sort = 'asc')
    // {
    // 	$data = DB::table($this->table)
    // 				->orderBy('id', $sort)
    // 				->paginate($limit);    				
    // 	return $data;
    // }
    public function getByMovie($filter = [] , $req = '')
    {

        $result     = $this->getListId($filter , $req);
        $list_epi_id = array_column($result->items(), "id");

        $data = DB::table($this->table)
                    ->select(
                        'episode.*',
                        'episode_video.video_id',
                        'video.source_link',
                        'video.source_name',
                        'video.max_qualify',
                        'video.created_at as video_created_at',
                        'video.updated_at as video_updated_at',
                    )
                    ->leftJoin('episode_video' , 'episode_video.epi_id' , '=' , 'episode.id')
                    ->leftJoin('video' , 'episode_video.video_id' , '=' , 'video.id')
                    ->orderBy($filter['orderBy'], $filter['sort'])
                    ->whereIn('episode.id',$list_epi_id);
        $data = $data->get();
        $arr_keys = $result->keys();
        for ($i = 0; $i < count($result); $i++) {
            $result->forget($result[$i]);     
        }
        for ($i = 0; $i < count($data); $i++) {
            $result->offsetSet($i,$data[$i]);     
        }
        
        return $result;
    }

    public function getById($filter = [] , $req = '')
    {
        $data = DB::table($this->table)
                    ->select(
                        'episode.*',
                        'episode_video.video_id',
                        'video.source_link',
                        'video.source_name',
                        'video.max_qualify',
                        'video.created_at as video_created_at',
                        'video.updated_at as video_updated_at',
                    )
                    ->leftJoin('episode_video' , 'episode_video.epi_id' , '=' , 'episode.id')
                    ->leftJoin('video' , 'episode_video.video_id' , '=' , 'video.id')
                    ->orderBy($filter['orderBy'], $filter['sort']);
        $data = addConditionsToQuery($filter['conditions'],$data);
        $data = $data->get();
        return $data;
    }

    public function get_all_episode_has_create($mov_id , $sort = 'asc')
    {
    	$data = DB::table($this->table)
    				->select('episode')
    				->where('mov_id', $mov_id)
    				->orderBy('episode', $sort)
    				->get();
    	return $data;
    }

    private function getListId($filter , $req){
        $result = DB::table($this->table)
            ->select('episode.id')
            ->leftJoin('episode_video' , 'episode_video.epi_id' , '=' , 'episode.id')
            ->leftJoin('video' , 'episode_video.video_id' , '=' , 'video.id')
            ->groupBy('episode.id')
            ->orderBy($filter['orderBy'], $filter['sort']);
        
        $result = addConditionsToQuery($filter['conditions'],$result);
        $result = $result->paginate($filter['limit']);
        $result->appends($req->all())->links();
        return $result;
    }
}