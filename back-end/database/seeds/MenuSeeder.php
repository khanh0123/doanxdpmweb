<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = DB::table('menu')->get();
    	if(count($result) == 0){
    		DB::table('menu')->insert([[
				'name'     => 'Phim lẻ',
				'slug'     => 'phim-le',
				'sub_menu' => 'gen013,gen008,gen006,gen002,gen001',
    		],[

    			'name'     => 'Phim bộ',
				'slug'     => 'phim-bo',
				'sub_menu' => 'cou001,cou002',
    		],[

    			'name'     => 'Phim chiếu rạp',
				'slug'     => 'phim-chieu-rap',
				'sub_menu' => 'cat003',
    		]]);
    	}
    }
}
