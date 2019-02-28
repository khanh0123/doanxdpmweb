<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JsonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = DB::table('json_table')->get();
    	if(count($result) == 0){
    		DB::table('json_table')->insert([
    			'key' => 'banner',
    			'value' => ''
    		]);
    	}
    }
}
