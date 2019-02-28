<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Movie_genre;
use App\Models\Movie;
use App\Models\Genre;
use Phpml\Classification\NaiveBayes;
use Phpml\Dataset\ArrayDataset;
use Storage;
class TestController extends Controller
{

	private $num_train = 1200;
	private function show($path){
		$files1 = scandir($path);
		foreach ($files1 as $value) {
			echo " - $value";
			if(strpos($value, '.') === false){
				echo "   ";
				$p = $path."\\$value";	
				
				$this->show($p);
			}
			echo "<br>";
		}
	}
	public function index()
	{
		die;
		// Get file listing...
		$dir = public_path();
		

		$this->show($dir);














		die;

		$googleDisk = Storage::disk('google');

		
		

        // Get file listing...
		$dir = '/';
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
        
        // Get file details...
        $file = $contents
        ->where('type', '=', 'file')        
        ->first(); // there can be duplicate file names!
        //return $file; // array with file info
        // Store the file locally...
        //$readStream = Storage::cloud()->getDriver()->readStream($file['path']);
        //$targetFile = storage_path("downloaded-{$filename}");
        //file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);
        // Stream the file to the browser...
        // return Response()->json($file);
        // echo "<pre>";
        // var_dump($file);
        // echo "</pre>";
        // die();
        
        $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
        // echo "<pre>";
        // var_dump($readStream);
        // echo "</pre>";
        // die();
        
        return response()->streamDownload(function () use ($readStream) {
        	// stream_get_contents($readStream,5);
        	fpassthru($readStream);
        }, 200, [
        	'Content-Type' => $file['mimetype'],
        	"Content-Length" =>  $file['size'],
        //'Content-disposition' => 'attachment; filename="'.$filename.'"', // force download?
        ]);



  //   	$this->filterMovie();
  //   	$this->filterGenre();
		// $path = storage_path() . "/jsons/demo/data_traning_1000_v4.json";
		// $path2 = storage_path() . "/jsons/demo/data_genre_1000_v4.json";
		// $data_training = json_decode(file_get_contents($path),true);        
		// $labels1 = json_decode(file_get_contents($path2),true);
		// echo "num train: ".count($data_training)."<br>";
		// echo "num label: ".count($labels1)."<br>";

  //       // $this->checkCorrectData($data_training,$labels1,1000);
  //       // 

		// $classifier = new NaiveBayes();
		// $classifier->train($data_training, $labels1);

  //   	//data test
		// $sum_data = 200;
		// $data_movie = Movie::skip(0)->take($sum_data)->orderBy("id","desc")->get();
		// $new_data = [];
		// foreach ($data_movie as $value) {
		// 	$new_data[] = [
		// 		$value->id,
		// 		// create_slug($value->name," "),
		// 		// create_slug($value->short_des," "),
		// 		$value->name,
		// 		$value->short_des,
		// 	];	
		// }
		// $predict = $classifier->predict($new_data);

		// $per_sum = 0;
		// for ($i = 0; $i < count($predict); $i++) {
		// 	$data_genres_predict = $this->getGenres($predict[$i]);
		// 	$data_genres_correct = Movie_genre::where("mov_id",$data_movie[$i]->id)
		// 	->select("movie_genre.gen_id","name")
		// 	->join("genre" , "genre.id" , "=" , "movie_genre.gen_id")
		// 	->groupBy("movie_genre.gen_id","name")
		// 	->get();

		// 	$data_genres_predict = $data_genres_predict->toArray();
		// 	$data_genres_correct = $data_genres_correct->toArray();
		// 	$data_genres_predict = array_column($data_genres_predict, "name");
		// 	$data_genres_correct = array_column($data_genres_correct, "name");

		// 	$number_correct = 0;
		// 	$ketqua = "Dự đoán phim ".$data_movie[$i]->name." thuộc thể loại: ";
		// 	$chinhxac = "Chính xác thuộc thể loại: ";
		// 	if(count($data_genres_correct) == 0){
		// 		$number_correct = 1;
		// 	} else {
		// 		for ($j = 0; $j < count($data_genres_predict); $j++) {
		// 			$ketqua.= $data_genres_predict[$j]." - ";
		// 			if(in_array($data_genres_predict[$j], $data_genres_correct)){
		// 				$number_correct++;
		// 			}
		// 		}

		// 		for ($k = 0; $k < count($data_genres_correct); $k++) {
		// 			$chinhxac.= $data_genres_correct[$k]." - ";
		// 		}

		// 	}
		// 	echo "Bộ phim thứ ".($i+1)." <br>";
		// 	echo $ketqua."<br>";
		// 	echo $chinhxac."<br>";
		// 	$per = ($number_correct/(count($data_genres_correct) > 0 ? count($data_genres_correct) : 1))*100;
		// 	$per_sum+=$per;
		// 	echo "Độ chính xác : ".($per)."%<br>";

		// 	echo "-------------------------------------------->>>><br>";

		// }
		// echo "Tổng xác xuất chính xác ".($per_sum/$sum_data)."%<br>";
		// die;
    	// $this->filterGenre();die;





	}

	private function checkCorrectData($datas,$genres,$num = 20)
	{
		foreach ($datas as $key => $value) {
    		// echo "<pre>";
    		// var_dump($datas[10]);
    		// echo "</pre>";
    		// die();

			if($key >= $num) break;
			$id = $value[0];
			$name = $value[1];

			$movie = Movie::where("id","=","$id")->first();

			$lstGenres = Movie_genre::where("mov_id",$movie->id)
			->select("movie_genre.gen_id","name")
			->join("genre" , "genre.id" , "=" , "movie_genre.gen_id")
			->groupBy("movie_genre.gen_id","name")
			->get();

    		// if($key == 25){
	    	// 		echo "<pre>";
	    	// 		var_dump($lstGenres);
	    	// 		echo "</pre>";
	    	// 		die();

	    	// 	}


			$preGenres = $this->getGenres($genres[$key]);

			$lstGenres = $lstGenres->toArray();
			$preGenres = $preGenres->toArray();


			$data_genres_predict = array_column($preGenres, "name");
			$data_genres_correct = array_column($lstGenres, "name");

    		// if($key == 10){
    		// 	echo "<pre>";
    		// 	var_dump($genres[$key]);
    		// 	echo "</pre>";
    		// 	// die();

    		// }

			$number_correct = 0;
			$ketqua = "Dự đoán phim ".$name." thuộc thể loại: ";
			$chinhxac = "Chính xác thuộc thể loại: ";
			if(count($data_genres_correct) == 0){
				$number_correct = 1;
			} else {
				for ($j = 0; $j < count($data_genres_predict); $j++) {
					$ketqua.= $data_genres_predict[$j]." - ";
					if(in_array($data_genres_predict[$j], $data_genres_correct)){
						$number_correct++;
					}
				}

				for ($k = 0; $k < count($data_genres_correct); $k++) {
					$chinhxac.= $data_genres_correct[$k]." - ";
				}
			}
			echo "Bộ phim thứ ".($key+1)." <br>";
			echo $ketqua."<br>";
			echo $chinhxac."<br>";
			$percent = ($number_correct/(count($data_genres_correct) > 0 ? count($data_genres_correct) : 1)*100);
			echo "Độ chính xác : ".$percent."%<br>";

			echo "-------------------------------------------->>>><br>";

		}
		die;
	}

	private function filterGenre()
	{
		$index_movie = [];

    	// echo count($data_movie);die;

		$data_gen = [];
		$num_current = 0;
		$max = 0;
		while (count($data_gen) < $this->num_train) {
			$data_movie = Movie::select("movie.*","movie_genre.gen_id")
			->skip($num_current)
			->take(500)
			->orderBy("id","desc")
			->leftJoin("movie_genre" , "movie.id" , "=" , "movie_genre.mov_id")
			->get();
			if(empty($data_movie))break;
			foreach ($data_movie as $key => $mov) {
				if(!isset($index_movie[$mov->id])){
					$data_gen[$max] = $this->initValueGenFilter();
					$index_movie[$mov->id] = $max;
					$max++;
				}
				$data_gen[$index_movie[$mov->id]][$this->getNum($mov->gen_id)] = 1;
			}
			$num_current+=500;

		}

		$data_gen = array_values($data_gen);
		foreach ($data_gen as $key => $value) {

			$new = '';
			foreach ($value as $k => $v) {    			
				$new.= $v . ($k< count($value) -1 ? "," : "");
			}
			$data_gen[$key] = $new;
		}
		$data_gen = array_slice($data_gen, 0,$this->num_train);


		$fp = fopen(storage_path() . "/jsons/demo/data_genre_1000_v4.json", 'w');
		fwrite($fp, json_encode($data_gen,JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS));
		fclose($fp);
    	// echo count($data_gen);die;

    	// echo json_encode($data_gen);die;
    	// echo json_encode($data_movie,JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);
	}

	private function filterMovie(){
		$data_movie = Movie::select("*")
		->limit($this->num_train)    		
		->orderBy("id","desc")
		->get();
		$new_data = [];
    	// echo "<pre>";
    	// var_dump($data_movie);
    	// echo "</pre>";
    	// die();

		foreach ($data_movie as $key => $value) {
    		// $new_data[$key][] = $value->id;
			$new_data[$key][] = $value->id;
			// $new_data[$key][] = create_slug($value->name," ");
			// $new_data[$key][] = create_slug($value->short_des," ");
			$new_data[$key][] = $value->name;
			$new_data[$key][] = $value->short_des;
    		// $new_data[$key][] = $value->slug;
			// $short_des = $value->short_des;
    		// var_dump($short_des);
    		// print_r($short_des);
    		// $short_des = preg_replace("/<(\/?)[a-z]+\>/", "", $short_des);
    		// echo "<br>";
    		// echo "<br>";
    		// echo "<br>";
    		// print_r($short_des);die;
    		// $new_data[$key][] = preg_replace("/<(\/?)[a-z]+\>/", "", $value->short_des);
    		// $new_data[$key][] = preg_replace("/<(\/?)[a-z]+\>/", "", $value->long_des);
    		// $new_data[$key][] = $value->runtime;
    		// $new_data[$key][] = $value->release_date;
    		// $new_data[$key][] = $value->epi_num;
    		// $new_data[$key][] = $value->cat_id;
		}
    	// echo "<pre>";
    	// var_dump($new_data);
    	// echo "</pre>";
    	// die();

		$new_data =  json_encode($new_data,JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);
		$fp = fopen(storage_path() . "/jsons/demo/data_traning_1000_v4.json", 'w');
		fwrite($fp, $new_data);
		fclose($fp);

	}


	private function getGenres($string)
	{
    	// var_dump($string);
		$lst_ID = [];
		$arr = explode(",",$string);
		for ($i = 0; $i < count($arr) ; $i++) {
			if($arr[$i] == 1){
    			// echo $i;
				$lst_ID[] = auto_increment_string_id('gen'.($i-1));
    			// echo auto_generate_id('gen006');
			}
		}

		$data = Genre::whereIn("id",$lst_ID)->get();
		return $data;


	}

	private function initValueGenFilter($max = 28)
	{
		$return = [];
		for ($i = 0; $i < $max; $i++) {
			$return[] = 0;
		}
		return $return;
	}

	private function getNum($id)
	{
		$reg = "/gen.([0-9]+)$/";
		$result = [];
		if(preg_match($reg, $id , $result)){

			return (int)$result[1];
		}
		return -1;
	}

	
}
