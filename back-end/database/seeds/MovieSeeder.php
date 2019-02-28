<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //code để gộp file json lại thành 1 file
        // $data = [];
        // for ($i = 1; $i < 15; $i++) {
        //     $path = storage_path() . "/jsons/phimle$i.json";
        //     $json = json_decode(file_get_contents($path));
        //     $data = array_merge($data,$json->data);

        // }

        // $data = json_encode(array_reverse($data),JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);
        // $fp = fopen(storage_path() . "/jsons/phimle.json", 'w');
        // fwrite($fp, $data);
        // fclose($fp);


        $result = DB::table('movie')->get();
        if(count($result) == 0){
            $path = storage_path() . "/jsons/phimbo1.json"; // ie: /var/www/laravel/app/storage/json/filename.json

            $items = json_decode(file_get_contents($path)); 

            $data = $items->items;
            $array_data = [];
            foreach ($data as $key => $value) {

                $images = [];
                $id = generate_id();
                $images = [
                    'poster' => [
                        'id' => $id,
                        'url' => $value->images->vod_thumb_big
                    ],
                    'thumbnail' => [
                        'id' => $id,
                        'url' => $value->images->poster
                    ],
                ];
                // foreach ($value->images as $k => $v) {
                //     if($v != ''){
                //         $images = [
                //             'poster' => [
                //                 'id' => $id,
                //                 'url' => $v
                //             ],
                //             'thumbnail' => [
                //                 'id' => $id,
                //                 'url' => $value->thumbnail
                //             ],
                //         ];
                //     }                                
                // }

                $array_data[] = [
                    'name'         => $value->title,
                    'slug'         => create_slug($value->title),
                    'total_rate'   => 0,
                    'avg_rate'     => 0,
                    'is_hot'       => rand(0,1),
                    'is_new'       => rand(0,1),
                    'is_banner'    => rand(0,1),
                    'runtime'      => $value->runtime,
                    'epi_num'      => $value->episode,                    
                    'short_des'    => $value->short_description,
                    'long_des'     => $value->long_description,
                    'release_date' => strtotime($value->release_date),
                    'ad_id'        => 1,
                    'cat_id'       => "cat001",
                    'images'       => json_encode($images)
                ];
            }
            $array_data = array_reverse($array_data);
            
            DB::table('movie')->insert($array_data);

            //Thêm phim lẻ
            $path = storage_path() . "/jsons/phimle.json";
            $data = json_decode(file_get_contents($path));
            // $data = array_reverse($data);
            // echo json_encode($data,JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);

            // $data = $json->data;
            $array_data = [];
            $row_count_inserted = 0;
            $nextId = DB::table('movie')->max('id') + 1;

            foreach ($data as $key => $value) {

                $id = generate_id();
                $images = [
                    'thumbnail' => [
                        'id'  => $id,
                        'url' => $value->thumbnail
                    ],
                    'poster' => [
                        'id'  => $id,
                        'url' => $value->poster
                    ]

                ];
                $array_data[] = [
                    'name'         => $value->name,
                    'slug'         => create_slug($value->name),
                    'total_rate'   => 0,
                    'avg_rate'     => 0,
                    'is_hot'       => rand(0,1),
                    'is_new'       => rand(0,1),
                    'is_banner'    => rand(0,1),
                    'runtime'      => (int)$value->time,
                    'epi_num'      => 1,
                    'short_des'    => strip_tags($value->description),
                    'long_des'     => strip_tags($value->description),
                    'release_date' => time(),
                    'ad_id'        => 1,
                    'cat_id'       => "cat002",
                    'trailer'      => $value->trailer,
                    'images'       => json_encode($images)
                ];
                if($row_count_inserted < 300)
                    $row_count_inserted ++;
                else {
                    $array_data = array_reverse($array_data);
                    DB::table('movie')->insert($array_data);
                    $row_count_inserted = 0;
                    $array_data = [];
                }
            }

            //insert genre of movie
            DB::table('movie')->insert($array_data);
            $arr_genre = [];
            $row_count_inserted = 0;
            foreach ($data as $key => $value) {

                foreach ($value->genres->data as $v) {

                    $gen = DB::table("genre")->where("name","like","%$v->name%")->first();
                    if(empty($gen)){
                        echo "không tồn tại thể loại $v->name";
                        continue;
                    }
                    $mov = DB::table("movie")->where("name","like","%$value->name%")->first();
                    $arr_genre[] = [
                        'gen_id' => $gen->id,
                        'mov_id' => $mov->id
                    ];
                }

                if($row_count_inserted < 300)
                    $row_count_inserted ++;
                else {
                    DB::table('movie_genre')->insert($arr_genre);
                    $row_count_inserted = 0;
                    $arr_genre = [];
                }
            }
            DB::table('movie_genre')->insert($arr_genre);
        }
    }
}
