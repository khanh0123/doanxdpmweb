<?php 

	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{


	public function _article_summary_WAR_article_summaryportlet_INSTANCE_Wcw5_parseImageURL($c){
		  $d="//vnreview.vn/image";
		  $a=strlen($c);
		  for($b=0;$b<$a;$b=$b+2){
		    if(($b+2)<$a){
		      $d=$d."/";
		      $d=$d.substr($c,$b,2);
		    }
		  }

		  $d=$d."/".$c.".jpg";
		  return $d;
	}


public function getContent($string)
{
	$content = file_get_contents($string);
	$pattern='/<div class="journal-content-article">(.*)<\/div>/imsU';
	preg_match_all($pattern, $content, $arr);
	return $arr[1][0];	
}

	 /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$result = DB::table('posts')->get();
    	if(count($result) == 0){
    		$string = file_get_contents(storage_path() . "/jsons/datapost.json");
    		$parse = json_decode($string,true);
    		
    		foreach ($parse['returnValue'] as $key=>$value)
    		{
    			$image = $value['imgId'];
    			$title = $value['title'];
    			$content =$value['url'];
    			$desc = $value['desc'];
    			DB::table('posts')->insert(
    				[
    					'title'=>$title,
    					'image'=>$image,
    					'content'=>$content,
    					'short_des'=>$desc,
    					'ad_id'=>'1',
    					'slug'=>create_slug($title),
    					'long_des'=>$desc

    				]
    			);
    		}

    	}
    }
    
}
  
?>