<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// $result = DB::table('country')->get();
    	// if(count($result) == 0){
     //    	$path = storage_path() . "/jsons/all_countries_codes.json";
     //    	$jsons = json_decode(file_get_contents($path)); 

     //    	$id = "cou001";
     //    	$array_data = [];
     //    	foreach ($jsons as $key => $value) {

     //    		$array_data[] = [
     //    			'id' => $id,
     //    			'name' => $value->name,
     //    			'slug' => create_slug($value->name),
     //    			'code' => $value->alpha_2,
     //    		];
     //    		$id = auto_increment_string_id($id);
     //    	}
     //    	// echo json_encode($array_data);
     //    	// die;
        	// $array_data = array_reverse($array_data);
        	// DB::table('country')->insert($array_data);
        	// DB::table('max_id')->insert(
        	// 	[
        	// 		'table_name' => 'country',
        	// 		'max_id' => $id
        	// 	],
        	// );
     //    }
        $array_data = [];
        $array_data[] = [
           'id'   => 'cou001',
           'name' => 'Việt Nam',
           'slug' => create_slug('Việt Nam'),
           'code' => 'VI',
        ];
        $array_data[] = [
           'id'   => 'cou002',
           'name' => 'Trung Quốc',
           'slug' => create_slug('Trung Quốc'),
           'code' => 'CN',
        ];
        $array_data[] = [
           'id'   => 'cou003',
           'name' => 'Mỹ',
           'slug' => create_slug('Mỹ'),
           'code' => 'US',
        ];
        $array_data[] = [
           'id'   => 'cou004',
           'name' => 'Hồng Kông',
           'slug' => create_slug('Hồng Kông'),
           'code' => 'HK',
        ];
        $array_data[] = [
           'id'   => 'cou005',
           'name' => 'Ấn Độ',
           'slug' => create_slug('Ấn Độ'),
           'code' => 'AD',
        ];
        $array_data[] = [
           'id'   => 'cou006',
           'name' => 'Nga',
           'slug' => create_slug('Nga'),
           'code' => 'N',
        ];
        $array_data[] = [
           'id'   => 'cou007',
           'name' => 'Hàn Quốc',
           'slug' => create_slug('Hàn Quốc'),
           'code' => 'HQ',
        ];
        $array_data[] = [
           'id'   => 'cou008',
           'name' => 'Thái Lan',
           'slug' => create_slug('Thái Lan'),
           'code' => 'TL',
        ];
        $array_data[] = [
           'id'   => 'cou009',
           'name' => 'Pháp',
           'slug' => create_slug('Pháp'),
           'code' => 'P',
        ];
        $array_data[] = [
           'id'   => 'cou010',
           'name' => 'Đức',
           'slug' => create_slug('Đức'),
           'code' => 'Đ',
        ];
        $array_data[] = [
           'id'   => 'cou011',
           'name' => 'Nhật Bản',
           'slug' => create_slug('Nhật Bản'),
           'code' => 'NB',
        ];
        $array_data = array_reverse($array_data);
        DB::table('country')->insert($array_data);
        DB::table('max_id')->insert(
            [
                'table_name' => 'country',
                'max_id' => 'cou011'
            ],
        );
    }
}
