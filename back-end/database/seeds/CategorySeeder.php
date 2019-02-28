<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$result = DB::table('category')->get();
    	if(count($result) == 0){
    		DB::table('category')->insert([
    			[
    				'id' => 'cat001',
    				'name' => 'Phim Bộ',
    				'slug' => 'phim-bo'
    			],
    			[
    				'id' => 'cat002',
    				'name' => 'Phim Lẻ',
    				'slug' => 'phim-le'
    			],
                [
                    'id' => 'cat003',
                    'name' => 'Phim Chiếu Rạp',
                    'slug' => 'phim-chieu-rap'
                ],
    		]);
    		
    		DB::table('max_id')->insert([
    			[
    				'table_name' => 'category',
    				'max_id' => 'cat003'
    			],
    		]);
    	}
		
    }
}
