<?php

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = DB::table('config')->where('key','banner')->get();
    	if(count($result) == 0){
    		DB::table('config')->insert([
    			'key' => 'facebook_access_token',
    			'value' => '',
    		]);
    	}
    }
}
